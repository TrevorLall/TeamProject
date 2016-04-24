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

<html>
<head>
	<title>Register</title>
</head>
<body>
	<form action="" method="POST">
		Username: <input type="text" name="username" required /> <br />
		Password: <input type="password" name="password" required /> <br />
		<input type="submit" value="Register" />
		<a href="login.php">Login</a>
	</form>
</body>
</html>