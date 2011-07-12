<?php 

class Ajax_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function comment_add($log_id, $comment)
	{
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'log_id' => $log_id,
			'comment' => $comment
		);
		
		$this->db->set('cdate', 'NOW()', FALSE);  
		
		$return = $this->db->insert('nshis_comments', $data); 
		
		if ($return) {
			echo "Success";
		} else {
			echo "ERROR";
		}
	}
	
	function status_change($item, $item_id, $status, $status_comment)
	{
		$current_status = $this->devicestatus->current_status($item, $item_id);
		$update_status = $this->devicestatus->get_status_id($status);
		
		$return = $this->devicelog->insert_log($this->session->userdata('user_id'), $item_id, $item, 'update status', 0, $current_status['status_name'] . ' to ' . $update_status['status_name']);
		
		$this->comment_add($this->db->insert_id(), $status_comment); 
		
		$this->devicestatus->update_status($item, $item_id, $status);
		
		if ($return) {
			echo "Success";
		} else {
			echo "ERROR";
		}
	}
	
	
	
}