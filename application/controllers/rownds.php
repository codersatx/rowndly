<?php 

class Rownds extends Public_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('rownd');
	}
	
	public function index()
	{
		$data['rownds'] =  $this->rownd->all();
		$this->render($data);
	}
	
	public function view($id)
	{
		$data['rownd'] = $this->rownd->find($id);
		app::debug($data);
	}
	
	public function create()
	{
		$this->rownd->save();
	}
	
	public function edit($id)
	{
		$data['rownd'] = $this->rownd->find($id);
		$this->render($data);
	}
	
	public function update()
	{
		$this->rownd->save();
	}
}