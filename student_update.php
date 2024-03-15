<?php require_once('include/header.php'); ?>
<?php require_once('include/sidebar.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Update Student</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= $base_url?>dashboard">Home</a></li>
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
                  <h3 class="card-title">Edit Student's Information</h3>
                </div>

                <?php
                  $where['id']=$_GET['id'];
                  $data=$mysqli->common_select('student','*',$where);
                  if(!$data['error'] && count($data['data'])>0)
                    $d=$data['data'][0];
                  else{
                    echo "<h2 class='text-danger text-center'>This url is not correct</h2>";
                    exit;
                  }
                  $room_data=$mysqli->common_select_query('select room_id,seat_id from student where seat_id!="'.$d->seat_id.'"');
                  $room_data_json=array();
                  if(!$room_data['error'] && count($room_data['data'])>0){
                    foreach($room_data['data'] as $rd){
                      $room_data_json[$rd->room_id][]=$rd->seat_id;
                    }
                  }
                  
                ?>

                <div class="card-body">
                  <div class="row ">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Name:</label>
                        <input type="text" name="name" class="form-control" placeholder="Full Name" value="<?= $d->name ?>">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Father's Name:</label>
                        <input type="text" name="father" class="form-control" placeholder="Full Name" value="<?= $d->father ?>">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Mother's Name:</label>
                        <input type="text" name="mother" class="form-control" placeholder="Full Name" value="<?= $d->mother ?>">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Contact:</label>
                        <input type="text" name="contact" class="form-control" placeholder="+880" value="<?= $d->contact ?>"> 
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Guardian Contact:</label>
                        <input type="text" name="guardian_contact" class="form-control" placeholder="+880" value="<?= $d->guardian_contact ?>">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>NID:</label>
                        <input type="text" name="nid_bc" class="form-control" placeholder="National Id Card Number" value="<?= $d->nid_bc ?>">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Room:</label>
                        <select onchange="seat_check(this.value)" class="custom-select mr-sm-2" id="room_id" name="room_id">
                          <option value="">Select Room</option>
                          <?php
                            $data=$mysqli->common_select('room');
                            if(!$data['error']){
                              foreach($data['data'] as $dt){
                          ?>
                              <option value="<?= $dt->id ?>"><?= $dt->room_no ?></option>
                          <?php } } ?>
                        </select> 
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Seat:</label>
                        <select class="custom-select mr-sm-2" id="seat_id" name="seat_id">
                          <option value="">Select Seat</option>
                          <?php
                            $data=$mysqli->common_select('seat');
                            if(!$data['error']){
                              foreach($data['data'] as $dt){
                          ?>
                              <option data-room="room<?= $dt->room_id ?>seat<?= $dt->id ?>" class="seat seat<?= $dt->room_id ?>" <?= $d->seat_id==$dt->id?"selected":"" ?> value="<?= $dt->id ?>"><?= $dt->seat_no ?></option>
                          <?php } } ?>
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
                    if($_POST){
                      $rs=$mysqli->common_update('student',$_POST,$where);
                      if(!$rs['error']){
                        echo "<script>window.location='student_view.php'</script>";
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
<script>
  var roomdata=<?= json_encode($room_data_json); ?>;
  for(i in roomdata){
    for(s in roomdata[i]){
      $("option[data-room='room" + i +"seat"+ roomdata[i][s] +"']").remove();
    }
  }
  
  seat_check(<?= $d->room_id ?>)
  function seat_check(e){
    $('.seat').hide();
    $('#seat_id').val('');
    $('.seat'+e).show();
  }
  $('#room_id').val('<?= $d->room_id ?>');
  $('#seat_id').val('<?= $d->seat_id ?>');
</script>