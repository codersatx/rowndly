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