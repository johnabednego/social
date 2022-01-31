<?php
// mysqli_select_db('biobook',mysqli_connect('localhost','root',''))or die(mysqli_error());
define('DB_HOST', 'localhost');
define('DB_NAME', 'root');
define('DB_PASS', '');
define('DB', 'biobook');

$link = mysqli_connect(DB_HOST, DB_NAME, DB_PASS, DB);
if ($link === false) {
	// code...
	die("Error: Could not connect to database!!".mysqli_connect_error());
}


?>
