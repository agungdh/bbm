<?php
$query = $this->db->query("SELECT * 
        FROM invoice i, spp s, penawaran p, pelanggan pg
        WHERE i.id_spp=s.id
        and s.id_penawaran=p.id
        and p.id_pelanggan=pg.id 
        and i.id=?",array($id));

    foreach ($query->result() as $row) { 
        $nomorinvoice = $row->nomorinvoice; 
        $nomorspp = $row->nomorspp; 
        $tanggalinvoice = date_format(date_create($row->tanggalinvoice),'d-m-Y');
        $jatuhtempo = date_format(date_create($row->jatuhtempo),'d-m-Y'); 
        $totaltagihan = $row->totaltagihan; 
        $namapelanggan = $row->namapelanggan; 
        $alamatkirim = $row->alamatkirim; 
    }
?>

<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>BAYAR INVOICE</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="tambah">
    <div class="box-body">

      <div class="form-group">
        <label for="nomorinvoice">Nomor INVOICE</label>
        <input type="text" class="form-control" id="nomorinvoice" name="nomorinvoice" 
        value="<?php echo $nomorinvoice.': '.$namapelanggan.', Ke:'.$alamatkirim ; ?>" readonly>         
      </div>

      <div class="form-group">
        <label for="spp">Nomor SPP</label>
        <input type="text" class="form-control" id="nomorspp" name="nomorspp" 
        value="<?php echo $nomorspp; ?>" readonly>         
      </div>

    <div class="form-group">
      <label for="tanggalinvoice">Tanggal INVOICE</label>
  <input type="text" class="form-control" id="tanggalinvoice" name="tanggalinvoice" value="<?php echo $tanggalinvoice; ?>" readonly>          
    </div>

      <div class="form-group">
        <label for="spp">Total Bayar</label>
        <input type="text" class="form-control" id="totalharga" name="totalharga" 
        value="<?php echo number_format($totaltagihan,0,',','.'); ?>" readonly>         
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

  $this->db->query("UPDATE invoice
      set statusbayar=1
      where id=?", array($id));


    ?>
    <script>
      window.location = "<?php echo base_url('invoice'); ?>";
    </script>
    <?php 
}

if ($this->input->post('batal')) {
    
    ?>
    <script>
      window.location = "<?php echo base_url('invoice'); ?>";
    </script>
    <?php
}
?>