<?php 

class Globals_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_item_logs($id, $type)
	{
		if ($type == 'cubicle') {
			$where_clause = "b.cubicle_id = ".$id;
		} 
		else {
			$where_clause = "device_id = ".$id." AND device = '".$type."'";
		}
		$query_str = "
			SELECT  a.username, b.*,
				c.name as cubicle_deployed,
			    d.name as keyboard_name, 
			    e.name as mouse_name,
			    f.name as cpu_name,
			    g.name as monitor_name,
			    h.name as dialpad_name,
			    i.name as connector_name,
			    j.name as headset_name,
			    k.name as ups_name,
			    l.name as cubicle_name,
			    m.name as usb_headset_name
			FROM nshis_logs AS b
			    left join nshis_users as a on b.user_id=a.id
			    left join nshis_cubicles as c on b.cubicle_id=c.cubicle_id
			    LEFT JOIN nshis_keyboards AS d ON b.device_id = d.keyboard_id 
			    LEFT JOIN nshis_mouses AS e ON b.device_id = e.mouse_id 
			    LEFT JOIN nshis_cpus AS f ON b.device_id = f.cpu_id
			    LEFT JOIN nshis_monitors AS g ON b.device_id = g.monitor_id 
			    LEFT JOIN nshis_dialpads AS h ON b.device_id = h.dialpad_id
			    LEFT JOIN nshis_connectors AS i ON b.device_id= i.connector_id
			    LEFT JOIN nshis_headsets AS j ON b.device_id = j.headset_id
			    LEFT JOIN nshis_upss AS k ON b.device_id = k.ups_id
			    LEFT JOIN nshis_cubicles AS l ON b.device_id = l.cubicle_id
			    LEFT JOIN nshis_usb_headsets AS m ON b.device_id = m.usb_headset_id
			WHERE ".$where_clause."
			order by b.cdate desc";
		
		$return = $this->db->query($query_str);
		
		if ($return)
		{
			return $return;
		}
		else 
		{
			return false;
		}
	}
	
	function insert_log($user_id, $device_id, $device, $process, $cubicle_id = 0, $usb_headset_assigned = NULL)
	{
		
		$cubicle_name = $cubicle_id != 0 ? $this->get_device_name($cubicle_id, 'cubicle') : NULL;
		
		$data = array(
			'user_id'	=>	$user_id,
			'process'	=>	$process,
			'device_id'	=>	$device_id,
			'device'	=>	$device,
			'device_name'	=>	$this->get_device_name($device_id, $device),
			'cubicle_id' =>	$cubicle_id,
			'cubicle_name' => $cubicle_name,
			'usb_headset_assignment' => $usb_headset_assigned
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$this->db->insert('nshis_logs', $data); 
	}
	
	private function get_device_name($device_id, $device_type)
	{
		$query = $this->db->get_where('nshis_'.$device_type.'s', array($device_type.'_id' => $device_id));
		
		if ($query->num_rows() > 0) {
			$info = $query->row();
			return $info->name;
		}
		else {
			return FALSE;
		}
	}
	
}