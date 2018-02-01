<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {
  function __construct(){
    parent::__construct();
    if ($this->session->status != "login") {
      redirect(base_url());
    }   
  }

  function index(){
    $this->load->view('template/template',array("isi" => "invoice/tabel"));
  }

  function tambah(){
    $this->load->view('template/template',array("isi" => "invoice/tambah"));
  }

  function hapus($id=null){
    $this->load->view('template/template',array("isi" => "invoice/hapus", "data" => array("id" => $id)));
  }

  function bayar($id=null){
    $this->load->view('template/template',array("isi" => "invoice/bayar", "data" => array("id" => $id)));
  }

  function spp($id=null){
    $this->load->view('template/template',array("isi" => "invoice/spp", "data" => array("id" => $id)));
  }

  function isi_invoice($id=null){
    $this->load->view('template/template',array("isi" => "invoice/isi_invoice", "data" => array("id" => $id)));
  }

  function tambahspp($id=null){
    $this->load->view('template/template',array("isi" => "invoice/tambahspp", "data" => array("id" => $id)));
  }

  function hapusspp($id=null,$id_invoice=null){
    $this->load->view('template/template',array("isi" => "invoice/hapusspp", "data" => array("id" => $id, "id_invoice" => $id_invoice)));
  }

  function ubahspp($id=null,$id_invoice=null){
    $this->load->view('template/template',array("isi" => "invoice/ubahspp", "data" => array("id" => $id, "id_invoice" => $id_invoice)));
  }

// AJAX INVOICE
  function ajax(){
    $requestData = $_REQUEST;
    $columns = array( 
        0 => 'namapelanggan',
          1 => 'nomorinvoice',
          2 => 'totaltagihan',
          3 => 'jatuhtempo'
    );

      $query = $this->db->query("SELECT count(*) total_data 
        FROM invoice i, spp s, penawaran p, pelanggan pg
        WHERE i.id_spp=s.id
        and i.statusbayar=0
        and s.id_penawaran=p.id
        and p.id_pelanggan=pg.id");

      foreach ($query->result() as $rowC) { 
        $totalData = $rowC->total_data;
        $totalFiltered = $totalData; 
      } 

    $data = array();

    if( !empty($requestData['search']['value']) ) {
      $search_value = "%" . $requestData['search']['value'] . "%";

      $query = $this->db->query("SELECT count(*) total_data 
        FROM invoice i, spp s, penawaran p, pelanggan pg
        WHERE i.id_spp=s.id
        and i.statusbayar=0
        and s.id_penawaran=p.id
        and p.id_pelanggan=pg.id 
        AND (i.nomorinvoice LIKE ? or pg.namapelanggan LIKE ?)",array($search_value, $search_value));

      foreach ($query->result() as $rowC) { 
        $totalFiltered = $rowC->total_data;
      } 

      $query = $this->db->query("SELECT *,i.id as id_invoice 
        FROM invoice i, spp s, penawaran p, pelanggan pg
        WHERE i.id_spp=s.id
        and i.statusbayar=0
        and s.id_penawaran=p.id
        and p.id_pelanggan=pg.id 
        AND (i.nomorinvoice LIKE ? or pg.namapelanggan LIKE ?) 
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length'],array($search_value, $search_value));
            
    } else {  

      $query = $this->db->query("SELECT *,i.id as id_invoice 
        FROM invoice i, spp s, penawaran p, pelanggan pg
        WHERE i.id_spp=s.id
        and i.statusbayar=0
        and s.id_penawaran=p.id
        and p.id_pelanggan=pg.id ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']);
            
    }

    foreach ($query->result() as $row) { 
      $nestedData=array(); 
      $id_invoice = $row->id_invoice;
      $nestedData[] = $row->namapelanggan;
      $nestedData[] = $row->nomorinvoice;
      $nestedData[] = "<p align='right'>".number_format($row->totaltagihan,0,',','.')."</p>";
      $nestedData[] = "<p align='right'>".date_format(date_create($row->jatuhtempo),'d-m-Y')."</p>";
      $nestedData[] = "<p align='center'>
      <a href='".base_url('invoice/hapus/').$id_invoice."'><button class='btn btn-danger fa fa-trash' title=' Hapus INVOICE'></button></a>
      <a href='".base_url('invoice/isi_invoice/').$id_invoice."'><button class='btn btn-primary fa fa-cubes' title=' Data SPP'></button></a>
      <a href='".base_url('invoice/bayar/').$id_invoice."'><button class='btn btn-warning fa fa-check' title=' INVOICE Terkirim'></button></a>

      <a target='_blank' href='".base_url('invoice/cetak/').$id_invoice."'><button class='btn btn-info fa fa-print' title=' Cetak INVOICE'></button></a>
      <a target='_blank' href='".base_url('invoice/kwitansi/').$id_invoice."'><button class='btn btn-primary fa fa-print' title=' Cetak Tanda Terima'></button></a>
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
  
// AJAX ISI INVOICE
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
      <a href='".base_url('invoice/ubahspp/').$id_nospp."'><button class='btn btn-success fa fa-check' title=' Ubah DATA INVOICE'></button></a>
      <a href='".base_url('invoice/hapusspp/').$id_nospp."'><button class='btn btn-danger fa fa-trash' title=' Hapus INVOICE'></button></a>
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

    $this->load->view('invoice/cetak',array('id' => $id));
  }

  function kwitansi($id=null){
    $this->load->library('pdf/fpdf');
    //$this->load->library('ciqrcode'); 

    $this->load->view('invoice/kwitansi',array('id' => $id));
  }
}