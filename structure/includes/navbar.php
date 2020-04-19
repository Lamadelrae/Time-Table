<?php 
include("../includes/classes.inc.php");
include("../includes/bootstrap.inc.php");
//session validation
$validatesesh = new DBops();
$validatesesh->validatesesh($_SESSION['user_id']);

$validate_inactive = new DBops();
$validate_inactive->validate_inactive($_SESSION['user_id']);

$active_timetable = new DBops();
$active_timetable->active_timetable($_SESSION['user_id']);
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Time-Table</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="/projects/TimeTable/structure/home.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Settings</a>
      </li>
        <li class="nav-item">
        <a class="nav-link" href="clock_out.php">Clock Out</a>
      </li>
    </ul>
  </div>
</nav>