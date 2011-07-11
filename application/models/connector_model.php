<?php 

class Connector_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function check_connector_exist($connector_name)
	{
		$return = $this->db->get_where('nshis_connectors', array('name' => $connector_name));
		
		if($return->num_rows() > 0)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	function insert_new_connector($connector_name, $other_name, $serial_number, $date_purchased, $notes) 
	{
		$data = array(
			'name' => $connector_name,
			'other_name' => $other_name,
			'serial_number' => $serial_number,
			'date_purchased' => $date_purchased,
			'notes' => $notes
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_connectors', $data); 
		
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
	
	function assign_connector($connector_id, $cubicle) 
	{
		$data = array(
        	'flag_assigned' => 0,
            'cubicle_id' => 0,
        );
            
		$update1 = $this->db->update('nshis_connectors', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'connector' => $connector_id,
        );
            
		$update2 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle,
        );
            
		$update3 = $this->db->update('nshis_connectors', $data, array('connector_id' => $connector_id));
		
		if($update1 && $update2 && $update3)
		{
			return $cubicle;
		}
		else 
		{
			return false;
		}
	}
	
	function transfer($connector_id, $cubicle)
	{
		$data = array(
        	'flag_assigned' => 0,
            'cubicle_id' => 0
        );
            
		$update1 = $this->db->update('nshis_connectors', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'connector' => 0
        );
            
		$update2 = $this->db->update('nshis_cubicles', $data, array('connector' => $connector_id));
		
		$data = array(
        	'connector' => $connector_id
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle
        );
            
		$update4 = $this->db->update('nshis_connectors', $data, array('connector_id' => $connector_id));
		
		if ($update1 && $update2 && $update3 && $update4)
		{
			return $cubicle;
		}
		else 
		{
			return false;
		}
		
		
	}
	
	function swap($connector_id, $cubicle_connector_id)
	{
		$id = explode('|', $cubicle_connector_id);
		
		$dest_cubicle = $id[0];
		$dest_connector = $id[1];
		
		$query = $this->db->get_where('nshis_connectors', array('connector_id' => $connector_id));
		foreach ($query->result() as $row)
		{
		    $source_cubicle = $row->cubicle_id;
		    $source_connector = $connector_id;
		}
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $dest_cubicle
        );
            
		$update1 = $this->db->update('nshis_connectors', $data, array('connector_id' => $source_connector));
		
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $source_cubicle
        );
            
		$update2 = $this->db->update('nshis_connectors', $data, array('connector_id' => $dest_connector));
		
		$data = array(
        	'connector' => $dest_connector
        );
            
		$update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $source_cubicle));
		
		$data = array(
        	'connector' => $source_connector
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
	
	function get_available_connectors()
	{
		$return = $this->db->get_where('nshis_connectors', array('flag_assigned' => 0, 'status' => 1));
		
		if($return->num_rows() > 0)
		{
			return $return;
		}
		else 
		{
			return false;
		}
	}
	
	function get_connector_info($connector_id)
	{
		
		$this->db->select('nshis_connectors.connector_id, nshis_connectors.serial_number, nshis_connectors.cdate, nshis_connectors.name as connector_name,  nshis_connectors.other_name, nshis_connectors.notes, nshis_connectors.date_purchased, nshis_cubicles.name as cb_name, nshis_cubicles.cubicle_id as cb_id');
		$this->db->from('nshis_connectors');
		$this->db->join('nshis_cubicles', 'nshis_connectors.cubicle_id = nshis_cubicles.cubicle_id','left');
		$this->db->where('nshis_connectors.connector_id', $connector_id); 
		
		$return = $this->db->get();
		
		
//		$return = $this->db->get_where('nshis_connectors', array('connector_id' => $connector_id));
		
//		$query_str = "SELECT * FROM nshis_connectors WHERE connector_id = ? LIMIT 1";
//		
//		$return = $this->db->query($query_str, array($connector_id));
		
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
	
	function get_connector_info_by_name($connector_name)
	{
		$query_str = "SELECT * FROM nshis_connectors WHERE name = ? LIMIT 1";
		
		$return = $this->db->query($query_str, array(trim($connector_name)));
		
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
	
	function get_all_connector_info()
	{
		$this->db->select('nshis_connectors.connector_id, nshis_connectors.cubicle_id,  nshis_connectors.flag_assigned, nshis_connectors.serial_number, nshis_connectors.name as connector_name,  nshis_connectors.other_name, nshis_cubicles.name as cb_name');
		$this->db->from('nshis_connectors');
		$this->db->join('nshis_cubicles', 'nshis_connectors.cubicle_id = nshis_cubicles.cubicle_id','left');
		$this->db->order_by('nshis_connectors.name', 'asc'); 
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
	
	function insert_comment($connector_id, $comment)
	{
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'device_id' => $connector_id,
			'device' => 'connector',
			'comment' => $comment
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_comments', $data); 
		
		if($return)
		{
			return $connector_id;
		}
		else
		{
			return false;
		}
	}
	
	function get_comments($connector_id)
	{
		$this->db->select('nshis_comments.comment, nshis_comments.cdate, nshis_users.username');
		$this->db->from('nshis_comments');
		$this->db->join('nshis_users', 'nshis_users.ID = nshis_comments.user_id','right');
		$this->db->where('nshis_comments.device_id', $connector_id);
		$this->db->where('nshis_comments.device', 'connector');
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
	
	function edit_connector($connector_id, $connector_name, $connector_other_name, $connector_sn, $connector_date_purchased, $notes)
	{
		$data = array(
			'name' => $connector_name,
			'other_name' => $connector_other_name,
			'serial_number' => $connector_sn,
			'date_purchased' => $connector_date_purchased,
			'notes'	=> $notes
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		$this->db->where('connector_id', $connector_id);
		$return = $this->db->update('nshis_connectors', $data); 
		
		if($return)
		{
			return $connector_id;
		}
		else 
		{
			return false;
//			redirect('/user/register/', 'refresh');
		}
	}
	
	function delete_connector($connector_id)
	{
		$delete = $this->db->delete('nshis_connectors', array('connector_id' => $connector_id)); 
		
		$data = array(
			'connector' => 0,
		);
		$this->db->where('connector', $connector_id);
		$return = $this->db->update('nshis_cubicles', $data);
		
		if ($delete && $return)
		{
			return $connector_id;
		}
		else
		{
			return false;
		}
	}
	
	function get_cubicle_connector_info($connector_id = NULL)
	{
		$this->db->select('nshis_connectors.connector_id, nshis_connectors.name as connector_name, nshis_cubicles.cubicle_id, nshis_cubicles.name as cb_name');
		$this->db->from('nshis_connectors');
		$this->db->join('nshis_cubicles', 'nshis_connectors.cubicle_id = nshis_cubicles.cubicle_id','right');
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
	
	function pull_out($connector_id)
	{
		$connector = $this->db->get_where('nshis_connectors', array('connector_id' => $connector_id), 1);
		$row = $connector->row_array();
		$cubicle_id = $row['cubicle_id'];
		
		if($cubicle_id)
		{
			$data = array(
	        	'flag_assigned' => 0,
	            'cubicle_id' => 0
	        );
	            
			$update1 = $this->db->update('nshis_connectors', $data, array('connector_id' => $connector_id));
			
			$data = array(
	        	'connector' => 0
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