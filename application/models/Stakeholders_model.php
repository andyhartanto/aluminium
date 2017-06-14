<?php
  /**
   *
   */
  class Stakeholders_model extends CI_Model
  {

    function __construct()
    {
      # code...
      parent::__construct();
    }

    public function ambil_stakeholders_semua()
    {
      # code...
      $this->db->select('*');
      $this->db->from('tracer_study_stakeholders');
      $this->db->order_by('tanggalIsi','desc');
      $query = $this->db->get();
      return $query;
    }

    public function tampil_data_stakeholders($offset, $limit)
    {
      # code...
      $query = $this->db->query("SELECT * FROM tracer_study_stakeholders ORDER BY id_tss DESC LIMIT $offset, $limit");
      return $query;
    }

    public function ambil_data_tss_per_id($id_tss)
    {
      # code...
      $this->db->select("*");
      $this->db->from("tracer_study_stakeholders");
      $this->db->where("id_tss", $id_tss);
      $query = $this->db->get();
      $result = $query->row();
      return $result;
    }
  }

?>
