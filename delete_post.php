<?php

require_once"database.php";

$get_id =$_GET['id'];
	
	// sending query
	mysqli_query($link,"DELETE FROM post WHERE post_id = '$get_id'")
	or die(mysqli_error());  	
	header("Location: home.php");

?>
