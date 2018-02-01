<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>TAMBAH SPP</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="tambah">
    <div class="box-body">

      <div class="form-group">
        <label for="spp">Nomor SPP</label>
        <select class="form-control id_spp"  style="width: 100%;" id="id_spp" name="id_spp">
        </select>
      </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input type="submit" class="btn btn-success" name="proses" value="Simpan Data"></input>
      <input type="submit" class="btn btn-info" name="batal" value="Batal"></input>
    </div>
  </form>
</div><!-- /.box -->

<script>
  $('.id_spp').select2(
   {
    placeholder: 'Pilih SSP',
    ajax: {
      url: '<?php echo base_url("invoice/ajaxspp") ?>',
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

  $id_spp = $this->input->post('id_spp');

  if ( $id_spp == null ) {
    ?>
    <script type="text/javascript">
      alertModal('<i class="icon fa fa-close"></i> Gagal!!','DATA masih KOSONG tidak dapat disimpan...');
    </script>
    <?php
    return;
  }

// CEK DATA KEMBAR
  $kembar = $this->db->query("SELECT * from isi_invoice 
    where id_spp=?", array($id_spp));

  $rowKembar = $kembar->num_rows();

  if ( $rowKembar > 0 ) // BILA SUDAH ADA
  {
    ?>
    <script type="text/javascript">
      alertModal('<i class="icon fa fa-close"></i> Gagal!!','sudah PERNAH disimpan...');
    </script>
    <?php
    return;   
  } 

  $query = $this->db->query("SELECT * from spp s, penawaran p 
    where s.id_penawaran=p.id
    and s.id=?", array($id_spp));

  foreach ($query->result() as $row) { 
        $kwantitas = $row->kwantitas; 
        $hargainvoice = $row->hargainvoice; 
        $hargadasar = $row->hargadasar; 
        $ppn = $row->ppn; 
        $pbbkb = $row->pbbkb; 
        $transport = $row->transport; 
  }

  $jmlharga = $hargainvoice * $kwantitas;
  $jmlppn = $ppn * $kwantitas;
  $jmlpbbkb = $pbbkb * $kwantitas;
  $jmltransport = $transport * $kwantitas;

  $totalharga = $jmlharga + $jmlppn + $jmlpbbkb + $jmltransport;

  $this->db->query("INSERT into isi_invoice
      set id_invoice=?, 
          id_spp=?,
          hargainvoice=?,
          hargadasar=?,
          ppn=?,
          pbbkb=?,
          transport=?,
          totalharga=?
          ", array($id, 
                    $id_spp,
                    $hargainvoice,
                    $hargadasar,
                    $jmlppn,
                    $jmlpbbkb,
                    $jmltransport,
                    $totalharga));
    ?>
    <script>
      window.location = "<?php echo base_url('invoice/isi_invoice/').$id; ?>";
    </script>
    <?php 
}

if ($this->input->post('batal')) {
    
    ?>
    <script> 
      window.location = "<?php echo base_url('invoice/isi_invoice/').$id; ?>";
    </script>
    <?php
}
?>