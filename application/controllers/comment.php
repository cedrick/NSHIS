<?php

class Comment extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		//$this->userCheck($this->session->userdata('is_logged'));
		
		$this->load->model('Comment_model');
	}

	function add()
	{
		$this->Comment_model->add($_POST['log_id'], $_POST['comment']);
	}
	
}