<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$new_prod = false;

// 	$log = './log/log';
// 	$content = file_get_contents($log);
// 	echo $content;
// 	$new_content .= PHP_EOL.time()."\t".$_SERVER['REMOTE_ADDR']."-\ttest write to log file";
//  file_put_contents($log, $new_content, FILE_APPEND);

// Return $pdo database object
function dbConnect() {
	try {
		$pdo = new PDO(
			'mysql:host=localhost;dbname=dbPart',
			'partuser',
			'mypassword');

		$pdo->setAttribute(
		PDO::ATTR_ERRMODE,
		PDO::ERRMODE_EXCEPTION);

		$pdo -> exec('SET NAMES "utf8"');
	}
	catch (PDOException $e) {
		$error =  'Unable to connect to the database server.<br>'.	
					$e->getMessage();
		echo $error;
		// exit();
	}
	// echo 'Database connected';
	return $pdo;
}

// function getData($id){
// 	dbConnect();

// 	try {
// 		$sql = 'SELECT * FROM tbPart WHERE id = :id';
// 		$s = $pdo -> prepare($sql);
// 		$s -> bindValue(':id', $id, PDO::PARAM_INT);
// 		$result = $s -> execute();
// 	}
// 	catch (PDOException $e) {
// 		$error =  'Query failed with following error:<br>'.	
// 					$e->getMessage();
// 			exit();
// 	}
// }

function addData($supplierid, $sup_part_number, $prefix,  $descr, $typeid){
	$pdo = dbConnect();
	echo '<br><span>Hit function -> '.$sup_part_number.' - '.$descr.' - '.$typeid.'</span><br>';
	// include './php/upload.php';

	if (preg_match('/^image\/p?jpeg$/i', $_FILES['upload']['type'])) {
		$ext = '.jpg';
	}
	else if (preg_match('/^image\/gif$/i', $_FILES['upload']['type'])) {
		$ext = '.gif';
	}
	else if (preg_match('/^image\/(x-)?png$/i', $_FILES['upload']['type'])) {
		$ext = '.png';
	}
	else {
		$ext = '.unknown';
	}

	$filename = './img/'.time().$ext;
	echo $filename;
	// exit();

	if (!is_uploaded_file($_FILES['upload']['tmp_name']) or 
		!copy($_FILES['upload']['tmp_name'], $filename)) {
		$error = PHP_EOL.time()."\t".$_SERVER['REMOTE_ADDR']."-\tCould not save file as $filename!";
		file_put_contents($log, $error, FILE_APPEND);
	}




	try {
		
		// get next transcrete part number
		$sql = 'SELECT MAX(id) as value FROM tbPart';

		foreach( $pdo -> query($sql) as $row){
			$part_id = $row['value'] + 1;
			$part_number = 'P'.$part_id;
		}
	
		$sql = 'INSERT INTO tbPart (prefix, descr, typeid) VALUES ( :prefix, :descr, :typeid )';	
		$s = $pdo -> prepare($sql);
		$s -> bindValue(':prefix', $prefix, PDO::PARAM_STR);
		$s -> bindValue(':descr', $descr, PDO::PARAM_STR);
		$s -> bindValue(':typeid', $typeid, PDO::PARAM_INT);
		$s -> execute();
		echo 'Part added to database<br>';

		// echo $supplierid.' - '.$part_number_id.' - '.$sup_part_number;
		$sql = 'INSERT INTO tbSupplierPart (supplierid, partid, sup_part_number, img) VALUES
							( :supplierid, :part_id, :sup_part_number, :img)';
		$s = $pdo -> prepare($sql);
		$s -> bindValue(':supplierid', $supplierid, PDO::PARAM_INT);
		$s -> bindValue(':part_id', $part_id, PDO::PARAM_INT);
		$s -> bindValue(':sup_part_number', $sup_part_number, PDO::PARAM_STR);
		$s -> bindValue(':img', $filename, PDO::PARAM_STR);
		$s -> execute();
		echo 'Supplier Part added to database<br>';		

		// if ()
		// // 	$s -> bindValue(':supplierid', 1, PDO::PARAM_INT);
		// // 	$s -> bindValue(':part_id', $part_id, PDO::PARAM_INT);
		// // 	$s -> bindValue(':sup_part_number', $part_number, PDO::PARAM_STR);
		// // 	$s -> execute();
		// }

	}
	catch (PDOException $e) {
		$error =  'Insert failed with following error:<br>'.	
					$e->getMessage();
		echo $error;
	}
	echo 'Database update successful';

}

// function testData($supplierid, $sup_part_number, $prefix, $descr, $typeid){
// 	$pdo = dbConnect();

// }
	
	if(isset($_POST['add'])) {

		addData(
			$_POST['supplierid'], 
			$_POST['sup_part_number'], 
			$_POST['prefix'], 
			$_POST['descr'], 
			$_POST['typeid'] );
	}

	try {
		$pdo = dbConnect();
		$sql = 'SELECT id, type FROM tbType';
		$s = $pdo->prepare($sql);
		$s -> execute();
		$types = $s -> fetchAll();

		$sql = 'SELECT id, company FROM tbSupplier ORDER BY company';
		$s = $pdo->prepare($sql);
		$s -> execute();
		$suppliers = $s -> fetchAll();

		$sql = 'SELECT DISTINCT prefix FROM tbPart';
		$s = $pdo->prepare($sql);
		$s -> execute();
		$prefixes = $s -> fetchAll();
	}
	catch (PDOException $e) {
		$error =  'Error getting Type list:<br>'.	
					$e->getMessage();
		echo $error;
	}

	include 'index.html.php';
?>

<!-- 	// ****************  Pagination ********************************//
	$rec_limit = 25; // number records to display on page
	try {
		// number of records in table
		$sql = 'SELECT COUNT(partnumber) FROM tbPart WHERE active';
		
		$s = $pdo ->prepare($sql);
		$s -> execute();
		$recval = $s -> fetch();
	}
	catch (PDOException $e) {
		$error = 'Error counting part results.<br>' . $e -> getMessage();
		include $_SERVER['DOCUMENT_ROOT'] .
			'/includes/error.html.php';
		exit();
	}
	$rec_count = $recval[0];

	// check that the table contains records
	if($rec_count == 0) { 
		$error = 'No valid data in table.<br>'.$sql;
		include $_SERVER['DOCUMENT_ROOT'] .
			'/includes/error.html.php';
		exit();	
	}

	if( isset($_GET['page'] ) ) {
		
		if ( $_GET['page'] < ($rec_count / $rec_limit)-1 )
			$page = $_GET['page'] + 1;
		else
			$page = $_GET['page'];

		$offset = $rec_limit * $page ;
  }
	else {
    $page = 0;
    $offset = 0;
  }

  $left_rec = $rec_count - ($page * $rec_limit); -->