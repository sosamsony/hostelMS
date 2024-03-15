<?php require_once('include/header.php'); ?>
<?php require_once('include/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Student</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= $base_url ?>index.php">Home</a></li>
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
          <h3 class="card-title">Viewing Students Data</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <a href="student_create.php" class="btn btn-success form-control mb-2">Add New Student</a>
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#SL</th>
                <th>Name</th>
                <th>Father's Name</th>
                <th>Mother's Name</th>
                <th>Contact No</th>
                <th>Guardian's Contact No</th>
                <th>NID</th>
                <th>Seat No</th>
                <th class="text-center">Bill List</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $data = $mysqli->common_select_query("SELECT student.*,seat.seat_no FROM `student`
                  join seat on seat.id=student.seat_id
                  WHERE student.deleted_at is null");
              if (!$data['error']) {
                foreach ($data['data'] as $d) {

              ?>
                  <tr>
                    <td><?= $d->id ?></td>
                    <td><?= $d->name ?></td>
                    <td><?= $d->father ?></td>
                    <td><?= $d->mother ?></td>
                    <td><?= $d->contact ?></td>
                    <td><?= $d->guardian_contact ?></td>
                    <td><?= $d->nid_bc ?></td>
                    <td><?= $d->seat_no ?></td>
                    <td class="text-center">
                      <a title="Bill List" href="student_bill_view.php?student_id=<?= $d->id ?>">
                        <i class="fa fa-list"></i>
                      </a>
                    </td>
                    <td class="text-center">
                      <a title="Update" href="student_update.php?id=<?= $d->id ?>">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a title="Delete" class="text-danger" href="student_delete.php?id=<?= $d->id ?>">
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                  </tr>
              <?php }
              } ?>
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
<script src="<?= $base_url ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= $base_url ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= $base_url ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= $base_url ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= $base_url ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= $base_url ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= $base_url ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?= $base_url ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= $base_url ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= $base_url ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= $base_url ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= $base_url ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $(function() {
    $("#datatable").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');

  });
</script>