<?php 

//connect to database
$server = "localhost";
$user = "washington";
$password1 = "Insurmountable.1";
$database = "healthtrak";

$conn = new mysqli($server, $user, $password1, $database);

if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>