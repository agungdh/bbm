<?php
$query = $this->db->query("SELECT * 
        FROM sopir
        WHERE id=?",array($id));

    foreach ($query->result() as $row) { 
        $namasopir = $row->namasopir; 
        $namakenek = $row->namakenek; 
    }
?>
<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>UBAH SOPIR</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="tambah">
    <div class="box-body">

      <div class="form-group">
        <label for="namasopir">Nama SOPIR</label>
        <input value="<?php echo $namasopir; ?>" type="text" class="form-control" id="namasopir" placeholder="Isikan Nama SOPIR" name="namasopir" >
      </div>

      <div class="form-group">
        <label for="namakenek">Nama KENEK</label>
        <input value="<?php echo $namakenek; ?>" type="text" class="form-control" id="namakenek" placeholder="Isikan Nama KENEK" name="namakenek" >
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

  $namasopir = $this->input->post('namasopir');
  $namakenek = $this->input->post('namakenek');

  if ($namasopir == null || $namakenek == null) {
    ?>
    <script type="text/javascript">
      alertModal('<i class="icon fa fa-close"></i> Gagal!!','DATA masih KOSONG tidak dapat disimpan...');
    </script>
    <?php
    return;
  }

  $this->db->query("UPDATE sopir
      set namasopir=?,
      namakenek=?
      WHErE id = ?", array($namasopir,$namakenek, $id));

    ?>

    <script>
      window.location = "<?php echo base_url('sopir'); ?>";
    </script>
    <?php 
}

if ($this->input->post('batal')) {
    
    ?>
    <script>
      window.location = "<?php echo base_url('sopir'); ?>";
    </script>
    <?php
}
?>