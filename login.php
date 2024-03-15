<?php
session_start();
if (isset($_SESSION['userid'])) {
  echo "<script>window.location='dashboard.php'</script>";
  exit;
}
$base_url = "http://localhost/hostel/";
require_once('class/crud.php');
$mysqli = new crud;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hostel MS Admin Panel | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= $base_url ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= $base_url ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $base_url ?>assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box w-auto shadow-lg">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="<?= $base_url ?>assets/index2.html" class="h1"><b>Hostel <span class="h2"><b>Management System</b></span> <br></b>Admin Panel</a>
      </div>
      <div class="card-body ">
        <p class="login-box-msg ">Sign in to start your session</p>

        <form action="" method="post">
            <label for="email">Username or Email:</label>
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Username or Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <label for="password">Password:</label>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <?php
        if ($_POST) {
          $where['email'] = $_POST['email'];
          $where['password'] = sha1(md5($_POST['password']));

          $rs = $mysqli->common_select('sign_in', '*', $where);
          if (!$rs['error']) {
            if (isset($rs['data'][0])) {
              $_SESSION['userid'] = $rs['data'][0]->id;
              $_SESSION['username'] = $rs['data'][0]->name;
              $_SESSION['contact'] = $rs['data'][0]->contact_no;
              $_SESSION['email'] = $rs['data'][0]->email;
            }
            echo "<script>window.location='dashboard.php'</script>";
          } else {
            echo $rs['error'];
          }
        }

        ?>

        <div class="col-12 pb-0">
        <p class="my-1 text-center">
          <a href="forgot-password.html" class="text-danger">Forgot Your Password? Click Here</a>
        </p>
        <p class="mb-0 mt-3 pb-0 text-center">
          <a href="register.php" class="text-success"><b>Don't have an account? <br> Click Here to Register for a New Account</b></a>
        </p>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?= $base_url ?>assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= $base_url ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= $base_url ?>assets/dist/js/adminlte.min.js"></script>
</body>

</html>