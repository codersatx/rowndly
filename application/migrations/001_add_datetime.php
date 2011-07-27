<?php

class Add_datetime extends Migration{

	function up()
	{
		if (! $this->field_exists('last_visited','rownds'))
		{
			$fields = array('last_visited' => array('type'=>'DATETIME'));
			$this->ci->dbforge->add_column('rownds', $fields);
			return 'Added last visited field';
		}
		return 'Last visited field already exists.';
	}
	
	function down()
	{
		if ($this->field_exists('last_visited', 'rownds'))
		{
			$this->ci->dbforge->drop_column('rownds', 'last_visited');
			return 'Dropped last visited column.';
		}
		return 'Last visited column does not exists.';
	}
}
