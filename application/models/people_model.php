<?php 

class People_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function exist($full_name)
	{
		$this->db->from('nshis_people');
		$this->db->where('concat(first_name, " ", last_name) = "'.$full_name.'"');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	function add($fname, $lname)
	{
		$this->db->insert('nshis_people', array('first_name' => $fname, 'last_name' => $lname));
	}
	
	function viewall()
	{
		$this->db->select('*');
		$this->db->from('nshis_people');
		$this->db->join('nshis_usb_headsets', 'nshis_people.id = nshis_usb_headsets.assigned_person', 'left');
		$this->db->order_by('nshis_people.last_name, nshis_people.first_name');
		return $this->db->get();
	}
	
	function get_available()
	{
		return $this->db->get_where('nshis_people', array('flag_usb_headset' => 0));
	}
	
	function get_name($user_id)
	{
		$query = $this->db->get_where('nshis_people', array('id' => $user_id));
		
		if ($query->num_rows() == 0) {
			return '';
		}
		
		$info = $query->row();
		
		return $info->first_name.' '.$info->last_name;		
	}
}