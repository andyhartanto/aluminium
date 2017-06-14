<?php
  Class Upload extends CI_Controller{
    function __construct(){
      parent::__construct();
    }

    public function index(){
      $this->load->view('vUpload.html', array('error'=>' '));
    }

    public function aksi_upload(){
      $config['upload_path'] = './gambar/';
      $config['allowed_types'] = 'gif|jpg|jpeg|png';
      $config['max_size'] = 100;
      $config['max_width'] = 1024;
      $config['max_height'] = 768;
      $this->upload->initialize($config);

      //cek upload error atau berhasl
      if(!$this->upload->do_upload('berkas')){
        $error = array('error'=>$this->upload->display_errors());
        $this->load->view('vUpload.html', $error);
      }else{
        $data = array('upload_data'=>$this->upload->data());
        $this->load->view('vUploadSukses.html', $data);
      }
    }
  }
?>
