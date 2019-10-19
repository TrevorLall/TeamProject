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
	<title>Register</title>
	
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
				<h2>Register</h2>
			</div>
			<form action="" method="POST">
				<label for="username">Username</label> <br/>
				<input type="text" name="username" required /> <br />
				<label for="password">Password</label> <br />
				<input type="password" name="password" required /> <br />
				<button type="submit">Register</button>
				<a href="login.php"><p class="small">Sign In</p></a>
				<br />
			</form>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$hash = password_hash($password, PASSWORD_BCRYPT);
	
	require('mysql_connect.php');
	
	try { 
		$STH = $DBH->prepare("INSERT INTO users (u_name, pass) values (?,?)");
		$STH->bindParam(1, $username);
		$STH->bindParam(2, $hash);
		$STH->execute();
		echo "Account successfully registered!<br />";
	} 
	catch(PDOException $e) { 
		echo "<p style='color:red;'>This username is already registered!</p>"; 
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