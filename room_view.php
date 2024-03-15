<?php require_once('include/header.php'); ?>
<?php require_once('include/sidebar.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Rooms</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= $base_url?>index.php">Home</a></li>
              <li class="breadcrumb-item active">List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Viewing All Rooms</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <a href="room_create.php" class="btn btn-success form-control mb-2">Add New Room</a>
            <table id="datatable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>#SL</th>
                <th>Room No</th>
                <th>Air Condition</th>
                <th>Wifi</th>
                <th class="text-center">Action</th>
              </tr>
              </thead>
              <tbody>
                <?php
                  $data=$mysqli->common_select('room');
                  if(!$data['error']){
                    foreach($data['data'] as $d){
                    
                ?>
                      <tr>
                        <td><?= $d->id ?></td>
                        <td><?= $d->room_no ?></td>
                        <td><?= $d->aircondition ?></td>
                        <td><?= $d->wifi?></td>
                        <td class="text-center">
                        <a title="Update" href="room_update.php?id=<?= $d->id ?>">
                            <i class="fa fa-edit"></i>
                          </a>
                          <a title="Delete" class="text-danger" href="room_delete.php?id=<?= $d->id ?>">
                            <i class="fa fa-trash"></i>
                          </a>
                        </td>
                      </tr>
                <?php
                    }
                  }
                ?>
              </tbody>
            </table>
          </div><!-- /.card-body -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
<?php require_once('include/footer.php'); ?>

<!-- DataTables  & Plugins -->
<script src="<?= $base_url?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= $base_url?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= $base_url?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= $base_url?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= $base_url?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= $base_url?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= $base_url?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?= $base_url?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= $base_url?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= $base_url?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= $base_url?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= $base_url?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $(function () {
    $("#datatable").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "pdf", "colvis"]
    }).buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');
   
  });
</script>