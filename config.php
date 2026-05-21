<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'smart_attendance');

if(!$conn){
    die("Database connection failed: " . mysqli_connect_error());
}
session_start();
?>
