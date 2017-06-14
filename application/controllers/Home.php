<?php
	defined('BASEPATH') OR exit('File yang dimaksud tidak ada / tidak dapat diakses.');
	Class Home extends CI_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->database();
			$this->load->model('Login_model');
			$this->load->model('Agenda_model');
		}

		public function index(){
			//tampilkan agenda terbaru
			$data['agenda_terbaru'] = $this->Agenda_model->agenda_terbaru(5);
			//$data['agenda_sebelumnya'] = $this->Agenda_model->agenda_sebelumnya(5,5);
			$this->load->view('vHomeAluminium.html',$data);
		}

		public function login(){
			//cek login
			//mengecek alumni belum login sebelumnya
			if($this->session->userdata('username')==null)
			{
				//memvalidasi inputan user di form
				$this->form_validation->set_rules("txt_username", "Username", "trim|required");
				$this->form_validation->set_rules("txt_password", "Password", "trim|required");

				//pengecekan inputan dalam form
				if($this->form_validation->run() == FALSE)
				{
					$this->load->view('vLoginAluminium.html');
				}

				else if($this->form_validation->run() == TRUE)
				{
					//memasukan inputan dalam form ke variable
					$username = $this->input->post("txt_username");
					$password = $this->input->post("txt_password");
					$dekripsiPassword = md5($password);

					//konek ke model, untuk pengecekan proses login
					//deskripsi pass
					$hasil = $this->Login_model->get_alumni($username,$dekripsiPassword);
					//non deskripsi
					// $hasil = $this->Login_model->get_alumni($username,$password);

					if($hasil->num_rows()==1)
					{
						//memasukkan data hasil query $hasil ke dalam array
						foreach($hasil->result() as $sess)
						{
							$sess_data['id_alumni'] = $sess->id_alumni;
							$sess_data['username'] = $sess->username;
							$sess_data['tanggalLahir'] = $sess->tanggalLahir;
							$sess_data['alamat'] = $sess->alamatAsal;
							$sess_data['facebook'] = $sess->facebook;
							$sess_data['twitter'] = $sess->twitter;
							$sess_data['instagram'] = $sess->instagram;
							$sess_data['nama'] = $sess->nama;
							$sess_data['status'] = $sess->status;
							$this->session->set_userdata($sess_data);
							session_start();
						}

						//mengecek apakah yang login alumni
						if($this->session->userdata('status')=='alumni')
						{
							redirect('Alumni');
						}

						//mengecek apakah yang login Admin
						else if($this->session->userdata('username')=='admin' && $this->session->userdata('status')=='admin')
						{
							redirect('Admin');
						}
					}
					else
					{
						$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Maaf username atau password anda tidak valid ! Coba lagi...</div>' );
						redirect('Home/login');
					}
				}
			}

			//pengecekan untuk alumni dan admin yang sudah login dan masuk ke dashboard, mereka tidak dapat kembali ke halaman login
			else if($this->session->userdata('username')!=null)
			{
				if($this->session->userdata('status')=='admin')
					redirect('Admin');
				else{
					redirect('Alumni');
				}
			}
		}

		public function baca_agenda_lengkap(){
			$id = $this->uri->segment(3);
			$data['agenda'] = $this->Agenda_model->ambil_data_agenda_per_id($id);
			$this->load->view('vSelengkapnya.html',$data);
		}
	}
?>
