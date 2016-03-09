<?php

session_start();
if(isset($_SESSION['username']) && !empty($_SESSION['username']))
	$user = $_SESSION['username'];
else
	$user = "public";

if(sizeof($_FILES) > 0)
{
	$urllist = json_decode($_POST['jsonurl']);
	$paths = explode("###",rtrim($_POST['paths'],"###"));
	for($i=0;$i<count($paths);$i++)
	{
		tableEntry($urllist[$i],$paths[$i],$user,$_POST['password'],$_POST['sharedwith'],$_POST['expiry']);
	}
	$fileUploader = new FileUploader($_FILES,$paths,"../uploads/$user/");
	zipfiles("../uploads/$user/");
}

class FileUploader
{
	public function __construct($uploads,$paths,$uploadDir)
	{
		// Loop through files sent
		foreach($uploads as $key => $current)
		{
			// Stores full destination path of file on server
			$this->uploadFile=$uploadDir.rtrim($paths[$key],"/.");
			// Stores containing folder path to check if dir later
			$this->folder = substr($this->uploadFile,0,strrpos($this->uploadFile,"/"));
			
			// Check whether the current entity is an actual file or a folder (With a . for a name)
			if(strlen($current['name'])!=1)
			{
				// Upload current file
				if($this->upload($current,$this->uploadFile))
					echo "The file ".$paths[$key]." has been uploaded\n";
				else 
					echo "Error  ";
			}
			else
				echo "DirectoryAndNotFile  ";
		}
	}
	
	private function upload($current,$uploadFile)
	{
		// Checks whether the current file's containing folder exists, if not, it will create it.
		if(!is_dir($this->folder))
		{
			$oldmask = umask(0);
			mkdir($this->folder,0777,true);
			umask($oldmask);
		}
		// if($current['error']==3)
		// {
		// 	alert "Sorry! The file(s) couldn't be uploaded."
		// }
		// else
		// 	echo "DirAlreadyExists  ";
		// Moves current file to upload destination
		if(move_uploaded_file($current['tmp_name'],$uploadFile))
			return true;
		else 
		{
			echo "CantMoveUploadedFile  ";
			return false;
		}
	}
}

function zipfiles($dir)
{
	if(is_dir($dir))
	{
		$list = scandir($dir);
		foreach ($list as $folder)
		{
		    if ($folder === '.' or $folder === '..')
		    	continue;
		    else if ( is_dir($dir.'/'.$folder) )
		    {
		        shell_exec("cd $dir; zip -r \"$folder.zip\" \"$folder/\"; rm -r \"$folder/\"");
		        echo "$folder.zip created\n";
		    }
		    else if( pathinfo($folder, PATHINFO_EXTENSION)!='zip' )
		    // else
		    {
		    	shell_exec("cd $dir; zip \"$folder.zip\" \"$folder\"; rm \"$folder\"");
		        echo "$folder.zip created\n";
		    }
		}
	}
}

function tableEntry($url,$name,$user,$password,$sharedwith,$expiry)
{
	require '../database/dbconf.php';
	$expireText = getExpiry($expiry);
	$expireBool = 0;
	if($expireText!="")
		$expireBool = 1;

	if( @mysql_connect('localhost',$db_username,$db_password) && mysql_select_db($db_name) )
	{
		$query = "INSERT INTO `uploads` (`url`, `name`, `uploadedby`, `password`, `expire`, `expiry`)
								VALUES ('$url', '$name', '$user', '$password', '$expireBool', '$expireText')";
		if(@mysql_query($query))
			echo "URL:$url Name:$name By:$user PWD:$password Expiry:$expireText\n";
		else
			echo "Error in recording upload entry\n";

		$query = "INSERT INTO `{$sharedwith}` (`url`) VALUES ('$url')";
		if(@mysql_query($query))
			echo "URL shared with $sharedwith\n";
		else
			echo "Error in recording shared entry\n";
	}
	else
		echo "Cannot connect to database\n";
}

function getExpiry($expiry)
{
	date_default_timezone_set('Asia/Calcutta');
	$currentDate = strtotime(date("Y-m-d H:i:s"));
	
	if($expiry=="Never")
		$expireText="";
	else if($expiry=="1 min")
	{
		$expireText = date( "Y-m-d H:i:s" , ($currentDate+(60)) );
	}
	else if($expiry=="1 hour")
	{
		$expireText = date( "Y-m-d H:i:s" , ($currentDate+(60*60)) );
	}
	else if($expiry=="1 day")
	{
		$expireText = date( "Y-m-d H:i:s" , ($currentDate+(60*60*24)) );
	}
	return $expireText;
}



?>