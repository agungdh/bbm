<?php
  //if(!empty($this->input->post('username')) and !empty($this->input->post('password'))){
	if(( $this->input->post('username') !== null ) and ($this->input->post('password')!== null)){
		$sql = "SELECT *, count(*) total FROM users
    WHERE username = ?
    and password = ?";
    $query = $this->db->query($sql, array($this->input->post('username'), md5($this->input->post('password'))));
    foreach ($query->result() as $item) {
      $data_session = array(
        'id' => $item->id,
        'nama' => $item->nama,
        'username' => $item->username,
        'level' => $item->level,
        'total' => $item->total,
        'status' => "login"
        );
     } 
     if ($data_session['total'] > 0) {
      $this->session->set_userdata($data_session);
     }
    redirect(base_url());
	} else {    
?>

<!DOCTYPE html>

<html>



  <head>
    <?php $this->load->view('template/meta'); ?>
  </head>

  <body class="hold-transition login-page" style="background-image: url('<?php echo base_url();?>assets/logo/hijau.jpg')">

    <div class="login-box" 
        style="margin: 50;
          width: 400px;
          position: relative;
          border-radius: 15px;
          background: #aaffbb;
          box-shadow: 3px 3px 20px 5px #000;">    

      <div class="login-logo">
        <img src="<?php echo base_url("assets/logo/logo.png"); ?>" 
          height="15%" width="15%"><br>

        <a href=""><b>Pelangi</b>Soft</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Isi Username dan Password</p>
        <form role="form" method="post">
          
          <div class="form-group has-feedback">
            <input name="username" type="text" class="form-control" placeholder="Username:">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          
          <div class="form-group has-feedback">
            <input name="password" type="password" class="form-control" placeholder="Password:">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          
          <div class="row">
            <div class="col-xs-8">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
            </div><!-- /.col -->
          </div>
                            
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

  </body>
</html>
<?php
  }
?>
