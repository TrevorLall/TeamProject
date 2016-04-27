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
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>KaZh</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
	<link rel="stylesheet" type="text/css" href="css/index/style.css" />
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
                    <li><a href="index.php" class="nav1">Home</a></li>
                    <li class="divider"></li>
                    <li><a href="aboutus.html" class="nav2">About Us</a></li>
                    <li class="divider"></li>
                    <li><a href="" class="nav3">My Account</a></li>
                    <li class="divider"></li>
                    <li><a href="" class="nav5">Shipping</a></li>
                    <li class="divider"></li>
                    <li><a href="contact.html" class="nav5">Contact Us</a></li>
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
					<li><a href="register.php">Sign Up</a></li>
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
                <div class="product_title"><a href="details.html">One Piece Volume 1</a></div>
                <div class="product_img"><a href="details.html"><img src="images/rsz_onepiece1.jpg" width="190" height="200" alt="" border="0" /></a></div>
                <div class="prod_price"><span class="reduce">30$</span> <span class="price">15$</span></div>
            </div>
        </div>
        <!-- end of left content -->
            
        <!-- center content -->
        <div class="center_content">
        <div class="center_title_bar">Latest Products</div>
		
<?php
	require('mysql_connect.php');

	$STH = $DBH->query("SELECT * FROM product");
	$STH->setFetchMode(PDO::FETCH_ASSOC);

	while($row = $STH->fetch()) 
	{ 		
?>
			<div class="prod_box">
				<div class="top_prod_box"></div>
				<div class="center_prod_box">
					<div class="product_title"><a href="product_detail.php?id=<?php echo $row['p_id']; ?>"><?php echo $row['p_name']; ?></a></div>
					<div class="product_img"><a href="product_detail.php?id=<?php echo $row['p_id']; ?>"><img src="data:image/jpeg;base64, <?php echo base64_encode($row['image']); ?>" width="100" height="100" alt="" border="0" /></a></div>
					<div class="prod_price"><span class="reduce"><?php echo $row['price']+9; ?></span> <span class="price"><?php echo $row['price']; ?></span></div>
				</div>
				<div class="bottom_prod_box"></div>
				<div class="prod_details_tab"><a href="product_detail.php?id=<?php echo $row['p_id']; ?>" class="prod_details">Details</a></div>
			</div>
<?php
	}
?>
          
        <!-- RECOMMENDED PRODUCTS SECTION -->
        <div class="center_title_bar">Recommended Products</div>
        
        <!-- Digimon Adventure 3 -->
        <div class="prod_box">
            <div class="top_prod_box"></div>
            <div class="center_prod_box">
                <div class="product_title"><a href="">Digimon Adventure 3</a></div>
                <div class="product_img"><a href=""><img src="images/digimon.jpg" width="100" height="100" alt="" border="0" /></a></div>
                <div class="prod_price"><span class="reduce">50$</span> <span class="price">22$</span></div>
            </div>
            <div class="bottom_prod_box"></div>
            <div class="prod_details_tab"> <a href="" class="prod_details">Details</a> </div>
        </div>
      
        <!-- Sailor Moon S -->
        <div class="prod_box">
        <div class="top_prod_box"></div>
        <div class="center_prod_box">
            <div class="product_title"><a href="">Sailor Moon S</a></div>
            <div class="product_img"><a href=""><img src="images/sailormoon1.jpg" width="100" height="100" alt="" border="0" /></a></div>
            <div class="prod_price"><span class="price">21$</span></div>
        </div>
        <div class="bottom_prod_box"></div>
        <div class="prod_details_tab"> <a href="" class="prod_details">Details</a> </div>
        </div>
        
        <!-- Another -->
        <div class="prod_box">
            <div class="top_prod_box"></div>
            <div class="center_prod_box">
              <div class="product_title"><a href="">Another</a></div>
              <div class="product_img"><a href=""><img src="images/another.jpg" width="100" height="100" alt="" border="0" /></a></div>
              <div class="prod_price"><span class="reduce">35$</span> <span class="price">14.50$</span></div>
            </div>
            <div class="bottom_prod_box"></div>
            <div class="prod_details_tab"> <a href="" class="prod_details">Details</a> </div>
        </div>
    </div>
    <!-- end of center content -->
    
    <!-- right content -->
    <div class="right_content">
        <div class="shopping_cart">
            <div class="cart_title">Shopping cart</div>
            <div class="cart_details"> 3 items <br />
                <span class="border_cart"></span> Total: <span class="price">350$</span> </div>
                <div class="cart_icon">
                    <a href="#" title="header=[Checkout] body=[&nbsp;] fade=[on]">
                        <img src="images/shoppingcart.png" alt="" width="48" height="48" border="0" /></a>
                </div>
                <!-- ^ should be done or not? :o -->
        </div>
        <div class="title_box">What's new</div>
        <div class="border_box">
            <div class="product_title"><a href="details.html">Card Captors Volume 4</a></div>
            <div class="product_img"><a href="details.html"><img src="images/cardcaptors2.jpg" width="150" height="150" alt="" border="0" /></a></div>
            <div class="prod_price"><span class="reduce">38$</span> <span class="price">26$</span></div>
        </div>
        <div class="banner_adds"> <a href="#"><img src="images/add1.jpg" alt="" width="190" border="0" /></a></div>
    </div>
    <!-- end of right content -->
            
        </div>
  <!-- end of main content -->
  
  <!-- footer -->
  <div class="footer">
    <div class="left_footer"> <img src="images/banner1.jpg" alt="" width="170" height="49"/> </div>
    <div class="center_footer"> Template name. All Rights Reserved 2008<br />
      <a href="http://csscreme.com"> <a href="#">home</a> <a href="#">about</a> <a href="#">sitemap</a> <a href="#">rss</a> <a href="contact.html">contact us</a> </div>
  </div>
      
</div>
<!-- end of main_container -->
</body>
</html>