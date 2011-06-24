<?php 

class Headset_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function check_headset_exist($headset_name)
	{
		$return = $this->db->get_where('nshis_headsets', array('name' => $headset_name));
		
		if($return->num_rows() > 0)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	function insert_new_headset($headset_name, $other_name, $serial_number, $date_purchased, $notes) 
	{
		$data = array(
			'name' => $headset_name,
			'other_name' => $other_name,
			'serial_number' => $serial_number,
			'date_purchased' => $date_purchased,
			'notes' => $notes
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_headsets', $data); 
		
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
	
	function assign_headset($headset_id, $cubicle) 
	{
		$data = array(
        	'flag_assigned' => 0,
            'cubicle_id' => 0,
        );
            
		$update1 = $this->db->update('nshis_headsets', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'headset' => $headset_id,
        );
            
		$update2 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle,
        );
            
		$update3 = $this->db->update('nshis_headsets', $data, array('headset_id' => $headset_id));
		
		if($update1 && $update2 && $update3)
		{
			return $cubicle;
		}
		else 
		{
			return false;
		}
	}
	
	function transfer($headset_id, $cubicle)
	{
		$data = array(
        	'flag_assigned' => 0,
            'cubicle_id' => 0
        );
            
		$update1 = $this->db->update('nshis_headsets', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'headset' => 0
        );
            
		$update2 = $this->db->update('nshis_cubicles', $data, array('headset' => $headset_id));
		
		$data = array(
        	'headset' => $headset_id
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle
        );
            
		$update4 = $this->db->update('nshis_headsets', $data, array('headset_id' => $headset_id));
		
		if ($update1 && $update2 && $update3 && $update4)
		{
			return $cubicle;
		}
		else 
		{
			return false;
		}
		
		
	}
	
	function swap($headset_id, $cubicle_headset_id)
	{
		$id = explode('|', $cubicle_headset_id);
		
		$dest_cubicle = $id[0];
		$dest_headset = $id[1];
		
		$query = $this->db->get_where('nshis_headsets', array('headset_id' => $headset_id));
		foreach ($query->result() as $row)
		{
		    $source_cubicle = $row->cubicle_id;
		    $source_headset = $headset_id;
		}
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $dest_cubicle
        );
            
		$update1 = $this->db->update('nshis_headsets', $data, array('headset_id' => $source_headset));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $source_cubicle
        );
            
		$update2 = $this->db->update('nshis_headsets', $data, array('headset_id' => $dest_headset));
		
		$data = array(
        	'headset' => $dest_headset
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $source_cubicle));
		
		$data = array(
        	'headset' => $source_headset
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $dest_cubicle));
		
		if ($update1 && $update2 && $update3)
		{
			return $dest_cubicle;
		}
		else 
		{
			return false;
		}
		
		
	}
	
	function get_available_headsets()
	{
		$return = $this->db->get_where('nshis_headsets', array('flag_assigned' => 0));
		
		if($return->num_rows() > 0)
		{
			return $return;
		}
		else 
		{
			return false;
		}
	}
	
	function get_headset_info($headset_id)
	{
		
		$this->db->select('nshis_headsets.headset_id, nshis_headsets.serial_number, nshis_headsets.cdate, nshis_headsets.name as headset_name,  nshis_headsets.other_name, nshis_headsets.notes, nshis_headsets.date_purchased, nshis_cubicles.name as cb_name, nshis_cubicles.cubicle_id as cb_id');
		$this->db->from('nshis_headsets');
		$this->db->join('nshis_cubicles', 'nshis_headsets.cubicle_id = nshis_cubicles.cubicle_id','left');
		$this->db->where('nshis_headsets.headset_id', $headset_id); 
		
		$return = $this->db->get();
		
		
//		$return = $this->db->get_where('nshis_headsets', array('headset_id' => $headset_id));
		
//		$query_str = "SELECT * FROM nshis_headsets WHERE headset_id = ? LIMIT 1";
//		
//		$return = $this->db->query($query_str, array($headset_id));
		
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
	
	function get_headset_info_by_name($headset_name)
	{
		$query_str = "SELECT * FROM nshis_headsets WHERE name = ? LIMIT 1";
		
		$return = $this->db->query($query_str, array(trim($headset_name)));
		
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
	
	function get_all_headset_info()
	{
		$this->db->select('nshis_headsets.headset_id, nshis_headsets.cubicle_id,  nshis_headsets.flag_assigned, nshis_headsets.serial_number, nshis_headsets.name as headset_name,  nshis_headsets.other_name, nshis_cubicles.name as cb_name');
		$this->db->from('nshis_headsets');
		$this->db->join('nshis_cubicles', 'nshis_headsets.cubicle_id = nshis_cubicles.cubicle_id','left');
		$this->db->order_by('nshis_headsets.name', 'asc'); 
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
	
	function insert_comment($headset_id, $comment)
	{
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'device_id' => $headset_id,
			'device' => 'headset',
			'comment' => $comment
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_comments', $data); 
		
		if($return)
		{
			return $headset_id;
		}
		else
		{
			return false;
		}
	}
	
	function get_comments($headset_id)
	{
		$this->db->select('nshis_comments.comment, nshis_comments.cdate, nshis_users.username');
		$this->db->from('nshis_comments');
		$this->db->join('nshis_users', 'nshis_users.ID = nshis_comments.user_id','right');
		$this->db->where('nshis_comments.device_id', $headset_id);
		$this->db->where('nshis_comments.device', 'headset');
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
	
	function edit_headset($headset_id, $headset_name, $headset_other_name, $headset_sn, $headset_date_purchased, $notes)
	{
		$data = array(
			'name' => $headset_name,
			'other_name' => $headset_other_name,
			'serial_number' => $headset_sn,
			'date_purchased' => $headset_date_purchased,
			'notes'	=> $notes
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		$this->db->where('headset_id', $headset_id);
		$return = $this->db->update('nshis_headsets', $data); 
		
		if($return)
		{
			return $headset_id;
		}
		else 
		{
			return false;
//			redirect('/user/register/', 'refresh');
		}
	}
	
	function delete_headset($headset_id)
	{
		$delete = $this->db->delete('nshis_headsets', array('headset_id' => $headset_id)); 
		
		$data = array(
			'headset' => 0,
		);
		$this->db->where('headset', $headset_id);
		$return = $this->db->update('nshis_cubicles', $data);
		
		if ($delete && $return)
		{
			return $headset_id;
		}
		else
		{
			return false;
		}
	}
	
	function get_cubicle_headset_info($headset_id = NULL)
	{
		$this->db->select('nshis_headsets.headset_id, nshis_headsets.name as headset_name, nshis_cubicles.cubicle_id, nshis_cubicles.name as cb_name');
		$this->db->from('nshis_headsets');
		$this->db->join('nshis_cubicles', 'nshis_headsets.cubicle_id = nshis_cubicles.cubicle_id','right');
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
	
	function pull_out($headset_id)
	{
		$headset = $this->db->get_where('nshis_headsets', array('headset_id' => $headset_id), 1);
		$row = $headset->row_array();
		$cubicle_id = $row['cubicle_id'];
		
		if($cubicle_id)
		{
			$data = array(
	        	'flag_assigned' => 0,
	            'cubicle_id' => 0
	        );
	            
			$update1 = $this->db->update('nshis_headsets', $data, array('headset_id' => $headset_id));
			
			$data = array(
	        	'headset' => 0
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