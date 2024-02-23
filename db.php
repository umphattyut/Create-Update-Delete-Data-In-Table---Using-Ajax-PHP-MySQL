<?php
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PWD', '');
	define('DB_NAME', 'db_test');
	
	@$mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);
	if(mysqli_connect_errno()){
   		echo("Connect failed: %s\n");
   		printf(mysqli_connect_error());
    	exit();
	}
	else{
		return $mysqli;
	}
?>