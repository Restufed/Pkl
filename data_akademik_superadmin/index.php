<?php
require_once '../database/koneksi.php';
$halaman = 'data_akademik_superadmin';
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
          <div class="col-sm-6"><h1 class="m-0"></h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data akademik</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-tambah">
              Tambah Data 
            </button>
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-import">
              <i class="fas fa-file-excel"></i> Import Data 
            </button>
            <a href="export_excel.php" class="btn btn-success btn-sm">
              <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="export_pdf.php" class="btn btn-danger btn-sm">
              <i class="fas fa-file-pdf"></i> Export Pdf
            </a>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>kode akademik </th>
                  <th>Semester</th>
                  <th>Tahun</th>
                  <th>Status</th>
                  <th> aksi </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query_ambil_data = mysqli_query($db, "SELECT * FROM tb_akademik") or die(mysqli_error($db));
                $rv = mysqli_num_rows($query_ambil_data);
                if ($rv > 0) {
                    $no = 1;
                    while ($data = mysqli_fetch_array($query_ambil_data)) {
                        $Kode_akademik = $data['kode_akademik'];
                        $data_Semester = $data['Semester'];
                        $Tahun = $data['Tahun'];
                        $status = $data['is_active'];
                        ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td><?= $Kode_akademik; ?></td>                   
                          <td><?= ($data_Semester == 'GN') ? 'Genap' : 'Ganjil'; ?></td>
                          <td><?= $Tahun; ?> </td>
                          <td><?= ($status == '1') ? 'Aktif' : 'Tidak Aktif'; ?> </td>
                          <td>
                            <button type="button" class="btn btn-success btn-sm" 
                                    data-toggle="modal" 
                                    data-target="#modal-edit" 
                                    data-kode_akademik="<?= $Kode_akademik; ?>"
                                    data-semester="<?= $data_Semester; ?>"
                                    data-tahun="<?= $Tahun; ?>">
                              <i class="fas fa-edit"></i> 
                            </button>
                            <a name="btn_edit" class="btn btn-sm fas fa-edit btn-warning" href="edit_data.php?kode=<?= $Kode_akademik; ?>"><i class=""></i></a>
                            <a class="btn btn-sm btn-danger" href="proses_hapus.php?kode=<?= $Kode_akademik; ?>" onclick="return confirm('Apakah kamu yakin menghapus data ini?')"><i class="fas fa-trash"></i></a>
                          </td>
                        </tr>
                        <?php
                    }
                }
                ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
  </div>

  <aside class="control-sidebar control-sidebar-dark"></aside>
  <footer class="main-footer">
    <strong> &copy; </strong> All rights reserved.
  </footer>
</div>

<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="proses_tambah.php" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="kode">Kode akademik</label>
            <input type="text" name="kode" class="form-control" id="kode" placeholder="Masukan kode" required>
          </div>
          <div class="form-group">
            <label>Semester</label>
            <select class="form-control" name="semester" required>
              <option value="">-- Pilih Semester -- </option>
              <option value="GN">Genap</option>
              <option value="GL">Ganjil</option>
            </select>
          </div>
          <div class="form-group">
            <label for="Tahun">Tahun</label>
            <input type="number" name="tahun" class="form-control" id="Tahun" placeholder="Masukan Tahun " required>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select class="form-control" name="status" required>
              <option value="">-- Status -- </option>
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>
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

<div class="modal fade" id="modal-edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Data Pengguna</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="proses_edit.php" method="post"> 
        <div class="modal-body">
          <input type="text" name="id" class="form-control" readonly>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama" required>
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
          </div>
          <div class="form-group">
            <label>Peran</label>
            <select class="form-control" name="peran" required>
              <option value="">-- Pilih Peran --</option>
              <option value="M">Mahasiswa</option>
              <option value="D">Dosen</option>
              <option value="S">Super Admin</option>
            </select>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="btn_edit">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-import">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Import Data Akademik</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="proses_import.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label>Download template </label>
            <a href="template/template_akademik.xls">Download</a>
            <input type="file" name="file_akademik" class="form-control" id="file_akademik" required>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="btn_import">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include '../script.php'; ?>
<script>
  $('#modal-edit').on('show.bs.modal', function(e){
    var Kode = $(e.relatedTarget).data('kode_akademik');
    var Semester = $(e.relatedTarget).data('semester');
    var Tahun = $(e.relatedTarget).data('tahun');

    $(e.currentTarget).find('input[name="id"]').val(Kode);
  });

  $('#modal-foto').on('show.bs.modal', function(e){
    var nim = $(e.relatedTarget).data('nim');
    $(e.currentTarget).find('input[name="nim"]').val(nim);
  });
</script>

</body>
</html>