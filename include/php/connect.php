<?php
	// include_once './php/db_const.php';
	include_once './include/php/log.php';
	
	const DB_HOST = 'mysql:host=localhost;';
	const DB_USER = 'partuser';
	const DB_PASS = 'mypassword';
	const DB_NAME = 'dbname=dbPart';

	try {
		$pdo = new PDO(	DB_HOST.DB_NAME, DB_USER, DB_PASS	);

		$pdo->setAttribute(
		PDO::ATTR_ERRMODE,
		PDO::ERRMODE_EXCEPTION);

		$pdo -> exec('SET NAMES "utf8"');
	}
	catch (PDOException $e) {
		$error =  'Unable to connect to the database server.<br>'
								.$e->getMessage();
		echo $error;
	}
	echo 'database connected';
	append_log('Database connection successful');
?>