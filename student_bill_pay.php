<?php require_once('include/header.php'); ?>
<?php require_once('include/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Student Bill Pay</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= $base_url ?>dashboard">Home</a></li>
            <li class="breadcrumb-item active">Pay</li>
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
        <?php
          $bill_id = $_GET['id'];
          $already_pay=0;
          $paybill=$mysqli->common_select_query("select sum(pay_amount) as payment from student_payment where bill_id=$bill_id");
          if($paybill){
            if(!empty($paybill['data'])){
              $already_pay=$paybill['data'][0]->payment;
            }
          }
          $where['id']=$bill_id;
          $bill_details=$mysqli->common_select_single("student_monthly_bill","*",$where);
          if($bill_details){
            if(!empty($bill_details['data'])){
              $d=$bill_details['data'];
            }
          }
          $student_id=$d->student_id;
        ?>

          <div class="card card-danger">
            <form enctype="multipart/form-data" action="" method="post">
              <div class="card-header">
                <h3 class="card-title"> Student Bill Payment</h3>
              </div>
              <div class="card-body">
                <div class="row ">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Student:</label>
                      <select class="custom-select mr-sm-2" id="">
                        <?php
                            $data=$mysqli->common_select('student');
                            if(!$data['error']){
                              foreach($data['data'] as $dt){
                          ?>
                              <option <?= $student_id==$dt->id?"selected":"disabled" ?> value="<?= $dt->id ?>"><?= $dt->name ?> (<?= $dt->contact?>)</option>
                          <?php } } ?>
                        </select>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Year:</label>
                      <select class="custom-select mr-sm-2" id="">
                      <?php 
                        $year_start  = 2023;
                        $year_end = date('Y') + 1; 
                        $selected_year=date('Y',strtotime($d->bill_month));
                        for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
                            $selected = $selected_year == $i_year ? ' selected' : 'disabled';
                            echo '<option value="'.$i_year.'"'.$selected.'>'.$i_year.'</option>'."\n";
                        }
                    ?>
                        </select>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Month:</label>
                      <select class="custom-select mr-sm-2" id="">
                      <?php
                        $selected_month=date('m',strtotime($d->bill_month));
                        for ($i_month = 1; $i_month <= 12; $i_month++) { 
                            $selected = $selected_month == $i_month ? ' selected' : 'disabled';
                            echo '<option value="'.$i_month.'"'.$selected.'>'. date('F', mktime(0,0,0,$i_month)).'</option>'."\n";
                        }
                      ?>
                        </select>
                    </div>
                  </div>
                  
                  <div class="col-sm-12">
                    
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
                      <tfoot>
                        <tr>
                          <td></td>
                          <td> Total: </td>
                          <td><?= $totalamount ?></td>
                        </tr>
                        <tr>
                          <td ></td>
                          <td> Pay: </td>
                          <td><?= $already_pay ?></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td> Due: </td>
                          <td><?= $due=$totalamount - $already_pay ?></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td> Pay Now: </td>
                          <td> 
                            <input type="text" name="pay_amount" class="form-control" value="<?= $totalamount - $already_pay ?>">
                            <input type="hidden" name="bill_id" class="form-control" value="<?= $bill_id ?>">
                           </td>
                        </tr>
                      </tfoot>
                    </table>
                    
                  </div>

                  <div class="col-sm-12">
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </div>
                <!-- Date dd/mm/yyyy -->
                <?php
                  if($_POST){
                    $_POST['created_at']=date('Y-m-d H:i:s');
                    $rs=$mysqli->common_create('student_payment',$_POST);
                      if(!$rs['error']){
                        if($due>0){
                          $pamt=$_POST['pay_amount'] - $due;
                          if($pamt==0){
                            $updata['bill_status']=1;
                            $rsm=$mysqli->common_update('student_monthly_bill',$updata,$where);
                          }
                        }
                      echo "<script>window.location='student_bill_view.php?student_id=".$student_id."'
                      </script>";
                      }else{
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
