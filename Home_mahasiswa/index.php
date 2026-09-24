<?php
require_once '../database/koneksi.php';

// Pastikan session peran terdefinisi dan bersihkan spasi
$peran = isset($_SESSION['peran']) ? trim($_SESSION['peran']) : '';

if ($peran != 'M') {
    echo '<script>window.location.href="../logout.php"</script>';
    exit();
} else {
    $halaman = 'Home_Mahasiswa';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Mahasiswa</title>

  <!-- Include the main CSS & JavaScript library file -->
  <?php include '../library.php'; ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar / Top Header Section -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links (Sidebar Toggle Button & Main Menu) -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links (Profile & Logout) -->
    <ul class="navbar-nav ml-auto">
      <!-- User Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Hallo, <?= isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Mahasiswa'; ?> <i class="far fa-id-card ml-1"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="profile.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="../logout.php" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container (Side Menu) -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../aset_adminlte/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Sistem Manajemen</span>
    </a>

    <!-- Sidebar Menu Content -->
    <div class="sidebar">
     <?php include '../sidebar_Mahasiswa.php'; ?>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content (Main Content) -->
  <div class="content-wrapper">
    <!-- Content Header (Page header & Breadcrumb) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Selamat Datang, <?= isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Mahasiswa'; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right"></ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main Content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
            <!-- Tempat menaruh isi konten nantinya -->

          </div>
        </div>
      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar (Optional Right Side) -->
  <aside class="control-sidebar control-sidebar-dark"></aside>

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong> &copy; </strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- Include Footer Script / JS -->
<?php include '../script.php'; ?>
</body>
</html>
<?php } ?>