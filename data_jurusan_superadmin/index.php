<?php
require_once '../database/koneksi.php';
$halaman = 'data_jurusan_superadmin';
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
                <h3 class="card-title">Data Jurusan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-tambah">
                  <i class="fas fa-plus"></i> Tambah Data 
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
                     <th>kode </th>
                    <th>Nama Jurusan</th>
                    <th>aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                 <?php
                 $query_jurusan = mysqli_query($db, "SELECT * FROM tb_jurusan") or die(mysqli_error($db));
                 $rv = mysqli_num_rows($query_jurusan);
                 if ($rv > 0) {
                    $no = 1;
                    while ($data = mysqli_fetch_array($query_jurusan)) {
                        $kode = $data['kode_jurusan'];
                        $nama = $data['nama_jurusan'];
                        ?>
                        <tr>
                         <td><?= $no++; ?></td>
                         <td><?= $kode; ?></td>
                         <td><?= $nama; ?></td>
                         <td>
                           <a name="btn_edit" class="btn btn-sm fas fa-edit btn-warning" href="edit_data.php?id=<?= $kode ?>"><i></i></a>
                           <a class="btn btn-sm btn-danger" href="proses_hapus.php?id=<?= $kode ?>" onclick="return confirm('Apakah kamu yakin menghapus data ini?')"><i class="fas fa-trash"></i></a>
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
        <h4 class="modal-title">Tambah Data Jurusan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="proses_tambah.php" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="kode">Kode Jurusan</label>
            <input type="text" name="kode" class="form-control" id="kode" placeholder="Masukkan kode jurusan" required>
          </div>
          <div class="form-group">
            <label for="nama">Nama Jurusan</label>
            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan nama jurusan" required>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="btn_tambah">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-import">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Import Data Jurusan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="proses_import.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
           <label>Download </label>
          <a href="template/template_jurusan.xls"class="btn btn-info btn-sm">
    <i class="fas fa-download mr-1"></i> Download Template</a>
           <input type="file" name="file_jurusan" class="form-control" id="file_jurusan" accept=".xlsx" required>
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
    var kode = $(e.relatedTarget).data('kode');
    var nama_jurusan = $(e.relatedTarget).data('nama_jurusan');

    $(e.currentTarget).find('input[name="kode"]').val(kode);
    $(e.currentTarget).find('input[name="nama"]').val(nama_jurusan);

  });
</script>

</body>
</html>