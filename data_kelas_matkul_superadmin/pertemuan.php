<?php
require_once '../database/koneksi.php';
$halaman = 'data_kelas_matkul_superadmin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail Data Kelas Mata Kuliah</title>

  <?php include '../library.php'; ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Hallo, <?= $_SESSION['nama']; ?> <i class="fas fa-user-secret"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="profile.php" class="dropdown-item"><i class="fas fa-user mr-2"></i> Profile</a>
          <div class="dropdown-divider"></div>
          <a href="../logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt mr-2"></i> Keluar</a>
        </div>
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.php" class="brand-link">
      <img src="../aset_adminlte/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Sistem Manajemen</span>
    </a>
    <div class="sidebar">
     <?php include '../sidebar_admin.php'; ?>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1 class="m-0">Detail Data Kelas Mata Kuliah</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right"></ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Data Kelas Mata Kuliah</h3>
              </div>
              
              <div class="card-body">
              <?php     
                // Pemanggilan ID tanpa ternary operator
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                } else {
                    $id = '';
                }

                $query_kelas = mysqli_query($db, "SELECT * FROM tb_kelas_matkul WHERE id = '$id'") or die(mysqli_error($db));
                $data = mysqli_fetch_array($query_kelas);

                $kode_akademik = isset($data['kode_akademik']) ? $data['kode_akademik'] : '';
                $kode_jurusan  = isset($data['kode_jurusan']) ? $data['kode_jurusan'] : '';
                $kode_matkul   = isset($data['kode_matkul']) ? $data['kode_matkul'] : '';
                $nik           = isset($data['nik']) ? $data['nik'] : '';

                // Query dosen
                $query_dosen = mysqli_query($db, "SELECT * FROM tb_dosen WHERE nik = '$nik'") or die(mysqli_error($db));
                $data_dosen  = mysqli_fetch_array($query_dosen);
                $kelamin = isset($data_dosen['kelamin']) ? $data_dosen['kelamin'] : '';
                $img     = isset($data_dosen['img']) ? $data_dosen['img'] : NULL;
              ?>

              <!-- Tampilan 5 Kolom Sejajar Ke Samping -->
              <div class="row mb-4">
                
                <!-- 1. Periode Akademik -->
                <div class="col">
                  <table class="table table-borderless table-sm m-0">
                    <tr>
                      <td><strong>Periode Akademik</strong></td>
                      <td>:</td>
                      <td> 
                        <?php 
                        $query_akademik = mysqli_query($db, "SELECT Tahun, Semester FROM tb_akademik WHERE kode_akademik = '$kode_akademik'") or die(mysqli_error($db));
                        $data_akademik  = mysqli_fetch_array($query_akademik);
                        
                        $tahun_akademik = isset($data_akademik['Tahun']) ? $data_akademik['Tahun'] : '';
                        $sem_akademik   = isset($data_akademik['Semester']) ? $data_akademik['Semester'] : '';
                        
                        if ($sem_akademik == 'GN') {
                            $text_semester = 'Genap';
                        } else {
                            $text_semester = 'Ganjil';
                        }

                        echo $tahun_akademik . ' - ' . $text_semester;
                        ?>
                      </td>
                    </tr>
                  </table>
                </div>

                <!-- 2. Jurusan -->
                <div class="col">
                  <table class="table table-borderless table-sm m-0">
                    <tr>
                      <td><strong>Jurusan</strong></td>
                      <td>:</td>
                      <td>
                        <?php 
                        $query_jurusan = mysqli_query($db, "SELECT nama_jurusan FROM tb_jurusan WHERE kode_jurusan = '$kode_jurusan'") or die(mysqli_error($db));
                        $data_jurusan  = mysqli_fetch_array($query_jurusan);
                        if (isset($data_jurusan['nama_jurusan'])) {
                            echo $data_jurusan['nama_jurusan'];
                        }
                        ?>
                      </td>
                    </tr>
                  </table>
                </div>

                <!-- 3. Mata Kuliah -->
                <div class="col">
                  <table class="table table-borderless table-sm m-0">
                    <tr>
                      <td><strong>Mata kuliah</strong></td>
                      <td>:</td>
                      <td>
                        <?php
                        $query_matkul = mysqli_query($db, "SELECT nama_matkul FROM tb_matkul WHERE kode_matkul = '$kode_matkul'") or die(mysqli_error($db));
                        $data_matkul  = mysqli_fetch_array($query_matkul);
                        $nama_matkul  = isset($data_matkul['nama_matkul']) ? $data_matkul['nama_matkul'] : '';
                        
                        echo $nama_matkul . ' - ' . $kode_matkul; 
                        ?>
                      </td>
                    </tr>
                  </table>
                </div>

                <!-- 4. Dosen -->
                <div class="col">
                  <table class="table table-borderless table-sm m-0">
                    <tr>
                      <td><strong>Dosen</strong></td>
                      <td>:</td>
                      <td>
                        <?php 
                        $nama_dosen = isset($data_dosen['nama']) ? $data_dosen['nama'] : '';
                        $nik_dosen  = isset($data_dosen['nik']) ? $data_dosen['nik'] : '';
                        echo $nama_dosen . ' - ' . $nik_dosen;
                        ?>
                      </td>
                    </tr>
                  </table>
                </div>

                <!-- 5. Nama Kelas -->
                <div class="col">
                  <table class="table table-borderless table-sm m-0">
                    <tr>
                      <td><strong>Nama Kelas</strong></td>
                      <td>:</td>
                      <td>
                        <?php 
                        if (isset($data['nama_kelas'])) {
                            echo $data['nama_kelas'];
                        }
                        ?>
                      </td>
                    </tr>
                  </table>
                </div>

              </div>

              <!-- Tombol Action -->
              <div class="mb-3 clearfix">
                <a href="index.php" class="btn btn-primary btn-sm mr-1">
                  <i class="fas fa-arrow-left"></i> Kembali
                </a>
                 <a href="export_data_pertemuan_pdf.php?id_kelas=<?= $id; ?>" class="btn btn-danger btn-sm">
                 <i class="fas fa-file-pdf"></i> Export Pdf
                  </a>
                <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#modal-tambah-pertemuan">
                  <i class="fas fa-plus"></i> Tambah Pertemuan
                </button>
              </div>

              <!-- Tabel Data Pertemuan -->
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="5%" class="text-center">No</th>
                    <th>Pertemuan Ke</th>
                    <th>Judul Pertemuan</th>
                    <th width="15%">Tanggal</th>
                    <th width="15%" class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query_pertemuan = mysqli_query($db, "SELECT * FROM tb_pertemuan WHERE id_kelas = '$id' ORDER BY pertemuan_ke ASC") or die(mysqli_error($db));
                  $rv = mysqli_num_rows($query_pertemuan);

                  if ($rv > 0) {
                      $no = 1;
                      while ($data_pertemuan = mysqli_fetch_array($query_pertemuan)) {
                          $id_pertemuan    = $data_pertemuan['id'];
                          $pertemuan_ke    = $data_pertemuan['pertemuan_ke'];
                          $judul_pertemuan = $data_pertemuan['judul_pertemuan'];
                          $tanggal         = $data_pertemuan['tanggal'];
                          ?>
                          <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td>Pertemuan Ke-<?= $pertemuan_ke; ?></td>
                            <td><?= $judul_pertemuan; ?></td>
                            <td><?= $tanggal; ?></td>
                            <td class="text-center">
                              <!-- FIX: sekarang kirim id_pertemuan juga, bukan cuma id kelas -->
                              <a href="presensi.php?id=<?= $id; ?>&id_pertemuan=<?= $id_pertemuan; ?>" class="btn btn-info btn-sm" title="Lihat Presensi / QR">
                                <i class="fas fa-qrcode"></i>
                              </a>
                            </td>
                          </tr>
                          <?php
                      } 
                  }     
                  ?>
                </tbody>
              </table>
              </div>

            </div>

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

<!-- Modal Tambah Data Pertemuan -->
<div class="modal fade" id="modal-tambah-pertemuan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data Pertemuan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form action="proses_tambah_pertemuan.php" method="post">
        <div class="modal-body">
          <input type="hidden" name="id_kelas" value="<?= $id; ?>">

          <div class="form-group">
            <label for="judul_pertemuan">Judul Pertemuan</label>
            <input type="text" name="judul_pertemuan" class="form-control" placeholder="masukkan judul pertemuan" required>
          </div>
        </div>
        
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="btn_tambah">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include '../script.php'; ?>
</body>
</html>