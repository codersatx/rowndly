<?php

class Rownd extends Orm{

	public function __construct()
	{
		parent::__construct();
		$this->belongs_to = array('user','group');
	}
	
	public function update_position($id, $position)
	{
		$this->db->where('id',$id);
		$this->db->update('rownds', array('sort_order'=>$position));
	}

}