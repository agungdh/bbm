<script type="text/javascript" language="javascript" >
  $(document).ready(function() {
        var dataTable = $('#lookup').DataTable( {
          "responsive": true,
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"<?php echo base_url("penawaran/ajax") ?>", // json datasource
            type: "post",  // method  , by default get
            
          },
          "columnDefs": [ {
          "targets": [],
          "orderable": false
          } ]
        } );
      } );
</script>


<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>DATA KESEPAKATAN HARGA</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <div class="form-group">
      <a href='<?php echo base_url("penawaran/tambah"); ?>'><button class="btn btn-success">+ Tambah PENAWARAN</button></a>
    </div>

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>PELANGGAN</th>
                    <th>LOKASI</th>
                    <th>HARGA JUAL</th>
                    <th>SAMPAI TANGGAL</th>
                    <th>PROSES</th>
        </tr>
      </thead>

      <tbody>
      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->