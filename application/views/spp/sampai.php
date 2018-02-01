<?php
  $query = $this->db->query("SELECT *
    FROM spp s, penawaran p, pelanggan pg, sopir sp, kendaraan k
    WHERE s.id_penawaran=p.id 
    AND p.id_pelanggan=pg.id
    AND s.id_sopir=sp.id
    AND s.id_kendaraan=k.id
    AND s.id=?",array($id));
  
  foreach ($query->result() as $row) {   
    $id_pelanggan  = $row->id_pelanggan;   
    $id_kendaraan  = $row->id_kendaraan;   
    $id_sopir  = $row->id_sopir;   
    $nomorspp  = $row->nomorspp;  
    $tanggalspp  = $row->tanggalspp;  
    $nopo  = $row->nopo;  
    $tanggalpo = $row->tanggalpo;  
    $kwantitas = $row->kwantitas;   
    $segelatas = $row->segelatas;   
    $segelbawah = $row->segelbawah;   
    $namapelanggan = $row->namapelanggan;   
    $nomorkendaraan = $row->nomorkendaraan;   
    $namasopir = $row->namasopir;   
  }
?>

<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>SPP SUDAH SAMPAI</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="moddul">
    <div class="box-body">

      <div class="form-group">
        <label for="nomorspp">Nomor SPP</label>
        <input type="text" class="form-control" id="nomorspp" name="nomorspp" value="<?php echo $nomorspp; ?>" readonly>         
      </div>

    <div class="form-group">
      <label for="tanggalspp">Tanggal SPP</label>
  <input type="text" class="form-control" id="tanggalspp" placeholder="Isikan Tanggal SPP" name="tanggalspp" value="<?php echo date_format(date_create($tanggalspp),'d-m-Y'); ?>" readonly>          
    </div>

      <div class="form-group">
        <label for="nopo">Nomor PO</label>
        <input type="text" class="form-control" id="nopo" name="nopo"  value="<?php echo $nopo; ?>" readonly>         
      </div>

    <div class="form-group">
      <label for="tanggalpo">Tanggal PO</label>
  <input type="text" class="form-control" id="tanggalpo" name="tanggalpo" value="<?php echo date_format(date_create($tanggalpo),'d-m-Y'); ?>" readonly>          
    </div>

      <div class="form-group">
        <label for="pelanggan">Nama Pelanggan</label>
        <input type="text" class="form-control" id="namapelanggan" name="namapelanggan"  value="<?php echo $namapelanggan; ?>" readonly>   
      </div>

      <div class="form-group">
        <label for="faktormeter">Kwantitas</label>
        <input type="text" class="form-control" id="kwantitas" name="kwantitas" value="<?php echo number_format($kwantitas,0,',','.'); ?>" readonly>         
      </div>

      <div class="form-group">
        <label for="segelatas">Segel Atas</label>
        <input type="text" class="form-control" id="segelatas" name="segelatas"  value="<?php echo $segelatas; ?>" readonly>         
      </div>

      <div class="form-group">
        <label for="segelbawah">Segel Bawah</label>
        <input type="text" class="form-control" id="segelbawah" name="segelbawah"  value="<?php echo $segelbawah; ?>" readonly>         
      </div>

      <div class="form-group">
        <label for="kendaraan">Nomor Kendaraan</label>
        <input type="text" class="form-control" id="nomorkendaraan" name="nomorkendaraan"  value="<?php echo $nomorkendaraan; ?>" readonly> 
      </div>

      <div class="form-group">
        <label for="sopir">Nama Sopir</label>
        <input type="text" class="form-control" id="namasopir" name="namasopir"  value="<?php echo $namasopir; ?>" readonly> 
      </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input type="submit" class="btn btn-warning" name="proses" value="Simpan Perubahan"></input>
      <input type="submit" class="btn btn-info" name="batal" value="Batal"></input>
    </div>
  </form>
</div><!-- /.box -->

<?php
if ($this->input->post('proses')) {

  $this->db->query("UPDATE spp
      set status=1
      where id=?", array($id));

    ?>
    <script>
      window.location = "<?php echo base_url('spp'); ?>";
    </script>
    <?php 
}

if ($this->input->post('batal')) {
    
    ?>
    <script>
      window.location = "<?php echo base_url('spp'); ?>";
    </script>
    <?php
}
?>