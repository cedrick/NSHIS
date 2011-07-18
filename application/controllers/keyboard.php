<?php

class Keyboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->userCheck($this->session->userdata('is_logged'));

		$this->load->model('Keyboard_model');

		$this->load->model('Cubicle_model');

		$this->load->model('Globals_model');
	}

	function index()
	{

	}

	function add()
	{

		$this->form_validation->set_rules('keyboard_name', 'Keyboard Name', 'trim|required|xss_clean|callback_unique|alpha_numeric|min_length[4]|strtoupper');
		$this->form_validation->set_rules('keyboard_other_name', 'Keyboard Other Name', 'trim|xss_clean|min_length[4]');
		$this->form_validation->set_rules('keyboard_sn', 'Serial number', 'trim|xss_clean|strtoupper');
		$this->form_validation->set_rules('keyboard_date_purchased', 'Date Purchased', 'trim|xss_clean');
		$this->form_validation->set_rules('keyboard_notes', 'Notes', 'trim|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('template',array('page'=>'keyboard/add'));
		}
		else
		{
				
			$keyboard_name = $this->input->post('keyboard_name');
			$keyboard_other_name = $this->input->post('keyboard_other_name');
			$keyboard_sn = $this->input->post('keyboard_sn');
			$keyboard_date_purchased = $this->input->post('keyboard_date_purchased');
			$keyboard_notes = $this->input->post('keyboard_notes');
				
			$id = $this->Keyboard_model->insert_new_keyboard($keyboard_name, $keyboard_other_name, $keyboard_sn, $keyboard_date_purchased, $keyboard_notes);
				
			if($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'keyboard', 'add');

				redirect('/keyboard/view/'.$id, 'refresh');
			}
		}
	}

	function assign($location)
	{
		$this->form_validation->set_rules('keyboard_id', 'Keyboard Name', 'trim|required|xss_clean|alpha_numeric|min_length[1]|strtoupper');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Keyboard_model->get_available_keyboards();
			$cubicle = $this->Cubicle_model->get_cubicle_info($location);
			$this->load->view('template',array('page'=>'keyboard/assign','data' => $data, 'cubicle' => $cubicle));
		}
		else
		{
			$keyboard_id = $this->input->post('keyboard_id');
			
			//pullout item if current location has already assigned
			$old_data = $this->Cubicle_model->get_cubicle_info_by_id($location);
			$old_data[$this->router->fetch_class()] != 0 ? $this->pullout($old_data[$this->router->fetch_class()], FALSE) : NULL;
				
			$id = $this->Keyboard_model->assign_keyboard($keyboard_id, $location);
				
			if ($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $keyboard_id, 'keyboard', 'assign', $id);

				redirect('/cubicle/view/'.$id, 'refresh');
			}
		}
	}

	function view($keyboard_id)
	{
		$info = $this->Keyboard_model->get_keyboard_info($keyboard_id);
		$comments = $this->Keyboard_model->get_comments($keyboard_id);

		$data = array('info' => $info, 'comments' => $comments);

		$this->load->view('template',array('page'=>'keyboard/view', 'data'=>$data));
	}

	function viewall()
	{
		$data = $this->Keyboard_model->get_all_keyboard_info();

		$this->load->view('template',array('page'=>'keyboard/viewall', 'data'=>$data));
	}

	function edit($keyboard_id = NULL)
	{
		if (isset($keyboard_id))
		{
			$this->form_validation->set_rules('keyboard_name', 'Keyboard Name', 'trim|required|xss_clean|alpha_numeric|min_length[4]|strtoupper');
			$this->form_validation->set_rules('keyboard_other_name', 'Other Name', 'trim|xss_clean');
			$this->form_validation->set_rules('keyboard_sn', 'Serial number', 'trim|xss_clean|strtoupper');
			$this->form_validation->set_rules('keyboard_date_purchased', 'Date Purchased', 'trim|xss_clean');
			$this->form_validation->set_rules('keyboard_notes', 'Notes', 'trim|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Keyboard_model->get_keyboard_info($keyboard_id);
				$this->load->view('template',array('page'=>'keyboard/edit', 'data' => $data));
			}
			else
			{
				$keyboard_name = $this->input->post('keyboard_name');
				$keyboard_other_name = $this->input->post('keyboard_other_name');
				$keyboard_sn = $this->input->post('keyboard_sn');
				$keyboard_date_purchased = $this->input->post('keyboard_date_purchased');
				$keyboard_notes = $this->input->post('keyboard_notes');

				$id = $this->Keyboard_model->edit_keyboard($keyboard_id, $keyboard_name, $keyboard_other_name, $keyboard_sn, $keyboard_date_purchased, $keyboard_notes);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'keyboard', 'edit');
						
					redirect('/keyboard/view/'.$id, 'refresh');
				}

			}
		}
		else
		{
			echo "Cannot edit empty keyboard. Please go back into your previous page.";
		}
	}

	function delete()
	{
		if($_POST['my_device_id'] != '' || $_POST['my_device_id'] != NULL)
		{
			$this->devicelog->insert_log($this->session->userdata('user_id'), $_POST['my_device_id'], 'keyboard', 'delete');
			
			$id = $this->Keyboard_model->delete_keyboard($_POST['my_device_id']);
		}
	}

	function transfer($keyboard_id = NULL)
	{
		if (isset($keyboard_id))
		{
			$this->form_validation->set_rules('cubicle_id', 'Cubicle', 'trim|required|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Keyboard_model->get_cubicle_keyboard_info($keyboard_id);
				$this->load->view('template',array('page'=>'keyboard/transfer', 'data' => $data));
			}
			else
			{
				$cubicle_id = $this->input->post('cubicle_id');
				
				//pullout item if destination has already assigned
				$old_data = $this->Cubicle_model->get_cubicle_info_by_id($cubicle_id);
				$old_data[$this->router->fetch_class()] != 0 ? $this->pullout($old_data[$this->router->fetch_class()], FALSE) : NULL;
				

				$id = $this->Keyboard_model->transfer($keyboard_id, $cubicle_id);

				if ($id)
				{
					$this->devicelog->insert_log($this->session->userdata('user_id'), $keyboard_id, 'keyboard', 'transfer', $id);
						
					redirect('/cubicle/view/'.$id, 'refresh');
				}


			}
		}
		else
		{
			echo "Cannot transfer empty keyboard. Please go back into your previous page.";
		}
	}

	function swap($keyboard_id = NULL)
	{
		if (isset($keyboard_id))
		{
			$this->form_validation->set_rules('cubicle_id', 'Cubicle', 'trim|required|xss_clean');
				
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Keyboard_model->get_cubicle_keyboard_info($keyboard_id);
				$this->load->view('template',array('page'=>'keyboard/swap', 'data' => $data));
			}
			else
			{
				$cubicle_keyboard_id = $this->input->post('cubicle_id');

				$id = $this->Keyboard_model->swap($keyboard_id, $cubicle_keyboard_id);

				if ($id)
				{
					//$this->devicelog->insert_log($this->session->userdata('user_id'), $keyboard_id, 'keyboard', 'swap', $id);
						
					redirect('/cubicle/view/'.$id, 'refresh');
				}
			}
		}
		else
		{
			echo "Cannot swap empty keyboard. Please go back into your previous page.";
		}
	}

	function comment($keyboard_id)
	{
		$this->form_validation->set_rules('keyboard_comment', 'Comment', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Keyboard_model->get_keyboard_info($keyboard_id);
			$this->load->view('template',array('page'=>'keyboard/comment', 'data' => $data));
		}
		else
		{
			$comment = $this->input->post('keyboard_comment');
				
			$id = $this->Keyboard_model->insert_comment($keyboard_id, $comment);
				
			if ($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'keyboard', 'comment');
					
				redirect('/keyboard/view/'.$id, 'refresh');
			}
		}
	}

	function available()
	{
		$data = $this->Keyboard_model->get_all_keyboard_info();

		if ($data)
		{
			$this->load->view('template',array('page'=>'keyboard/available', 'data' => $data));
		}
	}

	function deployed()
	{
		$data = $this->Keyboard_model->get_all_keyboard_info();

		if ($data)
		{
			$this->load->view('template',array('page'=>'keyboard/deployed', 'data' => $data));
		}
	}

	function unique($keyboard_name)
	{
		$exist = $this->Keyboard_model->check_keyboard_exist($keyboard_name);

		if($exist)
		{
			$info = $this->Keyboard_model->get_keyboard_info_by_name($keyboard_name);
				
			$this->form_validation->set_message('unique', anchor('keyboard/view/'.$info['keyboard_id'],$info['name']).' already exist.');
				
			return false;
		}
		else
		{
			return true;
		}
	}

	function pullout($keyboard_id, $redirect = TRUE)
	{
		$return = $this->Keyboard_model->pull_out($keyboard_id);

		if ($return)
		{
			$this->devicelog->insert_log($this->session->userdata('user_id'), $keyboard_id, 'keyboard', 'pullout', $return);
				
			$redirect == TRUE ? redirect('/keyboard/view/'.$keyboard_id, 'refresh') : '';
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