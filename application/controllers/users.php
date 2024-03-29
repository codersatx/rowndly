<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Public_Controller{
	
	//-----------------------------------------------------------------
	
	public function __construct()
	{
		parent::__construct();
		$this->form_validation->set_error_delimiters('<div class="account_form message error">', '</div>');
		$data['title'] = 'My Account';
		$this->load->vars($data);
	}
	
	//-----------------------------------------------------------------
	
	public function index()
	{
		redirect('/login');
	}
	
	//-----------------------------------------------------------------
	
	public function login()
	{
		if (app::is_post())
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$result = $this->auth->login($username, $password);
			if ($result == TRUE)
			{
				session_start();
				$redirect = '/rownds';
				if (isset($_SESSION['requested_url']))
				{
					$redirect = $_SESSION['requested_url'];
				}
				$this->output->set_content_type('application/json')
							 ->set_output(json_encode(array('status'=>'OK','redirect'=>$redirect)));
				return;
			}
			else
			{
				$this->output->set_content_type('application/json')
							 ->set_output(json_encode(array('status'=>'NOT OK')));
				return;
			}
		}
		
		$this->render(NULL, NULL, 'login', 'users', 'login');
	}
	
	//-----------------------------------------------------------------
	
	public function register()
	{
		$data['head_title'] = 'Register';
		$data['title'] = 'Register';
		$this->form_validation->set_error_delimiters('<div class="registration error">', '</div>');
		$this->form_validation->set_rules('first_name', 'First Name');
		$this->form_validation->set_rules('last_name', 'Last Name');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[6]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|min_length[6]');
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->render($data, NULL, NULL, 'users', 'register');
		}
		else
		{
			$values = app::get_post_values(array('confirm_password'));
			$values->created_at = date('Y-m-d h:i:s');
			$values->is_active = TRUE;
			$values->is_admin = FALSE;
			$values->password = sha1($values->password);
			if ($this->user->check_username($values->username))
			{
				$this->user->save($values);
				redirect('/login');
				
			}
			else
			{
				$data['custom_error_message'] = 'The username you selected already exists.';
				$this->render($data, NULL, NULL, 'users', 'register');
			}
		}
	}
	
	//-----------------------------------------------------------------
	
	public function logout()
	{
		unset($user);
		$this->session->set_userdata(array('user'=>''));
		$this->session->sess_destroy();
		redirect('/login');
	}
	
	//-----------------------------------------------------------------
	
	public function my_account($status = NULL)
	{
		app::requires_login();
		
		$user = $this->session->userdata('user');
		$data['user'] = $this->user->find($user->id)->result;
		$data['head_title'] = 'My Account';
		$data['status'] = $status;
		$this->form_validation->set_rules('first_name', 'First Name');
		$this->form_validation->set_rules('private_key', 'Private Key');
		$this->form_validation->set_rules('last_name', 'Last Name');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[6]');
	
		if ($this->form_validation->run() === FALSE)
		{
			$this->render($data, NULL, NULL, 'users', 'my_account');
		}
		else
		{	
			$values = app::get_post_values(array('created_at','password','confirm_password','is_active','is_admin'));
			if ( ! isset($values->allow_public))
			{
				$values->allow_public = FALSE;
			}

			if ( ! isset($values->show_thumbnails))
			{
				$values->show_thumbnails = FALSE;
			}
			$values->updated_at = date('Y-m-d h:i:s');
			$values->id = $user->id;
	
			if($values->username != $user->username)
			{
				if ($this->user->check_username($values->username))
				{
					$this->user->save($values);
					$data['message'] = 'Please login again since you changed your username.';
					$data['message_type'] = 'success';
					$this->render($data, NULL, NULL, 'users', 'my_account');
				}
				else
				{
					$data['custom_error_message'] = 'The username you selected already exists.';
					$this->render($data, NULL, NULL, 'users', 'my_account');
					return;
				}
			}
			else
			{
					$this->user->save($values);
					redirect('/my_account/1');
			}
		}
	}
	
	//-----------------------------------------------------------------
	
	public function change_password()
	{
		app::requires_login();
		$data['head_title'] = 'Change Password';
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|min_length[6]');
		
		if ($this->form_validation->run() === FALSE)
		{
			$user = $this->session->userdata('user');
			$this->render($data, NULL, NULL, 'users', 'change_password');
		}
		else
		{
			$db_data['current_password'] = $this->input->post('current_password');
			$db_data['password'] = $this->input->post('password');
			$result = $this->user->change_password($db_data);
			if($result)
			{
				$data['message'] = 'Your password was changed successfully.';
				$data['message_type'] = 'success';
				$this->render($data, NULL, NULL, 'users', 'change_password');
			}
			else
			{
				$data['message'] = 'Please enter your current password.';
				$data['message_type'] = 'error';
				$this->render($data, NULL, NULL, 'users', 'change_password');
			}
		}
	}
	
	public function is_logged_in()
	{
		if(app::is_ajax())
		{
			if($this->auth->is_logged_in())
			{
				$status = 'yes';
			}
			else
			{
				$status = 'no';
			}
			$this->output->set_content_type('plain/text')
			 			 ->set_output($status);
		}
	}
}