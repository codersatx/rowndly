<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rownd extends Orm{

	public function __construct()
	{
		parent::__construct();
		$this->belongs_to = array('user');
	}
	
	public function update_position($id, $position)
	{
		$this->db->where('id',$id);
		$this->db->update('rownds', array('sort_order'=>$position));
	}
	
	public function find_by_user($user_id)
	{
		$result = $this->db->select('title, url, last_visited')
				 ->where('user_id', $user_id)
				 ->order_by('sort_order','asc')
				 ->get('rownds');
		return $result;
	}

}