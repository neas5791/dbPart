<?php

// Return $pdo database object
function dbConnect() {
	try {
		$pdo = new PDO(
			'mysql:host=localhost;dbname=dbPart',
			'partUser',
			'mypassword');

		$pdo->setAttribute(
		PDO::ATTR_ERRMODE,
		PDO::ERRMODE_EXCEPTION);

		$pdo -> exec('SET NAMES "utf8"');
	}
		catch (PDOException $e) {
		$error =  'Unable to connect to the database server.<br>'.	
					$e->getMessage();
			exit();
	}
	echo 'Database connected';
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

function addData($part_number, $descr, $typeid){
	dbConnect();
	try{
		$sql = 'INSERT INTO tbPart (part_number, descr, typeid) 
				VALUES
					( IF(:part_number = '', CONCAT('P', LAST_INSERT_ID() + 1), :part_number),
					 :descr, 
					 :typeid)';
		$s = $pdo -> prepare($sql);
		$s -> bindValue(':part_number', $part_number);
		$s -> bindValue(':descr', $descr);
		$s -> bindValue(':typeid', $typeid);
	}
	catch (PDOException $e) {
		$error =  'Insert failed with following error:<br>'.	
					$e->getMessage();
			exit();
	}
	echo 'Database update successful';
}
	
if(isset($_POST['add'])) {
	echo 'add';
}
include '../index.html.php';
?>