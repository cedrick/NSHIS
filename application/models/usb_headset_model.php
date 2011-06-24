<?php 

class Usb_headset_model extends CI_Model {
  
	function __construct()
	{
		parent::__construct();
  }
  
  function check_usb_headset_exist($usb_headset_name)
  {
    $return = $this->db->get_where('nshis_usb_headsets', array('name' => $usb_headset_name));
    
    if($return->num_rows() > 0)
    {
      return true;
    }
    else 
    {
      return false;
    }
  }
  
  function insert_new_usb_headset($usb_headset_name, $other_name, $serial_number, $date_purchased, $notes) 
  {
    $data = array(
      'name' => $usb_headset_name,
      'other_name' => $other_name,
      'serial_number' => $serial_number,
      'date_purchased' => $date_purchased,
      'notes' => $notes
    );
    
    $this->db->set('cdate', 'NOW()', FALSE);  
    
    $return = $this->db->insert('nshis_usb_headsets', $data); 
    
    $id = $this->db->insert_id();
    
    if ($return)
    {
      return $id;
    }
    else 
    {
      return false;
    }
  }
  
  function assign_usb_headset($usb_headset_id, $assign_to) 
  {
    $data = array(
          'flag_assigned' => 1,
          'assigned_person' => $assign_to,
        );
            
    $update1 = $this->db->update('nshis_usb_headsets', $data, array('usb_headset_id' => $usb_headset_id));
    
    if($update1)
    {
      return true;
    }
    else 
    {
      return false;
    }
  }
  
  function transfer($usb_headset_id, $cubicle)
  {
    $data = array(
          'flag_assigned' => 0,
            'cubicle_id' => 0
        );
            
    $update1 = $this->db->update('nshis_usb_headsets', $data, array('cubicle_id' => $cubicle));
    
    $data = array(
          'usb_headset' => 0
        );
            
    $update2 = $this->db->update('nshis_cubicles', $data, array('usb_headset' => $usb_headset_id));
    
    $data = array(
          'usb_headset' => $usb_headset_id
        );
            
    $update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle));
    
    $data = array(
          'flag_assigned' => 1,
            'cubicle_id' => $cubicle
        );
            
    $update4 = $this->db->update('nshis_usb_headsets', $data, array('usb_headset_id' => $usb_headset_id));
    
    if ($update1 && $update2 && $update3 && $update4)
    {
      return $cubicle;
    }
    else 
    {
      return false;
    }
    
    
  }
  
  function swap($usb_headset_id, $cubicle_usb_headset_id)
  {
    $id = explode('|', $cubicle_usb_headset_id);
    
    $dest_cubicle = $id[0];
    $dest_usb_headset = $id[1];
    
    $query = $this->db->get_where('nshis_usb_headsets', array('usb_headset_id' => $usb_headset_id));
    foreach ($query->result() as $row)
    {
        $source_cubicle = $row->cubicle_id;
        $source_usb_headset = $usb_headset_id;
    }
    
    $data = array(
          'flag_assigned' => 1,
            'cubicle_id' => $dest_cubicle
        );
            
    $update1 = $this->db->update('nshis_usb_headsets', $data, array('usb_headset_id' => $source_usb_headset));
    
    $data = array(
          'flag_assigned' => 1,
            'cubicle_id' => $source_cubicle
        );
            
    $update2 = $this->db->update('nshis_usb_headsets', $data, array('usb_headset_id' => $dest_usb_headset));
    
    $data = array(
          'usb_headset' => $dest_usb_headset
        );
            
    $update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $source_cubicle));
    
    $data = array(
          'usb_headset' => $source_usb_headset
        );
            
    $update3 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $dest_cubicle));
    
    if ($update1 && $update2 && $update3)
    {
      return $dest_cubicle;
    }
    else 
    {
      return false;
    }
    
    
  }
  
  function get_available_usb_headsets()
  {
    $return = $this->db->get_where('nshis_usb_headsets', array('flag_assigned' => 0));
    
    if($return->num_rows() > 0)
    {
      return $return;
    }
    else 
    {
      return false;
    }
  }
  
  function get_usb_headset_info($usb_headset_id)
  {
    
    $this->db->select('nshis_usb_headsets.name as usb_headset_name,  nshis_usb_headsets.*');
    $this->db->from('nshis_usb_headsets');
    $this->db->where('nshis_usb_headsets.usb_headset_id', $usb_headset_id); 
    
    $return = $this->db->get();
    
    
//    $return = $this->db->get_where('nshis_usb_headsets', array('usb_headset_id' => $usb_headset_id));
    
//    $query_str = "SELECT * FROM nshis_usb_headsets WHERE usb_headset_id = ? LIMIT 1";
//    
//    $return = $this->db->query($query_str, array($usb_headset_id));
    
    if($return->num_rows() > 0)
    {
//      $row = $return->row_array(); 
      return $return;
    }
    else 
    {
      return false;
    }
  }
  
  function get_usb_headset_info_by_name($usb_headset_name)
  {
    $query_str = "SELECT * FROM nshis_usb_headsets WHERE name = ? LIMIT 1";
    
    $return = $this->db->query($query_str, array(trim($usb_headset_name)));
    
    if($return->num_rows() > 0)
    {
      $row = $return->row_array(); 
      return $row;
    }
    else 
    {
      return false;
    }
  }
  
  function get_all_usb_headset_info()
  {
    $this->db->select('nshis_usb_headsets.name as usb_headset_name,  nshis_usb_headsets.*');
    $this->db->from('nshis_usb_headsets');
    $this->db->order_by('nshis_usb_headsets.name', 'asc'); 
    $return = $this->db->get();
    
    if($return->num_rows() > 0)
    {
      return $return;
    }
    else 
    {
      return false;
    }
  }
  
  function insert_comment($usb_headset_id, $comment)
  {
    $data = array(
      'user_id' => $this->session->userdata('user_id'),
      'device_id' => $usb_headset_id,
      'device' => 'usb_headset',
      'comment' => $comment
    );
    
    $this->db->set('cdate', 'NOW()', FALSE);  
    
    $return = $this->db->insert('nshis_comments', $data); 
    
    if($return)
    {
      return $usb_headset_id;
    }
    else
    {
      return false;
    }
  }
  
  function get_comments($usb_headset_id)
  {
    $this->db->select('nshis_comments.comment, nshis_comments.cdate, nshis_users.username');
    $this->db->from('nshis_comments');
    $this->db->join('nshis_users', 'nshis_users.ID = nshis_comments.user_id','right');
    $this->db->where('nshis_comments.device_id', $usb_headset_id);
    $this->db->where('nshis_comments.device', 'usb_headset');
    $this->db->order_by('nshis_comments.cdate', 'desc'); 
    $return = $this->db->get();
    
    if($return->num_rows() > 0)
    {
      return $return;
    }
    else 
    {
      return false;
    }
  }
  
  function edit_usb_headset($usb_headset_id, $usb_headset_name, $usb_headset_other_name, $usb_headset_sn, $usb_headset_date_purchased, $notes)
  {
    $data = array(
      'name' => $usb_headset_name,
      'other_name' => $usb_headset_other_name,
      'serial_number' => $usb_headset_sn,
      'date_purchased' => $usb_headset_date_purchased,
      'notes' => $notes
    );
    
    $this->db->set('cdate', 'NOW()', FALSE);  
    $this->db->where('usb_headset_id', $usb_headset_id);
    $return = $this->db->update('nshis_usb_headsets', $data); 
    
    if($return)
    {
      return $usb_headset_id;
    }
    else 
    {
      return false;
//      redirect('/user/register/', 'refresh');
    }
  }
  
  function delete_usb_headset($usb_headset_id)
  {
    $delete = $this->db->delete('nshis_usb_headsets', array('usb_headset_id' => $usb_headset_id)); 
    
    if ($delete)
    {
      return $usb_headset_id;
    }
    else
    {
      return false;
    }
  }
  
  function unassign_usb_headset($usb_headset_id)
  {
    $data = array(
      'flag_assigned' => 0,
      'assigned_person' => NULL
    );
    $unassign = $this->db->update('nshis_usb_headsets', $data, array('usb_headset_id' => $usb_headset_id)); 
    
    if ($unassign)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
  function get_cubicle_usb_headset_info($usb_headset_id = NULL)
  {
    $this->db->select('nshis_usb_headsets.usb_headset_id, nshis_usb_headsets.name as usb_headset_name, nshis_cubicles.cubicle_id, nshis_cubicles.name as cb_name');
    $this->db->from('nshis_usb_headsets');
    $this->db->join('nshis_cubicles', 'nshis_usb_headsets.cubicle_id = nshis_cubicles.cubicle_id','right');
    $this->db->order_by('nshis_cubicles.name', 'asc'); 
    $return = $this->db->get();
    
    if($return->num_rows() > 0)
    {
      return $return;
    }
    else 
    {
      return false;
    }
  }
  
  function pull_out($usb_headset_id)
  {
    $usb_headset = $this->db->get_where('nshis_usb_headsets', array('usb_headset_id' => $usb_headset_id), 1);
    $row = $usb_headset->row_array();
    $cubicle_id = $row['cubicle_id'];
    
    if($cubicle_id)
    {
      $data = array(
            'flag_assigned' => 0,
              'cubicle_id' => 0
          );
              
      $update1 = $this->db->update('nshis_usb_headsets', $data, array('usb_headset_id' => $usb_headset_id));
      
      $data = array(
            'usb_headset' => 0
          );
              
      $update2 = $this->db->update('nshis_cubicles', $data, array('cubicle_id' => $cubicle_id));
      
      if ($update1 && $update2)
      {
        return $cubicle_id;
      }
      else
      {
        return false;
      }
    }else 
    {
      return false;
    }
  }
  
  function is_changed($assign, $id)
  {
    $result = $this->db->get_where('nshis_usb_headsets', array('usb_headset_id' => $id, 'assigned_person' => $assign));
    
    if($result->num_rows() > 0)
    {
      return FALSE;
    }else
    {
      return TRUE;
    }
  }
  
  function is_assigned($id)
  {
    $result = $this->db->get_where('nshis_usb_headsets', array('usb_headset_id' => $id, 'flag_assigned' => 1));
    
    if($result->num_rows() > 0)
    {
      return TRUE;
    }else
    {
      return FALSE;
    }
  }
  
  function is_assigned_unique($name)
  {
    $result = $this->db->get_where('nshis_usb_headsets', array('assigned_person' => $name));
    
    if($result->num_rows() > 0)
    {
      return $result;
    }else
    {
      return FALSE;
    }
  }
}