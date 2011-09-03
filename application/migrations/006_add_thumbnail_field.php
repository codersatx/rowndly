<?php

class Add_thumbnail_field extends Migration{
	
	public function up()
	{
		if ( ! field_exists('show_thumbnails', 'users'))
		{
			$fields = array(
				'show_thumbnails'=>array('type'=>'TINYINT','constraint'=>'4'),
				);
			add_columns($fields, 'users');
			return 'Added show_thumbnails to Users table.';

		}
		return 'The show_thumbnails field already exists.';
	}
	
	public function down()
	{
		if (field_exists('show_thumbnails', 'users'))
		{
			drop_columns('show_thumbnails', 'users');
			return 'The show_thumbnails field was dropped from Users.';
		}
		return 'The show_thumbnails fields does not exist in Users.';
	}
}