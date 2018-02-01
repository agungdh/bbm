<?php
// --------------------------------
      $query = $this->db->query("SELECT * 
        FROM invoice i, spp s, penawaran p, pelanggan pg, kendaraan k
        WHERE i.id_spp=s.id
        AND s.id_penawaran=p.id
        AND p.id_pelanggan=pg.id
        AND s.id_kendaraan=k.id
        AND i.id=?",array($id));
            
    foreach ($query->result() as $row) { 
      $nomorinvoice = $row->nomorinvoice;
      $tanggalinvoice = date_format(date_create($row->tanggalinvoice),'d-m-Y');
      $namapelanggan = $row->namapelanggan;
      $alamatkirim = $row->alamatkirim;
      $npwp = $row->npwp;
      $nomorspp = $row->nomorspp;
      $tanggalspp = date_format(date_create($row->tanggalspp),'d-m-Y');
      $nopo = $row->nopo;
      $tanggalpo = date_format(date_create($row->tanggalpo),'d-m-Y');
      $nomorkendaraan = $row->nomorkendaraan;
    }

      $querySPP = $this->db->query("SELECT * 
        FROM isi_invoice ii, invoice i, spp s
        WHERE ii.id_invoice=i.id
        and ii.id_spp=s.id
        AND i.id=?",array($id));
            
    foreach ($querySPP->result() as $rowSPP) { 
      $hargainvoice = $rowSPP->hargainvoice;
      $hargadasar = $rowSPP->hargadasar;
      $kwantitas = $rowSPP->kwantitas;
      $dpp = $hargainvoice * $kwantitas;
      $ppn = $rowSPP->ppn;
      $pbbkb = $rowSPP->pbbkb;
      $transport = $rowSPP->transport;
      $totalharga = $rowSPP->totalharga;
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
	$pdf->Cell(270,8,'K W I T A N S I',0,0,'C');

// NOMOR INVOICE
	  $blinv = date_format(date_create($tanggalinvoice),'m');
      if ($blinv=='01') { $blinv ='I';}
      if ($blinv=='02') { $blinv ='II';}
      if ($blinv=='03') { $blinv ='III';}
      if ($blinv=='04') { $blinv ='IV';}
      if ($blinv=='05') { $blinv ='V';}
      if ($blinv=='06') { $blinv ='VI';}
      if ($blinv=='07') { $blinv ='VII';}
      if ($blinv=='08') { $blinv ='VIII';}
      if ($blinv=='09') { $blinv ='IX';}
      if ($blinv=='10') { $blinv ='X';}
      if ($blinv=='11') { $blinv ='XI';}
      if ($blinv=='12') { $blinv ='XII';}
      $thinv = date_format(date_create($tanggalinvoice),'Y');
      $nomorinvoice = $nomorinvoice . ' /EKElpg/INV-Fuel/'.$blinv.'/'. $thinv ;
      
	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',12);
	$pdf->Cell(270,5,'NOMOR : '.$nomorinvoice,0,0,'C');

// ------------------------------------------
	$pdf->ln(15);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',12);
	$pdf->Cell(50,5,'Terima Dari',0,0,'L');
	$pdf->Cell(150,5,': '.$namapelanggan,0,0,'L');

	$pdf->ln(10);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',12);
	$pdf->Cell(50,5,'Uang Sejumlah',0,0,'L');
	$pdf->Cell(2,5,': ',0,0,'L');
    $pdf->SetFont('Arial','I',12);
	$pdf->MultiCell(148,5,Terbilang($totalharga).'Rupiah',0,'L');
    $pdf->SetFont('Arial','',12);

	$pdf->ln(10);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',12);
	$pdf->Cell(50,5,'Untuk Pembayaran',0,0,'L');
	$pdf->Cell(150,5,': SOLAR HSD Rp '.number_format($hargadasar,0,',','.').' x ' . number_format($kwantitas,0,',','.').' liter',0,0,'L');

	$pdf->ln(10);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',12);
	$pdf->Cell(50,5,'Jumlah',0,0,'L');
	$pdf->Cell(2,5,': ',0,0,'L');
    $pdf->SetFont('Arial','B',14);
	$pdf->Cell(148,5,'Rp '.number_format($totalharga,0,',','.'),0,0,'L');
    $pdf->SetFont('Arial','',12);

	$pdf->ln(15);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',12);
	$pdf->Cell(50,5,'Pembayaran Tunai atau Cek Transfer ke Bank BNI No.Rek 050.6810.477 atau ke Bank BRI No.Rek 0130.0100.221.0303',0,0,'L');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',12);
	$pdf->Cell(50,5,'atau ke Bank MANDIRI No.Rek 114-00-1601192-9 An: PT. EDELWEIS KALASHNIKOV ENERGY',0,0,'L');

	$pdf->ln(10);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',12);
	$pdf->Cell(50,5,'Pengiriman 2 hari setelah PO diterima',0,0,'L');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',12);
	$pdf->Cell(50,5,'Perubahan Harga Berlaku Per 15 Hari',0,0,'L');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',10);
	$pdf->Cell(180,5,'',0,0,'L');
	$pdf->Cell(50,5,'Lampung, ',0,0,'C');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',10);
	$pdf->Cell(180,5,'',0,0,'L');
	$pdf->Cell(50,5,'Pemasaran Wilayah Lampung',0,0,'C');

	$pdf->ln(20);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','BU',10);
	$pdf->Cell(180,5,'',0,0,'L');
	$pdf->Cell(50,5,'AGUSTINA ARIYANTI',0,0,'C');

/*
	$tempdir =  base_url()."assets/images/";
	$isi_teks = "Belajar QR Code itu asik";
	$namafile = "coba.png";
	 
	QRCode::png($isi_teks,$tempdir.$namafile,'H',5,0);
*/
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
