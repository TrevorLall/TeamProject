<?php
session_start();

require('mysql_connect.php');

//Redirect to login.php if admin is not logged in
if ($_SESSION['UID'] != 1){
	$url = "login.php";
	header("Location: $url");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$id = $_POST['id'];	
	$name = $_POST['name'];
	$desc = $_POST['desc'];
	$price = $_POST['price'];
	$qoh = $_POST['qoh'];
	
	try { 
		$STH = $DBH->prepare("UPDATE product SET p_name = ?, p_desc = ?, price = ?, qoh = ? WHERE p_id = ?");
		$STH->bindParam(1, $name);
		$STH->bindParam(2, $desc);
		$STH->bindParam(3, $price);
		$STH->bindParam(4, $qoh);
		$STH->bindParam(5, $id);
		$STH->execute();
		$rows_affected = $STH->rowCount();
		if ($rows_affected == 1)
			echo "<script>alert('Item information updated!!');</script>";
		else
			echo "<script>alert('No modification has been made!!');</script>";
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
	<a href="admin_add.php">Add Item</a>
	<a href="process_logout.php">Logout</a>
	<hr /> <br />
	
<?php
try {
	$STH = $DBH->query("SELECT * FROM product");
	$STH->setFetchMode(PDO::FETCH_ASSOC);
	
	while($row = $STH->fetch()) 
	{ 
?>
	<form action="" method="post" id="<?php echo $row['p_id']; ?>">
		<input type="text" name="name" value="<?php echo $row['p_name']; ?>" /> <br />
		<textarea name="desc" rows="5" cols="40" form="<?php echo $row['p_id']; ?>"><?php echo $row['p_desc']; ?></textarea> <br />
		<input type="text" name="price" value="<?php echo $row['price']; ?>" /> <br />
		<input type="text" name="qoh" value="<?php echo $row['qoh']; ?>" /> <br />
		<input type="hidden" name="id" value="<?php echo $row['p_id']; ?>" />
		<input type="submit" value="Update" />
	</form>
	<hr />
	<br />
<?php
	}
}
catch(PDOException $e) { 
	echo $e->getMessage(); 
}
?>
</body>
</html>