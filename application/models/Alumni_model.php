<?php
  class Alumni_model extends CI_Model{
    function __construct(){
      parent::__construct();
    }
    function ambil_nama_poster_perid($id)
    {
      # code...
      $this->db->select('nama');
      $this->db->from('alumni');
      $this->db->where('id_alumni', $id);
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }
    function ambil_data_admin()
    {
      # code...
      $this->db->select('*');
      $this->db->from('alumni');
      $this->db->where('status', 'admin');
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    function ambil_data_tempat_kerja($id){
      $this->db->select('*');
      $this->db->from('kerja');
      $this->db->where('id_alumni_fk',$id);
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    function data_alumni_semua(){
      $this->db->select('*');
      $this->db->from('alumni');
      $this->db->order_by('id_alumni', 'desc');
      $query = $this->db->get();
      return $query;
    }

    function simpan_data_alumni(){
      //variabel inputan form
      $username = $this->input->post('username');
      $password = $this->input->post('password');
      $enkripsiPassword = md5($password);
      $namaLengkap = $this->input->post('namaLengkap');
      $jenisKelamin = $this->input->post('jenisKelamin');
      $alamatAsal = $this->input->post('alamatAsal');
      $email = $this->input->post('email');
      $facebook = $this->input->post('facebook');
      $twitter = $this->input->post('twitter');
      $instagram = $this->input->post('instagram');
      $tanggalLahir = date('Y-m-d', strtotime($this->input->post('tanggalLahir')));
      //proses insert data alumni
      $data = array('username' => $username, 'password' => $enkripsiPassword, 'nama' => $namaLengkap, 'jenisKelamin' => $jenisKelamin, 'alamat_asal' => $alamatAsal, 'email' => $email, 'facebook' => $facebook, 'twitter' => $twitter, 'instagram' => $instagram, 'tanggalLahir' => $tanggalLahir, 'status' => 'alumni');
      $this->db->insert('alumni', $data);
    }

    function simpan_data_tempat_bekerja(){
      $id_alumni = $this->session->userdata('id_alumni');
      $namaInstansi = $this->input->post('nama_instansi');
      $kotaBekerja = $this->input->post('kota_kerja');
      $tahunMasuk = $this->input->post('tahun_masuk');
      $latitude = $this->input->post('latitude');
      $longitude = $this->input->post('longitude');
      $data = array( 'nama_instansi' => $namaInstansi ,'id_alumni_fk' => $id_alumni , 'kota_kerja' => $kotaBekerja, 'tahun_masuk' => $tahunMasuk, 'latitude' => $latitude, 'longitude' => $longitude);
      $this->db->insert('kerja', $data);
    }

    function tampil_data_alumni($offset, $limit){
      $query = $this->db->query("SELECT * FROM alumni ORDER BY id_alumni DESC LIMIT $offset, $limit");
      return $query;
    }

    function get_data_edit_alumni($id_alumni){
      $this->db->select('*');
      $this->db->from('alumni');
      $this->db->where('id_alumni', $id_alumni);
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    function ambil_data_alumni_per_id($id){
      //row
      $this->db->select('*');
      $this->db->from('alumni');
      $this->db->where('id_alumni', $id);
      $query = $this->db->get();
      $result = $query->row();
      return $result;
    }

    function ambil_data_alumni_per_id2($id){
      //result
      $this->db->select('*');
      $this->db->from('alumni');
      $this->db->where('id_alumni', $id);
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    function tampil_nama($nama)
    {
      # code...
      $this->db->select('nama');
      $this->db->from('alumni');
      $this->db->where('nama', $nama);
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    function tampil_email($email)
    {
      # code...
      $this->db->select('email');
      $this->db->from('alumni');
      $this->db->where('email', $email);
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    function tampil_fb($fb)
    {
      # code...
      $this->db->select('facebook');
      $this->db->from('alumni');
      $this->db->where('facebook', $fb);
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    function tampil_twitter($twitter)
    {
      # code...
      $this->db->select('twitter');
      $this->db->from('alumni');
      $this->db->where('twitter', $twitter);
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    function tampil_instagram($instagram)
    {
      # code...
      $this->db->select('instagram');
      $this->db->from('alumni');
      $this->db->where('instagram', $instagram);
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    function update_data_alumni($id_alumni){
      //variabel update data alumni form
      // $username = $this->input->post('username');
      $password = $this->input->post('password');
      $enkripsiPassword = md5($password);
      $namaLengkap = $this->input->post('namaLengkap');
      $alamatAsal = $this->input->post('alamatAsal');
      $jenisKelamin = $this->input->post('jenisKelamin');
      $email = $this->input->post('email');
      $facebook = $this->input->post('facebook');
      $twitter = $this->input->post('twitter');
      $instagram = $this->input->post('instagram');
      $tanggalLahir = date('Y-m-d', strtotime($this->input->post('tanggalLahir')));
      //, $this->input->post('tanggalLahir')

      $data = array('password' => $enkripsiPassword, 'nama' => $namaLengkap, 'jenisKelamin' => $jenisKelamin, 'alamat_asal' => $alamatAsal, 'jenisKelamin' => $jenisKelamin, 'email' => $email, 'facebook' => $facebook, 'twitter' => $twitter, 'instagram' => $instagram, 'tanggalLahir' => $tanggalLahir, 'status' => 'alumni');
      $this->db->where('id_alumni', $id_alumni);
      $this->db->update('alumni', $data);
    }

    function update_profile_admin($username)
    {
      # code...
      $username = $this->input->post('username');
      $password = $this->input->post('password');
      $enkripPass = md5($password);
      $data = array('username' => $username, 'password' => $enkripPass);
      $this->db->where('username', $username);
      $this->db->update('alumni', $data);
    }

    function update_data_tempat_bekerja($id_alumni){
      $id_alumni = $this->session->userdata('id_alumni');
      $namaInstansi = $this->input->post('nama_instansi');
      $kotaBekerja = $this->input->post('kota_kerja');
      $tahunMasuk = $this->input->post('tahun_masuk');
      $latitude = $this->input->post('latitude');
      $longitude = $this->input->post('longitude');

      $data = array( 'nama_instansi' => $namaInstansi ,'id_alumni_fk' => $id_alumni , 'kota_kerja' => $kotaBekerja, 'tahun_masuk' => $tahunMasuk, 'latitude' => $latitude, 'longitude' => $longitude);
      $this->db->where('id_alumni_fk', $id_alumni);
      $this->db->update('kerja', $data);
    }
    function hapus_data_alumni($id_alumni){
      $this->db->where('id_alumni', $id_alumni);
      $this->db->delete('alumni');
    }
    function hapus_data_tempat_kerja_perId($id)
    {
      # code...
      $this->db->where('id_alumni_fk', $id);
      $this->db->delete('kerja');
    }
  }
?>
