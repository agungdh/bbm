<script type="text/javascript" language="javascript" >
  $(document).ready(function() {
        var dataTable = $('#lookup').DataTable( {
          "responsive": true,
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"<?php echo base_url("laporan/ajaxmasuk") ?>", // json datasource
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
    <h4><strong><font color=blue>DATA BBM MASUK</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

<?php
      $query = $this->db->query("SELECT sum(masuk) as totalmasuk 
        FROM mutasiproduk");

      foreach ($query->result() as $rowC) { 
        $totalmasuk = $rowC->totalmasuk;
      }
?>

    <div class="form-group">
      <button class="btn btn-success"><?php echo number_format($totalmasuk,0,',','.').' Liter'; ?></button>
    </div>

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>NAMA PRODUK</th>
                    <th>TANGGAL</th>
                    <th>LITER</th>
                    <th>NOMOR SPP</th>
        </tr>
      </thead>

      <tbody>
      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->