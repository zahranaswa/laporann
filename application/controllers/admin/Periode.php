<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Periode extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('licensing');
        $this->licensing->check_license();
		
		//Get Zona Waktu
        foreach ($this->db->get('tb_aplikasi')->result() as $timezone) {
            date_default_timezone_set($timezone->timezone);
        }

		if(!$this->session->userdata('level')){
			$this->session->set_flashdata('pesan', 'Anda harus masuk terlebih dahulu!');
			redirect('home');
		}
	}

	public function index()
	{
		$data['title']		= 'Data Periode';
		$data['subtitle']	= 'Data periode akan ditampilkan disini!';

		$data['collapse']	= 'No';

		$data['periode']	= $this->m_model->get_desc('tb_periode');
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/periode');
		$this->load->view('admin/templates/footer');
    }

	public function insert()
	{
		$periode	= $_POST['periode'];
		$status		= $_POST['status'];
		$terdaftar	= date('Y-m-d H:i:s');

		$data = array(
			'periode' 	=> $periode,
			'status' 	=> $status,
			'terdaftar' => $terdaftar
		);

		$this->m_model->insert($data, 'tb_periode');
		$this->session->set_flashdata('pesan', 'Data berhasil ditambahkan!');
		redirect('admin/periode');
	}

	public function delete($id)
	{
		$where = array('id' => $id);

		$this->m_model->delete($where, 'tb_periode');
		$this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
		redirect('admin/periode');
	}

	public function update($id)
	{
		$periode	= $_POST['periode'];
		$status		= $_POST['status'];

		$data = array(
			'periode' 	=> $periode,
			'status' 	=> $status
		);

		$where = array('id' => $id);

		$this->m_model->update($where, $data, 'tb_periode');
		$this->session->set_flashdata('pesan', 'Data berhasil diubah!');
		redirect('admin/periode');
	}
}