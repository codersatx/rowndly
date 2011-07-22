<?php 

class Rownds extends Public_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('rownd');
	}
	
	public function index()
	{
		$rownds =  $this->rownd->all(array('sort_order'=>'asc'));
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
	
	public function view($id)
	{
		$data['rownd'] = $this->rownd->find($id);
		app::debug($data);
	}
	
	public function create()
	{
		
		$values = app::get_post_values();
		$values->url = prep_url($values->url);
		
		$data = @file_get_contents($values->url);
		if( preg_match("#<title>(.+)<\/title>#iU", $data, $t))
		{
			$values->title = trim($t[1]);
		} else {
			$values->title = $values->url;
		}
	
		
		//app::debug(get_meta_tags($values->url));
		//return;
		//$values->title = $this->metatags->get_title();

		$order =$this->rownd->find_max('sort_order'); 
		$order = (int) $order['sort_order'] + 1;
		$values->sort_order = $order;
		$result = $this->rownd->save($values);
		if ($result > 0)
		{
			
			$rownd = $this->rownd->find($result);
			$rownd = $rownd->result[0];
				$delete = anchor('/rownds/destroy/'. $rownd->id, '<img src="/assets/images/minus.png" alt="Delete Rownd"/>', array('class'=>'delete-link','rel'=>$rownd->id));
			echo '<li class="ui-state-default" id="rownd_'. $rownd->id .'">';
			echo anchor($rownd->url, character_limiter($rownd->title, 70));
			echo app::div($rownd->url, array('class'=>'rownd-url'));
			echo $delete .'</li>';
			
			
		}
		else
		{
			//app::set_flash('There was an error saving this user.','error');
			//redirect('rownds/create');
		}
		
	}
	
	public function edit($id)
	{
		$data['rownd'] = $this->rownd->find($id)->result[0];
		$this->render($data);
	}
	
	public function update()
	{
		$values = app::get_post_values();
		if ($this->rownd->save($values))
		{
			app::set_flash('Updated user');
			redirect('rownds/index');
		}
		else
		{
			app::set_flash('There was an error saving this user.','error');
			redirect('rownds/edit/'. $values->id);
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
	
}