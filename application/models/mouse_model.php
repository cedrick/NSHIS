<?php 

class Mouse_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function check_mouse_exist($mouse_name)
	{
		$return = $this->db->get_where('nshis_mouses', array('name' => $mouse_name));
		
		if($return->num_rows() > 0)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	function insert_new_mouse($mouse_name, $other_name, $serial_number, $date_purchased, $notes) 
	{
		$data = array(
			'name' => $mouse_name,
			'other_name' => $other_name,
			'serial_number' => $serial_number,
			'date_purchased' => $date_purchased,
			'notes' => $notes
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_mouses', $data); 
		
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
	
	function assign_mouse($mouse_id, $cubicle) 
	{
		$data = array(
        	'flag_assigned' => 0,
            'cubicle_id' => 0,
        );
            
		$update1 = $this->db->update('nshis_mouses', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'mouse' => $mouse_id,
        );
            
		$update2 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle,
        );
            
		$update3 = $this->db->update('nshis_mouses', $data, array('mouse_id' => $mouse_id));
		
		if($update1 && $update2 && $update3)
		{
			return $cubicle;
		}
		else 
		{
			return false;
		}
	}
	
	function transfer($mouse_id, $cubicle)
	{
		$data = array(
        	'flag_assigned' => 0,
            'cubicle_id' => 0
        );
            
		$update1 = $this->db->update('nshis_mouses', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'mouse' => 0
        );
            
		$update2 = $this->db->update('nshis_cubicles', $data, array('mouse' => $mouse_id));
		
		$data = array(
        	'mouse' => $mouse_id
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle
        );
            
		$update4 = $this->db->update('nshis_mouses', $data, array('mouse_id' => $mouse_id));
		
		if ($update1 && $update2 && $update3 && $update4)
		{
			return $cubicle;
		}
		else 
		{
			return false;
		}
		
		
	}
	
	function swap($mouse_id, $cubicle_mouse_id)
	{
		$id = explode('|', $cubicle_mouse_id);
		
		$dest_cubicle = $id[0];
		$dest_mouse = $id[1];
		
		$query = $this->db->get_where('nshis_mouses', array('mouse_id' => $mouse_id));
		foreach ($query->result() as $row)
		{
		    $source_cubicle = $row->cubicle_id;
		    $source_mouse = $mouse_id;
		}
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $dest_cubicle
        );
            
		$update1 = $this->db->update('nshis_mouses', $data, array('mouse_id' => $source_mouse));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $source_cubicle
        );
            
		$update2 = $this->db->update('nshis_mouses', $data, array('mouse_id' => $dest_mouse));
		
		$data = array(
        	'mouse' => $dest_mouse
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $source_cubicle));
		
		$data = array(
        	'mouse' => $source_mouse
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $dest_cubicle));
		
		if ($update1 && $update2 && $update3)
		{
			$this->devicelog->insert_log($this->session->userdata('user_id'), $mouse_id, 'mouse', 'swap', $dest_cubicle, array('swap_device_id' => $dest_mouse, 'swap_cubicle_id' => $source_cubicle));
			
			return $dest_cubicle;
		}
		else 
		{
			return false;
		}
		
		
	}
	
	function get_available_mouses()
	{
		$return = $this->db->get_where('nshis_mouses', array('flag_assigned' => 0, 'status' => 1));
		
		if($return->num_rows() > 0)
		{
			return $return;
		}
		else 
		{
			return false;
		}
	}
	
	function get_mouse_info($mouse_id)
	{
		
		$this->db->select('nshis_mouses.mouse_id, nshis_mouses.serial_number, nshis_mouses.cdate, nshis_mouses.name as mouse_name,  nshis_mouses.other_name, nshis_mouses.notes, nshis_mouses.date_purchased, nshis_cubicles.name as cb_name, nshis_cubicles.cubicle_id as cb_id');
		$this->db->from('nshis_mouses');
		$this->db->join('nshis_cubicles', 'nshis_mouses.cubicle_id = nshis_cubicles.cubicle_id','left');
		$this->db->where('nshis_mouses.mouse_id', $mouse_id); 
		
		$return = $this->db->get();
		
		
//		$return = $this->db->get_where('nshis_mouses', array('mouse_id' => $mouse_id));
		
//		$query_str = "SELECT * FROM nshis_mouses WHERE mouse_id = ? LIMIT 1";
//		
//		$return = $this->db->query($query_str, array($mouse_id));
		
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
	
	function get_mouse_info_by_name($mouse_name)
	{
		$query_str = "SELECT * FROM nshis_mouses WHERE name = ? LIMIT 1";
		
		$return = $this->db->query($query_str, array(trim($mouse_name)));
		
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
	
	function get_all_mouse_info()
	{
		$this->db->select('nshis_mouses.mouse_id, nshis_mouses.cubicle_id,  nshis_mouses.flag_assigned, nshis_mouses.serial_number, nshis_mouses.name as mouse_name,  nshis_mouses.other_name, nshis_cubicles.name as cb_name');
		$this->db->from('nshis_mouses');
		$this->db->join('nshis_cubicles', 'nshis_mouses.cubicle_id = nshis_cubicles.cubicle_id','left');
		$this->db->order_by('nshis_mouses.name', 'asc'); 
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
	
	function insert_comment($mouse_id, $comment)
	{
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'device_id' => $mouse_id,
			'device' => 'mouse',
			'comment' => $comment
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_comments', $data); 
		
		if($return)
		{
			return $mouse_id;
		}
		else
		{
			return false;
		}
	}
	
	function get_comments($mouse_id)
	{
		$this->db->select('nshis_comments.comment, nshis_comments.cdate, nshis_users.username');
		$this->db->from('nshis_comments');
		$this->db->join('nshis_users', 'nshis_users.ID = nshis_comments.user_id','right');
		$this->db->where('nshis_comments.device_id', $mouse_id);
		$this->db->where('nshis_comments.device', 'mouse');
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
	
	function edit_mouse($mouse_id, $mouse_name, $mouse_other_name, $mouse_sn, $mouse_date_purchased, $notes)
	{
		$data = array(
			'name' => $mouse_name,
			'other_name' => $mouse_other_name,
			'serial_number' => $mouse_sn,
			'date_purchased' => $mouse_date_purchased,
			'notes'	=> $notes
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		$this->db->where('mouse_id', $mouse_id);
		$return = $this->db->update('nshis_mouses', $data); 
		
		if($return)
		{
			return $mouse_id;
		}
		else 
		{
			return false;
//			redirect('/user/register/', 'refresh');
		}
	}
	
	function delete_mouse($mouse_id)
	{
		$delete = $this->db->delete('nshis_mouses', array('mouse_id' => $mouse_id)); 
		
		$data = array(
			'mouse' => 0,
		);
		$this->db->where('mouse', $mouse_id);
		$return = $this->db->update('nshis_cubicles', $data);
		
		if ($delete && $return)
		{
			return $mouse_id;
		}
		else
		{
			return false;
		}
	}
	
	function get_cubicle_mouse_info($mouse_id = NULL)
	{
		$this->db->select('nshis_mouses.mouse_id, nshis_mouses.name as mouse_name, nshis_cubicles.cubicle_id, nshis_cubicles.name as cb_name');
		$this->db->from('nshis_mouses');
		$this->db->join('nshis_cubicles', 'nshis_mouses.cubicle_id = nshis_cubicles.cubicle_id','right');
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
	
	function pull_out($mouse_id)
	{
		$mouse = $this->db->get_where('nshis_mouses', array('mouse_id' => $mouse_id), 1);
		$row = $mouse->row_array();
		$cubicle_id = $row['cubicle_id'];
		
		if($cubicle_id)
		{
			$data = array(
	        	'flag_assigned' => 0,
	            'cubicle_id' => 0
	        );
	            
			$update1 = $this->db->update('nshis_mouses', $data, array('mouse_id' => $mouse_id));
			
			$data = array(
	        	'mouse' => 0
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