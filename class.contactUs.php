<?php

require_once('dbconfig.php');

class contactUs
{	

	private $conn;

	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{

		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function contact($udate, $uproblem)
	{
		try
		{
			
			
			$stmt = $this->conn->prepare("INSERT INTO repair(repairdate, problem) 
		                                               VALUES(:udate, :uproblem, )");
												  
			$stmt->bindparam(":udate", $udate);
			$stmt->bindparam(":uproblem", $uproblem);
			
		



				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}


	


	public function redirect($url)
	{
		header("Location: $url");
	}
	
	
}
?>