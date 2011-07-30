<?php

class Public_Controller extends CI_Controller{
	
	/**
     * Sets up the class.
     */
    public function __construct()
    {
        parent::__construct();
		$data['user'] = $this->session->userdata('user');
		$this->load->vars($data);
    }

    /**
     * Renders the content within the default theme.
     * @return void
     */
    public function render($view_data = array(), $view = NULL)
    {
		$controller = app::segment(1) ? app::segment(1) : 'rownds';;
		$method = app::segment(2) ? app::segment(2) : 'index';
		if ($view == NULL)
		{
			$view = $controller .'/'. $method;
		}
		
		$template_data['head_title'] = isset($view_data['head_title']) ? $view_data['head_title'] : 'rowndly - my daily rownds of sites I visit';
		$template_data['head_description'] 	= isset($view_data['head_description']) ? $view_data['head_description'] : 'A place to save a list of sites you visit everyday.';
		$template_data['content'] = $this->load->view($view, $view_data, TRUE);
		$this->load->view('layouts/template', $template_data);
    }
}