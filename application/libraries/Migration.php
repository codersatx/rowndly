<?php

class Migration{
	
	public $ci;
	
	public function __construct()
	{
		$this->ci = get_instance();
	}
	
	public function field_exists($field, $table)
	{
		return $this->ci->db->field_exists($field, $table);
	}
	
	public function table_exists($table)
	{
		return $this->ci->db->table_exists($table);
	}
	
	public function create_table($table)
	{
		$this->ci->load->dbforge();
		return $this->ci->dbforge->create_table($table);
	}
	
	public function drop_table($table)
	{
		$this->ci->load->dbforge();
		return $this->ci->dbforge->drop_table($table);
	}
}

function create_table($table)
{
	$migration = new Migration();
	return $migration->create_table($table);
}

function drop_table($table)
{
	$migration = new Migration();
	return $migration->drop_table($table);
}

function table_exists($table)
{
	$migration = new Migration();
	return $migration->table_exists($table);
}

function field_exists($field, $table)
{
	$migration = new Migration();
	return $migration->field_exists($field, $table);
}

function add_columns($fields, $table)
{
	$migration = new Migration();
	if ($migration->ci->dbforge->add_column($table, $fields))
	{
		return TRUE;
	}
	return FALSE;
}

function drop_columns($fields, $table)
{
	$migration = new Migration();
	if ($migration->ci->dbforge->drop_column($table, $fields))
	{
		return TRUE;
	}
	return FALSE;
}