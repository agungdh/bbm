<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>TAMBAH KONSUMEN</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="tambah">
    <div class="box-body">

      <div class="form-group">
        <label for="namapelanggan">Nama KONSUMEN</label>
        <input type="text" class="form-control" id="namapelanggan" placeholder="Isikan Nama KONSUMEN" name="namapelanggan" >         
      </div>

      <div class="form-group">
        <label for="alamatpelanggan">Alamat KONSUMEN</label>
        <input type="text" class="form-control" id="alamatpelanggan" placeholder="Isikan Alamat KONSUMEN" name="alamatpelanggan" >         
      </div>

      <div class="form-group">
        <label for="kota">Kota</label>
        <input type="text" class="form-control" id="kota" placeholder="Isikan Kota" name="kota" >
      </div>

      <div class="form-group">
        <label for="npwp">NPWP</label>
        <input type="text" class="form-control" id="npwp" placeholder="Isikan NPWP" name="npwp" >
      </div>

    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input type="submit" class="btn btn-success" name="proses" value="Simpan Data"></input>
      <input type="submit" class="btn btn-info" name="batal" value="Batal"></input>
    </div>
  </form>
</div><!-- /.box -->

<?php
if ($this->input->post('proses')) {

  $namapelanggan = $this->input->post('namapelanggan');
  $alamatpelanggan = $this->input->post('alamatpelanggan');
  $kota = $this->input->post('kota');
  $npwp = $this->input->post('npwp');

  if ($namapelanggan == null || $alamatpelanggan == null || $kota == null || $npwp == null ) {
    ?>
    <script type="text/javascript">
      alertModal('<i class="icon fa fa-close"></i> Gagal!!','DATA masih KOSONG tidak dapat disimpan...');
    </script>
    <?php
    return;
  }

  $this->db->query("INSERT into pelanggan
      set namapelanggan=?, 
          alamatpelanggan=?, 
          kota=?, 
          npwp=? 
          ", array($namapelanggan, 
                    $alamatpelanggan,
                    $kota,
                    $npwp));

    ?>

    <script>
      window.location = "<?php echo base_url('konsumen'); ?>";
    </script>
    <?php 
}

if ($this->input->post('batal')) {
    
    ?>
    <script>
      window.location = "<?php echo base_url('konsumen'); ?>";
    </script>
    <?php
}
?>