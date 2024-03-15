<?php require_once('include/header.php'); ?>
<?php require_once('include/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Add Student Bill</h1>
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
        <?php
          $student_id = $_GET['student_id'];
          $lastbill=$mysqli->common_select_query("SELECT month(`bill_month`) as m, year(`bill_month`) as y FROM `student_monthly_bill` WHERE student_id=$student_id order by `bill_month` desc LIMIT 1");
          if($lastbill){
            if(!empty($lastbill['data'])){
              if($lastbill['data'][0]->m ==12){
                $selected_month =1; //current month
                $selected_year = $lastbill['data'][0]->y + 1; // current Year
              }else{
                $selected_month =$lastbill['data'][0]->m + 1; //current month
                $selected_year =$lastbill['data'][0]->y; // current Year
              }
            }else{
              $selected_month = date('m'); //current month
              $selected_year = date('Y'); // current Year
            }
          }
        ?>

          <div class="card card-danger">
            <form enctype="multipart/form-data" action="" method="post">
              <div class="card-header">
                <h3 class="card-title">Add Student Bill Details</h3>
              </div>
              <div class="card-body">
                <div class="row ">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Student:</label><br>
                        <?php
                          $student_ddata=$mysqli->common_select_query("SELECT student.id,student.name,student.contact,seat.rent,seat.seat_no FROM `student` join seat on seat.id=student.seat_id where student.id=$student_id");
                          if(!$student_ddata['error']){
                            
                        ?>
                        <input type="hidden" name="student_id" value="<?= $student_id ?>">
                        <?= $student_ddata['data'][0]->name ?> (<?= $student_ddata['data'][0]->contact?>)
                        <?php }  ?>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Year:</label>
                      <select class="custom-select mr-sm-2" id="" name="bill_year">
                      <?php 
                        $year_start  = 2023;
                        $year_end = date('Y') + 1; 
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
                      <select class="custom-select mr-sm-2" id="" name="bill_month">
                      <?php
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
                        <th>Total</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php
                          $data=$mysqli->common_select_query("SELECT facility.name as fac,facility.amount,facility.count_type,facility.id FROM `student_facility` join facility on facility.id=student_facility.facility_id where student_facility.student_id=$student_id ");
                            $totalamount=0;
                            foreach($data['data'] as $d){
                        ?>
                              <tr>
                                <td><?= $d->fac ?> (<?= $d->amount ?>) </td>
                                <td><?= $d->count_type==1?"Daily":"Monthly" ?></td>
                                <td>
                                  <?php
                                    $totaldays=cal_days_in_month(CAL_GREGORIAN,$selected_month,$selected_year);
                                    $qty=$d->count_type==1?$totaldays:1;
                                    echo $qty." x ".$d->amount." = ".$qty*$d->amount;
                                  ?>
                                  
                                </td>
                                <td>
                                  <?php  $amount=$qty*$d->amount; $totalamount+=$amount; ?>
                                  <?=  $amount; ?>
                                  <input type="hidden" name="amount[]" value="<?= $amount ?>">
                                  <input type="hidden" name="facility_id[]" value="<?= $d->id ?>">
                                </td>
                              </tr>
                        <?php } ?>
                              <tr>
                                <td>Room Rent (<?= $student_ddata['data'][0]->rent ?>)</td>
                                <td>Monthly</td>
                                <td>
                                    1 x <?= $student_ddata['data'][0]->rent ?> = <?= $student_ddata['data'][0]->rent ?>
                                </td>
                                <td>
                                  <?php  $amount=$student_ddata['data'][0]->rent; $totalamount+=$amount; ?>
                                  <?=  $amount; ?>
                                  <input type="hidden" name="amount[]" value="<?= $amount ?>">
                                  <input type="hidden" name="facility_id[]" value="0">
                                </td>
                              </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="2"></td>
                          <td> Total: </td>
                          <td>
                            <input type="hidden" name="total" value="<?= $totalamount ?>">
                            <?= $totalamount ?>
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
                    $pdata['student_id']=$_POST['student_id'];
                    $pdata['bill_month']=$_POST['bill_year']."-".$_POST['bill_month']."-28";
                    $pdata['amount']=$_POST['total'];
                    $pdata['bill_status']=0;
                    $pdata['created_at']=date('Y-m-d H:i:s');
                    $rs=$mysqli->common_create('student_monthly_bill',$pdata);
                      if(!$rs['error']){
                        if($_POST['facility_id']){
                          foreach($_POST['facility_id'] as $i=>$m){
                            $bdt['bill_id']=$rs['data'];
                            $bdt['facility_id']=$m;
                            $bdt['bill_month']=$_POST['bill_year']."-".$_POST['bill_month']."-28";
                            $bdt['amount']=$_POST['amount'][$i];
                            $rsm=$mysqli->common_create('student_monthly_bill_details',$bdt);
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
