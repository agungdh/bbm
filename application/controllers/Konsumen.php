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
  
// AJAX ISI konsumen
  function ajaxinvoice(){
    $requestData = $_REQUEST;
    $columns = array( 
        0 => 'nomorspp',
          1 => 'tanggalspp',
          2 => 'kwantitas',
          3 => 'totalharga'
    );

      $query = $this->db->query("SELECT count(*) total_data 
        FROM isi_invoice ii, spp s
        WHERE ii.id_spp=s.id");

      foreach ($query->result() as $rowC) { 
        $totalData = $rowC->total_data;
        $totalFiltered = $totalData; 
      } 

    $data = array();

    if( !empty($requestData['search']['value']) ) {
      $search_value = "%" . $requestData['search']['value'] . "%";

      $query = $this->db->query("SELECT count(*) total_data 
        FROM isi_invoice ii, spp s
        WHERE ii.id_spp=s.id 
        AND (s.nomorspp LIKE ? or s.tanggalspp LIKE ?)",array($search_value, $search_value));

      foreach ($query->result() as $rowC) { 
        $totalFiltered = $rowC->total_data;
      } 

      $query = $this->db->query("SELECT s.nomorspp, s.tanggalspp, s.kwantitas, ii.totalharga,
        ii.id as id_nospp 
        FROM isi_invoice ii, spp s
        WHERE ii.id_spp=s.id 
        AND (s.nomorspp LIKE ? or s.tanggalspp LIKE ?) 
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length'],array($search_value, $search_value));
            
    } else {  

      $query = $this->db->query("SELECT s.nomorspp, s.tanggalspp, s.kwantitas, ii.totalharga,
        ii.id as id_nospp 
        FROM isi_invoice ii, spp s
        WHERE ii.id_spp=s.id ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']);
            
    }

    foreach ($query->result() as $row) { 
      $nestedData=array(); 
      $id_nospp = $row->id_nospp;
      $nestedData[] = $row->nomorspp;
      $nestedData[] = "<p align='right'>".date_format(date_create($row->tanggalspp),'d-m-Y')."</p>";
      $nestedData[] = "<p align='right'>".number_format($row->kwantitas,0,',','.')."</p>";
      $nestedData[] = "<p align='right'>".number_format($row->totalharga,0,',','.')."</p>";
      $nestedData[] = "<p align='center'>
      <a href='".base_url('konsumen/ubahspp/').$id_nospp."'><button class='btn btn-success fa fa-check' title=' Ubah DATA konsumen'></button></a>
      <a href='".base_url('konsumen/hapusspp/').$id_nospp."'><button class='btn btn-danger fa fa-trash' title=' Hapus konsumen'></button></a>
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
  
// DATA SPP
  function ajaxspp(){
    $json = [];

    $search_value = "%" . $this->input->get('q') . "%";

    $query = $this->db->query("SELECT *, s.id as id_spp 
      FROM spp s, penawaran p, pelanggan pg
      WHERE s.id_penawaran=p.id
      and p.id_pelanggan=pg.id 
      and s.status=1
      AND (s.nomorspp LIKE ? or pg.namapelanggan LIKE ?)"
      ,array($search_value, $search_value));

    foreach ( $query->result() as $row )
    {
      $json[] = ['id'=>$row->id_spp, 'text'=>$row->nomorspp.': '.$row->namapelanggan.
      ' Tgl:'.date_format(date_create($row->tanggalspp),'d-m-Y') ];
    } 


  echo json_encode($json);
  }  

  function cetak($id=null){
    $this->load->library('pdf/fpdf');

    $this->load->view('konsumen/cetak',array('id' => $id));
  }

  function kwitansi($id=null){
    $this->load->library('pdf/fpdf');
    //$this->load->library('ciqrcode'); 

    $this->load->view('konsumen/kwitansi',array('id' => $id));
  }
}