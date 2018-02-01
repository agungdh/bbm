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
        <input readonly value="<?php echo $namasopir; ?>" type="text" class="form-control" id="namasopir" placeholder="Isikan Nama SOPIR" name="namasopir" >
      </div>

      <div class="form-group">
        <label for="namakenek">Nama KENEK</label>
        <input readonly value="<?php echo $namakenek; ?>" type="text" class="form-control" id="namakenek" placeholder="Isikan Nama KENEK" name="namakenek" >
      </div>

    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input type="submit" class="btn btn-danger" name="proses" value="HAPUS Data"></input>
      <input type="submit" class="btn btn-info" name="batal" value="Batal"></input>
    </div>
  </form>
</div><!-- /.box -->

<?php
if ($this->input->post('proses')) {
  $this->db->query("DELETE from sopir
      WHErE id = ?", array($id));

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