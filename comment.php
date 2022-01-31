<?php require_once'session.php';?>
<?php
	require_once"database.php";	
	if (isset($_POST['post_comment']))
	{
		$user=$_SESSION['id'];
		$content_comment=$_POST['content_comment'];
		$post_id=$_POST['post_id'];
		$image = $_POST['profile_picture'];
		$user_id=$_POST['user_id'];
		$time=time();
		

		{
			mysqli_query($link,"INSERT INTO comments (post_id,user_id,name,content_comment,image,created)
			VALUES ('$post_id','$id','$user_id','$content_comment','$image' ,'$time')")
			or die (mysqli_error());
			echo "<script>window.location='home.php'</script>";
		}
			
	}
	
?>