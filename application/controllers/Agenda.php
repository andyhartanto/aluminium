<?php
  Class Agenda extends CI_Controller{
    function __construct(){
      parent::__construct();
      //loading model Agenda_model
      $this->load->model('Agenda_model');
      //cek user admin sudah login atau belum
      if($this->session->userdata('username')==null){
        redirect('Home/login');
      }
      //$this->load->helper('cleanurl_helper');
      //$this->load->helper('tglindo_helper');
      //$this->load->model('Link_model');
    }
    //untuk menampilkan agenda terbaru
    //function index(){
      // $data['a_terbaru'] = $this->Agenda_model->agenda_terbaru(5);
      // $data['a_sebelumnya'] = $this->Agenda_model->agenda_sebelumnya(5,5);
      // //$data['banner'] = $this->Link_model->daftar(5,0);
      // $data['jenis'] = "Agenda";
      // $this->load->view('vAgendaAdmin.html',$data);
    //}

    //menampilkan kelola agenda
    function index(){
      $page = $this->uri->segment(3);
      $limit = 5;
      if(!$page):$offset = 0;
      else:$offset = $page;
      endif;

      $data = array();
      // $total = $this->Agenda_model->agenda_semua();
      // $config['total_rows'] = $total->num_rows();
      //ambil data jumlah agenda
      $config['total_rows'] = $this->db->get('agenda')->num_rows();
      // set data yang ditampilkan
      $config['base_url'] = base_url().'index.php/Agenda/index/';
      $config['per_page'] = $limit;
      $config['uri_segment'] = 3;
      $config['first_link'] = 'Awal ';
      $config['last_link'] = ' Akhir';
      $config['next_link'] = 'Selanjutnya ';
      $config['prev_link'] = ' Sebelumnya';
      // setup konfigurasi untuk pagination
      $this->pagination->initialize($config);
      // data pagination
      $data['paginator'] = $this->pagination->create_links();
      $data['page'] = $page;
      $data['hasil'] = $this->Agenda_model->tampil_agenda($offset, $limit);
      // $data['jenis'] = 'Module Agenda';
      $this->load->view('vAgendaAdmin.html',$data);
    }

    function tambah_agenda(){
      $this->form_validation->set_rules('judul', 'Judul', 'required');
      $this->form_validation->set_rules('penulis', 'Penulis', 'required');
      $this->form_validation->set_rules('isi', 'Isi', 'required');

      if($this->form_validation->run()==TRUE){
        if($this->input->post('simpan')){
          //konfigurasi dan upload gambar
          $config['upload_path'] = './assets/img/agenda/';
          $config['allowed_types'] = 'gif|jpg|jpeg|png';
          $config['max_size'] = 8024;
          $config['max_width'] = 4024;
          $config['max_height'] = 4024;
          $this->upload->initialize($config);
          $this->upload->do_upload('upGambar');
          $data_gambar = $this->upload->data();

          //konfigurasi dan upload gambar thumbnails
          $config2['source_image'] = $data_gambar['full_path'];
          $config2['new_image'] = './assets/img/agenda/thumbs';
          $config2['maintain_ration'] = TRUE;
          $config2['width'] = 200;
          $config2['height'] = 200;
          $this->image_lib->initialize($config2);
          $this->image_lib->resize();

          $this->Agenda_model->simpan_agenda();
          redirect('Agenda');
        }
      }
      $this->load->view('vTambahAgendaAdmin.html');
    }

    function edit_agenda(){
      $id = $this->uri->segment(3);
      $this->form_validation->set_rules('judul', 'Judul', 'required');
      $this->form_validation->set_rules('penulis', 'Penulis', 'required');
      $this->form_validation->set_rules('isi', 'Isi', 'required');
      if($this->form_validation->run()==true){
        if($_POST==NULL){
          $data['data_edit'] = $this->Agenda_model->get_data_edit_agenda($id);
          $this->load->view('vUpdateAgendaAdmin.html',$data);
        }else{
          $this->Agenda_model->update_agenda($id);
          redirect('Agenda');
        }
      }else{
        $data['data_edit'] = $this->Agenda_model->get_data_edit_agenda($id);
        $this->load->view('vUpdateAgendaAdmin.html',$data);
      }
    }

    function delete_agenda(){
      $id = $this->uri->segment(3);
      $this->Agenda_model->hapus_agenda($id);
      redirect('Agenda');
    }
  }
?>
