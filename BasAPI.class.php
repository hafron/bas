<?php
require_once 'API.class.php';
require_once 'Model.class.php';

class BasAPI extends API
{
    private $Model;
    
    private $domain, $user, $password_hash;

    public function __construct($request, $origin) {
        parent::__construct($request);

        if (!array_key_exists('token', $this->request)) {
			throw new Exception('No token provided.');
		}
				
		$token = explode(':', $this->request['token']);
		if (count($token) !== 2) {
			throw new Exception('Invalid token');
		}
        
        $this->domain = $_SERVER['HTTP_ORIGIN'];
        $this->user = $token[0];
        $this->password_hash = $token[1];
        		
        $this->Model = new Model($this->domain);
        if (!$this->Model->groups->exists($this->user)) {
			throw new Exception('User not registered in the origin domain.');
		}
		
		if (!$this->Model->users->checkPass($this->user, $this->password_hash)) {
			throw new Exception('Invalid user name or password.');
		}
    }
    
    private function getUserInfo($user) {
		$user_info = $this->Model->users->get($user);
		if ($user_info === false) {
			throw new Exception('User not exists in the origin domain.');
		}
		$groups = $this->Model->groups->get($user);
		return array(	
			'name' => $user_info['name'],
			'mail' => $user_info['mail'],
			'grps' => $groups
		);
	}
	
	private function getAllUsers($start, $limit, $filter) {
		$users = $this->Model->users->get_all($start, $limit, $filter);

		$users_with_groups = array();
		foreach ($users as $user) {
			$groups = $this->Model->groups->get($user['user']);
			$info = array(
				'name' => $user['name'],
				'mail' => $user['mail'],
				'grps' => $groups
			);
			$users_with_groups[$user['user']] = $info;
		}
		return $users_with_groups;
	}
	
	private function getUserFilter() {
		$filter = array();
		$fields = array('user', 'name', 'mail', 'grps');
		
		foreach ($fields as $f) {
			if (isset($this->request[$f])) {
				$filter[$f] = $this->request[$f];
			}
		}
		
		return $filter;
	}
	
	private function getFromRequest($name) {
		if (!isset($this->request[$name])) {
			throw new Exception($name.' required');
		}
		return $this->request[$name];
	}
    
    protected function users() {
		$metaonly = false;
		if (isset($this->request['metaonly'])) {
			$metaonly = true;
		}
		
		if ($this->method === 'GET') {
			// users/name
			if ($this->verb !== '') {
				$user = $this->verb;
				return $this->getUserInfo($user);
			} else {
				
				$filter = $this->getUserFilter();
				
				$result =
				array('meta' => 
					array(
						'count' => $this->Model->users->count($filter)
						)
					);
				
				if ($metaonly) {
					return $result;
				}
	
				$start = $limit = 0;
				if (isset($this->request['start'])) {
					$start = $this->request['start'];
				}
				if (isset($this->request['limit'])) {
					$limit = $this->request['limit'];
				}
				$result['data'] = $this->getAllUsers($start, $limit, $filter);
				
				return $result;
			} 
		} elseif ($this->method === 'POST') {		
			if (!$this->Model->groups->domain_admin($this->user)) {
				throw new Exception('createUser: no permission');
			}
		
			$user = $this->getFromRequest('user');
			$password_hash = $this->getFromRequest('password_hash');
			$name = $this->getFromRequest('name');
			$mail = $this->getFromRequest('mail');
			$grps = $this->getFromRequest('grps');

			$this->Model->db->beginTransaction();
			try {
				$this->Model->users->add($user, $password_hash, $name, $mail);
				$this->Model->groups->add_user($user, $grps);
				
				$this->Model->db->commit();
				return array('success' => 'user created: '.$user);
			} catch(Exception $e) {
				$this->Model->db->rollBack();
				throw $e;
			}
		} elseif ($this->method === 'PUT') {
			$user = $this->verb;
			
			if ($user === '') {
				throw new Exception("you don't specify user you want to change");
			}
			if (!$this->Model->groups->domain_admin($this->user) &&
				!$user === $this->user) {
				throw new Exception('update user: no permission');
			}
			if (!$this->Model->groups->exists($user)) {
				throw new Exception('update user: user does not exists in the domain');
			}
			if ($this->Model->users->is_protected($user)) {
				throw new Exception('update user: user protected');
			}
			
			$data_keys = array('user', 'password_hash', 'name', 'mail');
			$data = array();
			$grps = '';
			
			foreach ($this->request as $key => $value) {
				if ($key === 'grps') {
					$grps = $value;
				} else if (in_array($key, $data_keys)) {
					$data[$key] = $value;
				}
			}
						
			$this->Model->db->beginTransaction();
			try {
				$this->Model->users->update($user, $data);
				if ($grps !== '') {
					$this->Model->groups->update($user, $grps);
				}
				$this->Model->db->commit();
				return array('success' => 'user modified: '.$user);
			} catch(Exception $e) {
				$this->Model->db->rollBack();
				throw $e;
			}
		} elseif ($this->method === 'DELETE') {
			$user = $this->verb;
			
			if ($user === '') {
				throw new Exception("you don't specify user you want to delete");
			}
			if (!$this->Model->groups->domain_admin($this->user) &&
				!$user === $this->user) {
				throw new Exception('delete user: no permission');
			}
			if (!$this->Model->groups->exists($user)) {
				throw new Exception('delete user: user does not exists in the domain');
			}
			if ($this->Model->users->is_protected($user)) {
				throw new Exception('delete user: user protected');
			}
			
			$this->Model->groups->block($user);
			return array('success' => 'user blocked: '.$user);
		}
	}
}
