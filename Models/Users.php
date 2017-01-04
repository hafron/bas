<?php

require_once 'Factory.php';
class Users extends Factory
{
	private $fields = array('id', 'user', 'password_hash', 'name', 'mail', 'global_perms');
	
	public function checkPass($user, $password_hash) {
		$sth = $this->db->prepare('SELECT COUNT(*)
			FROM users WHERE user = :user AND password_hash = :password_hash');
		
		$sth->execute(array(':user' => $user, ':password_hash' => $password_hash));
		$numrows = $sth->fetchColumn();
		if ($numrows > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function get($user) {
		$sth = $this->db->prepare('SELECT users.user, users.name, users.mail
			FROM users	JOIN groups ON users.id = groups.user
						JOIN domains ON groups.domain = domains.id
			WHERE 	groups.blocked = 0 AND
					users.user = :user AND
					domains.domain = :domain');
		$sth->execute(array(':user' => $user, ':domain' => $this->domain));
		return $sth->fetch();
	}
	
	private function prepare_filters($filter) {
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
		
		if (isset($filter['grps'])) {
			$filter_query .= ' AND groups.group_name LIKE :filter_grps';
			$filters[':filter_grps'] = '%'.$filter['grps'].'%';
		}
		
		return array($filters, $filter_query);
	}
	
	public function count($filter=array()) {
		$f = $this->prepare_filters($filter);
		$q = 'SELECT COUNT(*)
			FROM users	JOIN groups ON users.id = groups.user
						JOIN domains ON groups.domain = domains.id
			WHERE 	groups.blocked = 0 AND
					domains.domain = :domain '.$f[1];

		$sth = $this->db->prepare($q);
		$vals = array(':domain' => $this->domain);
		
		$sth->execute(array_merge($vals, $f[0]));
		$count = $sth->fetchColumn();
		return $count;
	}
	
	public function get_all($start=0, $limit=0, $filter=array()) {
		if (!is_int($limit) || $limit < 0) {
			$limit = 0;
		}
		if (!is_int($start) || $start < 0) {
			$start = 0;
		}
		
		$f = $this->prepare_filters($filter);
		$q = 'SELECT users.user, users.name, users.mail
			FROM users	JOIN groups ON users.id = groups.user
						JOIN domains ON groups.domain = domains.id
			WHERE	groups.blocked = 0 AND
					domains.domain = :domain '.$f[1];

		if ($limit > 0) {
			$q .= ' LIMIT ' . $limit . ' OFFSET ' . $start;
		}
		
		$sth = $this->db->prepare($q);	
		$vals = array(':domain' => $this->domain);
		
		$sth->execute(array_merge($vals, $f[0]));
		
		return $sth->fetchAll();
	}
	
	public function add($user, $password_hash, $name, $mail) {
		$sth = $this->db->prepare('INSERT INTO users (user, password_hash, name, mail) VALUES (:user, :password_hash, :name, :mail)');
		
		return $sth->execute(array(':user' => $user,
							':password_hash' => $password_hash,
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
			$update_query[] = $key.'=:'.$key;
			$execute_values[':'.$key] = $value;
		}
		$execute_values[':old_user'] = $user;
		$sth = $this->db->prepare('UPDATE users SET
								'.implode(',', $update_query).'
								WHERE user=:old_user');
		
		return $sth->execute($execute_values);
	}
}
