<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>TAMBAH INPUT BBM</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="tambah">
    <div class="box-body">

      <div class="form-group">
        <label for="no_faktur">NO Faktur</label>
        <input type="text" class="form-control" id="no_faktur" placeholder="Isikan NO Faktur" name="no_faktur" >
      </div>

      <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input type="text" class="form-control" id="tanggal" placeholder="Isikan Tanggal" name="tanggal" value="<?php echo date('d-m-Y'); ?>">
      </div>

      <div class="form-group">
        <label for="masuk">Masuk</label>
        <input type="text" class="form-control" id="masuk" placeholder="Isikan Masuk" name="masuk" >
      </div>

    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input type="submit" class="btn btn-success" name="proses" value="Simpan Data"></input>
      <input type="submit" class="btn btn-info" name="batal" value="Batal"></input>
    </div>
  </form>
</div><!-- /.box -->

<script type="text/javascript">
  $( "#tanggal" ).datepicker({
  inline: true,
  dateFormat: 'dd-mm-yy', 
});
</script>

<?php
if ($this->input->post('proses')) {

  $no_faktur = $this->input->post('no_faktur');
  $tanggal = date_format(date_create($this->input->post('tanggal')),'Y-m-d');
  $masuk = $this->input->post('masuk');

  if ($no_faktur == null || $tanggal == null || $masuk == null) {
    ?>
    <script type="text/javascript">
      alertModal('<i class="icon fa fa-close"></i> Gagal!!','DATA masih KOSONG tidak dapat disimpan...');
    </script>
    <?php
    return;
  }

  $this->db->query("INSERT into mutasiproduk
      set no_faktur=?,
      tanggal=?,
      masuk=?", array($no_faktur,$tanggal,$masuk));

  $id1 = 1;

  $this->db->query("UPDATE produk
      set stok = stok + ?
      where id = ?", array($masuk, $id1));  

    ?>

    <script>
      window.location = "<?php echo base_url('input_bbm'); ?>";
    </script>
    <?php 
}

if ($this->input->post('batal')) {
    
    ?>
    <script>
      window.location = "<?php echo base_url('input_bbm'); ?>";
    </script>
    <?php
}
?>