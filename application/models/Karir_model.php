<?php
  /**
   *
   */
  class Karir_model extends CI_Model
  {

    public function __construct()
    {
      # code...
      parent::__construct();
    }

    public function ambil_id_alumni_fk()
    {
      # code...
      $this->db->select('*');
      $this->db->from('karir');
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    public function ambil_nama_poster_perid($id)
    {
      # code...
      $this->db->select('nama');
      $this->db->from('alumni');
      $this->db->where('id_alumni', $id);
      $query = $this->db->get();
      return $query->result();
    }

    public function ambil_path_gambar_per_id($id){
      $this->db->select('gambar');
      $this->db->from('karir');
      $this->db->where('id_karir', $id);
      $query = $this->db->get();
      return $query->row();
    }

    public function simpan_karir()
    {
      # code...
      $id_alumni = $this->input->post('idAlumni');
      $namaPerusahaan = $this->input->post('namaPerusahaan');
      $posisi = $this->input->post('posisi');
      $kriteria = $this->input->post('kriteria');
      $batasWaktu = $this->input->post('batasWaktu');
      $kontak = $this->input->post('kontak');
      $gambar = $_FILES['upGambar']['name'];

      $data = array(
        'id_alumni_fk' => $id_alumni,
        'namaPerusahaan' => $namaPerusahaan,
        'posisi' => $posisi,
        'kriteria' => $kriteria,
        'batasWaktu' => $batasWaktu,
        'kontak' => $kontak,
         'gambar' => $gambar
      );
      $this->db->insert('karir', $data);
    }

    public function simpan_karir_admin()
    {
      # code...
      $idAdmin = "admin";
      $namaPerusahaan = $this->input->post('namaPerusahaan');
      $posisi = $this->input->post('posisi');
      $kriteria = $this->input->post('kriteria');
      $batasWaktu = $this->input->post('batasWaktu');
      $kontak = $this->input->post('kontak');
      $gambar = $_FILES['upGambar']['name'];

      $data = array(
        'id_alumni_fk' => $idAdmin,
        'namaPerusahaan' => $namaPerusahaan,
        'posisi' => $posisi,
        'kriteria' => $kriteria,
        'batasWaktu' => $batasWaktu,
        'kontak' => $kontak,
         'gambar' => $gambar
      );
      $this->db->insert('karir', $data);
    }

    public function karir_semua()
    {
      # code...
      $this->db->select('*');
      $this->db->from('karir');
      $this->db->order_by('id_karir','desc');
      $query = $this->db->get();
      return $query;
    }

    public function ambil_data_karir_per_id($id)
    {
      # code...
      $this->db->select('*');
      $this->db->from('karir');
      $this->db->where('id_karir', $id);
      $query = $this->db->get();
      return $query;
    }

    public function ambil_data_edit_per_id($id)
    {
      # code...
      $this->db->select('*');
      $this->db->from('karir');
      $this->db->where('id_karir', $id);
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    public function tampil_karir($offset, $limit)
    {
      # code...
      // $this->db->select('*');
      // $this->db->from('karir');
      // $this->db->limit('$limit','$offset');
      // $this->db->order_by('batasWaktu','desc');
      // $query = $this->db->get();
      $query = $this->db->query("SELECT * FROM karir ORDER BY id_karir DESC LIMIT $offset, $limit");
      return $query;
    }

    public function karir_semua_by_id($id_alumni)
    {
      # code...
      $this->db->select('*');
      $this->db->from('karir');
      $this->db->where('id_alumni_fk', $id_alumni);
      $query = $this->db->get();
      return $query;
    }

    public function tampil_karir_by_id($offset, $limit, $id_alumni)
    {
      # code...
      $this->db->select('*');
      $this->db->from('karir');
      $this->db->where('id_alumni_fk', $id_alumni);
      $this->db->limit('$limit', '$offset');
      $this->db->order_by('id_karir', 'desc');
      $query = $this->db->get();
      return $query;
    }

    public function hapus_karir_by_id($id)
    {
      # code...
      //hapus gambar karir
      $this->load->helper("file");
      $query_get_image = $this->db->get_where('karir', array('id_karir'=> $id));
      foreach($query_get_image->result() as $row){
        $fileGambar = $row->gambar;
      }
      unlink('assets/img/karier/'.$fileGambar);

      //hapus data karir
      $this->db->where('id_karir', $id);
      $this->db->delete('karir');
    }

    public function update_karir($id)
    {
      # code...
      $userfile = $_FILES['upGambar']['name'];

      if(!empty($userfile)){
        //konfiguras library->upload, set tipe data dan path tempat upload
        $konfigurasi['upload_path'] = './assets/img/karier/';
        $konfigurasi['allowed_types'] = 'jpg|jpeg|png';
        $konfigurasi['remove_spaces'] = FALSE;
        $konfigurasi['max_size'] = 8024;
        $konfigurasi['max_width'] = 8000;
        $konfigurasi['max_height'] = 8000;
        $this->upload->initialize($konfigurasi);
        $this->upload->do_upload('upGambar');


        $id_alumni_fk = $this->input->post('idAlumni');
        $namaPerusahaan = $this->input->post('namaPerusahaan');
        $posisi = $this->input->post('posisi');
        $kriteria = $this->input->post('kriteria');
        $batasWaktu = $this->input->post('batasWaktu');
        // $batasWaktu = date('Y-m-d');
        $kontak = $this->input->post('kontak');
        $gambar = $_FILES['upGambar']['name'];

        $data = array(
          'id_alumni_fk'=>$id_alumni_fk,
          'namaPerusahaan'=>$namaPerusahaan,
          'posisi'=>$posisi,
          'kriteria'=>$kriteria,
          'batasWaktu'=>$batasWaktu,
          'kontak'=>$kontak,
          'gambar'=>$gambar
        );
        $this->db->where('id_karir', $id);
        $this->db->update('karir', $data);
      }else{
        $id_alumni_fk = $this->input->post('idAlumni');
        $namaPerusahaan = $this->input->post('namaPerusahaan');
        $posisi = $this->input->post('posisi');
        $kriteria = $this->input->post('kriteria');
        $batasWaktu = $this->input->post('batasWaktu');
        $kontak = $this->input->post('kontak');

        $data = array(
          'id_alumni_fk'=>$id_alumni_fk,
          'namaPerusahaan'=>$namaPerusahaan,
          'posisi'=>$posisi,
          'kriteria'=>$kriteria,
          'batasWaktu'=>$batasWaktu,
          'kontak'=>$kontak
      );

        $this->db->where('id_karir', $id);
        $this->db->update('karir', $data);
      }
    }
  }

?>
