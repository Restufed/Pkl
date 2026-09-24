<?php
require_once '../database/koneksi.php';
$halaman = 'data_Mahasiswa';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>

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
          <div class="col-sm-6"><h1 class="m-0">Edit Data Mahasiswa</h1></div>
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
                <h3 class="card-title">Edit Data Mahasiswa</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action ="proses_edit.php" method = "post">
                <div class="card-body">
                  <?php
                 $nim= $_GET['nim'];
                 $query_panggil_Mahasiswa = mysqli_query($db, "SELECT nim, nama, kontak, email, kelamin, img FROM tb_mahasiswa WHERE nim='$nim'") or die(mysqli_error($db));
                 $data = mysqli_fetch_array($query_panggil_Mahasiswa);
                     $nim = $data['nim'];
                     $nama = $data['nama'];
                     $kontak= $data['kontak'];
                     $email= $data['email'];
                     $kelamin= $data['kelamin'];
                    $img= $data['img'];
                  ?>
                  <input type="hidden" name="nim" value=" <?=$nim;['nim']; ?>"hidden>

                   <form action ="proses_tambah.php" method = "post">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nim</label>
                    <input type="text" name="nim" class="form-control" value="<?= $nim; ?>"  id="nim" placeholder="Masukan nim" readonly>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama</label>
                   <input type="text" name="nama" class="form-control" value="<?= $nama; ?>" id="nama" placeholder="Masukan Nama" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">kontak</label>
                   <input type="number" name="kontak" class="form-control" value="<?= $kontak; ?>"  id="kontak" placeholder="Masukan Nomor " required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">email</label>
                    <input type="text" name="email" class="form-control"  value="<?= $email; ?>" id="email" placeholder="Masukan email " required>
                  </div>
                  
                   <!-- select -->
                      <div class="form-group">
                        <label>Jenis kelamin</label>
                        <select class="form-control"  name="kelamin" required>
                            <option value="">-- Pilih jenis kelamin -- </option>
                          
                          <option value="L" <?php if ($kelamin =='L') {echo'selected';}?>>Laki-Laki</option>
                          <option value="P" <?= ($kelamin == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                      </div>
                     </div>
                 
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name ="btn-edit" class="btn btn-primary">Edit data siswa</button>
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