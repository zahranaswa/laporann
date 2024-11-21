<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->library('licensing');
        $this->load->library('login_attempt');
        $this->licensing->check_license();
        //Get Zona Waktu
        foreach ($this->db->get('tb_aplikasi')->result() as $timezone) {
            date_default_timezone_set($timezone->timezone);
        }
	}

    public function index()
    {
        if ($this->session->userdata('level') == 'Administrator') {
            redirect('admin/dashboard');
        } else {
            $data['title']  = 'Login';
            $digit1 = mt_rand(1, 20);
            $digit2 = mt_rand(1, 20);
            
            $captcha = array('captcha' => $digit1+$digit2);

            $this->session->set_userdata($captcha);
            $data['captcha'] = "$digit1 + $digit2 = ?";

            $data['aplikasi'] = $this->m_model->get_desc('tb_aplikasi');

            $this->load->view('login', $data);
        }
    }
    
    public function auth()
    {
        $username   = $_POST['username'];
        $password   = $_POST['password'];
        $jawaban    = $_POST['jawaban'];

        if(!empty($jawaban)) {

            if($jawaban == $this->session->userdata('captcha')) {
       
                $where = array( 'username' => $username );

                $cek = $this->m_model->get_where($where, 'tb_user');
    
                if ($cek->num_rows() > 0) {
                    
                    // Check if login attempts exceeded
                    if ($this->login_attempt->is_max_login_attempts_exceeded($username)) {
                        // Block account
                        $this->session->set_flashdata('pesan', 'Kesempatan login sudah habis, silahkan coba lagi nanti!');
                        redirect('home');
                    }
                    
                    foreach ($cek->result_array() as $row) {

                        if(password_verify($password, $row['password'])) {

                            if($row['login'] == 'Ya') {
                                $datauser = array(
                                    'id'            => $row['id'], 
                                    'nama'          => $row['nama'],  
                                    'jenisKelamin'  => $row['jenisKelamin'],
                                    'tptLahir'      => $row['tptLahir'],
                                    'tglLahir'      => $row['tglLahir'],
                                    'telp'          => $row['telp'],   
                                    'email'         => $row['email'],
                                    'login'         => $row['login'],
                                    'alamat'        => $row['alamat'],
                                    'username'      => $row['username'],
                                    'skin'          => $row['skin'],
                                    'level'         => $row['level'],
                                    'foto'          => $row['foto'],
                                    'terdaftar'     => $row['terdaftar'],
                                    'start_time'    => date('Y-m-d H:i:s'),
                                );
    
                                $this->session->set_userdata($datauser);
    
                                $insertLog = array(
                                    'idUser'    => $row['id'],
                                    'status'    => 'Login',
                                    'ipAddress' => $_SERVER['REMOTE_ADDR'],
                                    'device'    => $_SERVER['HTTP_USER_AGENT'],
                                    'terdaftar' => date('Y-m-d H:i:s'),
                                );
    
                                $this->m_model->insert($insertLog, 'tb_log');

                                $this->login_attempt->reset_login_attempts($username);
                                
                                if($row['level'] == 'Administrator' OR $row['level'] == 'User') {
                                    redirect('admin/dashboard');
                                }
                                
                            } else {
                                $this->session->set_flashdata('pesan', 'Tidak ada akses login, silahkan hubungi administrator!');
                                redirect('home');
                            }
                            
                        } else {
                            $this->login_attempt->increment_login_attempts($username);

                            $this->session->set_flashdata('pesan', 'Password anda salah!');
                            redirect('home');
                        }
                    }
                } else {
                    $this->session->set_flashdata('pesan', 'Username tidak ditemukan!');
                    redirect('home');
                }
            } else {
                $this->session->set_flashdata('pesan', 'Hitung dengan benar!');
                redirect('home');
            }
        } else {
            $this->session->set_flashdata('pesan', 'Captcha harap diisi!');
            redirect('home');
        }
    }

    public function logout()
    {
        $insertLog = array(
            'idUser'    => $this->session->userdata('id'),
            'status'    => 'Logout',
            'ipAddress' => $_SERVER['REMOTE_ADDR'],
            'device'    => $_SERVER['HTTP_USER_AGENT'],
            'terdaftar' => date('Y-m-d H:i:s'),
        );

        $this->m_model->insert($insertLog, 'tb_log');

        $this->session->sess_destroy();
        redirect('home');
    }
}