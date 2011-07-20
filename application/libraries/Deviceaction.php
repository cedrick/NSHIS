<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deviceaction {
	public $CI;
	public $device_id;
 	public $device_type;
 	
	public function __construct()
	{
		$this->CI =& get_instance();

		$this->CI->load->database();
	}
	
	public function generate_actions($device_id, $device_type)
	{
		//check if status is OK
		$query = $this->CI->db->get_where('nshis_'.$device_type.'s', array($device_type.'_id' => $device_id, 'status' => 1, ));
		if ($query->num_rows() == 0) {
			return FALSE;
		}
		
		$this->print_assign();
		
	}
	
	public function print_assign()
	{
		echo '<div id="assign_btn">ASSIGN</div>';
	}
	
	private function get_avail_cub($device_type)
	{
		$query = $this->CI->db->get_where('nshis_cubicles', array($device_type => 0));
		
	}
	
	
	
}