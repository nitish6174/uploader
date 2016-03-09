<?php

	header('Content-Type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';
	echo '<response>';

	require '../database/dbconf.php';
	$url = $_POST['url'];
	if( @mysql_connect('localhost',$db_username,$db_password) && mysql_select_db($db_name) )
	{
		$query_run = mysql_query("SELECT * FROM `uploads` WHERE `url`='$url';");
		$user = mysql_result($query_run_user,0,'uploadedby');
		$name = mysql_result($query_run_user,0,'name');
		$dir = "../uploads/$user/";
		echo "$name";
		shell_exec("cd $dir; rm \"$name.zip\"");

		mysql_query("DELETE FROM `uploads` WHERE `url`='$url';");
		$query_run = mysql_query("SELECT * FROM `users` WHERE 1;");
		for($i=0 ; $i<mysql_num_rows($query_run) ; $i++)
		{
			$tablename = mysql_result($query_run,$i,'username');
			mysql_query("DELETE FROM `{$tablename}` WHERE `url`='$url';");
		}
	}
	else
		echo "Error occured while deleting";

	echo '</response>';
?>