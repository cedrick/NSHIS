<?php 

class Cubicle_model extends Model {
	
	function Cubicle_model()
	{
		parent::Model();
	}
	
	function check_cubicle_exist($cubicle_name)
	{
		$return = $this->db->get_where('nshis_cubicles', array('name' => $cubicle_name));
		
		if($return->num_rows() > 0)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	function insert_new_cubicle($cubicle_name) 
	{
		$data = array(
			'name' => $cubicle_name,
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_cubicles', $data); 
		
		$id = $this->db->insert_id();
		
		if($return)
		{
			return $id;
		}
		else 
		{
			return false;
		}
		
	}
	
	function edit_cubicle($cubicle_id, $cubicle_name)
	{
		$data = array(
			'name' => $cubicle_name,
		);

		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$this->db->where('cubicle_id', $cubicle_id);
		
		$return = $this->db->update('nshis_cubicles', $data);
		
		if ($return)
		{
			return $cubicle_id;
		}
		else 
		{
			return false;
		}
		  
		
	}
	
	function delete_cubicle($cubicle_id)
	{
		$delete = $this->db->delete('nshis_cubicles', array('cubicle_id' => $cubicle_id));
		
		$devices = array('keyboards','mouses');
		
		foreach ($devices as $device)
		{
			$data = array(
				'cubicle_id' => 0,
				'flag_assigned' => 0 
			);
			
			$this->db->where('cubicle_id', $cubicle_id);
			
			$this->db->update('nshis_' . $device, $data);
		}
		
		if ($delete)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	function get_cubicle_info($cubicle_id)
	{
		$query_str = "
			SELECT a.cubicle_id, a.name AS cub_name, a.*, 
				b.keyboard_id, b.name as kyb_name, 
				c.mouse_id, c.name as mse_name,
				d.cpu_id, d.name as cpu_name,
				e.monitor_id, e.name as mon_name,
				f.dialpad_id, f.name as dlp_name,
				g.connector_id, g.name as con_name,
				h.headset_id, h.name as hst_name,
				i.ups_id, i.name as ups_name
			FROM nshis_cubicles AS a 
				LEFT JOIN nshis_keyboards AS b ON a.keyboard = b.keyboard_id 
				LEFT JOIN nshis_mouses AS c ON a.mouse = c.mouse_id 
				LEFT JOIN nshis_cpus AS d ON a.cpu = d.cpu_id
				LEFT JOIN nshis_monitors AS e ON a.monitor = e.monitor_id 
				LEFT JOIN nshis_dialpads AS f ON a.dialpad = f.dialpad_id
				LEFT JOIN nshis_connectors AS g ON a.connector = g.connector_id
				LEFT JOIN nshis_headsets AS h ON a.headset = h.headset_id
				LEFT JOIN nshis_upss AS i ON a.ups = i.ups_id
			WHERE a.cubicle_id = ? 
			LIMIT 1";
		
		$return = $this->db->query($query_str, array($cubicle_id));
		
		if($return->num_rows() > 0)
		{
			return $return;
		}
		else 
		{
			return false;
		}
	}
	
	function get_all_cubicle_info()
	{
		$this->db->order_by('name', 'asc'); 
		$return = $this->db->get('nshis_cubicles');
		
		if($return->num_rows() > 0)
		{
			return $return;
		}
		else 
		{
			return false;
		}
	}
	
	function get_cubicle_info_by_name($cubicle_name)
	{
		$return = $this->db->get_where('nshis_cubicles', array('name' => $cubicle_name));
		
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
	
	function insert_comment($cubicle_id, $comment)
	{
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'device_id' => $cubicle_id,
			'device' => 'cubicle',
			'comment' => $comment
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_comments', $data); 
		
		if ($return)
		{
			return $cubicle_id;
		}
		else 
		{
			return false;
		}
		
	}
	
	function get_comments($cubicle_id)
	{
		$this->db->select('nshis_comments.comment, nshis_comments.cdate, nshis_users.username');
		$this->db->from('nshis_comments');
		$this->db->join('nshis_users', 'nshis_users.ID = nshis_comments.user_id','right');
		$this->db->where('nshis_comments.device_id', $cubicle_id);
		$this->db->where('nshis_comments.device', 'cubicle');
		$this->db->order_by('nshis_comments.cdate', 'asc'); 
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
	
}