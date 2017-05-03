<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Register extends CI_Controller {

public function index()
	{
		$this->load->view('register');
	}

public function createuser()
	{
		$this->load->helper('url','form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username','Username', 'trim|required|callback_cekDb');
		$this->form_validation->set_rules('password','Password', 'trim|required');
		$this->load->model('user');

		if($this->form_validation->run()==false){
			$this->load->view('register');
		}
		else
		{
			$this->user->insertUser();
			$this->load->view('register_sukses');
		}

	}


	public function cekDb()
	{
		$this->load->model('user');
		$username = $this->input->post('username');
		$result = $this->user->register($username);
		if($result){
			$this->form_validation->set_message('cekDb',"Registrasi Gagal Username sudah digunakan");
			return false;
		}else{
			return true;
		}
	}

}

 ?>