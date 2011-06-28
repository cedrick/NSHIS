<?php

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();

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