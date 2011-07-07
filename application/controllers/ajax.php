<?php

class Ajax extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		//$this->userCheck($this->session->userdata('is_logged'));
		
		$this->load->model('Ajax_model');
	}

	function comment_add()
	{
		$this->Ajax_model->comment_add($_POST['log_id'], $_POST['comment']);
	}
	
	function status_change()
	{
		$this->Ajax_model->status_change($_POST['item'], $_POST['item_id'], $_POST['status'], $_POST['status_comment']);
	}
}