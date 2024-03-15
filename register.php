<?php
$base_url = "http://localhost/hostel/";
require_once('class/crud.php');
$mysqli = new crud;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hostel MS Admin Panel | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= $base_url ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= $base_url ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $base_url ?>assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition register-page">
  <div class="register-box w-50 shadow-lg">
    <div class="card card-outline card-primary">
      <div class="card-header text-center py-0">
        <a href="<?= $base_url ?>assets/index2.html" class="h1"><b>Hostel <span class="h2"><b>Management System</b></span> <br></b>Admin Panel</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg py-0">Register for a New Admin Account</p>

        <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Full Name:</label>
          <div class="input-group mb-3">
            <input type="text" name="name" class="form-control" placeholder="Enter Full name">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <label for="email">Email Address:</label>
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="example@email.com">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <label for="phone">Phone Number:</label>
          <div class="input-group mb-3">
            <input type="text" name="contact_no" class="form-control" placeholder="+880">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
          </div>
          <label for="password">Password:</label>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Enter a Strong Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <label for="cpassword">Retype Password:</label>
          <div class="input-group mb-3">
            <input type="password" name="cpassword" class="form-control" placeholder="Confirm password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <label for="image">Upload Image:</label>
          <div class="input-group mb-3">
            <input type="file" name="image" class="form-control" accept="image/*">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-image"></span>
              </div>
            </div>
          </div>

          <div class="row">
          <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
            <div class="col-8 text-right">
              <!-- <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                <label for="agreeTerms">
                  I agree to the <a href="#">terms</a>
                </label>
              </div> -->
              <a href="login.php" class="text-success"><b>Already have an Account? Log In</b></a>
            </div>
            <!-- /.col -->
            
        
            
            <!-- /.col -->
          </div>
        </form>
        <?php
        if ($_POST) {
          $pass = trim($_POST['password']);
          $cpass = trim($_POST['cpassword']);
          if ($pass !== $cpass) {
            echo "Both passwords are not the same";
            exit;
          }
          $_POST['password'] = sha1(md5($_POST['password']));
          unset($_POST['cpassword']);

          // Upload the image
          if ($_FILES['image']['name']) {
            $image = $_FILES['image']['name'];
            $target = "upload/users/" . basename($image);
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
              $_POST['image'] = $image;
            } else {
              echo "Failed to upload the image.";
              exit;
            }
          }

          // Insert user data into the database
          $rs = $mysqli->common_create('sign_in', $_POST);
          if (!$rs['error']) {
            echo "<script>window.location='login.php'</script>";
          } else {
            echo $rs['error'];
          }
        }
        ?>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- jQuery -->
  <script src="<?= $base_url ?>assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= $base_url ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= $base_url ?>assets/dist/js/adminlte.min.js"></script>
</body>

</html>