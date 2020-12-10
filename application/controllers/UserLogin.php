<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserLogin extends CI_Controller {

	public function __construct()
	{
			parent::__construct();
			
	}
	public function login()
	{
		$this->load->view('user/login');
	}
	public function login_process()
	{
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','password','required');
		if($this->form_validation->run() == FALSE) {
			$this->load->view('user/login');
		}
		else{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$data = $this->UserModel->login_process($username,$password);
			if($data == TRUE){
				$userdetails = array(
				'username' =>$username,
				'logged_in' => TRUE,
				
				);
			$this->session->set_userdata($userdetails);
			redirect('login_success');
			}
			else{
				$this->session->set_flashdata('error','Username/Password Incorrect!!!');
				redirect('login');
			}
		}
		
	}	
	
	public function login_success(){
		if($this->session->userdata('username') != NULL){
			$this->load->view('user/login_success');
			
		}
		else{
			$this->session->set_flashdata('auth' ,'Authentication Required!!!');
			redirect('login');
		}
		
	}
	
	
	
	public function logout(){
		
		$this->session->unset_userdata('username');
		redirect('login');
	}
	
}

?>
