<?php
  class Agenda_model extends CI_Model{
    function __construct(){
      parent::__construct();
    }

    function agenda_terbaru($limit){
      // $this->db->select('idAgenda, judul, penulis, tanggalPost, isi, gambar');
      // $this->db->from('agenda');
      // $this->db->limit($limit);
      // $this->db->order_by("idAgenda","desc");
      // $query = $this->db->get();
      $query = $this->db->query("SELECT * FROM agenda ORDER BY idAgenda DESC LIMIT 5");
      return $query;
    }

    function agenda_sebelumnya($limit, $offset){
      $this->db->select('idAgenda, judul');
      $this->db->from('agenda');
      $this->db->limit('$limit, $offset');
      $this->db->order_by("idAgenda","desc");
      $query = $this->db->get();
      return $query;
    }

    function agenda_semua(){
      $this->db->select('*');
      $this->db->from('agenda');
      $this->db->order_by('idAgenda','desc');
      $query = $this->db->get();
      return $query;
    }

    function tampil_agenda($offset, $limit){
      $query = $this->db->query("SELECT * FROM agenda ORDER BY idAgenda DESC LIMIT $offset, $limit");
      return $query;
    }

    function ambil_data_agenda_per_id($id){
      $this->db->select('*');
      $this->db->from('agenda');
      $this->db->where('idAgenda',$id);
      $query = $this->db->get();
      return $query;
    }

    function simpan_agenda(){
      $judul = $this->input->post('judul');
      $penulis = $this->input->post('penulis');
      $isi = $this->input->post('isi');
      $tgl = date('Y-m-d');
      $gambar = $_FILES['upGambar']['name'];

      $data = array('judul' => $judul, 'penulis' => $penulis, 'isi' => $isi, 'tanggalPost' => $tgl, 'gambar' => $gambar);
      $this->db->insert('agenda', $data);
    }

    function get_data_edit_agenda($id){
      $this->db->select('*');
      $this->db->from('agenda');
      $this->db->where('idAgenda',$id);
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    function update_agenda($id){
      $userfile = $_FILES['userfile']['name'];
      //jika gambar diupdate
      if(!empty($userfile)){
        //konfiguras library->upload, set tipe data dan path tempat upload
        $konfigurasi['upload_path'] = './assets/img/agenda/';
        $konfigurasi['allowed_types'] = 'gif|jpg|jpeg|png';
        $konfigurasi['max_size'] = 8024;
        $konfigurasi['max_width'] = 4024;
        $konfigurasi['max_height'] = 4024;
        $this->upload->initialize($konfigurasi);
        // $this->load->library('upload', $konfigurasi);
        $this->upload->do_upload();
        $data_file = $this->upload->data();

        //konfigurasi gambar thumbnails
        // $konfigurasi2['image_library'] = 'gd2';
        // $konfigurasi2['source_image'] = '$data_file';
        $konfigurasi2['source_image'] = $data_file['full_path'];
        $konfigurasi2['new_image'] = './assets/img/agenda/thumbs';
        $konfigurasi2['create_tumb'] = TRUE;
        $konfigurasi2['maintain_ration'] = TRUE;
        $konfigurasi2['width'] = 200;
        $konfigurasi2['height'] = 200;
        $this->image_lib->initialize($konfigurasi2);
        // $this->load->library('image_lib', $konfigurasi2);
        $this->image_lib->resize();

        $judul = $this->input->post('judul');
        $penulis = $this->input->post('penulis');
        $isi = $this->input->post('isi');
        $tgl = date('Y-m-d');
        $gambar = $_FILES['userfile']['name'];

        $data = array('judul'=>$judul,
                      'penulis'=>$penulis,
                      'isi'=>$isi,
                      'tanggalPost'=>$tgl,
                      'gambar'=>$gambar);
        $this->db->where('idAgenda',$id);
        $this->db->update('agenda',$data);
      }
      // tidak update foto
      else {
        $judul = $this->input->post('judul');
        $penulis = $this->input->post('penulis');
        $isi = $this->input->post('isi');
        $tgl = date('Y-m-d');
        $gambar = $_FILES['userfile']['name'];

        $data = array('judul'=>$judul,
                      'penulis'=>$penulis,
                      'isi'=>$isi,
                      'tanggalPost'=>$tgl,
                      'gambar'=>$gambar
                    );
        $this->db->where('idAgenda',$id);
        $this->db->update('agenda',$data);
      }

    }

    function hapus_agenda($id){
      $this->db->where('idAgenda',$id);
      $this->db->delete('agenda');
    }
  }
?>
