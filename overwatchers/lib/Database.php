<?php

$filepath = realpath(dirname(__FILE__));
require_once ($filepath.'/config.php');

class Database{

	public $isCon;
	protected $db;
	
	public function __construct($host = DB_HOST, $dbname = DB_NAME, $user = DB_USER, $pass = DB_PASS, $char = DB_CHAR){
		$this->isCon = TRUE;
		try{
			$this->db = new PDO("mysql:host={$host};dbname={$dbname};charset={$char}", $user, $pass);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			
		}catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
	}
	
	private function __clone(){}
	
	public function disconnect(){
		$this->db = NULL;
		$this->isCon = FALSE;
	}
	
	public function getRow($query, $params = []){
		try{
			$stmt = $this->db->prepare($query);
			$stmt->execute($params);
			return $stmt->fetch();
		}catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
	}
	
	public function getRows($query, $params = []){
		try{
			$stmt = $this->db->prepare($query);
			$stmt->execute($params);
			return $stmt->fetchAll();
		}catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
	}
	
	public function insertRow($query, $params = []){
		try{
			$stmt = $this->db->prepare($query);
			$stmt->execute($params);
			return TRUE;
		}catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
	}
	
	public function updateRow($query, $params = []){
		$this->insertRow($query, $params);
	}
	
	public function deleteRow($query, $params = []){
		$this->insertRow($query, $params);
	}
}

?>