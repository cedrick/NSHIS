<?php 

class Monitor_model extends Model {
	
	function Monitor_model()
	{
		parent::Model();
	}
	
	function check_monitor_exist($monitor_name)
	{
		$return = $this->db->get_where('nshis_monitors', array('name' => $monitor_name));
		
		if($return->num_rows() > 0)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	function insert_new_monitor($monitor_name, $other_name, $serial_number, $date_purchased, $notes) 
	{
		$data = array(
			'name' => $monitor_name,
			'other_name' => $other_name,
			'serial_number' => $serial_number,
			'date_purchased' => $date_purchased,
			'notes' => $notes
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_monitors', $data); 
		
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
	
	function assign_monitor($monitor_id, $cubicle) 
	{
		$data = array(
        	'flag_assigned' => 0,
            'cubicle_id' => 0,
        );
            
		$update1 = $this->db->update('nshis_monitors', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'monitor' => $monitor_id,
        );
            
		$update2 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle,
        );
            
		$update3 = $this->db->update('nshis_monitors', $data, array('monitor_id' => $monitor_id));
		
		if($update1 && $update2 && $update3)
		{
			return $cubicle;
		}
		else 
		{
			return false;
		}
	}
	
	function transfer($monitor_id, $cubicle)
	{
		$data = array(
        	'flag_assigned' => 0,
            'cubicle_id' => 0
        );
            
		$update1 = $this->db->update('nshis_monitors', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'monitor' => 0
        );
            
		$update2 = $this->db->update('nshis_cubicles', $data, array('monitor' => $monitor_id));
		
		$data = array(
        	'monitor' => $monitor_id
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle
        );
            
		$update4 = $this->db->update('nshis_monitors', $data, array('monitor_id' => $monitor_id));
		
		if ($update1 && $update2 && $update3 && $update4)
		{
			return $cubicle;
		}
		else 
		{
			return false;
		}
		
		
	}
	
	function swap($monitor_id, $cubicle_monitor_id)
	{
		$id = explode('|', $cubicle_monitor_id);
		
		$dest_cubicle = $id[0];
		$dest_monitor = $id[1];
		
		$query = $this->db->get_where('nshis_monitors', array('monitor_id' => $monitor_id));
		foreach ($query->result() as $row)
		{
		    $source_cubicle = $row->cubicle_id;
		    $source_monitor = $monitor_id;
		}
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $dest_cubicle
        );
            
		$update1 = $this->db->update('nshis_monitors', $data, array('monitor_id' => $source_monitor));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $source_cubicle
        );
            
		$update2 = $this->db->update('nshis_monitors', $data, array('monitor_id' => $dest_monitor));
		
		$data = array(
        	'monitor' => $dest_monitor
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $source_cubicle));
		
		$data = array(
        	'monitor' => $source_monitor
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
	
	function get_available_monitors()
	{
		$return = $this->db->get_where('nshis_monitors', array('flag_assigned' => 0));
		
		if($return->num_rows() > 0)
		{
			return $return;
		}
		else 
		{
			return false;
		}
	}
	
	function get_monitor_info($monitor_id)
	{
		
		$this->db->select('nshis_monitors.monitor_id, nshis_monitors.serial_number, nshis_monitors.cdate, nshis_monitors.name as monitor_name,  nshis_monitors.other_name, nshis_monitors.notes, nshis_monitors.date_purchased, nshis_cubicles.name as cb_name, nshis_cubicles.cubicle_id as cb_id, nshis_cubicles.cubicle_id as cb_id');
		$this->db->from('nshis_monitors');
		$this->db->join('nshis_cubicles', 'nshis_monitors.cubicle_id = nshis_cubicles.cubicle_id','left');
		$this->db->where('nshis_monitors.monitor_id', $monitor_id); 
		
		$return = $this->db->get();
		
		
//		$return = $this->db->get_where('nshis_monitors', array('monitor_id' => $monitor_id));
		
//		$query_str = "SELECT * FROM nshis_monitors WHERE monitor_id = ? LIMIT 1";
//		
//		$return = $this->db->query($query_str, array($monitor_id));
		
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
	
	function get_monitor_info_by_name($monitor_name)
	{
		$query_str = "SELECT * FROM nshis_monitors WHERE name = ? LIMIT 1";
		
		$return = $this->db->query($query_str, array(trim($monitor_name)));
		
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
	
	function get_all_monitor_info()
	{
		$this->db->select('nshis_monitors.monitor_id, nshis_monitors.cubicle_id,  nshis_monitors.flag_assigned, nshis_monitors.serial_number, nshis_monitors.name as monitor_name,  nshis_monitors.other_name, nshis_cubicles.name as cb_name');
		$this->db->from('nshis_monitors');
		$this->db->join('nshis_cubicles', 'nshis_monitors.cubicle_id = nshis_cubicles.cubicle_id','left');
		$this->db->order_by('nshis_monitors.name', 'asc'); 
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
	
	function insert_comment($monitor_id, $comment)
	{
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'device_id' => $monitor_id,
			'device' => 'monitor',
			'comment' => $comment
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_comments', $data); 
		
		if($return)
		{
			return $monitor_id;
		}
		else
		{
			return false;
		}
	}
	
	function get_comments($monitor_id)
	{
		$this->db->select('nshis_comments.comment, nshis_comments.cdate, nshis_users.username');
		$this->db->from('nshis_comments');
		$this->db->join('nshis_users', 'nshis_users.ID = nshis_comments.user_id','right');
		$this->db->where('nshis_comments.device_id', $monitor_id);
		$this->db->where('nshis_comments.device', 'monitor');
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
	
	function edit_monitor($monitor_id, $monitor_name, $monitor_other_name, $monitor_sn, $monitor_date_purchased, $notes)
	{
		$data = array(
			'name' => $monitor_name,
			'other_name' => $monitor_other_name,
			'serial_number' => $monitor_sn,
			'date_purchased' => $monitor_date_purchased,
			'notes'	=> $notes
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		$this->db->where('monitor_id', $monitor_id);
		$return = $this->db->update('nshis_monitors', $data); 
		
		if($return)
		{
			return $monitor_id;
		}
		else 
		{
			return false;
//			redirect('/user/register/', 'refresh');
		}
	}
	
	function delete_monitor($monitor_id)
	{
		$delete = $this->db->delete('nshis_monitors', array('monitor_id' => $monitor_id)); 
		
		$data = array(
			'monitor' => 0,
		);
		$this->db->where('monitor', $monitor_id);
		$return = $this->db->update('nshis_cubicles', $data);
		
		if ($delete && $return)
		{
			return $monitor_id;
		}
		else
		{
			return false;
		}
	}
	
	function get_cubicle_monitor_info($monitor_id = NULL)
	{
		$this->db->select('nshis_monitors.monitor_id, nshis_monitors.name as monitor_name, nshis_cubicles.cubicle_id, nshis_cubicles.name as cb_name');
		$this->db->from('nshis_monitors');
		$this->db->join('nshis_cubicles', 'nshis_monitors.cubicle_id = nshis_cubicles.cubicle_id','right');
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
	
	function pull_out($monitor_id)
	{
		$monitor = $this->db->get_where('nshis_monitors', array('monitor_id' => $monitor_id), 1);
		$row = $monitor->row_array();
		$cubicle_id = $row['cubicle_id'];
		
		if($cubicle_id)
		{
			$data = array(
	        	'flag_assigned' => 0,
	            'cubicle_id' => 0
	        );
	            
			$update1 = $this->db->update('nshis_monitors', $data, array('monitor_id' => $monitor_id));
			
			$data = array(
	        	'monitor' => 0
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