<?php

class Add_allow_public extends Migration{
	
	public function up()
	{
		if ( ! field_exists('allow_public','users'))
		{
			$fields = array('allow_public'=>array('type'=>'tinyint','constraint'=>'4'));
			add_columns($fields, 'users');
			return 'Added allow_public to Users table.';
		}
		return 'The allow_public field already exists.';
	}
	
	public function down()
	{
		if (field_exists('allow_public', 'users'))
		{
			drop_columns('allow_public', 'users');
			return 'The allow_public field dropped.';
		}
		return 'The allow_public field does not exist.';
	}
}