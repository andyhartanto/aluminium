<?php
class TracerStudyTesAjax extends CI_Controller{
  public function __construct(){
    parent::__construct();
    $this->load->model('TracerStudy_model');
    if($this->session->userdata('username'==null)){
      redirect('Home/login');
    }
  }

  public function index(){
    $data['username'] = $this->session->userdata('username');
    if($data['username']!=null){
      $data['id_alumni'] = $this->session->userdata('id_alumni');
      $data['nama'] = $this->session->userdata('nama');
      $data['alumni_sudah_isi'] = $this->TracerStudy_model->get_data_ts($data['id_alumni']);

      // ambil nilai status
      $status['row'] = $this->TracerStudy_model->ambil_status_ts($data['id_alumni']);
      if($status['row'] == null){
        // $st = 0;
        $data['status_ts'] = 0;
      }else{
        $st = $status['row']->status;
        $data['status_ts'] = $st;
      }

      $row['row'] = $this->TracerStudy_model->ambil_data($data['id_alumni']);
      // jika belum isi, set data tampilan 0
      if($row['row'] == null){
        $data['f3'] = 0;
      }
      // jika sudah ada data set tampilan data
      else{
        $data['f3'] = $row['row']->f3;
      }

      $this->load->view('vTesAjax.html',$data);
    }
    //username sesuai
  }
  //index

  public function masuk_data_ts(){

    $f3 = $this->input->post('f3');
    // $f4 = $this->input->post('f4');
    // $f5 = $this->input->post('f5');
    // $f6 = $this->input->post('f6');
    // $f7 = $this->input->post('f7');
    // $f7a = $this->input->post('f7a');
    // $f8 = $this->input->post('f8');
    // $f9 = $this->input->post('f9');
    // $f10 = $this->input->post('f10');
    // $f11 = $this->input->post('f11');
    // $f12 = $this->input->post('f12');
    // $f13 = $this->input->post('f13');
    // $f14 = $this->input->post('f14');
    // $f15 = $this->input->post('f15');
    // $f16 = $this->input->post('f16');
    $proses = $this->input->post('proses');
    var_dump($f3);
    if($proses == 1){
      $id_alumni = $this->session->userdata('id_alumni');
      $udah = $this->TracerStudy_model->get_data_ts($id_alumni);
      if($udah = 1 ){
        $data = array(
          'id_alumni_fk' => $this->session->userdata('id_alumni'),
          'f3' => $f3
        );
        $proses = 0;
        $this->TracerStudy_model->update_data_ts($data);
      }
      else{
        $data = array(
          'id_alumni_fk' => $this->session->userdata('id_alumni'),
          'f3' => $f3,
          'status' => $proses
        );
        $proses = 0;
        $this->TracerStudy_model->simpan_data_ts($data);
      }
    }
    elseif ($proses == 2) {
      $data = array(
        'id_alumni_fk' => $this->session->userdata('id_alumni'),
        'f4' => $f4,
        'f5' => $f5,
        'f6' => $f6,
        'f7' => $f7,
        'f7a' => $f7a,
        'status' => $proses
      );
      $proses = 0;
      $this->TracerStudy_model->update_data_ts($data);
    }
    elseif ($proses == 3) {
      $data = array(
        'id_alumni_fk' => $this->session->userdata('id_alumni'),
        'f8' => $f8,
        'status' => $proses
      );
      $proses = 0;
      $this->TracerStudy_model->update_data_ts($data);
    }
    elseif ($proses == 4) {
      $data = array(
        'id_alumni_fk' => $this->session->userdata('id_alumni'),
        'f11' => $f11,
        'f12' => $f12,
        'f13' => $f13,
        'f14' => $f14,
        'f15' => $f15,
        'f16' => $f16,
        'status' => $proses
      );
      $proses = 0;
      $this->TracerStudy_model->update_data_ts($data);
    }
    elseif ($proses == 5) {
      $data = array(
        'id_alumni_fk' => $this->session->userdata('id_alumni'),
        'f9' => $f9,
        'f10' => $f10,
        'status' => $proses
      );
      $proses = 0;
      $this->TracerStudy_model->update_data_ts($data);
    }
  }

  public function masuk_data_ts_tes_ajax(){
    $f3 = $this->input->post('f3');
    $proses = $this->input->post('proses');
    if($proses == 1){
      $id_alumni = 7;
      $udah = $this->TracerStudy_model->get_data_ts($id_alumni);
      if($udah = 1 ){
        $data = array(
          'id_alumni_fk' => $id_alumni,
          'f3' => $f3
        );
        $proses = 0;
        $this->TracerStudy_model->update_data_ts($data);
      }
      else{
        $data = array(
          'id_alumni_fk' => $id_alumni,
          'f3' => $f3,
          'status' => $proses
        );
        $proses = 0;
        $this->TracerStudy_model->simpan_data_ts($data);
      }
    }
  }

  public function masuk_data_ts_sdm(){
    //tempat variable input post f17a
    $f17a1 = $this->input->post('f17a1');
    $f17a2 = $this->input->post('f17a2');
    $f17a3 = $this->input->post('f17a3');
    $f17a4 = $this->input->post('f17a4');
    $f17a5 = $this->input->post('f17a5');
    $f17a6 = $this->input->post('f17a6');
    $f17a7 = $this->input->post('f17a7');
    $f17a8 = $this->input->post('f17a8');
    $f17a9 = $this->input->post('f17a9');
    $f17a10 = $this->input->post('f17a10');
    $f17a11 = $this->input->post('f17a11');
    $f17a12 = $this->input->post('f17a12');
    $f17a13 = $this->input->post('f17a13');
    $f17a14 = $this->input->post('f17a14');
    $f17a15 = $this->input->post('f17a15');
    $f17a16 = $this->input->post('f17a16');
    $f17a17 = $this->input->post('f17a17');
    $f17a18 = $this->input->post('f17a18');
    $f17a19 = $this->input->post('f17a19');
    $f17a20 = $this->input->post('f17a20');
    $f17a21 = $this->input->post('f17a21');
    $f17a22 = $this->input->post('f17a22');
    $f17a23 = $this->input->post('f17a23');
    $f17a24 = $this->input->post('f17a24');
    $f17a25 = $this->input->post('f17a25');
    $f17a26 = $this->input->post('f17a26');
    $f17a27 = $this->input->post('f17a27');
    $f17a28 = $this->input->post('f17a28');
    $f17a29 = $this->input->post('f17a29');

    //tempat variable input post f17b
    $f17b1 = $this->input->post('f17b1');
    $f17b2 = $this->input->post('f17b2');
    $f17b3 = $this->input->post('f17b3');
    $f17b4 = $this->input->post('f17b4');
    $f17b5 = $this->input->post('f17b5');
    $f17b6 = $this->input->post('f17b6');
    $f17b7 = $this->input->post('f17b7');
    $f17b8 = $this->input->post('f17b8');
    $f17b9 = $this->input->post('f17b9');
    $f17b10 = $this->input->post('f17b10');
    $f17b11 = $this->input->post('f17b11');
    $f17b12 = $this->input->post('f17b12');
    $f17b13 = $this->input->post('f17b13');
    $f17b14 = $this->input->post('f17b14');
    $f17b15 = $this->input->post('f17b15');
    $f17b16 = $this->input->post('f17b16');
    $f17b17 = $this->input->post('f17b17');
    $f17b18 = $this->input->post('f17b18');
    $f17b19 = $this->input->post('f17b19');
    $f17b20 = $this->input->post('f17b20');
    $f17b21 = $this->input->post('f17b21');
    $f17b22 = $this->input->post('f17b22');
    $f17b23 = $this->input->post('f17b23');
    $f17b24 = $this->input->post('f17b24');
    $f17b25 = $this->input->post('f17b25');
    $f17b26 = $this->input->post('f17b26');
    $f17b27 = $this->input->post('f17b27');
    $f17b28 = $this->input->post('f17b28');
    $f17b29 = $this->input->post('f17b29');

    //proses fieldset yang akan dijalankan
    $proses = $this->input->post('proses');

    // cek proses
    if($proses == 61){
      $id_alumni = $this->session->userdata('id_alumni');
      $id_ts['row'] = $this->TracerStudy_model->ambil_id_ts($id_alumni);
      $id = $id_ts['row']->id_tracer_study;
      $id_ts_sdm = $this->TracerStudy_model->cek_id_ts($id);
      if($id_ts_sdm>=1){
        $data = array(
          'fk_id_ts' => $id,
          'f171' => $f17a1,
          'f172' => $f17a2,
          'f173' => $f17a3,
          'f174' => $f17a4,
          'f175' => $f17a5,
          'f176' => $f17a6,
          'f177' => $f17a7,
          'f178' => $f17a8,
          'f179' => $f17a9,
          'f1710' => $f17a10,
          'f1711' => $f17a11,
          'f1712' => $f17a12,
          'f1713' => $f17a13,
          'f1714' => $f17a14,
          'f1715' => $f17a15
        );
        $this->TracerStudy_model->update_data_ts_sdma($data);
        $data2 = array(
          'id_alumni_fk' => $this->session->userdata('id_alumni'),
          'status' => $proses
        );
        $this->TracerStudy_model->update_data_ts($data2);
        $proses = 0;
      }else{
        $data = array(
          'fk_id_ts' => $id,
          'f171' => $f17a1,
          'f172' => $f17a2,
          'f173' => $f17a3,
          'f174' => $f17a4,
          'f175' => $f17a5,
          'f176' => $f17a6,
          'f177' => $f17a7,
          'f178' => $f17a8,
          'f179' => $f17a9,
          'f1710' => $f17a10,
          'f1711' => $f17a11,
          'f1712' => $f17a12,
          'f1713' => $f17a13,
          'f1714' => $f17a14,
          'f1715' => $f17a15
        );
        $this->TracerStudy_model->simpan_data_ts_sdma($data);
        $data2 = array(
          'id_alumni_fk' => $this->session->userdata('id_alumni'),
          'status' => $proses
        );
        $this->TracerStudy_model->update_data_ts($data2);
        $proses = 0;
      }
    }elseif ($proses == 62){
      $id_alumni = $this->session->userdata('id_alumni');
      $id_ts['row'] = $this->TracerStudy_model->ambil_id_ts($id_alumni);
      $id = $id_ts['row']->id_tracer_study;
      $id_ts_sdm = $this->TracerStudy_model->cek_id_ts($id);
      if($id_ts_sdm>=1){
        $data = array(
          'fk_id_ts' => $id,
          'f1716' => $f17a16,
          'f1717' => $f17a17,
          'f1718' => $f17a18,
          'f1719' => $f17a19,
          'f1720' => $f17a20,
          'f1721' => $f17a21,
          'f1722' => $f17a22,
          'f1723' => $f17a23,
          'f1724' => $f17a24,
          'f1725' => $f17a25,
          'f1726' => $f17a26,
          'f1727' => $f17a27,
          'f1728' => $f17a28,
          'f1729' => $f17a29
        );
        $this->TracerStudy_model->update_data_ts_sdma($data);
        $data2 = array(
          'id_alumni_fk' => $this->session->userdata('id_alumni'),
          'status' => $proses
        );
        $this->TracerStudy_model->update_data_ts($data2);
        $proses = 0;
      }else{
        $data = array(
          'fk_id_ts' => $id,
          'f171' => $f17a1,
          'f172' => $f17a2,
          'f173' => $f17a3,
          'f174' => $f17a4,
          'f175' => $f17a5,
          'f176' => $f17a6,
          'f177' => $f17a7,
          'f178' => $f17a8,
          'f179' => $f17a9,
          'f1710' => $f17a10,
          'f1711' => $f17a11,
          'f1712' => $f17a12,
          'f1713' => $f17a13,
          'f1714' => $f17a14,
          'f1715' => $f17a15
        );
        $this->TracerStudy_model->simpan_data_ts_sdma($data);
        $data2 = array(
          'id_alumni_fk' => $this->session->userdata('id_alumni'),
          'status' => $proses
        );
        $this->TracerStudy_model->update_data_ts($data2);
        $proses = 0;
      }
    }elseif($proses == 71){
      $id_alumni = $this->session->userdata('id_alumni');
      $id_ts['row'] = $this->TracerStudy_model->ambil_id_ts($id_alumni);
      $id = $id_ts['row']->id_tracer_study;
      $id_ts_sdm = $this->TracerStudy_model->cek_id_ts_prodi($id);
      if($id_ts_sdm>=1){
        $data = array(
          'fk_id_ts' => $id,
          'f171' => $f17b1,
          'f172' => $f17b2,
          'f173' => $f17b3,
          'f174' => $f17b4,
          'f175' => $f17b5,
          'f176' => $f17b6,
          'f177' => $f17b7,
          'f178' => $f17b8,
          'f179' => $f17b9,
          'f1710' => $f17b10,
          'f1711' => $f17b11,
          'f1712' => $f17b12,
          'f1713' => $f17b13,
          'f1714' => $f17b14,
          'f1715' => $f17b15
        );
        $this->TracerStudy_model->update_data_ts_prodi($data);
        $data2 = array(
          'id_alumni_fk' => $this->session->userdata('id_alumni'),
          'status' => $proses
        );
        $this->TracerStudy_model->update_data_ts($data2);
        $proses = 0;
      }else{
        $data = array(
          'fk_id_ts' => $id,
          'f171' => $f17b1,
          'f172' => $f17b2,
          'f173' => $f17b3,
          'f174' => $f17b4,
          'f175' => $f17b5,
          'f176' => $f17b6,
          'f177' => $f17b7,
          'f178' => $f17b8,
          'f179' => $f17b9,
          'f1710' => $f17b10,
          'f1711' => $f17b11,
          'f1712' => $f17b12,
          'f1713' => $f17b13,
          'f1714' => $f17b14,
          'f1715' => $f17b15
        );
        $this->TracerStudy_model->simpan_data_ts_prodi($data);
        $data2 = array(
          'id_alumni_fk' => $this->session->userdata('id_alumni'),
          'status' => $proses
        );
        $this->TracerStudy_model->update_data_ts($data2);
        $proses = 0;
      }
    }elseif ($proses == 8){
      $id_alumni = $this->session->userdata('id_alumni');
      $id_ts['row'] = $this->TracerStudy_model->ambil_id_ts($id_alumni);
      $id = $id_ts['row']->id_tracer_study;
      $id_ts_sdm = $this->TracerStudy_model->cek_id_ts_prodi($id);
      if($id_ts_sdm>=1){
        $data = array(
          'fk_id_ts' => $id,
          'f1716' => $f17b16,
          'f1717' => $f17b17,
          'f1718' => $f17b18,
          'f1719' => $f17b19,
          'f1720' => $f17b20,
          'f1721' => $f17b21,
          'f1722' => $f17b22,
          'f1723' => $f17b23,
          'f1724' => $f17b24,
          'f1725' => $f17b25,
          'f1726' => $f17b26,
          'f1727' => $f17b27,
          'f1728' => $f17b28,
          'f1729' => $f17b29
        );
        $this->TracerStudy_model->update_data_ts_prodi($data);
        $data2 = array(
          'id_alumni_fk' => $this->session->userdata('id_alumni'),
          'status' => $proses
        );
        $this->TracerStudy_model->update_data_ts($data2);
        $proses = 0;
      }else{
        $data = array(
          'fk_id_ts' => $id,
          'f1716' => $f17b16,
          'f1717' => $f17b17,
          'f1718' => $f17b18,
          'f1719' => $f17b19,
          'f1720' => $f17b20,
          'f1721' => $f17b21,
          'f1722' => $f17b22,
          'f1723' => $f17b23,
          'f1724' => $f17b24,
          'f1725' => $f17b25,
          'f1726' => $f17b26,
          'f1727' => $f17b27,
          'f1728' => $f17b28,
          'f1729' => $f17b29
        );

        $this->TracerStudy_model->simpan_data_ts_prodi($data);
        $data2 = array(
          'id_alumni_fk' => $this->session->userdata('id_alumni'),
          'status' => $proses
        );
        $this->TracerStudy_model->update_data_ts($data2);
        $proses = 0;
      }//simpan72
    }//porses72
  }//masuk_data_ts

  public function ambil_f3(){
    $id_alumni = $this->session->userdata('id_alumni');
    $d['row'] = $this->TracerStudy_model->ambil_nilai_f3($id_alumni);
    $dataF3 = $d['row']->f3;
    return $dataF3;
  }

  public function tampil_data_ts(){


  }

  public function masuk_data_tss(){
    $this->form_validation->set_rules('nama', 'Nama', 'required');
    $this->form_validation->set_rules('perusahaan', 'Perusahaan', 'required');
    $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
    $this->form_validation->set_rules('namaAlumni', 'Nama Alumni', 'required');
    $this->form_validation->set_rules('p1', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p2', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p3', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p4', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p5', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p6', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p7', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p8', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p9', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p10', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p11', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p12', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p13', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p14', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p15', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p16', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p17', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p18', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p19', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p20', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p21', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p22', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p23', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p24', 'form pertanyaan ini', 'required');
    $this->form_validation->set_rules('p25', 'form pertanyaan ini', 'required');

    if($this->form_validation->run() == FALSE){
      $this->load->view('vTracerStudyStakeholders.html');
      echo "<script language=\"javascript\">
          alert('Maaf, terdapat beberapa data yang belum diisi, mohon untuk Anda dapat mengisi semua form data diri, serta menjawab daftar pertanyaan yang ada dengan baik dan benar. Terimakasih banyak atas bantuannya.');
      </script>";
    }else{
      $nama = $this->input->post('nama');
      $perusahaan = $this->input->post('perusahaan');
      $jabatan = $this->input->post('jabatan');
      $namaAlumni = $this->input->post('namaAlumni');
      $p1 = $this->input->post('p1');
      $p2 = $this->input->post('p2');
      $p3 = $this->input->post('p3');
      $p4 = $this->input->post('p4');
      $p5 = $this->input->post('p5');
      $p6 = $this->input->post('p6');
      $p7 = $this->input->post('p7');
      $p8 = $this->input->post('p8');
      $p9 = $this->input->post('p9');
      $p10 = $this->input->post('p10');
      $p11 = $this->input->post('p11');
      $p12 = $this->input->post('p12');
      $p13 = $this->input->post('p13');
      $p14 = $this->input->post('p14');
      $p15 = $this->input->post('p15');
      $p16 = $this->input->post('p16');
      $p17 = $this->input->post('p17');
      $p18 = $this->input->post('p18');
      $p19 = $this->input->post('p19');
      $p20 = $this->input->post('p20');
      $p21 = $this->input->post('p21');
      $p22 = $this->input->post('p22');
      $p23 = $this->input->post('p23');
      $p24 = $this->input->post('p24');
      $p25 = $this->input->post('p25');

      $data = array(
        'nama' => $nama,
        'perusahaan' => $perusahaan,
        'jabatan' => $jabatan,
        'namaAlumni' => $namaAlumni,
        'tanggalIsi' => date('y-m-d'),
        'p1' => $p1,
        'p2' => $p2,
        'p3' => $p3,
        'p4' => $p4,
        'p5' => $p5,
        'p6' => $p6,
        'p7' => $p7,
        'p8' => $p8,
        'p9' => $p9,
        'p10' => $p10,
        'p11' => $p11,
        'p12' => $p12,
        'p13' => $p13,
        'p14' => $p14,
        'p15' => $p15,
        'p16' => $p16,
        'p17' => $p17,
        'p18' => $p18,
        'p19' => $p19,
        'p20' => $p20,
        'p21' => $p21,
        'p22' => $p22,
        'p23' => $p23,
        'p24' => $p24,
        'p25' => $p25
      );
      $this->TracerStudy_model->simpan_data_tss($data);
      echo "<script language=\"javascript\">
          alert('Terimakasih banyak Kami ucapkan, atas segala bantuan, dan kerjasama yang baik dari Anda dalam mengisi Form Tracer Study Stakeholders Kami. Sukses selalu untuk Anda sekalian.');
      </script>";
      $this->load->view('vHomeAluminium.html');
    }
  }

}
?>
