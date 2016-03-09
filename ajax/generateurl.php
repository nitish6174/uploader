<?php

	require '../database/dbconf.php';
	if( @mysql_connect('localhost',$db_username,$db_password) && mysql_select_db($db_name) )
	{
		$count = $_GET['count'];
		$urllist = array();
		for($i=0;$i<$count;$i++)
		{
			$newurl = "";
			$result = 0;
			while($result==0)
			{
				$allowed = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
				$newurl = substr(str_shuffle($allowed),0,5);
				$query = "SELECT `url` FROM `uploads` WHERE `url`='$newurl';";
				if ($query_run = mysql_query($query)) 
				{
					if(@mysql_num_rows($query_run)>0)
						$result = 0;
					else
					{						
						$result = 1;
						for($j=0;$j<count($urllist);$j++)
							if($newurl==$urllist[$j])
								$result = 0;
					}
				}
				else
					echo "";	
			}
			array_push($urllist,$newurl);
			echo $urllist[$i]."#";			
		}
	}
	else
		echo "";
	
?>