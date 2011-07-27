<?php

class Add_is_admin extends Migration{
	
	public function up()
	{
		if ( ! field_exists('is_admin','users'))
		{
			$fields = array('is_admin'=>array('type'=>'tinyint','constraint'=>'4'));
			add_columns($fields, 'users');
			return 'Added is_admin to Users table.';
		}
		return 'The is_admin field already exists.';
	}
	
	public function down()
	{
		if (field_exists('is_admin', 'users'))
		{
			drop_columns($fields, 'users');
			return 'The is_admin field dropped.';
		}
		return 'The is_admin field does not exist.';
	}
}