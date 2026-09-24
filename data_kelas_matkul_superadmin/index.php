<?php
require_once '../database/koneksi.php';
$halaman = 'data_kelas_matkul_superadmin';
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Main content -->
    <div class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
            </div>
          </div>
        </div>

        <?php
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'sukses') {
                echo '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        Data kelas mata kuliah berhasil ditambahkan!
                      </div>';
            } elseif ($_GET['status'] == 'gagal') {
                echo '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        Gagal menambahkan data, silakan coba lagi.
                      </div>';
            }
        }
        ?>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Kelas mata kuliah</h3>
          </div>
          <div class="card-body">
            <button type="button" class="btn btn-success btn-sm mb-3" data-toggle="modal" data-target="#modal-tambah">
              Tambah Data 
            </button>
            <button type="button" class="btn btn-danger btn-sm mb-3" data-toggle="modal" data-target="#modal-import">
              <i class="fas fa-file-excel"></i> Import Data 
            </button>
            <a href="export_excel.php" class="btn btn-success btn-sm mb-3">
              <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="export_pdf.php" class="btn btn-danger btn-sm mb-3">
              <i class="fas fa-file-pdf"></i> Export Pdf
            </a>
            
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>akademik</th>
                  <th>Jurusan</th>
                  <th>Matkul</th>
                  <th>Nama Dosen</th>
                  <th>Nama Kelas</th>
                  <th>aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query_kelas_matkul = mysqli_query($db, "SELECT * FROM tb_kelas_matkul") or die(mysqli_error($db));
                $rv = mysqli_num_rows($query_kelas_matkul);
                if ($rv > 0) { 
                    $no = 1;
                    while ($data = mysqli_fetch_array($query_kelas_matkul)) {
                        $id            = $data['id'];
                        $kode_akademik = $data['kode_akademik'];
                        $query_akademik = mysqli_query($db, "SELECT Tahun, Semester FROM tb_akademik WHERE kode_akademik = '$kode_akademik'") or die(mysqli_error($db));
                        $data_akademik  = mysqli_fetch_array($query_akademik);

                        $kode_jurusan  = $data['kode_jurusan'];
                        $query_jurusan = mysqli_query($db, "SELECT nama_jurusan FROM tb_jurusan WHERE kode_jurusan = '$kode_jurusan'") or die(mysqli_error($db));
                        $data_jurusan  = mysqli_fetch_array($query_jurusan);
                        $nama_jurusan   = $data_jurusan['nama_jurusan'];

                        $kode_matkul  = $data['kode_matkul'];
                        $query_matkul = mysqli_query($db, "SELECT nama_matkul FROM tb_matkul WHERE kode_matkul = '$kode_matkul'") or die(mysqli_error($db));
                        $data_matkul  = mysqli_fetch_array($query_matkul);

                        $nik        = $data['nik'];
                        $query_dosen = mysqli_query($db, "SELECT nama, nik FROM tb_dosen WHERE nik = '$nik'") or die(mysqli_error($db));
                        $data_dosen  = mysqli_fetch_array($query_dosen);

                        $nama_kelas    = $data['nama_kelas'];
                        ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td><?= $data_akademik['Tahun']; ?> - <?= ($data_akademik['Tahun'] == 'GN') ? 'Genap' : 'Ganjil'; ?></td>
                          <td><?= $nama_jurusan; ?></td>
                          <td><?= $data_matkul['nama_matkul']; ?></td>
                          <td><?= $nik; ?> - <?= $data_dosen['nama']; ?></td>
                          <td><?= $nama_kelas; ?></td>
                          <td>
                            <a class="btn btn-sm btn-info" href="detail_data.php?id=<?= $id; ?>"><i class="fas fa-info-circle"></i> Detail</a>   
                            <a class= "btn-sm btn-primary" href = "pertemuan.php?id=<?= $id; ?>"  ><i class = "fas fa-qrcode"></i></a>
                            <a name="btn_edit" class="btn btn-sm fas fa-edit btn-warning" href="edit_data.php?id=<?= $kode_matkul ?>"><i></i></a>
                            <a class="btn btn-sm btn-danger" href="proses_hapus.php?id=<?= $id; ?>" onclick="return confirm('Apakah kamu yakin menghapus data ini?')"><i class="fas fa-trash"></i></a>
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

  <aside class="control-sidebar control-sidebar-dark"></aside>
  <footer class="main-footer">
    <strong> &copy; </strong> All rights reserved.
  </footer>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data kelas Matakuliah</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="proses_tambah.php" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="kode_akademik">Kode Akademik</label>
            <select name="kode_akademik" class="form-control" id="kode_akademik" required>
              <option value="" disabled selected>-- Pilih Kode Akademik --</option>
              <?php
              $q_akademik = mysqli_query($db, "SELECT kode_akademik, Tahun, Semester FROM tb_akademik") or die(mysqli_error($db));
              while ($row_akademik = mysqli_fetch_array($q_akademik)) {
                  echo '<option value="' . $row_akademik['kode_akademik'] . '">' 
                        . $row_akademik['kode_akademik'] . ' - ' . $row_akademik['Tahun'] . ' / ' . $row_akademik['Semester'] 
                        . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label for="kode_jurusan">Kode Jurusan</label>
            <select name="kode_jurusan" class="form-control" id="kode_jurusan" required>
              <option value="" disabled selected>-- Pilih Kode Jurusan --</option>
              <?php
              $q_jurusan = mysqli_query($db, "SELECT kode_jurusan, nama_jurusan FROM tb_jurusan") or die(mysqli_error($db));
              while ($row_jurusan = mysqli_fetch_array($q_jurusan)) {
                  echo '<option value="' . $row_jurusan['kode_jurusan'] . '">' 
                        . $row_jurusan['kode_jurusan'] . ' - ' . $row_jurusan['nama_jurusan'] 
                        . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label for="kode_matkul">Kode Mata kuliah</label>
            <select name="kode_matkul" class="form-control" id="kode_matkul" required>
              <option value="" disabled selected>-- Pilih Kode Matkul --</option>
              <?php
              $q_matkul = mysqli_query($db, "SELECT kode_matkul, nama_matkul FROM tb_matkul") or die(mysqli_error($db));
              while ($row_matkul = mysqli_fetch_array($q_matkul)) {
                  echo '<option value="' . $row_matkul['kode_matkul'] . '">' 
                        . $row_matkul['kode_matkul'] . ' - ' . $row_matkul['nama_matkul'] 
                        . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label for="nik">NIK</label>
            <select name="nik" class="form-control" id="nik" required>
              <option value="" disabled selected>-- Pilih Dosen --</option>
              <?php
              $q_dosen = mysqli_query($db, "SELECT nik, nama FROM tb_dosen") or die(mysqli_error($db));
              while ($row_dosen = mysqli_fetch_array($q_dosen)) {
                  echo '<option value="' . $row_dosen['nik'] . '">' 
                        . $row_dosen['nik'] . ' - ' . $row_dosen['nama'] 
                        . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label for="nama_kelas">Nama Kelas</label>
            <input type="text" name="nama_kelas" class="form-control" id="nama_kelas" placeholder="Masukkan Nama Kelas" required>
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

<div class="modal fade" id="modal-import">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Import Data Kelas Mata Kuliah</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="proses_import.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label>Download template </label>
           <a href="template_kelas_matkul.xlsx" class="btn btn-xs btn-info ml-1 mb-1"><i class="fas fa-download"></i> Download Template</a>
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
<script>
  $('#modal-edit').on('show.bs.modal', function(e){
    var kode_akademik = $(e.relatedTarget).data('kode_jurusan');
    var kode_jurusan = $(e.relatedTarget).data('kode_jurusan');
    var kode_matkul = $(e.relatedTarget).data('kode_matkul');
    var nik = $(e.relatedTarget).data('nik');
    var nama_kelas = $(e.relatedTarget).data('nama_kelas');
   
    $(e.currentTarget).find('input[name="id"]').val(kode_matkul);
    $(e.currentTarget).find('input[name="kode_akademik"]').val(kode_akademik);
    $(e.currentTarget).find('input[name="kode_jurusan"]').val(kode_jurusan);
    $(e.currentTarget).find('input[name="name"]').val(kode_matkul);
    $(e.currentTarget).find('input[name="nik"]').val(nik);
    $(e.currentTarget).find('input[name="nama_kelas"]').val(nama_kelas);
  });
</script>

</body>
</html>