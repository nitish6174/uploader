<?php
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username']))
	header('Location: index.php');
?>

<!DOCTYPE html>
<html>

<head>
	<title>File uploader - Dashboard</title>
	<meta charset="utf-8">  
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<link rel="stylesheet" href="css/font-awesome.css">
	<link rel='stylesheet' type='text/css' href='css/bootstrap.css' />
	<link rel='stylesheet' type='text/css' href='css/jquery-ui.css' />
	<link rel='stylesheet' type='text/css' href='css/dashboard.css'/>
</head>

<body>


	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">

			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="">FILE CLOUD</a>
			</div>

			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav" id="menuBar">
					<li class="active"><a onclick="render('upload');">Upload</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">View files<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a onclick="render('uploaded');">Uploaded by me</a></li>
							<li><a onclick="render('shared');">Shared with me</a></li>
						</ul>
					</li>
					<li><a onclick="render('repository');">View Public repository</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right" id="formBar">
					<li><a><?php $username=$_SESSION['username']; echo "$username"; ?></a></li>
					<form class="navbar-form navbar-right">
						<div class="form-group">
							<button type="button" class="btn btn-warning" onclick="logout()" id="logoutButton">Log out</button>
						</div>
					</form>
				</ul>
			</div>

		</div>
	</nav>

	<div class="container-fluid" id="page"></div>

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/dashboard.js"></script>

</body>

</html>
