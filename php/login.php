<?php
session_start();

//Redirect user if already logged in
if (isset($_SESSION['UID'])){
	
	//Redirect to index.php if it's normal user
	if ($_SESSION['UID'] != 1){
		$url = "index.php";
		header("Location: $url");	
	}
	//Redirect to admin.php if it's admin
	else {
		$url = "admin_add.php";
		header("Location: $url");	
	}
}
?>

<html>
<head>
	<title>Log In</title>
	
	<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/animate.css">
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="css/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>

<body>
	<div class="container">
		<div class="top">
			<h1 id="title" class="hidden"><span id="logo">Kazh <span>Anime</span></span></h1>
		</div>
		
		<div class="login-box animated fadeInUp">
			<div class="box-header">
				<h2>Log In</h2>
			</div>
			<form action="" method="POST">
				<label for="username">Username</label> <br/>
				<input type="text" name="username" required /> <br />
				<label for="password">Password</label> <br />
				<input type="password" name="password" required /> <br />
				<button type="submit">Sign In</button>
				<a href="register.php"><p class="small">Register</p></a>
				<br />
			</form>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	require('mysql_connect.php');
	
	try {
		$STH = $DBH->prepare("SELECT pass, u_id FROM users WHERE u_name = ?");
		$STH->bindParam(1, $username);
		$STH->execute();
		$STH->setFetchMode(PDO::FETCH_ASSOC);
	
		if ($row = $STH->fetch()) 
		{ 
			//Store user id in session and redirect to index.php
			if (password_verify($password, $row['pass'])){
				$_SESSION['UID'] = $row['u_id'];
				
				//If it's user privilege, reditect to index.php
				if ($row['u_id'] != 1){
					$url = "index.php";
					header("Location: $url");
				}
				//If it's admin privilege, redirect to admin.php
				else{
					$url = "admin_add.php";
					header("Location: $url");
				}
			}
			else
				echo "<p style='color:red;'>Wrong user name or password!!</p>";
		}
		else
			echo "<p style='color:red;'>Wrong user name or password!!</p>";
	} 
	catch(PDOException $e) { 
		echo $e->getMessage(); 
	}
}
?>
		</div>
	</div>
</body>

<script>
	$(document).ready(function () {
    	$('#logo').addClass('animated fadeInDown');
    	$("input:text:visible:first").focus();
	});
	$('#username').focus(function() {
		$('label[for="username"]').addClass('selected');
	});
	$('#username').blur(function() {
		$('label[for="username"]').removeClass('selected');
	});
	$('#password').focus(function() {
		$('label[for="password"]').addClass('selected');
	});
	$('#password').blur(function() {
		$('label[for="password"]').removeClass('selected');
	});
</script>
</html>