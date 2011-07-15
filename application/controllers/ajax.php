<?php

class Ajax extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		//$this->userCheck($this->session->userdata('is_logged'));
		
		$this->load->model('Ajax_model');
		
		$this->load->model('People_model');
		
		$this->load->model('Usb_headset_model');
		
	}

	function comment_add()
	{
		$this->Ajax_model->comment_add($_POST['log_id'], $_POST['comment']);
	}
	
	function status_change()
	{
		$this->Ajax_model->status_change($_POST['item'], $_POST['item_id'], $_POST['status'], $_POST['status_comment']);
	}
	
	function assign_headset()
	{
		$this->Usb_headset_model->assign_usb_headset($_POST['headset_id'], $_POST['user_id']);
		
		$this->devicelog->insert_log($this->session->userdata('user_id'), $_POST['headset_id'], 'usb_headset', 'assign', 0, $this->People_model->get_name($_POST['user_id']));
	}
}