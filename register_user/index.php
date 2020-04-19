<?php
include "../includes/classes.inc.php";
?>
<!DOCTYPE html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
  		    <h3></h3>
  	   </div>
  	 </div>
		 <br>
		 <br>
		 <div class="row">
			 <div class="col">
					 <form action="index.php" method="post">
				       <h4>Register user</h4>
				       <input type="text" class="form-control" id="username" name="username" placeholder="Username">
				       <br>
				       <input type="password" class="form-control" id="password" name="password" placeholder="Password">
				       <br>
				       <button class="btn btn-primary" name="submit-btn" id="submit-btn">
				    	  Register <i class="fas fa-check"></i>
				       </button>
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
	    $DBops = new DBops();
	    extract($_POST);
		$DBops->insert("users", $username, $password);
  }
  
?>

<!-- scripts -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/dfe2e43d7c.js" crossorigin="anonymous"></script>
<!-- scripts -->
