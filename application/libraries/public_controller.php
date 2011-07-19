<?php

class Public_Controller extends CI_Controller{
	
	/**
     * Sets up the class.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Renders the content within the default theme.
     * @return void
     */
    public function render($data = array(), $view = NULL)
    {
		$controller = app::segment(1) ? app::segment(1) : 'rownds';;
		$method = app::segment(2) ? app::segment(2) : 'index';
		if ($view == NULL)
		{
			$view = $controller .'/'. $method;
		}
		$this->load->view($view, $data);
    }
}