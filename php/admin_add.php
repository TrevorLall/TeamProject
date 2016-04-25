<?php
session_start();

//Redirect to login.php if admin is not logged in
if ($_SESSION['UID'] != 1){
	$url = "login.php";
	header("Location: $url");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$name = $_POST['name'];
	$desc = $_POST['desc'];
	$price = $_POST['price'];
	$qoh = $_POST['qoh'];
	
	require('mysql_connect.php');
	
	try { 
		$STH = $DBH->prepare("INSERT INTO product (p_name, p_desc, price, qoh) values (?,?,?,?)");
		$STH->bindParam(1, $name);
		$STH->bindParam(2, $desc);
		$STH->bindParam(3, $price);
		$STH->bindParam(4, $qoh);
		$STH->execute();
		echo "<script>alert('Item added!!');</script>";
	} 
	catch(PDOException $e) { 
		echo "<p style='color:red;'>An system error occurred!</p>"; 
	}
}
?>

<html>
<head>
	<title>Kazh Anime</title>
</head>

<body>
	<a href="admin_delete.php">Delete Item</a>
	<a href="admin_update.php">Update Item</a>
	<a href="process_logout.php">Logout</a>
	<hr /> <br />
	
	<form action="" method="post" id="add">
		<label>New Item: </label>
		<input type="text" name="name" required />
		<br /> <br />
		<textarea rows="5" cols="40" form="add" name="desc" placeholder="Item Description"></textarea>
		<br />
		<label>Item price: $</label>
		<input type="text" name="price" required />
		<br />
		<label>QoH: </label>
		<input type="number" name="qoh" required />
		<br />
		<input type="submit" value="Add" />
	</form>
</body>
</html>