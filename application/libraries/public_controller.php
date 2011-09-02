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
     * 
     * @param array $view_data An array of data to pass to our view
     * @param string $view The name of the view to load instead of the default view
     * @param string $template The name of the template to load instead of the default template
     * @param string $controller The name of the controller, used in situations where we are 
     * 							using routing and need to define the controller explicitly 
     * 							to override the default behavior
     * @param string $method The name of the method, used in situation where we are using routing
     * 						to define the method name to override the default behavior.
     * 						By default the render function attempts to load the view for the current
     * 						method by looking for a view named the same as the method in a folder
     * 						named the same as the controller.
     * @return void
     */
    public function render($view_data = array(), $view = NULL, $template = NULL, $controller = NULL, $method = NULL)
    {
		if ($controller == NULL)
		{
			$controller = app::segment(1) ? app::segment(1) : 'beta';;
		}
		
		if ($method == NULL)
		{
			$method 	= app::segment(2) ? app::segment(2) : 'index';
		}
		
		if ($view == NULL)
		{
			$view = $controller .'/'. $method;
		}

		$template_data['head_title'] = isset($view_data['head_title']) ? 
											$view_data['head_title'] : 
											'rowndly - my daily rownds of sites I visit';
											
		$template_data['head_description'] 	= isset($view_data['head_description']) ?
													$view_data['head_description'] : 
													'A place to save a list of sites you visit everyday.';
													
		$template_data['content'] = $this->load->view($view, $view_data, TRUE);
		$template = is_null($template) ? 'template' : $template;
		$this->load->view('layouts/'. $template, $template_data);
    }
}