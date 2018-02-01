<div class="box box-primary">
	<div class="box-header with-border">
    <h4><strong><font color=blue>DATA USER</font></strong></h4>
	</div><!-- /.box-header -->
	<!-- form start -->
	
	<form role="form" method="post" name="user">
		<div class="box-body">
		
			<div class="form-group">
				<label for="username">Nama User</label>
				<input type="text" class="form-control" id="username" name="username" placeholder="Nama User">
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			</div>

			<div class="form-group">
				<label for="level">Level Akses</label>
				<select class="form-control" id="level" name="level">
					<option value="1">Level User</option>
					<option value="2">Level Tamu</option>
					<option value="0">Level Administrator</option>
				</select>
			</div>

			<div class="form-group">
				<label for="avatar">Avatar</label>
				<select class="form-control" id="avatar" name="avatar">
					<option value="avatar1.png">Pilihan Avatar 01</option>
					<option value="avatar2.png">Pilihan Avatar 02</option>
					<option value="avatar3.png">Pilihan Avatar 03</option>
					<option value="avatar4.png">Pilihan Avatar 04</option>
					<option value="avatar5.png">Pilihan Avatar 05</option>
				</select>
			</div>
			
		</div><!-- /.box-body -->

		<div class="box-footer">
			<input type="submit" class="btn btn-primary" name="proses" value="Simpan Data User"></input>
		</div>
	</form>
</div><!-- /.box -->

<?php
if ($this->input->post('proses')) {
  $username = $this->input->post('username');
  $password = $this->input->post('password');
  $level = $this->input->post('level');
  $avatar = $this->input->post('avatar');
  
  if ( $username == null || $password == NULL ) 
  {
		?>
			<script>
				alertModal('<i class="icon fa fa-close"></i> Gagal!!','Data KOSONG tidak dapat disimpan...');
			</script>		
		<?php
		return;
  }
		
  $query = $this->db->query("select * from users where username=?", array($username));

  $row = $query->num_rows();

	if ( $row == 0 )
	{
		  $this->db->query("insert into users 
		  		set username=?,
		  			password=?,
		  			level=?,
		  			avatar=?", array($username,
		  							md5($password),
		  							$level,
		  							$avatar
		  				));
		?>
		<script>
			alertModalOk('<i class="icon fa fa-check"></i> Berhasil!','Data USER sudah disimpan');
		</script>
		<?php 

	} else {
		?>
			<script>
				alertModal('<i class="icon fa fa-close"></i> Gagal!!','Data USER sudah dipakai...');
			</script>		
		<?php
	} 
  
}
?>
