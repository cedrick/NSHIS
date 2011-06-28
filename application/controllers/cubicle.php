<?php

Class Cubicle extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->userCheck($this->session->userdata('is_logged'));

		$this->load->model('Cubicle_model');

		$this->load->model('Globals_model');

		$this->load->library('devicelog');
	}

	function index()
	{
		$this->load->view('view_all');
	}

	function add()
	{

		$this->form_validation->set_rules('cubicle_name', 'Cubicle Name', 'trim|required|xss_clean|callback_unique|alpha_numeric|min_length[4]|strtoupper');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('template',array('page'=>'cubicle/add'));
		}
		else
		{
			$cubicle_name = $this->input->post('cubicle_name');
				
			$id = $this->Cubicle_model->insert_new_cubicle($cubicle_name);
				
			if($id)
			{
				$this->Stats_model->insert_log($this->session->userdata('user_id'), $id, 'cubicle', 'add');

				redirect('/cubicle/view/'.$id, 'refresh');
			}
			else
			{
				//			redirect('/user/register/', 'refresh');
			}
				
		}

	}

	function edit($cubicle_id)
	{
		$this->form_validation->set_rules('cubicle_name', 'Cubicle Name', 'trim|required|xss_clean|callback_unique|alpha_numeric|min_length[4]|strtoupper');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Cubicle_model->get_cubicle_info($cubicle_id);
			$this->load->view('template',array('page'=>'cubicle/edit', 'data' => $data));
		}
		else
		{
			$cubicle_name = $this->input->post('cubicle_name');
				
			$id = $this->Cubicle_model->edit_cubicle($cubicle_id, $cubicle_name);
				
			if($id)
			{
				$this->Stats_model->insert_log($this->session->userdata('user_id'), $id, 'cubicle', 'edit');

				redirect('/cubicle/view/'.$id, 'refresh');
			}
			else
			{
				//			redirect('/user/register/', 'refresh');
			}
				
		}
	}

	function delete($cubicle_id)
	{
		$this->form_validation->set_rules('delete', 'Delete', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Cubicle_model->get_cubicle_info($cubicle_id);
			$this->load->view('template',array('page'=>'cubicle/delete', 'data' => $data));
		}
		else
		{
			$delete = $this->input->post('delete');
				
			if($delete=='no')
			{
				redirect('/cubicle/viewall', 'refresh');
			}
			else
			{
				$delete = $this->Cubicle_model->delete_cubicle($cubicle_id);

				if ($delete)
				{
					$this->Stats_model->insert_log($this->session->userdata('user_id'), $cubicle_id, 'cubicle', 'delete');
						
					redirect('/cubicle/viewall', 'refresh');
				}
				else
				{
					echo "Delete error";
				}
			}
			//			$this->Cubicle_model->edit_cubicle($cubicle_id, $cubicle_name);
		}
	}

	function view($cubicle_id)
	{

		$info = $this->Cubicle_model->get_cubicle_info($cubicle_id);
		$comments = $this->Cubicle_model->get_comments($cubicle_id);
		$logs = $this->Globals_model->get_item_logs($cubicle_id, 'cubicle');

		$data = array('info' => $info, 'comments' => $comments, 'logs' => $logs);

		$this->load->view('template',array('page'=>'cubicle/view', 'data'=>$data));

	}

	function viewall()
	{

		$data = $this->Cubicle_model->get_all_cubicle_info();

		$this->load->view('template',array('page'=>'cubicle/viewall', 'data'=>$data));

	}

	function comment($cubicle_id)
	{
		$this->form_validation->set_rules('cubicle_comment', 'Comment', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Cubicle_model->get_cubicle_info($cubicle_id);
			$this->load->view('template',array('page'=>'cubicle/comment', 'data' => $data));
		}
		else
		{
			$comment = $this->input->post('cubicle_comment');
				
			$id = $this->Cubicle_model->insert_comment($cubicle_id, $comment);
				
			if ($id)
			{
				$this->Stats_model->insert_log($this->session->userdata('user_id'), $id, 'cubicle', 'comment');

				redirect('/cubicle/view/'.$id, 'refresh');
			}
			else
			{

			}
		}
	}

	function unique($cubicle_name)
	{
		$exist = $this->Cubicle_model->check_cubicle_exist($cubicle_name);

		if($exist)
		{
			$info = $this->Cubicle_model->get_cubicle_info_by_name($cubicle_name);
				
			$this->form_validation->set_message('unique', anchor('cubicle/view/'.$info['cubicle_id'],$info['name']).' already exist.');
				
			return false;
		}
		else
		{
			return true;
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