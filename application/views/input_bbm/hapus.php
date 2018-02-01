<?php
$query = $this->db->query("SELECT * 
        FROM mutasiproduk
        WHERE id=?",array($id));

    foreach ($query->result() as $row) { 
        $no_faktur = $row->no_faktur; 
        $tanggal = date_format(date_create($row->tanggal),'d-m-Y'); 
        $masuk = $row->masuk; 
    }
?>
<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>HAPUS INPUT BBM</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="hapus">
    <div class="box-body">

      <div class="form-group">
        <label for="no_faktur">NO Faktur</label>
        <input readonly value="<?php echo $no_faktur; ?>" type="text" class="form-control" id="no_faktur" placeholder="Isikan NO Faktur" name="no_faktur" >
      </div>

      <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input readonly value="<?php echo $tanggal; ?>" type="text" class="form-control" id="tanggal" placeholder="Isikan Tanggal" name="tanggal">
      </div>

      <div class="form-group">
        <label for="masuk">Masuk</label>
        <input readonly value="<?php echo $masuk; ?>" type="text" class="form-control" id="masuk" placeholder="Isikan Masuk" name="masuk" >
      </div>

    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input type="submit" class="btn btn-danger" name="proses" value="Hapus Data"></input>
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
  $this->db->query("DELETE FROM mutasiproduk
      WHERE id = ?", array($id));

  $id1 = 1;

  $this->db->query("UPDATE produk
      set stok = stok - ?
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