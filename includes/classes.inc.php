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
		 $hashed_password = password_hash($password, PASSWORD_DEFAULT);
		 $sql = "INSERT INTO $table VALUES ('','$username','$hashed_password')";
         mysqli_query($conn, $sql);
         header("Location:/projects/TimeTable/index.php");
	}

	public function validate($table, $username, $password)
	{   
        $conn = $this->conn();
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
		header("Location: structure/index.php");
		}
		else {
		echo "<p>Password incorrect</p>";
		return false;
		}
		endwhile;	
	}

	public function validatesesh($username)
	{
		if(empty($_SESSION['username']))
		{
			header("Location: /projects/TimeTable/index.php");
			return false;
		}
	}

	public function TimeIn($user_id)
	{   
		$conn = $this->conn();

		$initial_date = date("Y-m-d H:i:s");

		$sql = "INSERT INTO timetable (user_id, initial_date) VALUES ('$user_id', '$initial_date')";
		$result = mysqli_query($conn, $sql);
	}

}


?>
