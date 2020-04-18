<?php 
session_start(); 
include("../includes/classes.inc.php");
include("../includes/bootstrap.inc.php");
//session validation
$validatesesh = new DBops();
$validatesesh->validatesesh($_SESSION['username']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<meta charset="utf-8">
</head>
 <body>
 	<div class="container">
 	   <div class="row">
 	   	   <div class="col"></div>
 	   	   <div class="col">
 	   	   	 <form action="index.php" method="post">
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

$TimeIn = new DBops();
$TimeIn->TimeIn($_SESSION['user_id']);
header("Location: home.php");

}

?>