<?php

class Mouse extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->userCheck($this->session->userdata('is_logged'));

		$this->load->model('Mouse_model');

		$this->load->model('Cubicle_model');

		$this->load->model('Globals_model');

		$this->load->library('devicelog');
	}

	function index()
	{

	}

	function add()
	{

		$this->form_validation->set_rules('mouse_name', 'Mouse Name', 'trim|required|xss_clean|callback_unique|alpha_numeric|min_length[4]|strtoupper');
		$this->form_validation->set_rules('mouse_other_name', 'Mouse Other Name', 'trim|xss_clean|min_length[4]');
		$this->form_validation->set_rules('mouse_sn', 'Serial number', 'trim|xss_clean|strtoupper');
		$this->form_validation->set_rules('mouse_date_purchased', 'Date Purchased', 'trim|xss_clean');
		$this->form_validation->set_rules('mouse_notes', 'Notes', 'trim|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('template',array('page'=>'mouse/add'));
		}
		else
		{
				
			$mouse_name = $this->input->post('mouse_name');
			$mouse_other_name = $this->input->post('mouse_other_name');
			$mouse_sn = $this->input->post('mouse_sn');
			$mouse_date_purchased = $this->input->post('mouse_date_purchased');
			$mouse_notes = $this->input->post('mouse_notes');
				
			$id = $this->Mouse_model->insert_new_mouse($mouse_name, $mouse_other_name, $mouse_sn, $mouse_date_purchased, $mouse_notes);
				
			if($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'mouse', 'add');

				redirect('/mouse/view/'.$id, 'refresh');
			}
		}
	}

	function assign($location)
	{
		$this->form_validation->set_rules('mouse_id', 'Mouse Name', 'trim|required|xss_clean|alpha_numeric|min_length[1]|strtoupper');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Mouse_model->get_available_mouses();
			$cubicle = $this->Cubicle_model->get_cubicle_info($location);
			$this->load->view('template',array('page'=>'mouse/assign','data' => $data, 'cubicle' => $cubicle));
		}
		else
		{
			$mouse_id = $this->input->post('mouse_id');
				
			$id = $this->Mouse_model->assign_mouse($mouse_id, $location);
				
			if ($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $mouse_id, 'mouse', 'assign', $id);

				redirect('/cubicle/view/'.$id, 'refresh');
			}
		}
	}

	function view($mouse_id)
	{
		$info = $this->Mouse_model->get_mouse_info($mouse_id);
		$comments = $this->Mouse_model->get_comments($mouse_id);

		$data = array('info' => $info, 'comments' => $comments);

		$this->load->view('template',array('page'=>'mouse/view', 'data'=>$data));
	}

	function viewall()
	{
		$data = $this->Mouse_model->get_all_mouse_info();

		$this->load->view('template',array('page'=>'mouse/viewall', 'data'=>$data));
	}

	function edit($mouse_id = NULL)
	{
		if (isset($mouse_id))
		{
			$this->form_validation->set_rules('mouse_name', 'Mouse Name', 'trim|required|xss_clean|alpha_numeric|min_length[4]|strtoupper');
			$this->form_validation->set_rules('mouse_other_name', 'Other Name', 'trim|xss_clean');
			$this->form_validation->set_rules('mouse_sn', 'Serial number', 'trim|xss_clean|strtoupper');
			$this->form_validation->set_rules('mouse_date_purchased', 'Date Purchased', 'trim|xss_clean');
			$this->form_validation->set_rules('mouse_notes', 'Notes', 'trim|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Mouse_model->get_mouse_info($mouse_id);
				$this->load->view('template',array('page'=>'mouse/edit', 'data' => $data));
			}
			else
			{
				$mouse_name = $this->input->post('mouse_name');
				$mouse_other_name = $this->input->post('mouse_other_name');
				$mouse_sn = $this->input->post('mouse_sn');
				$mouse_date_purchased = $this->input->post('mouse_date_purchased');
				$mouse_notes = $this->input->post('mouse_notes');

				$id = $this->Mouse_model->edit_mouse($mouse_id, $mouse_name, $mouse_other_name, $mouse_sn, $mouse_date_purchased, $mouse_notes);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'mouse', 'edit');
						
					redirect('/mouse/view/'.$id, 'refresh');
				}

			}
		}
		else
		{
			echo "Cannot edit empty mouse. Please go back into your previous page.";
		}
	}

	function delete($mouse_id)
	{
		$this->form_validation->set_rules('delete', 'Delete', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Mouse_model->get_mouse_info($mouse_id);
			$this->load->view('template',array('page'=>'mouse/delete', 'data' => $data));
		}
		else
		{
			$delete = $this->input->post('delete');
				
			if($delete=='no')
			{
				redirect('/mouse/view/' . $mouse_id, 'refresh');
			}
			else
			{
				$id = $this->Mouse_model->delete_mouse($mouse_id);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'mouse', 'delete');
						
					redirect('/mouse/viewall', 'refresh');
				}
			}
		}
	}

	function transfer($mouse_id = NULL)
	{
		if (isset($mouse_id))
		{
			$this->form_validation->set_rules('cubicle_id', 'Cubicle', 'trim|required|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Mouse_model->get_cubicle_mouse_info($mouse_id);
				$this->load->view('template',array('page'=>'mouse/transfer', 'data' => $data));
			}
			else
			{
				$cubicle_id = $this->input->post('cubicle_id');
				
				//pullout item if destination has already assigned
				$old_data = $this->Cubicle_model->get_cubicle_info_by_id($cubicle_id);
				$old_data[$this->router->fetch_class()] != 0 ? $this->pullout($old_data[$this->router->fetch_class()], FALSE) : NULL;
				

				$id = $this->Mouse_model->transfer($mouse_id, $cubicle_id);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $mouse_id, 'mouse', 'transfer', $id);
						
					redirect('/cubicle/view/'.$id, 'refresh');
				}


			}
		}
		else
		{
			echo "Cannot transfer empty mouse. Please go back into your previous page.";
		}
	}

	function swap($mouse_id = NULL)
	{
		if (isset($mouse_id))
		{
			$this->form_validation->set_rules('cubicle_id', 'Cubicle', 'trim|required|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Mouse_model->get_cubicle_mouse_info($mouse_id);
				$this->load->view('template',array('page'=>'mouse/swap', 'data' => $data));
			}
			else
			{
				$cubicle_mouse_id = $this->input->post('cubicle_id');

				$id = $this->Mouse_model->swap($mouse_id, $cubicle_mouse_id);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $mouse_id, 'mouse', 'swap', $id);
						
					redirect('/cubicle/view/'.$id, 'refresh');
				}
			}
		}
		else
		{
			echo "Cannot swap empty mouse. Please go back into your previous page.";
		}
	}

	function comment($mouse_id)
	{
		$this->form_validation->set_rules('mouse_comment', 'Comment', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Mouse_model->get_mouse_info($mouse_id);
			$this->load->view('template',array('page'=>'mouse/comment', 'data' => $data));
		}
		else
		{
			$comment = $this->input->post('mouse_comment');
				
			$id = $this->Mouse_model->insert_comment($mouse_id, $comment);
				
			if ($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'mouse', 'comment');
					
				redirect('/mouse/view/'.$id, 'refresh');
			}
		}
	}

	function available()
	{
		$data = $this->Mouse_model->get_all_mouse_info();

		if ($data)
		{
			$this->load->view('template',array('page'=>'mouse/available', 'data' => $data));
		}
	}

	function deployed()
	{
		$data = $this->Mouse_model->get_all_mouse_info();

		if ($data)
		{
			$this->load->view('template',array('page'=>'mouse/deployed', 'data' => $data));
		}
	}

	function unique($mouse_name)
	{
		$exist = $this->Mouse_model->check_mouse_exist($mouse_name);

		if($exist)
		{
			$info = $this->Mouse_model->get_mouse_info_by_name($mouse_name);
				
			$this->form_validation->set_message('unique', anchor('mouse/view/'.$info['mouse_id'],$info['name']).' already exist.');
				
			return false;
		}
		else
		{
			return true;
		}
	}

	function pullout($mouse_id, $redirect = TRUE)
	{
		$return = $this->Mouse_model->pull_out($mouse_id);

		if ($return)
		{
			$this->devicelog->insert_log($this->session->userdata('user_id'), $mouse_id, 'mouse', 'pullout', $return);
				
			$redirect == TRUE ? redirect('/mouse/view/'.$mouse_id, 'refresh') : '';
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