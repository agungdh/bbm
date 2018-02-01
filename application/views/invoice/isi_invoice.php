<script type="text/javascript" language="javascript" >
  $(document).ready(function() {
        var dataTable = $('#lookup').DataTable( {
          "responsive": true,
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"<?php echo base_url("invoice/ajaxinvoice?id=".$id) ?>", // json datasource
            type: "post",  // method  , by default get
            
          },
          "columnDefs": [ {
          "targets": [],
          "orderable": false
          } ]
        } );
      } );
</script>

<?php
    $query = $this->db->query("SELECT * 
      from invoice i, spp s, penawaran p, pelanggan pg 
    where i.id_spp=s.id
    and s.id_penawaran=p.id
    and  p.id_pelanggan=pg.id
    and i.id=?", array($id));

    foreach ($query->result() as $row) { 
      $nomorinvoice = $row->nomorinvoice;
      $tanggalinvoice = $row->tanggalinvoice;
      $jatuhtempo = $row->jatuhtempo;
      $totaltagihan = $row->totaltagihan;
      $namapelanggan = $row->namapelanggan;
    }
?>

<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>DATA INVOICE: </font></strong></h4>

    <div class="row">
      <div class='col-md-4'>
        Nomor Invoice: <font color=blue>(<?php echo $nomorinvoice.') '.$namapelanggan; ?></font>
      </div>

      <div class='col-md-4'>
        Tanggal: <font color=blue><?php echo date_format(date_create($tanggalinvoice),'d-m-Y'); ?></font>
      </div>

      <div class='col-md-4'>
        Tagihan: <font color=blue><?php echo number_format($totaltagihan,0,',','.'); ?></font>
      </div>
    </div>

  </div><!-- /.box-header -->

    <div class="box-body">

    <div class="form-group">
      <a href='<?php echo base_url("invoice"); ?>'><button class="btn fa fa-reply btn-warning"> INVOICE</button></a>  
      <a href='<?php echo base_url("invoice/tambahspp/").$id; ?>'><button class="btn fa fa-plus btn-success"> Tambah SPP</button></a>
    </div>

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>NOMOR SPP</th>
                    <th>TANGGAL</th>
                    <th>KWANTITAS</th>
                    <th>TOTAL HARGA</th>
                    <th>PROSES</th>
        </tr>
      </thead>

      <tbody>
      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->
