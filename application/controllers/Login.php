<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

public function index()
	{
		$this->load->view('login');
	}

public function cekLogin()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username','Username', 'trim|required');
		$this->form_validation->set_rules('password','Password', 'trim|required|callback_cekDb');

		if($this->form_validation->run()==false){
			$this->load->view('login');
		}
		else
		{
			redirect('Pegawai','refresh');
		}

	}


	public function cekDb($password)
	{
		$this->load->model('user');
		$username = $this->input->post('username');
		$result = $this->user->login($username,$password);
		if($result){
			$sess_array = array();
			foreach ($result as $row) {
				$sess_array = array('id'=>$row->id,'username'=> $row->username);
				$this->session->set_userdata('logged_in',$sess_array);
			}
			return true;
		}else{
			$this->form_validation->set_message('cekDb',"Login Gagal Username dan Password tidak valid");
			return false;
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
		redirect('login','refresh');
	}

	public function create()
	{
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'trim|required');
		$this->load->model('user');	
		if($this->form_validation->run()==FALSE){

			$this->load->view('register');

		}else{
			
				$this->user->insertUser();
				redirect('login');
		}
	}

}

 ?>