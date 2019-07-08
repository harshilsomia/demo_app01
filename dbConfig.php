<?php
$servername = "localhost";
$username = "admin";
$password = "ts1234";
$dbname = "demo";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
