<?php 

class User_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function check_user_login($username, $password)
	{
		$sha1_password = sha1($password);
		
		$query_str = "SELECT ID, username FROM nshis_users WHERE username = ? AND password = ? LIMIT 0,1";
		
		$return = $this->db->query($query_str, array($username, $sha1_password));
		
		
		if($return->num_rows() > 0)
		{
			return $return;
		}
		else 
		{
			return false;
		}
	}
	
	function check_user_exist($username)
	{
		
		$query_str = "SELECT username FROM nshis_users WHERE username = ? LIMIT 0,1";
		
		$return = $this->db->query($query_str, array($username));
		
		if($return->num_rows() > 0)
		{
			return false;
		}
		else 
		{
			return true;
		}
	}
	
	function register_new_account($username, $password, $user_level)
	{
		$sha1_password = sha1($password);
		
		$query_str = "INSERT INTO nshis_users(username, password, level, cdate) VALUES(?, ?, ?, now())";
		
		$return = $this->db->query($query_str, array($username, $sha1_password, $user_level));
		
		if($return)
		{
			redirect('/user/login/', 'refresh');
		}
		else 
		{
			redirect('/user/register/', 'refresh');
		}
	}
}