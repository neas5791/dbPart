<?php
	
	function upload($filename) {
	
	$log = '../log/error.log';

	// print_r($_FILES);
	// exit();
	echo '<br>FILE NAME ->'.$_FILES['type']."<br>";

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

	$filename = '/img/'.time().$filename.$_SERVER['REMOTE_ADDR'].$ext;
	
	if (!is_uploaded_file($_FILES['upload']['tmp_name']) or 
		!copy($_FILES['upload']['tmp_name'], $filename)) {
		$error = PHP_EOL.time()."\t".$_SERVER['REMOTE_ADDR']."-\tCould not save file as $filename!";
		file_put_contents($log, $error, FILE_APPEND);
	}
	return $filename;
}
?>