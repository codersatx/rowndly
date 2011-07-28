<?php
/**
 * Handles database migrations.
 *  
 * @author Alex Garcia
 */
class Migrate extends Public_Controller{
	
	//-----------------------------------------------------------------
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbforge();
		$this->load->helper('directory');
		$user = $this->session->userdata('user');
		if (is_object($user))
		{
			if ($user->is_admin == '')
			{
				redirect('users/login');
			}
		}
		else
		{
			redirect('users/login');
		}
	}
	
	//-----------------------------------------------------------------
	
	/**
	 * Up
	 * Handles migrating our database up to the latest version of our
	 * schema or to a specific one we define.
	 * 
	 * @param int $to_version The version we want to migrate up to. 
	 * @return void
	 * @todo Only allow this to run on a post not a get request to make 
	 * sure we don't call the function from the url.
	 */
	public function up($to_version = NULL)
	{
		$map = directory_map(APPPATH .'migrations/');
		sort($map);
		$migration_version = $this->_get_migration_version();
		foreach($map as $file)
		{
			$version = preg_replace("/[^0-9\s]/", "", $file);
			$condition = $version > $migration_version;
			
			if ($to_version != NULL)
			{
				$condition = $version > $migration_version && $version <= $to_version;
			}
			
			if ($condition)
			{
				$class = preg_replace("/[^a-zA-Z_.\s]/", "", $file);
				$class = ltrim($class, '_');
				$class = ucfirst(str_replace('.php', '', $class));
				include_once('application/migrations/'.$file);
				$o = new $class();
				$messages[] = $o->up();
				unset($o);
				$this->_set_migration_version($version);
				$migration_version = $version; 
			}
		}
		$messages[] = 'Up to date at version: '. $migration_version;
		app::debug($messages);
	}
	
	//-----------------------------------------------------------------
	
	/**
	 * Down
	 * Handles migrating down to specific schema version. If left empty the 
	 * schema will be migrated down to the beginning.
	 * 
	 * @param int $to_version The version we want to migrate down to.
	 * @return void
	 * @todo Only allow this to run on a post not a get request to make 
	 * sure we don't call the function from the url.
	 */
	public function down($to_version = '000')
	{
		//Get the latest schema version
		$schema_version = $this->_get_migration_version();
		
		if ($schema_version < $to_version)
		{
			$messages[] = 'The schema is at version:'. $schema_version .' but you requested to go down to '. $to_version .'.';
		}
		else
		{
			$map = directory_map(APPPATH .'migrations/');
			foreach($map as $file)
			{
				$version = preg_replace("/[^0-9\s]/", "", $file);
				if($version > $to_version)
				{
					$class = preg_replace("/[^a-zA-Z_.\s]/", "", $file);
					$class = ltrim($class, '_');
					$class = ucfirst(str_replace('.php', '', $class));
					include_once('application/migrations/'.$file);
					$o = new $class();
					$messages[] = $o->down();
					unset($o);
					$this->_set_migration_version($to_version);
				}
		
			}
			
			$messages[] = 'The schema is now at version:'. $to_version;
		}
		
		app::debug($messages);
	}
	
	//-----------------------------------------------------------------
	
	private function _set_migration_version($version)
	{
		$this->db->where('id','1');
		return $this->db->update('migration', array('version'=>$version));
	}
	
	//-----------------------------------------------------------------
	
	private function _get_migration_version()
	{
		$this->db->where('id','1');
		$this->db->select('version');
		$result = $this->db->get('migration')->row();
		return $result->version;
	}
}