<script type="text/javascript" language="javascript" >
  $(document).ready(function() {
        var dataTable = $('#lookup').DataTable( {
          "responsive": true,
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"<?php echo base_url("spp/ajax") ?>", // json datasource
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
    <h4><strong><font color=blue>SURAT PENGANTAR PENGIRIMAN</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <div class="form-group">
      <a href='<?php echo base_url("spp/tambah"); ?>'><button class="btn btn-success">+ Tambah SPP</button></a>
    </div>

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>PELANGGAN</th>
                    <th>NOMOR SPP</th>
                    <th>KWANTITAS</th>
                    <th>TANGGAL</th>
                    <th>PROSES</th>
        </tr>
      </thead>

      <tbody>
      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->