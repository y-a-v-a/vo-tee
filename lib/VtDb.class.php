<?php

class VtDb {
	
	private static $instance = null;
	
	private $connection = null;
	
	private function __construct() {
		try {
			$this->connection =
				new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DB, DB_USER, DB_PASSWD);
		} catch(PDOException $e) {
			Vtlog::log($e->getMessage());
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
			Vtlog::log($e->getMessage());
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
	
	public function addVote($ip, $design) {
		$data = array();
		$data['ip'] = $ip;
		$data['design'] = $design;
		$data['adddate'] = date('YmdHis');

		$sql = 'INSERT INTO votes (ip, design, adddate)
			VALUES (:ip, (SELECT id FROM design WHERE design = :design), :adddate)';
		$st = $this->connection->prepare($sql);
		return $st->execute($data);
	}
	
	public function getVoteCountFor($id) {
		$sql = 'SELECT COUNT( * ) 
		FROM votes
		LEFT JOIN design ON votes.design = design.id
		WHERE design.design = \'' . $id . '\'';
		$res = $this->connection->query($sql)->fetch();
		if (isset($res[0])) {
			return $res[0];
		}
		return 0;
	}
	
	public function hasVoted($ip, $design) {
		$data = array();
		$data['ip'] = $ip;
		$data['design'] = $design;
		$sql = 'SELECT * FROM votes WHERE ip = :ip AND design = (SELECT id FROM design WHERE design = :design)';
		$st = $this->connection->prepare($sql);
		$st->execute($data);
		return count($st->fetchAll());
	}
	
	public function getApplicantInfo($id) {
		$data = array('design' => $id);
		$sql = 'SELECT name, hometown FROM design WHERE design = :design';
		$st = $this->connection->prepare($sql);
		$st->execute($data);
		$res = $st->fetch();
		return array('name' => $res['name'], 'hometown' => $res['hometown']);
	}
}
