<?php

class People extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->userCheck($this->session->userdata('is_logged'));
		
		$this->load->model('People_model');
		
		$this->load->model('Usb_headset_model');
	}

	function index()
	{
		
	}
	
	function add()
	{
		$this->form_validation->set_rules('fname', 'First Name', 'trim|required|xss_clean|min_length[2]|strtoupper');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|required|xss_clean|min_length[2]|strtoupper');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('template',array('page'=>'people/add'));
		}
		else
		{
			$fname = $this->input->post('fname');
			$lname = $this->input->post('lname');
			$full_name = $fname.' '.$lname;
			
			$is_exist = $this->People_model->exist($full_name);
			
			if(FALSE == $is_exist)
			{
				$this->People_model->add($fname, $lname);
				
				redirect('/people/viewall/', 'refresh');
			} 
			else {
				$this->session->set_flashdata('error', $full_name.' already exist.');
				
				redirect('/people/add/', 'refresh');
				//$this->load->view('template',array('page'=>'people/add'));
			}
		}
	}
	
	function viewall()
	{
		$result = $this->People_model->viewall();
		
		$this->load->view('template',array('page'=>'people/viewall', 'data' => $result));
	}
	
	
	
	function userCheck($is_logged)
	{
		if(!$is_logged)
		{
			redirect('/user/notlogged', 'refresh');
		}
	}
	
}