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
}