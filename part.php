<?php
	include './include/php/connect.php';
	include_once './include/php/log.php';
	
	echo '<script type="text/javascript">console.log("'.$_POST['action'].';"</script> -->';

	// Insert new part
	if ( !isset($_POST['action']) ) {
		try {
			$sql = 'INSERT INTO tbPart (descr, image) VALUES ( :descr, :image )';	
			$s = $pdo -> prepare($sql);
			$s -> bindValue(':descr', $_POST['descr'], PDO::PARAM_STR);
			// $s -> bindValue(':typeid', $typeid, PDO::PARAM_INT);
			// $filename = './img/'.($pdo -> lastInsertId()).'.jpg';	
			$s -> bindValue(':image', $_POST['image'], PDO::PARAM_STR);
			$s -> execute();
			$last_id = $pdo -> lastInsertId();
	
			append_log('#'.$last_id.' added to part number table');
		} 
		catch (PDOException $e) {
			$error = 'Insert part failed with following error:<br>'
						.$e->getMessage();
			echo $error;
		}
	}
?>