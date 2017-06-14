<?php
  class TracerStudy_model extends CI_Model{
    public function __construct(){
      parent::__construct();
    }

    public function get_data_ts($id){
        $this->db->select("id_tracer_study");
        $this->db->from("tracer_study");
        $this->db->where("id_alumni_fk", $id);
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    public function ambil_id_alumni_fk($id){
        $this->db->select("id_alumni_fk");
        $this->db->from("tracer_study");
        $this->db->where("id_tracer_study", $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function ambilDataTSAll()
    {
      # code...
      $query =  $this->db->select("*")
                          ->from("tracer_study")
                          ->join("alumni", "alumni.id_alumni = tracer_study.id_alumni_fk")
                          ->order_by('waktu_isi', 'desc')
                          ->get();
      return $query;
    }

    public function ambilIdAlumni($id)
    {
      # code...
      $this->db->select("id_alumni_fk");
      $this->db->from("tracer_study");
      $this->db->where("id_tracer_study", $id);
      $query = $this->db->get();
      $result = $query->row();
      return $result;
    }

    public function ambil_status_ts($id_alumni){
      $this->db->select("status");
      $this->db->from("tracer_study");
      $this->db->where("id_alumni_fk", $id_alumni);
      $query = $this->db->get();
      $result = $query->row();
      return $result;
    }

    public function ambil_nilai_f3($id_alumni){
      $this->db->select("f3");
      $this->db->from("tracer_study");
      $this->db->where("id_alumni_fk", $id_alumni);
      $query = $this->db->get();
      $result = $query->row();
      return $result;
    }

    public function ambil_data($id_alumni){
      $this->db->select("*");
      $this->db->from("tracer_study");
      $this->db->where("id_alumni_fk", $id_alumni);
      $query = $this->db->get();
      $result = $query->row();
      return $result;
    }

    public function simpan_data_ts($data){
      $this->db->insert("tracer_study", $data);
    }

    public function update_data_ts($data){
      $this->db->where('id_alumni_fk', $data['id_alumni_fk'] );
      $this->db->update('tracer_study', $data);
    }

    public function ambil_id_ts($id_alumni){
      $this->db->select("*");
      $this->db->from("tracer_study");
      $this->db->where("id_alumni_fk", $id_alumni);
      $query = $this->db->get();
      $result = $query->row();
      return $result;
    }

    public function tampilDataTS($idTS)
    {
      # code...
      $this->db->select("*");
      $this->db->from("tracer_study");
      $this->db->where("id_tracer_study", $idTS);
      $query = $this->db->get();
      $result = $query->row();
      return $result;
    }

    public function tampilDataTSSDM($idTS)
    {
      # code...
      $this->db->select("*");
      $this->db->from("tracer_study_sdma");
      $this->db->where("fk_id_ts", $idTS);
      $query = $this->db->get();
      $result = $query->row();
      return $result;
    }

    public function tampilDataTSP($idTS)
    {
      # code...
      $this->db->select("*");
      $this->db->from("tracer_study_sdmp");
      $this->db->where("fk_id_ts", $idTS);
      $query = $this->db->get();
      $result = $query->row();
      return $result;
    }

    public function cek_id_ts($id){
        $this->db->select("*");
        $this->db->from("tracer_study_sdma");
        $this->db->where("fk_id_ts", $id);
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    public function simpan_data_ts_sdma($data){
      $this->db->insert('tracer_study_sdma', $data);
    }

    public function update_data_ts_sdma($data){
      $this->db->where('fk_id_ts', $data['fk_id_ts']);
      $this->db->update('tracer_study_sdma', $data);
    }

    public function ambil_dataf171($id){
      $this->db->select("*");
      $this->db->from("tracer_study_sdma");
      $this->db->where("fk_id_ts", $id);
      $query = $this->db->get();
      $result = $query->row();
      return $result;
    }

    public function simpan_data_ts_sdmp($data){
      $this->db->insert('tracer_study_sdmp', $data);
    }

    public function update_data_ts_sdmp($data){
      $this->db->where('fk_id_ts', $data['fk_id_ts']);
      $this->db->update('tracer_study_sdmp', $data);
    }

    public function ambil_dataf172($id){
      $this->db->select("*");
      $this->db->from("tracer_study_sdmp");
      $this->db->where("fk_id_ts", $id);
      $query = $this->db->get();
      $result = $query->row();
      return $result;
    }

    public function cek_id_ts_prodi($id){
        $this->db->select("*");
        $this->db->from("tracer_study_sdmp");
        $this->db->where("fk_id_ts", $id);
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    public function simpan_data_ts_prodi($data){
      $this->db->insert('tracer_study_sdmp', $data);
    }

    public function update_data_ts_prodi($data){
      $this->db->where('fk_id_ts', $data['fk_id_ts']);
      $this->db->update('tracer_study_sdmp',$data);
    }

    public function ambil_jenis_kelamin_laki(){
      // $this->db->select('jenisKelamin')->from('alumni')->where('jenisKelamin',1);
      // $query = $this->db->get();
      // return $query->num_rows();
      $this->db->where("jenisKelamin",1);
      return $this->db->count_all_results("alumni");
    }

    public function ambil_jenis_kelamin_perempuan(){
      // $this->db->select('jenisKelamin')->from('alumni')->where('jenisKelamin',$perempuan);
      // $query = $this->db->get();
      // return $query->num_rows();
      $this->db->where("jenisKelamin",2);
      return $this->db->count_all_results("alumni");
    }

    public function simpan_data_tss($data){
      $this->db->insert('tracer_study_stakeholders', $data);
    }

    public function ambilDataLamaWaktuTunggu(){
      // $query = $this->db->query("SELECT f5, count(*) from tracer_study as num GROUP BY f5 ");
      $this->db->select("f5 as 'bulan', count(id_tracer_study) as 'jumlah'");
      $this->db->from('tracer_study');
      $this->db->where('f5>', '0' );
      $this->db->group_by('f5');
      $result = $this->db->get()->result();
      return $result;

      // $hasil = array();
      // foreach ($variable as $key => $value) {
      //   # code...
      // }
    }

    public function ambilDataBekerja(){
      // "SELECT f8, count(*) from tracer_study as pilihanF8 GROUP BY f8 "
      $this->db->select("f8, count(id_tracer_study) as'pilihanF8'");
      $this->db->from('tracer_study');
      $this->db->group_by('f8');
      $result = $this->db->get()->result();
      return $result;
    }

    public function ambilDataSudahBekerja()
    {
      # code...
      $this->db->where("f8",1);
      return $this->db->count_all_results("tracer_study");
    }

    public function ambilDataBelumBekerja()
    {
      # code...
      $this->db->where("f8",2);
      return $this->db->count_all_results("tracer_study");
    }

    public function ambilDataf14SangatErat()
    {
      # code...
      $this->db->where("f14",1);
      return $this->db->count_all_results("tracer_study");
    }

    public function ambilDataf14Erat()
    {
      # code...
      $this->db->where("f14",2);
      return $this->db->count_all_results("tracer_study");
    }

    public function ambilDataf14CukupErat()
    {
      # code...
      $this->db->where("f14",3);
      return $this->db->count_all_results("tracer_study");
    }

    public function ambilDataf14KurangErat()
    {
      # code...
      $this->db->where("f14",4);
      return $this->db->count_all_results("tracer_study");
    }

    public function ambilDataf14TidakSamaSekali()
    {
      # code...
      $this->db->where("f14",5);
      return $this->db->count_all_results("tracer_study");
    }

    public function ambilDataKepuasanTingkatPendidikan(){
      // "SELECT f16, count(*) from tracer_study as pilihanF16 GROUP BY f16 "
      $this->db->select("f16, count(id_tracer_study) as'pilihanF16'");
      $this->db->from('tracer_study');
      $this->db->group_by('f16');
      $result = $this->db->get()->result();
      return $result;
    }

    public function ambilDataPendapatan(){
      // "SELECT f13, count(*) from tracer_study as pilihanF13 GROUP BY f13 "
      $this->db->select("f13, count(id_tracer_study) as'pilihanF13'");
      $this->db->from('tracer_study');
      $this->db->group_by('f13');
      $result = $this->db->get()->result();
      return $result;
    }

    public function ambilDataPendapatan02()
    {
      # code...
      $this->db->where("f13",1);
      return $this->db->count_all_results("tracer_study");
    }

    public function ambilDataPendapatan23()
    {
      # code...
      $this->db->where("f13",2);
      return $this->db->count_all_results("tracer_study");
    }

    public function ambilDataPendapatan34()
    {
      # code...
      $this->db->where("f13",3);
      return $this->db->count_all_results("tracer_study");
    }

    public function ambilDataPendapatan4()
    {
      # code...
      $this->db->where("f13",4);
      return $this->db->count_all_results("tracer_study");
    }

    public function ambilDataF5b0(){
      $this->db->select("f5, count(id_tracer_study) as 'b0'");
      $this->db->from('tracer_study');
      $this->db->where('f5', 0);
      $this->db->group_by('f5');
      $result = $this->db->get()->result();
      return $result;
    }

  }
?>
