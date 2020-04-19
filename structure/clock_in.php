<?php 
session_start(); 
include("../includes/classes.inc.php");
include("../includes/bootstrap.inc.php");
//session validation
$validatesesh = new DBops();
$validatesesh->validatesesh($_SESSION['user_id']);

$validate_active = new DBops();
$validate_active->validate_active($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Clock In</title>
	<meta charset="utf-8">
</head>
 <body>
 	<div class="container">
 	   <div class="row">
 	   	   <div class="col"></div>
 	   	   <div class="col">
 	   	   	 <form action="clock_in.php" method="post">
 	   	   	   <button id="time-btn" name="time-btn" class="btn btn-light" style="position:relative; top:250px;font-size:50px;">
               <i style="font-size:250px;" class="far fa-clock"></i>Start
              </button>
            </form>
 	   	   </div>
 	       <div class="col"></div>
       </div>
    </div>
 </body>
</html>


<?php 

if(isset($_POST['time-btn']))
{

$clock_in = new DBops();
$clock_in->clock_in($_SESSION['user_id']);
header("Location: home.php");

}

?>