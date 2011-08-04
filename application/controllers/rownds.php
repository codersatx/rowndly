<?php
/**
 * Rownds
 * 
 * Handles the display and management of rownds. Extends the auth controller
 * since we need users to be logged in to view this resource.
 * 
 * @author Alex Garcia
 */
class Rownds extends Auth_Controller{

	//------------------------------------------------------------------------------------
	
	/**
	 * Class constructor
	 * Defines some global variables
	 */
	public function __construct()
	{
		parent::__construct();
		$data['title'] = 'My Rownds';
		$data['email'] = app::session('email');
		$data['allow_public'] = app::session('allow_public');
		$data['private_key'] = app::session('private_ley');
		$data['user_id'] = app::session('id');
		$this->load->vars($data);
	}
	
	//------------------------------------------------------------------------------------
	
	/**
	 * Shows a list of rownds the user has stored.
	 * 
	 */ 
	public function index()
	{
		$rownds =  $this->rownd->all(array('sort_order'=>'asc'), array('user_id'=>app::session('id')));
		
		if ($rownds)
		{
			$data['rownds'] = $rownds->result;
			$this->render($data);
		}
		else
		{
			$this->render();
		}
	}
	
	//------------------------------------------------------------------------------------
	
	/**
	 * Creates a new rownd
	 * 
	 * Will only run on an ajax call not directly.
	 * 
	 * @return string json encoded string with all the code needed to append a new rownd to the list
	 */
	public function create()
	{	
		if (app::is_ajax())
		{
			$values = new stdClass();
			$values->url = prep_url($this->input->post('url'));
			$values->title = $values->url;
			$values->user_id = app::session('id');
			$order = $this->rownd->find_max('sort_order'); 
			$order = (int) $order['sort_order'] + 1;
			$values->sort_order = $order;
			$values->title  = $this->_get_page_title($values->url);
		
			$result = $this->rownd->save($values);
			if ($result > 0)
			{
				$rownd = $this->rownd->find($result);
				$rownd = $rownd->result[0];
			
				$edit = anchor('/rownds/edit/'. $rownd->id,
					'<img src="/assets/images/pencil.png" alt="Edit Rownd"/>', 
					array('class'=>'edit-link','rel'=>$rownd->id));
			
				$delete = anchor('/rownds/destroy/'. $rownd->id, 
					'<img src="/assets/images/minus.png" alt="Delete Rownd"/>', 
					array('class'=>'delete-link','rel'=>$rownd->id));
				
				$output = '<li class="ui-state-default" id="rownd_'. $rownd->id .'">';
				$output .= anchor($rownd->url, character_limiter($rownd->title, 56), array('target'=>'_blank'));
				$output .= app::div($rownd->url, array('class'=>'rownd-url'));
				$output .= $edit . $delete .'</li>';
				$this->output->set_content_type('application/json')
							 ->set_output(json_encode(array('status'=>'ok','output'=>$output)));	
			}
		}
		else
		{
			redirect('/');
		}
	}
	
	//------------------------------------------------------------------------------------
	
	/**
	 * Updates a rownd
	 * 
	 * Will only run on an ajax call.
	 * 
	 * @return string json encoded string with the id, title and url 
	 */
	public function update()
	{
		if (app::is_ajax())
		{
			$values = new stdClass;
			$values->id = $this->input->post('inline-id');
			$values->title = $this->input->post('inline-title');
			$values->url = $this->input->post('inline-url');
		
			if ($this->rownd->save($values))
			{
				$title = character_limiter($values->title, 56, '...');
				$this->output->set_content_type('application/json')
							 ->set_output(json_encode(array('id'=>$values->id, 'title'=> $title, 'url'=>$values->url)));
			}
		}
		else
		{
			redirect('/');
		}
	}
	
	//------------------------------------------------------------------------------------
	
	/**
	 * Deletes a rownd
	 * 
	 * Will only run on an ajax call.
	 * 
	 * @param int $id  The id of the rownd to be deleted.
	 * @return string plain text
	 */
	public function destroy($id)
	{
		if (app::is_ajax())
		{
			$this->rownd->destroy($id);
			$this->output->set_content_type('text/plain')
						 ->set_output('ok');
		}
		else
		{
			redirect('/');
		}
	}
	
	//------------------------------------------------------------------------------------
	
	/**
	 * Sorts the rownd when a user does a drag and drop
	 * 
	 */
	public function sort()
	{
		if (app::is_ajax())
		{
			foreach($_POST as $key=>$val)
			{
				foreach($val as $position=>$id)
				{
					$this->rownd->update_position($id, $position);
				}
			}
		}
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
	public function post($url, $path)
	{
		$path = str_replace('--', '/', $path);
		$data['url'] = $url . $path;
		$this->render($data, NULL, 'post');
	}
	
	//------------------------------------------------------------------------------------
	
	/**
	 * Tracks a click made on the actual link to record when the last time that rownd
	 * was visited.
	 * 
	 * Will only be run by an ajax call
	 * 
	 * @param int $id The id of rownd
	 * @return string json encoded string with the date and time
	 */
	public function track($id)
	{
		if (app::is_ajax())
		{
			$rownd = new stdClass();
			$rownd->id = $id;
			$rownd->last_visited = date('Y-m-d H:i:s');
			$this->rownd->save($rownd);
			$this->output->set_content_type('application/json')
						 ->set_output(json_encode(array('last_visited'=>'Last Rownd: '. date("m/d/Y @ h:i a", strtotime($rownd->last_visited)))));
		}
		else
		{
			redirect('/');
		}
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