<?php
$query = $this->db->query("SELECT *, ii.id_invoice, s.nomorspp,
          pg.namapelanggan, s.tanggalspp, ii.hargainvoice, ii.hargadasar, 
          ii.ppn, ii.pbbkb, ii.transport, ii.totalharga 
        FROM isi_invoice ii, spp s, penawaran p, pelanggan pg
        WHERE ii.id_spp=s.id
        and s.id_penawaran=p.id
        and p.id_pelanggan=pg.id 
        and ii.id=?",array($id));

    foreach ($query->result() as $row) { 
        $id_invoice = $row->id_invoice; 
        $nomorspp = $row->nomorspp; 
        $namapelanggan = $row->namapelanggan; 
        $tanggalspp = date_format(date_create($row->tanggalspp),'d-m-Y'); 
        $hargainvoice = $row->hargainvoice; 
        $hargadasar = $row->hargadasar; 
        $kwantitas = $row->kwantitas; 
        $ppn = $row->ppn; 
        $transport = $row->transport; 
        $pbbkb = $row->pbbkb; 
        $totalharga = $row->totalharga; 
    }
?>

<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>UBAH DATA INVOICE</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="tambah">
    <div class="box-body">

      <div class="form-group">
        <label for="spp">Nomor SPP</label>
        <input type="text" class="form-control" id="nomorspp" name="nomorspp" 
        value="<?php echo $nomorspp.': '.$namapelanggan.' Tgl:'.$tanggalspp; ?>" readonly>     
      </div>

      <div class="form-group">
        <label for="spp">Harga BBM</label>
        <input type="text" class="form-control" id="hargainvoice" name="hargainvoice" 
        value="<?php echo number_format($hargainvoice,0,',','.'); ?>" readonly>     
      </div>

      <div class="form-group">
        <label for="spp">Kwantitas</label>
        <input type="text" class="form-control" id="kwantitas" name="kwantitas" 
        value="<?php echo number_format($kwantitas,0,',','.'); ?>" readonly>     
      </div>

      <div class="form-group">
        <label for="spp">PPN</label>
        <input type="text" class="form-control" id="ppn" name="ppn" 
        value="<?php echo number_format($ppn,0,',','.'); ?>" readonly>     
      </div>

      <div class="form-group">
        <label for="spp">PBB-KB</label>
        <input type="text" class="form-control" id="pbbkb" name="pbbkb" 
        value="<?php echo number_format($pbbkb,0,',','.'); ?>" readonly>     
      </div>

      <div class="form-group">
        <label for="spp">Transport</label>
        <input type="text" class="form-control" id="transport" name="transport" 
        value="<?php echo number_format($transport,0,',','.'); ?>" readonly>     
      </div>

      <div class="form-group">
        <label for="spp">Total Harga</label>
        <input type="text" class="form-control" id="totalharga" name="totalharga" 
        value="<?php echo number_format($totalharga,0,',','.'); ?>" readonly>     
      </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input type="submit" class="btn btn-success" name="proses" value="Simpan Perubahan"></input>
      <input type="submit" class="btn btn-info" name="batal" value="Batal"></input>
    </div>
  </form>
</div><!-- /.box -->

<?php
if ($this->input->post('proses')) {

  //$this->db->query("DELETE from isi_invoice
  //    where id=? 
  //        ", array($id));

    ?>
    <script>
      window.location = "<?php echo base_url('invoice/isi_invoice/').$id_invoice; ?>";
    </script>
    <?php 
}

if ($this->input->post('batal')) {
    
    ?>
    <script> 
      window.location = "<?php echo base_url('invoice/isi_invoice/').$id_invoice; ?>";
    </script>
    <?php
}
?>