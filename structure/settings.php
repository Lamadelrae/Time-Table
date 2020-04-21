<?php 
session_start(); 
include "includes/navbar.php"; 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Settings</title>
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
<?php $interactable_data_table = new DBops();  $interactable_data_table->interactable_data_table($_SESSION['user_id']);?>
   </table>
</body>
</html>