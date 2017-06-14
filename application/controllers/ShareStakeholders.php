<?php
  /**
   *
   */
  Class ShareStakeholders extends CI_Controller
  {
    function __construct()
    {
      # code...
      parent:: __construct();
      // $this->load->helper('url');
    }
    function index()
    {
      # code...
      $this->load->view('vTracerStudyStakeholders.html');
    }
  }

 ?>
