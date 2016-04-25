<?php
session_start();

//Redirect to admin.php if it's admin
if ($_SESSION['UID'] == 1){
	$url = "admin_add.php";
	header("Location: $url");	
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	//Redirect user if not logged in
	if (!isset($_SESSION['UID'])){
		$url = "login.php";
		header("Location: $url");	
	}
}
?>

<html>
<head>
	<title>Kazh Anime</title>
</head>

<body>
	<p>Welcome to Kazh Anime</p>
</body>
</html>