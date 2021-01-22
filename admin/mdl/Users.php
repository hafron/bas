<?php

require_once 'Factory.php';
class Users extends Factory
{
	private $fields = array('id', 'user', 'pass', 'name', 'mail', 'global_perms');
	
	public function checkPass($user, $pass) {
		$sth = $this->db->prepare('SELECT * FROM users
					WHERE users.user = :user AND users.pass = :pass');
		$sth->execute(array(':user' => $user, ':pass' => $pass));
		return $sth->fetch();
	}
		
	public function get($user) {
		$sth = $this->db->prepare('SELECT * FROM users WHERE users.user = :user');
		$sth->execute(array(':user' => $user));
		return $sth->fetch();
	}
	
	private function prepare_filters($filter, $where=false) {
		$filters = array();
		$filter_query = '';
		if (isset($filter['user'])) {
			$filter_query .= ' AND users.user LIKE :filter_user';
			$filters[':filter_user'] = '%'.$filter['user'].'%';
		}
		
		if (isset($filter['name'])) {
			$filter_query .= ' AND users.name LIKE :filter_name';
			$filters[':filter_name'] = '%'.$filter['name'].'%';
		}
		
		if (isset($filter['mail'])) {
			$filter_query .= ' AND users.mail LIKE :filter_mail';
			$filters[':filter_mail'] = '%'.$filter['mail'].'%';
		}
		
		//http://stackoverflow.com/questions/1252693/using-str-replace-so-that-it-only-acts-on-the-first-match
		if ($where) {
			//replace first AND with WHERE
			$needle = 'AND';
			$pos = strpos($filter_query, $needle);
			if ($pos !== false) {
				$filter_query = substr_replace($filter_query, 'WHERE', $pos, strlen($needle));
			}
		}
				
		return array($filters, $filter_query);
	}
	
	public function count($filter=array()) {
		$f = $this->prepare_filters($filter, true);
		$q = 'SELECT COUNT(*)
			FROM users '.$f[1];

		$sth = $this->db->prepare($q);
		
		$vals = array();
		$sth->execute(array_merge($vals, $f[0]));
		$count = $sth->fetchColumn();
		
		return (int)$count;
	}
	
	public function get_all($start=0, $limit=0, $filter=array()) {
		if (!is_int($limit) || $limit < 0) {
			$limit = 0;
		}
		if (!is_int($start) || $start < 0) {
			$start = 0;
		}
		
		$f = $this->prepare_filters($filter, true);
		$q = 'SELECT * FROM users '.$f[1];

		if ($limit > 0) {
			$q .= ' LIMIT ' . $limit . ' OFFSET ' . $start;
		}
		
		$sth = $this->db->prepare($q);	
		$vals = array();
		
		$sth->execute(array_merge($vals, $f[0]));
		
		return $sth->fetchAll();
	}
	
	public function add($user, $pass, $name, $mail) {
		$sth = $this->db->prepare('INSERT INTO users (user, pass, name, mail) VALUES (:user, :pass, :name, :mail)');
		
		return $sth->execute(array(':user' => $user,
							':pass' => $pass,
							':name' => $name,
							':mail' => $mail));
	}
	
	public function is_protected($user) {
		$sth = $this->db->prepare('	SELECT users.global_perms FROM users
									WHERE users.user = :user');
		$sth->execute(array(':user' => $user));
		$global_perms = $sth->fetchColumn();
		if ($global_perms === false) {
			throw new Exception("user doesn't exist in database");
		}
		$global_perms = (int)$global_perms;
		if ($global_perms > 0) {
			return true;
		}
		return false;
	}
	
	public function update($user, $data) {
		$update_query = array();
		$execute_values = array();
		foreach ($data as $key => $value) {
			if (in_array($key, $this->fields)) {
				$update_query[] = $key.'=:'.$key;
				$execute_values[':'.$key] = $value;
			}
		}
		//nothing to update
		if (count($update_query) === 0) {
			return true;
		}
		
		$execute_values[':old_user'] = $user;
		$q = 'UPDATE users SET
								'.implode(',', $update_query).'
								WHERE user=:old_user';
								
		$sth = $this->db->prepare($q);
		return $sth->execute($execute_values);
	}
}
