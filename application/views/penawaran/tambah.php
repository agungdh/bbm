<script>
  function calc()
  {
    hargainvoice = document.tambah.hargainvoice.value;
    transport = document.tambah.transport.value;
    pbbkb = document.getElementById("pbbkb").selectedIndex;

    if ( pbbkb == 0 ) { pbbkb = 7.5; pbbkbtampil = 7.5; }
    if ( pbbkb == 1 ) { pbbkb = 6.75; pbbkbtampil = 6.75; }
    if ( pbbkb == 2 ) { pbbkb = 1.28; pbbkbtampil = 1.28; }
    if ( pbbkb == 3 ) { pbbkb = 0; pbbkbtampil = 0; }

    hargadasar =0;
    ppn =  parseInt(hargainvoice) * 10 / 100;
    pbbkb = (parseInt(hargainvoice) * parseFloat(pbbkb) / 100).toFixed(0) ;

    hargadasar = parseInt(hargainvoice) + parseFloat(ppn) + parseFloat(pbbkb) + parseInt(transport);
    document.tambah.hargainvoicetampil.value = hargainvoice;
    document.tambah.transporttampil.value = transport;
    document.tambah.hargadasartampil.value = hargadasar;
    document.tambah.hargadasar.value = hargadasar;
    document.tambah.pbbkbtampil.value = pbbkb;
    document.tambah.ppntampil.value = ppn;
  }
</script>

<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>TAMBAH PENAWARAN</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="tambah">
    <div class="box-body">

      <div class="form-group">
        <label for="produk">Nama Pelanggan</label>
        <select class="form-control id_pelanggan"  style="width: 100%;" id="id_pelanggan" name="id_pelanggan">
        </select>
      </div>

      <div class="form-group">
        <label for="alamatkirim">Alamat Kirim</label>
        <input type="text" class="form-control" id="alamatkirim" placeholder="Isikan Alamat Kirim" name="alamatkirim" >         
      </div>

      <div class="form-group">
        <label for="hargainvoice"><p id="lbhi">Harga Setelah Diskon</p></label>
        <input type="text" class="form-control" id="hargainvoice" placeholder="Isikan Harga Setelah Diskon" name="hargainvoice" onkeyup="calc();" value="0">           
        <input type="text" class="form-control hargainvoicetampil" id="hargainvoicetampil" readonly name="hargainvoicetampil">           
        <input type="hidden" class="form-control" id="ppntampil" " name="ppntampil" readonly>      
      </div>

      <script type="text/javascript">
          $(document).ready(function () {
              $(".hargainvoicetampil").inputmask('currency', {
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
        <label for="pbbkb">PBB-KB</label>
        <select class="form-control" style="width: 100%;" id="pbbkb" name="pbbkb" onclick="calc();" onkeyup="calc();">
          <option value="7.50">Konstruksi: 7.50%</option>
          <option value="6.75">Perkebunan: 6.75%</option>
          <option value="1.28">Industri: 1.28%</option>
          <option value="0">BUMN: 0%</option>
        </select>
      </div>

      <div class="form-group">
        <label for="transport"><p id="lbtr">Transport</p></label>
        <input type="text" class="form-control" id="transport" name="transport" onkeyup="calc();" 
        value="0">         
        <input type="text" class="form-control transporttampil" id="transporttampil" readonly name="transporttampil">           
      </div>

      <script type="text/javascript">
          $(document).ready(function () {
              $(".transporttampil").inputmask('currency', {
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
        <label for="hargadasartampil">Harga Jual</label>
        <input type="text" class="form-control hargadasartampil" id="hargadasartampil" name="hargadasartampil" readonly>         
        <input type="hidden" class="form-control hargadasar" id="hargadasar" " name="hargadasar" readonly>         
        <input type="hidden" class="form-control" id="pbbkbtampil" " name="pbbkbtampil" readonly>         
      </div>

      <script type="text/javascript">
          $(document).ready(function () {
              $(".hargadasartampil").inputmask('currency', {
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
      <label for="masaberlaku">Masa Berlaku S.D</label>
  <input type="text" class="form-control" id="masaberlaku" name="masaberlaku" value="<?php echo date('d-m-Y', strtotime('+15 days', strtotime(date('Y-m-d')))); ?>">          
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input type="submit" class="btn btn-success" name="proses" value="Simpan Data"></input>
      <input type="submit" class="btn btn-info" name="batal" value="Batal"></input>
    </div>
  </form>
</div><!-- /.box -->

<script>
$( "#masaberlaku" ).datepicker({
  inline: true,
  dateFormat: 'dd-mm-yy', 
});

  $('.id_pelanggan').select2(
   {
    placeholder: 'Pilih Pelanggan',
    ajax: {
      url: '<?php echo base_url("penawaran/ajaxpelanggan") ?>',
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

  $id_pelanggan = $this->input->post('id_pelanggan');
  $alamatkirim = $this->input->post('alamatkirim');
  $hargainvoice = $this->input->post('hargainvoice');
  $ppntampil = $this->input->post('ppntampil');
  $pbbkbtampil = $this->input->post('pbbkbtampil');
  $transport = $this->input->post('transport');
  $hargadasar = $this->input->post('hargadasar');
  $masaberlaku = date_format(date_create($this->input->post('masaberlaku')),'Y-m-d');

  if ($id_pelanggan == null || $alamatkirim == null || $hargainvoice == null || $ppntampil == null ||
    $pbbkbtampil == null || $transport == null || $hargadasar == null || $masaberlaku == null ) {
    ?>
    <script type="text/javascript">
      alertModal('<i class="icon fa fa-close"></i> Gagal!!','DATA masih KOSONG tidak dapat disimpan...');
    </script>
    <?php
    return;
  }

  $this->db->query("INSERT into penawaran
      set id_pelanggan=?, 
          alamatkirim=?, 
          ppn=?, 
          pbbkb=?, 
          hargainvoice=?, 
          transport=?,
          hargadasar=?,
          masaberlaku=?
          ", array($id_pelanggan, 
                    $alamatkirim, 
                    $ppntampil, 
                    $pbbkbtampil, 
                    $hargainvoice, 
                    $transport,
                    $hargadasar,
                    $masaberlaku));

    ?>
    <script>
      window.location = "<?php echo base_url('penawaran'); ?>";
    </script>
    <?php 
}

if ($this->input->post('batal')) {
    
    ?>
    <script>
      window.location = "<?php echo base_url('penawaran'); ?>";
    </script>
    <?php
}
?>