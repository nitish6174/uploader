<?php

	header('Content-Type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';
	echo '<response>';

	require '../database/dbconf.php';
	$username = $_POST['username'];
	$password = $_POST['password'];
	if( @mysql_connect('localhost',$db_username,$db_password) && mysql_select_db($db_name) )
	{
		$query = "SELECT * FROM `users` WHERE `username`='$username';";
		if ($query_run = mysql_query($query))
		{
			if($username=="public")
				echo "This username can't be used";			
			else if(mysql_num_rows($query_run)==0)
			{
				$query = "INSERT INTO `users` (`username`, `password`) VALUES ('$username', '$password')";
				if(mysql_query($query))
				{
					mysql_query("CREATE TABLE `{$username}` ( url VARCHAR(10) PRIMARY KEY )");

					$oldmask = umask(0);
					mkdir("../uploads/".$username."/",0777,true);
					umask($oldmask);

					echo 'OK';
				}
				else
					echo 'Error occurred while signing you up';
			}
			else
				echo "This username is already taken up";
		}
		else
			echo "Error occured while signing you up";
	}
	else
		echo "Error occured while signing you up";

	echo '</response>';
?>