<?php

class Ups extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->userCheck($this->session->userdata('is_logged'));

		$this->load->model('Ups_model');

		$this->load->model('Cubicle_model');

		$this->load->model('Globals_model');

		$this->load->library('devicelog');
	}

	function index()
	{

	}

	function add()
	{

		$this->form_validation->set_rules('ups_name', 'Ups Name', 'trim|required|xss_clean|callback_unique|alpha_numeric|min_length[4]|strtoupper');
		$this->form_validation->set_rules('ups_other_name', 'Ups Other Name', 'trim|xss_clean|min_length[4]');
		$this->form_validation->set_rules('ups_sn', 'Serial number', 'trim|xss_clean|strtoupper');
		$this->form_validation->set_rules('ups_date_purchased', 'Date Purchased', 'trim|xss_clean');
		$this->form_validation->set_rules('ups_notes', 'Notes', 'trim|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('template',array('page'=>'ups/add'));
		}
		else
		{
				
			$ups_name = $this->input->post('ups_name');
			$ups_other_name = $this->input->post('ups_other_name');
			$ups_sn = $this->input->post('ups_sn');
			$ups_date_purchased = $this->input->post('ups_date_purchased');
			$ups_notes = $this->input->post('ups_notes');
				
			$id = $this->Ups_model->insert_new_ups($ups_name, $ups_other_name, $ups_sn, $ups_date_purchased, $ups_notes);
				
			if($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'ups', 'add');

				redirect('/ups/view/'.$id, 'refresh');
			}
		}
	}

	function assign($location)
	{
		$this->form_validation->set_rules('ups_id', 'Ups Name', 'trim|required|xss_clean|alpha_numeric|min_length[1]|strtoupper');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Ups_model->get_available_upss();
			$cubicle = $this->Cubicle_model->get_cubicle_info($location);
			$this->load->view('template',array('page'=>'ups/assign','data' => $data, 'cubicle' => $cubicle));
		}
		else
		{
			$ups_id = $this->input->post('ups_id');
			
			//pullout item if current location has already assigned
			$old_data = $this->Cubicle_model->get_cubicle_info_by_id($location);
			$old_data[$this->router->fetch_class()] != 0 ? $this->pullout($old_data[$this->router->fetch_class()], FALSE) : NULL;
				
			$id = $this->Ups_model->assign_ups($ups_id, $location);
				
			if ($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $ups_id, 'ups', 'assign', $id);

				redirect('/cubicle/view/'.$id, 'refresh');
			}
		}
	}

	function view($ups_id)
	{
		$info = $this->Ups_model->get_ups_info($ups_id);
		$comments = $this->Ups_model->get_comments($ups_id);

		$data = array('info' => $info, 'comments' => $comments);

		$this->load->view('template',array('page'=>'ups/view', 'data'=>$data));
	}

	function viewall()
	{
		$data = $this->Ups_model->get_all_ups_info();

		$this->load->view('template',array('page'=>'ups/viewall', 'data'=>$data));
	}

	function edit($ups_id = NULL)
	{
		if (isset($ups_id))
		{
			$this->form_validation->set_rules('ups_name', 'Ups Name', 'trim|required|xss_clean|alpha_numeric|min_length[4]|strtoupper');
			$this->form_validation->set_rules('ups_other_name', 'Other Name', 'trim|xss_clean');
			$this->form_validation->set_rules('ups_sn', 'Serial number', 'trim|xss_clean|strtoupper');
			$this->form_validation->set_rules('ups_date_purchased', 'Date Purchased', 'trim|xss_clean');
			$this->form_validation->set_rules('ups_notes', 'Notes', 'trim|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Ups_model->get_ups_info($ups_id);
				$this->load->view('template',array('page'=>'ups/edit', 'data' => $data));
			}
			else
			{
				$ups_name = $this->input->post('ups_name');
				$ups_other_name = $this->input->post('ups_other_name');
				$ups_sn = $this->input->post('ups_sn');
				$ups_date_purchased = $this->input->post('ups_date_purchased');
				$ups_notes = $this->input->post('ups_notes');

				$id = $this->Ups_model->edit_ups($ups_id, $ups_name, $ups_other_name, $ups_sn, $ups_date_purchased, $ups_notes);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'ups', 'edit');
						
					redirect('/ups/view/'.$id, 'refresh');
				}

			}
		}
		else
		{
			echo "Cannot edit empty ups. Please go back into your previous page.";
		}
	}

	function delete($ups_id)
	{
		$this->form_validation->set_rules('delete', 'Delete', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Ups_model->get_ups_info($ups_id);
			$this->load->view('template',array('page'=>'ups/delete', 'data' => $data));
		}
		else
		{
			$delete = $this->input->post('delete');
				
			if($delete=='no')
			{
				redirect('/ups/view/' . $ups_id, 'refresh');
			}
			else
			{
				$id = $this->Ups_model->delete_ups($ups_id);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'ups', 'delete');
						
					redirect('/ups/viewall', 'refresh');
				}
			}
		}
	}

	function transfer($ups_id = NULL)
	{
		if (isset($ups_id))
		{
			$this->form_validation->set_rules('cubicle_id', 'Cubicle', 'trim|required|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Ups_model->get_cubicle_ups_info($ups_id);
				$this->load->view('template',array('page'=>'ups/transfer', 'data' => $data));
			}
			else
			{
				$cubicle_id = $this->input->post('cubicle_id');
				
				//pullout item if destination has already assigned
				$old_data = $this->Cubicle_model->get_cubicle_info_by_id($cubicle_id);
				$old_data[$this->router->fetch_class()] != 0 ? $this->pullout($old_data[$this->router->fetch_class()], FALSE) : NULL;
				

				$id = $this->Ups_model->transfer($ups_id, $cubicle_id);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $ups_id, 'ups', 'transfer', $id);
						
					redirect('/cubicle/view/'.$id, 'refresh');
				}


			}
		}
		else
		{
			echo "Cannot transfer empty ups. Please go back into your previous page.";
		}
	}

	function swap($ups_id = NULL)
	{
		if (isset($ups_id))
		{
			$this->form_validation->set_rules('cubicle_id', 'Cubicle', 'trim|required|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Ups_model->get_cubicle_ups_info($ups_id);
				$this->load->view('template',array('page'=>'ups/swap', 'data' => $data));
			}
			else
			{
				$cubicle_ups_id = $this->input->post('cubicle_id');

				$id = $this->Ups_model->swap($ups_id, $cubicle_ups_id);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $ups_id, 'ups', 'swap', $id);
						
					redirect('/cubicle/view/'.$id, 'refresh');
				}
			}
		}
		else
		{
			echo "Cannot swap empty ups. Please go back into your previous page.";
		}
	}

	function comment($ups_id)
	{
		$this->form_validation->set_rules('ups_comment', 'Comment', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Ups_model->get_ups_info($ups_id);
			$this->load->view('template',array('page'=>'ups/comment', 'data' => $data));
		}
		else
		{
			$comment = $this->input->post('ups_comment');
				
			$id = $this->Ups_model->insert_comment($ups_id, $comment);
				
			if ($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'ups', 'comment');
					
				redirect('/ups/view/'.$id, 'refresh');
			}
		}
	}

	function available()
	{
		$data = $this->Ups_model->get_all_ups_info();

		if ($data)
		{
			$this->load->view('template',array('page'=>'ups/available', 'data' => $data));
		}
	}

	function deployed()
	{
		$data = $this->Ups_model->get_all_ups_info();

		if ($data)
		{
			$this->load->view('template',array('page'=>'ups/deployed', 'data' => $data));
		}
	}

	function unique($ups_name)
	{
		$exist = $this->Ups_model->check_ups_exist($ups_name);

		if($exist)
		{
			$info = $this->Ups_model->get_ups_info_by_name($ups_name);
				
			$this->form_validation->set_message('unique', anchor('ups/view/'.$info['ups_id'],$info['name']).' already exist.');
				
			return false;
		}
		else
		{
			return true;
		}
	}

	function pullout($ups_id, $redirect = TRUE)
	{
		$return = $this->Ups_model->pull_out($ups_id);

		if ($return)
		{
			$this->devicelog->insert_log($this->session->userdata('user_id'), $ups_id, 'ups', 'pullout', $return);
				
			$redirect == TRUE ? redirect('/ups/view/'.$ups_id, 'refresh') : '';
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