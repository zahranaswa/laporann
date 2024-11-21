<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan extends CI_Controller {

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
		$data['title']		= 'Data Kegiatan';
		$data['subtitle']	= 'Data kegiatan akan ditampilkan disini!';

		$data['collapse']	= 'No';

		$data['periode']	= $this->m_model->get_desc('tb_periode');
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/filterkegiatan');
		$this->load->view('admin/templates/footer');
    }

	public function search()
	{
		$idPeriode	= $_POST['idPeriode'];

		redirect("admin/kegiatan/kegiatan/$idPeriode");
	}

	public function kegiatan($idPeriode)
	{
		$data['title']		= 'Data Kegiatan';
		$data['subtitle']	= 'Data kegiatan akan ditampilkan disini!';

		$data['collapse']	= 'No';

		$data['idPeriode']	= $idPeriode;
		$this->db->where('idPeriode', $idPeriode);
		if($this->session->userdata('level') == 'User') {
			$this->db->where('idUser', $this->session->userdata('id'));
		}
		$data['kegiatan']	= $this->m_model->get_desc('tb_kegiatan');
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/kegiatan');
		$this->load->view('admin/templates/footer');
	}

	public function insert($idPeriode)
	{
		$idUser		= $this->session->userdata('id');
		$nama		= $_POST['nama'];
		$keterangan	= $_POST['keterangan'];
		$status		= $_POST['status'];
		$terdaftar	= date('Y-m-d H:i:s');

		$data = array(
			'idUser' 		=> $idUser,
			'idPeriode' 	=> $idPeriode,
			'nama' 			=> $nama,
			'keterangan' 	=> $keterangan,
			'status' 		=> $status,
			'terdaftar' 	=> $terdaftar
		);

		$this->m_model->insert($data, 'tb_kegiatan');
		$this->session->set_flashdata('pesan', 'Data berhasil ditambahkan!');
		redirect("admin/kegiatan/kegiatan/$idPeriode");
	}

	public function delete($id, $idPeriode)
	{
		$where = array('id' => $id);

		$this->m_model->delete($where, 'tb_kegiatan');
		$this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
		redirect("admin/kegiatan/kegiatan/$idPeriode");
	}

	public function update($id, $idPeriode)
	{
		$nama		= $_POST['nama'];
		$keterangan	= $_POST['keterangan'];
		$status		= $_POST['status'];

		$data = array(
			'nama' 			=> $nama,
			'keterangan' 	=> $keterangan,
			'status' 		=> $status,
		);

		$where = array('id' => $id);

		$this->m_model->update($where, $data, 'tb_kegiatan');
		$this->session->set_flashdata('pesan', 'Data berhasil diubah!');
		redirect("admin/kegiatan/kegiatan/$idPeriode");
	}

	public function lampiran($idPeriode, $idData)
	{
		$data['title']		= 'Lampiran Kegiatan';
		$data['subtitle']	= 'Data lampiran kegiatan akan ditampilkan disini!';

		$data['collapse']	= 'Yes';

		$data['idPeriode']	= $idPeriode;
		$data['idData']		= $idData;
		$this->db->where('id', $idData);
		$data['kegiatan']	= $this->m_model->get_desc('tb_kegiatan');
		$this->db->where('idKegiatan', $idData);
		$data['lampiran']	= $this->m_model->get_desc('tb_lampiran');
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/lampirankegiatan');
		$this->load->view('admin/templates/footer');
	}

	public function insertlampiran($idPeriode, $idData)
	{
		$nama		= $_POST['nama'];
		$file		= $_FILES['file'];
		$terdaftar	= date('Y-m-d H:i:s');

		if($file != ''){
            $config['upload_path']      = './assets/file/';
            $config['allowed_types']    = '*';
            $config['file_name']        = 'file-' . time();

            $this->load->library('upload', $config);

            if(!$this->upload->do_upload('file')){
                $file = '';
            } else {
                $file = $this->upload->data('file_name');
            }
        }

		$data = array(
			'idKegiatan' 	=> $idData,
			'nama' 			=> $nama,
			'file' 			=> $file,
			'terdaftar' 	=> $terdaftar,
		);

		$this->m_model->insert($data, 'tb_lampiran');
		$this->session->set_flashdata('pesan', 'Data berhasil ditambahkan');

		redirect("admin/kegiatan/lampiran/$idPeriode/$idData");
	}

	public function deletelampiran($idData, $idPeriode, $idKegiatan)
	{
		$where = array('id' => $idData);

		$this->m_model->delete($where, 'tb_lampiran');
		$this->session->set_flashdata('pesan', 'Data berhasil dihapus!');
		redirect("admin/kegiatan/lampiran/$idPeriode/$idKegiatan");
	}

	public function updatelampiran($idPeriode, $idData, $idKegiatan)
	{
		$nama		= $_POST['nama'];
		$file		= $_FILES['file'];

		$where = array('id' => $idData);

		if($file != ''){
            $config['upload_path']      = './assets/file/';
            $config['allowed_types']    = '*';
            $config['file_name']        = 'file-' . time();

            $this->load->library('upload', $config);

            if(!$this->upload->do_upload('file')){
                $file = '';
            } else {
                $file = $this->upload->data('file_name');
            }
        }

		if($file != ''){
			$data = array(
				'nama' 			=> $nama,
				'file' 			=> $file,
			);
		} else {
			$data = array(
				'nama' 			=> $nama,
			);
		}

		$this->m_model->update($where, $data, 'tb_lampiran');
		$this->session->set_flashdata('pesan', 'Data berhasil ditambahkan');

		redirect("admin/kegiatan/lampiran/$idPeriode/$idKegiatan");
	}
}