<?php 

class CPU extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->userCheck($this->session->userdata('is_logged'));
		
		$this->load->model('CPU_model');
		
		$this->load->model('Cubicle_model');
		
		$this->load->model('Stats_model');
		
		$this->load->model('Globals_model');
	}
	
	function index() 
	{
		
	}
	
	function add()
	{
		
		$this->form_validation->set_rules('cpu_name', 'CPU Name', 'trim|required|xss_clean|callback_unique|alpha_numeric|min_length[4]|strtoupper');
		$this->form_validation->set_rules('cpu_other_name', 'Other Name', 'trim|xss_clean');
		$this->form_validation->set_rules('cpu_sn', 'Serial number', 'trim|xss_clean|strtoupper');
		$this->form_validation->set_rules('cpu_processor', 'Processor', 'trim|xss_clean');
		$this->form_validation->set_rules('cpu_hostname', 'Hostname', 'trim|xss_clean');
		$this->form_validation->set_rules('cpu_memory1', 'Memory 1', 'trim|xss_clean');
		$this->form_validation->set_rules('cpu_memory2', 'Memory 2', 'trim|xss_clean');
		$this->form_validation->set_rules('cpu_memory1_type', 'Memory 1', 'trim|xss_clean');
		$this->form_validation->set_rules('cpu_memory2_type', 'Memory 2', 'trim|xss_clean');
		$this->form_validation->set_rules('cpu_hd1', 'Hard Disk 1', 'trim|xss_clean');
		$this->form_validation->set_rules('cpu_hd2', 'Hard Disk 2', 'trim|xss_clean');
		$this->form_validation->set_rules('cpu_hd1_type', 'Hard Disk 1 Type', 'trim|xss_clean');
		$this->form_validation->set_rules('cpu_hd2_type', 'Hard Disk 2 Type', 'trim|xss_clean');
		$this->form_validation->set_rules('cpu_date_purchased', 'Date Purchased', 'trim|xss_clean');
		$this->form_validation->set_rules('cpu_notes', 'Notes', 'trim|xss_clean');
		
		if($this->form_validation->run() == FALSE)
		{
			$processor = $this->db->get('nshis_choices_processor');
			$memory = $this->db->get('nshis_choices_memory');
			$memory_types = $this->db->get('nshis_choices_memory_types');
			$hd = $this->db->get('nshis_choices_hd');
			$hd_types = $this->db->get('nshis_choices_hd_types');
			$data = array('processor' => $processor, 'memory' => $memory, 'memory_types' => $memory_types, 'hd' => $hd, 'hd_types' => $hd_types);
			
			$this->load->view('template',array('page'=>'cpu/add', 'data' => $data));
		}
		else 
		{
			$cpu_name = $this->input->post('cpu_name');
			$cpu_other_name = $this->input->post('cpu_other_name');
			$cpu_sn = $this->input->post('cpu_sn');
			$cpu_processor = $this->input->post('cpu_processor');
			$cpu_memory1 = $this->input->post('cpu_memory1');
			$cpu_memory2 = $this->input->post('cpu_memory2');
			$cpu_memory1_type = $this->input->post('cpu_memory1_type');
			$cpu_memory2_type = $this->input->post('cpu_memory2_type');
			$cpu_hd1 = $this->input->post('cpu_hd1');
			$cpu_hd2 = $this->input->post('cpu_hd2');
			$cpu_hd1_type = $this->input->post('cpu_hd1_type');
			$cpu_hd2_type = $this->input->post('cpu_hd2_type');
			$cpu_date_purchased = $this->input->post('cpu_date_purchased');
			$cpu_hostname = $this->input->post('cpu_hostname');
			$cpu_notes = $this->input->post('cpu_notes');
			
			$data = array(
				'name' => $cpu_name,
				'other_name' => $cpu_other_name,
				'serial_number' => $cpu_sn,
				'processor_id' => $cpu_processor,
				'memory1_id' => $cpu_memory1,
				'memory2_id' => $cpu_memory2,
				'memory1_type_id' => $cpu_memory1_type,
				'memory2_type_id' => $cpu_memory2_type,
				'hd1_id' => $cpu_hd1,
				'hd2_id' => $cpu_hd2,
				'hd1_type_id' => $cpu_hd1_type,
				'hd2_type_id' => $cpu_hd2_type,
				'date_purchased' => $cpu_date_purchased,
				'hostname' => $cpu_hostname,
				'notes' => $cpu_notes
			);
			$id = $this->CPU_model->insert_new_cpu($data);
			
			if($id)
			{
				$this->Stats_model->insert_log($this->session->userdata('user_id'), $id, 'cpu', 'add');
				
				redirect('/cpu/view/'.$id, 'refresh');
			}
		}
	}
	
	function assign($location)
	{
		$this->form_validation->set_rules('cpu_id', 'CPU Name', 'trim|required|xss_clean|alpha_numeric|min_length[1]|strtoupper');
		
		if($this->form_validation->run() == FALSE)
		{
			$data = $this->CPU_model->get_available_cpus();
			$cubicle = $this->Cubicle_model->get_cubicle_info($location);
			$this->load->view('template',array('page'=>'cpu/assign','data' => $data, 'cubicle' => $cubicle));
		}
		else 
		{
			$cpu_id = $this->input->post('cpu_id');
			
			$id = $this->CPU_model->assign_cpu($cpu_id, $location);
			
			if ($id)
			{
				$this->Stats_model->insert_log($this->session->userdata('user_id'), $cpu_id, 'cpu', 'assign', $id);
				
				redirect('/cubicle/view/'.$id, 'refresh');
			}
		}
	}
	
	function view($cpu_id)
	{
		$data = $this->CPU_model->get_cpu_info($cpu_id);
		$comments = $this->CPU_model->get_comments($cpu_id);
		
		$info = $this->CPU_model->get_cpu_info($cpu_id);
		$comments = $this->CPU_model->get_comments($cpu_id);
		$logs = $this->Globals_model->get_item_logs($cpu_id, 'cpu');
		
		$data = array('info' => $info, 'comments' => $comments, 'logs' => $logs);
		
		$this->load->view('template',array('page'=>'cpu/view', 'data'=>$data));
		
//		if ($data)
//		{
//			$this->load->view('template',array('page'=>'cpu/view', 'data'=>$data, 'comments'=>$comments));
//		}
//		else 
//		{
//			$this->load->view('template',array('page'=>'cpu/view', 'data'=>$data));
//		}
		
	}
	
	function viewall()
	{
		$data = $this->CPU_model->get_all_cpu_info();
		
		$this->load->view('template',array('page'=>'cpu/viewall', 'data'=>$data));
	}
	
	function edit($cpu_id = NULL)
	{
		if (isset($cpu_id))
		{
			$this->form_validation->set_rules('cpu_name', 'CPU Name', 'trim|required|xss_clean|alpha_numeric|min_length[4]|strtoupper');
			$this->form_validation->set_rules('cpu_other_name', 'Other Name', 'trim|xss_clean');
			$this->form_validation->set_rules('cpu_sn', 'Serial number', 'trim|xss_clean|strtoupper');
			$this->form_validation->set_rules('cpu_processor', 'Processor', 'trim|xss_clean');
			$this->form_validation->set_rules('cpu_memory1', 'Memory 1', 'trim|xss_clean');
			$this->form_validation->set_rules('cpu_memory2', 'Memory 2', 'trim|xss_clean');
			$this->form_validation->set_rules('cpu_memory1_type', 'Memory 1', 'trim|xss_clean');
			$this->form_validation->set_rules('cpu_memory2_type', 'Memory 2', 'trim|xss_clean');
			$this->form_validation->set_rules('cpu_hd1', 'Hard Disk 1', 'trim|xss_clean');
			$this->form_validation->set_rules('cpu_hd2', 'Hard Disk 2', 'trim|xss_clean');
			$this->form_validation->set_rules('cpu_hd1_type', 'Hard Disk 1 Type', 'trim|xss_clean');
			$this->form_validation->set_rules('cpu_hd2_type', 'Hard Disk 2 Type', 'trim|xss_clean');
			$this->form_validation->set_rules('cpu_date_purchased', 'Date Purchased', 'trim|xss_clean');
			$this->form_validation->set_rules('cpu_hostname', 'Hostname', 'trim|xss_clean');
			$this->form_validation->set_rules('cpu_notes', 'Notes', 'trim|xss_clean');
			
			if($this->form_validation->run() == FALSE)
			{
				$processor = $this->db->get('nshis_choices_processor');
				$memory = $this->db->get('nshis_choices_memory');
				$memory_types = $this->db->get('nshis_choices_memory_types');
				$hd = $this->db->get('nshis_choices_hd');
				$hd_types = $this->db->get('nshis_choices_hd_types');
				$info = $this->CPU_model->get_cpu_info($cpu_id);
				
				$data = array('processor' => $processor, 'memory' => $memory, 'memory_types' => $memory_types, 'hd' => $hd, 'hd_types' => $hd_types, 'info' => $info);
				$this->load->view('template',array('page'=>'cpu/edit', 'data' => $data));
			}
//			else 
//			{
//				$cpu_name = $this->input->post('cpu_name');
//				$cpu_sn = $this->input->post('cpu_sn');
//				$cpu_notes = $this->input->post('cpu_notes');
//				
//				$id = $this->CPU_model->edit_cpu($cpu_id, $cpu_name, $cpu_sn, $cpu_notes);
//				
//				if ($id)
//				{
//					$this->Stats_model->insert_log($this->session->userdata('user_id'), $id, 'cpu', 'edit');
//					
//					redirect('/cpu/view/'.$id, 'refresh');
//				}
//				
//			}
			else 
			{
				$cpu_name = $this->input->post('cpu_name');
				$cpu_other_name = $this->input->post('cpu_other_name');
				$cpu_sn = $this->input->post('cpu_sn');
				$cpu_processor = $this->input->post('cpu_processor');
				$cpu_memory1 = $this->input->post('cpu_memory1');
				$cpu_memory2 = $this->input->post('cpu_memory2');
				$cpu_memory1_type = $this->input->post('cpu_memory1_type');
				$cpu_memory2_type = $this->input->post('cpu_memory2_type');
				$cpu_hd1 = $this->input->post('cpu_hd1');
				$cpu_hd2 = $this->input->post('cpu_hd2');
				$cpu_hd1_type = $this->input->post('cpu_hd1_type');
				$cpu_hd2_type = $this->input->post('cpu_hd2_type');
				$cpu_date_purchased = $this->input->post('cpu_date_purchased');
				$cpu_hostname = $this->input->post('cpu_hostname');
				$cpu_notes = $this->input->post('cpu_notes');
				
				$data = array(
					'name' => $cpu_name,
					'other_name' => $cpu_other_name,
					'serial_number' => $cpu_sn,
					'processor_id' => $cpu_processor,
					'memory1_id' => $cpu_memory1,
					'memory2_id' => $cpu_memory2,
					'memory1_type_id' => $cpu_memory1_type,
					'memory2_type_id' => $cpu_memory2_type,
					'hd1_id' => $cpu_hd1,
					'hd2_id' => $cpu_hd2,
					'hd1_type_id' => $cpu_hd1_type,
					'hd2_type_id' => $cpu_hd2_type,
					'date_purchased' => $cpu_date_purchased,
					'hostname' => $cpu_hostname,
					'notes' => $cpu_notes
				);
				$id = $this->CPU_model->edit_cpu($cpu_id, $data);
				
				if($id)
				{
					$this->Stats_model->insert_log($this->session->userdata('user_id'), $id, 'cpu', 'edit');
					
					redirect('/cpu/view/'.$id, 'refresh');
				}
			}
		}
		else
		{
			echo "Cannot edit empty cpu. Please go back into your previous page.";
		}
	}
	
	function delete($cpu_id)
	{
		$this->form_validation->set_rules('delete', 'Delete', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE)
		{
			$data = $this->CPU_model->get_cpu_info($cpu_id);
			$this->load->view('template',array('page'=>'cpu/delete', 'data' => $data));
		}
		else 
		{
			$delete = $this->input->post('delete');
			
			if($delete=='no')
			{
				redirect('/cpu/view/' . $cpu_id, 'refresh');
			}	
			else 
			{
				$id = $this->CPU_model->delete_cpu($cpu_id);
				
				if ($id)
				{
					$this->Stats_model->insert_log($this->session->userdata('user_id'), $id, 'cpu', 'delete');
					
					redirect('/cpu/viewall', 'refresh');
				}
			}		
		}
	}
	
	function transfer($cpu_id = NULL)
	{
		if (isset($cpu_id))
		{
			$this->form_validation->set_rules('cubicle_id', 'Cubicle', 'trim|required|xss_clean');
			
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->CPU_model->get_cubicle_cpu_info($cpu_id);
				$this->load->view('template',array('page'=>'cpu/transfer', 'data' => $data));
			}
			else
			{
				$cubicle_id = $this->input->post('cubicle_id');
				
				$id = $this->CPU_model->transfer($cpu_id, $cubicle_id);
				
				if ($id)
				{
					$this->Stats_model->insert_log($this->session->userdata('user_id'), $cpu_id, 'cpu', 'transfer');
					
					redirect('/cubicle/view/'.$id, 'refresh');
				}
				
				
			}
		}
		else
		{
			echo "Cannot transfer empty cpu. Please go back into your previous page.";
		}
	}
	
	function swap($cpu_id = NULL)
	{
		if (isset($cpu_id))
		{
			$this->form_validation->set_rules('cubicle_id', 'Cubicle', 'trim|required|xss_clean');
			
			if($this->form_validation->run() == FALSE)
			{
				$data = $this->CPU_model->get_cubicle_cpu_info($cpu_id);
				$this->load->view('template',array('page'=>'cpu/swap', 'data' => $data));
			}
			else
			{
				$cubicle_cpu_id = $this->input->post('cubicle_id');
				
				$id = $this->CPU_model->swap($cpu_id, $cubicle_cpu_id);
				
				if ($id)
				{
					$this->Stats_model->insert_log($this->session->userdata('user_id'), $cpu_id, 'cpu', 'swap');
					
					redirect('/cubicle/view/'.$id, 'refresh');
				}
			}
		}
		else
		{
			echo "Cannot swap empty cpu. Please go back into your previous page.";
		}
	}
	
	function comment($cpu_id)
	{
		$this->form_validation->set_rules('cpu_comment', 'Comment', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE)
		{
			$data = $this->CPU_model->get_cpu_info($cpu_id);
			$this->load->view('template',array('page'=>'cpu/comment', 'data' => $data));
		}
		else 
		{
			$comment = $this->input->post('cpu_comment');
			
			$id = $this->CPU_model->insert_comment($cpu_id, $comment);
			
			if ($id)
			{
				$this->Stats_model->insert_log($this->session->userdata('user_id'), $id, 'cpu', 'comment');
			
				redirect('/cpu/view/'.$id, 'refresh');
			}
		}
	}
	
	function available()
	{
		$data = $this->CPU_model->get_all_cpu_info();
		
		if ($data)
		{
			$this->load->view('template',array('page'=>'cpu/available', 'data' => $data));
		}
	}
	
	function deployed()
	{
		$data = $this->CPU_model->get_all_cpu_info();
		
		if ($data)
		{
			$this->load->view('template',array('page'=>'cpu/deployed', 'data' => $data));
		}
	}
	
	function unique($cpu_name)
	{
		$exist = $this->CPU_model->check_cpu_exist($cpu_name);
		
		if($exist)
		{
			$info = $this->CPU_model->get_cpu_info_by_name($cpu_name);
			
			$this->form_validation->set_message('unique', anchor('cpu/view/'.$info['cpu_id'],$info['name']).' already exist.');
			
			return false;
		}
		else 
		{
			return true;
		}
	}
	
	function pullout($cpu_id)
	{
		$return = $this->CPU_model->pull_out($cpu_id);
		
		if ($return) 
		{
			$this->Stats_model->insert_log($this->session->userdata('user_id'), $cpu_id, 'cpu', 'pullout', $return);
			
			redirect('/cpu/view/'.$cpu_id, 'refresh');
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