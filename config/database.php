<?php 

//connect to database
$server = "sql8.freemysqlhosting.net";
$user = "sql8756530";
$password1 = "8hE4DZKJye";
$database = "sql8756530";

$conn = new mysqli($server, $user, $password1, $database);

if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
