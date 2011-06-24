<?php 

class Stats_model extends Model {
	
	function Stats_model()
	{
		parent::Model();
	}
	
	function insert_log($user_id, $device_id, $device, $process, $cubicle_id = 0, $usb_headset_assigned = NULL)
	{
		$data = array(
			'user_id'	=>	$user_id,
			'process'	=>	$process,
			'device_id'	=>	$device_id,
			'device'	=>	$device,
			'cubicle_id' =>	$cubicle_id,
			'usb_headset_assignment' => $usb_headset_assigned
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$this->db->insert('nshis_logs', $data); 
	}
	
	function get_devices_info()
	{
		$data = $this->db->query('
			select 
			    (select count(*) from nshis_keyboards where flag_assigned=0) as unassigned_kyb,
			    (select count(*) from nshis_keyboards where flag_assigned=1) as assigned_kyb,
			    (select count(*) from nshis_keyboards) as total_kyb,
			    (select \'Keyboard\') as name_kyb,
			    (select count(*) from nshis_mouses where flag_assigned=0) as unassigned_mse,
			    (select count(*) from nshis_mouses where flag_assigned=1) as assigned_mse,
			    (select count(*) from nshis_mouses) as total_mse,
			    (select \'Mouse\') as name_mse,
			    (select count(*) from nshis_cpus where flag_assigned=0) as unassigned_cpu,
			    (select count(*) from nshis_cpus where flag_assigned=1) as assigned_cpu,
			    (select count(*) from nshis_cpus) as total_cpu,
			    (select \'CPU\') as name_cpu,
			    (select count(*) from nshis_monitors where flag_assigned=0) as unassigned_mon,
			    (select count(*) from nshis_monitors where flag_assigned=1) as assigned_mon,
			    (select count(*) from nshis_monitors) as total_mon,
			    (select \'Monitor\') as name_mon,
			    (select count(*) from nshis_dialpads where flag_assigned=0) as unassigned_dlp,
			    (select count(*) from nshis_dialpads where flag_assigned=1) as assigned_dlp,
			    (select count(*) from nshis_dialpads) as total_dlp,
			    (select \'Dialpad\') as name_dlp,
			    (select count(*) from nshis_connectors where flag_assigned=0) as unassigned_con,
			    (select count(*) from nshis_connectors where flag_assigned=1) as assigned_con,
			    (select count(*) from nshis_connectors) as total_con,
			    (select \'Connector\') as name_con,
			    (select count(*) from nshis_headsets where flag_assigned=0) as unassigned_hst,
			    (select count(*) from nshis_headsets where flag_assigned=1) as assigned_hst,
			    (select count(*) from nshis_headsets) as total_hst,
			    (select \'Headset(USB)\') as name_usbhst,
			    (select count(*) from nshis_usb_headsets where flag_assigned=0) as unassigned_usbhst,
          (select count(*) from nshis_usb_headsets where flag_assigned=1) as assigned_usbhst,
          (select count(*) from nshis_usb_headsets) as total_usbhst,
          (select \'Headset(Analog)\') as name_hst,
			    (select count(*) from nshis_upss where flag_assigned=0) as unassigned_ups,
			    (select count(*) from nshis_upss where flag_assigned=1) as assigned_ups,
			    (select count(*) from nshis_upss) as total_ups,
			    (select \'UPS\') as name_ups
		');
		
		return $data;
	}
	
	function get_logs()
	{
		$query_str = "
			select  a.username, b.*,
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
			from nshis_logs as b
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
			order by b.cdate desc LIMIT 50";
		
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