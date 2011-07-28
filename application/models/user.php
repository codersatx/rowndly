<?php

class User extends Orm{
	
	public function __construct()
	{
		parent::__construct();
		$this->has_many = array('user');
	}
	
	public function check_username($username)
	{
		$this->db->where('username', $username);
		$result = $this->db->get($this->table);
		if ($result->num_rows() == 0)
		{
			return TRUE;
		}
		return FALSE;
	}
	
	public function change_password($data)
	{
		$user = $this->session->userdata('user');
		$current_password = sha1($data['current_password']);
		$password = sha1($data['password']);
		$user = $this->find($user->id);
		if (is_object($user))
		{
			$user = $user->result;
			if ($current_password == $user->password)
			{
				$this->db->where('id', $user->id);
				return $this->db->update('users', array('password'=>$password));
			}
		}
		return FALSE;
	}
}