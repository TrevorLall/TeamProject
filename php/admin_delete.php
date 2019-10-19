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
	
	try { 
		$STH = $DBH->prepare("DELETE FROM product WHERE p_id = ?");
		$STH->bindParam(1, $id);
		$STH->execute();
		$rows_affected = $STH->rowCount();
		if ($rows_affected != 1)
			echo "<script>alert('An system error occurred!!');</script>";
	} 
	catch(PDOException $e) { 
		echo "<p style='color:red;'>An system error occurred!</p>"; 
	}
}
?>

<html>
<head>
	<title>Kazh Anime</title>
	<link href="css/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<a href="admin_add.php">Add Item</a>
	<a href="admin_update.php">Update Item</a>
	<a href="process_logout.php">Logout</a>
	<hr /> <br />
	
<?php 
try {
	$STH = $DBH->query("SELECT * FROM product");
	$STH->setFetchMode(PDO::FETCH_ASSOC);
	
	while($row = $STH->fetch()) 
	{ 
?>
	<form action="" method="post">
		<table border="1" width="400" style="border-collapse: collapse;">
			<tr>
				<th>Name</th>
				<th>Description</th>
				<th>Genre</th>
				<th>Price</th>
				<th>QoH</th>
				<th></th>
			</tr>
			<tr align="center">
				<td><?php echo $row['p_name']; ?></td>
				<td><?php echo $row['p_desc']; ?></td>
				<td><?php echo $row['genre']; ?></td>
				<td>$<?php echo $row['price']; ?></td>
				<td><?php echo $row['qoh']; ?></td>
				<td><input type="submit" value="Delete"></td>
			</tr>
		</table>
		<input type="hidden" name="id" value="<?php echo $row['p_id']; ?>" />	
	</form>
<?php 
	}
}
catch(PDOException $e) { 
	echo $e->getMessage(); 
}
?>
</body>
</html>