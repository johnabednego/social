<?php 
require_once 'database.php';
session_start();
if (!isset($_SESSION['id'])){
header('location:index.html');
}
$id = $_SESSION['id'];

$query="SELECT * FROM user WHERE id ='$id'";
$stmt = mysqli_query($link, $query);
$row=mysqli_fetch_array($stmt);
$cover_picture=$row['cover_picture'];
$profile_picture=$row['profile_picture'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$username=$row['username'];
		

?>