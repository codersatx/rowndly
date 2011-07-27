<?php

class Auth{
	
	public $ci;
	
	public function __construct()
	{
		$this->ci = get_instance();
	}
	
	public function login($username, $password)
	{
		$this->ci->db->where('username', $username);
		$this->ci->db->where('password', sha1($password));
		$this->ci->db->where('is_active', TRUE);
		$result = $this->ci->db->get('users');
		if ($result->num_rows() == 1)
		{
			$user = $result->row();
			unset($user->password);
			$this->ci->session->set_userdata(array('user'=>$user));
			//app::debug($this->ci->session->userdata('user'));
			return TRUE;
		}
		return FALSE;
	}
	
	public function is_logged_in()
	{
		$user = $this->ci->session->userdata('user');
		if (isset($user->id))
		{
			return TRUE;
		}
		return FALSE;
	}
}