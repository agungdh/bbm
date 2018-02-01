<?php
$query = $this->db->query("SELECT * 
        FROM kendaraan
        WHERE id=?",array($id));

    foreach ($query->result() as $row) { 
        $nomorkendaraan = $row->nomorkendaraan; 
    }
?>
<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=red>HAPUS KENDARAAN</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="ubah">
    <div class="box-body">

      <div class="form-group">
        <label for="nomorkendaraan">Nomor KENDARAAN</label>
        <input readonly type="text" class="form-control" id="nomorkendaraan" placeholder="Isikan Nomor KENDARAAN" name="nomorkendaraan" value="<?php echo $nomorkendaraan; ?>" >         
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

  $this->db->query("DELETE FROM kendaraan
          WHERE id = ?", array($id));

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