<?php

// we've writen this code where we need
require_once 'mdl/Users.php';


class Model {
	private $db;
	
	private $users;
		
	public function __get($property) {
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}
	
	public function __construct($basedir) {
		$data_path = $basedir.'/../data/';
		$db_path = $data_path. 'db.sqlite';
		
		//if database not exists
		if (!file_exists($db_path)) {
			$this->db = new PDO('sqlite:/' . $db_path);
			$schema = file_get_contents($data_path . 'schema.sql');
			if ($schema === false) {
				throw new Exception('cannot find schema file: '.$schema);
			}
			$this->db->exec($schema);
		} else {		
			$this->db = new PDO('sqlite:/' . $db_path);
		}
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		
		$this->users = new Users($this);
	}
	
	public function __destruct() {
		//http://stackoverflow.com/questions/18277233/pdo-closing-connection
		$this->db = NULL;
	}
	
}
