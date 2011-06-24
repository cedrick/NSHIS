<?php 

class Stats extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->userCheck($this->session->userdata('is_logged'));
		
		$this->load->model('Stats_model');
	}
	
	function index()
	{
		$device_info = $this->Stats_model->get_devices_info();
		$logs = $this->Stats_model->get_logs();
		$data = array('device_info' => $device_info, 'logs' => $logs);
		
		$this->load->view('template',array('page'=>'index', 'data' => $data));
		
		
	}
	
	function userCheck($is_logged)
	{
		if(!$is_logged)
		{
			redirect('/user/notlogged', 'refresh');
		}
	}
	
}