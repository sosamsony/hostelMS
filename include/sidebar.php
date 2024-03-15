<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="dashboard.php" class="brand-link">
    <img src="<?= $base_url ?>assets/dist/img/AdminLTELogo.png" alt="Admin Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Hostel MS</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <?php if (isset($_SESSION['image'])) { ?>
          <img src="<?= $base_url ?>upload/users/<?= $_SESSION['image'] ?>" class="img-circle elevation-2" alt="User Image">
        <?php } else { ?>
          <img src="<?= $base_url ?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        <?php } ?>
      </div>
      <div class="info">
        <a href="#" class="d-block"><?= isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest' ?></a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item" style="background-color: rgba(255, 255, 255, .1);">
          <a href="dashboard.php" class=" nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              <b>Dashboard</b>
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fa-solid fa-house-chimney-window nav-icon"></i>
            <p><b>Manage Room</b></p>
            <i class="right fas fa-angle-left"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= $base_url ?>room_view.php" class="nav-link">
                <i class="fa-solid fa-door-open nav-icon"></i>
                <p>View Rooms</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $base_url ?>room_create.php" class="nav-link">
                <i class="fa-solid fa-house-circle-check nav-icon"></i>
                <p>Add Rooms</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-bed nav-icon"></i>
            <p><b>Manage Seats</b></p>
            <i class="right fas fa-angle-left"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= $base_url ?>seat_view.php" class="nav-link">
                <i class="fa-solid fa-bed-pulse nav-icon"></i>
                <p>View All Seats</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $base_url ?>seat_create.php" class="nav-link">
                <i class="fa-solid fa-chair nav-icon"></i>
                <p>Add New Seat</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fa-solid fa-cube nav-icon"></i>
            <p><b>Facilities</b></p>
            <i class="right fas fa-angle-left"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= $base_url ?>facility_view.php" class="nav-link">
                <i class="fa-solid fa-icons nav-icon"></i>
                <p>View Facilities</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $base_url ?>facility_create.php" class="nav-link">
                <i class="fa-solid fa-crosshairs nav-icon"></i>
                <p>Add Facility</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fa-solid fa-people-roof nav-icon"></i>
            <p><b>Student Facilities</b></p>
            <i class="right fas fa-angle-left"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= $base_url ?>student_facility_view.php" class="nav-link">
                <i class="fa-solid fa-universal-access nav-icon"></i>
                <p>View Student Facilities</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $base_url ?>student_facility_create.php" class="nav-link">
                <i class="fa-solid fa-person-shelter nav-icon"></i>
                <p>Add Student Facility</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fa-solid fa-people-group nav-icon"></i>
            <p><b>Student Details</b></p>
            <i class="right fas fa-angle-left"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= $base_url ?>student_view.php" class="nav-link">
                <i class="fa-solid fa-users-between-lines nav-icon"></i>
                <p>View All Student Details</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $base_url ?>student_create.php" class="nav-link">
                <i class="fa-solid fa-user-graduate nav-icon"></i>
                <p>Add New Student</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $base_url ?>bill_details.php" class="nav-link">
                <i class="fa-solid fa-file-invoice-dollar nav-icon"></i>
                <p>View Student Bills</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fa-sharp fa-solid fa-money-bill-transfer nav-icon"></i>
            <p><b>Transaction</b></p>
            <i class="right fas fa-angle-left"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= $base_url ?>income_view.php" class="nav-link">
                <i class="fa-solid fa-sack-dollar nav-icon"></i>
                <p>Income</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $base_url ?>expense_view.php" class="nav-link">
                <i class="fa-solid fa-hand-holding-dollar nav-icon"></i>
                <p>Expense</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $base_url ?>report_view.php" class="nav-link">
                <i class="fa-solid fa-file-signature nav-icon"></i>
                <p>Monthly Reports</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="<?= $base_url ?>account_head_view.php" class="nav-link">
            <i class="fa-sharp fa-solid fa-award nav-icon"></i>
            <p>
              <b>Account Head</b>
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="<?= $base_url ?>user_view.php" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              <b>User</b>
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>