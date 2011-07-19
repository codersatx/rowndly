<?php

class User extends Orm{
	
	public function __construct()
	{
		$this->has_many = array('rownd');
	}
}