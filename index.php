<?php
include "includes/classes.inc.php";
include "includes/bootstrap.inc.php";

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta  charset="utf-8">
		<title>Time Punch</title>
	</head>
  <body>
  	<div class="container">
  	 <div class="row">
  		 <div class="col">
				  <br>
  		    <h3>The 21st Century Open Source Time Punch Program</h3>
  	   </div>
  	 </div>
		 <br>
		 <br>
		 <div class="row">
			 <div class="col">
					<form action="/projects/TimeTable/index.php" method="post">
				       <h4>Log-in</h4>
				       <input type="text" class="form-control" id="username" name="username" placeholder="Username">
				       <br>
				       <input type="password" class="form-control" id="password" name="password" placeholder="Password">
				       <br>
				       <input type="submit" class="btn btn-primary" name="submit-btn" id="submit-btn">

				      <a href="register_user/index.php" class="float-right btn btn-primary">Register User</a> 
					</form>
			 </div>
		 </div>
  	</div>
  </body>
</html>

<?php 
 if(isset($_POST['submit-btn']))
 {
   $username = $_POST['username'];
   $password = $_POST['password'];	
   $validate = new DBops();
   extract($_POST);
   $validate->validate("users", $username, $password);
 }
?>