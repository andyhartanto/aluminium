<?php
  /**
   *
   */
  class Stakeholders extends CI_Controller
  {
    public function __construct()
    {
      # code...
      parent::__construct();
      if($this->session->userdata('username')==null){
        redirect('Home/login');
      }
      $this->load->model('Stakeholders_model');
      $this->load->helper('text');
    }

    public function index(){
      $data['username']=$this->session->userdata('username');
      if($data['username']!=null)
      {
        $data['nama'] = $this->session->userdata('username');
        //pagination kelola tracer study share_stakeholders
        //pagination data alumni
        $page = $this->uri->segment(3);
        $limit = 15;
        if(!$page){
          $offset = 0;
        }else{
          $offset = $page;
        }
        $data = array();
        $total = $this->Stakeholders_model->ambil_stakeholders_semua();
        $config['base_url'] = base_url().'index.php/Stakeholders';
        $config['total_rows'] = $total->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['first_link'] = 'Awal ';
        $config['last_link'] = ' Akhir';
        $config['next_link'] = '  Selanjutnya';
        $config['prev_link'] = 'Sebelumnya  ';
        $this->pagination->initialize($config);
        $data['paginator'] = $this->pagination->create_links();

        $data['hasil'] = $this->Stakeholders_model->tampil_data_stakeholders($offset, $limit);
        $data['page'] = $page;
        $this->load->view('vKelolaStakeholdersAdmin.html',$data);
      }
    }

    public function tampilDetailTSS(){
        $id_tss = $this->uri->segment(3);
        $data['id_tss'] = $id_tss;
        $hasil['row'] = $this->Stakeholders_model->ambil_data_tss_per_id($id_tss);
        $data['nama'] = $hasil['row']->nama;
        $data['perusahaan'] = $hasil['row']->perusahaan;
        $data['jabatan'] = $hasil['row']->jabatan;
        $data['alumni'] = $hasil['row']->namaAlumni;
        $data['p1'] = $hasil['row']->p1;
        $data['p2'] = $hasil['row']->p2;
        $data['p3'] = $hasil['row']->p3;
        $data['p4'] = $hasil['row']->p4;
        $data['p5'] = $hasil['row']->p5;
        $data['p6'] = $hasil['row']->p6;
        $data['p7'] = $hasil['row']->p7;
        $data['p8'] = $hasil['row']->p8;
        $data['p9'] = $hasil['row']->p9;
        $data['p10'] = $hasil['row']->p10;
        $data['p11'] = $hasil['row']->p11;
        $data['p12'] = $hasil['row']->p12;
        $data['p13'] = $hasil['row']->p13;
        $data['p14'] = $hasil['row']->p14;
        $data['p15'] = $hasil['row']->p15;
        $data['p16'] = $hasil['row']->p16;
        $data['p17'] = $hasil['row']->p17;
        $data['p18'] = $hasil['row']->p18;
        $data['p19'] = $hasil['row']->p19;
        $data['p20'] = $hasil['row']->p20;
        $data['p21'] = $hasil['row']->p21;
        $data['p22'] = $hasil['row']->p22;
        $data['p23'] = $hasil['row']->p23;
        $data['p24'] = $hasil['row']->p24;
        $data['p25'] = $hasil['row']->p25;
        $this->load->view('vDetailStakeholders.html', $data);
    }

    public function simpanLaporanTSSpdf()
    {
      # code...
      $id_tss = $this->uri->segment(3);
      $data['id_tss'] = $id_tss;
      $hasil['row'] = $this->Stakeholders_model->ambil_data_tss_per_id($id_tss);
      $data['nama'] = $hasil['row']->nama;
      $data['perusahaan'] = $hasil['row']->perusahaan;
      $data['jabatan'] = $hasil['row']->jabatan;
      $data['alumni'] = $hasil['row']->namaAlumni;
      $data['p1'] = $hasil['row']->p1;
      $data['p2'] = $hasil['row']->p2;
      $data['p3'] = $hasil['row']->p3;
      $data['p4'] = $hasil['row']->p4;
      $data['p5'] = $hasil['row']->p5;
      $data['p6'] = $hasil['row']->p6;
      $data['p7'] = $hasil['row']->p7;
      $data['p8'] = $hasil['row']->p8;
      $data['p9'] = $hasil['row']->p9;
      $data['p10'] = $hasil['row']->p10;
      $data['p11'] = $hasil['row']->p11;
      $data['p12'] = $hasil['row']->p12;
      $data['p13'] = $hasil['row']->p13;
      $data['p14'] = $hasil['row']->p14;
      $data['p15'] = $hasil['row']->p15;
      $data['p16'] = $hasil['row']->p16;
      $data['p17'] = $hasil['row']->p17;
      $data['p18'] = $hasil['row']->p18;
      $data['p19'] = $hasil['row']->p19;
      $data['p20'] = $hasil['row']->p20;
      $data['p21'] = $hasil['row']->p21;
      $data['p22'] = $hasil['row']->p22;
      $data['p23'] = $hasil['row']->p23;
      $data['p24'] = $hasil['row']->p24;
      $data['p25'] = $hasil['row']->p25;
      $pdfFilePath = FCPATH."/downloads/stakeholders/Laporan Tracer Study Stakeholders ".$data['nama'].".pdf";
      if(file_exists($pdfFilePath)== FALSE){
        echo "<script language=\"javascript\">
          alert('Laporan Hasil Pengisian Tracer Study Stakeholders telah berhasil disimpan.');
          window.close();
          </script>";
          ini_set('memory_limit', '32M');
          $html = $this->load->view('vSimpanStakeholders.html', $data, true);
          $this->load->library('pdf');
          $pdf = $this->pdf->load();
          $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
          $pdf->WriteHTML($html);
          $pdf->Output($pdfFilePath, 'F');
      }else if(file_exists($pdfFilePath) == TRUE){
        echo "<script language=\"javascript\">
          if(confirm('Laporan Hasil Pengisian Tracer Study Stakeholders ini sudah ada, apakah Anda ingin memperbaharuinya ? ')){
            window.location.replace('http://localhost:8080/aluminiumv3/index.php/Stakeholders/UpdateLaporanTracerStudyStakeholders/$id_tss');
          }else{
            alert('Anda tidak memperbaharui Laporan Tracer Study Stakeholders ini.');
            window.close();
          }
          </script>";
      }
    }

    public function UpdateLaporanTracerStudyStakeholders()
    {
      # code...
      $id_tss = $this->uri->segment(3);
      $data['id_tss'] = $id_tss;
      $hasil['row'] = $this->Stakeholders_model->ambil_data_tss_per_id($id_tss);
      $data['nama'] = $hasil['row']->nama;
      $data['perusahaan'] = $hasil['row']->perusahaan;
      $data['jabatan'] = $hasil['row']->jabatan;
      $data['alumni'] = $hasil['row']->namaAlumni;
      $data['p1'] = $hasil['row']->p1;
      $data['p2'] = $hasil['row']->p2;
      $data['p3'] = $hasil['row']->p3;
      $data['p4'] = $hasil['row']->p4;
      $data['p5'] = $hasil['row']->p5;
      $data['p6'] = $hasil['row']->p6;
      $data['p7'] = $hasil['row']->p7;
      $data['p8'] = $hasil['row']->p8;
      $data['p9'] = $hasil['row']->p9;
      $data['p10'] = $hasil['row']->p10;
      $data['p11'] = $hasil['row']->p11;
      $data['p12'] = $hasil['row']->p12;
      $data['p13'] = $hasil['row']->p13;
      $data['p14'] = $hasil['row']->p14;
      $data['p15'] = $hasil['row']->p15;
      $data['p16'] = $hasil['row']->p16;
      $data['p17'] = $hasil['row']->p17;
      $data['p18'] = $hasil['row']->p18;
      $data['p19'] = $hasil['row']->p19;
      $data['p20'] = $hasil['row']->p20;
      $data['p21'] = $hasil['row']->p21;
      $data['p22'] = $hasil['row']->p22;
      $data['p23'] = $hasil['row']->p23;
      $data['p24'] = $hasil['row']->p24;
      $data['p25'] = $hasil['row']->p25;
      $pdfFilePath = FCPATH."/downloads/stakeholders/Laporan Tracer Study Stakeholders ".$data['nama'].".pdf";
      echo "<script language=\"javascript\">
        alert('Laporan Hasil Pengisian Tracer Study Stakeholders telah berhasil diperbaharui.');
        window.close();
        </script>";
      ini_set('memory_limit', '32M');
      $html = $this->load->view('vSimpanUpdateStakeholders.html', $data, true);
      $this->load->library('pdf');
      $pdf = $this->pdf->load();
      $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
      $pdf->WriteHTML($html);
      $pdf->Output($pdfFilePath, 'F');
    }
  }

?>
