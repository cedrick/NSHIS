<?php 

class Search_model extends Model {
	
	function Search_model()
	{
		parent::Model();
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