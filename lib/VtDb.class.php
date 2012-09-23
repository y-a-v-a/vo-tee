<?php

class VtDb {
	
	private static $instance = null;
	
	private $connection = null;
	
	private function __construct() {
		try {
			$this->connection =
				new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DB, DB_USER, DB_PASSWD);
		} catch(PDOException $e) {
			VtLog::log($e->getMessage());
		}
	}
		
	public static function getInstance() {
		if (self::$instance == null) {
			self::$instance = new VtDb();
		}
		return self::$instance;
	}
	
	public function doQuery($query) {
		$res = null;
		if ($this->connection == null) {
			throw new Exception('Could not query because there is no valid connection to db.');
		}
		try {
			$res = $this->connection->query($query);
		} catch(PDOException $e) {
			VtLog::log($e->getMessage());
		}
		return $res;
	}
	
	public function __destruct() {
		$this->connection = null;
	}
	
	public function addDesignData($data) {
		$sql = 'INSERT INTO design (name, url, email, hometown, design, adddate)
		 	VALUES (:name, :url, :email, :hometown, :design, :adddate)';
		$st = $this->connection->prepare($sql);
		return $st->execute($data);
	}
	
	public function addVote($data) {
		$sql = 'INSERT INTO votes (ip, design)
			VALUES (:ip, :design)';
		$st = $this->connection->prepare($sql);
		return $st->execute($data);
	}
	
}






