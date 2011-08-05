<?php

class Beta extends Public_Controller{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index($status = NULL)
	{
		$data['status'] =  $status;
		$this->render($data, NULL, 'beta');
	}
	
	public function sign_up()
	{
		$email = $this->input->post('email');
		$user = new stdClass();
		$user->email = $this->input->post('email');
		$user->date_registered = date('Y-m-d H:i:s');
		$this->db->insert('beta', $user);
		redirect('/beta/index/1');
	}
}