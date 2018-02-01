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
      $kwantitas = $rowSPP->kwantitas;
      $dpp = $hargainvoice * $kwantitas;
      $ppn = $rowSPP->ppn;
      $pbbkb = $rowSPP->pbbkb;
      $transport = $rowSPP->transport;
      $totalharga = $rowSPP->totalharga;
  	}

//-------------------------

	$pdf = new FPDF('P','mm','A4');	

	$pdf->AliasNbPages();
	$pdf->AddPage();

    $pdf->Image(base_url('assets/logo/logo.jpg'),155,10,20);

	$pdf->ln(10);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',14);
	$pdf->Cell(100,5,'PT. EDELWEIS KALASHNIKOV ENERGY',0,0,'L');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,5,'BU-PIUNU',0,0,'L');
	$pdf->Cell(80,5,'',0,0,'L');
	$pdf->Cell(80,5,'AGEN PEMASARAN',0,0,'C');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(30,5,'0513/10/DJM.0/2018',0,0,'L');
	$pdf->Cell(80,5,'',0,0,'L');
	$pdf->Cell(80,5,'PT. EDELWEIS KALASHNIKOV ENERGY',0,0,'C');

	$pdf->ln();
    $pdf->Cell(5);
	$pdf->Cell(30,5,'TRANSPORTIR BBM',0,0,'L');
	$pdf->Cell(80,5,'',0,0,'L');
	$pdf->Cell(80,5,'WILAYAH LAMPUNG',0,0,'C');

	$pdf->ln();
    $pdf->Cell(5);
	$pdf->Cell(30,5,'05.AD.03.22.17.1260',0,0,'L');

	$pdf->ln(10);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','B',14);
	$pdf->Cell(180,8,'I N V O I C E',0,0,'C');

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
    $pdf->SetFont('Arial','',10);
	$pdf->Cell(180,5,'NOMOR : '.$nomorinvoice.'',0,0,'C');

// ------------------------------------------
	$pdf->ln(10);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(20,5,'Sold To',0,0,'L');
	$pdf->Cell(150,5,': '.$namapelanggan,0,0,'L');

	$pdf->ln();
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(20,5,'',0,0,'L');
	$pdf->Cell(150,5,': '.$alamatkirim,0,0,'L');

	$pdf->ln(10);
    $pdf->Cell(5);
	$pdf->Cell(20,5,'N.P.W.P',0,0,'L');
	$pdf->Cell(150,5,': '.$npwp,0,0,'L');

	$pdf->ln(10);
    $pdf->Cell(5);
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(20,5,'Tanggal PO','T',0,'L');
	$pdf->Cell(50,5,': '.$tanggalpo,'T',0,'L');
	$pdf->Cell(30,5,'Tanggal SPP','T',0,'R');
	$pdf->Cell(70,5,': '.$tanggalspp,'T',0,'L');
	//$pdf->Cell(50,5,': '.$tanggalspp,'T',0,'L');

	$pdf->ln();
    $pdf->Cell(5);
	$pdf->Cell(20,5,'Nomor PO',0,0,'L');
	$pdf->Cell(50,5,': '.$nopo,0,0,'L');
	$pdf->Cell(30,5,'Nomor SPP',0,0,'R');
	$pdf->Cell(70,5,': '.$nomorspp,0,0,'L');
	//$pdf->Cell(50,5,'',0,0,'L');

	$pdf->ln();
    $pdf->Cell(5);
	$pdf->Cell(20,5,'',0,0,'L');
	$pdf->Cell(50,5,'',0,0,'L');
	$pdf->Cell(30,5,'Armada',0,0,'R');
	$pdf->Cell(70,5,': '.$nomorkendaraan,0,0,'L');
	//$pdf->Cell(50,5,,0,0,'L');

	$pdf->ln(10);
    $pdf->Cell(5);
	$pdf->Cell(15,5,'No',1,0,'C');
	$pdf->Cell(50,5,'Deskripsi',1,0,'C');
	$pdf->Cell(35,5,'Kuantum',1,0,'C');
	$pdf->Cell(35,5,'Harga Satuan',1,0,'C');
	$pdf->Cell(35,5,'Total Harga',1,0,'C');


	$pdf->ln(10);
    $pdf->Cell(5);
	$pdf->Cell(15,5,'1',0,0,'C');
	$pdf->Cell(50,5,'SOLAR HSD',0,0,'L');
	$pdf->Cell(35,5,number_format($kwantitas,0,',','.').' Liter',0,0,'R');
	$pdf->Cell(35,5,number_format($hargainvoice,0,',','.'),0,0,'R');
	$pdf->Cell(35,5,number_format($dpp,0,',','.'),0,0,'R');

	$pdf->ln(10);
    $pdf->Cell(5);
	$pdf->Cell(15,5,'','T',0,'C');
	$pdf->Cell(50,5,'Dasar Pengenaan Pajak (DPP)','T',0,'L');
	$pdf->Cell(35,5,'','T',0,'R');
	$pdf->Cell(35,5,': Rp','T',0,'R');
	$pdf->Cell(35,5,number_format($dpp,0,',','.'),'T',0,'R');

	$pdf->ln();
    $pdf->Cell(5);
	$pdf->Cell(15,5,'',0,0,'C');
	$pdf->Cell(50,5,'PPN (10%)',0,0,'L');
	$pdf->Cell(35,5,'',0,0,'R');
	$pdf->Cell(35,5,': Rp',0,0,'R');
	$pdf->Cell(35,5,number_format($ppn,0,',','.'),0,0,'R');

	$pdf->ln();
    $pdf->Cell(5);
	$pdf->Cell(15,5,'',0,0,'C');
	$pdf->Cell(50,5,'PPBKB',0,0,'L');
	$pdf->Cell(35,5,'',0,0,'R');
	$pdf->Cell(35,5,': Rp',0,0,'R');
	$pdf->Cell(35,5,number_format($pbbkb,0,',','.'),0,0,'R');

	$pdf->ln();
    $pdf->Cell(5);
	$pdf->Cell(15,5,'',0,0,'C');
	$pdf->Cell(50,5,'TRANSPORT',0,0,'L');
	$pdf->Cell(35,5,'',0,0,'R');
	$pdf->Cell(35,5,': Rp',0,0,'R');
	$pdf->Cell(35,5,number_format($transport,0,',','.'),0,0,'R');

	$pdf->ln(10);
    $pdf->Cell(5);
	$pdf->Cell(15,5,'','T',0,'C');
	$pdf->Cell(50,5,'','T',0,'R');
	$pdf->Cell(35,5,'','T',0,'R');
	$pdf->Cell(35,5,'T O T A L : Rp','T',0,'R');
	$pdf->Cell(35,5,number_format($totalharga,0,',','.'),'T',0,'R');

	$pdf->ln(10);
    $pdf->Cell(5);
	$pdf->Cell(20,10,'TERBILANG :',1,0,'L');
	$pdf->Cell(150,10,'#'.Terbilang($totalharga).'Rupiah #',1,0,'L');

	$pdf->ln(15);
    $pdf->Cell(5);
	$pdf->Cell(93,5,'Pembayaran Tunai atau Cek Transfer',1,0,'C');
	$pdf->Cell(20,5,'',0,0,'L');
	$pdf->Cell(60,5,'PT. EDELWEIS KALASHNIKOV ENERGY',0,0,'C');

	$pdf->ln();
    $pdf->Cell(5);
	$pdf->Cell(20,5,'Bank','LR',0,'L');
	$pdf->Cell(73,5,'BRI An. PT. EDELWEIS KALASHNIKOV ENERGY','LR',0,'L');

	$pdf->ln();
    $pdf->Cell(5);
	$pdf->Cell(20,5,'Cabang','LR',0,'L');
	$pdf->Cell(73,5,'METRO','LR',0,'L');

	$pdf->ln();
    $pdf->Cell(5);
	$pdf->Cell(20,5,'No.Rekening','LR',0,'L');
	$pdf->Cell(73,5,'0130 0100 221 0303','LR',0,'L');

	$pdf->ln();
    $pdf->Cell(5);
	$pdf->Cell(20,5,'Bank','LR',0,'L');
	$pdf->Cell(73,5,'MANDIRI An. PT. EDELWEIS KALASHNIKOV ENERGY','LR',0,'L');

	$pdf->ln();
    $pdf->Cell(5);
	$pdf->Cell(20,5,'Cabang','LR',0,'L');
	$pdf->Cell(73,5,'METRO','LR',0,'L');

	$pdf->ln();
    $pdf->Cell(5);
	$pdf->Cell(20,5,'No.Rekening','LR',0,'L');
	$pdf->Cell(73,5,'114-00-1601192-9','LR',0,'L');

	$pdf->ln();
    $pdf->Cell(5);
	$pdf->Cell(20,5,'Bank','LR',0,'L');
	$pdf->Cell(73,5,'BNI An. PT. EDELWEIS KALASHNIKOV ENERGY','LR',0,'L');
	$pdf->Cell(20,5,'',0,0,'L');
    $pdf->SetFont('Arial','BU',8);
	$pdf->Cell(60,5,'AGUSTINA ARIYANTI',0,0,'C');
    $pdf->SetFont('Arial','',8);

	$pdf->ln();
    $pdf->Cell(5);
	$pdf->Cell(20,5,'Cabang','LR',0,'L');
	$pdf->Cell(73,5,'METRO','LR',0,'L');
	$pdf->Cell(20,5,'',0,0,'L');
	$pdf->Cell(60,5,'Pemasaran Wilayah Lampung',0,0,'C');

	$pdf->ln();
    $pdf->Cell(5);
	$pdf->Cell(20,5,'No.Rekening','LBR',0,'L');
	$pdf->Cell(73,5,'050 6801 477','LBR',0,'L');


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
