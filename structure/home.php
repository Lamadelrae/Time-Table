<?php 
session_start(); 
include("includes/navbar.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
</head>
<body>
	<br>
	<br>
	<table class='container table'>
        <thead>
          <tr>
            <th scope='col'>User ID</th>
            <th scope='col'>Initial Date</th>
            <th scope='col'>Final Date</th>
            <th scope='col'>Diff</th>
          </tr>
        </thead>
         <?php $show_data_table = new DBops(); $show_data_table->show_data_table($_SESSION['user_id']); ?>
    	</table>
    	<br>
    <table class='container table'>
        <thead>
          <tr>
            <th scope='col'></th>
            <th scope='col'></th>
            <th scope='col'></th>
            <th scope='col'>Total Hours</th>
          </tr>
        </thead>
        <?php $total_diff = new DBops(); $total_diff->total_diff($_SESSION['user_id']); ?>
    </table>
</body>
</html>

