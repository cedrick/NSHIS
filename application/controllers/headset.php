<?php

class Headset extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->userCheck($this->session->userdata('is_logged'));

		$this->load->model('Headset_model');

		$this->load->model('Cubicle_model');

		$this->load->model('Globals_model');

		$this->load->library('devicelog');
	}

	function index()
	{

	}

	function add()
	{

		$this->form_validation->set_rules('headset_name', 'Headset Name', 'trim|required|xss_clean|callback_unique|alpha_numeric|min_length[4]|strtoupper');
		$this->form_validation->set_rules('headset_other_name', 'Headset Other Name', 'trim|xss_clean|min_length[4]');
		$this->form_validation->set_rules('headset_sn', 'Serial number', 'trim|xss_clean|strtoupper');
		$this->form_validation->set_rules('headset_date_purchased', 'Date Purchased', 'trim|xss_clean');
		$this->form_validation->set_rules('headset_notes', 'Notes', 'trim|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('template',array('page'=>'headset/add'));
		}
		else
		{
				
			$headset_name = $this->input->post('headset_name');
			$headset_other_name = $this->input->post('headset_other_name');
			$headset_sn = $this->input->post('headset_sn');
			$headset_date_purchased = $this->input->post('headset_date_purchased');
			$headset_notes = $this->input->post('headset_notes');
				
			$id = $this->Headset_model->insert_new_headset($headset_name, $headset_other_name, $headset_sn, $headset_date_purchased, $headset_notes);
				
			if($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'headset', 'add');

				redirect('/headset/view/'.$id, 'refresh');
			}
		}
	}

	function assign($location)
	{
		$this->form_validation->set_rules('headset_id', 'Headset Name', 'trim|required|xss_clean|alpha_numeric|min_length[1]|strtoupper');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Headset_model->get_available_headsets();
			$cubicle = $this->Cubicle_model->get_cubicle_info($location);
			$this->load->view('template',array('page'=>'headset/assign','data' => $data, 'cubicle' => $cubicle));
		}
		else
		{
			$headset_id = $this->input->post('headset_id');
				
			$id = $this->Headset_model->assign_headset($headset_id, $location);
				
			if ($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $headset_id, 'headset', 'assign', $id);

				redirect('/cubicle/view/'.$id, 'refresh');
			}
		}
	}

	function view($headset_id)
	{
		$info = $this->Headset_model->get_headset_info($headset_id);
		$comments = $this->Headset_model->get_comments($headset_id);

		$data = array('info' => $info, 'comments' => $comments);

		$this->load->view('template',array('page'=>'headset/view', 'data'=>$data));
	}

	function viewall()
	{
		$data = $this->Headset_model->get_all_headset_info();

		$this->load->view('template',array('page'=>'headset/viewall', 'data'=>$data));
	}

	function edit($headset_id = NULL)
	{
		if (isset($headset_id))
		{
			$this->form_validation->set_rules('headset_name', 'Headset Name', 'trim|required|xss_clean|alpha_numeric|min_length[4]|strtoupper');
			$this->form_validation->set_rules('headset_other_name', 'Other Name', 'trim|xss_clean');
			$this->form_validation->set_rules('headset_sn', 'Serial number', 'trim|xss_clean|strtoupper');
			$this->form_validation->set_rules('headset_date_purchased', 'Date Purchased', 'trim|xss_clean');
			$this->form_validation->set_rules('headset_notes', 'Notes', 'trim|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Headset_model->get_headset_info($headset_id);
				$this->load->view('template',array('page'=>'headset/edit', 'data' => $data));
			}
			else
			{
				$headset_name = $this->input->post('headset_name');
				$headset_other_name = $this->input->post('headset_other_name');
				$headset_sn = $this->input->post('headset_sn');
				$headset_date_purchased = $this->input->post('headset_date_purchased');
				$headset_notes = $this->input->post('headset_notes');

				$id = $this->Headset_model->edit_headset($headset_id, $headset_name, $headset_other_name, $headset_sn, $headset_date_purchased, $headset_notes);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'headset', 'edit');
						
					redirect('/headset/view/'.$id, 'refresh');
				}

			}
		}
		else
		{
			echo "Cannot edit empty headset. Please go back into your previous page.";
		}
	}

	function delete($headset_id)
	{
		$this->form_validation->set_rules('delete', 'Delete', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Headset_model->get_headset_info($headset_id);
			$this->load->view('template',array('page'=>'headset/delete', 'data' => $data));
		}
		else
		{
			$delete = $this->input->post('delete');
				
			if($delete=='no')
			{
				redirect('/headset/view/' . $headset_id, 'refresh');
			}
			else
			{
				$id = $this->Headset_model->delete_headset($headset_id);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'headset', 'delete');
						
					redirect('/headset/viewall', 'refresh');
				}
			}
		}
	}

	function transfer($headset_id = NULL)
	{
		if (isset($headset_id))
		{
			$this->form_validation->set_rules('cubicle_id', 'Cubicle', 'trim|required|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Headset_model->get_cubicle_headset_info($headset_id);
				$this->load->view('template',array('page'=>'headset/transfer', 'data' => $data));
			}
			else
			{
				$cubicle_id = $this->input->post('cubicle_id');
				
				//pullout item if destination has already assigned
				$old_data = $this->Cubicle_model->get_cubicle_info_by_id($cubicle_id);
				$old_data[$this->router->fetch_class()] != 0 ? $this->pullout($old_data[$this->router->fetch_class()], FALSE) : NULL;
				

				$id = $this->Headset_model->transfer($headset_id, $cubicle_id);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $headset_id, 'headset', 'transfer', $id);
						
					redirect('/cubicle/view/'.$id, 'refresh');
				}


			}
		}
		else
		{
			echo "Cannot transfer empty headset. Please go back into your previous page.";
		}
	}

	function swap($headset_id = NULL)
	{
		if (isset($headset_id))
		{
			$this->form_validation->set_rules('cubicle_id', 'Cubicle', 'trim|required|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Headset_model->get_cubicle_headset_info($headset_id);
				$this->load->view('template',array('page'=>'headset/swap', 'data' => $data));
			}
			else
			{
				$cubicle_headset_id = $this->input->post('cubicle_id');

				$id = $this->Headset_model->swap($headset_id, $cubicle_headset_id);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $headset_id, 'headset', 'swap', $id);
						
					redirect('/cubicle/view/'.$id, 'refresh');
				}
			}
		}
		else
		{
			echo "Cannot swap empty headset. Please go back into your previous page.";
		}
	}

	function comment($headset_id)
	{
		$this->form_validation->set_rules('headset_comment', 'Comment', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Headset_model->get_headset_info($headset_id);
			$this->load->view('template',array('page'=>'headset/comment', 'data' => $data));
		}
		else
		{
			$comment = $this->input->post('headset_comment');
				
			$id = $this->Headset_model->insert_comment($headset_id, $comment);
				
			if ($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'headset', 'comment');
					
				redirect('/headset/view/'.$id, 'refresh');
			}
		}
	}

	function available()
	{
		$data = $this->Headset_model->get_all_headset_info();

		if ($data)
		{
			$this->load->view('template',array('page'=>'headset/available', 'data' => $data));
		}
	}

	function deployed()
	{
		$data = $this->Headset_model->get_all_headset_info();

		if ($data)
		{
			$this->load->view('template',array('page'=>'headset/deployed', 'data' => $data));
		}
	}

	function unique($headset_name)
	{
		$exist = $this->Headset_model->check_headset_exist($headset_name);

		if($exist)
		{
			$info = $this->Headset_model->get_headset_info_by_name($headset_name);
				
			$this->form_validation->set_message('unique', anchor('headset/view/'.$info['headset_id'],$info['name']).' already exist.');
				
			return false;
		}
		else
		{
			return true;
		}
	}

	function pullout($headset_id, $redirect = TRUE)
	{
		$return = $this->Headset_model->pull_out($headset_id);

		if ($return)
		{
			$this->devicelog->insert_log($this->session->userdata('user_id'), $headset_id, 'headset', 'pullout', $return);
				
			$redirect == TRUE ? redirect('/headset/view/'.$headset_id, 'refresh') : '';
		}
		else
		{
			echo "Cannot pullout unassigned item. Please go back into your previous page.";
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