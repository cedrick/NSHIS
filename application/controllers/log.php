<?php

class Log extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->userCheck($this->session->userdata('is_logged'));

		$this->load->model('Cubicle_model');

		$this->load->model('Globals_model');

		$this->load->library('devicelog');
	}

	function daily($sdate_unix = NULL)
	{
		if($this->input->post('mdate')) {
			
			$date = strtotime($this->input->post('mdate'));
			
			redirect(base_url().'log/daily/'.$date, 'refresh');
			
		}
		
		if(NULL == $sdate_unix) {
			//get current date
			$format = 'DATE_RFC1123';
			
			$sdate_unix = time() + 28800;
			
			$sdate_human = unix_to_human($sdate_unix);
		}
		
		$date = mdate("%m/%d/%Y", $sdate_unix);
		
		$data = array('date' => $date);
		
		$this->load->view('template',array('page'=>'log', 'data' => $data));
	}
	
	function userCheck($is_logged)
	{
		if(!$is_logged)
		{
			redirect('/user/notlogged', 'refresh');
		}
	}
	
}