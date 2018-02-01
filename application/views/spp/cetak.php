<?php
	$pdf = new FPDF('P','mm','A4');	

	$pdf->AliasNbPages();
	$pdf->AddPage();

	$pdf->ln(10);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',14);
	$pdf->Cell(180,5,'SURAT PENGANTAR PENGIRIMAN',0,0,'C');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',14);
	$pdf->Cell(180,5,'BAHAN BAKAR MINYAK',0,0,'C');

    $pdf->Image(base_url('assets/logo/logo.jpg'),95,30,20);

	$pdf->ln(20);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',18);
	$pdf->Cell(180,5,'PT. EDELWEIS KALASHNIKOV ENERGY',0,0,'C');

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
      $nomorspp = $row->nomorspp . ' /EKElpg/SPP-Fuel/'.$blspp.'/'. $thspp ;
      $tanggalspp = date_format(date_create($row->tanggalspp),'d-m-Y');
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

// --------------------------------
	$pdf->ln(10);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,5,'BU-PIUNU',0,0,'L');
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(15,5,'No. DO',0,0,'L');
	$pdf->Cell(50,5,': '. $nomorspp,0,0,'L');
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(15,5,'No. PO',0,0,'L');
	$pdf->Cell(50,5,': '. $row->nopo,0,0,'L');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,5,'0513/10/DJM.0/2018',0,0,'L');
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(15,5,'Tgl. DO',0,0,'L');
	$pdf->Cell(50,5,': '.$tanggalspp,0,0,'L');
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(15,5,'Tgl. PO',0,0,'L');
	$pdf->Cell(50,5,': '.$tanggalpo,0,0,'L');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,5,'TRANSPORTIR BBM',0,0,'L');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,5,'05.AD.03.22.17.1260',0,0,'L');

// ------------------------------------------
	$pdf->ln(10);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,5,'Diserahkan',0,0,'L');
	$pdf->Cell(60,5,': '.$namapelanggan,0,0,'L');
	$pdf->Cell(30,5,'Agen/Transportir',0,0,'L');
	$pdf->Cell(60,5,': PT. EDELWEIS KALASHNIKOV ENERGY',0,0,'L');

//+++++++++++++++++++

	$pdf->ln();
    $pdf->Cell(5);

	$start_awal	=$pdf->GetX(); 
	$get_x 	= $pdf->GetX();
	$get_y	= $pdf->GetY();

    $pdf->SetFont('Arial','',8);
	$pdf->MultiCell(30,5,'Alamat',0,'L');
	$get_x += 30;                           
	$pdf->SetXY($get_x, $get_y);

	$pdf->MultiCell(2,5,': ',0,'L');
	$get_x += 2;                           
	$pdf->SetXY($get_x, $get_y);

	$pdf->MultiCell(58,5,$alamatkirim,0,'L');
	$get_x += 58;                           
	$pdf->SetXY($get_x, $get_y);

	$pdf->MultiCell(30,5,'Alamat',0,'L');
	$get_x += 30;                           
	$pdf->SetXY($get_x, $get_y);

	$pdf->MultiCell(2,5,': ',0,'L');
	$get_x += 2;                           
	$pdf->SetXY($get_x, $get_y);

	$pdf->MultiCell(58,5,'Jl. Melinting No.06 RT.035 RW.012, Kelurahan Ganjar Agung, Kecamatan Metro Barat, Metro - Lampung',0,'L');

//+++++++++++++++++++

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,5,'ID',0,0,'L');
	$pdf->Cell(60,5,': '.$kota,0,0,'L');
	$pdf->Cell(30,5,'ID',0,0,'L');
	$pdf->Cell(60,5,': METRO',0,0,'L');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,5,'N.P.W.P',0,0,'L');
	$pdf->Cell(60,5,': '.$npwp,0,0,'L');
	$pdf->Cell(30,5,'N.P.W.P',0,0,'L');
	$pdf->Cell(60,5,': 80.428.223.4-321.000',0,0,'L');

// ------------------------------------------
	$pdf->ln(10);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(60,5,'Tanggal berlaku',1,0,'C');
	$pdf->Cell(60,5,'Produk',1,0,'C');
	$pdf->Cell(60,5,'Kwantitas',1,0,'C');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(60,8,$tanggalspp,1,0,'C');
	$pdf->Cell(60,8,'SOLAR HSD',1,0,'C');
	$pdf->Cell(60,8,number_format($kwantitas,0,',','.'),1,0,'C');

// ------------------------------------------
	$pdf->ln(13);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,8,'Dikirim dengan',1,0,'L');
	$pdf->Cell(30,8,'MOBIL TANGKI',1,0,'L');
	$pdf->Cell(20,8,'Segel Atas',1,0,'L');
	$pdf->Cell(40,8,$segelatas,1,0,'L');
	$pdf->Cell(30,8,'Jam Berangkat',1,0,'L');
	$pdf->Cell(30,8,'',1,0,'L');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,8,'No. Kendaraan',1,0,'L');
	$pdf->Cell(30,8,$nomorkendaraan,1,0,'L');
	$pdf->Cell(20,8,'Segel Bawah',1,0,'L');
	$pdf->Cell(40,8,$segelbawah,1,0,'L');
	$pdf->Cell(30,8,'Jam Tiba',1,0,'L');
	$pdf->Cell(30,8,'',1,0,'L');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,8,'Km. Awal',1,0,'L');
	$pdf->Cell(30,8,'',1,0,'L');
	$pdf->Cell(60,8,'',1,0,'L');
	$pdf->Cell(30,8,'Jam Bongkar',1,0,'L');
	$pdf->Cell(30,8,'',1,0,'L');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,8,'Km. Akhir',1,0,'L');
	$pdf->Cell(30,8,'',1,0,'L');
	$pdf->Cell(20,8,'Temperatur',1,0,'L');
	$pdf->Cell(40,8,$temperatur,1,0,'L');
	$pdf->Cell(30,8,'Jam Selesai',1,0,'L');
	$pdf->Cell(30,8,'',1,0,'L');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,8,'Berat Jenis',1,0,'L');
	$pdf->Cell(30,8,$beratjenis,1,0,'L');
	$pdf->Cell(60,8,'',1,0,'L');
	$pdf->Cell(30,8,'',1,0,'L');
	$pdf->Cell(30,8,'',1,0,'L');

//----------------
	$pdf->ln(10);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,15,'Jumlah Liter',1,0,'L');
    $pdf->SetFont('Arial','',12);
	$pdf->Cell(150,15,'## '.Terbilang($kwantitas).' Liter ##',1,0,'C');
    $pdf->SetFont('Arial','',8);

// ------------------------------------------
	$pdf->ln(20);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(45,5,'Distribusi',1,0,'C');
	$pdf->Cell(45,5,'Pengirim/ Transportir',1,0,'C');
	$pdf->Cell(45,5,'Pengemudi',1,0,'C');
	$pdf->Cell(45,5,'Penerima',1,0,'C');

// ------------------------------------------
	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(45,30,'','LTR',0,'C');
	$pdf->Cell(45,30,'','LTR',0,'C');
	$pdf->Cell(45,30,'','LTR',0,'C');
	$pdf->Cell(45,30,'','LTR',0,'C');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','BU',8);
	$pdf->Cell(45,5,'AGUSTINA ARIYANTI','LBR',0,'C');
	$pdf->Cell(45,5,'RYAN MEI SAPUTRA','LBR',0,'C');
	$pdf->Cell(45,5,$namasopir.'/ '.$namakenek,'LBR',0,'C');
	$pdf->Cell(45,5,'','LBR',0,'C');

//--------------------------------------
	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(180,5,'1. Lembar Asli (Putih) untuk Customer','LR',0,'L');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(180,5,'2. Lembar Warna Kuning untuk Transportir','LR',0,'L');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(180,5,'3. Lembar Warna Hijau untuk Lain-lain','LR',0,'L');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(180,5,'','LBR',0,'L');

//=========


  $pdf->Output();

  function Terbilang($x)
	{
	  $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
	  if ($x < 12)
		return " " . $abil[$x];
	  elseif ($x < 20)
		return Terbilang($x - 10) . "Belas";
	  elseif ($x < 100)
		return Terbilang($x / 10) . " Puluh" . Terbilang($x % 10);
	  elseif ($x < 200)
		return " Seratus" . Terbilang($x - 100);
	  elseif ($x < 1000)
		return Terbilang($x / 100) . " Ratus" . Terbilang($x % 100);
	  elseif ($x < 2000)
		return " Seribu" . Terbilang($x - 1000);
	  elseif ($x < 1000000)
		return Terbilang($x / 1000) . " Ribu" . Terbilang($x % 1000);
	  elseif ($x < 1000000000)
		return Terbilang($x / 1000000) . " Juta" . Terbilang($x % 1000000);
	}

?>	
