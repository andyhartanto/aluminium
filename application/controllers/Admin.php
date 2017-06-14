<?php
  Class Admin extends CI_Controller{
    public function __construct(){
      parent::__construct();
      if($this->session->userdata('username')==null){
        redirect('Home/login');
      }
      $this->load->model('Alumni_model');
      $this->load->model('Karir_model');
      $this->load->model('TracerStudy_model');
      $this->load->helper('text');
      $this->load->library('pdf');
    }

    public function index(){
      $data['username'] = $this->session->userdata('username');
      if($data['username'] != null){
        $data['hasilLaki'] = $this->TracerStudy_model->ambil_jenis_kelamin_laki();
        $data['hasilPerempuan'] = $this->TracerStudy_model->ambil_jenis_kelamin_perempuan();
        $this->load->view('vDashboardAdmin.html',$data);
      }
    }

    public function profilAdmin()
    {
      # code...
      $data['admin'] = $this->Alumni_model->ambil_data_admin();
      $this->load->view('vProfileAdmin.html', $data);
    }

    public function edit_profile_admin()
    {
      # code...
      $data['username'] = $this->session->userdata('username');
      $username = $this->uri->segment(3);
      $this->form_validation->set_rules('username', 'Username', 'required');
      $this->form_validation->set_rules('password', 'Password', 'required');
      if($data['username']== 'admin'){
        if($_POST != null){
          if($this->form_validation->run()==true){
            $this->Alumni_model->update_profile_admin($username);
            redirect('Admin/profilAdmin');
          }else{
            $data['data_edit_profile_admin'] = $this->Alumni_model->ambil_data_admin();
            $this->load->view('vEditProfileAdmin.html', $data);
          }
        }else{
          $data['data_edit_profile_admin'] = $this->Alumni_model->ambil_data_admin();
          $this->load->view('vEditProfileAdmin.html', $data);
        }
      }else{
        redirect('Home/login');
      }
    }

    public function alumni(){
      $data['username'] = $this->session->userdata('username');
      if($data['username'] != null){
        //pagination data alumni
        $page = $this->uri->segment(3);
        $limit = 10;
        if(!$page){
          $offset = 0;
        }else{
          $offset = $page;
        }
        $data = array();
        $total = $this->Alumni_model->data_alumni_semua();
        $config['base_url'] = base_url().'index.php/Admin/alumni';
        $config['total_rows'] = $total->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['first_link'] = 'Awal ';
        $config['last_link'] = ' Akhir';
        $config['next_link'] = '  Selanjutnya';
        $config['prev_link'] = 'Sebelumnya  ';
        $this->pagination->initialize($config);
        $data['paginator'] = $this->pagination->create_links();

        $data['hasil'] = $this->Alumni_model->tampil_data_alumni($offset, $limit);
        $data['page'] = $page;
        $this->load->view('vAlumniAdmin.html',$data);
      }
    }

    function tambah_alumni(){
      $this->form_validation->set_rules('username', 'Username', 'required');
      $this->form_validation->set_rules('password', 'Password', 'required');
      $this->form_validation->set_rules('namaLengkap', 'Nama Lengkap', 'required');
      $this->form_validation->set_rules('jenisKelamin', 'Jenis Kelamin', 'required');

      if($this->form_validation->run()==TRUE){
        if($this->input->post('simpan')){
          $this->Alumni_model->simpan_data_alumni();
          redirect('Admin/alumni');
        }
      }
      $this->load->view('vTambahAlumniAdmin.html');
    }

    function edit_data_alumni(){
      $id_alumni = $this->uri->segment(3);
      // if($_POST==NULL){
      //   $data['data_edit'] = $this->Alumni_model->get_data_edit_alumni($id_alumni);
      //   $this->load->view('vUpdateAlumniAdmin.html', $data);
      // }else{
      //   $this->form_validation->set_rules('username', 'Username', 'required');
      //   $this->form_validation->set_rules('password', 'Password', 'required');
      //   $this->form_validation->set_rules('namaLengkap', 'Nama Lengkap', 'required');
      //   $this->form_validation->set_rules('jenisKelamin', 'Jenis Kelamin', 'required');
      //
      //   if($this->input->post('simpan')){
      //     if($this->form_validation->run()==TRUE){
      //         $this->Alumni_model->update_data_alumni($id_alumni);
      //         redirect('Admin/alumni');
      //     }
      //     $data['data_edit'] = $this->Alumni_model->get_data_edit_alumni($id_alumni);
      //     $this->load->view('vUpdateAlumniAdmin.html', $data);
      //   }
      // }
      $this->form_validation->set_rules('username', 'Username', 'required');
      $this->form_validation->set_rules('password', 'Password', 'required');
      $this->form_validation->set_rules('namaLengkap', 'Nama Lengkap', 'required');
      $this->form_validation->set_rules('jenisKelamin', 'Jenis Kelamin', 'required');

      if($this->form_validation->run()==TRUE){
          $this->Alumni_model->update_data_alumni($id_alumni);
          redirect('Admin/alumni');
        // $data['data_edit'] = $this->Alumni_model->get_data_edit_alumni($id_alumni);
        // $this->load->view('vUpdateAlumniAdmin.html', $data);
      }else{
        $data['data_edit'] = $this->Alumni_model->get_data_edit_alumni($id_alumni);
        $this->load->view('vUpdateAlumniAdmin.html', $data);
      }
    }

    function delete_data_alumni(){
      $id_alumni = $this->uri->segment(3);
      $this->Alumni_model->hapus_data_alumni($id_alumni);
      $this->Alumni_model->hapus_data_tempat_kerja_perId($id_alumni);
      redirect('Admin/alumni');
    }

    function KelolaKarir(){
      $username = $this->session->userdata('username');
      if($username  != null){
        $page = $this->uri->segment(3);
        $limit = 10;
        // if(!$page){
        //   $offset = 0;
        // }else{
        //   $offset = $page;
        // }
        if(!$page):$offset = 0;
        else:$offset = $page;
        endif;
        $data = array();
        // $total = $this->Karir_model->karir_semua();
        // $config ['total_rows'] = $total->num_rows();
        $config['total_rows'] = $this->db->get('karir')->num_rows();
        // ambil jumlah data karir
        // $config['total_rows'] = $this->db->get('karir')->num_rows();
        //set data karir yang ditampilkan
        $config['base_url'] = base_url().'index.php/Admin/KelolaKarir/';
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
        $data['seluruhKarir'] = $this->Karir_model->tampil_karir($offset, $limit);
        $data['page'] = $page;
        $data['nama'] = $this->session->userdata('nama');

        $dataIdAlumniFk = $this->Karir_model->ambil_id_alumni_fk();
        foreach($dataIdAlumniFk as $row){
          $id = $row->id_alumni_fk;
          $dataNama = $this->Alumni_model->ambil_nama_poster_perid($id);
          foreach ($dataNama as $row2) {
            # code...
            $dNama = $row2->nama;
            $resNama[] = $this->Alumni_model->tampil_nama($dNama);
          }
        }
        if($dataNama == null){
          $data['namaPoster'] = "";
        }else{
          $data['namaPoster'] = $resNama;
        }

        $this->load->view('vKelolaKarirAdmin.html', $data);
      }
    }

    function KelolaTracerStudy()
    {
      # code...
      $username = $this->session->userdata('username');
      if($username == 'admin'){
        $data['dataTracerStudyAll'] = $this->TracerStudy_model->ambilDataTSAll();
        $this->load->view('vKelolaTracerStudy.html', $data);
      }
    }

    function LihatDetailTs(){
      $id_tracer_study = $this->uri->segment(3);
      $data['id_tracer_study'] = $id_tracer_study;

      // ambil id alumni fk
      $data['tracer_study'] = $this->TracerStudy_model->ambil_id_alumni_fk($id_tracer_study);
      $id = $data['tracer_study']->id_alumni_fk;

      // ambil info alumni
      $data['al'] = $this->Alumni_model->ambil_data_alumni_per_id($id);
      $data['nama'] = $data['al']->nama;

      // ambil data ts alumni
      $row['row'] = $this->TracerStudy_model->tampilDataTS($id_tracer_study);
      $data['f3'] = $row['row']->f3;
      $data['f4'] = $row['row']->f4;
      $data['f5'] = $row['row']->f5;
      $data['f6'] = $row['row']->f6;
      $data['f7'] = $row['row']->f7;
      $data['f7a'] = $row['row']->f7a;
      $data['f8'] = $row['row']->f8;
      $data['f9'] = $row['row']->f9;
      $data['f10'] = $row['row']->f10;
      $data['f11'] = $row['row']->f11;
      $data['f12'] = $row['row']->f12;
      $data['f13'] = $row['row']->f13;
      $data['f14'] = $row['row']->f14;
      $data['f15'] = $row['row']->f15;
      $data['f16'] = $row['row']->f16;

      //ambil data ts sdm alumni
      $row2['row'] = $this->TracerStudy_model->tampilDataTSSDM($id_tracer_study);
      if($row2['row'] == null){
        $data['f17a1'] = 0;
        $data['f17a2'] = 0;
        $data['f17a3'] = 0;
        $data['f17a4'] = 0;
        $data['f17a5'] = 0;
        $data['f17a6'] = 0;
        $data['f17a7'] = 0;
        $data['f17a8'] = 0;
        $data['f17a9'] = 0;
        $data['f17a10'] = 0;
        $data['f17a11'] = 0;
        $data['f17a12'] = 0;
        $data['f17a13'] = 0;
        $data['f17a14'] = 0;
        $data['f17a15'] = 0;
        $data['f17a16'] = 0;
        $data['f17a17'] = 0;
        $data['f17a18'] = 0;
        $data['f17a19'] = 0;
        $data['f17a20'] = 0;
        $data['f17a21'] = 0;
        $data['f17a22'] = 0;
        $data['f17a23'] = 0;
        $data['f17a24'] = 0;
        $data['f17a25'] = 0;
        $data['f17a26'] = 0;
        $data['f17a27'] = 0;
        $data['f17a28'] = 0;
        $data['f17a29'] = 0;
      }else{
        $data['f17a1'] = $row2['row']->f171;
        $data['f17a2'] = $row2['row']->f172;
        $data['f17a3'] = $row2['row']->f173;
        $data['f17a4'] = $row2['row']->f174;
        $data['f17a5'] = $row2['row']->f175;
        $data['f17a6'] = $row2['row']->f176;
        $data['f17a7'] = $row2['row']->f177;
        $data['f17a8'] = $row2['row']->f178;
        $data['f17a9'] = $row2['row']->f179;
        $data['f17a10'] = $row2['row']->f1710;
        $data['f17a11'] = $row2['row']->f1711;
        $data['f17a12'] = $row2['row']->f1712;
        $data['f17a13'] = $row2['row']->f1713;
        $data['f17a14'] = $row2['row']->f1714;
        $data['f17a15'] = $row2['row']->f1715;
        $data['f17a16'] = $row2['row']->f1716;
        $data['f17a17'] = $row2['row']->f1717;
        $data['f17a18'] = $row2['row']->f1718;
        $data['f17a19'] = $row2['row']->f1719;
        $data['f17a20'] = $row2['row']->f1720;
        $data['f17a21'] = $row2['row']->f1721;
        $data['f17a22'] = $row2['row']->f1722;
        $data['f17a23'] = $row2['row']->f1723;
        $data['f17a24'] = $row2['row']->f1724;
        $data['f17a25'] = $row2['row']->f1725;
        $data['f17a26'] = $row2['row']->f1726;
        $data['f17a27'] = $row2['row']->f1727;
        $data['f17a28'] = $row2['row']->f1728;
        $data['f17a29'] = $row2['row']->f1729;
      }

      //ambil data ts sdm prodi
      $row3['row'] = $this->TracerStudy_model->tampilDataTSP($id_tracer_study);
      if($row3['row'] == null){
        $data['f17b1'] = 0;
        $data['f17b2'] = 0;
        $data['f17b3'] = 0;
        $data['f17b4'] = 0;
        $data['f17b5'] = 0;
        $data['f17b6'] = 0;
        $data['f17b7'] = 0;
        $data['f17b8'] = 0;
        $data['f17b9'] = 0;
        $data['f17b10'] = 0;
        $data['f17b11'] = 0;
        $data['f17b12'] = 0;
        $data['f17b13'] = 0;
        $data['f17b14'] = 0;
        $data['f17b15'] = 0;
        $data['f17b16'] = 0;
        $data['f17b17'] = 0;
        $data['f17b18'] = 0;
        $data['f17b19'] = 0;
        $data['f17b20'] = 0;
        $data['f17b21'] = 0;
        $data['f17b22'] = 0;
        $data['f17b23'] = 0;
        $data['f17b24'] = 0;
        $data['f17b25'] = 0;
        $data['f17b26'] = 0;
        $data['f17b27'] = 0;
        $data['f17b28'] = 0;
        $data['f17b29'] = 0;
      }else{
        $data['f17b1'] = $row3['row']->f171;
        $data['f17b2'] = $row3['row']->f172;
        $data['f17b3'] = $row3['row']->f173;
        $data['f17b4'] = $row3['row']->f174;
        $data['f17b5'] = $row3['row']->f175;
        $data['f17b6'] = $row3['row']->f176;
        $data['f17b7'] = $row3['row']->f177;
        $data['f17b8'] = $row3['row']->f178;
        $data['f17b9'] = $row3['row']->f179;
        $data['f17b10'] = $row3['row']->f1710;
        $data['f17b11'] = $row3['row']->f1711;
        $data['f17b12'] = $row3['row']->f1712;
        $data['f17b13'] = $row3['row']->f1713;
        $data['f17b14'] = $row3['row']->f1714;
        $data['f17b15'] = $row3['row']->f1715;
        $data['f17b16'] = $row3['row']->f1716;
        $data['f17b17'] = $row3['row']->f1717;
        $data['f17b18'] = $row3['row']->f1718;
        $data['f17b19'] = $row3['row']->f1719;
        $data['f17b20'] = $row3['row']->f1720;
        $data['f17b21'] = $row3['row']->f1721;
        $data['f17b22'] = $row3['row']->f1722;
        $data['f17b23'] = $row3['row']->f1723;
        $data['f17b24'] = $row3['row']->f1724;
        $data['f17b25'] = $row3['row']->f1725;
        $data['f17b26'] = $row3['row']->f1726;
        $data['f17b27'] = $row3['row']->f1727;
        $data['f17b28'] = $row3['row']->f1728;
        $data['f17b29'] = $row3['row']->f1729;
      }
      // $this->load->view('vTracerStudyDetail.html',$data);
      $this->load->view('vTracerStudyDetail.html',$data);

      // $sumber = $this->load->view('vTracerStudyDetail.html', $data, TRUE);
      // $html = $sumber;
      // $pdfFilePath = "hasilReport.pdf";
      // $this->load->library('MPDF');
      // $this->pdf->WriteHTML($html);
      // $this->pdf->Output($pdfFilePath, "D");
    }

    function simpanLaporanTSpdf(){
      $id_tracer_study = $this->uri->segment(3);

      // ambil id alumni fk
      $data['tracer_study'] = $this->TracerStudy_model->ambil_id_alumni_fk($id_tracer_study);
      $id = $data['tracer_study']->id_alumni_fk;

      // ambil info alumni
      $data['al'] = $this->Alumni_model->ambil_data_alumni_per_id($id);
      $data['nama'] = $data['al']->nama;

      // ambil data ts alumni
      $row['row'] = $this->TracerStudy_model->tampilDataTS($id_tracer_study);
      $data['f3'] = $row['row']->f3;
      $data['f4'] = $row['row']->f4;
      $data['f5'] = $row['row']->f5;
      $data['f6'] = $row['row']->f6;
      $data['f7'] = $row['row']->f7;
      $data['f7a'] = $row['row']->f7a;
      $data['f8'] = $row['row']->f8;
      $data['f9'] = $row['row']->f9;
      $data['f10'] = $row['row']->f10;
      $data['f11'] = $row['row']->f11;
      $data['f12'] = $row['row']->f12;
      $data['f13'] = $row['row']->f13;
      $data['f14'] = $row['row']->f14;
      $data['f15'] = $row['row']->f15;
      $data['f16'] = $row['row']->f16;

      //ambil data ts sdm alumni
      $row2['row'] = $this->TracerStudy_model->tampilDataTSSDM($id_tracer_study);
      if($row2['row'] == null){
        $data['f17a1'] = 0;
        $data['f17a2'] = 0;
        $data['f17a3'] = 0;
        $data['f17a4'] = 0;
        $data['f17a5'] = 0;
        $data['f17a6'] = 0;
        $data['f17a7'] = 0;
        $data['f17a8'] = 0;
        $data['f17a9'] = 0;
        $data['f17a10'] = 0;
        $data['f17a11'] = 0;
        $data['f17a12'] = 0;
        $data['f17a13'] = 0;
        $data['f17a14'] = 0;
        $data['f17a15'] = 0;
        $data['f17a16'] = 0;
        $data['f17a17'] = 0;
        $data['f17a18'] = 0;
        $data['f17a19'] = 0;
        $data['f17a20'] = 0;
        $data['f17a21'] = 0;
        $data['f17a22'] = 0;
        $data['f17a23'] = 0;
        $data['f17a24'] = 0;
        $data['f17a25'] = 0;
        $data['f17a26'] = 0;
        $data['f17a27'] = 0;
        $data['f17a28'] = 0;
        $data['f17a29'] = 0;
      }else{
        $data['f17a1'] = $row2['row']->f171;
        $data['f17a2'] = $row2['row']->f172;
        $data['f17a3'] = $row2['row']->f173;
        $data['f17a4'] = $row2['row']->f174;
        $data['f17a5'] = $row2['row']->f175;
        $data['f17a6'] = $row2['row']->f176;
        $data['f17a7'] = $row2['row']->f177;
        $data['f17a8'] = $row2['row']->f178;
        $data['f17a9'] = $row2['row']->f179;
        $data['f17a10'] = $row2['row']->f1710;
        $data['f17a11'] = $row2['row']->f1711;
        $data['f17a12'] = $row2['row']->f1712;
        $data['f17a13'] = $row2['row']->f1713;
        $data['f17a14'] = $row2['row']->f1714;
        $data['f17a15'] = $row2['row']->f1715;
        $data['f17a16'] = $row2['row']->f1716;
        $data['f17a17'] = $row2['row']->f1717;
        $data['f17a18'] = $row2['row']->f1718;
        $data['f17a19'] = $row2['row']->f1719;
        $data['f17a20'] = $row2['row']->f1720;
        $data['f17a21'] = $row2['row']->f1721;
        $data['f17a22'] = $row2['row']->f1722;
        $data['f17a23'] = $row2['row']->f1723;
        $data['f17a24'] = $row2['row']->f1724;
        $data['f17a25'] = $row2['row']->f1725;
        $data['f17a26'] = $row2['row']->f1726;
        $data['f17a27'] = $row2['row']->f1727;
        $data['f17a28'] = $row2['row']->f1728;
        $data['f17a29'] = $row2['row']->f1729;
      }

      //ambil data ts sdm prodi
      $row3['row'] = $this->TracerStudy_model->tampilDataTSP($id_tracer_study);
      if($row3['row'] == null){
        $data['f17b1'] = 0;
        $data['f17b2'] = 0;
        $data['f17b3'] = 0;
        $data['f17b4'] = 0;
        $data['f17b5'] = 0;
        $data['f17b6'] = 0;
        $data['f17b7'] = 0;
        $data['f17b8'] = 0;
        $data['f17b9'] = 0;
        $data['f17b10'] = 0;
        $data['f17b11'] = 0;
        $data['f17b12'] = 0;
        $data['f17b13'] = 0;
        $data['f17b14'] = 0;
        $data['f17b15'] = 0;
        $data['f17b16'] = 0;
        $data['f17b17'] = 0;
        $data['f17b18'] = 0;
        $data['f17b19'] = 0;
        $data['f17b20'] = 0;
        $data['f17b21'] = 0;
        $data['f17b22'] = 0;
        $data['f17b23'] = 0;
        $data['f17b24'] = 0;
        $data['f17b25'] = 0;
        $data['f17b26'] = 0;
        $data['f17b27'] = 0;
        $data['f17b28'] = 0;
        $data['f17b29'] = 0;
      }else{
        $data['f17b1'] = $row3['row']->f171;
        $data['f17b2'] = $row3['row']->f172;
        $data['f17b3'] = $row3['row']->f173;
        $data['f17b4'] = $row3['row']->f174;
        $data['f17b5'] = $row3['row']->f175;
        $data['f17b6'] = $row3['row']->f176;
        $data['f17b7'] = $row3['row']->f177;
        $data['f17b8'] = $row3['row']->f178;
        $data['f17b9'] = $row3['row']->f179;
        $data['f17b10'] = $row3['row']->f1710;
        $data['f17b11'] = $row3['row']->f1711;
        $data['f17b12'] = $row3['row']->f1712;
        $data['f17b13'] = $row3['row']->f1713;
        $data['f17b14'] = $row3['row']->f1714;
        $data['f17b15'] = $row3['row']->f1715;
        $data['f17b16'] = $row3['row']->f1716;
        $data['f17b17'] = $row3['row']->f1717;
        $data['f17b18'] = $row3['row']->f1718;
        $data['f17b19'] = $row3['row']->f1719;
        $data['f17b20'] = $row3['row']->f1720;
        $data['f17b21'] = $row3['row']->f1721;
        $data['f17b22'] = $row3['row']->f1722;
        $data['f17b23'] = $row3['row']->f1723;
        $data['f17b24'] = $row3['row']->f1724;
        $data['f17b25'] = $row3['row']->f1725;
        $data['f17b26'] = $row3['row']->f1726;
        $data['f17b27'] = $row3['row']->f1727;
        $data['f17b28'] = $row3['row']->f1728;
        $data['f17b29'] = $row3['row']->f1729;
      }
      $pdfFilePath = FCPATH."/downloads/Laporan Tracer Study ".$data['nama'].".pdf";
      if(file_exists($pdfFilePath) == TRUE)
      {
        // $data['file_exists'] = 'true';
        // $this->load->view('vSimpanTracerStudy.html', $data);
        echo "<script language=\"javascript\">
          if(confirm('Laporan Hasil Tracer Study untuk Alumni ini sudah ada, apakah Anda ingin memperbarui laporan tersebut ?')){
            window.location.replace('http://localhost:8080/aluminiumv3/index.php/Admin/UpdateLaporanTracerStudy/$id_tracer_study');
          }else{
            alert('Anda tidak memperbaharui Laporan Hasil Tracer Study ini.');
            window.location.replace('http://localhost:8080/aluminiumv3/index.php/Admin/KelolaTracerStudy');
          }
        </script>";

        // redirect('Admin/KelolaTracerStudy');
      }else if(file_exists($pdfFilePath)== FALSE){
        $data['file_exists'] = 'false';
        // $this->load->view('vSimpanTracerStudy.html', $data);
        echo "<script language=\"javascript\">
          alert('Laporan Hasil Tracer Study telah berhasil disimpan.');
          window.location.replace('http://localhost:8080/aluminiumv3/index.php/Admin/KelolaTracerStudy');
        </script>";
        ini_set('memory_limit', '32M');
        $html = $this->load->view('vSimpanTracerStudy.html', $data, true);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
        $pdf->WriteHTML($html);
        $pdf->Output($pdfFilePath,'F');
        // redirect('Admin/KelolaTracerStudy');
      }
    }

    function UpdateLaporanTracerStudy()
    {
      # code...
      $id_tracer_study = $this->uri->segment(3);

      // ambil id alumni fk
      $data['tracer_study'] = $this->TracerStudy_model->ambil_id_alumni_fk($id_tracer_study);
      $id = $data['tracer_study']->id_alumni_fk;

      // ambil info alumni
      $data['al'] = $this->Alumni_model->ambil_data_alumni_per_id($id);
      $data['nama'] = $data['al']->nama;

      // ambil data ts alumni
      $row['row'] = $this->TracerStudy_model->tampilDataTS($id_tracer_study);
      $data['f3'] = $row['row']->f3;
      $data['f4'] = $row['row']->f4;
      $data['f5'] = $row['row']->f5;
      $data['f6'] = $row['row']->f6;
      $data['f7'] = $row['row']->f7;
      $data['f7a'] = $row['row']->f7a;
      $data['f8'] = $row['row']->f8;
      $data['f9'] = $row['row']->f9;
      $data['f10'] = $row['row']->f10;
      $data['f11'] = $row['row']->f11;
      $data['f12'] = $row['row']->f12;
      $data['f13'] = $row['row']->f13;
      $data['f14'] = $row['row']->f14;
      $data['f15'] = $row['row']->f15;
      $data['f16'] = $row['row']->f16;

      //ambil data ts sdm alumni
      $row2['row'] = $this->TracerStudy_model->tampilDataTSSDM($id_tracer_study);
      if($row2['row'] == null){
        $data['f17a1'] = 0;
        $data['f17a2'] = 0;
        $data['f17a3'] = 0;
        $data['f17a4'] = 0;
        $data['f17a5'] = 0;
        $data['f17a6'] = 0;
        $data['f17a7'] = 0;
        $data['f17a8'] = 0;
        $data['f17a9'] = 0;
        $data['f17a10'] = 0;
        $data['f17a11'] = 0;
        $data['f17a12'] = 0;
        $data['f17a13'] = 0;
        $data['f17a14'] = 0;
        $data['f17a15'] = 0;
        $data['f17a16'] = 0;
        $data['f17a17'] = 0;
        $data['f17a18'] = 0;
        $data['f17a19'] = 0;
        $data['f17a20'] = 0;
        $data['f17a21'] = 0;
        $data['f17a22'] = 0;
        $data['f17a23'] = 0;
        $data['f17a24'] = 0;
        $data['f17a25'] = 0;
        $data['f17a26'] = 0;
        $data['f17a27'] = 0;
        $data['f17a28'] = 0;
        $data['f17a29'] = 0;
      }else{
        $data['f17a1'] = $row2['row']->f171;
        $data['f17a2'] = $row2['row']->f172;
        $data['f17a3'] = $row2['row']->f173;
        $data['f17a4'] = $row2['row']->f174;
        $data['f17a5'] = $row2['row']->f175;
        $data['f17a6'] = $row2['row']->f176;
        $data['f17a7'] = $row2['row']->f177;
        $data['f17a8'] = $row2['row']->f178;
        $data['f17a9'] = $row2['row']->f179;
        $data['f17a10'] = $row2['row']->f1710;
        $data['f17a11'] = $row2['row']->f1711;
        $data['f17a12'] = $row2['row']->f1712;
        $data['f17a13'] = $row2['row']->f1713;
        $data['f17a14'] = $row2['row']->f1714;
        $data['f17a15'] = $row2['row']->f1715;
        $data['f17a16'] = $row2['row']->f1716;
        $data['f17a17'] = $row2['row']->f1717;
        $data['f17a18'] = $row2['row']->f1718;
        $data['f17a19'] = $row2['row']->f1719;
        $data['f17a20'] = $row2['row']->f1720;
        $data['f17a21'] = $row2['row']->f1721;
        $data['f17a22'] = $row2['row']->f1722;
        $data['f17a23'] = $row2['row']->f1723;
        $data['f17a24'] = $row2['row']->f1724;
        $data['f17a25'] = $row2['row']->f1725;
        $data['f17a26'] = $row2['row']->f1726;
        $data['f17a27'] = $row2['row']->f1727;
        $data['f17a28'] = $row2['row']->f1728;
        $data['f17a29'] = $row2['row']->f1729;
      }

      //ambil data ts sdm prodi
      $row3['row'] = $this->TracerStudy_model->tampilDataTSP($id_tracer_study);
      if($row3['row'] == null){
        $data['f17b1'] = 0;
        $data['f17b2'] = 0;
        $data['f17b3'] = 0;
        $data['f17b4'] = 0;
        $data['f17b5'] = 0;
        $data['f17b6'] = 0;
        $data['f17b7'] = 0;
        $data['f17b8'] = 0;
        $data['f17b9'] = 0;
        $data['f17b10'] = 0;
        $data['f17b11'] = 0;
        $data['f17b12'] = 0;
        $data['f17b13'] = 0;
        $data['f17b14'] = 0;
        $data['f17b15'] = 0;
        $data['f17b16'] = 0;
        $data['f17b17'] = 0;
        $data['f17b18'] = 0;
        $data['f17b19'] = 0;
        $data['f17b20'] = 0;
        $data['f17b21'] = 0;
        $data['f17b22'] = 0;
        $data['f17b23'] = 0;
        $data['f17b24'] = 0;
        $data['f17b25'] = 0;
        $data['f17b26'] = 0;
        $data['f17b27'] = 0;
        $data['f17b28'] = 0;
        $data['f17b29'] = 0;
      }else{
        $data['f17b1'] = $row3['row']->f171;
        $data['f17b2'] = $row3['row']->f172;
        $data['f17b3'] = $row3['row']->f173;
        $data['f17b4'] = $row3['row']->f174;
        $data['f17b5'] = $row3['row']->f175;
        $data['f17b6'] = $row3['row']->f176;
        $data['f17b7'] = $row3['row']->f177;
        $data['f17b8'] = $row3['row']->f178;
        $data['f17b9'] = $row3['row']->f179;
        $data['f17b10'] = $row3['row']->f1710;
        $data['f17b11'] = $row3['row']->f1711;
        $data['f17b12'] = $row3['row']->f1712;
        $data['f17b13'] = $row3['row']->f1713;
        $data['f17b14'] = $row3['row']->f1714;
        $data['f17b15'] = $row3['row']->f1715;
        $data['f17b16'] = $row3['row']->f1716;
        $data['f17b17'] = $row3['row']->f1717;
        $data['f17b18'] = $row3['row']->f1718;
        $data['f17b19'] = $row3['row']->f1719;
        $data['f17b20'] = $row3['row']->f1720;
        $data['f17b21'] = $row3['row']->f1721;
        $data['f17b22'] = $row3['row']->f1722;
        $data['f17b23'] = $row3['row']->f1723;
        $data['f17b24'] = $row3['row']->f1724;
        $data['f17b25'] = $row3['row']->f1725;
        $data['f17b26'] = $row3['row']->f1726;
        $data['f17b27'] = $row3['row']->f1727;
        $data['f17b28'] = $row3['row']->f1728;
        $data['f17b29'] = $row3['row']->f1729;
      }
      // lokasi file pdf laporan
      $pdfFilePath = FCPATH."/downloads/Laporan Tracer Study ".$data['nama'].".pdf";

      // proses update laporan pdf
      echo "<script language=\"javascript\">alert('Laporan Hasil Tracer Study telah berhasil disimpan.');</script>";
      ini_set('memory_limit', '32M');
      $html = $this->load->view('vSimpanUpdateTracerStudy.html', $data, true);
      $this->load->library('pdf');
      $pdf = $this->pdf->load();
      $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
      $pdf->WriteHTML($html);
      $pdf->Output($pdfFilePath,'F');
      redirect('Admin/KelolaTracerStudy');
      // $this->load->view('vSimpanUpdateTracerStudy.html', $data);
    }

    function laporan(){
      $username = $this->session->userdata('username');
      if($username == 'admin'){
        $data['nama'] = $this->session->userdata('nama');
        $data['num'] = $this->TracerStudy_model->ambilDataLamaWaktuTunggu();
        $data['alumni_bekerja'] = $this->TracerStudy_model->ambilDataBekerja();
        $data['hasilBekerja'] = $this->TracerStudy_model->ambilDataSudahBekerja();
        $data['hasilBelumBekerja'] = $this->TracerStudy_model->ambilDataBelumBekerja();
        $data['hasilSangatErat'] = $this->TracerStudy_model->ambilDataf14SangatErat();
        $data['hasilErat'] = $this->TracerStudy_model->ambilDataf14Erat();
        $data['hasilCukupErat'] = $this->TracerStudy_model->ambilDataf14CukupErat();
        $data['hasilKurangErat'] = $this->TracerStudy_model->ambilDataf14KurangErat();
        $data['hasilTidakSamaSekali'] = $this->TracerStudy_model->ambilDataf14TidakSamaSekali();
        $data['hasilPendapatan02'] = $this->TracerStudy_model->ambilDataPendapatan02();
        $data['hasilPendapatan23'] = $this->TracerStudy_model->ambilDataPendapatan23();
        $data['hasilPendapatan34'] = $this->TracerStudy_model->ambilDataPendapatan34();
        $data['hasilPendapatan4'] = $this->TracerStudy_model->ambilDataPendapatan4();
        $data['kepuasan_tingkat_pendidikan'] = $this->TracerStudy_model->ambilDataKepuasanTingkatPendidikan();
        $data['pendapatan'] = $this->TracerStudy_model->ambilDataPendapatan();
        $data['b0'] = $this->TracerStudy_model->ambilDataF5b0();
        $this->load->view('vLaporanAdmin.html', $data);
      }
    }

    function logout(){
      $this->session->unset_userdata('username');
      session_destroy();
      redirect('Home');
    }

  }
?>
