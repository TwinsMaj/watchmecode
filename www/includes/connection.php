<?php
	
	# define db constants
	define("DBNAME", "store");
	define("DBUSER", "root");
	define("DBPASS", "romantic");
	define("DBHOST", "localhost");

	try {
		$conn = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);
	} catch(PDOException $e) {
		echo $e->getMessage();
	}