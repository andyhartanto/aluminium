<?php
  class Karir extends CI_Controller
  {
    function __construct(){
      parent:: __construct();
      // load model karir
      $this->load->model('Karir_model');
      // cek user, sudah login atau belum
      if($this->session->userdata('username')==null){
        redirect('Home/login');
      }
    }

    function index(){
      $data['username']=$this->session->userdata('username');
      if($data['username']!=null)
      {
        $page = $this->uri->segment(3);
        $limit = 10;
        if(!$page){
          $offset = 0;
        }else{
          $offset = $page;
        }
        $data = array();
        $total = $this->Karir_model->karir_semua();

        $config ['total_rows'] = $total->num_rows();

        // ambil jumlah data karir
        $config['total_rows'] = $this->db->get('karir')->num_rows();
        //set data karir yang ditampilkan
        $config['base_url'] = base_url().'index.php/Karir/index/';
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['first_link'] = 'Awal';
        $config['last_link'] = 'Akhir';
        $config['next_link'] = 'Selanjutya';
        $config['prev_link'] = 'Sebelumnya';
        // setup konfigurasi pagination
        $this->pagination->initialize($config);
        // data pagination
        $data['paginator'] = $this->pagination->create_links();
        $data['nama'] = $this->session->userdata('nama');
        $data['seluruhKarir'] = $this->Karir_model->tampil_karir($offset, $limit);
        $data['page'] = $page;
        // $data['jenis'] = 'Module Karir';
        $this->load->view('vKarir.html',$data);
      }
    }

    function kelola_karir(){
      $data['username']=$this->session->userdata('username');
      if($data['username']!=null){
        $id_alumni = $this->session->userdata('id_alumni');
        $page = $this->uri->segment(3);
        $limit = 10;
        if(!$page){
          $offset = 0;
        }else{
          $offset = $page;
        }
        $data = array();
        $total = $this->Karir_model->karir_semua_by_id($id_alumni);
        $config['base_url'] = base_url().'Karir';
        $config ['total_rows'] = $total->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['first_link'] = 'Awal';
        $config['last_link'] = 'Akhir';
        $config['next_link'] = 'Selanjutya';
        $config['prev_link'] = 'Sebelumnya';
        $this->pagination->initialize($config);
        $data['paginator'] = $this->pagination->create_links();

        $data['nama'] = $this->session->userdata('nama');
        $data['karir_by_id'] = $this->Karir_model->tampil_karir_by_id($offset, $limit, $id_alumni);
        $data['page'] = $page;
        $this->load->view('vKelolaKarir.html',$data);
      }
    }

    function tambah_karir()
    {
      // cek validasi input dalam form
      $this->form_validation->set_rules('namaPerusahaan', 'Nama Perusahaan', 'required');
      $this->form_validation->set_rules('posisi', 'Posisi yang dibutuhkan', 'required');
      $this->form_validation->set_rules('kriteria', 'Syarat atau Kriteria', 'required');
      $this->form_validation->set_rules('batasWaktu', 'Batas Waktu', 'required');
      $this->form_validation->set_rules('kontak', 'Kontak', 'required');
      // $this->form_validation->set_rules('upGambar', 'Gambar', 'required');
      // jika semua inputan dari form sesuai / valid
      if($this->form_validation->run() == TRUE){
        // jika post tombol submit
        if($this->input->post('simpan')){
          //konfigurasi karakter asing dan spasi
          // $file_name = $_FILES['upGambar']['name'];
          // $new_file_name = preg_replace('/[A-Za-z0-9]/', "", $file_name);

          // konfigurasi untuk upload image
          $konfig['upload_path'] = './assets/img/karier/';
          $konfig['allowed_types'] =  'jpg|jpeg|png';
          $konfig['remove_spaces'] = FALSE;
          $konfig['max_size'] =  4024;
          $konfig['max_width'] = 8000;
          $konfig['max_height'] = 8000;
          // $konfig['file_name'] = $new_file_name;
          $this->upload->initialize($konfig);
          // proses upload gambar
          $this->upload->do_upload('upGambar');
          // $data_gambar = $this->upload->data();
          $this->Karir_model->simpan_karir();
          redirect('Karir');
        }
      }
      $data['id_alumni'] = $this->session->userdata('id_alumni');
      $data['nama'] = $this->session->userdata('nama');
      $this->load->view('vTambahKarirAluminium.html', $data);
    }

    public function tambah_karir_admin()
    {
      # code...
      // cek validasi input dalam form
      $this->form_validation->set_rules('namaPerusahaan', 'Nama Perusahaan', 'required');
      $this->form_validation->set_rules('posisi', 'Posisi yang dibutuhkan', 'required');
      $this->form_validation->set_rules('kriteria', 'Syarat atau Kriteria', 'required');
      $this->form_validation->set_rules('batasWaktu', 'Batas Waktu', 'required');
      $this->form_validation->set_rules('kontak', 'Kontak', 'required');

      // jika semua inputan dari form sesuai / valid
      if($this->form_validation->run() == TRUE){
        // jika post tombol submit
        if($this->input->post('simpan')){
          // konfigurasi untuk upload image
          $konfig['upload_path'] = './assets/img/karier/';
          $konfig['allowed_types'] =  'jpg|jpeg|png';
          $konfig['remove_spaces'] = FALSE;
          $konfig['max_size'] =  4024;
          $konfig['max_width'] = 8000;
          $konfig['max_height'] = 8000;
          $this->upload->initialize($konfig);
          // proses upload gambar
          $this->upload->do_upload('upGambar');
          // $data_gambar = $this->upload->data();
          $this->Karir_model->simpan_karir_admin();
          redirect('Admin/KelolaKarir');
        }
      }
      $data['id_alumni'] = $this->session->userdata('id_alumni');
      $data['admin'] = $this->session->userdata('username');
      $this->load->view('vTambahKarirAdmin.html', $data);
    }
    public function selengkapnya()
    {
      # code...
      $data['username']=$this->session->userdata('username');
      if($data['username']!=null)
      {
        $id = $this->uri->segment(3);
        $data['karir'] = $this->Karir_model->ambil_data_karir_per_id($id);
        $data['nama'] = $this->session->userdata('nama');
        $this->load->view('vKarirDetail.html', $data);
      }
    }

    public function edit_karir()
    {
      # code...
      $id = $this->uri->segment(3);
      $this->form_validation->set_rules('namaPerusahaan', 'Nama Perusahaan', 'required');
      $this->form_validation->set_rules('posisi', 'Posisi', 'required');
      $this->form_validation->set_rules('kriteria', 'Kriteria', 'required');
      $this->form_validation->set_rules('batasWaktu', 'Batas Waktu', 'required');
      $this->form_validation->set_rules('kontak', 'Kontak', 'required');
      if($this->form_validation->run()==true){
        if($_POST == NULL){
          $data['ambil_data_awal'] = $this->Karir_model->ambil_data_edit_per_id($id);
          $data['id_alumni'] = $this->session->userdata('id_alumni');
          $data['nama'] = $this->session->userdata('nama');
          $this->load->view('vUpdateKarirAluminium.html', $data);
        }else{
          $this->Karir_model->update_karir($id);
          redirect('Karir/kelola_karir');
        }
      }else{
        $data['ambil_data_awal'] = $this->Karir_model->ambil_data_edit_per_id($id);
        $data['id_alumni'] = $this->session->userdata('id_alumni');
        $data['nama'] = $this->session->userdata('nama');
        $this->load->view('vUpdateKarirAluminium.html', $data);
      }
    }

    public function edit_karir_admin()
    {
      # code...
      $id = $this->uri->segment(3);
      $this->form_validation->set_rules('namaPerusahaan', 'Nama Perusahaan', 'required');
      $this->form_validation->set_rules('posisi', 'Posisi', 'required');
      $this->form_validation->set_rules('kriteria', 'Kriteria', 'required');
      $this->form_validation->set_rules('batasWaktu', 'Batas Waktu', 'required');
      $this->form_validation->set_rules('kontak', 'Kontak', 'required');
      if($this->form_validation->run()==true){
        if($_POST == NULL){
          $data['ambil_data_awal'] = $this->Karir_model->ambil_data_edit_per_id($id);
          $data['id_alumni'] = $this->session->userdata('id_alumni');
          $data['admin'] = $this->session->userdata('username');
          $this->load->view('vUpdateKarirAdmin.html', $data);
        }else{
          $this->Karir_model->update_karir($id);
          redirect('Admin/KelolaKarir');
        }
      }else{
        $data['ambil_data_awal'] = $this->Karir_model->ambil_data_edit_per_id($id);
        $data['id_alumni'] = $this->session->userdata('id_alumni');
        $data['admin'] = $this->session->userdata('username');
        $this->load->view('vUpdateKarirAdmin.html', $data);
      }
    }

    public function hapus_karir()
    {
      # code...
      $id = $this->uri->segment(3);
      $this->Karir_model->hapus_karir_by_id($id);
      redirect('Karir/kelola_karir');
    }

    public function hapus_karir_admin()
    {
      # code...
      $id = $this->uri->segment(3);
      $this->Karir_model->hapus_karir_by_id($id);
      redirect('Admin/KelolaKarir');
    }
  }
?>
