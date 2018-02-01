<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kendaraan extends CI_Controller {
  function __construct(){
    parent::__construct();
    if ($this->session->status != "login") {
      redirect(base_url());
    }   
  }

  function index(){
    $this->load->view('template/template',array("isi" => "kendaraan/tabel"));
  }

  function tambah(){
    $this->load->view('template/template',array("isi" => "kendaraan/tambah"));
  }

  function ubah($id=null){
    $this->load->view('template/template',array("isi" => "kendaraan/ubah", "data" => array("id" => $id)));
  }

  function hapus($id=null){
    $this->load->view('template/template',array("isi" => "kendaraan/hapus", "data" => array("id" => $id)));
  }

// AJAX konsumen
  function ajax(){
    $requestData = $_REQUEST;
    $columns = array( 
        0 => 'nomorkendaraan'
    );

      $query = $this->db->query("SELECT count(*) total_data 
        FROM kendaraan");

      foreach ($query->result() as $rowC) { 
        $totalData = $rowC->total_data;
        $totalFiltered = $totalData; 
      } 

    $data = array();

    if( !empty($requestData['search']['value']) ) {
      $search_value = "%" . $requestData['search']['value'] . "%";

      $query = $this->db->query("SELECT count(*) total_data 
        FROM kendaraan
        WHERE (nomorkendaraan LIKE ? )",array($search_value));

      foreach ($query->result() as $rowC) { 
        $totalFiltered = $rowC->total_data;
      } 

      $query = $this->db->query("SELECT *
        FROM kendaraan
        WHERE (nomorkendaraan LIKE ? )
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length'],array($search_value));
            
    } else {  

      $query = $this->db->query("SELECT *
        FROM kendaraan
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']);
            
    }

    foreach ($query->result() as $row) { 
      $nestedData=array(); 
      $id = $row->id;
      $nestedData[] = $row->nomorkendaraan;
      $nestedData[] = "<p align='center'>
      <a href='".base_url('kendaraan/ubah/').$id."'><button class='btn btn-success fa fa-check' title=' Ubah KENDARAAN'></button></a>
      <a href='".base_url('kendaraan/hapus/').$id."'><button class='btn btn-danger fa fa-trash' title=' Hapus KENDARAAN'></button></a>
      </p>";      

      $data[] = $nestedData;
        
    }

    $json_data = array(
          "draw"            => intval( $requestData['draw'] ),    
          "recordsTotal"    => intval( $totalData ), 
          "recordsFiltered" => intval( $totalFiltered ), 
          "data"            => $data   
          );

    echo json_encode($json_data);  
  }
  
}