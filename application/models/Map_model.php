<?php
  if(!defined('BASEPATH')) exit ('No direct script access allowed');
  class Map_model extends CI_Model{
    function __construct(){
      parent::__construct();
    }

    function ambil_data_tempat_kerja_perId($id_alumni){
      $this->db->select("*");
      $this->db->from("kerja");
      $this->db->where("id_alumni_fk", $id_alumni);
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    function ambil_lat_long(){
      $return = array();
      $this->db->select("*");
      $this->db->from("kerja");
      $query = $this->db->get();

      if($query->num_rows()>0){
        foreach($query->result() as $row){
          array_push($return, $row);
        }
      }
      return $return;
    }

    function haversine($latitude, $longitude){
      // low cosine formula
      // $this->db->select("*, round((6371 * acos(cos(radians('$latitude'))* cos(radians(latitude))*cos(radians('$longitude')-radians(longitude))+sin(radians('$latitude'))*sin(radians(latitude)))),2) AS distance",false);

      //haversine formula
      // 1
      // $this->db->select("*, round(3961 * 2 * ASIN ( SQRT ( POWER ( SIN ( ($latitude - latitude) * pi() / 180 / 2),2) + COS($latitude * pi()/180) * COS(latitude * pi()/180) * POWER(SIN(($longitude - longitude)* pi()/180)/2),2))) AS distance");

      // 2
      // $this->db->select("*, round((2 * 3961 * asin(sqrt((sin(radians((latitude - '$latitude') / 2))) ^ 2 + cos(radians('$latitude')) * cos(radians(latitude)) * (sin(radians(( longitude - '$longitude') / 2 ))) ^ 2)))) AS distance", false);

      // 2.2
      // $this->db->select("*, round(2 * 3961 * asin(sqrt((sin(radians(('$latitude' - latitude) / 2))) ^ 2 + cos(radians(latitude)) * cos(radians('$latitude')) * (sin(radians(('$longitude' - longitude) / 2))) ^ 2))) as distance", false);

      // 2.3
      // $query = "SELECT *,  2 * 3961 * asin(sqrt((sin(radians((lat2 - lat1) / 2))) ^ 2 + cos(radians(lat1)) * cos(radians(lat2)) * (sin(radians((lon2 - lon1) / 2))) ^ 2)) AS distance  HAVING `distance` < 5 ORDER BY `distance` ASC";

      // 2.4 ketemu haversine formula
      $this->db->select("*, round(2 * asin( sqrt( cos(radians('$latitude')) * cos(radians(latitude)) * pow(sin(radians(('$longitude' - longitude)/2 )),2) + pow(sin(radians(('$latitude' - latitude)/2)), 2)))* 6371) as jarak_km", false);
      //hasil hitung / jarak kurang dari 8 Km
      $this->db->having('jarak_km < 8');
      //urut jarak terdekat sampai terjauh
      $this->db->order_by('jarak_km','asc');
      //eksekusi dari tabel kerja (latitude, longitude)
      $query = $this->db->get('kerja');
      $result = $query->result();
      return $result;
      // $awaka = "SELECT 'id_alumni_fk', ( 3959 * acos( cos( radians(?) ) * cos( radians('latitude') ) * cos( radians(?) - radians('longitude') ) + sin(radians(?) * sin( radians('longitude') ) ) ) AS 'distance' FROM 'kerja' HAVING 'distance < 5'";
      // $result = $this->db->query($awaka, array($lat, $long));
      // return $result;
    }
  }

 ?>
