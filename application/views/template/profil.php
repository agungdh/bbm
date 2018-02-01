<?php
$query = $this->db->query("SELECT * FROM users WHERE id = ?",array($this->session->id));

foreach ($query->result() as $item) { ?>
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4><strong><font color=blue>UBAH DATA PROFIL</font></strong></h4>
    </div><!-- /.box-header -->
    <!-- form start -->
      <div class="box-body">

    <form role="form" method="post">
                  <!-- text input -->

                  <div class="form-group">
                    <label>Username</label>
                    <input disabled value="<?php echo $item->username; ?>" name="username" type="text" class="form-control" placeholder="Masukkan Username">
                  </div>

                  <div class="form-group">
                    <label>Nama</label>
                    <input value="<?php echo $item->nama; ?>" name="nama" type="text" class="form-control" placeholder="Masukkan Nama">
                  </div>

                  <div class="form-group">
                    <label>Password</label>
                    <input name="password" type="password" class="form-control" placeholder="Masukkan Password">
                  </div>

        <input class="btn btn-primary" name="submit" type="submit" value="Simpan Perubahan" />
    </form>
    </div><!-- /.boxbody -->
  </div><!-- /.box -->
 <?php } ?>


<?php
if ($this->input->post('submit')) {
  $nama = $this->input->post('nama');
  $password = $this->input->post('password');

  if ($nama == null || $password == null) {
    ?>
    <script type="text/javascript">
      alert('Gagal!!\nAda Data KOSONG, tidak dapat disimpan...');
    </script>
    <?php
    return;
  }

  $sql = "UPDATE users
  set nama = ?,
  password = ?
  WHERE id = ?";
  $this->db->query($sql, array($nama, md5($password), $this->session->id));

    ?>
    <script>
      window.location = "<?php echo base_url(); ?>";
    </script>
    <?php 
}

?>