<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	//Redirect user if not logged in
	if (!isset($_SESSION['UID'])){		
		$url = "login.php";
		header("Location: $url");
	}
	
	$p_id = $_GET['id'];
	$u_id = $_SESSION['UID'];
	
	require('mysql_connect.php');
	
	try { 
		$STH = $DBH->prepare("INSERT INTO cart (u_id, p_id) VALUES (?,?)");
		$STH->bindParam(1, $u_id);
		$STH->bindParam(2, $p_id);
		$STH->execute();
		$rows_affected = $STH->rowCount();
		if ($rows_affected == 1)
			echo "<script>alert('Item added to cart!');</script>";
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
</head>
    
<body>
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
                <div class="product_title">
                    <a href="">Card Captors Volume 4</a>
                </div>
                <div class="product_img">
                    <a href=""><img src="images/cardcaptors1.jpg" width="190" height="200" alt="" border="0" /></a>
                </div>
                <div class="prod_price"><span class="reduce">30$</span> <span class="price">15$</span></div>
          </div>
        </div>
        <!-- end of left content -->
        
		<?php
		$id = $_GET['id'];
		
		require('mysql_connect.php');

		$STH = $DBH->query("SELECT p_name, p_desc, price, genre, image FROM product WHERE p_id = ".$id);
		$STH->setFetchMode(PDO::FETCH_ASSOC);
		
		if ($row = $STH->fetch()){
		?>
        <!-- center content -->
        <div class="center_content">
        <div class="center_title_bar"><?php echo $row['p_name']; ?></div>
            <table>
                <tr>
                    <td>
                        <div class="product_title"><?php echo $row['p_name']; ?></div>
                        <div class="product_img">
                            <img src="data:image/jpeg;base64, <?php echo base64_encode($row['image']); ?>" width="250" height="200" alt="" border="0" />
                        </div>
                        <center>
							<div class="prod_price"><span class="reduce"><?php echo $row['price']+9; ?></span> <span class="price"><?php echo $row['price']; ?></span></div>
							<form action="" method="post">
								<input type="submit" value="Add To Cart" />
							</form>
                        </center>
                    </td>
                    <td>
						<p style="font-size:12px"><?php echo $row['p_desc']; ?></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <center><p style="font-size:15px">Genre: <?php echo $row['genre']; ?></p> <br/>

                                <p style="font-size:12px">Special Features: On the Boat: Behind the Scenes of One Piece, Episode Commentary (277, 287,                                                      289, 290), Textless Openings and Closings, U.S. Trailer, Trailers. </p>

                                <p style="font-size:12px">Spoken Languages: English, Japanese, English subtitles.</p></center>
                    </td>
                </tr>
            </table>
		<?php
		}
		?>
            <br/><br/><br/>
            
            <!-- shipping information table -->
            <table border="1" style="width:100%">
                <tr>
                    <th colspan="4"><p style="font-size:16px;">Shipping Information</p></th>
                </tr>
                <tr>
                    <td>Standard Shipping</td>
                    <td>4-6 business days <br/>
                        Shipping fee: <b><u>$4.95</u></b>
                    </td>
                </tr>
                <tr>
                    <td>Express Shipping</td>
                    <td>2 days max <br/>
                        Shipping fee: <b><u>$8.95</u></b>
                    </td>
                </tr>
                <tr>
                    <td>Next Day Shipping</td>
                    <td>1 day <br/>
                        Shipping fee: <b><u>$12.95</u></b>
                    </td>
                </tr>
            </table>
        </div>
        <!-- end of center content -->
      
        <!-- right content -->
        <div class="right_content">
		<br /><br />
 		<?php
		if (isset($_SESSION['UID'])){
			$u_id = $_SESSION['UID'];
			
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
				<form action="checkout.php" method="post">
					<input type="hidden" name="id" value="<?php echo $u_id; ?>" />
					<input type="submit" value="Checkout" />
				</form>
        </div>
		<?php
		}
		?>
		<br /><br /><br />
		<div class="banner_adds"><img src="images/onepiece.gif" alt="" height="150" border="0" /></div>
		<br />
            <div class="title_box">What's new</div>
            <div class="border_box">
                <div class="product_title"><a href="">Card Captors Volume 4</a></div>
                <div class="product_img">
                    <a href=""><img src="images/cardcaptors2.jpg" width="150" height="150" alt="" border="0" /></a>
                </div>
            <div class="prod_price"><span class="reduce">350$</span> <span class="price">270$</span></div>
            </div>
            <div class="banner_adds"> <a href=""><img src="images/add3.jpg" alt="" width="190" border="0" /></a></div>
        </div>
        <!-- end of main content -->
        
        <!-- footer -->
        <div class="footer">
            <div class="left_footer"> <img src="images/banner1.jpg" alt="" width="170" height="49"/> </div>
            <div class="center_footer"> 
                Template name. All Rights Reserved 2008<br />
                <a href="http://csscreme.com"> <a href="#">home</a> 
                <a href="#">about</a> <a href="#">sitemap</a> <a href="#">rss</a> <a href="contact.html">contact us</a> 
            </div>
        </div>    
    </div>
    <!-- end of main_container -->
</body>
</html>