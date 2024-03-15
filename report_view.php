<?php require_once('include/header.php') ?>
<?php require_once('include/sidebar.php') ?>

<?php
// Initialize the total sum variable
$totalInc = $totalexp= 0;
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Monthly Report</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= $base_url?>index.php">Account</a></li>
              <li class="breadcrumb-item active">Monthly Report</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body booking_card">
                    <?php
                        $year=$_GET['s_year']??date('Y');
                        $month=$_GET['s_month']??date('m');
                    ?>
                    <form action="" method="get">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for=""> Year</label>
                                    <select class="form-control" name="s_year">
                                        <?php for($i=2022; $i <= date('Y'); $i++){ ?>
                                        <option value="<?= $i ?>" <?= $year==$i?"selected":"" ?>><?= $i ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for=""> Month</label>
                                    <select class="form-control" name="s_month">
                                        <?php for($i=1; $i <= 12; $i++){ ?>
                                        <option value="<?= $i ?>" <?= $month==$i?"selected":"" ?>><?= date('F', mktime(0, 0, 0, $i, 10)); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group"><br>
                                    <button class="btn btn-primary" type="submit">Get Report</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="datatable table table-stripped table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <td style="vertical-align:top">
                                        <table class="table">
                                            <tr>
                                                <td>Type</td>
                                                <td>Date</td>
                                                <td>Amount</td>
                                            </tr>
                                            <?php
                                                $rs = $mysqli->common_select_query("SELECT date(`created_at`) as dt, sum(`pay_amount`) as total FROM `student_payment` where year(created_at)=$year and month(created_at)=$month group by date(`created_at`)");
                                                if ($rs['data']) {
                                                    foreach ($rs['data'] as $i => $d) {
                                                        $totalInc += $d->total; // Update the total sum variable

                                            ?>
                                                <tr>
                                                    <td>Student Payment</td>
                                                    <td><?= $d->dt ?></td>
                                                    <td><?= $d->total ?></td>
                                                </tr>
                                            <?php } } ?>
                                            <?php
                                                $rs = $mysqli->common_select_query("SELECT date(`transaction_date`) as dt, sum(`amount`) as total FROM `transaction` where year(transaction_date)=$year and month(transaction_date)=$month and `account_head_id` in (SELECT id from account_head WHERE account_head.account_type='Income') group by date(`transaction_date`)");
                                                if ($rs['data']) {
                                                    foreach ($rs['data'] as $i => $d) {
                                                        $totalInc += $d->total; // Update the total sum variable

                                            ?>
                                                <tr>
                                                    <td>Other Income</td>
                                                    <td><?= $d->dt ?></td>
                                                    <td><?= $d->total ?></td>
                                                </tr>
                                            <?php } } ?>
                                        </table>
                                    </td>
                                    <td style="vertical-align:top">
                                    <table class="table">
                                            <tr>
                                                <td>Type</td>
                                                <td>Date</td>
                                                <td>Amount</td>
                                            </tr>
                                            <?php
                                                $rs = $mysqli->common_select_query("SELECT date(`transaction_date`) as dt, sum(`amount`) as total FROM `transaction` where year(transaction_date)=$year and month(transaction_date)=$month and `account_head_id` in (SELECT id from account_head WHERE account_head.account_type='Expense') group by date(`transaction_date`)");
                                                if ($rs['data']) {
                                                    foreach ($rs['data'] as $i => $d) {
                                                        $totalexp += $d->total; // Update the total sum variable

                                            ?>
                                                <tr>
                                                    <td>Expense</td>
                                                    <td><?= $d->dt ?></td>
                                                    <td><?= $d->total ?></td>
                                                </tr>
                                            <?php } } ?>
                                        </table>
                                    </td>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td class="text-right font-weight-bold">Total Income: <?= $totalInc ?></td>
                                   
                                    <td class="text-right font-weight-bold ">Total Expense: <?= $totalexp ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-right font-weight-bold">Profit <?= ($totalInc - $totalexp) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row no-print">
                <div class="col-12">
                  <a onclick="window.print()" href="#" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Display the total sum -->


<?php include_once('include/footer.php') ?>
