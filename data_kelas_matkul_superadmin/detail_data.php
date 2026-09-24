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
            <ol class="breadcrumb float-sm-right">
            </ol>
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
                <div class="row">
                  <!-- Kolom Kiri -->
                  <div class="col-md-6">
                    <table class="table table-borderless table-sm">
                      <tr>
                        <td width="35%"><strong>Periode Akademik</strong></td>
                        <td width="5%">:</td>
                        <td>
                          <?php
                          
                          $id = $_GET['id'];

                          $query_kelas = mysqli_query($db, "SELECT * FROM tb_kelas_matkul WHERE id = '$id'") or die(mysqli_error($db));
                          $data = mysqli_fetch_array($query_kelas);
                          if (!$data) {
                              $data = array('kode_akademik' => '', 'kode_jurusan' => '', 'kode_matkul' => '', 'nik' => '', 'nama_kelas' => '-');
                          }

                          $kode_akademik = $data['kode_akademik'];
                          $kode_jurusan  = $data['kode_jurusan'];
                          $kode_matkul   = $data['kode_matkul'];
                          $nik           = $data['nik'];

                          // Query akademik dipanggil di sini, tepat sebelum dipakai
                          $query_akademik = mysqli_query($db, "SELECT Tahun, Semester FROM tb_akademik WHERE kode_akademik = '$kode_akademik'") or die(mysqli_error($db));
                          $data_akademik  = mysqli_fetch_array($query_akademik);
                          if (!$data_akademik) {
                              $data_akademik = array('Tahun' => '-', 'Semester' => '-');
                          }
                          echo $data_akademik['Tahun'] . ' - ' . (($data_akademik['Semester'] == 'GN') ? 'Genap' : 'Ganjil');
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td><strong>Nama Kelas</strong></td>
                        <td>:</td>
                        <td><?= $data['nama_kelas']; ?></td>
                      </tr>
                      <tr>
                        <td><strong>Jurusan</strong></td>
                        <td>:</td>
                        <td>
                          <?php
                          // Query jurusan dipanggil di sini, tepat sebelum dipakai
                          $query_jurusan = mysqli_query($db, "SELECT nama_jurusan FROM tb_jurusan WHERE kode_jurusan = '$kode_jurusan'") or die(mysqli_error($db));
                          $data_jurusan  = mysqli_fetch_array($query_jurusan);
                          if (!$data_jurusan) {
                              $data_jurusan = array('nama_jurusan' => '-');
                          }
                          echo $data_jurusan['nama_jurusan'];
                          ?>
                        </td>
                      </tr>
                    </table>
                  </div>

                  <!-- Kolom Kanan -->
                  <div class="col-md-6">
                    <table class="table table-borderless table-sm">
                      <tr>
                        <td width="30%"><strong>Mata Kuliah</strong></td>
                        <td width="5%">:</td>
                        <td>
                          <?php
                          $query_matkul = mysqli_query($db, "SELECT nama_matkul FROM tb_matkul WHERE kode_matkul = '$kode_matkul'") or die(mysqli_error($db));
                          $data_matkul  = mysqli_fetch_array($query_matkul);
                          if (!$data_matkul) {
                              $data_matkul = array('nama_matkul' => '-');
                          }
                          echo $data_matkul['nama_matkul'] . ' - ' . $kode_matkul;
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td><strong>Dosen</strong></td>
                        <td>:</td>
                        <td>
                          <?php
                          // Query dosen dipanggil di sini, tepat sebelum dipakai
                          $query_dosen = mysqli_query($db, "SELECT nama, nik FROM tb_dosen WHERE nik = '$nik'") or die(mysqli_error($db));
                          $data_dosen  = mysqli_fetch_array($query_dosen);
                          if (!$data_dosen) {
                              $data_dosen = array('nama' => '-', 'nik' => '');
                          }
                          echo $data_dosen['nama'] . ' - ' . $data_dosen['nik'];
                          ?>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>

                <!-- Tombol Action -->
                 <div class="mt-3 mb-3">
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-tambah-mahasiswa"><i class="fas fa-plus"></i> Tambah Mahasiswa</button>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-import">
                   <i class="fas fa-file-excel"></i> Import Data 
                </button>
                  <a href="index.php" class="btn btn-secondary btn-sm float-right"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Mahasiswa</th>
                    <th width="10%" class="text-center">Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                      // Query daftar peserta dipanggil di sini, tepat sebelum loop-nya
                      $q_mhs = mysqli_query($db, "SELECT tb_peserta.id as id_peserta, tb_peserta.nim, tb_mahasiswa.nama 
                                                      FROM tb_peserta 
                                                      JOIN tb_mahasiswa ON tb_peserta.nim = tb_mahasiswa.nim 
                                                      WHERE tb_peserta.id_kelas = '$id'") 
                                      or die(mysqli_error($db));

                      $no = 1;
                      while ($mhs = mysqli_fetch_array($q_mhs)) {
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>
                            <?= $mhs['nama']; ?> - <?= $mhs['nim']; ?>
                        </td>
                        <td class="text-center">
                            <a href="proses_hapus_siswa.php?id=<?= $mhs['id_peserta']; ?>&id_kelas=<?= $id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah kamu yakin ingin menghapus mahasiswa ini dari kelas?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
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

<div class="modal fade" id="modal-tambah-mahasiswa">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Mahasiswa ke Kelas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form action="proses_tambah_siswa.php" method="post">
        <div class="modal-body">
          <input type="hidden" name="id_kelas" value="<?= $id; ?>">

          <div class="form-group">
            <label for="nim">Pilih Mahasiswa</label>
            <select name="nim" class="form-control" id="nim" required>
              <option value="" disabled selected>-- Pilih Mahasiswa --</option>
              <?php
              // Query dropdown mahasiswa dipanggil di sini, tepat sebelum loop-nya
              $query_panggil_mhs = mysqli_query($db, "
                    SELECT nim, nama FROM tb_mahasiswa
                    WHERE nim NOT IN (
                        SELECT nim FROM tb_peserta WHERE id_kelas = '$id'
                    )
              ") or die(mysqli_error($db));

              while ($data_mhs = mysqli_fetch_array($query_panggil_mhs)) {
                  ?>
                  <option value="<?= $data_mhs['nim']; ?>"><?= $data_mhs['nim']; ?> - <?= $data_mhs['nama']; ?></option>
                  <?php
              }
              ?>
            </select>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" name="btn_tambah_siswa">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-import">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Import Data Kelas Mata Kuliah</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="proses_import_mahasiswa.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class = "row">
            <div class ="col-6">
              <center>
            <label>Download template </label>
           <a href="template/template_peserta.xls" class="btn btn-xs btn-info ml-1 mb-1"><i class="fas fa-download"></i> Download </a>
           </center>
            </div>
             <div class ="col-6">
              <center>
              <label>Download Data Mahasiswa </label>
           <a href="../data_pengguna_mahasiswa/export_excel.php" class="btn btn-xs btn-info ml-1 mb-1"><i class="fas fa-download"></i> Download </a>
           </center>
             </div>
          </div>
          
          <div class="form-group">
           <input type ="hidden" value = "<?= $id; ?>" name = "id_kelas">
           <label for="upload" >uplod file</label>
            <input type="file" name="file_kelas_matkul" class="form-control" accept=".xlsx, .xls" required>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="btn_import">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<?php include '../script.php'; ?>
</body>
</html>