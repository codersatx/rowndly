<?php

class Orm extends CI_Model{
	
	public $table;
	public $fields;
	public $object;
	public $belongs_to;
	public $has_many;
	
	public function __construct()
	{
		parent::__construct();
		$this->table = strtolower(plural(get_class($this)));
		$this->fields = $this->db->list_fields($this->table);
	}
	
	public function all($order_by = array())
	{
		if ( count($this->belongs_to) > 0)
		{
			$this->db->select($this->table.'.*');
			$this->db->from($this->table);
			foreach($this->belongs_to as $model)
			{
				$model = plural($model);
				$model_fields = array_slice($this->db->list_fields($model), 1);
				$this->db->select($model_fields);
				$this->db->join($model, $model.'.id = '. $this->table.'.'. singular($model) .'_id', 'left');
			}
			
			if ( count($order_by) > 0 )
			{
				foreach($order_by as $column => $direction)
				{
					$this->db->order_by($column, $direction);
				}
			}
			$result = $this->db->get();
			$this->object = $result->result();
		}
		else
		{
			if ( count($order_by) > 0 )
			{
				foreach($order_by as $column => $direction)
				{
					$this->db->order_by($column, $direction);
				}
			}
			$result = $this->db->get($this->table);
			$this->object = $result->result();
		}
		
		return $this->object;
	}
	
	public function find($id)
	{
		$this->db->where('id', $id);
		$result = $this->db->get($this->table);
		$this->object = $result->result();
		return $this->object[0];
	}
	
	public function find_where($conditions = array())
	{
		if ( count($conditions > 0))
		{
			foreach($conditions as $condition => $value)
			{
				$this->db->where($condition, $value);
			}
		}
		$result = $this->db->get($this->table);
		$this->object = $result->result();
		return $this->object;
	}
	
	public function save()
	{
		$not_these = array('submit');
		foreach($_POST as $key=>$val)
		{
			if ( ! in_array($key, $not_these))
			{
				$object->$key = $this->input->post($key);
			}
		}
		
		if (isset($object->id))
		{
			$this->db->where('id', $object->id);
			$this->db->update($this->table, $object);
		}
		else
		{
			$this->db->insert($this->table, $object);
		}
		
		
	}
}