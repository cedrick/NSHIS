<?php 

class Connector extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->userCheck($this->session->userdata('is_logged'));
		
		$this->load->model('Connector_model');
		
		$this->load->model('Cubicle_model');
		
		$this->load->model('Stats_model');
		
		$this->load->model('Globals_model');
	}
	
	function index() 
	{
		
	}
	
	function add()
	{
		
		$this->form_validation->set_rules('connector_name', 'Connector Name', 'trim|required|xss_clean|callback_unique|alpha_numeric|min_length[4]|strtoupper');
		$this->form_validation->set_rules('connector_other_name', 'Connector Other Name', 'trim|xss_clean|min_length[4]');
		$this->form_validation->set_rules('connector_sn', 'Serial number', 'trim|xss_clean|strtoupper');
		$this->form_validation->set_rules('connector_date_purchased', 'Date Purchased', 'trim|xss_clean');
		$this->form_validation->set_rules('connector_notes', 'Notes', 'trim|xss_clean');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('template',array('page'=>'connector/add'));
		}
		else 
		{
			
			$connector_name = $this->input->post('connector_name');
			$connector_other_name = $this->input->post('connector_other_name');
			$connector_sn = $this->input->post('connector_sn');
			$connector_date_purchased = $this->input->post('connector_date_purchased');
			$connector_notes = $this->input->post('connector_notes');
			
			$id = $this->Connector_model->insert_new_connector($connector_name, $connector_other_name, $connector_sn, $connector_date_purchased, $connector_notes);
			
			if($id)
			{
				$this->Stats_model->insert_log($this->session->userdata('user_id'), $id, 'connector', 'add');
				
				redirect('/connector/view/'.$id, 'refresh');
			}
		}
	}
	
	function assign($location)
	{
		$this->form_validation->set_rules('connector_id', 'Connector Name', 'trim|required|xss_clean|alpha_numeric|min_length[1]|strtoupper');
		
		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Connector_model->get_available_connectors();
			$cubicle = $this->Cubicle_model->get_cubicle_info($location);
			$this->load->view('template',array('page'=>'connector/assign','data' => $data, 'cubicle' => $cubicle));
		}
		else 
		{
			$connector_id = $this->input->post('connector_id');
			
			$id = $this->Connector_model->assign_connector($connector_id, $location);
			
			if ($id)
			{
				$this->Stats_model->insert_log($this->session->userdata('user_id'), $connector_id, 'connector', 'assign', $id);
				
				redirect('/cubicle/view/'.$id, 'refresh');
			}
		}
	}
	
	function view($connector_id)
	{
		$info = $this->Connector_model->get_connector_info($connector_id);
		$comments = $this->Connector_model->get_comments($connector_id);
		$logs = $this->Globals_model->get_item_logs($connector_id, 'connector');
		
		$data = array('info' => $info, 'comments' => $comments, 'logs' => $logs);
		
		$this->load->view('template',array('page'=>'connector/view', 'data'=>$data));
	}
	
	function viewall()
	{
		$data = $this->Connector_model->get_all_connector_info();
		
		$this->load->view('template',array('page'=>'connector/viewall', 'data'=>$data));
	}
	
	function edit($connector_id = NULL)
	{
		if (isset($connector_id))
		{
			$this->form_validation->set_rules('connector_name', 'Connector Name', 'trim|required|xss_clean|alpha_numeric|min_length[4]|strtoupper');
			$this->form_validation->set_rules('connector_other_name', 'Other Name', 'trim|xss_clean');
			$this->form_validation->set_rules('connector_sn', 'Serial number', 'trim|xss_clean|strtoupper');
			$this->form_validation->set_rules('connector_date_purchased', 'Date Purchased', 'trim|xss_clean');
			$this->form_validation->set_rules('connector_notes', 'Notes', 'trim|xss_clean');
			
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Connector_model->get_connector_info($connector_id);
				$this->load->view('template',array('page'=>'connector/edit', 'data' => $data));
			}
			else 
			{
				$connector_name = $this->input->post('connector_name');
				$connector_other_name = $this->input->post('connector_other_name');
				$connector_sn = $this->input->post('connector_sn');
				$connector_date_purchased = $this->input->post('connector_date_purchased');
				$connector_notes = $this->input->post('connector_notes');
				
				$id = $this->Connector_model->edit_connector($connector_id, $connector_name, $connector_other_name, $connector_sn, $connector_date_purchased, $connector_notes);
				
				if ($id)
				{
					$this->Stats_model->insert_log($this->session->userdata('user_id'), $id, 'connector', 'edit');
					
					redirect('/connector/view/'.$id, 'refresh');
				}
				
			}
		}
		else
		{
			echo "Cannot edit empty connector. Please go back into your previous page.";
		}
	}
	
	function delete($connector_id)
	{
		$this->form_validation->set_rules('delete', 'Delete', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Connector_model->get_connector_info($connector_id);
			$this->load->view('template',array('page'=>'connector/delete', 'data' => $data));
		}
		else 
		{
			$delete = $this->input->post('delete');
			
			if($delete=='no')
			{
				redirect('/connector/view/' . $connector_id, 'refresh');
			}	
			else 
			{
				$id = $this->Connector_model->delete_connector($connector_id);
				
				if ($id)
				{
					$this->Stats_model->insert_log($this->session->userdata('user_id'), $id, 'connector', 'delete');
					
					redirect('/connector/viewall', 'refresh');
				}
			}		
		}
	}
	
	function transfer($connector_id = NULL)
	{
		if (isset($connector_id))
		{
			$this->form_validation->set_rules('cubicle_id', 'Cubicle', 'trim|required|xss_clean');
			
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Connector_model->get_cubicle_connector_info($connector_id);
				$this->load->view('template',array('page'=>'connector/transfer', 'data' => $data));
			}
			else
			{
				$cubicle_id = $this->input->post('cubicle_id');
				
				$id = $this->Connector_model->transfer($connector_id, $cubicle_id);
				
				if ($id)
				{
					$this->Stats_model->insert_log($this->session->userdata('user_id'), $connector_id, 'connector', 'transfer', $id);
					
					redirect('/cubicle/view/'.$id, 'refresh');
				}
				
				
			}
		}
		else
		{
			echo "Cannot transfer empty connector. Please go back into your previous page.";
		}
	}
	
	function swap($connector_id = NULL)
	{
		if (isset($connector_id))
		{
			$this->form_validation->set_rules('cubicle_id', 'Cubicle', 'trim|required|xss_clean');
			
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->Connector_model->get_cubicle_connector_info($connector_id);
				$this->load->view('template',array('page'=>'connector/swap', 'data' => $data));
			}
			else
			{
				$cubicle_connector_id = $this->input->post('cubicle_id');
				
				$id = $this->Connector_model->swap($connector_id, $cubicle_connector_id);
				
				if ($id)
				{
					$this->Stats_model->insert_log($this->session->userdata('user_id'), $connector_id, 'connector', 'swap', $id);
					
					redirect('/cubicle/view/'.$id, 'refresh');
				}
			}
		}
		else
		{
			echo "Cannot swap empty connector. Please go back into your previous page.";
		}
	}
	
	function comment($connector_id)
	{
		$this->form_validation->set_rules('connector_comment', 'Comment', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE)
		{
			$data = $this->Connector_model->get_connector_info($connector_id);
			$this->load->view('template',array('page'=>'connector/comment', 'data' => $data));
		}
		else 
		{
			$comment = $this->input->post('connector_comment');
			
			$id = $this->Connector_model->insert_comment($connector_id, $comment);
			
			if ($id)
			{
				$this->Stats_model->insert_log($this->session->userdata('user_id'), $id, 'connector', 'comment');
			
				redirect('/connector/view/'.$id, 'refresh');
			}
		}
	}
	
	function available()
	{
		$data = $this->Connector_model->get_all_connector_info();
		
		if ($data)
		{
			$this->load->view('template',array('page'=>'connector/available', 'data' => $data));
		}
	}
	
	function deployed()
	{
		$data = $this->Connector_model->get_all_connector_info();
		
		if ($data)
		{
			$this->load->view('template',array('page'=>'connector/deployed', 'data' => $data));
		}
	}
	
	function unique($connector_name)
	{
		$exist = $this->Connector_model->check_connector_exist($connector_name);
		
		if($exist)
		{
			$info = $this->Connector_model->get_connector_info_by_name($connector_name);
			
			$this->form_validation->set_message('unique', anchor('connector/view/'.$info['connector_id'],$info['name']).' already exist.');
			
			return false;
		}
		else 
		{
			return true;
		}
	}
	
	function pullout($connector_id)
	{
		$return = $this->Connector_model->pull_out($connector_id);
		
		if ($return) 
		{
			$this->Stats_model->insert_log($this->session->userdata('user_id'), $connector_id, 'connector', 'pullout', $return);
			
			redirect('/connector/view/'.$connector_id, 'refresh');
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