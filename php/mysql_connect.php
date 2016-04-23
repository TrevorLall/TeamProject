<?php
$host = 'localhost'; 
$dbname = 'test'; 
$user = 'root'; 
$pass = ''; 

# MySQL with PDO_MYSQL 
$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
?>