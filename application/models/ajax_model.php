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
	
	function assign_item($item, $item_id, $cubicle_id)
	{
		//update cubicle table
		$data = array(
        	$item => $item_id,
        );
		$update1 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle_id));
		
		//update item table
		$data = array(
        	'flag_assigned' => 1,
            'cubicle_id' => $cubicle_id,
        );
            
		$update2 = $this->db->update('nshis_'.$item.'s', $data, array($item.'_id' => $item_id));
		
		if($update1 && $update2)
		{
			//log
			$this->devicelog->insert_log($this->session->userdata('user_id'), $item_id, $item, 'assign', $cubicle_id);
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
		
	}
	
}