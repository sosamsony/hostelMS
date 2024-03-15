<?php require_once('include/header.php'); ?>
<?php require_once('include/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Upadte Income</h1>
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
                <h3 class="card-title">Edit Income Details</h3>
              </div>

              <?php
              $where['id'] = $_GET['id'];
              $data = $mysqli->common_select('transaction', '*', $where);

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
                      <label>Account Head Id:</label>
                      <select class="custom-select mr-sm-2" id="" name="account_head_id">
                        <?php
                        $data = $mysqli->common_select('account_head');
                        if (!$data['error']) {
                          foreach ($data['data'] as $dt) {
                        ?>
                            <option value="<?= $dt->id ?>"><?= $dt->head_code ?></option>
                        <?php }
                        } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Amount:</label>
                      <input type="text" name="amount" class="form-control" placeholder="Seat No" value="<?= $d->amount ?>">
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Transaction Date:</label>
                      <input type="date" name="transaction_date" class="form-control" value="<?= $d->transaction_date ?>">
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
                  $rs = $mysqli->common_update('transaction', $_POST, $where);
                  if (!$rs['error']) {
                    echo "<script>window.location='income_view.php'</script>";
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