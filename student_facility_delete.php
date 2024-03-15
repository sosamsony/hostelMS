<?php require_once('include/header.php'); ?>
<?php require_once('include/sidebar.php'); ?>

<?php
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $where = array('id' => $id);
  $rs = $mysqli->common_delete('student_facility', $where);

  if (!$rs['error']) {
    echo "<script>window.location='student_facility_view.php'</script>";
    exit();
  } else {
    echo "Error: " . $rs['error'];
  }
} else {
  echo "Error: No ID specified.";
}
?>

<?php require_once('include/footer.php'); ?>
