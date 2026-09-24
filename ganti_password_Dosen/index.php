<?php
require_once '../database/koneksi.php';
$halaman = 'ganti_password_Dosen';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin</title>

  <?php include '../library.php'; ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
           Hallo,<?= $_SESSION['nama']; ?> <i class="fas fa-user-secret"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="profile.php" class="dropdown-item"><i class="fas fa-user mr-2"></i> Profile</a>
          <div class="dropdown-divider"></div>
          <a href="../logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt mr-2"></i> Keluar</a>
        </div>
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.php" class="brand-link">
      <img src="../aset_adminlte/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Sistem Manajemen</span>
    </a>
    <div class="sidebar">
     <?php include '../sidebar_dosen.php'; ?>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="card-header">
      <h3 class="card-title">Ganti Password</h3>
    </div>

    <div class="content">
      <div class="container-fluid">
       <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Password</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action ="proses_ganti_password.php" method = "post">
                <div class="card-body">
                    <?php 
                    $user = $_SESSION['user'];
                    $nama = $_SESSION['nama'];
                     ?>
                  <div class="form-group">
                    <label for="exampleInputEmail1">username</label>
                    <input type="text" name="username" class="form-control" value= "<?= $user ?>" id="username" placeholder="Masukan username" readonly>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= $nama ?>" id="nama" placeholder="Masukan Nama" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">password Baru</label>
                    <input type="password" name="pwbaru" class="form-control" id="pwbaru" placeholder="Masukan password Baru" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">konfirmasi password Baru</label>
                   <input type="password" name="password" class="form-control" id="password" placeholder="Ulangi password baru" required>
                  </div>
                   <!-- select -->
                     
                </div> 
                <!-- /.card-body -->
   <div class="card-footer">
      <button type="submit" name="btn-ganti" class="btn btn-primary">Ganti Password</button>
    </div>
  </form>  
     </div>
            <!-- /.card -->
      </div>
    </div>
  </div>

  <aside class="control-sidebar control-sidebar-dark"></aside>

  <footer class="main-footer">
    <strong> &copy; </strong> All rights reserved.
  </footer>
</div>

<?php include '../script.php'; ?>
</body>
</html>