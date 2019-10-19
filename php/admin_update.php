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
	$genre = $_POST['genre'];
	
	try { 
		$STH = $DBH->prepare("UPDATE product SET p_name = ?, p_desc = ?, genre = ?, price = ?, qoh = ? WHERE p_id = ?");
		$STH->bindParam(1, $name);
		$STH->bindParam(2, $desc);
		$STH->bindParam(3, $genre);
		$STH->bindParam(4, $price);
		$STH->bindParam(5, $qoh);
		$STH->bindParam(6, $id);
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
	<link href="css/admin.css" rel="stylesheet" type="text/css" />
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
		<table>
			<tr>
				<td>Anime Name:</td>
				<td><input type="text" name="name" value="<?php echo $row['p_name']; ?>" required /></td>
			</tr>
			<tr>
				<td>Anime Description:</td>
				<td><textarea rows="5" cols="40" form="<?php echo $row['p_id']; ?>" name="desc"><?php echo $row['p_desc']; ?></textarea></td>
			</tr>
			<tr>
				<td>Anime Genre</td>
				<td>
					<select name="genre" id="genre">
						<option value="" disabled selected>- Select Genre -</option>
						<option value="action">Action</option>
						<option value="adventure">Adventure</option>
						<option value="comedy">Comedy</option>
						<option value="demons">Demons</option>
						<option value="fantasy">Fantasy</option>
						<option value="game">Game</option>
						<option value="historical">Historical</option>
						<option value="horror">Horror</option>
						<option value="love/romance">Love/Romance</option>
						<option value="magic">Magic</option>
						<option value="music">Music</option>
						<option value="mystery">Mystery</option>
						<option value="psychological">Psychological</option>
						<option value="sci-fi">Sci-Fi</option>
						<option value="sports">Sports</option>
						<option value="supernatural">Supernatural</option>
						<option value="vampire">Vampire</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Anime Price:</td>
				<td>$ <input type="text" name="price" size="4" value="<?php echo $row['price']; ?>" required/></td>
			</tr>
			<tr>
				<td>QoH:</td>
				<td><input type="number" name="qoh" min="1" max="50" value="<?php echo $row['qoh']; ?>" required /></td>
			</tr>
			<tr>
				<td></td>
				<td><button type="submit">Update</button></td>
			</tr>
		</table>
		<input type="hidden" name="id" value="<?php echo $row['p_id']; ?>" />
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