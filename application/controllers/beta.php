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
	
	public function send_invite($email = 'codersatx@gmail.com')
	{
		$this->load->helper('send_email');
		$message = '<p>Hi. Thank you for your interest in our private beta.</p>';
		$message .= '<p>Below you will find a link to register. Feel free to register';
		$message .= 'and play with the service. If you find any bugs please submit them to:</p>';
		$message .= '<p>ticket+rowndly.80138-6engsjz6@lighthouseapp.com</p>';
		$message .= '<p>Register for Rowndly:</p>';
		$message .= '<p>http://rowndly.com/register</p>';
		$message .= '<p>Alex Garcia</p>';
		send_email('Alex Garcia', 'codersatx@gmail.com', $email, 'Rowndly Invite', $message);
	}
}