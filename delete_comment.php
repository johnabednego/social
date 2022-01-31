<?php

require_once"database.php";

$get_id =$_GET['id'];
	
	// sending query
	mysqli_query($link,"DELETE FROM comments WHERE comment_id = '$get_id'")
	or die(mysqli_error());  	
	header("Location: home.php");

?>
