<?php require_once('include/header.php'); ?>
<?php require_once('include/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">

          <?php
          $student = $_GET['student_id'];
          $data = $mysqli->common_select_query("SELECT student.name, seat.seat_no, room.room_no FROM student JOIN seat ON student.seat_id = seat.id JOIN room ON seat.room_id = room.id WHERE student.id = $student");
          if (!$data['error'] && count($data['data']) > 0) {
            $d = $data['data'][0]; ?>
            <h1>Bill Details of <?= $d->name ?></h1>
            <b>Room No: <?= $d->room_no ?>, Seat No: <?= $d->seat_no ?></b>
          <?php }
          ?>


        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= $base_url ?>index.php">Home</a></li>
            <li class="breadcrumb-item active">Bill List</li>
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
          <h3 class="card-title">View Bills</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <a href="student_bill_create.php?student_id=<?= $_GET['student_id'] ?>" class="btn btn-success form-control mb-2">Add New Bill</a>
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Month</th>
                <th>Amount</th>
                <th>Due</th>
                <th>Pay Status</th>
                <th class="text-center">Bill Pay</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $student = $_GET['student_id'];
              $data = $mysqli->common_select_query("SELECT *,(select sum(pay_amount) from student_payment where student_payment.bill_id=student_monthly_bill.id) as pay, month(bill_month) as m, year(bill_month) as y FROM `student_monthly_bill` where student_monthly_bill.student_id=$student");
              if (!$data['error']) {
                foreach ($data['data'] as $d) {
              ?>
                  <tr>
                    <td><?= $d->y ?>/<?= date('F', mktime(0, 0, 0, $d->m))  ?></td>
                    <td><?= $d->amount ?></td>
                    <td><?= ($d->amount - $d->pay) ?></td>
                    <td><?= $d->bill_status ? "Paid" : "Unpaid" ?></td>
                    <td class="text-center">
                      <a title="Bill Pay" href="student_bill_pay.php?id=<?= $d->id ?>">
                      <i class="far fa-money-bill-alt" aria-hidden="true"></i>  Bill Pay Option
                      </a>
                    </td>
                    <td class="text-center">
                      <?php if ($d->pay <= 0) { ?>
                        <a title="Delete" class="text-danger" href="student_bill_delete.php?id=<?= $d->id ?>">
                          <i class="fa fa-trash"></i>
                        </a>
                      <?php } ?>
                   
                      <a title="Invoice" href="invoice-print.php?id=<?= $d->id ?>">
                        <i class="fa-solid fa-receipt"></i> View Invoice
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
      "buttons": ["excel", "pdf", "colvis"]
    }).buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');

  });
</script>