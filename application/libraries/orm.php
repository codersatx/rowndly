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
		$this->object = new stdClass;
	}
	
	public function all($order_by = array(), $conditions = array())
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
			
			if (count($conditions) > 0)
			{
				foreach($conditions as $column => $value)
				{
					$this->db->where($column, $value);
				}
			}
			
			$result = $this->db->get();
			if ($result->num_rows() > 0)
			{
				$this->object->result = $result->result();
				return $this->object;
			}
			else
			{
				return FALSE;
			}
			
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
			if ($result->num_rows() > 0)
			{
				$this->object->result = $result->result();
				return $this->object;
			}
			else
			{
				return FALSE;
			}
		}
		
		
	}
	
	public function find($id, $conditions = array())
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
			
			if (count($conditions) > 0)
			{
				foreach($conditions as $column => $value)
				{
					$this->db->where($column, $value);
				}
			}
			$this->db->where($this->table.'.id', $id);
			$result = $this->db->get();
			if ($result->num_rows() > 0)
			{
				$this->object->result = $result->result();
				return $this->object;
			}
			else
			{
				return FALSE;
			}
			
		}
		else
		{	
			$this->db->where('id', $id);
			$result = $this->db->get($this->table);
			if ($result->num_rows() === 1)
			{
				$this->object->result = $result->row();
				return $this->object;
			}
			else
			{
				return FALSE;
			}
		}
	}
	
	public function find_max($column_name)
	{
		$this->db->select_max('sort_order');
		$result = $this->db->get($this->table);
		return $result->row_array();
	}
	
	public function save($object)
	{	
		if (isset($object->id))
		{
			$this->db->where('id', $object->id);
			$result = $this->db->update($this->table, $object);
		}
		else
		{
			$result = $this->db->insert($this->table, $object);
		}
		
		return $result;
	}
	
	
	public function destroy($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete($this->table);
	}
}