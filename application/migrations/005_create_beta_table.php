<?php

class Create_beta_table extends Migration{
	
	public function up()
	{
		if ( ! table_exists('beta'))
		{
			$fields = array(
				'id'=>array('type'=>'INT','constraint'=>'5','auto_increment'=>TRUE),
				'email'=>array('type'=>'VARCHAR','constraint'=>'255'),
				'date_registered'=>array('type'=>'DATETIME')
				);
			$this->ci->load->dbforge();
			$this->ci->dbforge->add_key('id', TRUE);
			$this->ci->dbforge->add_field($fields);
			$this->ci->dbforge->create_table('beta');
			return 'Created beta table.';
		}
		return 'The beta table already exists.';
	}
	
	public function down()
	{
		if (table_exists('beta'))
		{
			$this->ci->load->dbforge();
			$this->ci->dbforge->drop_table('beta');
			return 'The beta table dropped.';
		}
		return 'The beta table does not exist.';
	}
}