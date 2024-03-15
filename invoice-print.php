<?php require_once('include/header.php'); ?>
<?php require_once('include/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Invoice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Invoice</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Hostel MS
                    <small class="float-right">Date: <?= date('M-d, Y') ?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>Hostel MS Admins</strong><br>
                    Sholoshahar, 2no. Gate<br>
                    Chittagong, BD 1000<br>
                    Phone: (+880) 1867-655403<br>
                    Email: info@wdpf54.tech
                  </address>
                </div>
                <?php
                  $bill_id = $_GET['id'];
                  $data = $mysqli->common_select_query("SELECT student.name,student.contact,student.guardian_contact,student_monthly_bill.* FROM `student_monthly_bill`
                  join student on student.id=student_monthly_bill.student_id
                  WHERE student_monthly_bill.id=$bill_id");
                  if (!$data['error']) 
                    $bill=$data['data'][0];
                ?>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong><?= $bill->name ?></strong><br>
                    Phone: <?= $bill->contact ?><br>
                    Guardian's Contact: <?= $bill->guardian_contact ?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice #<?= $bill->id ?></b><br>
                  <br>
                  <b>Bill Month:</b> <?= date('M',strtotime($bill->bill_month)) ?>, <?= date('Y',strtotime($bill->bill_month)) ?><br>
                  <b>Total:</b> <?= $bill->amount ?>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                <table id="datatable" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Facility</th>
                        <th>Bill Type</th>
                        <th>Sub Total</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php
                          $selected_month=date('m',strtotime($bill->bill_month));
                          $selected_year=date('Y',strtotime($bill->bill_month));
                          $already_pay=0;
                          $paybill=$mysqli->common_select_query("select sum(pay_amount) as payment from student_payment where bill_id=$bill_id");
                          if($paybill){
                            if(!empty($paybill['data'])){
                              $already_pay=$paybill['data'][0]->payment;
                            }
                          }

                          $data=$mysqli->common_select_query("SELECT facility.name as fac,student_monthly_bill_details.amount,facility.amount as famt,facility.count_type, student_monthly_bill_details.facility_id FROM `student_monthly_bill_details` left join facility on facility.id=student_monthly_bill_details.facility_id where student_monthly_bill_details.bill_id=$bill_id");
                            $totalamount=0;
                            foreach($data['data'] as $d){
                              if($d->facility_id==0){
                                ?>
                                  <tr>
                                    <td>Room Rent (<?= $d->amount ?>)</td>
                                    <td>Monthly</td>
                                    <td>
                                        1 x <?= $d->amount ?> = <?= $d->amount ?>
                                    
                                      <?php  $amount=$d->amount; $totalamount+=$amount; ?>
                                    </td>
                                  </tr>
                                <?php }else{ ?>
                              <tr>
                                <td><?= $d->fac ?> (<?= $d->famt ?>) </td>
                                <td><?= $d->count_type==1?"Daily":"Monthly" ?></td>
                                <td>
                                  <?php
                                    $totaldays=cal_days_in_month(CAL_GREGORIAN,$selected_month,$selected_year);
                                    $qty=$d->count_type==1?$totaldays:1;
                                    echo $qty." x ".$d->famt." = ".$qty*$d->famt;
                                  ?>
                                  
                                
                                  <?php 
                                  $amount=$qty*$d->famt;
                                  $totalamount+=$amount; ?>
                                </td>
                              </tr>
                        <?php }} ?>
                      </tbody>
                    </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Total:</th>
                        <td>BDT <?= $totalamount ?></td>
                      </tr>
                      <tr>
                        <th>Due:</th>
                        <td>BDT <?= $totalamount - $already_pay ?></td>
                      </tr>
                      <tr>
                        <th>Paid :</th>
                        <td>BDT <?= $already_pay ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a onclick="window.print()" href="#" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

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
  //window.addEventListener("load", window.print());
</script>