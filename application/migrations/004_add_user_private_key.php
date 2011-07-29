<?php

class Add_user_private_key extends Migration{
	
	public function up()
	{
		if ( ! field_exists('private_key','users'))
		{
			$fields = array('private_key'=>array('type'=>'varchar','constraint'=>'255'));
			add_columns($fields, 'users');
			return 'Added private_key  to Users table.';
		}
		return 'The private_key field already exists.';
	}
	
	public function down()
	{
		if (field_exists('private_key', 'users'))
		{
			drop_columns('private_key', 'users');
			return 'The private_key field dropped.';
		}
		return 'The private_key  field does not exist.';
	}
}