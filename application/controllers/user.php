<?php

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		
		$this->load->model('User_model');
		
	}
	
	function index()
	{
		// echo "test";
		
//		$this->load->view('welcome_message');
	}
	
	function register()
	{

		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|callback_is_username_exist|alpha_dash|min_length[4]|strtolower');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[6]|max_length[100]');
		$this->form_validation->set_rules('password_conf', 'Password Confirm', 'trim|required|xss_clean|min_length[6]|matches[password]');
		$this->form_validation->set_rules('secrete_phrase', 'Secrete Phrase', 'trim|required|xss_clean|callback_secrete_phrase');
		$this->form_validation->set_rules('user_level', 'User Level', 'trim|xss_clean');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('form_register');
		}
		else 
		{
			
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$user_level = $this->input->post('user_level');
			
			$this->User_model->register_new_account($username, $password, $user_level);
			
		}
	}
	
	function login()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('form_login');
		}
		else 
		{
			
			$username = $this->input->post('username');
			$password =  $this->input->post('password');
			
			$data = $this->User_model->check_user_login($username, $password);
			if($data)
			{
				$row = $data->row();
				
				$sess_data = array(
					'user_id'	=> $row->ID,
                	'username'  => $username,
                	'is_logged' => TRUE
               	);

				$this->session->set_userdata($sess_data);
				
				redirect('/', 'refresh');
			}
			else 
			{
				echo "Login Failed";
			}
		}
		
	}
	
	function logout()
	{
		$sess_data = array(
			'user_id'	=> '',
        	'username'  => '',
        	'is_logged' => false
        );
		$this->session->unset_userdata($sess_data);
		
		redirect('/user/login/', 'refresh');
	}
	
	function notlogged()
	{
		$this->load->view('form_login',array('err' => 'Login first'));
	}
	
	function is_username_exist($username)
	{
		
		$this->form_validation->set_message('is_username_exist', 'Username already exist.');
		
		return $this->User_model->check_user_exist($username);
		
	}
	
	function secrete_phrase($phrase)
	{
		
		$this->form_validation->set_message('secrete_phrase', 'Invalid Secrete Phrase.');
		
		if($phrase=='1t0nly')
		{
			return true;
		}
		else 
		{
			return false;
		}
		
	}
	
}
