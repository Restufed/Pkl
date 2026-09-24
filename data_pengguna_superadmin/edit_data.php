<?php
require_once '../database/koneksi.php';
$halaman = 'data_pengguna';
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
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>
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
     <?php include '../sidebar_admin.php'; ?>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1 class="m-0">Edit Data pengguna</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
       <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Data pengguna</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action ="proses_edit.php" method = "post">
                <div class="card-body">
                  <?php
                 $id = $_GET['id'];
                 $query_panggil_pengguna = mysqli_query($db, "SELECT nama, username, peran FROM tb_pengguna WHERE id='$id'") or die(mysqli_error($db));
                 $data = mysqli_fetch_array($query_panggil_pengguna);
                  $nama =$data ['nama'];
                  $username=$data ['username'];
                  $peran =$data ['peran'];
                  ?>
                  <input type="hidden" name="id" value=" <?=$id;['id']; ?> "hidden>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama</label>
                    <input type="text" name="nama" value="<?=$nama; ?>" class="form-control" id="nama" placeholder="Masukan Nama" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">username</label>
                    <input type="text" name="username"  value="<?= $username; ?>"class="form-control" id="username" placeholder="Masukan username" required>
                  </div>
                   <!-- select -->
                      <div class="form-group">
                        <label>Peran</label>
                        <select class="form-control" name="peran" required>
                            <option value="">-- Pilih peran -- </option>
                          <option value="M" <?php if ($peran =='M') {echo'selected';}?>>Mahasiswa</option>
                          <option value="D" <?= ($peran == 'D') ? 'selected' : ''; ?>>Dosen</option>
                          <option value="S" <?= ($peran == 'S') ? 'selected' : ''; ?>>Super Admin</option>
                        </select>
                      </div>
                </div>
                 
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name ="btn-edit" class="btn btn-primary">Edit data</button>
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