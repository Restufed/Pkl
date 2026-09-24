<?php
require_once '../database/koneksi.php';
$halaman = 'data_akademik_superadmin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Data akademik</title>

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
          <div class="col-sm-6"><h1 class="m-0">Edit Data akademik</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Data akademik</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php
              $Kode_akademik = $_GET['kode'];
              $query_edit_akademik = mysqli_query($db, "SELECT * FROM tb_akademik WHERE kode_akademik='$Kode_akademik'") or die(mysqli_error($db));
              $data = mysqli_fetch_array($query_edit_akademik);
              $Kode_akademik = $data['kode_akademik'];
              $Semester = $data ['Semester'];
              $Tahun = $data['Tahun'];
              $status = $data['is_active'];
              
              ?>

              <form action="proses_edit.php" method="post">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Kode_akademik</label>
                    <input type="text" name="kode" value= "<?=$Kode_akademik;?>" class="form-control" id="kode" placeholder="Masukan kode" require>
                  </div>
                   <div class="form-group">
                        <label></label>
                        <select class="form-control"  name="semester" required>
                            <option value="">-- Pilih Semester -- </option>
                          <option value="GN" <?= ($Semester == 'GN') ? 'selected' : ''; ?> >Genap</option>
                          <option value="GL"<?= ($Semester == 'GL') ? 'selected' : ''; ?> >Ganjil</option>
                        </select>
                      </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Tahun</label>
                   <input type="number" name="tahun"  value= "<?=$Tahun;?>" class="form-control" id="Tahun" placeholder="Masukan Tahun " required>
                  </div>
                      <div class="form-group">
                        <label></label>
                        <select class="form-control"  name="status" required>
                            <option value="">-- Status -- </option>
                          <option value="1"<?= ($status == '1') ? 'selected' : ''; ?>>Aktif</option>
                          <option value="0"<?= ($status == '0') ? 'selected' : ''; ?> >Tidak Aktif</option>
                        </select>
                      </div>
                  <!-- select -->
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="btn-edit" class="btn btn-primary">Edit jurusan</button>
                  <a href="index.php" class="btn btn-secondary float-right">Batal</a>
                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>
        </div>
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