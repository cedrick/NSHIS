<?php 

class Search_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
  function search($item_type, $string)
  {
    $this->db->like('name', $string);
    
    $query = $this->db->get('nshis_'.$item_type.'s');
    
    if($query)
    {
      return $query;
    }else{
      return false;
    }
  }
  
}