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
		$this->_send_invite($user->email);
		redirect('/beta/index/1');
	}
	
	private function _send_invite($email)
	{
		$this->load->helper('send_email');
		$message = '<p>Hi. Thank you for your interest in our private beta.</p>';
		$message .= '<p>Below you will find a link to register.</p>';
		$message .= '<p>Feel free to register for the service.</p>';
		$message .= '<p>If you find any bugs or other issues please submit them to:</p>';
		$message .= '<p>codersatx@gmail.com</p>';
		$message .= '<p>Register for Rowndly:</p>';
		$message .= '<p>http://rowndly.com/register</p>';
		$message .= '<p>Alex Garcia</p>';
		send_email('Alex Garcia', 'codersatx@gmail.com', $email, 'Rowndly Invite', $message);
	}
}