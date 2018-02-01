<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konsumen extends CI_Controller {
  function __construct(){
    parent::__construct();
    if ($this->session->status != "login") {
      redirect(base_url());
    }   
  }

  function index(){
    $this->load->view('template/template',array("isi" => "konsumen/tabel"));
  }

  function tambah(){
    $this->load->view('template/template',array("isi" => "konsumen/tambah"));
  }

  function ubah($id=null){
    $this->load->view('template/template',array("isi" => "konsumen/ubah", "data" => array("id" => $id)));
  }

  function hapus($id=null){
    $this->load->view('template/template',array("isi" => "konsumen/hapus", "data" => array("id" => $id)));
  }

// AJAX konsumen
  function ajax(){
    $requestData = $_REQUEST;
    $columns = array( 
        0 => 'namapelanggan',
          1 => 'alamatpelanggan',
          2 => 'kota',
          3 => 'npwp'
    );

      $query = $this->db->query("SELECT count(*) total_data 
        FROM pelanggan");

      foreach ($query->result() as $rowC) { 
        $totalData = $rowC->total_data;
        $totalFiltered = $totalData; 
      } 

    $data = array();

    if( !empty($requestData['search']['value']) ) {
      $search_value = "%" . $requestData['search']['value'] . "%";

      $query = $this->db->query("SELECT count(*) total_data 
        FROM pelanggan
        WHERE (namapelanggan LIKE ? or alamatpelanggan LIKE ? or kota LIKE ? or npwp LIKE ? )",array($search_value, $search_value, $search_value, $search_value));

      foreach ($query->result() as $rowC) { 
        $totalFiltered = $rowC->total_data;
      } 

      $query = $this->db->query("SELECT *
        FROM pelanggan
        WHERE (namapelanggan LIKE ? or alamatpelanggan LIKE ? or kota LIKE ? or npwp LIKE ? )
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length'],array($search_value, $search_value, $search_value, $search_value));
            
    } else {  

      $query = $this->db->query("SELECT *
        FROM pelanggan
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']);
            
    }

    foreach ($query->result() as $row) { 
      $nestedData=array(); 
      $id = $row->id;
      $nestedData[] = $row->namapelanggan;
      $nestedData[] = $row->alamatpelanggan;
      $nestedData[] = $row->kota;
      $nestedData[] = $row->npwp;
      $nestedData[] = "<p align='center'>
      <a href='".base_url('konsumen/ubah/').$id."'><button class='btn btn-success fa fa-check' title=' Ubah KONSUMEN'></button></a>
      <a href='".base_url('konsumen/hapus/').$id."'><button class='btn btn-danger fa fa-trash' title=' Hapus KONSUMEN'></button></a>
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