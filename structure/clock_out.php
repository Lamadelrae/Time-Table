<?php 
session_start(); 
include("../includes/classes.inc.php");
include("../includes/bootstrap.inc.php");
//session validation
$validatesesh = new DBops();
$validatesesh->validatesesh($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Clock Out</title>
	<meta charset="utf-8">
</head>
 <body>
 	<div class="container">
 	   <div class="row">
 	   	   <div class="col"></div>
 	   	   <div class="col">
 	   	   	 <form action="clock_out.php" method="post">
 	   	   	   <button id="time-btn" name="time-btn" class="btn btn-light" style="position:relative; top:250px;font-size:50px;">
               <i style="font-size:250px;" class="far fa-clock"></i>End
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

$clock_out = new DBops();
$clock_out->clock_out($_SESSION['user_id']);
header("Location: /projects/TimeTable/index.php");
}
?>