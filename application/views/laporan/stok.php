<script type="text/javascript" language="javascript" >
  $(document).ready(function() {
        var dataTable = $('#lookup').DataTable( {
          "responsive": true,
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"<?php echo base_url("laporan/ajaxstok") ?>", // json datasource
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
    <h4><strong><font color=blue>STOK BBM</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

<?php
      $query = $this->db->query("SELECT sum(stok*hargaproduk) as hargaliter 
        FROM produk");

      foreach ($query->result() as $rowC) { 
        $hargaliter = $rowC->hargaliter;
      }
?>

    <div class="form-group">
      <button class="btn btn-success">Rp <?php echo number_format($hargaliter,0,',','.'); ?></button>
    </div>

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>NAMA PRODUK</th>
                    <th>HARGA SATUAN</th>
                    <th>LITER</th>
                    <th>TOTAL HARGA</th>
        </tr>
      </thead>

      <tbody>
      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->