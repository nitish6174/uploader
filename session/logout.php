<?php
	ob_start();
	session_start();
	session_destroy();
	// echo "logged out";
	header('Location: ..');
?>