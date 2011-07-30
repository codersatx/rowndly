<?php
class Auth_Controller extends Public_Controller{
	
	public $user;
	
	/**
     * Sets up the class.
     */
    public function __construct()
    {
        parent::__construct();
		app::requires_login();
		$this->load->model(array('rownd'));
		$session_user = $this->session->userdata('user');
		$this->user = $this->user->find($session_user->id)->result;
		foreach($this->user as $key=>$value)
		{
			$this->session->set_userdata(array($key=>$value));
		}
    }
}