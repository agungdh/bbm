<?php
$query = $this->db->query("SELECT * 
        FROM invoice i, spp s
        WHERE i.id_spp=s.id 
        and i.id=?",array($id));

    foreach ($query->result() as $row) { 
        $nomorinvoice = $row->nomorinvoice; 
        $nomorspp = $row->nomorspp; 
        $tanggalinvoice = date_format(date_create($row->tanggalinvoice),'d-m-Y');
        $jatuhtempo = date_format(date_create($row->jatuhtempo),'d-m-Y'); 
    }
?>

<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=red>HAPUS INVOICE</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="tambah">
    <div class="box-body">

      <div class="form-group">
        <label for="nomorinvoice">Nomor INVOICE</label>
        <input type="text" class="form-control" id="nomorinvoice" name="nomorinvoice" 
        value="<?php echo $nomorinvoice; ?>" readonly>         
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
      <label for="jatuhtempo">Tanggal Jatuh Tempo</label>
  <input type="text" class="form-control" id="jatuhtempo" name="jatuhtempo" value="<?php echo $jatuhtempo; ?>"  readonly>          
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input type="submit" class="btn btn-danger" name="proses" value="Yakin di HAPUS"></input>
      <input type="submit" class="btn btn-info" name="batal" value="Batal"></input>
    </div>
  </form>
</div><!-- /.box -->

<?php
if ($this->input->post('proses')) {

  $this->db->query("DELETE from isi_invoice
      where id_invoice=?", array($id));

  $this->db->query("DELETE from invoice
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