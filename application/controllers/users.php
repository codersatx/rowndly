<?php
class Users extends Public_Controller{
	
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
				echo 'OK';
				return;
			}
			else
			{
				echo 'NOT OK';
				return;
			}
		}
		
		$this->render();
	}
	
	public function register()
	{
		$data['head_title'] = 'Register';
		$this->load->model('user');
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
}