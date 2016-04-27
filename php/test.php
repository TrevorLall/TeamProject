<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	if(!isset($_FILES['userfile']))
	{
		echo '<p>Please select a file</p>';
	}
	else
	{
		try    
		{
			upload();
			echo '<p>Thank you for submitting</p>';
		}
		catch(Exception $e)
		{
			echo '<h4>'.$e->getMessage().'</h4>';
		}
	}
}

function upload(){
	/*** check if a file was uploaded ***/
	if(is_uploaded_file($_FILES['userfile']['tmp_name']) && getimagesize($_FILES['userfile']['tmp_name']) != false)
	{
		/***  get the image info. ***/
		$size = getimagesize($_FILES['userfile']['tmp_name']);
		/*** assign our variables ***/
		$type = $size['mime'];
		$imgfp = fopen($_FILES['userfile']['tmp_name'], 'rb');
		$size = $size[3];
		$name = $_FILES['userfile']['name'];
		$maxsize = 99999999;


		/***  check the file is less than the maximum file size ***/
		if($_FILES['userfile']['size'] < $maxsize )
		{
			$name = $_POST['name'];
			$desc = $_POST['desc'];
			$genre = $_POST['genre'];
			$price = $_POST['price'];
			$qoh = $_POST['qoh'];
			
			require('mysql_connect.php');
			
			$stmt = $DBH->prepare("INSERT INTO product (p_name ,p_desc, genre, price, qoh, image) VALUES (?,?,?,?,?,?)");

			/*** bind the params ***/
			$stmt->bindParam(1, $name);
			$stmt->bindParam(2, $desc);
			$stmt->bindParam(3, $genre);
			$stmt->bindParam(4, $price);
			$stmt->bindParam(5, $qoh);
			$stmt->bindParam(6, $imgfp, PDO::PARAM_LOB);

			/*** execute the query ***/
			$stmt->execute();
			
			echo "Success";
		}
		else
		{
			/*** throw an exception is image is not of type ***/
			throw new Exception("File Size Error");
		}
	}
	else
	{
		// if the file is not less than the maximum allowed, print an error
		throw new Exception("Unsupported Image Format!");
	}
}
?>

<html>
  <head>
	<title></title>
  </head>
  
	<body>
		<form enctype="multipart/form-data" action="" method="post">
			<input type="text" name="name" value="One Piece Volume 2" />
			<input type="text" name="desc" value="The tragic secrets of Robin's past are revealed in series of heartbreaking flashbacks! Bullied because                            of her unique powers, young Robin's only friends were the kindly scientists that nurtured her genius intellect while her                                  mother searched for the answers to life's greatest mysteries. Back in the present, Luffy races to rescue Robin from the clutches of Spandam the madman, Nami saves                              Sanji from a beating at the hands of a bathing beauty, and Chopper goes berserk after eating one too many Rumble Balls during                            his showdown with a samurai lion! Meanwhile, Franky teaches a zipper-mouthed freak a thing or two about the punching power                                of cola, Zoro's swordplay is hampered by being handcuffed to Usopp, and Sanji reappears just in time to introduce his wolfish                            opponent to the burning power of the devil's leg!" />
			<input type="text" name="genre" value="adventure" />
			<input type="text" name="price" value="35.99" />
			<input type="text" name="qoh" value="5" />
			<input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
			<div><input name="userfile" type="file" /></div>
			<div><input type="submit" value="Upload" /></div>
		</form><br />
		
		<form enctype="multipart/form-data" action="" method="post">
			<input type="text" name="name" value="One Piece Volume 13" />
			<input type="text" name="desc" value="Gol D. Roger was known as the Pirate King, the strongest and most infamous being to have sailed the Grand Line. The capture and death of Roger by the World Government brought a change throughout the world. His last words before his death revealed the location of the greatest treasure in the world, One Piece. It was this revelation that brought about the Grand Age of Pirates, men who dreamed of finding One Piece (which promises an unlimited amount of riches and fame), and quite possibly the most coveted of titles for the person who found it, the title of the Pirate King." />
			<input type="text" name="genre" value="adventure" />
			<input type="text" name="price" value="21.99" />
			<input type="text" name="qoh" value="5" />
			<input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
			<div><input name="userfile" type="file" /></div>
			<div><input type="submit" value="Upload" /></div>
		</form><br />
		
		<form enctype="multipart/form-data" action="" method="post">
			<input type="text" name="name" value="One Piece Volume 9" />
			<input type="text" name="desc" value="One Piece Film: Gold is the 13th One Piece movie, which will be released in Japanese theatres on July 23, 2016. The movie was first announced following the broadcast of Episode of Sabo. The title and release date of the film was revealed in the first 2016 issue of Shueisha's Weekly Shonen Jump magazine." />
			<input type="text" name="genre" value="adventure" />
			<input type="text" name="price" value="55.99" />
			<input type="text" name="qoh" value="5" />
			<input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
			<div><input name="userfile" type="file" /></div>
			<div><input type="submit" value="Upload" /></div>
		</form><br />
		
		<form enctype="multipart/form-data" action="" method="post">
			<input type="text" name="name" value="One Piece Volume 16" />
			<input type="text" name="desc" value="Luffy and crew arrive at the harbour of Anabaru. The local casino is holding a competition in which the winner will obtain a huge monetary reward if he reaches the finishing line first. Nami is elated and decides to participate in the competition. However, there is a conspiracy going behind the competition and the mastermind is an ex-military commander, Gasparde. His plan is to lure all the pirates to the military base and send them to their deaths. Luffy and gang have to overcome the numerous tests and tribulations along the way to complete this dead-end adventure." />
			<input type="text" name="genre" value="adventure" />
			<input type="text" name="price" value="15.99" />
			<input type="text" name="qoh" value="5" />
			<input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
			<div><input name="userfile" type="file" /></div>
			<div><input type="submit" value="Upload" /></div>
		</form><br />
		
		<form enctype="multipart/form-data" action="" method="post">
			<input type="text" name="name" value="One Piece Volume 24" />
			<input type="text" name="desc" value="The movie is a retelling of the Drum Island arc with new music and animation. Vivi has been removed from the plot while both Nico Robin and Franky, who joined the crew after the Drum Island arc, have been added. The movie also has the Straw Hat's new ship, the Thousand Sunny. It has been stated that Oda will be creating a new character for this movie, Wapol's older brother, Mushul, who also appears to be a Devil Fruit user. " />
			<input type="text" name="genre" value="adventure" />
			<input type="text" name="price" value="32.99" />
			<input type="text" name="qoh" value="5" />
			<input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
			<div><input name="userfile" type="file" /></div>
			<div><input type="submit" value="Upload" /></div>
		</form><br />
		
		<form enctype="multipart/form-data" action="" method="post">
			<input type="text" name="name" value="One Piece Volume 4" />
			<input type="text" name="desc" value="Luffy and crew go to an island searching for a legendary sword, said to be the most expensive in the world. Soon attacking marines and beautiful maidens split the crew. Zoro betrays the crew to help an old friend, Luffy and Usopp wander through a cave, and the rest help a village fight marines. When Zoro defeats Sanji he takes the sacred pearls that are the only defense against the evil sword that will plunge the world into darkness. " />
			<input type="text" name="genre" value="adventure" />
			<input type="text" name="price" value="19.99" />
			<input type="text" name="qoh" value="5" />
			<input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
			<div><input name="userfile" type="file" /></div>
			<div><input type="submit" value="Upload" /></div>
		</form><br />
	</body>
</html>