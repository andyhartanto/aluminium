<?php
if(!defined ('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_MODEL{
	function __construct(){
		//memanggil konstruktor dari model
		parent::__construct();

	}

	//mengecek username dan password dari tabel alumni berdasar jumlah baris
	//29012017 http://www.tutorial-webdesign.com/membuat-login-multiuser-dengan-codeigniter/
	function cek_user($data){
		$query = $this->db->get_where('alumni',$data);
		return $query;
	}

	function get_alumni($user,$pass){
		$query = $this->db->get_where('alumni', array('username'=>$user, 'password'=>$pass));
		return $query;
		/*
		if($query->num_rows()>0){
			$row = $query->row();
			$this->session->set_userdata($username);
			redirect('Home/alumni');
			exit;
		}else {
			echo "user dan pass salah";
			exit;
		}
		*/
		/*
		//$query = $this->db->query("SELECT * FROM alumni WHERE username = '" . $username . "' AND password = '" . md5($password) . "' ");
		//return $query->result();

		$kondisi =array('username' => $user, 'password' => md5($pass));
		$this->db->select('*');
		$this->db->from('alumni');
		$this->db->where($kondisi);
		$hasil = $this->db->get();
		if ($hasil->num_rows()==1){
			return true;
		}else{
			return false;
		}
		*/
	}
	//http://dokumengue.blogspot.co.id/2014/04/menampilkan-data-dari-database.html
	function get_user_all(){
		$query=$this->db->query("SELECT * FROM alumni WHERE username = 'admin' AND password = 'admin' ");
		return $query->result();
	}

	//get alumni
	function get_user_by_id($id){
		$this->db->where('id_alumni',$id);
		$query = $this->db->get('username');
		return $query->result();
	}
}
?>
