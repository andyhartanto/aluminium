<?php
  Class Alumni extends CI_Controller{
    public function __construct(){
      parent::__construct();
      if($this->session->userdata('username')==null){
        redirect('Home/login');
        // echo "<script language=\"javascript\">alert('test');</script>";
      }
      $this->load->model('Alumni_model');
    }

    public function index(){
      $data['username']=$this->session->userdata('username');
      if($data['username']!=null)
      {
        $this->load->model('TracerStudy_model');
        $data['hasilLaki'] = $this->TracerStudy_model->ambil_jenis_kelamin_laki();
        $data['hasilPerempuan'] = $this->TracerStudy_model->ambil_jenis_kelamin_perempuan();
        $data['hasilBekerja'] = $this->TracerStudy_model->ambilDataSudahBekerja();
        $data['hasilBelumBekerja'] = $this->TracerStudy_model->ambilDataBelumBekerja();
        $data['nama'] =  $this->session->userdata('nama');
        $this->load->view('vDashboardAluminium.html',$data);
      }
    }

    public function TracerStudy(){
      $data['username'] = $this->session->userdata('username');
      if($data['username']!=null){
        //$this->load->view('vTracerStudy.html',$data);
        redirect('TracerStudy');
      }
    }

    public function PersebaranAlumni(){
      $data['username']=$this->session->userdata('username');
      if($data['username']!=null){
        // meload library googlemaps dan model map_model
        $this->load->library('Googlemaps');
        $this->load->model('Map_model');

        //inisialissi array untuk konfiguras biostall dan data
        $config = array();
        $marker = array();
        $data = array();

        //tangkap tombol submit
        $tSubmit = $this->input->post('submit');

        //cek jika submit, proses haversine
        if($tSubmit == 'Cari Alumni Terdekat'){
          //menangkap latitude dan longitude posisi alumni saat ini
          $latitude = $this->input->post('lat');
          $longitude = $this->input->post('long');

          //center akan menjadi lokasi alumni saat itu
          $config['center'] = 'auto';

          //konfigurasi marker posisi alumni saat itu
          $config['onboundschanged'] ='if (!centreGot){
            var mapCentre = map.getCenter();
            marker_0.setOptions({
              position: new google.maps.LatLng(mapCentre.lat(),mapCentre.lng()),
              icon:{
                path: google.maps.SymbolPath.CIRCLE,
                scale: 4,
                strokeColor: "blue",
                strokeOpacity: 0.5,
                strokeWeight: 8.0,
                fillColor: "blue",
                fillOpacity: 1
              }
            });
          }
          centreGot = true;';

          //konfigurasi zoom dari peta
          $config['zoom'] = 9;

          //menyimpan / mejalankan konfigurasi dan menggambar marker
          $this->googlemaps->initialize($config);
          $this->googlemaps->add_marker($marker);

          // proses haversine
          $data['hasil_haversine'] = $this->Map_model->haversine($latitude, $longitude);

          //menggambar marker dari hasi proses haversine
          foreach ($data['hasil_haversine'] as $row) {
            $id_alumni_fk = $row->id_alumni_fk;
            $hLatitude = $row->latitude;
            $hLongitude = $row->longitude;
            $tempatKerja = $row->nama_instansi;
            $data['id_alumnifk'] = $id_alumni_fk;
            $dataInfo = $this->Alumni_model->ambil_data_alumni_per_id2($data['id_alumnifk']);
            foreach ($dataInfo as $row2) {
              $nama = $row2->nama;
              $email = $row2->email;
              $facebook = $row2->facebook;
              $twitter = $row2->twitter;
              $instagram = $row2->instagram;

              $resNama[] = $this->Alumni_model->tampil_nama($nama);
              $resEmail[] = $this->Alumni_model->tampil_email($email);
              $resFb[] = $this->Alumni_model->tampil_fb($facebook);
              $resTwitter[] = $this->Alumni_model->tampil_twitter($twitter);
              $resInstagram[] = $this->Alumni_model->tampil_instagram($instagram);
            }
            $dat['nama'] = $resNama;
            $dat['email'] = $resEmail;
            $dat['facebook'] = $resFb;
            $dat['twitter'] = $resTwitter;
            $dat['instagram'] = $resInstagram;
            $marker['position'] =  $hLatitude.','.$hLongitude;
            if($facebook == "" && $email == "" && $twitter == "" && $instagram == ""){
              $marker['infowindow_content'] = "Aluminium : $nama, bekerja di $tempatKerja. Kontak Facebook : <a href=http://www.facebook.com/>-</a> , Twitter : <a href=http://www.twitter.com/>-</a>, Instagram : <a href=http://www.instagram.com/>-</a>, Email : - ";
            }else{
              $marker['infowindow_content'] = "Aluminium : $nama, bekerja di $tempatKerja. Kontak Facebook : <a href=$facebook>$nama</a> , Twitter : <a href=http://www.twitter.com/$twitter>@$twitter</a>, Instagram : <a href=http://www.instagram.com/$instagram>@$instagram</a>, Email : $email ";
            }
            // $marker['infowindow_content'] = "Aluminium : $nama, bekerja di $tempatKerja. Kontak Facebook : <a href=$facebook>$nama</a> , Twitter : <a href=http://www.twitter.com/$twitter>@$twitter</a>, Instagram : <a href=http://www.instagram.com/$instagram>@$instagram</a>, Email : $email ";
            $this->googlemaps->add_marker($marker);
          }
          // $idAlumni = array();
          // foreach ($idAlumni as $key) {
          //   //proses ambil latitude, longitude jika idAlumni = a
          //
          // }

          // //ambil koordinat  sesuai id_alumni
          // $koordinatHav = $this->Map_model->ambil_lat_long_hav();
          // //membuat dan menggambar marker
          // foreach ($koordinatHav as $koorHav) {
          //   $marker['position'] =  $koorHav->latitude.','.$koorHav->longitude;
          //   $this->googlemaps->add_marker($marker);
          // }
          $data['map'] = $this->googlemaps->create_map();
          $data['nama'] = $this->session->userdata('nama');
          $this->load->view('vPersebaranAlumni.html', $data);
        }else{
          //cek nilai id alumni fk
          $data['id_alumnifk'] = 0;
          $config['center'] = '-3.677076, 119.647694';
          $config['zoom'] = 5;
          // $config['onboundschanged'] ='if (!centreGot){
          //   var mapCentre = map.getCenter();
          //   marker_0.setOptions({
          //     position: new google.maps.LatLng(mapCentre.lat(),mapCentre.lng()),
          //     icon:{
          //       path: google.maps.SymbolPath.CIRCLE,
          //       scale: 4,
          //       strokeColor: "blue",
          //       strokeOpacity: 0.5,
          //       strokeWeight: 8.0,
          //       fillColor: "blue",
          //       fillOpacity: 1
          //     }
          //   });
          // }
          // centreGot = true;';
          $this->googlemaps->initialize($config);
          $this->googlemaps->add_marker($marker);
          $koordinatAll = $this->Map_model->ambil_lat_long();
          foreach ($koordinatAll as $koordinat) {
            // $marker = array();
            $id_alumni_fk = $koordinat->id_alumni_fk;
            $tempatKerja = $koordinat->nama_instansi;
            $dataInfo = $this->Alumni_model->ambil_data_alumni_per_id2($id_alumni_fk);
            foreach ($dataInfo as $row2) {
              $nama = $row2->nama;
              $email = $row2->email;
              $facebook = $row2->facebook;
              $twitter = $row2->twitter;
              $instagram = $row2->instagram;

              // $nama = "Gupta Yusuf Putra";
              // $email = "";
              // $facebook = "";
              // $twitter = "";
              // $instagram = "";

              $resNama[] = $this->Alumni_model->tampil_nama($nama);
              $resEmail[] = $this->Alumni_model->tampil_email($email);
              $resFb[] = $this->Alumni_model->tampil_fb($facebook);
              $resTwitter[] = $this->Alumni_model->tampil_twitter($twitter);
              $resInstagram[] = $this->Alumni_model->tampil_instagram($instagram);
            }
            $dat['nama'] = $resNama;
            $dat['email'] = $resEmail;
            $dat['facebook'] = $resFb;
            $dat['twitter'] = $resTwitter;
            $dat['instagram'] = $resInstagram;
            if($facebook == "" && $email == "" && $twitter == "" && $instagram == ""){
              $marker['infowindow_content'] = "Aluminium : $nama, bekerja di $tempatKerja. Kontak Facebook : <a href=http://www.facebook.com/>-</a> , Twitter : <a href=http://www.twitter.com/>-</a>, Instagram : <a href=http://www.instagram.com/>-</a>, Email : - ";
            }else{
              $marker['infowindow_content'] = "Aluminium : $nama, bekerja di $tempatKerja. Kontak Facebook : <a href=$facebook>$nama</a> , Twitter : <a href=http://www.twitter.com/$twitter>@$twitter</a>, Instagram : <a href=http://www.instagram.com/$instagram>@$instagram</a>, Email : $email ";
            }
            $marker['position'] =  $koordinat->latitude.','.$koordinat->longitude;
            $this->googlemaps->add_marker($marker);
          }
          // $data = array();
          $data['id_alumni'] = 0;
          $data['map'] = $this->googlemaps->create_map();
          $data['nama'] = $this->session->userdata('nama');
          $this->load->view('vPersebaranAlumni.html', $data);
        }
      }
    }

    public function prosesHaversine(){
      // $data = array('latitude' => $this->input->post('lat'), 'longitude' => $this->input->post('long'));
      $this->load->model('Map_model');
      $latitude = $this->input->post('lat');
      $longitude = $this->input->post('long');
      $data['hasil'] = $this->Map_model->haversine($latitude, $longitude);
      $this->load->view('vTesHaversine.html', $data);
    }

    public function profile_alumni(){
    $data['username'] = $this->session->userdata('username');
      if($data['username']!=null){
        $this->load->model('Alumni_model');
        $this->load->model('Map_model');
        $id = $this->session->userdata('id_alumni');
        $data['nama'] =  $this->session->userdata('nama');
        $data['data_alumni'] = $this->Alumni_model->get_data_edit_alumni($id);
        $data['data_tempat_kerja'] = $this->Alumni_model->ambil_data_tempat_kerja($id);
        if($data['data_tempat_kerja']==null ){
          $data['kerja'] = 0;
        }else{
          $data['kerja'] = 1;
        }
        $this->load->view('vProfileAlumni.html', $data);
      }
    }

    public function edit_profile_alumni(){
      $data['username'] = $this->session->userdata('username');
      $this->load->model('Alumni_model');
      $id_alumni = $this->uri->segment(3);
      $this->form_validation->set_rules('namaLengkap', 'Nama Lengkap', 'required');
      $this->form_validation->set_rules('password', 'Password', 'required');
      $this->form_validation->set_rules('jenisKelamin', 'Jenis Kelamin', 'required');
      $this->form_validation->set_rules('email', 'Email', 'required');
      $this->form_validation->set_rules('facebook', 'Facebook', 'required');

      // if($data['username']!=null){
      //   if($_POST == NULL){
      //     $data['nama'] = $this->session->userdata('nama');
      //     $data['data_edit'] = $this->Alumni_model->get_data_edit_alumni($id_alumni);
      //     $this->load->view('vEditProfileAlumni.html', $data);
      //   }else{
      //     $this->Alumni_model->update_data_alumni($id_alumni);
      //     redirect('Alumni/profile_alumni');
      //   }
      // }

      if($data['username']!=null){
        if($_POST != null){
          if($this->form_validation->run()==true){
            $this->Alumni_model->update_data_alumni($id_alumni);
            redirect('Alumni/profile_alumni');
          }else{
            $data['nama'] = $this->session->userdata('nama');
            $data['data_edit'] = $this->Alumni_model->get_data_edit_alumni($id_alumni);
            $this->load->view('vEditProfileAlumni.html',$data);
          }
        }else{
          $data['nama'] = $this->session->userdata('nama');
          $data['data_edit'] = $this->Alumni_model->get_data_edit_alumni($id_alumni);
          $this->load->view('vEditProfileAlumni.html',$data);
        }
      }
    }

    public function tambah_tempat_bekerja(){
      $data['username'] = $this->session->userdata('username');
      if($data['username']!=null){
        $this->form_validation->set_rules('nama_instansi', 'Nama Instansi tempat Anda bekerja', 'required');
        $this->form_validation->set_rules('kota_kerja', 'Kota tempat Anda bekerja', 'required');
        $this->form_validation->set_rules('tahun_masuk', 'Tahun masuk Anda bekerja', 'required');
        $this->form_validation->set_rules('latitude', 'Lokasi bekerja Anda (Latitude)', 'required');
        $this->form_validation->set_rules('longitude', 'Lokasi bekerja Anda (Longitude)', 'required');
        $t_submit = $this->input->post('submit');
        $id_alumni = $this->session->userdata('id_alumni');
        if($t_submit == NULL){
          $data['nama'] = $this->session->userdata('nama');
          $this->load->view('vTambahTempatBekerja.html', $data);
        }else{
          if($this->form_validation->run()==true){
            $this->load->model('Alumni_model');
            $this->Alumni_model->simpan_data_tempat_bekerja();
            redirect('Alumni/profile_alumni');
          }
          else{
            $data['nama'] = $this->session->userdata('nama');
            $this->load->view('vTambahTempatBekerja.html', $data);
          }
        }
      }
    }

    public function edit_tempat_bekerja(){
      $data['username'] = $this->session->userdata('username');
      if($data['username']!=null){
        $this->form_validation->set_rules('nama_instansi', 'Nama Instansi tempat Anda bekerja', 'required');
        $this->form_validation->set_rules('kota_kerja', 'Kota tempat Anda bekerja', 'required');
        $this->form_validation->set_rules('tahun_masuk', 'Tahun masuk Anda bekerja', 'required');
        $this->form_validation->set_rules('latitude', 'Lokasi bekerja Anda (Latitude)', 'required');
        $this->form_validation->set_rules('longitude', 'Lokasi bekerja Anda (Longitude)', 'required');
        $t_submit = $this->input->post('submit');
        $this->load->model('Alumni_model');
        if($t_submit == null){
          $id_alumni = $this->session->userdata('id_alumni');
          $data['ambil_data_kerja'] = $this->Alumni_model->ambil_data_tempat_kerja($id_alumni);
          $data['nama'] = $this->session->userdata('nama');
          $this->load->view('vEditTempatBekerjaAlumni.html', $data);
        }else{
          if($this->form_validation->run()==true){
            $id_alumni = $this->session->userdata('id_alumni');
            $this->Alumni_model->update_data_tempat_bekerja($id_alumni);
            redirect('Alumni/profile_alumni');
          }else{
            $id_alumni = $this->session->userdata('id_alumni');
            $data['ambil_data_kerja'] = $this->Alumni_model->ambil_data_tempat_kerja($id_alumni);
            $data['nama'] = $this->session->userdata('nama');
            $this->load->view('vEditTempatBekerjaAlumni.html', $data);
          }
        }
      }
    }

    // public function Karir(){
    //   $data['username']=$this->session->userdata('username');
    //   if($data['username']!=null)
    //   {
    //     $data['nama'] = $this->session->userdata('nama');
    //     $this->load->view('vKarir.html',$data);
    //   }
    // }

    public function Stakeholder(){
      $data['username']=$this->session->userdata('username');
      if($data['username']!=null)
      {
        $data['nama'] = $this->session->userdata('nama');
        $this->load->view('vShareTracerStudyStakeholders.html',$data);
      }
    }

    public function logout(){
      $this->session->unset_userdata('username');
      session_destroy();
      redirect('Home');
    }

  }
?>
