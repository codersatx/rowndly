<?php

class App{
	
	public static $ci;
	
	public static function init()
	{
		self::$ci = get_instance();
	}

	/**
	 * Returns the value of the segment in the number variable. This is a shortcut
	 * function for the CI function $this->uri->segment(int);
	 * @param string $number
	 * @return string
	 */
	public static function segment($number)
	{
		return self::$ci->uri->segment($number);
	}
	
	//--------------------------------------------------------------------------

	/** 
	 * Debug Helper
	 *
	 * Outputs the given variable(s) with formatting and location.
	 *
	 * Modified by Dan to produce a little prettier output.
	 * Modified by Alex Garcia to use print_r instead of var_dump so I can the array structure better.
	 * 
	 * @author		Phil Sturgeon <http://philsurgeon.co.uk>
	 * @modified	Dan Horrigan
	 * @modified 	Alex Garcia
	 * @link		http://philsturgeon.co.uk/news/2010/09/power-dump-php-applications
	 * @access		public
	 * @param		mixed	Variables to be output
	 */
	public static function debug($array)
	{
		list($callee) = debug_backtrace();
	    $arguments = func_get_args();
	    $total_arguments = count($arguments);

	    echo '<div style="background: #EEE !important; border:1px solid #666; padding:10px;">';
	    echo '<h1 style="border-bottom: 1px solid #CCC; padding: 0 0 5px 0; margin: 0 0 5px 0; font: bold 18px sans-serif;">'.$callee['file'].' @ line: '.$callee['line'].'</h1><pre>';
	    $i = 0;
	    foreach ($arguments as $argument)
	    {
	        echo '<strong>Debug #'.(++$i).' of '.$total_arguments.'</strong>:<br />';
	        print_r($argument);
	        echo '<br />';
	    }

	    echo "</pre>";
	    echo "</div>";
	}
	
	public static function get_post_values()
	{
		$object = new stdClass;
		$not_these = array('submit');
		foreach($_POST as $key=>$val)
		{
			if ( ! in_array($key, $not_these))
			{
				$object->$key = self::$ci->input->post($key);
			}
		}
		return $object;
	}
	
	public static function set_flash($notice, $type = 'notice')
	{
		$flash = self::$ci->session->set_flashdata(array('notice'=>$notice, 'type'=>$type));
		return $flash;
	}
	
	public static function get_flash($key)
	{
		return self::$ci->session->flashdata($key);
	}
	
}

app::init();