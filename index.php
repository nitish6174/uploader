<?php
session_start();
if(isset($_SESSION['username']) && !empty($_SESSION['username']))
	header('Location: dashboard.php');
// require 'database/dbconf.php';
?>

<!DOCTYPE html>
<html>

<head>
	<title>File uploader</title>
	<meta charset="utf-8">  
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<link rel="stylesheet" href="css/font-awesome.css">
	<link rel='stylesheet' type='text/css' href='css/bootstrap.css' />
	<link rel='stylesheet' type='text/css' href='css/jquery-ui.css' />
	<link rel='stylesheet' type='text/css' href='css/main.css'/>
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
					<li><a onclick="render('repository');">View Public repository</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right" id="formBar">
					<form class="navbar-form navbar-right">
						<div class="form-group">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal" id="loginButton">Log in</button>
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-default" data-toggle="modal" data-target="#signupModal" id="signupButton">Sign up</button>
						</div>
					</form>
				</ul>
			</div>

		</div>
	</nav>

	<div class="container-fluid" id="page"></div>
	


	<div class="modal fade" id="loginModal" tabindex='-1'>
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<strong>Login to File Cloud</strong>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<form role="form">
						<div class="form-group">
							<input type="email" class="form-control" placeholder="Username" id="loginUsername">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" placeholder="Password" id="loginPassword">
						</div>
					</form>
					<div class="alert alert-danger" role="alert" id="loginAlert">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<span class="sr-only">Error:</span>
						<span class="msg"></span>
					</div>
				</div>

				<div class="modal-footer" style="text-align: center;">
					<button class="btn btn-primary" onclick="return login()">Log in</button>
				</div>

			</div>
		</div>
	</div>

	<div class="modal fade" id="signupModal" tabindex='-1'>
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<strong>Sign up for File Cloud</strong>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<form role="form">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Enter your desired username" id="signupUsername">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" placeholder="Enter a password" id="signupPassword">
						</div> 
						<div class="form-group">
							<input type="password" class="form-control" placeholder="Re-type your Password" id="signupPasswordRe">
						</div>            
					</form>
					<div class="alert alert-danger" role="alert" id="signupAlert">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<span class="sr-only">Error:</span>
						<span class="msg"></span>
					</div>
				</div>

				<div class="modal-footer">
					<button class="btn btn-primary btn-block" onclick="return signup()">Create my account</button>
				</div>

			</div>
		</div>
	</div>

<!-- 	<div class="modal fade" id="signupSuccessModal" tabindex='-1'>
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-body">
					Your account created successfully!<br>
				</div>

				<div class="modal-footer" style="text-align: center;">
					<button class="btn btn-primary" onclick="return loginAfterSignup()">Log in to your account</button>
				</div>

			</div>
		</div>
	</div> -->


	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/main.js"></script>

</body>

</html>
