<?php
session_start();

//Redirect to admin.php if it's admin
if (isset($_SESSION['UID'])){
	
	if ($_SESSION['UID'] == 1){
		$url = "admin_add.php";
		header("Location: $url");	
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	//Redirect user if not logged in
	if (!isset($_SESSION['UID'])){
		$url = "login.php";
		header("Location: $url");	
	}
	
	$id = $_SESSION['UID'];
	
	try {
		require('mysql_connect.php');
		$STH = $DBH->prepare("DELETE FROM cart WHERE u_id = ?");
		$STH->bindParam(1, $id);
		$STH->execute();
		$rows_affected = $STH->rowCount();
		if ($rows_affected == 1)
			echo "<script>alert('Your order has been processed!');</script>";
	} 
	catch(PDOException $e) { 
		echo "<p style='color:red;'>An system error occurred!</p>"; 
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>KaZh</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="css/index/style.css" />
<link rel="stylesheet" href="css/checkout.css">
</head>
    
<body>
    <!-- main container -->
    <div id="main_container">
        <div id="header">
            <!-- Logo -->
            <div id="logo"> 
            <a href=""><img src="images/banner.jpg" alt="" border="0" width="940" height="140" /></a> 
            </div>
        </div>
    
    <!-- Main -->
    <div id="main_content">
        <div id="menu_tab">
            <div class="left_menu_corner"></div>
            <ul class="menu">
                <li><a href="index.php" class="nav1">Home</a></li>
                <li class="divider"></li>
                <li><a href="" class="nav2">About Us</a></li>
                <li class="divider"></li>
                <li><a href="" class="nav3">My Account</a></li>
                <li class="divider"></li>
                <li><a href="" class="nav5">Shipping</a></li>
                <li class="divider"></li>
                <li><a href="contact.php" class="nav5">Contact Us</a></li>
                <li class="divider"></li>
                <li class="currencies">Currencies
                  <select>
                    <option>Canadian Dollar</option>
                    <option>US Dollar</option>
                    <option>Euro</option>
                  </select>
                </li>
				<?php
				if (isset($_SESSION['UID'])){
					
					require('mysql_connect.php');

					$STH = $DBH->query("SELECT u_name FROM users WHERE u_id = ".$_SESSION['UID']);
					$STH->setFetchMode(PDO::FETCH_ASSOC);
					$row = $STH->fetch()
				?>
				<li><a href="" style="pointer-events: none; cursor: default;" class="nav4">Welcome <?php echo $row['u_name']; ?></a></li>
				<li class="divider"></li>
				<li><a href="process_logout.php">Sign Out</a></li>
				<li class="divider"></li>
				<?php
				}
				else{
				?>
				<li><a href="login.php">Sign In</a></li>
				<li class="divider"></li>
				<?php
				}
				?>
            </ul>
        <div class="right_menu_corner"></div>
        </div>
        <!-- end of menu tab -->
        
        <!-- left content -->
        <div class="left_content">
            <div class="title_box">Genre</div>
                <ul class="left_menu">
                    <li class="odd"><a href="#">Action</a></li>
                    <li class="even"><a href="#">Adventure</a></li>
                    <li class="odd"><a href="#">Comedy</a></li>
                    <li class="even"><a href="#">Demons</a></li>
                    <li class="odd"><a href="#">Fantasy</a></li>
                    <li class="even"><a href="#">Game</a></li>
                    <li class="odd"><a href="#">Historical</a></li>
                    <li class="even"><a href="#">Horror</a></li>
                    <li class="odd"><a href="#">Love/Romance</a></li>
                    <li class="even"><a href="#">Magic</a></li>
                    <li class="odd"><a href="#">Music</a></li>
                    <li class="even"><a href="#">Mystery</a></li>
                    <li class="odd"><a href="#">Psychological</a></li>
                    <li class="even"><a href="#">Sci-Fi</a></li>
                    <li class="odd"><a href="#">Sports</a></li>
                    <li class="even"><a href="#">Supernatural</a></li>
                    <li class="odd"><a href="#">Vampire</a></li>
                </ul>
                <div class="title_box">Special Products</div>
                <div class="border_box">
                    <div class="product_title"><a href="details.html">Card Captors Volume 4</a></div>
                    <div class="product_img"><a href="details.html"><img src="images/cardcaptors1.jpg" width="190" height="200" alt="" border="0" /></a></div>
                    <div class="prod_price"><span class="reduce">30$</span> <span class="price">15$</span></div>
                </div>
        </div>
        <!-- end of left content -->
    
        <!-- center content -->
        <div class="center_content">
			<div class="form-container">
			<form action="" method="post">
			  <div class="personal-information">
				<h1>Payment Information</h1>
			  </div> <!-- end of personal-information -->
			  <input id="input-field" type="text" name="streetaddress" required="required" autocomplete="on" maxlength="45" placeholder="Streed Address"/>

			  <input id="column-left" type="text" name="city" required="required" autocomplete="on" maxlength="20" placeholder="City"/>

			  <input id="column-right" type="text" name="zipcode" required="required" autocomplete="on" maxlength="5" placeholder="ZIP code"/>
			  
			  <input id="input-field" type="email" name="email" required="required" autocomplete="on" maxlength="40" placeholder="Email"/>
			
			<div class="card-wrapper"></div>
			  <input id="column-left" type="text" name="first-name" placeholder="First Name"/>
			  
			  <input id="column-right" type="text" name="last-name" placeholder="Surname"/>
			  
			  <input id="input-field" type="text" name="number" placeholder="Card Number"/>
			 
			  <input id="column-left" type="text" name="expiry" placeholder="MM / YY"/>
				
			  <input id="column-right" type="text" name="cvc" placeholder="CCV"/>
			
			  <input id="input-button" type="submit" value="Submit"/>
			</form>
		  </div> <!-- end of form-container -->
        </div>
        <!-- end of center content -->
        
        <!-- right content -->
        <div class="right_content">
		<br /><br />
		<?php
		if (isset($_SESSION['UID'])){
			$u_id = $_SESSION['UID'];
			require('mysql_connect.php');
			$STH = $DBH->query("SELECT count(*) as item, sum(price) as total FROM cart inner join product using (p_id) WHERE cart.u_id = ".$u_id);
			$STH->setFetchMode(PDO::FETCH_ASSOC);
			$row = $STH->fetch();
		?>
		<div class="shopping_cart">
			<div class="cart_title" style="font-size:20px">Shopping cart</div><br />
			<div class="cart_details" style="font-size:15px"> <?php echo $row['item']; ?> items <br />
				<span class="border_cart"></span> Total: <span class="price"><?php echo $row['total']; ?>$</span> </div>
				<div class="cart_icon">
					<a href="" style="pointer-events: none; cursor: default;"><img src="images/cart.jpg" alt="" width="48" height="48" border="0" /></a>
				</div>
		</div>
		<?php
		}
		?>
		<br />
		<div class="banner_adds"><img src="images/onepiece.gif" alt="" height="150" border="0" /></div>
		<br />
			
        <div class="title_box">What's new</div>
        <div class="border_box">
            <div class="product_title"><a href="">Card Captors Volume 4</a></div>
            <div class="product_img"><a href=""><img src="images/cardcaptors2.jpg" width="150" height="150" alt="" border="0" /></a>
            </div>
            <div class="prod_price"><span class="reduce">350$</span> <span class="price">270$</span></div>
        </div>
        <div class="banner_adds"> <a href="#"><img src="images/add2.jpg" alt="" width="190" border="0" /></a></div>
        </div>
    </div>
    <!-- end of main content -->
        
    <!-- footer -->
    <div class="footer">
        <div class="left_footer"> <img src="images/banner1.jpg" alt="" width="170" height="49"/> </div>
        <div class="center_footer"> Template name. All Rights Reserved 2008<br />
            <a href="http://csscreme.com"> <a href="index.html">home</a> <a href="aboutus.html">about</a> <a href="#">sitemap</a> <a href="#">rss</a> <a href="contact.html">contact us</a> </div>
    </div>    
</div>
<!-- end of main_container -->
</body>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/121761/card.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/121761/jquery.card.js'></script>
<script src="js/checkout.js"></script>
</html>
