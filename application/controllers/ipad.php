<?php
/**
 * Rownds
 * 
 * Handles the display and management of rownds. Extends the auth controller
 * since we need users to be logged in to view this resource.
 * 
 * @author Alex Garcia
 */
class Ipad extends Public_Controller{

	//------------------------------------------------------------------------------------
	
	/**
	 * Class constructor
	 * Defines some global variables
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('rownd'));
	}

	//------------------------------------------------------------------------------------
	
	/**
	 * Handles the procedural post request from the add to rowndly booknarklet
	 * 
	 * We split the url and the path to make sure we get the whole url without errors.
	 * 
	 * @param string $url The base url
	 * @param string $path Everything past the base url
	 */
	public function post($user_id, $url, $path)
	{
		$path = str_replace('--', '/', $path);
		$url = $url . $path;
		$values = new stdClass();
		$values->url = prep_url($url);
		$values->title = $values->url;
		$values->user_id = $user_id;
		$order = $this->rownd->find_max('sort_order'); 
		$order = (int) $order['sort_order'] + 1;
		$values->sort_order = $order;
		$values->title  = $this->_get_page_title($values->url);
		$result = $this->rownd->save($values);
	}
	
	//------------------------------------------------------------------------------------
	
	/**
	 * Gets the page title for a given url 
	 * 
	 * Uses curl to fetch the page content and parses out the title
	 * 
	 * @param string $url
	 * @return string $page_title
	 */
	private function _get_page_title($url)
	{
		$page_title = 'Not defined.';
		
		if (isset($url))
		{
			$page_title = $url;
		
			//Initialize the Curl session 
			$ch = curl_init(); 
		
			//Set curl to return the data instead of printing it to the browser. 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		
			//Set the URL 
			curl_setopt($ch, CURLOPT_URL, $url); 
		
			//Execute the fetch 
			$page_title = curl_exec($ch); 
		
			//Close the connection
			curl_close($ch);
		
			preg_match("#<title>(.+)<\/title>#iU", $page_title, $title);
		
			if (isset($title[1]))
			{
				$page_title = $title[1];
			}
		}
		
		return $page_title;
	}
}