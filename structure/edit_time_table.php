<?php 
session_start(); 
include "includes/navbar.php"; 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Time Table</title>
</head>
<body>
	<br>
	<br>
  <table class="container table">
    <thead>
    	<tr>
    		<td>User ID</td>
    		<td>Initial Date</td>
    		<td>Final date</td>
    		<td>diff</td>
    	</tr>
    </thead>	
   <?php $id = $_GET['id'];$interactable_data_table = new DBops(); $interactable_data_table->edit_time_table($id, $_SESSION['user_id']);?>
   </table>

</body>
</html>