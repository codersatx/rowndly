<?php
class Rownds extends Auth_Controller{

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
	
	public function create()
	{
		$values = new stdClass();
		$values->url = prep_url($this->input->post('url'));
		$values->title = $values->url;
		$values->user_id = app::session('id');
		$order = $this->rownd->find_max('sort_order'); 
		$order = (int) $order['sort_order'] + 1;
		$values->sort_order = $order;
		
		$page_title = @file_get_contents($values->url);
		if (preg_match("#<title>(.+)<\/title>#iU", $page_title, $title))
		{
			$values->title = trim($title[1]);
		}

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
				
			echo '<li class="ui-state-default" id="rownd_'. $rownd->id .'">';
			echo anchor($rownd->url, character_limiter($rownd->title, 56), array('target'=>'_blank'));
			echo app::div($rownd->url, array('class'=>'rownd-url'));
			echo $edit . $delete .'</li>';	
		}
	}
	
	public function update()
	{
		$values = new stdClass;
		$values->id = $this->input->post('inline-id');
		$values->title = $this->input->post('inline-title');
		$values->url = $this->input->post('inline-url');
		
		if ($this->rownd->save($values))
		{
			$title = character_limiter($values->title, 56, '...');
			echo json_encode(array('id'=>$values->id, 'title'=> $title, 'url'=>$values->url));
		}
	}
	
	public function destroy($id)
	{
		$this->rownd->destroy($id);
		echo 'OK';
	}
	
	public function sort()
	{
		foreach($_POST as $key=>$val)
		{
			foreach($val as $position=>$id)
			{
				$this->rownd->update_position($id, $position);
			}
		}
	}
	
	public function post($url, $path)
	{
		$path = str_replace('--', '/', $path);
		$data['url'] = $url . $path;
		$this->render($data);
	}
	
	public function track($id)
	{
		$rownd = new stdClass();
		$rownd->id = $id;
		$rownd->last_visited = date('Y-m-d H:i:s');
		$this->rownd->save($rownd);
		echo json_encode(array('last_visited'=>'Last Rownd: '. date("m/d/Y @ h:i a", strtotime($rownd->last_visited))));
	}
}