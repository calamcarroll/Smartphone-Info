<?php

require_once('dbconfig.php');

class USER
{	

	private $conn;


	//Constructor for this class
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	

	//  function to runQuery
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	


	//fuction for registration
	public function register($uname, $uemail, $upass, $ufname, $ulname, $uaddress, $unum)
	{
		try
		{
			$new_password = password_hash($upass, PASSWORD_DEFAULT);
			
			$stmt = $this->conn->prepare("INSERT INTO users(user_name, user_email, user_pass, user_address, user_fname, user_lname, user_phone) 
		                                               VALUES(:uname, :uemail, :upass, :uaddress, :ufname, :ulname, :unum)");
												  
			$stmt->bindparam(":uname", $uname);
			$stmt->bindparam(":uemail", $uemail);
			$stmt->bindparam(":upass", $new_password);
			$stmt->bindparam(":uaddress", $uaddress);
			$stmt->bindparam(":ufname", $ufname);
			$stmt->bindparam(":ulname", $ulname);
			$stmt->bindparam(":unum", $unum);

				
			$stmt->execute();	
			
			return $stmt;

		}catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	
	// function for  loging in 
	public function doLogin($uname,$umail,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT user_id, user_name, user_email, user_pass FROM users WHERE user_name=:uname OR user_email=:uemail ");
			$stmt->execute(array(
			':uname'=>$uname, 
			':uemail'=>$uemail
			));

			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

			if($stmt->rowCount() == 1)
			{
				if(password_verify($upass, $userRow['user_pass']))// checks if passwords match 
				{
					$_SESSION['user_session'] = $userRow['user_id'];
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	//function to check in the user is logged in
	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}


	//Function to redirect 
	public function redirect($url)
	{
		header("Location: $url");
	}
	


	//function for logging out
	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}
}
?>