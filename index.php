<?php

	const DB_HOST = 'mysql:host=localhost;';
	const DB_USER = 'partuser';
	const DB_PASS = 'mypassword';
	const DB_NAME = 'dbname=dbPart';

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$new_prod = false;

	// echo 'got this far!';
	// exit();

function append_log($message) {
	$log = './log/log.txt';
	$content = file_get_contents($log);
	echo $content;
	$content .= PHP_EOL.time()."\t".$_SERVER['REMOTE_ADDR']." -\t".$message;
 	file_put_contents($log, $content, FILE_APPEND);
}


// Return $pdo database object
function dbConnect() {
	try {
		$pdo = new PDO(	DB_HOST.DB_NAME, DB_USER, DB_PASS	);

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

function addPart($pdo, $descr, $typeid){
	// $pdo = dbConnect();
	// echo '<br><span>Hit function addPart().</span><br>';

	try {
		$sql = 'INSERT INTO tbPart (descr, typeid) VALUES ( :descr, :typeid )';	
		$s = $pdo -> prepare($sql);
		$s -> bindValue(':descr', $descr, PDO::PARAM_STR);
		$s -> bindValue(':typeid', $typeid, PDO::PARAM_INT);
		$s -> execute();
		$last_id = $pdo -> lastInsertId();

		append_log('#'.$last_id.' added to part number table');
	} 
	catch (PDOException $e) {
		$error =  'Insert part failed with following error:<br>'.	
		$e->getMessage();
		echo $error;
	}

	return $last_id;
}

function addSupplierPart($pdo, $supplierid, $partid, $sup_part_number, $filename) {
	// echo '<br><span>Hit function addSupplierPart().</span><br>';

	try {
				$sql = 'INSERT INTO tbSupplierPart (supplierid, partid, sup_part_number, img) VALUES
							( :supplierid, :part_id, :sup_part_number, :img)';
		$s = $pdo -> prepare($sql);
		$s -> bindValue(':supplierid', $supplierid, PDO::PARAM_INT);
		$s -> bindValue(':part_id', $partid, PDO::PARAM_INT);
		$s -> bindValue(':sup_part_number', $sup_part_number, PDO::PARAM_STR);
		$s -> bindValue(':img', $filename, PDO::PARAM_STR);
		$s -> execute();
		// $last_id = $pdo -> lastInsertId();
		// append_log('#'.$last_id.' added to supplier part table');

	} 
	catch (PDOException $e) {
		$error =  'Insert supplier part failed with following error:<br>'.	
		$e->getMessage();
		echo $error;
		throw new PDOException("Error Processing Request", 1);
	}
}

function addDrawing($pdo, $partid, $drawing_number, $filename) {
	try {
				$sql = 'INSERT INTO tbDrawing (partid, drawing_number, pdf) VALUES
							( :part_id, :drawing_number, :pdf)';
		$s = $pdo -> prepare($sql);
		$s -> bindValue(':part_id', $partid, PDO::PARAM_INT);
		$s -> bindValue(':drawing_number', $drawing_number, PDO::PARAM_STR);
		$s -> bindValue(':pdf', $filename, PDO::PARAM_STR);
		$s -> execute();
		// $last_id = $pdo->$lastInsertId();
		// append_log('#'.$last_id.' added to drawing table database');
	} 
	catch (PDOException $e) {
		$error =  'Insert supplier part failed with following error:<br>'.	
		$e->getMessage();
		echo $error;
		throw new PDOException("Error Processing Request", 1);
	}	
}

// function addData($supplierid, $sup_part_number, $descr, $typeid){
// 	$pdo = dbConnect();
	
// 	if (preg_match('/^image\/p?jpeg$/i', $_FILES['upload']['type'])) {
// 		$ext = '.jpg';
// 	}
// 	else if (preg_match('/^image\/gif$/i', $_FILES['upload']['type'])) {
// 		$ext = '.gif';
// 	}
// 	else if (preg_match('/^image\/(x-)?png$/i', $_FILES['upload']['type'])) {
// 		$ext = '.png';
// 	}
// 	else {
// 		$ext = '.unknown';
// 	}

// 	try {

// 		$partid = addPart($pdo, $descr, $typeid);
// 		$filename = './img/'.$partid.$ext;
// 		addSupplierPart($pdo, $supplierid, $partid, $sup_part_number, $filename );
// 	}
// 	catch (PDOException $e) {
// 		$error =  'Insert failed with following error:<br>'.	
// 					$e->getMessage();
// 		echo $error;
// 	}


// 	// echo $filename;
	
// 	if (!is_uploaded_file($_FILES['upload']['tmp_name']) or 
// 		!copy($_FILES['upload']['tmp_name'], $filename)) {
// 		$error = PHP_EOL.time()."\t".$_SERVER['REMOTE_ADDR']."-\tCould not save file as $filename!";
// 		file_put_contents($log, $error, FILE_APPEND);
// 	}

// 	echo 'Database update successful';
// }


	if(isset($_POST['add'])) {
	
		$pdo = dbConnect();
		
		if (preg_match('/^image\/p?jpeg$/i', $_FILES['upload']['type'])) {
			$ext = '.jpg';
		}
		else if (preg_match('/^image\/gif$/i', $_FILES['upload']['type'])) {
			$ext = '.gif';
		}
		else if (preg_match('/^image\/(x-)?png$/i', $_FILES['upload']['type'])) {
			$ext = '.png';
		}
		else if (preg_match('/^application\/pdf$/i', $_FILES['upload']['type'])) {
			$ext = '.pdf';
		}
		else {
			$ext = '.unknown';
		}

		// add part details
		$partid = addPart($pdo, $_POST['descr'], $_POST['typeid'] );
		$filename = './img/'.$partid.$ext;

		// add drawing details
		if (isset($_POST['drawing_number'])){
			addDrawing($pdo, $partid, $_POST['drawing_number'], $filename);
		}

		// add supplier part details
		if (isset($_POST['sup_part_number'])){
			addSupplierPart($pdo,$_POST['supplierid'], $partid, $_POST['sup_part_number'], $filename );
		}

		// upload image of part
		if (!is_uploaded_file($_FILES['upload']['tmp_name']) or 
					!copy($_FILES['upload']['tmp_name'], $filename)) {
			
						$error = PHP_EOL.time()."\t".$_SERVER['REMOTE_ADDR']."-\tCould not save file as $filename!";
						file_put_contents($log, $error, FILE_APPEND);
		}

		echo 'Database update successful';
	}


// LOAD PAGE TABLE DATA
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

		$sql = 'SELECT
					tbPart.id AS "PID",  
					tbPart.descr AS "DESCRIPTION", 
					IFNULL(tbDrawing.drawing_number,"") AS "DWG_NUMBER",
					tbSupplierPart.sup_part_number AS "PART_NUMBER",
					tbSupplier.company as "SUPPLIER"
				FROM tbPart
				LEFT OUTER JOIN tbDrawing ON tbPart.id = tbDrawing.partid
				LEFT OUTER JOIN tbSupplierPart ON tbPart.id = tbSupplierPart.partid
				INNER JOIN tbSupplier ON tbSupplierPart.supplierid = tbSupplier.id
				ORDER BY PID';
		$s = $pdo->prepare($sql);
		$s -> execute();
		$results = $s -> fetchAll();
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

<!--// function getData($id){
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


// function testData($supplierid, $sup_part_number, $prefix, $descr, $typeid){
// 	$pdo = dbConnect();
// }

		// $sql = 'SELECT DISTINCT prefix FROM tbPart';
		// $s = $pdo->prepare($sql);
		// $s -> execute();
		// $prefixes = $s -> fetchAll();





// } -->