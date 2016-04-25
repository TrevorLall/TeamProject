<?php
session_start();

$_SESSION = array();
session_destroy();

$url = "login.php";
header("Location: $url");
?>