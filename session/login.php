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
			if(@mysql_num_rows($query_run)>0)
			{
				if( $password == mysql_result($query_run,0,'password') )
				{
					ob_start();
					session_start();
					$_SESSION['username'] = $username;
					echo "OK";
				}
				else
					echo "Wrong password";
			}
			else
				echo "This username does not exist";
		}
		else
			echo "Error occured while logging in";
	}
	else
		echo "Error occured while logging in";

	echo '</response>';
?>