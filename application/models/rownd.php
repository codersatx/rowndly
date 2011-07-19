<?php

class Rownd extends Orm{

	public function __construct()
	{
		parent::__construct();
		$this->belongs_to = array('user','group');
	}

}