<?php require_once('include/header.php'); ?>
<?php require_once('include/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Update Room</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= $base_url ?>dashboard">Home</a></li>
            <li class="breadcrumb-item active">Add New</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">

          <div class="card card-danger">
            <form enctype="multipart/form-data" action="" method="post">
              <div class="card-header">
                <h3 class="card-title">Edit Room Details</h3>
              </div>
              <?php
              $where['id'] = $_GET['id'];
              $data = $mysqli->common_select('room', '*', $where);

              if (!$data['error'] && count($data['data']) > 0)
                $d = $data['data'][0];
              else {
                echo "<h2 class='text-danger text-center'>This url is not correct</h2>";
                exit;
              }
              ?>
              <div class="card-body">
                <div class="row ">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Room No:</label>
                      <input type="text" name="room_no" class="form-control" placeholder="Room No. " value="<?= $d->room_no ?>">
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Air Condition:</label>
                      <select class="custom-select mr-sm-2" id="" name="aircondition" value="<?= $d->aircondition ?>">
                        <option value="AC"<?= ($d->aircondition=="AC")?'selected':'' ?>>AC</option>
                        <option value="Non-AC"<?= ($d->aircondition=="Non-AC")?'selected':'' ?>>Non-AC</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Wifi:</label>
                      <select class="custom-select mr-sm-2" id="" name="wifi" value="<?= $d->wifi ?>">
                        <option value="Yes"<?= ($d->wifi=="Yes")?'selected':'' ?>>Yes</option>
                        <option value="No"<?= ($d->wifi=="No")?'selected':'' ?>>No</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </div>
                <!-- Date dd/mm/yyyy -->

                <?php
                if ($_POST) {
                  $rs = $mysqli->common_update('room', $_POST, $where);
                  if (!$rs['error']) {
                    echo "<script>window.location='room_view.php'</script>";
                  } else {
                    echo $rs['error'];
                  }
                }
                ?>
              </div>

            </form>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

        </div>
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<?php require_once('include/footer.php'); ?>