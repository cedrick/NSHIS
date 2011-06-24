<?php 

class Globals_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_item_logs($id, $type)
	{
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
			WHERE device_id = ".$id." AND device = '".$type."'
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
}