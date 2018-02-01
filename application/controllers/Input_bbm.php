<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input_bbm extends CI_Controller {
  function __construct(){
    parent::__construct();
    if ($this->session->status != "login") {
      redirect(base_url());
    }   
  }

  function index(){
    $this->load->view('template/template',array("isi" => "input_bbm/tabel"));
  }

  function tambah(){
    $this->load->view('template/template',array("isi" => "input_bbm/tambah"));
  }

  function hapus($id=null){
    $this->load->view('template/template',array("isi" => "input_bbm/hapus", "data" => array("id" => $id)));
  }

// AJAX konsumen
  function ajax(){
    $requestData = $_REQUEST;
    $columns = array( 
        0 => 'no_faktur',
        1 => 'tanggal',
        2 => 'masuk',
    );

      $query = $this->db->query("SELECT count(*) total_data 
        FROM mutasiproduk");

      foreach ($query->result() as $rowC) { 
        $totalData = $rowC->total_data;
        $totalFiltered = $totalData; 
      } 

    $data = array();

    if( !empty($requestData['search']['value']) ) {
      $search_value = "%" . $requestData['search']['value'] . "%";

      $query = $this->db->query("SELECT count(*) total_data 
        FROM mutasiproduk
        WHERE (no_faktur LIKE ? or tanggal LIKE ? or masuk LIKE ? )",array($search_value,$search_value,$search_value));

      foreach ($query->result() as $rowC) { 
        $totalFiltered = $rowC->total_data;
      } 

      $query = $this->db->query("SELECT *
        FROM mutasiproduk
        WHERE (no_faktur LIKE ? or tanggal LIKE ? or masuk LIKE ? )
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length'],array($search_value,$search_value,$search_value));
            
    } else {  

      $query = $this->db->query("SELECT *
        FROM mutasiproduk
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']);
            
    }

    foreach ($query->result() as $row) { 
      $nestedData=array(); 
      $id = $row->id;
      $nestedData[] = $row->no_faktur;
      $nestedData[] = date_format(date_create($row->tanggal),'d-m-Y');
      $nestedData[] = $row->masuk;
      $nestedData[] = "<p align='center'>
      <a href='".base_url('input_bbm/hapus/').$id."'><button class='btn btn-danger fa fa-trash' title=' Hapus SOPIR'></button></a>
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