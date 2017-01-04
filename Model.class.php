<?php

// we've writen this code where we need
require_once 'Models/Groups.php';
require_once 'Models/Users.php';
require_once 'Models/Domains.php';

class Model {
	private $db;
	
	private $users, $domains, $users_domains, $groups, $activity;
		
	public function __get($property) {
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}
	
	public function __construct($domain) {
		$data_path = __DIR__.'/data/';
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
		//http://stackoverflow.com/questions/2269840/how-to-apply-bindvalue-method-in-limit-clause
		//$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		
		$this->users = new Users($this, $domain);
		$this->domains = new Domains($this, $domain);
		$this->groups = new Groups($this, $domain);
		//~ $this->activity = new Models\Acrivities($this);
	}
	
	public function __destruct() {
		//http://stackoverflow.com/questions/18277233/pdo-closing-connection
		$this->db = NULL;
	}
	
}
