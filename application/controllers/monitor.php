<?php

class Monitor extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->userCheck($this->session->userdata('is_logged'));

		$this->load->model('Monitor_model');

		$this->load->model('Cubicle_model');

		$this->load->model('Globals_model');

		$this->load->library('devicelog');
	}

	function index()
	{

	}

	function add()
	{

		$this->form_validation->set_rules('monitor_name', 'Monitor Name', 'trim|required|xss_clean|callback_unique|alpha_numeric|min_length[4]|strtoupper');
		$this->form_validation->set_rules('monitor_other_name', 'Monitor Other Name', 'trim|xss_clean|min_length[4]');
		$this->form_validation->set_rules('monitor_sn', 'Serial number', 'trim|xss_clean|strtoupper');
		$this->form_validation->set_rules('monitor_date_purchased', 'Date Purchased', 'trim|xss_clean');
		$this->form_validation->set_rules('monitor_notes', 'Notes', 'trim|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('template',array('page'=>'monitor/add'));
		}
		else
		{
				
			$monitor_name = $this->input->post('monitor_name');
			$monitor_other_name = $this->input->post('monitor_other_name');
			$monitor_sn = $this->input->post('monitor_sn');
			$monitor_date_purchased = $this->input->post('monitor_date_purchased');
			$monitor_notes = $this->input->post('monitor_notes');
				
			$id = $this->Monitor_model->insert_new_monitor($monitor_name, $monitor_other_name, $monitor_sn, $monitor_date_purchased, $monitor_notes);
				
			if($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'monitor', 'add');

				redirect('/monitor/view/'.$id, 'refresh');
			}
		}
	}

	function assign($location)
	{
		$this->form_validation->set_rules('monitor_id', 'Monitor Name', 'trim|required|xss_clean|alpha_numeric|min_length[1]|strtoupper');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Monitor_model->get_available_monitors();
			$cubicle = $this->Cubicle_model->get_cubicle_info($location);
			$this->load->view('template',array('page'=>'monitor/assign','data' => $data, 'cubicle' => $cubicle));
		}
		else
		{
			$monitor_id = $this->input->post('monitor_id');
			
			//pullout item if current location has already assigned
			$old_data = $this->Cubicle_model->get_cubicle_info_by_id($location);
			$old_data[$this->router->fetch_class()] != 0 ? $this->pullout($old_data[$this->router->fetch_class()], FALSE) : NULL;
				
			$id = $this->Monitor_model->assign_monitor($monitor_id, $location);
				
			if ($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $monitor_id, 'monitor', 'assign', $id);

				redirect('/cubicle/view/'.$id, 'refresh');
			}
		}
	}

	function view($monitor_id)
	{
		$info = $this->Monitor_model->get_monitor_info($monitor_id);
		$comments = $this->Monitor_model->get_comments($monitor_id);

		$data = array('info' => $info, 'comments' => $comments);

		$this->load->view('template',array('page'=>'monitor/view', 'data'=>$data));
	}

	function viewall()
	{
		$data = $this->Monitor_model->get_all_monitor_info();

		$this->load->view('template',array('page'=>'monitor/viewall', 'data'=>$data));
	}

	function edit($monitor_id = NULL)
	{
		if (isset($monitor_id))
		{
			$this->form_validation->set_rules('monitor_name', 'Monitor Name', 'trim|required|xss_clean|alpha_numeric|min_length[4]|strtoupper');
			$this->form_validation->set_rules('monitor_other_name', 'Other Name', 'trim|xss_clean');
			$this->form_validation->set_rules('monitor_sn', 'Serial number', 'trim|xss_clean|strtoupper');
			$this->form_validation->set_rules('monitor_date_purchased', 'Date Purchased', 'trim|xss_clean');
			$this->form_validation->set_rules('monitor_notes', 'Notes', 'trim|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Monitor_model->get_monitor_info($monitor_id);
				$this->load->view('template',array('page'=>'monitor/edit', 'data' => $data));
			}
			else
			{
				$monitor_name = $this->input->post('monitor_name');
				$monitor_other_name = $this->input->post('monitor_other_name');
				$monitor_sn = $this->input->post('monitor_sn');
				$monitor_date_purchased = $this->input->post('monitor_date_purchased');
				$monitor_notes = $this->input->post('monitor_notes');

				$id = $this->Monitor_model->edit_monitor($monitor_id, $monitor_name, $monitor_other_name, $monitor_sn, $monitor_date_purchased, $monitor_notes);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'monitor', 'edit');
						
					redirect('/monitor/view/'.$id, 'refresh');
				}

			}
		}
		else
		{
			echo "Cannot edit empty monitor. Please go back into your previous page.";
		}
	}

	function delete($monitor_id)
	{
		$this->form_validation->set_rules('delete', 'Delete', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Monitor_model->get_monitor_info($monitor_id);
			$this->load->view('template',array('page'=>'monitor/delete', 'data' => $data));
		}
		else
		{
			$delete = $this->input->post('delete');
				
			if($delete=='no')
			{
				redirect('/monitor/view/' . $monitor_id, 'refresh');
			}
			else
			{
				$id = $this->Monitor_model->delete_monitor($monitor_id);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'monitor', 'delete');
						
					redirect('/monitor/viewall', 'refresh');
				}
			}
		}
	}

	function transfer($monitor_id = NULL)
	{
		if (isset($monitor_id))
		{
			$this->form_validation->set_rules('cubicle_id', 'Cubicle', 'trim|required|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Monitor_model->get_cubicle_monitor_info($monitor_id);
				$this->load->view('template',array('page'=>'monitor/transfer', 'data' => $data));
			}
			else
			{
				$cubicle_id = $this->input->post('cubicle_id');
				
				//pullout item if destination has already assigned
				$old_data = $this->Cubicle_model->get_cubicle_info_by_id($cubicle_id);
				$old_data[$this->router->fetch_class()] != 0 ? $this->pullout($old_data[$this->router->fetch_class()], FALSE) : NULL;
				

				$id = $this->Monitor_model->transfer($monitor_id, $cubicle_id);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $monitor_id, 'monitor', 'transfer', $id);
						
					redirect('/cubicle/view/'.$id, 'refresh');
				}


			}
		}
		else
		{
			echo "Cannot transfer empty monitor. Please go back into your previous page.";
		}
	}

	function swap($monitor_id = NULL)
	{
		if (isset($monitor_id))
		{
			$this->form_validation->set_rules('cubicle_id', 'Cubicle', 'trim|required|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Monitor_model->get_cubicle_monitor_info($monitor_id);
				$this->load->view('template',array('page'=>'monitor/swap', 'data' => $data));
			}
			else
			{
				$cubicle_monitor_id = $this->input->post('cubicle_id');

				$id = $this->Monitor_model->swap($monitor_id, $cubicle_monitor_id);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $monitor_id, 'monitor', 'swap', $id);
						
					redirect('/cubicle/view/'.$id, 'refresh');
				}
			}
		}
		else
		{
			echo "Cannot swap empty monitor. Please go back into your previous page.";
		}
	}

	function comment($monitor_id)
	{
		$this->form_validation->set_rules('monitor_comment', 'Comment', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Monitor_model->get_monitor_info($monitor_id);
			$this->load->view('template',array('page'=>'monitor/comment', 'data' => $data));
		}
		else
		{
			$comment = $this->input->post('monitor_comment');
				
			$id = $this->Monitor_model->insert_comment($monitor_id, $comment);
				
			if ($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'monitor', 'comment');
					
				redirect('/monitor/view/'.$id, 'refresh');
			}
		}
	}

	function available()
	{
		$data = $this->Monitor_model->get_all_monitor_info();

		if ($data)
		{
			$this->load->view('template',array('page'=>'monitor/available', 'data' => $data));
		}
	}

	function deployed()
	{
		$data = $this->Monitor_model->get_all_monitor_info();

		if ($data)
		{
			$this->load->view('template',array('page'=>'monitor/deployed', 'data' => $data));
		}
	}

	function unique($monitor_name)
	{
		$exist = $this->Monitor_model->check_monitor_exist($monitor_name);

		if($exist)
		{
			$info = $this->Monitor_model->get_monitor_info_by_name($monitor_name);
				
			$this->form_validation->set_message('unique', anchor('monitor/view/'.$info['monitor_id'],$info['name']).' already exist.');
				
			return false;
		}
		else
		{
			return true;
		}
	}

	function pullout($monitor_id, $redirect = TRUE)
	{
		$return = $this->Monitor_model->pull_out($monitor_id);

		if ($return)
		{
			$this->devicelog->insert_log($this->session->userdata('user_id'), $monitor_id, 'monitor', 'pullout', $return);
				
			$redirect == TRUE ? redirect('/monitor/view/'.$monitor_id, 'refresh') : '';
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