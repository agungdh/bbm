<script type="text/javascript" language="javascript" >
  $(document).ready(function() {
        var dataTable = $('#lookup').DataTable( {
          "responsive": true,
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"<?php echo base_url("laporan/ajax") ?>", // json datasource
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
    <h4><strong><font color=blue>DATA TAGIHAN KONSUMEN</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

<?php
      $query = $this->db->query("SELECT sum(ii.totalharga) as totalharusbayar 
        FROM isi_invoice ii, invoice i, spp sp, penawaran p, pelanggan pg
        WHERE ii.id_invoice=i.id
        and i.id_spp=sp.id
        and sp.id_penawaran=p.id
        AND p.id_pelanggan=pg.id
        AND i.statusbayar=0");

      foreach ($query->result() as $rowC) { 
        $totalharusbayar = $rowC->totalharusbayar;
      }
?>

    <div class="form-group">
      <button class="btn btn-success">Rp. <?php echo number_format($totalharusbayar,0,',','.'); ?></button>
    </div>

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>PELANGGAN</th>
                    <th>NOMOR INVOICE</th>
                    <th>TAGIHAN</th>
                    <th>JT. TEMPO</th>
        </tr>
      </thead>

      <tbody>
      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->