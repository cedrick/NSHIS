<?php 

class Search extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->userCheck($this->session->userdata('is_logged'));
		
		$this->load->model('Search_model');
	}
	
	function index()
	{
		$this->form_validation->set_rules('name', 'Name', 'trim|xss_clean|required');
		$this->form_validation->set_rules('item_type', 'Item Type', 'trim|xss_clean|required');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('template',array('page'=>'search', 'result'=>NULL));
		}
		else 
		{
			$item_type = $this->input->post('item_type');
			$string = $this->input->post('name');
			
			$result = $this->Search_model->search($item_type, $string);
      
      if($result)
      {
        $data = array('item_type'=>$item_type,'result'=>$result);
        $this->load->view('template',array('page'=>'search', 'data'=>$data));
      }
		}
	}
	
	function userCheck($is_logged)
	{
		if(!$is_logged)
		{
			redirect('/user/notlogged', 'refresh');
		}
	}
	
}