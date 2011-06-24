<?php

class Usb_headset extends Controller {
  
  function Usb_headset() {
    
    parent::Controller();
    
    $this->load->model('Usb_headset_model');
    
    $this->load->model('Stats_model');
    
    $this->load->model('Globals_model');
    
  }
  
  function index() 
  {
  
    
    
  }
  
  function add() 
  {
    $this->form_validation->set_rules('usb_headset_name', 'Usb_headset Name', 'trim|required|xss_clean|callback_unique|min_length[4]|strtoupper');
    $this->form_validation->set_rules('usb_headset_other_name', 'Usb_headset Other Name', 'trim|xss_clean|min_length[4]');
    $this->form_validation->set_rules('usb_headset_sn', 'Serial number', 'trim|xss_clean|strtoupper');
    $this->form_validation->set_rules('usb_headset_date_purchased', 'Date Purchased', 'trim|xss_clean');
    $this->form_validation->set_rules('usb_headset_notes', 'Notes', 'trim|xss_clean');
    
    if($this->form_validation->run() == FALSE)
    {
      $this->load->view('template',array('page'=>'usb_headset/add'));
    }
    else 
    {
      
      $usb_headset_name = $this->input->post('usb_headset_name');
      $usb_headset_other_name = $this->input->post('usb_headset_other_name');
      $usb_headset_sn = $this->input->post('usb_headset_sn');
      $usb_headset_date_purchased = $this->input->post('usb_headset_date_purchased');
      $usb_headset_notes = $this->input->post('usb_headset_notes');
      
      $id = $this->Usb_headset_model->insert_new_usb_headset($usb_headset_name, $usb_headset_other_name, $usb_headset_sn, $usb_headset_date_purchased, $usb_headset_notes);
      
      if($id)
      {
        $this->Stats_model->insert_log($this->session->userdata('user_id'), $id, 'usb_headset', 'add');
        
        redirect('/usb_headset/view/'.$id, 'refresh');
      }
    }  
  }

  function view($usb_headset_id)
  {
    $info = $this->Usb_headset_model->get_usb_headset_info($usb_headset_id);
    $comments = $this->Usb_headset_model->get_comments($usb_headset_id);
    $logs = $this->Globals_model->get_item_logs($usb_headset_id, 'usb_headset');
    
    $data = array('info' => $info, 'comments' => $comments, 'logs' => $logs);
    
    $this->load->view('template',array('page'=>'usb_headset/view', 'data'=>$data));
  }

  function unique($usb_headset_name)
  {
    $exist = $this->Usb_headset_model->check_usb_headset_exist($usb_headset_name);
    
    if($exist)
    {
      $info = $this->Usb_headset_model->get_usb_headset_info_by_name($usb_headset_name);
      
      $this->form_validation->set_message('unique', anchor('usb_headset/view/'.$info['usb_headset_id'],$info['name']).' already exist.');
      
      return false;
    }
    else 
    {
      return true;
    }
  }
  
  function edit($usb_headset_id = NULL)
  {
    if (isset($usb_headset_id))
    {
      $this->form_validation->set_rules('usb_headset_name', 'Usb_headset Name', 'trim|required|xss_clean|alpha_numeric|min_length[4]|strtoupper');
      $this->form_validation->set_rules('usb_headset_other_name', 'Other Name', 'trim|xss_clean');
      $this->form_validation->set_rules('usb_headset_sn', 'Serial number', 'trim|xss_clean|strtoupper');
      $this->form_validation->set_rules('usb_headset_date_purchased', 'Date Purchased', 'trim|xss_clean');
      $this->form_validation->set_rules('usb_headset_notes', 'Notes', 'trim|xss_clean');
      
      if($this->form_validation->run() == FALSE)
      {
        $data = $this->Usb_headset_model->get_usb_headset_info($usb_headset_id);
        $this->load->view('template',array('page'=>'usb_headset/edit', 'data' => $data));
      }
      else 
      {
        $usb_headset_name = $this->input->post('usb_headset_name');
        $usb_headset_other_name = $this->input->post('usb_headset_other_name');
        $usb_headset_sn = $this->input->post('usb_headset_sn');
        $usb_headset_date_purchased = $this->input->post('usb_headset_date_purchased');
        $usb_headset_notes = $this->input->post('usb_headset_notes');
        
        $id = $this->Usb_headset_model->edit_usb_headset($usb_headset_id, $usb_headset_name, $usb_headset_other_name, $usb_headset_sn, $usb_headset_date_purchased, $usb_headset_notes);
        
        if ($id)
        {
          $this->Stats_model->insert_log($this->session->userdata('user_id'), $id, 'usb_headset', 'edit');
          
          redirect('/usb_headset/view/'.$id, 'refresh');
        }
        
      }
    }
    else
    {
      echo "Cannot edit empty usb_headset. Please go back into your previous page.";
    }
  }

  function comment($usb_headset_id)
  {
    $this->form_validation->set_rules('usb_headset_comment', 'Comment', 'trim|required|xss_clean');
    
    if($this->form_validation->run() == FALSE)
    {
      $data = $this->Usb_headset_model->get_usb_headset_info($usb_headset_id);
      $this->load->view('template',array('page'=>'usb_headset/comment', 'data' => $data));
    }
    else 
    {
      $comment = $this->input->post('usb_headset_comment');
      
      $id = $this->Usb_headset_model->insert_comment($usb_headset_id, $comment);
      
      if ($id)
      {
        $this->Stats_model->insert_log($this->session->userdata('user_id'), $id, 'usb_headset', 'comment');
      
        redirect('/usb_headset/view/'.$id, 'refresh');
      }
    }
  }
  
  function delete($usb_headset_id)
  {
    $this->form_validation->set_rules('delete', 'Delete', 'trim|required|xss_clean');
    
    if($this->form_validation->run() == FALSE)
    {
      $data = $this->Usb_headset_model->get_usb_headset_info($usb_headset_id);
      $this->load->view('template',array('page'=>'usb_headset/delete', 'data' => $data));
    }
    else 
    {
      $delete = $this->input->post('delete');
      
      if($delete=='no')
      {
        redirect('/usb_headset/view/' . $usb_headset_id, 'refresh');
      } 
      else 
      {
        $id = $this->Usb_headset_model->delete_usb_headset($usb_headset_id);
        
        if ($id)
        {
          $this->Stats_model->insert_log($this->session->userdata('user_id'), $id, 'usb_headset', 'delete');
          
          redirect('/usb_headset/viewall', 'refresh');
        }
      }   
    }
  }

  function viewall()
  {
    $data = $this->Usb_headset_model->get_all_usb_headset_info();
    
    $this->load->view('template',array('page'=>'usb_headset/viewall', 'data'=>$data));
  }

  function assign($usb_headset_id)
  {
    if($this->Usb_headset_model->is_assigned($usb_headset_id))
    {
      echo "This headset was already assigned.";
    }else
    {
      $this->form_validation->set_rules('usb_headset_assignto', 'Assigned to', 'trim|required|xss_clean|min_length[1]|callback_is_changed['.$usb_headset_id.']|callback_name_exist');
      
      if($this->form_validation->run() == FALSE)
      {
        $data = $this->Usb_headset_model->get_usb_headset_info($usb_headset_id);
        $this->load->view('template',array('page'=>'usb_headset/assign','data' => $data));
      }
      else 
      {
        $usb_headset_assignto = $this->input->post('usb_headset_assignto');
  
        $success = $this->Usb_headset_model->assign_usb_headset($usb_headset_id, $usb_headset_assignto);
        
        if ($success)
        {
          $this->Stats_model->insert_log($this->session->userdata('user_id'), $usb_headset_id, 'usb_headset', 'assign', 0, $usb_headset_assignto);
          
          redirect('/usb_headset/view/'.$usb_headset_id, 'refresh');
        }
      }
    }
  }
  
  function unassign($usb_headset_id)
  {
    if($this->Usb_headset_model->is_assigned($usb_headset_id))
    {
      $this->form_validation->set_rules('unassign', 'Unassign', 'trim|required|xss_clean');
    
      if($this->form_validation->run() == FALSE)
      {
        $data = $this->Usb_headset_model->get_usb_headset_info($usb_headset_id);
        $this->load->view('template',array('page'=>'usb_headset/unassign', 'data' => $data));
      }
      else 
      {
        $delete = $this->input->post('unassign');
        
        if($delete=='no')
        {
          redirect('/usb_headset/view/' . $usb_headset_id, 'refresh');
        } 
        else 
        {
          if ($this->Usb_headset_model->unassign_usb_headset($usb_headset_id))
          {
            $this->Stats_model->insert_log($this->session->userdata('user_id'), $usb_headset_id, 'usb_headset', 'unassign');
            
            redirect('/usb_headset/view/' . $usb_headset_id, 'refresh');
          }
        }   
      }
    }else
    {
      echo "This headset is not yet assign";
    }
  }
  
  function is_changed($assign, $id)
  {
    $is_changed = $this->Usb_headset_model->is_changed($assign, $id);
    
    if($is_changed)
    {
      return TRUE;
    }else
    {
      $this->form_validation->set_message('is_changed', 'No changes to assignments detected.');
    
      return FALSE;
    }
  }

  function name_exist($name)
  {
    $info = $this->Usb_headset_model->is_assigned_unique($name);
    if($info)
    {
      $row = $info->row();
      $this->form_validation->set_message('name_exist', $name.' already assigned in headset '.anchor('/usb_headset/view/' . $row->usb_headset_id, $row->name));
    
      return FALSE;
    }else
    {
      return TRUE;
    }
  }
  
  function available()
  {
    $data = $this->Usb_headset_model->get_all_usb_headset_info();
    
    if ($data)
    {
      $this->load->view('template',array('page'=>'usb_headset/available', 'data' => $data));
    }
  }
  
  function deployed()
  {
    $data = $this->Usb_headset_model->get_all_usb_headset_info();
    
    if ($data)
    {
      $this->load->view('template',array('page'=>'usb_headset/deployed', 'data' => $data));
    }
  }
}
