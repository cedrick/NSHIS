<?php 

class Comment_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function add($log_id, $comment)
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
	
}