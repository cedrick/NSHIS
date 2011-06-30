<?php

class Dialpad extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->userCheck($this->session->userdata('is_logged'));

		$this->load->model('Dialpad_model');

		$this->load->model('Cubicle_model');

		$this->load->model('Globals_model');

		$this->load->library('devicelog');
	}

	function index()
	{

	}

	function add()
	{

		$this->form_validation->set_rules('dialpad_name', 'Dialpad Name', 'trim|required|xss_clean|callback_unique|alpha_numeric|min_length[4]|strtoupper');
		$this->form_validation->set_rules('dialpad_other_name', 'Dialpad Other Name', 'trim|xss_clean|min_length[4]');
		$this->form_validation->set_rules('dialpad_sn', 'Serial number', 'trim|xss_clean|strtoupper');
		$this->form_validation->set_rules('dialpad_date_purchased', 'Date Purchased', 'trim|xss_clean');
		$this->form_validation->set_rules('dialpad_notes', 'Notes', 'trim|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('template',array('page'=>'dialpad/add'));
		}
		else
		{
				
			$dialpad_name = $this->input->post('dialpad_name');
			$dialpad_other_name = $this->input->post('dialpad_other_name');
			$dialpad_sn = $this->input->post('dialpad_sn');
			$dialpad_date_purchased = $this->input->post('dialpad_date_purchased');
			$dialpad_notes = $this->input->post('dialpad_notes');
				
			$id = $this->Dialpad_model->insert_new_dialpad($dialpad_name, $dialpad_other_name, $dialpad_sn, $dialpad_date_purchased, $dialpad_notes);
				
			if($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'dialpad', 'add');

				redirect('/dialpad/view/'.$id, 'refresh');
			}
		}
	}

	function assign($location)
	{
		$this->form_validation->set_rules('dialpad_id', 'Dialpad Name', 'trim|required|xss_clean|alpha_numeric|min_length[1]|strtoupper');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Dialpad_model->get_available_dialpads();
			$cubicle = $this->Cubicle_model->get_cubicle_info($location);
			$this->load->view('template',array('page'=>'dialpad/assign','data' => $data, 'cubicle' => $cubicle));
		}
		else
		{
			$dialpad_id = $this->input->post('dialpad_id');
			
			//pullout item if current location has already assigned
			$old_data = $this->Cubicle_model->get_cubicle_info_by_id($location);
			$old_data[$this->router->fetch_class()] != 0 ? $this->pullout($old_data[$this->router->fetch_class()], FALSE) : NULL;
			
			$id = $this->Dialpad_model->assign_dialpad($dialpad_id, $location);
				
			if ($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $dialpad_id, 'dialpad', 'assign', $id);

				redirect('/cubicle/view/'.$id, 'refresh');
			}
		}
	}

	function view($dialpad_id)
	{
		$info = $this->Dialpad_model->get_dialpad_info($dialpad_id);
		$comments = $this->Dialpad_model->get_comments($dialpad_id);

		$data = array('info' => $info, 'comments' => $comments);

		$this->load->view('template',array('page'=>'dialpad/view', 'data'=>$data));
	}

	function viewall()
	{
		$data = $this->Dialpad_model->get_all_dialpad_info();

		$this->load->view('template',array('page'=>'dialpad/viewall', 'data'=>$data));
	}

	function edit($dialpad_id = NULL)
	{
		if (isset($dialpad_id))
		{
			$this->form_validation->set_rules('dialpad_name', 'Dialpad Name', 'trim|required|xss_clean|alpha_numeric|min_length[4]|strtoupper');
			$this->form_validation->set_rules('dialpad_other_name', 'Other Name', 'trim|xss_clean');
			$this->form_validation->set_rules('dialpad_sn', 'Serial number', 'trim|xss_clean|strtoupper');
			$this->form_validation->set_rules('dialpad_date_purchased', 'Date Purchased', 'trim|xss_clean');
			$this->form_validation->set_rules('dialpad_notes', 'Notes', 'trim|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Dialpad_model->get_dialpad_info($dialpad_id);
				$this->load->view('template',array('page'=>'dialpad/edit', 'data' => $data));
			}
			else
			{
				$dialpad_name = $this->input->post('dialpad_name');
				$dialpad_other_name = $this->input->post('dialpad_other_name');
				$dialpad_sn = $this->input->post('dialpad_sn');
				$dialpad_date_purchased = $this->input->post('dialpad_date_purchased');
				$dialpad_notes = $this->input->post('dialpad_notes');

				$id = $this->Dialpad_model->edit_dialpad($dialpad_id, $dialpad_name, $dialpad_other_name, $dialpad_sn, $dialpad_date_purchased, $dialpad_notes);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'dialpad', 'edit');
						
					redirect('/dialpad/view/'.$id, 'refresh');
				}

			}
		}
		else
		{
			echo "Cannot edit empty dialpad. Please go back into your previous page.";
		}
	}

	function delete($dialpad_id)
	{
		$this->form_validation->set_rules('delete', 'Delete', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Dialpad_model->get_dialpad_info($dialpad_id);
			$this->load->view('template',array('page'=>'dialpad/delete', 'data' => $data));
		}
		else
		{
			$delete = $this->input->post('delete');
				
			if($delete=='no')
			{
				redirect('/dialpad/view/' . $dialpad_id, 'refresh');
			}
			else
			{
				$id = $this->Dialpad_model->delete_dialpad($dialpad_id);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'dialpad', 'delete');
						
					redirect('/dialpad/viewall', 'refresh');
				}
			}
		}
	}

	function transfer($dialpad_id = NULL)
	{
		if (isset($dialpad_id))
		{
			$this->form_validation->set_rules('cubicle_id', 'Cubicle', 'trim|required|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Dialpad_model->get_cubicle_dialpad_info($dialpad_id);
				$this->load->view('template',array('page'=>'dialpad/transfer', 'data' => $data));
			}
			else
			{
				$cubicle_id = $this->input->post('cubicle_id');
				
				//pullout item if destination has already assigned
				$old_data = $this->Cubicle_model->get_cubicle_info_by_id($cubicle_id);
				$old_data[$this->router->fetch_class()] != 0 ? $this->pullout($old_data[$this->router->fetch_class()], FALSE) : NULL;
				

				$id = $this->Dialpad_model->transfer($dialpad_id, $cubicle_id);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $dialpad_id, 'dialpad', 'transfer', $id);
						
					redirect('/cubicle/view/'.$id, 'refresh');
				}


			}
		}
		else
		{
			echo "Cannot transfer empty dialpad. Please go back into your previous page.";
		}
	}

	function swap($dialpad_id = NULL)
	{
		if (isset($dialpad_id))
		{
			$this->form_validation->set_rules('cubicle_id', 'Cubicle', 'trim|required|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Dialpad_model->get_cubicle_dialpad_info($dialpad_id);
				$this->load->view('template',array('page'=>'dialpad/swap', 'data' => $data));
			}
			else
			{
				$cubicle_dialpad_id = $this->input->post('cubicle_id');

				$id = $this->Dialpad_model->swap($dialpad_id, $cubicle_dialpad_id);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $dialpad_id, 'dialpad', 'swap', $id);
						
					redirect('/cubicle/view/'.$id, 'refresh');
				}
			}
		}
		else
		{
			echo "Cannot swap empty dialpad. Please go back into your previous page.";
		}
	}

	function comment($dialpad_id)
	{
		$this->form_validation->set_rules('dialpad_comment', 'Comment', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Dialpad_model->get_dialpad_info($dialpad_id);
			$this->load->view('template',array('page'=>'dialpad/comment', 'data' => $data));
		}
		else
		{
			$comment = $this->input->post('dialpad_comment');
				
			$id = $this->Dialpad_model->insert_comment($dialpad_id, $comment);
				
			if ($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'dialpad', 'comment');
					
				redirect('/dialpad/view/'.$id, 'refresh');
			}
		}
	}

	function available()
	{
		$data = $this->Dialpad_model->get_all_dialpad_info();

		if ($data)
		{
			$this->load->view('template',array('page'=>'dialpad/available', 'data' => $data));
		}
	}

	function deployed()
	{
		$data = $this->Dialpad_model->get_all_dialpad_info();

		if ($data)
		{
			$this->load->view('template',array('page'=>'dialpad/deployed', 'data' => $data));
		}
	}

	function unique($dialpad_name)
	{
		$exist = $this->Dialpad_model->check_dialpad_exist($dialpad_name);

		if($exist)
		{
			$info = $this->Dialpad_model->get_dialpad_info_by_name($dialpad_name);
				
			$this->form_validation->set_message('unique', anchor('dialpad/view/'.$info['dialpad_id'],$info['name']).' already exist.');
				
			return false;
		}
		else
		{
			return true;
		}
	}

	function pullout($dialpad_id, $redirect = TRUE)
	{
		$return = $this->Dialpad_model->pull_out($dialpad_id);

		if ($return)
		{
			$this->devicelog->insert_log($this->session->userdata('user_id'), $dialpad_id, 'dialpad', 'pullout', $return);
				
			$redirect == TRUE ? redirect('/dialpad/view/'.$dialpad_id, 'refresh') : '';
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