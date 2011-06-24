<?php 

class Keyboard_model extends Model {
	
	function Keyboard_model()
	{
		parent::Model();
	}
	
	function check_keyboard_exist($keyboard_name)
	{
		$return = $this->db->get_where('nshis_keyboards', array('name' => $keyboard_name));
		
		if($return->num_rows() > 0)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	function insert_new_keyboard($keyboard_name, $other_name, $serial_number, $date_purchased, $notes) 
	{
		$data = array(
			'name' => $keyboard_name,
			'other_name' => $other_name,
			'serial_number' => $serial_number,
			'date_purchased' => $date_purchased,
			'notes' => $notes
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_keyboards', $data); 
		
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
	
	function assign_keyboard($keyboard_id, $cubicle) 
	{
		$data = array(
        	'flag_assigned' => 0,
            'cubicle_id' => 0,
        );
            
		$update1 = $this->db->update('nshis_keyboards', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'keyboard' => $keyboard_id,
        );
            
		$update2 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle,
        );
            
		$update3 = $this->db->update('nshis_keyboards', $data, array('keyboard_id' => $keyboard_id));
		
		if($update1 && $update2 && $update3)
		{
			return $cubicle;
		}
		else 
		{
			return false;
		}
	}
	
	function transfer($keyboard_id, $cubicle)
	{
		$data = array(
        	'flag_assigned' => 0,
            'cubicle_id' => 0
        );
            
		$update1 = $this->db->update('nshis_keyboards', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'keyboard' => 0
        );
            
		$update2 = $this->db->update('nshis_cubicles', $data, array('keyboard' => $keyboard_id));
		
		$data = array(
        	'keyboard' => $keyboard_id
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle
        );
            
		$update4 = $this->db->update('nshis_keyboards', $data, array('keyboard_id' => $keyboard_id));
		
		if ($update1 && $update2 && $update3 && $update4)
		{
			return $cubicle;
		}
		else 
		{
			return false;
		}
		
		
	}
	
	function swap($keyboard_id, $cubicle_keyboard_id)
	{
		$id = explode('|', $cubicle_keyboard_id);
		
		$dest_cubicle = $id[0];
		$dest_keyboard = $id[1];
		
		$query = $this->db->get_where('nshis_keyboards', array('keyboard_id' => $keyboard_id));
		foreach ($query->result() as $row)
		{
		    $source_cubicle = $row->cubicle_id;
		    $source_keyboard = $keyboard_id;
		}
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $dest_cubicle
        );
            
		$update1 = $this->db->update('nshis_keyboards', $data, array('keyboard_id' => $source_keyboard));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $source_cubicle
        );
            
		$update2 = $this->db->update('nshis_keyboards', $data, array('keyboard_id' => $dest_keyboard));
		
		$data = array(
        	'keyboard' => $dest_keyboard
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $source_cubicle));
		
		$data = array(
        	'keyboard' => $source_keyboard
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
	
	function get_available_keyboards()
	{
		$return = $this->db->get_where('nshis_keyboards', array('flag_assigned' => 0));
		
		if($return->num_rows() > 0)
		{
			return $return;
		}
		else 
		{
			return false;
		}
	}
	
	function get_keyboard_info($keyboard_id)
	{
		
		$this->db->select('nshis_keyboards.keyboard_id, nshis_keyboards.serial_number, nshis_keyboards.cdate, nshis_keyboards.name as keyboard_name,  nshis_keyboards.other_name, nshis_keyboards.notes, nshis_keyboards.date_purchased, nshis_cubicles.name as cb_name, nshis_cubicles.cubicle_id as cb_id');
		$this->db->from('nshis_keyboards');
		$this->db->join('nshis_cubicles', 'nshis_keyboards.cubicle_id = nshis_cubicles.cubicle_id','left');
		$this->db->where('nshis_keyboards.keyboard_id', $keyboard_id); 
		
		$return = $this->db->get();
		
		
//		$return = $this->db->get_where('nshis_keyboards', array('keyboard_id' => $keyboard_id));
		
//		$query_str = "SELECT * FROM nshis_keyboards WHERE keyboard_id = ? LIMIT 1";
//		
//		$return = $this->db->query($query_str, array($keyboard_id));
		
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
	
	function get_keyboard_info_by_name($keyboard_name)
	{
		$query_str = "SELECT * FROM nshis_keyboards WHERE name = ? LIMIT 1";
		
		$return = $this->db->query($query_str, array(trim($keyboard_name)));
		
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
	
	function get_all_keyboard_info()
	{
		$this->db->select('nshis_keyboards.keyboard_id, nshis_keyboards.cubicle_id,  nshis_keyboards.flag_assigned, nshis_keyboards.serial_number, nshis_keyboards.name as keyboard_name,  nshis_keyboards.other_name, nshis_cubicles.name as cb_name');
		$this->db->from('nshis_keyboards');
		$this->db->join('nshis_cubicles', 'nshis_keyboards.cubicle_id = nshis_cubicles.cubicle_id','left');
		$this->db->order_by('nshis_keyboards.name', 'asc'); 
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
	
	function insert_comment($keyboard_id, $comment)
	{
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'device_id' => $keyboard_id,
			'device' => 'keyboard',
			'comment' => $comment
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_comments', $data); 
		
		if($return)
		{
			return $keyboard_id;
		}
		else
		{
			return false;
		}
	}
	
	function get_comments($keyboard_id)
	{
		$this->db->select('nshis_comments.comment, nshis_comments.cdate, nshis_users.username');
		$this->db->from('nshis_comments');
		$this->db->join('nshis_users', 'nshis_users.ID = nshis_comments.user_id','right');
		$this->db->where('nshis_comments.device_id', $keyboard_id);
		$this->db->where('nshis_comments.device', 'keyboard');
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
	
	function edit_keyboard($keyboard_id, $keyboard_name, $keyboard_other_name, $keyboard_sn, $keyboard_date_purchased, $notes)
	{
		$data = array(
			'name' => $keyboard_name,
			'other_name' => $keyboard_other_name,
			'serial_number' => $keyboard_sn,
			'date_purchased' => $keyboard_date_purchased,
			'notes'	=> $notes
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		$this->db->where('keyboard_id', $keyboard_id);
		$return = $this->db->update('nshis_keyboards', $data); 
		
		if($return)
		{
			return $keyboard_id;
		}
		else 
		{
			return false;
//			redirect('/user/register/', 'refresh');
		}
	}
	
	function delete_keyboard($keyboard_id)
	{
		$delete = $this->db->delete('nshis_keyboards', array('keyboard_id' => $keyboard_id)); 
		
		$data = array(
			'keyboard' => 0,
		);
		$this->db->where('keyboard', $keyboard_id);
		$return = $this->db->update('nshis_cubicles', $data);
		
		if ($delete && $return)
		{
			return $keyboard_id;
		}
		else
		{
			return false;
		}
	}
	
	function get_cubicle_keyboard_info($keyboard_id = NULL)
	{
		$this->db->select('nshis_keyboards.keyboard_id, nshis_keyboards.name as keyboard_name, nshis_cubicles.cubicle_id, nshis_cubicles.name as cb_name');
		$this->db->from('nshis_keyboards');
		$this->db->join('nshis_cubicles', 'nshis_keyboards.cubicle_id = nshis_cubicles.cubicle_id','right');
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
	
	function pull_out($keyboard_id)
	{
		$keyboard = $this->db->get_where('nshis_keyboards', array('keyboard_id' => $keyboard_id), 1);
		$row = $keyboard->row_array();
		$cubicle_id = $row['cubicle_id'];
		
		if($cubicle_id)
		{
			$data = array(
	        	'flag_assigned' => 0,
	            'cubicle_id' => 0
	        );
	            
			$update1 = $this->db->update('nshis_keyboards', $data, array('keyboard_id' => $keyboard_id));
			
			$data = array(
	        	'keyboard' => 0
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