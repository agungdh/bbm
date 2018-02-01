<?php
  $query = $this->db->query("SELECT *
        FROM penawaran p, pelanggan pg
        WHERE p.id_pelanggan=pg.id 
        and p.id=?",array($id));
  
  foreach ($query->result() as $row) {   
    $namapelanggan  = $row->namapelanggan;   
    $alamatkirim  = $row->alamatkirim;   
    $hargainvoice  = $row->hargainvoice;   
    $pbbkb  = $row->pbbkb;  
    $transport  = $row->transport;  
    $hargadasar = $row->hargadasar;  
    $masaberlaku = date_format(date_create($row->masaberlaku),'d-m-Y');   
  }
?>

<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=red>HAPUS PENAWARAN</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="hapus">
    <div class="box-body">

      <div class="form-group">
        <label for="produk">Nama Pelanggan</label>
        <input type="text" class="form-control" id="namapelanggan" name="namapelanggan" value="<?php echo $namapelanggan; ?>" readonly >         
      </div>

      <div class="form-group">
        <label for="alamatkirim">Alamat Kirim</label>
        <input type="text" class="form-control" id="alamatkirim" name="alamatkirim" value="<?php echo $alamatkirim; ?>" readonly>         
      </div>

      <div class="form-group">
        <label for="hargainvoice"><p id="lbhi">Harga Setelah Diskon</p></label>
        <input type="text" class="form-control" id="hargainvoice" name="hargainvoice" value="<?php echo number_format($hargainvoice,0,',','.'); ?>" readonly>           
      </div>

      <div class="form-group">
        <label for="pbbkb">PBB-KB</label>
        <input type="text" class="form-control" id="pbbkb" name="pbbkb" value="<?php echo number_format($pbbkb,0,',','.'); ?>" readonly>           
      </div>

      <div class="form-group">
        <label for="transport">Transport</label>
        <input type="text" class="form-control" id="transport" name="transport" value="<?php echo number_format($transport,0,',','.'); ?>" readonly>         
      </div>

      <div class="form-group">
        <label for="hargadasartampil">Harga Jual</label>
        <input type="text" class="form-control" id="hargadasartampil" name="hargadasartampil" value="<?php echo number_format($hargadasar,0,',','.'); ?>" readonly>                  
      </div>

    <div class="form-group">
      <label for="masaberlaku">Masa Berlaku S.D</label>
  <input type="text" class="form-control" id="masaberlaku" name="masaberlaku" value="<?php echo $masaberlaku; ?>" readonly>          
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input type="submit" class="btn btn-danger" name="proses" value="Yakin di HAPUS"></input>
      <input type="submit" class="btn btn-info" name="batal" value="Batal"></input>
    </div>
  </form>
</div><!-- /.box -->

<script>
$( "#masaberlaku" ).datepicker({
  inline: true,
  dateFormat: 'dd-mm-yy', 
});

  $('.id_pelanggan').select2(
   {
    placeholder: 'Pilih Pelanggan',
    ajax: {
      url: '<?php echo base_url("spp/ajaxpelanggan") ?>',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results: data
        };
      },
      cache: true
    }
  } 
  );

</script>

<?php
if ($this->input->post('proses')) {

  $this->db->query("DELETE from penawaran
      where id
          ", array($id));

    ?>
    <script>
      window.location = "<?php echo base_url('penawaran'); ?>";
    </script>
    <?php 
}

if ($this->input->post('batal')) {
    
    ?>
    <script>
      window.location = "<?php echo base_url('penawaran'); ?>";
    </script>
    <?php
}
?>