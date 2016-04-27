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
<title>KaZh</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="js/boxOver.js"></script>
</head>

<body>
    <!-- main container -->
    <div id="main_container">
        <div id="header">
            <!-- Logo -->
            <div id="logo"> 
            <a href="#"><img src="images/banner.jpg" alt="" border="0" width="940" height="140" /></a> 
            </div>
        </div>
    
    <!-- Main -->
    <div id="main_content">
        <div id="menu_tab">
            <div class="left_menu_corner"></div>
            <ul class="menu">
                <li><a href="index.html" class="nav1">Home</a></li>
                <li class="divider"></li>
                <li><a href="admin_add.php" class="nav2">Add Item</a></li>
                <li class="divider"></li>
                  <!-- CHECK THIS: my account -->
                <li><a href="admin_update.html" class="nav3">Update Item</a></li>
                <li class="divider"></li>
                <li><a href="admin_delete.html" class="nav4">Delete Item</a></li>
                <li class="divider"></li>
            </ul>
        <div class="right_menu_corner"></div>
      </div>
      <!-- end of menu tab -->
    
      <?php 
try {
	$STH = $DBH->query("SELECT * FROM product");
	$STH->setFetchMode(PDO::FETCH_ASSOC);
	
	while($row = $STH->fetch()) 
	{ 
?>
      <!-- center content -->
      <div class="center_content">
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
      </div>
        <!-- end of center content -->
    </div>
    <!-- end of main content -->  
</div>
<!-- end of main_container -->
</body>
</html>