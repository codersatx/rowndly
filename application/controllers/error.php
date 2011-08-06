<?php

class Error extends Public_Controller{
	
	public function error_404()
	{
		$this->render(NULL, NULL, 'login', 'error', 'error_404');
	}
}