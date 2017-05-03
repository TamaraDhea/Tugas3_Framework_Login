<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in')){
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
		}else{
			redirect('login','refresh');
		}	
	}

	public function index()
	{
		$this->load->model('pegawai_model');
		$data["pegawai_list"] = $this->pegawai_model->getDataPegawai();
		$this->load->view('pegawai_datatable',$data);	
	}
	
	public function datatable() //pertama membuat datatable ini
	{
		$this->load->model('pegawai_model');
		$data["pegawai_list"] = $this->pegawai_model->getDataPegawai();
		$this->load->view('pegawai_datatable',$data);
	}

	public function create()
	{
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('nip', 'Nip', 'trim|required|max_length[20]|numeric');
		$this->form_validation->set_rules('tanggalLahir', 'Tanggal Lahir', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required|max_length[100]');
		$this->load->model('pegawai_model');	
		if($this->form_validation->run()==FALSE){

			$this->load->view('tambah_pegawai_view');

		}else{
			$config['upload_path'] = './assets/uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = 1000000000;
			$config['max_width']  = 10240;
			$config['max_height']  = 7680;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('userfile'))
			{
				$error = array('error' => $this->upload->display_errors());
				$this->load->view('tambah_pegawai_view',$error);
			}
			else
			{
				$this->pegawai_model->insertPegawai();
				redirect('pegawai');
			}
		}
	}
	//method update butuh parameter id berapa yang akan di update
	public function update($id)
	{
		//load library
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('nip', 'Nip', 'trim|required|max_length[20]|numeric');
		$this->form_validation->set_rules('tanggalLahir', 'Tanggal Lahir', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
		$this->load->model('pegawai_model');
		$data['pegawai']=$this->pegawai_model->getPegawai($id);
		$filename = 'foto';

		if($this->form_validation->run()==FALSE){
			$this->load->view('edit_pegawai_view',$data);

		}else{

			$config['upload_path'] = './assets/uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = '1000000000';
			$config['max_width']  = '10240';
			$config['max_height']  = '7680';

			$this->load->library('upload', $config);

			if( ! $this->upload->do_upload())
			{
				$error = array('error' =>$this->upload->display_errors());
				$this->load->viev('edit_pegawai_view');
			}

			else
			{
				$image_data = $this->upload->data();
				$configer=array
				(
					'image_library' => 'gd2',
					'source_image' => $image_data['full_path'],
					'maintain_ration' => TRUE,
					'width' => 250,
					'height' => 250,
				);
				$this->load->library('image_lib', $config);
				$this->image_lib->clear();
				$this->image_lib->initialize($configer);
				$this->image_lib->resize();
				$this->pegawai_model->updateById($id);
				redirect('pegawai/datatable');
			}

			$this->pegawai_model->updateById($id);
			redirect('pegawai');

		}
	}

	public function delete($id)
	{

		$this->load->helper('url','form');
		$this->load->library('form_validation');
		$this->load->model('pegawai_model');
		$this->pegawai_model->deleteById($id);
		if($this->form_validation->run()==FALSE){
			redirect('pegawai');
		}
		
	}
}

/* End of file Pegawai.php */
/* Location: ./application/controllers/Pegawai.php */

 ?>