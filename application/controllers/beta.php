<?php

class Beta extends Public_Controller{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->render(NULL, NULL, 'beta');
	}
}