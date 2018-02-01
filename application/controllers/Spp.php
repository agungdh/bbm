<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spp extends CI_Controller {
  function __construct(){
    parent::__construct();
    if ($this->session->status != "login") {
      redirect(base_url());
    }   
  }

  function index(){
    $this->load->view('template/template',array("isi" => "spp/tabel"));
  }

  function tambah(){
    $this->load->view('template/template',array("isi" => "spp/tambah"));
  }

  function hapus($id=null){
    $this->load->view('template/template',array("isi" => "spp/hapus", "data" => array("id" => $id)));
  }

  function sampai($id=null){
    $this->load->view('template/template',array("isi" => "spp/sampai", "data" => array("id" => $id)));
  }

  function ajax(){
    $requestData = $_REQUEST;
    $columns = array( 
        0 => 'namapelanggan',
          1 => 'nomorspp',
          2 => 'kwantitas',
          3 => 'tanggal'
    );

      $query = $this->db->query("SELECT count(*) total_data 
        FROM spp s, penawaran p, pelanggan pg
        WHERE s.id_penawaran=p.id
        and p.id_pelanggan=pg.id
        AND s.status=0");

      foreach ($query->result() as $rowC) { 
        $totalData = $rowC->total_data;
        $totalFiltered = $totalData; 
      } 

    $data = array();

    if( !empty($requestData['search']['value']) ) {
      $search_value = "%" . $requestData['search']['value'] . "%";

      $query = $this->db->query("SELECT count(*) total_data 
        FROM spp s, penawaran p, pelanggan pg
        WHERE s.id_penawaran=p.id
        and p.id_pelanggan=pg.id
        AND s.status=0 
        AND (s.nomorspp LIKE ? or pg.namapelanggan LIKE ?)",array($search_value, $search_value));

      foreach ($query->result() as $rowC) { 
        $totalFiltered = $rowC->total_data;
      } 

      $query = $this->db->query("SELECT s.id as id_spp, 
        pg.namapelanggan, s.nomorspp, s.kwantitas, s.tanggalspp, s.status 
        FROM spp s, penawaran p, pelanggan pg
        WHERE s.id_penawaran=p.id
        and p.id_pelanggan=pg.id
        AND s.status=0 
        AND (s.nomorspp LIKE ? or pg.namapelanggan LIKE ?) 
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length'],array($search_value, $search_value));
            
    } else {  

      $query = $this->db->query("SELECT s.id as id_spp, 
        pg.namapelanggan, s.nomorspp, s.kwantitas, s.tanggalspp, s.status  
        FROM spp s, penawaran p, pelanggan pg
        WHERE s.id_penawaran=p.id
        and p.id_pelanggan=pg.id
        AND s.status=0 ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']);
            
    }

    foreach ($query->result() as $row) { 
      $nestedData=array(); 
      $id_spp = $row->id_spp;
      $status = $row->status;
      $nestedData[] = $row->namapelanggan;
      $nestedData[] = $row->nomorspp;
      $nestedData[] = "<p align='right'>".number_format($row->kwantitas,0,',','.')."</p>";
      $nestedData[] = "<p align='right'>".date_format(date_create($row->tanggalspp),'d-m-Y')."</p>";
      $nestedData[] = "<p align='center'>
      <a href='".base_url('spp/hapus/').$id_spp."'><button class='btn btn-danger fa fa-trash' title=' Hapus SPP'></button></a>
      <a href='".base_url('spp/sampai/').$id_spp."'><button class='btn btn-warning fa fa-check' title=' SPP Terkirim'></button></a>
      <a target='_blank' href='".base_url('spp/cetak/').$id_spp."'><button class='btn btn-info fa fa-print' title=' Cetak SPP'></button></a>
      <a target='_blank' href='".base_url('spp/terima/').$id_spp."'><button class='btn btn-primary fa fa-print' title=' Cetak Tanda Terima'></button></a>
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

    $masaberlaku = date('Y-m-d');

    $query = $this->db->query("SELECT *, p.id as id_penawaran 
      FROM penawaran p, pelanggan pg 
      WHERE p.id_pelanggan=pg.id
      and p.masaberlaku>=?
      and ( pg.namapelanggan LIKE ? or p.alamatkirim like ?)",array($masaberlaku, $search_value, $search_value));

    foreach ( $query->result() as $row )
    {
      $json[] = ['id'=>$row->id_penawaran, 'text'=>$row->namapelanggan .' ('.$row->alamatkirim.')'  ];
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

  function cetak($id=null){
    $this->load->library('pdf/fpdf');

    $this->load->view('spp/cetak',array('id' => $id));
  }

  function terima($id=null){
    $this->load->library('pdf/fpdf');

    $this->load->view('spp/terima',array('id' => $id));
  }
}