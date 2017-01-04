<?php

abstract class Factory {
	
	protected $db, $domain;
	
	public function __construct($model, $domain) {
		$this->db = $model->db;
		$this->domain = $domain;
	}
	
	public function get_table_name() {
		$class = get_class($this);
		
		//remove namespace
		$split = explode('\\', $class);
		$class_name = array_pop($split);
		
		$table = lcfirst($class_name);
		return $table;
	}
	
	public function save($obj) {
		if ($obj->any_errors()) {
			return false;
		}
		
		$set = array();
		$execute = array();
		foreach ($obj->get_columns() as $column) {
			$set[] = ":$column";
			$execute[':'.$column] = $obj->$column;
		}
			
		$query = 'REPLACE INTO '.$this->get_table_name().'
							('.implode(',', $obj->get_columns()).')
							VALUES ('.implode(',', $set).')';
									
		$sth = $this->model->db->prepare($query);
		$sth->execute($execute);
		
		return $this->model->db->lastInsertId();
	}
}
