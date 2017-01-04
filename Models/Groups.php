<?php

require_once 'Factory.php';
class Groups extends Factory
{
	public function get($user) {
		$sth = $this->db->prepare('SELECT group_name
			FROM groups JOIN users ON groups.user = users.id
						JOIN domains ON groups.domain = domains.id
			WHERE 	groups.blocked = 0 AND
					users.user = :user AND domains.domain = :domain');
		
		$sth->execute(array(':user' => $user, ':domain' => $this->domain));
		$groups = $sth->fetchColumn();
		if ($groups === false) {
			return array();
		}
		
		$groups_array = explode(',', $groups);
		return $groups_array;
	}
	
	public function exists($user) {
		$sth = $this->db->prepare('SELECT COUNT(*)
			FROM groups	JOIN users ON groups.user = users.id
						JOIN domains ON groups.domain = domains.id
			WHERE 	groups.blocked = 0 AND
					users.user = :user AND domains.domain = :domain');
		
		$sth->execute(array(':user' => $user, ':domain' => $this->domain));
		$numrows = (int)$sth->fetchColumn();
		if ($numrows === 1) {
			return true;
		} else if ($numrows === 0) {
			return false;
		} else {
			throw new Exception('there is more than one user with nick: '.$user);
		}
	}
	
	public function domain_admin($user) {
		$grps = $this->get($user);
		if (in_array('admin', $grps)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_user($user, $grps) {
		if (!is_array($grps)) {
			throw new Exception('no grups provided');
		}
		$grps_str = implode(',', $grps);
		
		$sth = $this->db->prepare('INSERT INTO groups(user, domain, group_name)
			VALUES (
				(SELECT users.id FROM users WHERE users.user=:user),
				(SELECT domains.id FROM domains WHERE domains.domain=:domain),
				:group_name)');
		return $sth->execute(array(':user' => $user,
								':domain' => $this->domain,
								':group_name' => $grps_str));
	}
	
	public function update($user, $grps) {
		if (!is_array($grps)) {
			throw new Exception('no grups provided');
		}
		$grps_str = implode(',', $grps);
		
		$sth = $this->db->prepare('UPDATE groups SET group_name=:group_name 
			WHERE 
		groups.user = (SELECT users.id FROM users WHERE users.user=:user) AND
		groups.domain = (SELECT domains.id FROM domains WHERE domains.domain=:domain)');
		return $sth->execute(array(':user' => $user,
								':domain' => $this->domain,
								':group_name' => $grps_str));
	}
	
	public function block($user) {
		$sth = $this->db->prepare('UPDATE groups SET blocked=1 WHERE
			groups.user = (SELECT users.id FROM users WHERE users.user=:user)'); 
		return $sth->execute(array(':user' => $user));
	}
}
