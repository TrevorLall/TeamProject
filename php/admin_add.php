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
	$genre = $_POST['genre'];
	$price = $_POST['price'];
	$qoh = $_POST['qoh'];
	$imgfp = fopen($_FILES['userfile']['tmp_name'], 'rb');
	
	require('mysql_connect.php');
	
	try { 
		$STH = $DBH->prepare("INSERT INTO product (p_name, p_desc, genre, price, qoh, image) values (?,?,?,?,?,?)");
		$STH->bindParam(1, $name);
		$STH->bindParam(2, $desc);
		$STH->bindParam(3, $genre);
		$STH->bindParam(4, $price);
		$STH->bindParam(5, $qoh);
		$STH->bindParam(6, $imgfp, PDO::PARAM_LOB);
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
	<link href="css/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="links">
		<a href="admin_delete.php">Delete Item</a>
		<a href="admin_update.php">Update Item</a>
		<a href="process_logout.php">Logout</a>
	</div>
	
	<form enctype="multipart/form-data" action="" method="post" id="add"> 
		<input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
        <div id="updateMain">
            <table>
                <tr>
                    <td>Anime Name:</td>
                    <td><input type="text" name="name" required /></td>
                </tr>
                <tr>
                    <td>Anime Description:</td>
                    <td><textarea rows="5" cols="40" form="add" name="desc" placeholder="Item Description"></textarea></td>
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
                    <td>$ <input type="text" name="price" size="4" required/></td>
                </tr>
                <tr>
                    <td>QoH:</td>
                    <td><input type="number" name="qoh" min="1" max="50" required /></td>
                </tr>
				<tr>
					<td>Upload Image:</td>
					<td><div><input name="userfile" type="file" required /></div></td>
				</tr>
                <tr>
                    <td></td>
                    <td><button type="submit">Add</button></td>
                </tr>
            </table>
        </div>
	</form>
</body>
</html>