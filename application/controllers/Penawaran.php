<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penawaran extends CI_Controller {
  function __construct(){
    parent::__construct();
    if ($this->session->status != "login") {
      redirect(base_url());
    }   
  }

  function index(){
    $this->load->view('template/template',array("isi" => "penawaran/tabel"));
  }

  function tambah(){
    $this->load->view('template/template',array("isi" => "penawaran/tambah"));
  }

  function hapus($id=null){
    $this->load->view('template/template',array("isi" => "penawaran/hapus", "data" => array("id" => $id)));
  }

  function ajax(){
    $requestData = $_REQUEST;
    $columns = array( 
        0 => 'namapelanggan',
          1 => 'alamatkirim',
          2 => 'hargadasar',
          3 => 'masaberlaku'
    );

      $query = $this->db->query("SELECT count(*) total_data 
        FROM penawaran pn, pelanggan p
        WHERE pn.id_pelanggan=p.id");

      foreach ($query->result() as $rowC) { 
        $totalData = $rowC->total_data;
        $totalFiltered = $totalData; 
      } 

    $data = array();

    if( !empty($requestData['search']['value']) ) {
      $search_value = "%" . $requestData['search']['value'] . "%";

      $query = $this->db->query("SELECT count(*) total_data 
        FROM penawaran pn, pelanggan p
        WHERE pn.id_pelanggan=p.id
        AND (p.namapelanggan LIKE ? or pn.alamatkirim LIKE ?)",array($search_value, $search_value));

      foreach ($query->result() as $rowC) { 
        $totalFiltered = $rowC->total_data;
      } 

      $query = $this->db->query("SELECT *,pn.id as id_penawaran 
        FROM penawaran pn, pelanggan p
        WHERE pn.id_pelanggan=p.id
        AND (pn.alamatkirim LIKE ? or p.namapelanggan LIKE ?) 
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length'],array($search_value, $search_value));
            
    } else {  

      $query = $this->db->query("SELECT *,pn.id as id_penawaran 
        FROM penawaran pn, pelanggan p
        WHERE pn.id_pelanggan=p.id 
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']);
            
    }

    foreach ($query->result() as $row) { 
      $nestedData=array(); 
      $id_penawaran = $row->id_penawaran;
      $nestedData[] = $row->namapelanggan;
      $nestedData[] = $row->alamatkirim;
      $nestedData[] = "<p align='right'>".number_format($row->hargadasar,0,',','.')."</p>";
      $nestedData[] = "<p align='right'>".date_format(date_create($row->masaberlaku),'d-m-Y')."</p>";
      $nestedData[] = "<p align='center'>
      <a href='".base_url('penawaran/hapus/').$id_penawaran."'><button class='btn btn-danger fa fa-trash' title=' Hapus PENAWARAN'></button></a>
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
  
// DATA PELANGGAN
  function ajaxpelanggan(){
    $json = [];

    $search_value = "%" . $this->input->get('q') . "%";

    $query = $this->db->query("SELECT * FROM pelanggan
      WHERE namapelanggan LIKE ?",array($search_value));

    foreach ( $query->result() as $row )
    {
      $json[] = ['id'=>$row->id, 'text'=>$row->namapelanggan ];
    } 


  echo json_encode($json);
  }  

// DATA KENDARAAN
  function ajaxkendaraan(){
    $json = [];

    $search_value = "%" . $this->input->get('q') . "%";

    $query = $this->db->query("SELECT * FROM kendaraan
      WHERE nomorkendaraan LIKE ?",array($search_value));

    foreach ( $query->result() as $row )
    {
      $json[] = ['id'=>$row->id, 'text'=>$row->nomorkendaraan ];
    } 


  echo json_encode($json);
  }  

// DATA SOPIR
  function ajaxsopir(){
    $json = [];

    $search_value = "%" . $this->input->get('q') . "%";

    $query = $this->db->query("SELECT * FROM sopir
      WHERE namasopir LIKE ?",array($search_value));

    foreach ( $query->result() as $row )
    {
      $json[] = ['id'=>$row->id, 'text'=>$row->namasopir ];
    } 

  echo json_encode($json);
  } 

// DATA PRODUK
  function ajaxproduk(){
    $json = [];

    $search_value = "%" . $this->input->get('q') . "%";

    $query = $this->db->query("SELECT * FROM produk
      WHERE namaproduk LIKE ?",array($search_value));

    foreach ( $query->result() as $row )
    {
      $json[] = ['id'=>$row->id, 'text'=>$row->namaproduk . ' Rp ' . number_format($row->hargaproduk,0,',','.')  ];
    } 

  echo json_encode($json);
  }  

}