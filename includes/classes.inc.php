<?php

class db
{
	//Properties
	private $host = "localhost";
	private $user = "root";
	private $pass = "";
	private $dbName = "timetable";

	//Methods:
	
	//Connection
    public function conn()
	{
	  $db = mysqli_connect($this->host, $this->user, $this->pass, $this->dbName);
	  return $db;
	}

}

class DBops extends db
{
	 //Insert
	public function insert($table, $username, $password)
	{
		 $conn = $this->conn();
		 $username = mysqli_real_escape_string($conn, $username);
		 $password = mysqli_real_escape_string($conn, $password);
		 $hashed_password = password_hash($password, PASSWORD_DEFAULT);
		 $status = 0;
		 $sql = "INSERT INTO $table (username, password, status) VALUES ('$username','$hashed_password','$status')";
         mysqli_query($conn, $sql);
         header("Location:/projects/TimeTable/index.php");
	}

	public function validate($table, $username, $password)
	{   
        $conn = $this->conn();
        
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);

		$sql = "SELECT* FROM $table WHERE username = '$username'";
		$result = mysqli_query($conn, $sql);
		while($row = mysqli_fetch_assoc($result)):
		$user_id = $row['id'];	
		$hashed_password = $row['password'];

		if(password_verify($password, $hashed_password))
		{	
		session_start();
		$_SESSION['user_id'] = $user_id;
		$_SESSION['username'] = $username;	
		header("Location: structure/clock_in.php");
		}
		else {
		echo "<p>Password incorrect</p>";
		return false;
		}
		endwhile;	
	}

	public function validatesesh($user_id)
	{
		if(empty($_SESSION['user_id']))
		{
			header("Location: /projects/TimeTable/index.php");
			return false;
		}
	}

	public function clock_in($user_id)
	{   
		$conn = $this->conn();

		$initial_date = date("Y-m-d H:i:s");

		$sql = "INSERT INTO timetable (user_id, initial_date, status) VALUES ('$user_id', '$initial_date', '1')";
		$result = mysqli_query($conn, $sql);

		//status change; 1 = active, 2 = inactive
		$status_change = "UPDATE users SET status = 1 WHERE id = '$user_id'";

		$result_status_change = mysqli_query($conn, $status_change);
	}

    public function active_timetable($user_id)
	{
		$conn = $this->conn();

		$sql = "SELECT* FROM timetable WHERE status = 1 AND user_id = '$user_id' ";

		$result = mysqli_query($conn, $sql);

		//get id 
		while($row = mysqli_fetch_assoc($result)):
		$timetable_id = $row['id'];
	    return $timetable_id;
		endwhile;
	}

	public function clock_out($user_id)
	{
		$conn = $this->conn();

		$active_timetable = $this->active_timetable($user_id);

		$final_date = date("Y-m-d H:i:s");
        //status; 1 = active, 2 = inactive
		$sql = "UPDATE timetable SET final_date = '$final_date', status = 2 WHERE id = '$active_timetable' AND user_id = '$user_id' ";
		$result = mysqli_query($conn, $sql);

		//status change; 1 = active, 2 = inactive
		$status_change = "UPDATE users SET status = 2 WHERE id = '$user_id'";
		$result_status_change = mysqli_query($conn, $status_change);

		//calculte the diff 
		$get_dates = "SELECT* FROM timetable WHERE id = '$active_timetable' and user_id = '$user_id'";

		$result_get_dates = mysqli_query($conn, $get_dates);

		while($row = mysqli_fetch_assoc($result_get_dates)):
		//dates
		$final_date = $row['final_date'];
		$initial_date = $row['initial_date'];

	    $final_date_F = strtotime($final_date);
		$initial_date_F = strtotime($initial_date);

		$diff = $final_date_F - $initial_date_F;
		$set_diff = "UPDATE timetable SET diff = '$diff' WHERE id = '$active_timetable' AND user_id = '$user_id' ";
		$result_set_diff = mysqli_query($conn, $set_diff);	
		endwhile;	
	}

	public function validate_active($user_id)
	{   
		$conn = $this->conn();
		$sql = "SELECT* FROM users WHERE id = '$user_id'";
		$result = mysqli_query($conn, $sql);
		while($row = mysqli_fetch_assoc($result)):	
		$status = $row['status'];
		endwhile;

		if($status == 1)
		{ 
		    
		  header("Location:home.php");
		 
		}

	}

	public function validate_inactive($user_id)
	{
		$conn = $this->conn();
		$sql = "SELECT* FROM users WHERE id = '$user_id'";
		$result = mysqli_query($conn, $sql);
		while($row = mysqli_fetch_assoc($result)):	
		$status = $row['status'];
		endwhile;

		if($status == 2)
		{ 
		    
		  header("Location:clock_in.php");
		 
		}
	}

	public function active_date()
	{
		$date = date("Y-m");
		return $date;
	}

	public function show_data_table($user_id)
	{
		$conn = $this->conn();

		$active_date = $this->active_date();

		$initial_active = $active_date."-01";
		$final_active = $active_date."-30";

		$sql = "SELECT* FROM timetable WHERE initial_date BETWEEN  '$initial_active' AND '$final_active' AND final_date BETWEEN  '$initial_active' AND '$final_active' AND  user_id = '$user_id' ";

		$result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)):
        $diff = $row['diff'];
        $diff_formatted = gmdate("H:i:s",$diff);
		echo "   <tbody>
                  <tr>
                    <th>".$row['user_id']."</th>
                    <td>".$row['initial_date']."</td>
                    <td>".$row['final_date']."</td>
                    <td>".$diff_formatted."</td>
                  </tr>
                  </tbody>
                  ";
        endwhile;   

	}

	public function total_diff($user_id)
	{
		$conn = $this->conn();

		$active_date = $this->active_date();

		$initial_active = $active_date."-01";
		$final_active = $active_date."-30";

		$sql = "SELECT SUM(diff) as SUM FROM timetable WHERE initial_date BETWEEN  '$initial_active' AND '$final_active' AND final_date BETWEEN  '$initial_active' AND '$final_active' AND  user_id = '$user_id'";

		$result = mysqli_query($conn, $sql);

		while($row = mysqli_fetch_assoc($result)):
	    $sum = $row['SUM'];
	    $sum_hours = $sum/60/60;
	    $sum_hours_exp = explode(".", $sum_hours);
	    $sum__formatted = date($sum_hours_exp[0].":i:s",$sum);
		echo "   <tbody>
                  <tr>
                    <th></th>
                    <td></td>
                    <td></td>
                    <td>".$sum__formatted."</td>
                  </tr>
                  </tbody>
                  ";
		endwhile;	
	}

	public function interactable_data_table($user_id)
	{
		$conn = $this->conn();

		$active_date = $this->active_date();

		$initial_active = $active_date."-01";
		$final_active = $active_date."-30";

		$sql = "SELECT* FROM timetable WHERE initial_date BETWEEN  '$initial_active' AND '$final_active' AND final_date BETWEEN  '$initial_active' AND '$final_active' AND  user_id = '$user_id' ";

		$result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)):
        $diff = $row['diff'];
        $diff_formatted = gmdate("H:i:s",$diff);
		echo "   <tbody>
                  <tr>
                    <th>".$row['user_id']."</th>
                    <td>".$row['initial_date']."</td>
                    <td>".$row['final_date']."</td>
                    <td>".$diff_formatted."</td>
                    <td><a href='edit_time_table.php?id=".$row['id']." ' class='btn btn-success'><i style='color:white;' class='far fa-edit'></i></a></td>
                  </tr>
                  </tbody>
                  ";
        endwhile;   

	}

	public function edit_time_table($id, $user_id)
	{
		$conn = $this->conn();

		$id = mysqli_real_escape_string($conn, $id);

	    $sql = "SELECT* FROM timetable WHERE id = '$id' AND user_id = '$user_id' ";

	    $result = mysqli_query($conn, $sql);

	    while($row = mysqli_fetch_assoc($result)):
	    echo "<tbody>
	            <tr>
	           <form method='post'> 
	             <td>".$row['user_id']."</td>
	             <td><input id='initial_date' name='initial_date' type='text' class='form-control' value='".$row['initial_date']."''></td>
	             <td><input id='final_date' name='final_date' type='text' class='form-control' value='".$row['final_date']."''></td>
	             <td><input id='diff' name='diff' type='number' class='form-control' value='".$row['diff']."''></td>
	             <td><button id='btn-edit' name='btn-edit' type='submit' class='btn btn-primary'><i class='fas fa-check'></i></button></td>
	            </form> 
	            </tr>
	          </tbody>
               <script src='js/jquery.maskedinput-1.1.4.pack.js' type='text/javascript' /></script>
               <script type='text/javascript'>
                 $(document).ready(function(){ 
                   $('#initial_date').mask('9999-99-99 99:99:99');
                 });
               </script>
               <script type='text/javascript'>
                 $(document).ready(function(){ 
                   $('#final_date').mask('9999-99-99 99:99:99');
                 });
               </script>";
	    endwhile;

	    if(isset($_POST['btn-edit']))
	    {
	    	$initial_date = $_POST['initial_date'];
	    	$final_date = $_POST['final_date'];
	    	$diff = $_POST['diff'];

	    	$initial_date = mysqli_real_escape_string($conn, $initial_date);
	    	$final_date = mysqli_real_escape_string($conn, $final_date);
	    	$diff = mysqli_real_escape_string($conn, $diff);

	    	$update = "UPDATE timetable SET initial_date = '$initial_date', final_date = '$final_date', diff = '$diff' WHERE id = '$id' AND user_id = '$user_id' ";

	    	mysqli_query($conn, $update);

	    	header("Location:/projects/TimeTable/structure/edit_time_table.php?id=".$id." ");
	    }
	    
	}

	public function monthly_report()
	{
		echo "<input type=''>";
	}
}


?>
