<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>TAMBAH KENDARAAN</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="tambah">
    <div class="box-body">

      <div class="form-group">
        <label for="nomorkendaraan">Nomor KENDARAAN</label>
        <input type="text" class="form-control" id="nomorkendaraan" placeholder="Isikan Nomor KENDARAAN" name="nomorkendaraan" >         
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

  $nomorkendaraan = $this->input->post('nomorkendaraan');

  if ($nomorkendaraan == null) {
    ?>
    <script type="text/javascript">
      alertModal('<i class="icon fa fa-close"></i> Gagal!!','DATA masih KOSONG tidak dapat disimpan...');
    </script>
    <?php
    return;
  }

  $this->db->query("INSERT into kendaraan
      set nomorkendaraan=?", array($nomorkendaraan));

    ?>

    <script>
      window.location = "<?php echo base_url('kendaraan'); ?>";
    </script>
    <?php 
}

if ($this->input->post('batal')) {
    
    ?>
    <script>
      window.location = "<?php echo base_url('kendaraan'); ?>";
    </script>
    <?php
}
?>