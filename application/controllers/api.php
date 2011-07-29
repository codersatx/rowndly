<?php

class Api extends Public_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('rownd','user'));
		$this->load->helper('xml');
	}
	
	public function json($user_id, $key = NULL)
	{
		$user = $this->user->find($user_id);
		
		if ($user && $user->result->allow_public || $key == $user->result->private_key)
		{
			$result = $this->rownd->find_by_user($user_id)->result_array();
			$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode(array('rownds'=>$result)));
		}
		else
		{
			$this->output
			    ->set_content_type('text/plain')
			    ->set_output('User not found.');
		}
	}
	
	public function xml($user_id, $key = NULL)
	{
		$user = $this->user->find($user_id);
		if ($user && $user->result->allow_public || $key == $user->result->private_key)
		{
			$config = array (
			                  'root'    => 'rownds',
			                  'element' => 'rownd', 
			                  'newline' => "\n", 
			                  'tab'    => "\t"
			                );
			$this->load->dbutil();
			$result = $this->rownd->find_by_user($user_id);
		
			$this->output
			    ->set_content_type('application/xml')
		    	->set_output($this->dbutil->xml_from_result($result, $config));	
		}
		else
		{
			$this->output
			    ->set_content_type('text/plain')
			    ->set_output('User not found.');
		}
	}
	
	public function rss($user_id, $key = NULL)
	{
		$rownds = $this->rownd->find_by_user($user_id)->result_array();
		$user = $this->user->find($user_id );
		
		if ($user && $user->result->allow_public || $key == $user->result->private_key)
		{
			$data['title'] = 'rownds';
			$data['link'] = 'http://rowndly.com';
			$data['description'] = $user->result->username .'\'s rownds';
			$data['items'] = $rownds;
		
			$code = '<rss version="2.0">';
			$code .= '<channel>';
			$code .= '<title>'. $data['title'] .'</title>';
			$code .= '<link>'. $data['link'] .'</link>';
			$code .= '<description>'.$data['description'].'</description>';
		
				foreach($data['items'] as $item) 
				{
					$code .= '<item>';
					$code .='<title>'.xml_convert($item['title']).'</title>';
					$code .='<link>'. $item['url'] .'</link>';
					$code .='<description>'.xml_convert($item['url']).'</description>';
					$code .='<pubDate>'. date('Y-m-d h:i:s', strtotime($item['last_visited'])).'</pubDate>';
					$code .='<guid>'. $item['url'] .'</guid>';
					$code .='</item>';
				}
			$code .= '</channel>';
			$code .= '</rss>';
			$this->output
			    ->set_content_type('application/rss+xml')
			    ->set_output($code);
		}
		else
		{
			$this->output
			    ->set_content_type('text/plain')
			    ->set_output('User not found.');
		}
	}
}