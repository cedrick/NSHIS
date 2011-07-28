<?php

class Stats extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->userCheck($this->session->userdata('is_logged'));

		$this->load->model('Stats_model');
		
		$this->load->model('Cubicle_model');
		
		$this->load->model('People_model');
	}

	function index()
	{
		//$device_info = $this->Stats_model->get_devices_info();
		//$data = array('device_info' => $device_info);

		//$this->load->view('template',array('page'=>'index', 'data' => $data));
		$this->load->view('template',array('page'=>'index'));
	}
	
	function view($device, $status, $assign = -1)
	{
		$data = array('device' => $device, 'status' => $status, 'flag_assigned' => $assign);
		
		$this->load->view('template',array('page'=>'stats/view', 'data' => $data));
	}

	function userCheck($is_logged)
	{
		if(!$is_logged)
		{
			redirect('/user/notlogged', 'refresh');
		}
	}
}