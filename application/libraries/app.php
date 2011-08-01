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
	
	public static function get_post_values($skip = array())
	{
		$object = new stdClass;
		$not_these = array('submit');
		foreach($_POST as $key=>$val)
		{
			if ( ! in_array($key, $not_these) && ! in_array($key, $skip))
			{
				$object->$key = self::$ci->input->post($key);
			}
		}
		return $object;
	}
	
	public static function set_flash($notice, $type = 'notice')
	{
		$flash = self::$ci->session->set_flashdata(array('notice'=>$notice, 'notice_type'=>$type));
		return $flash;
	}
	
	public static function get_flash($key)
	{
		return self::$ci->session->flashdata($key);
	}
	
	public static function div($string, $attributes = array())
	{
		$out = '<div ';
		$out .= self::parse_attributes($attributes);
		$out .= '>'. $string .'</div>';
		return $out;
	}
	
	public static function span($string, $attributes = array())
	{
		$out = '<span ';
		$out .= self::parse_attributes($attributes);
		$out .= '>'. $string .'</span>';
		return $out;
	}
	
	public static function parse_attributes($attributes)
	{
		$out = '';
		foreach($attributes as $key=>$value)
		{
			$out .= $key .'="'. $value .'" ';	
		}
		return $out;
	}
	
	public static function is_post()
	{
	   	$method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST')
        {
            return TRUE;
        }
        return FALSE;
	}
	
	public static function div_open($attributes = array())
	{
		return '<div '. self::parse_attributes($attributes) .'>';
	}
	
	public static function div_close()
	{
		return '</div>';
	}
	
	public static function get_current_url()
	{
		$out = "http://". $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 	return $out;
	}
	
	public static function requires_login()
	{
		if ( ! self::$ci->auth->is_logged_in())
		{
			session_start();
			$_SESSION['requested_url'] = self::get_current_url();
			redirect('users/login');
		}
	}
	
	//--------------------------------------------------------------------------
	/**
	* Gravatar
	*
	* Fetches a gravatar from the Gravatar website using the specified params
	*
	* @access  public
	* @param   string
	* @param   string
	* @param   integer
	* @param   string
	* @return  string
	*/
	public static function gravatar( $email, $rating = 'X', $size = '80', $default = 'http://gravatar.com/avatar.php' ) {
	    # Hash the email address
	    $email = md5( $email );
		self::$ci->load->helper('html');
	    # Return the generated URL
	    return img("http://gravatar.com/avatar.php?gravatar_id="
	        .$email."&amp;rating="
	        .$rating."&amp;size="
	        .$size."&amp;default="
	        .$default);
	}
	
	public static function session($key)
	{
		return self::$ci->session->userdata($key);
	}
	
	public function show_js_message($message, $type = "success")
	{
		$code = '<script type="text/javascript">';
		$code .= 'show_message("'.$message.'","'. $type .'");';
		$code .= '</script>';
		return $code;
	}
}
app::init();