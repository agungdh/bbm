<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>TAMBAH SPP</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="moddul">
    <div class="box-body">

      <div class="form-group">
        <label for="nomorspp">Nomor SPP</label>
        <input type="text" class="form-control" id="nomorspp" placeholder="Isikan Nomor SPP" name="nomorspp" >         
      </div>

    <div class="form-group">
      <label for="tanggalspp">Tanggal SPP</label>
  <input type="text" class="form-control" id="tanggalspp" placeholder="Isikan Tanggal SPP" name="tanggalspp" value="<?php echo date('d-m-Y'); ?>">          
    </div>

      <div class="form-group">
        <label for="nopo">Nomor PO</label>
        <input type="text" class="form-control" id="nopo" placeholder="Isikan Nomor PO" name="nopo" >         
      </div>

    <div class="form-group">
      <label for="tanggalpo">Tanggal PO</label>
  <input type="text" class="form-control" id="tanggalpo" placeholder="Isikan Tanggal PO" name="tanggalpo" value="<?php echo date('d-m-Y'); ?>">          
    </div>

      <div class="form-group">
        <label for="pelanggan">Nama Pelanggan</label>
        <select class="form-control id_pelanggan"  style="width: 100%;" id="id_pelanggan" name="id_pelanggan">
        </select>
      </div>

      <div class="form-group">
        <label for="faktormeter">Kwantitas</label>
        <input type="text" class="form-control kwantitas" id="kwantitas" placeholder="Isikan Faktor Meter" name="kwantitas" >         
      </div>

      <script type="text/javascript">
          $(document).ready(function () {
              $(".kwantitas").inputmask('currency', {
                  radixPoint: ",",
            groupSeparator: ".",
            digits: 0,
            autoGroup: true,
            prefix: '', //No Space, this will truncate the first character
            rightAlign: false,
            oncleared: function () { self.Value(''); }
              });
          });
      </script>

      <div class="form-group">
        <label for="segelatas">Segel Atas</label>
        <input type="text" class="form-control" id="segelatas" placeholder="Isikan Segel Atas" name="segelatas" >         
      </div>

      <div class="form-group">
        <label for="segeltengah">Segel Tengah</label>
        <input type="text" class="form-control" id="segeltengah" placeholder="Isikan Segel Tengah" name="segeltengah" >         
      </div>

      <div class="form-group">
        <label for="segelbawah">Segel Bawah</label>
        <input type="text" class="form-control" id="segelbawah" placeholder="Isikan Segel Bawah" name="segelbawah" >         
      </div>

      <div class="form-group">
        <label for="beratjenis">Berat Jenis</label>
        <input type="text" class="form-control" id="beratjenis" placeholder="Isikan Berat Jenis" name="beratjenis" >         
      </div>

      <div class="form-group">
        <label for="temperatur">Temperatur</label>
        <input type="text" class="form-control" id="temperatur" placeholder="Isikan Temperatur" name="temperatur" >         
      </div>

      <div class="form-group">
        <label for="kendaraan">Nomor Kendaraan</label>
        <select class="form-control id_kendaraan"  style="width: 100%;" id="id_kendaraan" name="id_kendaraan">
        </select>
      </div>

      <div class="form-group">
        <label for="sopir">Nama Sopir</label>
        <select class="form-control id_sopir"  style="width: 100%;" id="id_sopir" name="id_sopir">
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
$( "#tanggalspp" ).datepicker({
  inline: true,
  dateFormat: 'dd-mm-yy', 
});

$( "#tanggalpo" ).datepicker({
  inline: true,
  dateFormat: 'dd-mm-yy', 
});

  $('.id_pelanggan').select2(
   {
    placeholder: 'Pilih Pelanggan',
    ajax: {
      url: '<?php echo base_url("spp/ajaxpelanggan") ?>',
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

  $('.id_kendaraan').select2(
   {
    placeholder: 'Pilih Kendaraan',
    ajax: {
      url: '<?php echo base_url("spp/ajaxkendaraan") ?>',
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

  $('.id_sopir').select2(
   {
    placeholder: 'Pilih Sopir',
    ajax: {
      url: '<?php echo base_url("spp/ajaxsopir") ?>',
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

  $nomorspp = $this->input->post('nomorspp');
  $tanggalspp = date_format(date_create($this->input->post('tanggalspp')),'Y-m-d');
  $nopo = $this->input->post('nopo');
  $tanggalpo = date_format(date_create($this->input->post('tanggalpo')),'Y-m-d');
  $segelatas = $this->input->post('segelatas');
  $segeltengah = $this->input->post('segeltengah');
  $segelbawah = $this->input->post('segelbawah');
  $kwantitas = str_replace('.', '', $this->input->post('kwantitas'));
  $id_pelanggan = $this->input->post('id_pelanggan');
  $id_kendaraan = $this->input->post('id_kendaraan');
  $id_sopir = $this->input->post('id_sopir');
  $beratjenis = $this->input->post('beratjenis');
  $temperatur = $this->input->post('temperatur');

  if ($nomorspp == null || $nopo == null || $segelatas == null || $segelbawah == null ||
    $id_pelanggan == null || $id_kendaraan == null || $id_sopir == null || 
    $beratjenis == null || $temperatur == null ) {
    ?>
    <script type="text/javascript">
      alertModal('<i class="icon fa fa-close"></i> Gagal!!','DATA masih KOSONG tidak dapat disimpan...');
    </script>
    <?php
    return;
  }

  if ($kwantitas <= 0 ) {
    ?>
    <script type="text/javascript">
      alertModal('<i class="icon fa fa-close"></i> Gagal!!','KWANTITAS masih KOSONG tidak dapat disimpan...');
    </script>
    <?php
    return;
  }

// CEK DATA KEMBAR
  $kembar = $this->db->query("SELECT * from spp 
    where nomorspp=?", array($nomorspp));

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

  if ( $segeltengah <> null )
  {
    $segelatas = $segelatas .', '. $segeltengah;
  }
  
  $this->db->query("INSERT into spp
      set id_penawaran=?, 
          id_kendaraan=?, 
          id_sopir=?, 
          nomorspp=?, 
          tanggalspp=?,
          nopo=?,
          tanggalpo=?,
          kwantitas=?,
          segelatas=?,
          segelbawah=?,
          beratjenis=?,
          temperatur=?
          ", array($id_pelanggan, 
                    $id_kendaraan, 
                    $id_sopir, 
                    $nomorspp, 
                    $tanggalspp,
                    $nopo,
                    $tanggalpo,
                    $kwantitas,
                    $segelatas,
                    $segelbawah,
                    $beratjenis,
                    $temperatur));

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