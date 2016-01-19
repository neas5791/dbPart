<?php

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

function getData($id){
	dbConnect();

	try {
		$sql = 'SELECT * FROM tbPart WHERE id = :id';
		$s = $pdo -> prepare($sql);
		$s -> bindValue(':id', $id, PDO::PARAM_INT);
		$result = $s -> execute();
	}
	catch (PDOException $e) {
		$error =  'Query failed with following error:<br>'.	
					$e->getMessage();
			exit();
	}
}

function addData($supplierid, $sup_part_number, $prefix,  $descr, $typeid){
	$pdo = dbConnect();
	echo '<span>Hit function -> '.$part_number.' - '.$descr.' - '.$typeid.'</span><br>';

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
		$sql = 'INSERT INTO tbSupplierPart (supplierid, partid, sup_part_number) VALUES
							( :supplierid, :part_id, :sup_part_number)';
		$s = $pdo -> prepare($sql);
		$s -> bindValue(':supplierid', $supplierid, PDO::PARAM_INT);
		$s -> bindValue(':part_id', $part_id, PDO::PARAM_INT);
		$s -> bindValue(':sup_part_number', $sup_part_number, PDO::PARAM_STR);
		$s -> execute();
		echo 'Supplier Part added to database<br>';		

		$s -> bindValue(':supplierid', 1, PDO::PARAM_INT);
		$s -> bindValue(':part_id', $part_id, PDO::PARAM_INT);
		$s -> bindValue(':sup_part_number', $part_number, PDO::PARAM_STR);
		$s -> execute();
	}
	catch (PDOException $e) {
		$error =  'Insert failed with following error:<br>'.	
					$e->getMessage();
		echo $error;
	}
	echo 'Database update successful';

}

function testData($supplierid, $sup_part_number, $prefix, $descr, $typeid){
	$pdo = dbConnect();

}
	
	if(isset($_POST['add'])) {
		echo 'add';
		addData($_POST['supplierid'], $_POST['sup_part_number'], $_POST['prefix'], $_POST['descr'], $_POST['typeid'] );
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