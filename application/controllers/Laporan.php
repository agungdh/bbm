<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
  function __construct(){
    parent::__construct();
    if ($this->session->status != "login") {
      redirect(base_url());
    }   
  }

  function index(){
    $this->load->view('template/template',array("isi" => "laporan/tabel"));
  }

  function stok(){
    $this->load->view('template/template',array("isi" => "laporan/stok"));
  }

  function masuk(){
    $this->load->view('template/template',array("isi" => "laporan/masuk"));
  }

  function keluar(){
    $this->load->view('template/template',array("isi" => "laporan/keluar"));
  }

// TAGIHAN ==============
  function ajax(){
    $requestData = $_REQUEST;
    $columns = array( 
        0 => 'namapelanggan',
          1 => 'nomorinvoice',
          2 => 'totaltagihan',
          3 => 'jatuhtempo'
    );

      $query = $this->db->query("SELECT count(*) total_data 
        FROM isi_invoice ii, invoice i, spp sp, penawaran p, pelanggan pg
        WHERE ii.id_invoice=i.id
        and i.id_spp=sp.id
        and sp.id_penawaran=p.id
        AND p.id_pelanggan=pg.id
        AND i.statusbayar=0");

      foreach ($query->result() as $rowC) { 
        $totalData = $rowC->total_data;
        $totalFiltered = $totalData; 
      } 

    $data = array();

    if( !empty($requestData['search']['value']) ) {
      $search_value = "%" . $requestData['search']['value'] . "%";

      $query = $this->db->query("SELECT count(*) total_data 
        FROM isi_invoice ii, invoice i, spp sp, penawaran p, pelanggan pg
        WHERE ii.id_invoice=i.id
        and i.id_spp=sp.id
        and sp.id_penawaran=p.id
        AND p.id_pelanggan=pg.id
        AND i.statusbayar=0 
        AND (i.nomorinvoice LIKE ? or pg.namapelanggan LIKE ?)",array($search_value, $search_value));

      foreach ($query->result() as $rowC) { 
        $totalFiltered = $rowC->total_data;
      } 

      $query = $this->db->query("SELECT *,i.id as id_invoice 
        FROM isi_invoice ii, invoice i, spp sp, penawaran p, pelanggan pg
        WHERE ii.id_invoice=i.id
        and i.id_spp=sp.id
        and sp.id_penawaran=p.id
        AND p.id_pelanggan=pg.id
        AND i.statusbayar=0 
        AND (i.nomorinvoice LIKE ? or pg.namapelanggan LIKE ?) 
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length'],array($search_value, $search_value));
            
    } else {  

      $query = $this->db->query("SELECT *,i.id as id_invoice 
        FROM isi_invoice ii, invoice i, spp sp, penawaran p, pelanggan pg
        WHERE ii.id_invoice=i.id
        and i.id_spp=sp.id
        and sp.id_penawaran=p.id
        AND p.id_pelanggan=pg.id
        AND i.statusbayar=0  ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']);
            
    }

    foreach ($query->result() as $row) { 
      $nestedData=array(); 
      $id_invoice = $row->id_invoice;
      $nestedData[] = $row->namapelanggan;
      $nestedData[] = $row->nomorinvoice;
      $nestedData[] = "<p align='right'>".number_format($row->totaltagihan,0,',','.')."</p>";
      $nestedData[] = "<p align='right'>".date_format(date_create($row->jatuhtempo),'d-m-Y')."</p>";

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
  
// STOK ==============
  function ajaxstok(){
    $requestData = $_REQUEST;
    $columns = array( 
        0 => 'namaproduk',
          1 => 'hargaproduk',
          2 => 'stok',
          3 => 'totalharga'
    );

      $query = $this->db->query("SELECT count(*) total_data 
        FROM produk");

      foreach ($query->result() as $rowC) { 
        $totalData = $rowC->total_data;
        $totalFiltered = $totalData; 
      } 

    $data = array();

    if( !empty($requestData['search']['value']) ) {
      $search_value = "%" . $requestData['search']['value'] . "%";

      $query = $this->db->query("SELECT count(*) total_data 
        FROM produk
        WHERE namaproduk LIKE ?",array($search_value));

      foreach ($query->result() as $rowC) { 
        $totalFiltered = $rowC->total_data;
      } 

      $query = $this->db->query("SELECT * 
        FROM produk
        WHERE namaproduk LIKE ?  
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length'],array($search_value));
            
    } else {  

      $query = $this->db->query("SELECT * 
        FROM produk
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']);
            
    }

    foreach ($query->result() as $row) { 
      $nestedData=array(); 
      $id = $row->id;
      $nestedData[] = $row->namaproduk;
      $nestedData[] = "<p align='right'>".number_format($row->hargaproduk,0,',','.')."</p>";
      $nestedData[] = "<p align='right'>".number_format($row->stok,0,',','.')."</p>";
      $nestedData[] = "<p align='right'>".number_format($row->hargaproduk * $row->stok,0,',','.')."</p>";

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
  
// BBM KELUAR ==============
  function ajaxkeluar(){
    $requestData = $_REQUEST;
    $columns = array( 
        0 => 'namaproduk',
          1 => 'tanggalspp',
          2 => 'keluar',
          3 => 'nomorspp'
    );

      $query = $this->db->query("SELECT count(*) total_data 
        FROM mutasiproduk mp, spp s, produk p
        WHERE mp.id_spp=s.id
        AND mp.id_produk=p.id");

      foreach ($query->result() as $rowC) { 
        $totalData = $rowC->total_data;
        $totalFiltered = $totalData; 
      } 

    $data = array();

    if( !empty($requestData['search']['value']) ) {
      $search_value = "%" . $requestData['search']['value'] . "%";

      $query = $this->db->query("SELECT count(*) total_data 
        FROM mutasiproduk mp, spp s, produk p
        WHERE mp.id_spp=s.id
        AND mp.id_produk=p.id
        ANAD p.namaproduk LIKE ?",array($search_value));

      foreach ($query->result() as $rowC) { 
        $totalFiltered = $rowC->total_data;
      } 

      $query = $this->db->query("SELECT * 
        FROM mutasiproduk mp, spp s, produk p
        WHERE mp.id_spp=s.id
        AND mp.id_produk=p.id
        ANAD p.namaproduk LIKE ?  
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length'],array($search_value));
            
    } else {  

      $query = $this->db->query("SELECT * 
        FROM mutasiproduk mp, spp s, produk p
        WHERE mp.id_spp=s.id
        AND mp.id_produk=p.id
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']);
            
    }

    foreach ($query->result() as $row) { 
      $nestedData=array(); 
      $id = $row->id;
      $nestedData[] = $row->namaproduk;
      $nestedData[] = "<p align='right'>".date_format(date_create($row->tanggalspp),'d-m-Y')."</p>";
      $nestedData[] = "<p align='right'>".number_format($row->keluar,0,',','.')."</p>";
      $nestedData[] = $row->nomorspp;

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
  
// BBM MASUK ==============
  function ajaxmasuk(){
    $requestData = $_REQUEST;
    $columns = array( 
        0 => 'namaproduk',
          1 => 'tanggalspp',
          2 => 'masuk',
          3 => 'nomorspp'
    );

      $query = $this->db->query("SELECT count(*) total_data 
        FROM mutasiproduk mp, spp s, produk p
        WHERE mp.id_spp=s.id
        AND mp.id_produk=p.id");

      foreach ($query->result() as $rowC) { 
        $totalData = $rowC->total_data;
        $totalFiltered = $totalData; 
      } 

    $data = array();

    if( !empty($requestData['search']['value']) ) {
      $search_value = "%" . $requestData['search']['value'] . "%";

      $query = $this->db->query("SELECT count(*) total_data 
        FROM mutasiproduk mp, spp s, produk p
        WHERE mp.id_spp=s.id
        AND mp.id_produk=p.id
        ANAD p.namaproduk LIKE ?",array($search_value));

      foreach ($query->result() as $rowC) { 
        $totalFiltered = $rowC->total_data;
      } 

      $query = $this->db->query("SELECT * 
        FROM mutasiproduk mp, spp s, produk p
        WHERE mp.id_spp=s.id
        AND mp.id_produk=p.id
        ANAD p.namaproduk LIKE ?  
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length'],array($search_value));
            
    } else {  

      $query = $this->db->query("SELECT * 
        FROM mutasiproduk mp, spp s, produk p
        WHERE mp.id_spp=s.id
        AND mp.id_produk=p.id
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']);
            
    }

    foreach ($query->result() as $row) { 
      $nestedData=array(); 
      $id = $row->id;
      $nestedData[] = $row->namaproduk;
      $nestedData[] = "<p align='right'>".date_format(date_create($row->tanggalspp),'d-m-Y')."</p>";
      $nestedData[] = "<p align='right'>".number_format($row->masuk,0,',','.')."</p>";
      $nestedData[] = $row->nomorspp;

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