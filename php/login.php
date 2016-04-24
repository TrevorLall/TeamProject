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

<html>
<head>
	<title>Log In</title>
</head>

<body>
	<form action="" method="post">
		Username: <input type="text" name="username" required /> <br />
		Password: <input type="password" name="password" required /> <br />
		<input type="submit" value="login" />
		<a href="register.php">Register</a>
	</form>
</body>
</html>