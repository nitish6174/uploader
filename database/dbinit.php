<?php

require 'dbconf.php';

if( $conn = mysql_connect('localhost',$db_username,$db_password) )
{
	$query="CREATE DATABASE IF NOT EXISTS ".$db_name;
	mysql_query($query);

	if( mysql_select_db($db_name) )
	{
		$query = "SELECT * FROM `users` WHERE 1;";		
		if(!mysql_query($query))
		{
			$query = "CREATE TABLE users (
						username VARCHAR(15) PRIMARY KEY,
						password VARCHAR(15)
						)";
			echo $query.'<br>';
			mysql_query($query);

			$query = "CREATE TABLE uploads (
						url VARCHAR(10) PRIMARY KEY,
						name VARCHAR(30),
						fullpath VARCHAR(200),
						uploadedby VARCHAR(30),
						password VARCHAR(15),
						expire BOOLEAN,
						expiry DATETIME
						)";
			echo $query.'<br>';
			mysql_query($query);
			
			$query = "CREATE TABLE public (
						url VARCHAR(10) PRIMARY KEY
						)";
			echo $query.'<br>';
			mysql_query($query);

			$oldmask = umask(0);
			mkdir("../uploads/public/",0777,true);
			umask($oldmask);
		}
	}
	else
		echo "Can't connect to the database";
}
else
	echo "Can't connect to mySQL";

?>