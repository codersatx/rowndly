<?php
class Users extends Public_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user');
	}
	
	public function index()
	{
		$this->render();	
	}
	
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
				$redirect = $_SESSION['requested_url'];
				echo json_encode(array('status'=>'OK','redirect'=>$redirect));
				return;
			}
			else
			{
				echo json_encode(array('status'=>'NOT OK'));
				return;
			}
		}
		
		$this->render();
	}
	
	public function register()
	{
		$data['head_title'] = 'Register';
		$this->form_validation->set_error_delimiters('<div class="registration error">', '</div>');
		$this->form_validation->set_rules('first_name', 'First Name');
		$this->form_validation->set_rules('last_name', 'Last Name');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[6]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|min_length[6]');
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->render($data);
		}
		else
		{
			$values = app::get_post_values(array('confirm_password'));
			$values->created_at = date('Y-m-d h:i:s');
			$values->is_active = TRUE;
			$values->is_admin = FALSE;
			if ($this->user->check_username($values->username))
			{
				$this->user->save($values);
				redirect('users/login');
				
			}
			else
			{
				$data['custom_error_message'] = 'The username you selected already exists.';
				$this->render($data);
			}
		}
	}
	
	public function logout()
	{
		unset($user);
		$this->session->set_userdata(array('user'=>''));
		$this->session->sess_destroy();
		redirect('users/login');
	}
	
	
	public function my_account()
	{
		$user = $this->session->userdata('user');
		$data['user'] = $this->user->find($user->id)->result;
		$data['head_title'] = 'Register';
		$this->form_validation->set_error_delimiters('<div class="registration error">', '</div>');
		$this->form_validation->set_rules('first_name', 'First Name');
		$this->form_validation->set_rules('last_name', 'Last Name');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[6]');
	
		if ($this->form_validation->run() === FALSE)
		{
			$this->render($data);
		}
		else
		{
			$values = app::get_post_values(array('created_at','password','confirm_password','is_active','is_admin'));
			$values->updated_at = date('Y-m-d h:i:s');
			$values->id = $user->id;
	
			if($values->username != $user->username)
			{
				if ($this->user->check_username($values->username))
				{
					$this->user->save($values);
					redirect('users/my_account');
				}
				else
				{
					$data['custom_error_message'] = 'The username you selected already exists.';
					$this->render($data);
					return;
				}
			}
			else
			{
					$this->user->save($values);
					redirect('users/my_account');
			}
		}
	}
	
	public function change_password()
	{
		$user = $this->session->userdata('user');
		$data['head_title'] = 'Change Password';
		$this->render($data);
		
		
	}
}