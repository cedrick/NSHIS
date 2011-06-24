<?php 

class Main extends Controller {

	function Main()
	{
		parent::Controller();
		
		$this->userCheck($this->session->userdata('is_logged'));
	}
	
	function index()
	{		
		$this->load->view('template');
	}
	
	function userCheck($is_logged)
	{
		if(!$is_logged)
		{
			redirect('/user/notlogged', 'refresh');
		}
	}
	
}