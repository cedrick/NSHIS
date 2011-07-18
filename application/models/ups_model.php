<?php 

class Ups_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function check_ups_exist($ups_name)
	{
		$return = $this->db->get_where('nshis_upss', array('name' => $ups_name));
		
		if($return->num_rows() > 0)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	function insert_new_ups($ups_name, $other_name, $serial_number, $date_purchased, $notes) 
	{
		$data = array(
			'name' => $ups_name,
			'other_name' => $other_name,
			'serial_number' => $serial_number,
			'date_purchased' => $date_purchased,
			'notes' => $notes
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_upss', $data); 
		
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
	
	function assign_ups($ups_id, $cubicle) 
	{
		$data = array(
        	'flag_assigned' => 0,
            'cubicle_id' => 0,
        );
            
		$update1 = $this->db->update('nshis_upss', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'ups' => $ups_id,
        );
            
		$update2 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle,
        );
            
		$update3 = $this->db->update('nshis_upss', $data, array('ups_id' => $ups_id));
		
		if($update1 && $update2 && $update3)
		{
			return $cubicle;
		}
		else 
		{
			return false;
		}
	}
	
	function transfer($ups_id, $cubicle)
	{
		$data = array(
        	'flag_assigned' => 0,
            'cubicle_id' => 0
        );
            
		$update1 = $this->db->update('nshis_upss', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'ups' => 0
        );
            
		$update2 = $this->db->update('nshis_cubicles', $data, array('ups' => $ups_id));
		
		$data = array(
        	'ups' => $ups_id
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle
        );
            
		$update4 = $this->db->update('nshis_upss', $data, array('ups_id' => $ups_id));
		
		if ($update1 && $update2 && $update3 && $update4)
		{
			return $cubicle;
		}
		else 
		{
			return false;
		}
		
		
	}
	
	function swap($ups_id, $cubicle_ups_id)
	{
		$id = explode('|', $cubicle_ups_id);
		
		$dest_cubicle = $id[0];
		$dest_ups = $id[1];
		
		$query = $this->db->get_where('nshis_upss', array('ups_id' => $ups_id));
		foreach ($query->result() as $row)
		{
		    $source_cubicle = $row->cubicle_id;
		    $source_ups = $ups_id;
		}
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $dest_cubicle
        );
            
		$update1 = $this->db->update('nshis_upss', $data, array('ups_id' => $source_ups));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $source_cubicle
        );
            
		$update2 = $this->db->update('nshis_upss', $data, array('ups_id' => $dest_ups));
		
		$data = array(
        	'ups' => $dest_ups
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $source_cubicle));
		
		$data = array(
        	'ups' => $source_ups
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $dest_cubicle));
		
		if ($update1 && $update2 && $update3)
		{
			$this->devicelog->insert_log($this->session->userdata('user_id'), $ups_id, 'ups', 'swap', $dest_cubicle, array('swap_device_id' => $dest_ups, 'swap_cubicle_id' => $source_cubicle));
			
			return $dest_cubicle;
		}
		else 
		{
			return false;
		}
		
		
	}
	
	function get_available_upss()
	{
		$return = $this->db->get_where('nshis_upss', array('flag_assigned' => 0, 'status' => 1));
		
		if($return->num_rows() > 0)
		{
			return $return;
		}
		else 
		{
			return false;
		}
	}
	
	function get_ups_info($ups_id)
	{
		
		$this->db->select('nshis_upss.ups_id, nshis_upss.serial_number, nshis_upss.cdate, nshis_upss.name as ups_name,  nshis_upss.other_name, nshis_upss.notes, nshis_upss.date_purchased, nshis_cubicles.name as cb_name, nshis_cubicles.cubicle_id as cb_id');
		$this->db->from('nshis_upss');
		$this->db->join('nshis_cubicles', 'nshis_upss.cubicle_id = nshis_cubicles.cubicle_id','left');
		$this->db->where('nshis_upss.ups_id', $ups_id); 
		
		$return = $this->db->get();
		
		
//		$return = $this->db->get_where('nshis_upss', array('ups_id' => $ups_id));
		
//		$query_str = "SELECT * FROM nshis_upss WHERE ups_id = ? LIMIT 1";
//		
//		$return = $this->db->query($query_str, array($ups_id));
		
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
	
	function get_ups_info_by_name($ups_name)
	{
		$query_str = "SELECT * FROM nshis_upss WHERE name = ? LIMIT 1";
		
		$return = $this->db->query($query_str, array(trim($ups_name)));
		
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
	
	function get_all_ups_info()
	{
		$this->db->select('nshis_upss.ups_id, nshis_upss.cubicle_id,  nshis_upss.flag_assigned, nshis_upss.serial_number, nshis_upss.name as ups_name,  nshis_upss.other_name, nshis_cubicles.name as cb_name');
		$this->db->from('nshis_upss');
		$this->db->join('nshis_cubicles', 'nshis_upss.cubicle_id = nshis_cubicles.cubicle_id','left');
		$this->db->order_by('nshis_upss.name', 'asc'); 
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
	
	function insert_comment($ups_id, $comment)
	{
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'device_id' => $ups_id,
			'device' => 'ups',
			'comment' => $comment
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_comments', $data); 
		
		if($return)
		{
			return $ups_id;
		}
		else
		{
			return false;
		}
	}
	
	function get_comments($ups_id)
	{
		$this->db->select('nshis_comments.comment, nshis_comments.cdate, nshis_users.username');
		$this->db->from('nshis_comments');
		$this->db->join('nshis_users', 'nshis_users.ID = nshis_comments.user_id','right');
		$this->db->where('nshis_comments.device_id', $ups_id);
		$this->db->where('nshis_comments.device', 'ups');
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
	
	function edit_ups($ups_id, $ups_name, $ups_other_name, $ups_sn, $ups_date_purchased, $notes)
	{
		$data = array(
			'name' => $ups_name,
			'other_name' => $ups_other_name,
			'serial_number' => $ups_sn,
			'date_purchased' => $ups_date_purchased,
			'notes'	=> $notes
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		$this->db->where('ups_id', $ups_id);
		$return = $this->db->update('nshis_upss', $data); 
		
		if($return)
		{
			return $ups_id;
		}
		else 
		{
			return false;
//			redirect('/user/register/', 'refresh');
		}
	}
	
	function delete_ups($ups_id)
	{
		$delete = $this->db->delete('nshis_upss', array('ups_id' => $ups_id)); 
		
		$data = array(
			'ups' => 0,
		);
		$this->db->where('ups', $ups_id);
		$return = $this->db->update('nshis_cubicles', $data);
		
		if ($delete && $return)
		{
			return $ups_id;
		}
		else
		{
			return false;
		}
	}
	
	function get_cubicle_ups_info($ups_id = NULL)
	{
		$this->db->select('nshis_upss.ups_id, nshis_upss.name as ups_name, nshis_cubicles.cubicle_id, nshis_cubicles.name as cb_name');
		$this->db->from('nshis_upss');
		$this->db->join('nshis_cubicles', 'nshis_upss.cubicle_id = nshis_cubicles.cubicle_id','right');
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
	
	function pull_out($ups_id)
	{
		$ups = $this->db->get_where('nshis_upss', array('ups_id' => $ups_id), 1);
		$row = $ups->row_array();
		$cubicle_id = $row['cubicle_id'];
		
		if($cubicle_id)
		{
			$data = array(
	        	'flag_assigned' => 0,
	            'cubicle_id' => 0
	        );
	            
			$update1 = $this->db->update('nshis_upss', $data, array('ups_id' => $ups_id));
			
			$data = array(
	        	'ups' => 0
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