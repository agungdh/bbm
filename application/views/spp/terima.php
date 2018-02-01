<?php
// --------------------------------
      $query = $this->db->query("SELECT *
        FROM spp s, penawaran p, pelanggan pg, sopir sp, kendaraan k
        WHERE s.id_penawaran=p.id 
        AND p.id_pelanggan=pg.id
        AND s.id_sopir=sp.id
        AND s.id_kendaraan=k.id
        AND s.id=?",array($id));
            
    foreach ($query->result() as $row) { 
      $blspp = date_format(date_create($row->tanggalspp),'m');
      if ($blspp=='01') { $blspp ='I';}
      if ($blspp=='02') { $blspp ='II';}
      if ($blspp=='03') { $blspp ='III';}
      if ($blspp=='04') { $blspp ='IV';}
      if ($blspp=='05') { $blspp ='V';}
      if ($blspp=='06') { $blspp ='VI';}
      if ($blspp=='07') { $blspp ='VII';}
      if ($blspp=='08') { $blspp ='VIII';}
      if ($blspp=='09') { $blspp ='IX';}
      if ($blspp=='10') { $blspp ='X';}
      if ($blspp=='11') { $blspp ='XI';}
      if ($blspp=='12') { $blspp ='XII';}
      $thspp = date_format(date_create($row->tanggalspp),'Y');
      $nomorspp = $row->nomorspp . ' /EKElpg/TT-Fuel/'.$blspp.'/'. $thspp ;
      $tanggalspp = date_format(date_create($row->tanggalspp),'d-m-Y');
      $tanggalspp1 = date_format(date_create($row->tanggalspp),'Y-m-d');
      $nopo = $row->nopo;
      $tanggalpo = date_format(date_create($row->tanggalpo),'d-m-Y');
      $namapelanggan = $row->namapelanggan;
      $alamatkirim = $row->alamatkirim;
      $kota = $row->kota;
      $npwp = $row->npwp;
      $namasopir = $row->namasopir;
      $namakenek = $row->namakenek;
      $segelatas = $row->segelatas;
      $segelbawah = $row->segelbawah;
      $kwantitas = $row->kwantitas;
      $nomorkendaraan = $row->nomorkendaraan;
      $beratjenis = $row->beratjenis;
      $temperatur = $row->temperatur;
    }
//-------------------------

	$pdf = new FPDF('L','mm','A4');	

	$pdf->AliasNbPages();
	$pdf->AddPage();

    $pdf->Image(base_url('assets/logo/logo.jpg'),15,20,25);

	$pdf->ln(10);
    $pdf->Cell(30);
    $pdf->SetFont('Arial','',14);
	$pdf->Cell(80,5,'PT. EDELWEIS KALASHNIKOV ENERGY',0,0,'L');

	$pdf->ln();
    $pdf->Cell(30);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,5,'BU-PIUNU',0,0,'L');
	$pdf->Cell(100,5,'',0,0,'L');
	$pdf->Cell(100,5,'AGEN PEMASARAN',0,0,'C');

	$pdf->ln();
    $pdf->Cell(30);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,5,'0513/10/DJM.0/2018',0,0,'L');
	$pdf->Cell(100,5,'',0,0,'L');
	$pdf->Cell(100,5,'PT. EDELWEIS KALASHNIKOV ENERGY',0,0,'C');

	$pdf->ln();
    $pdf->Cell(30);
	$pdf->Cell(30,5,'TRANSPORTIR BBM',0,0,'L');
	$pdf->Cell(100,5,'',0,0,'L');
	$pdf->Cell(100,5,'WILAYAH LAMPUNG',0,0,'C');

	$pdf->ln();
    $pdf->Cell(30);
	$pdf->Cell(30,5,'05.AD.03.22.17.1260',0,0,'L');

	$pdf->ln(15);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','BU',18);
	$pdf->Cell(270,8,'TANDA TERIMA BARANG',0,0,'C');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',12);
	$pdf->Cell(270,5,'NOMOR SURAT JALAN : '.$nomorspp,0,0,'C');

// ------------------------------------------
	$pdf->ln(10);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',12);
	$pdf->Cell(30,5,'PENERIMA',0,0,'L');
	$pdf->Cell(92,5,': '.$namapelanggan,0,0,'L');
	$pdf->Cell(20,5,'',0,0,'L');
	$pdf->Cell(30,5,'PENGIRIM',0,0,'L');
	$pdf->Cell(90,5,': PT. EDELWEIS KALASHNIKOV ENERGY',0,0,'L');

//+++++++++++++++++++

	$pdf->ln();
    $pdf->Cell(5);

	$start_awal	=$pdf->GetX(); 
	$get_x 	= $pdf->GetX();
	$get_y	= $pdf->GetY();

	$pdf->MultiCell(30,5,'ALAMAT',0,'L');
	$get_x += 30;                           
	$pdf->SetXY($get_x, $get_y);

	$pdf->MultiCell(2,5,': ',0,'L');
	$get_x += 2;                           
	$pdf->SetXY($get_x, $get_y);

	$pdf->MultiCell(90,5,$alamatkirim,0,'L');
	$get_x += 90;                           
	$pdf->SetXY($get_x, $get_y);

	$pdf->MultiCell(20,5,'',0,'L');
	$get_x += 20;                           
	$pdf->SetXY($get_x, $get_y);

	$pdf->MultiCell(30,5,'ALAMAT',0,'L');
	$get_x += 30;                           
	$pdf->SetXY($get_x, $get_y);

	$pdf->MultiCell(2,5,': ',0,'L');
	$get_x += 2;                           
	$pdf->SetXY($get_x, $get_y);

	$pdf->MultiCell(90,5,'Jl. Melinting No.06 RT.035 RW.012, Kelurahan Ganjar Agung, Kecamatan Metro Barat, Metro Lampung',0,'L');

// ------------------------------------------
	$pdf->ln(10);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',10);
	$pdf->Cell(35,8,'NAMA BARANG',1,0,'L');
	$pdf->Cell(75,8,'SOLAR HSD',1,0,'L');

	$get_x 	= $pdf->GetX();
	$get_y	= $pdf->GetY();

	$pdf->Cell(150,8,'','TR',0,'L');

	$pdf->ln(8);
    $pdf->Cell(5);
	$pdf->Cell(35,8,'NOMOR POLISI',1,0,'L');
	$pdf->Cell(75,8,' '.$nomorkendaraan,1,0,'L');
	$pdf->Cell(150,8,'','R',0,'L');

	$pdf->ln(8);
    $pdf->Cell(5);
	$pdf->Cell(35,8,'NOMOR SEGEL',1,0,'L');
	$pdf->Cell(75,8,' '.$segelatas .' - '. $segelbawah,1,0,'L');
	$pdf->Cell(150,8,'','R',0,'L');

	$pdf->ln(8);
    $pdf->Cell(5);
	$pdf->Cell(35,8,'JUMLAH BARANG',1,0,'L');
	$pdf->Cell(75,8,' '.number_format($kwantitas,0,',','.').' Liter',1,0,'L');
	$pdf->Cell(150,8,'','BR',0,'L');

	$hari   = date('N', strtotime($tanggalspp1));
	if ( $hari == 1 ) { $hi = 'Senin'; }
	if ( $hari == 2 ) { $hi = 'Selasa'; }
	if ( $hari == 3 ) { $hi = 'Rabu'; }
	if ( $hari == 4 ) { $hi = 'Kamis'; }
	if ( $hari == 5 ) { $hi = 'Jumat'; }
	if ( $hari == 6 ) { $hi = 'Sabtu'; }
	if ( $hari == 7 ) { $hi = 'Minggu'; }

	$bulan   = substr($tanggalspp,3,2);
	if ( $bulan == '01' ) { $bi = 'Januari'; }
	if ( $bulan == '02' ) { $bi = 'Pebruari'; }
	if ( $bulan == '03' ) { $bi = 'Maret'; }
	if ( $bulan == '04' ) { $bi = 'April'; }
	if ( $bulan == '05' ) { $bi = 'Mei'; }
	if ( $bulan == '06' ) { $bi = 'Juni'; }
	if ( $bulan == '07' ) { $bi = 'Juli'; }
	if ( $bulan == '08' ) { $bi = 'Agustus'; }
	if ( $bulan == '09' ) { $bi = 'September'; }
	if ( $bulan == '10' ) { $bi = 'Oktober'; }
	if ( $bulan == '11' ) { $bi = 'Nopember'; }
	if ( $bulan == '12' ) { $bi = 'Desember'; }


	$pdf->SetXY($get_x, $get_y);
	$pdf->MultiCell(150,8,'Pada hari '.$hi.' tanggal '.substr($tanggalspp,0,2).' bulan '.$bi.' tahun '.substr($tanggalspp,6,4).' telah diadakan serah terima barang/ material dari PT. EDELWEIS KALASHNIKOV ENERGY kepada '.$namapelanggan.' (Sesuai dengan Nomor Purchase Order (PO): '.$nopo.' tanggal '.$tanggalpo.') ',0,'J');

	$pdf->ln(20);
    $pdf->Cell(5);
	$pdf->Cell(75,8,'Pihak Pengirim,',0,0,'C');
	$pdf->Cell(75,8,'Sopir,',0,0,'C');
	$pdf->Cell(75,8,'Pihak Penerima,',0,0,'C');

	$pdf->ln(20);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','BU',10);
	$pdf->Cell(75,8,'RIYAN MEI SAPUTRA',0,0,'C');
	$pdf->Cell(75,8,$namasopir,0,0,'C');
    $pdf->SetFont('Arial','',10);
	$pdf->Cell(75,8,'_________________',0,0,'C');

	$pdf->ln(10);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','I',8);
	$pdf->Cell(75,8,'Note: Nama, Cap & Tanda Tangan',0,0,'L');


//=========


  $pdf->Output();

?>	
