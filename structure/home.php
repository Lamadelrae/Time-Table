<?php 
session_start(); 
include("navbar.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
</head>
<body>
	<br>
	<br>
<?php 
$show_data_table = new DBops();

$show_data_table->show_data_table($_SESSION['user_id']);
?>
</body>
</html>

