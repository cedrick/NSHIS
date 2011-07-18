<?php 

class CPU_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function check_cpu_exist($cpu_name)
	{
		$return = $this->db->get_where('nshis_cpus', array('name' => $cpu_name));
		
		if($return->num_rows() > 0)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	function insert_new_cpu($data) 
	{
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_cpus', $data); 
		
		$id = $this->db->insert_id();
		
		if ($return)
		{
			return $id;
		}
		else 
		{
			return false;
		}
	}
	
	function assign_cpu($cpu_id, $cubicle) 
	{
		$data = array(
        	'flag_assigned' => 0,
            'cubicle_id' => 0,
        );
            
		$update1 = $this->db->update('nshis_cpus', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'cpu' => $cpu_id,
        );
            
		$update2 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle,
        );
            
		$update3 = $this->db->update('nshis_cpus', $data, array('cpu_id' => $cpu_id));
		
		if($update1 && $update2 && $update3)
		{
			return $cubicle;
		}
		else 
		{
			return false;
		}
	}
	
	function transfer($cpu_id, $cubicle)
	{
		$data = array(
        	'flag_assigned' => 0,
            'cubicle_id' => 0
        );
            
		$update1 = $this->db->update('nshis_cpus', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'cpu' => 0
        );
            
		$update2 = $this->db->update('nshis_cubicles', $data, array('cpu' => $cpu_id));
		
		$data = array(
        	'cpu' => $cpu_id
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle
        );
            
		$update4 = $this->db->update('nshis_cpus', $data, array('cpu_id' => $cpu_id));
		
		if ($update1 && $update2 && $update3 && $update4)
		{
			return $cubicle;
		}
		else 
		{
			return false;
		}
		
		
	}
	
	function swap($cpu_id, $cubicle_cpu_id)
	{
		$id = explode('|', $cubicle_cpu_id);
		
		$dest_cubicle = $id[0];
		$dest_cpu = $id[1];
		
		$query = $this->db->get_where('nshis_cpus', array('cpu_id' => $cpu_id));
		foreach ($query->result() as $row)
		{
		    $source_cubicle = $row->cubicle_id;
		    $source_cpu = $cpu_id;
		}
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $dest_cubicle
        );
            
		$update1 = $this->db->update('nshis_cpus', $data, array('cpu_id' => $source_cpu));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $source_cubicle
        );
            
		$update2 = $this->db->update('nshis_cpus', $data, array('cpu_id' => $dest_cpu));
		
		$data = array(
        	'cpu' => $dest_cpu
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $source_cubicle));
		
		$data = array(
        	'cpu' => $source_cpu
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $dest_cubicle));
		
		if ($update1 && $update2 && $update3)
		{
			$this->devicelog->insert_log($this->session->userdata('user_id'), $cpu_id, 'cpu', 'swap', $dest_cubicle, array('swap_device_id' => $dest_cpu, 'swap_cubicle_id' => $source_cubicle));
			
			return $dest_cubicle;
		}
		else 
		{
			return false;
		}
		
		
	}
	
	function get_available_cpus()
	{
		$return = $this->db->get_where('nshis_cpus', array('flag_assigned' => 0, 'status' => 1));
		
		if($return->num_rows() > 0)
		{
			return $return;
		}
		else 
		{
			return false;
		}
	}
	
	function get_cpu_info($cpu_id)
	{
		
		$this->db->select('nshis_cpus.*, nshis_choices_processor.*, nshis_choices_memory1.memory_name AS memory1_name, nshis_choices_memory2.memory_name AS memory2_name, nshis_choices_memory1_type.name_type AS memory1_type_name, nshis_choices_memory2_type.name_type AS memory2_type_name, nshis_choices_hd1.hd_name AS hd1_name, nshis_choices_hd2.hd_name AS hd2_name, nshis_choices_hd1_type.name_type AS hd1_type_name, nshis_choices_hd2_type.name_type AS hd2_type_name, nshis_cpus.cpu_id, nshis_cpus.serial_number, nshis_cpus.cdate, nshis_cpus.name as cpu_name, nshis_cpus.notes, nshis_cubicles.name as cb_name, nshis_cubicles.cubicle_id as cb_id');
		$this->db->from('nshis_cpus');
		$this->db->join('nshis_cubicles', 'nshis_cpus.cubicle_id = nshis_cubicles.cubicle_id','left');
		$this->db->join('nshis_choices_processor', 'nshis_cpus.processor_id = nshis_choices_processor.processor_id','left');
		$this->db->join('nshis_choices_memory AS nshis_choices_memory1', 'nshis_cpus.memory1_id = nshis_choices_memory1.memory_id','left');
		$this->db->join('nshis_choices_memory AS nshis_choices_memory2', 'nshis_cpus.memory2_id = nshis_choices_memory2.memory_id','left');
		$this->db->join('nshis_choices_memory_types AS nshis_choices_memory1_type', 'nshis_cpus.memory1_type_id = nshis_choices_memory1_type.memory_type_id','left');
		$this->db->join('nshis_choices_memory_types AS nshis_choices_memory2_type', 'nshis_cpus.memory2_type_id = nshis_choices_memory2_type.memory_type_id','left');
		$this->db->join('nshis_choices_hd AS nshis_choices_hd1', 'nshis_cpus.hd1_id = nshis_choices_hd1.hd_id','left');
		$this->db->join('nshis_choices_hd AS nshis_choices_hd2', 'nshis_cpus.hd2_id = nshis_choices_hd2.hd_id','left');
		$this->db->join('nshis_choices_hd_types AS nshis_choices_hd1_type', 'nshis_cpus.hd1_type_id = nshis_choices_hd1_type.hd_type_id','left');
		$this->db->join('nshis_choices_hd_types AS nshis_choices_hd2_type', 'nshis_cpus.hd2_type_id = nshis_choices_hd2_type.hd_type_id','left');
		$this->db->where('nshis_cpus.cpu_id', $cpu_id); 
		
		$return = $this->db->get();
		
		
//		$return = $this->db->get_where('nshis_cpus', array('cpu_id' => $cpu_id));
		
//		$query_str = "SELECT * FROM nshis_cpus WHERE cpu_id = ? LIMIT 1";
//		
//		$return = $this->db->query($query_str, array($cpu_id));
		
		if($return->num_rows() > 0)
		{
//			$row = $return->row_array(); 
			return $return;
		}
		else 
		{
			return false;
		}
	}
	
	function get_cpu_info_by_name($cpu_name)
	{
		$query_str = "SELECT * FROM nshis_cpus WHERE name = ? LIMIT 1";
		
		$return = $this->db->query($query_str, array(trim($cpu_name)));
		
		if($return->num_rows() > 0)
		{
			$row = $return->row_array(); 
			return $row;
		}
		else 
		{
			return false;
		}
	}
	
	function get_all_cpu_info()
	{
		$this->db->select('nshis_cpus.cpu_id, nshis_cpus.other_name, nshis_cpus.cubicle_id,  nshis_cpus.flag_assigned, nshis_cpus.serial_number, nshis_cpus.name as cpu_name, nshis_cubicles.name as cb_name, nshis_cubicles.cubicle_id as cb_id');
		$this->db->from('nshis_cpus');
		$this->db->join('nshis_cubicles', 'nshis_cpus.cubicle_id = nshis_cubicles.cubicle_id','left');
		$this->db->order_by('nshis_cpus.name', 'asc'); 
		$return = $this->db->get();
		
		if($return->num_rows() > 0)
		{
			return $return;
		}
		else 
		{
			return false;
		}
	}
	
	function insert_comment($cpu_id, $comment)
	{
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'device_id' => $cpu_id,
			'device' => 'cpu',
			'comment' => $comment
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_comments', $data); 
		
		if($return)
		{
			return $cpu_id;
		}
		else
		{
			return false;
		}
	}
	
	function get_comments($cpu_id)
	{
		$this->db->select('nshis_comments.comment, nshis_comments.cdate, nshis_users.username');
		$this->db->from('nshis_comments');
		$this->db->join('nshis_users', 'nshis_users.ID = nshis_comments.user_id','right');
		$this->db->where('nshis_comments.device_id', $cpu_id);
		$this->db->where('nshis_comments.device', 'cpu');
		$this->db->order_by('nshis_comments.cdate', 'desc'); 
		$return = $this->db->get();
		
		if($return->num_rows() > 0)
		{
			return $return;
		}
		else 
		{
			return false;
		}
	}
	
	function edit_cpu($cpu_id, $data)
	{
//		$data = array(
//			'name' => $cpu_name,
//			'serial_number' => $cpu_sn,
//			'notes'	=> $notes
//		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		$this->db->where('cpu_id', $cpu_id);
		$return = $this->db->update('nshis_cpus', $data); 
		
		if($return)
		{
			return $cpu_id;
		}
		else 
		{
			return false;
//			redirect('/user/register/', 'refresh');
		}
	}
	
	function delete_cpu($cpu_id)
	{
		$delete = $this->db->delete('nshis_cpus', array('cpu_id' => $cpu_id)); 
		
		$data = array(
			'cpu' => 0,
		);
		$this->db->where('cpu', $cpu_id);
		$return = $this->db->update('nshis_cubicles', $data);
		
		if ($delete && $return)
		{
			return $cpu_id;
		}
		else
		{
			return false;
		}
	}
	
	function get_cubicle_cpu_info($cpu_id = NULL)
	{
		$this->db->select('nshis_cpus.cpu_id, nshis_cpus.name as cpu_name, nshis_cubicles.cubicle_id, nshis_cubicles.name as cb_name');
		$this->db->from('nshis_cpus');
		$this->db->join('nshis_cubicles', 'nshis_cpus.cubicle_id = nshis_cubicles.cubicle_id','right');
		$this->db->order_by('nshis_cubicles.name', 'asc'); 
		$return = $this->db->get();
		
		if($return->num_rows() > 0)
		{
			return $return;
		}
		else 
		{
			return false;
		}
	}
	
	function pull_out($cpu_id)
	{
		$cpu = $this->db->get_where('nshis_cpus', array('cpu_id' => $cpu_id), 1);
		$row = $cpu->row_array();
		$cubicle_id = $row['cubicle_id'];
		
		if($cubicle_id)
		{
			$data = array(
	        	'flag_assigned' => 0,
	            'cubicle_id' => 0
	        );
	            
			$update1 = $this->db->update('nshis_cpus', $data, array('cpu_id' => $cpu_id));
			
			$data = array(
	        	'cpu' => 0
	        );
	            
			$update2 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle_id));
			
			if ($update1 && $update2)
			{
				return $cubicle_id;
			}
			else
			{
				return false;
			}
		}else 
		{
			return false;
		}
	}
	
	
	
}