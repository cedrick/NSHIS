<?php 

class Dialpad_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function check_dialpad_exist($dialpad_name)
	{
		$return = $this->db->get_where('nshis_dialpads', array('name' => $dialpad_name));
		
		if($return->num_rows() > 0)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	function insert_new_dialpad($dialpad_name, $other_name, $serial_number, $date_purchased, $notes) 
	{
		$data = array(
			'name' => $dialpad_name,
			'other_name' => $other_name,
			'serial_number' => $serial_number,
			'date_purchased' => $date_purchased,
			'notes' => $notes
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_dialpads', $data); 
		
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
	
	function assign_dialpad($dialpad_id, $cubicle) 
	{
		$data = array(
        	'flag_assigned' => 0,
            'cubicle_id' => 0,
        );
            
		$update1 = $this->db->update('nshis_dialpads', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'dialpad' => $dialpad_id,
        );
            
		$update2 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle,
        );
            
		$update3 = $this->db->update('nshis_dialpads', $data, array('dialpad_id' => $dialpad_id));
		
		if($update1 && $update2 && $update3)
		{
			return $cubicle;
		}
		else 
		{
			return false;
		}
	}
	
	function transfer($dialpad_id, $cubicle)
	{
		$data = array(
        	'flag_assigned' => 0,
            'cubicle_id' => 0
        );
            
		$update1 = $this->db->update('nshis_dialpads', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'dialpad' => 0
        );
            
		$update2 = $this->db->update('nshis_cubicles', $data, array('dialpad' => $dialpad_id));
		
		$data = array(
        	'dialpad' => $dialpad_id
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle
        );
            
		$update4 = $this->db->update('nshis_dialpads', $data, array('dialpad_id' => $dialpad_id));
		
		if ($update1 && $update2 && $update3 && $update4)
		{
			return $cubicle;
		}
		else 
		{
			return false;
		}
		
		
	}
	
	function swap($dialpad_id, $cubicle_dialpad_id)
	{
		$id = explode('|', $cubicle_dialpad_id);
		
		$dest_cubicle = $id[0];
		$dest_dialpad = $id[1];
		
		$query = $this->db->get_where('nshis_dialpads', array('dialpad_id' => $dialpad_id));
		foreach ($query->result() as $row)
		{
		    $source_cubicle = $row->cubicle_id;
		    $source_dialpad = $dialpad_id;
		}
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $dest_cubicle
        );
            
		$update1 = $this->db->update('nshis_dialpads', $data, array('dialpad_id' => $source_dialpad));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $source_cubicle
        );
            
		$update2 = $this->db->update('nshis_dialpads', $data, array('dialpad_id' => $dest_dialpad));
		
		$data = array(
        	'dialpad' => $dest_dialpad
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $source_cubicle));
		
		$data = array(
        	'dialpad' => $source_dialpad
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $dest_cubicle));
		
		if ($update1 && $update2 && $update3)
		{
			$this->devicelog->insert_log($this->session->userdata('user_id'), $dialpad_id, 'dialpad', 'swap', $dest_cubicle, array('swap_device_id' => $dest_dialpad, 'swap_cubicle_id' => $source_cubicle));
			
			return $dest_cubicle;
		}
		else 
		{
			return false;
		}
		
		
	}
	
	function get_available_dialpads()
	{
		$return = $this->db->get_where('nshis_dialpads', array('flag_assigned' => 0, 'status' => 1));
		
		if($return->num_rows() > 0)
		{
			return $return;
		}
		else 
		{
			return false;
		}
	}
	
	function get_dialpad_info($dialpad_id)
	{
		
		$this->db->select('nshis_dialpads.dialpad_id, nshis_dialpads.serial_number, nshis_dialpads.cdate, nshis_dialpads.name as dialpad_name,  nshis_dialpads.other_name, nshis_dialpads.notes, nshis_dialpads.date_purchased, nshis_cubicles.name as cb_name, nshis_cubicles.cubicle_id as cb_id');
		$this->db->from('nshis_dialpads');
		$this->db->join('nshis_cubicles', 'nshis_dialpads.cubicle_id = nshis_cubicles.cubicle_id','left');
		$this->db->where('nshis_dialpads.dialpad_id', $dialpad_id); 
		
		$return = $this->db->get();
		
		
//		$return = $this->db->get_where('nshis_dialpads', array('dialpad_id' => $dialpad_id));
		
//		$query_str = "SELECT * FROM nshis_dialpads WHERE dialpad_id = ? LIMIT 1";
//		
//		$return = $this->db->query($query_str, array($dialpad_id));
		
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
	
	function get_dialpad_info_by_name($dialpad_name)
	{
		$query_str = "SELECT * FROM nshis_dialpads WHERE name = ? LIMIT 1";
		
		$return = $this->db->query($query_str, array(trim($dialpad_name)));
		
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
	
	function get_all_dialpad_info()
	{
		$this->db->select('nshis_dialpads.dialpad_id, nshis_dialpads.cubicle_id,  nshis_dialpads.flag_assigned, nshis_dialpads.serial_number, nshis_dialpads.name as dialpad_name,  nshis_dialpads.other_name, nshis_cubicles.name as cb_name');
		$this->db->from('nshis_dialpads');
		$this->db->join('nshis_cubicles', 'nshis_dialpads.cubicle_id = nshis_cubicles.cubicle_id','left');
		$this->db->order_by('nshis_dialpads.name', 'asc'); 
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
	
	function insert_comment($dialpad_id, $comment)
	{
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'device_id' => $dialpad_id,
			'device' => 'dialpad',
			'comment' => $comment
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_comments', $data); 
		
		if($return)
		{
			return $dialpad_id;
		}
		else
		{
			return false;
		}
	}
	
	function get_comments($dialpad_id)
	{
		$this->db->select('nshis_comments.comment, nshis_comments.cdate, nshis_users.username');
		$this->db->from('nshis_comments');
		$this->db->join('nshis_users', 'nshis_users.ID = nshis_comments.user_id','right');
		$this->db->where('nshis_comments.device_id', $dialpad_id);
		$this->db->where('nshis_comments.device', 'dialpad');
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
	
	function edit_dialpad($dialpad_id, $dialpad_name, $dialpad_other_name, $dialpad_sn, $dialpad_date_purchased, $notes)
	{
		$data = array(
			'name' => $dialpad_name,
			'other_name' => $dialpad_other_name,
			'serial_number' => $dialpad_sn,
			'date_purchased' => $dialpad_date_purchased,
			'notes'	=> $notes
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		$this->db->where('dialpad_id', $dialpad_id);
		$return = $this->db->update('nshis_dialpads', $data); 
		
		if($return)
		{
			return $dialpad_id;
		}
		else 
		{
			return false;
//			redirect('/user/register/', 'refresh');
		}
	}
	
	function delete_dialpad($dialpad_id)
	{
		$delete = $this->db->delete('nshis_dialpads', array('dialpad_id' => $dialpad_id)); 
		
		$data = array(
			'dialpad' => 0,
		);
		$this->db->where('dialpad', $dialpad_id);
		$return = $this->db->update('nshis_cubicles', $data);
		
		if ($delete && $return)
		{
			return $dialpad_id;
		}
		else
		{
			return false;
		}
	}
	
	function get_cubicle_dialpad_info($dialpad_id = NULL)
	{
		$this->db->select('nshis_dialpads.dialpad_id, nshis_dialpads.name as dialpad_name, nshis_cubicles.cubicle_id, nshis_cubicles.name as cb_name');
		$this->db->from('nshis_dialpads');
		$this->db->join('nshis_cubicles', 'nshis_dialpads.cubicle_id = nshis_cubicles.cubicle_id','right');
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
	
	function pull_out($dialpad_id)
	{
		$dialpad = $this->db->get_where('nshis_dialpads', array('dialpad_id' => $dialpad_id), 1);
		$row = $dialpad->row_array();
		$cubicle_id = $row['cubicle_id'];
		
		if($cubicle_id)
		{
			$data = array(
	        	'flag_assigned' => 0,
	            'cubicle_id' => 0
	        );
	            
			$update1 = $this->db->update('nshis_dialpads', $data, array('dialpad_id' => $dialpad_id));
			
			$data = array(
	        	'dialpad' => 0
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