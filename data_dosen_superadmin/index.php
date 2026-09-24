<?php
require_once '../database/koneksi.php';
$halaman = 'data_dosen_superadmin';
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
                <h3 class="card-title">Data Dosen</h3>
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
                     <th>Nik</th>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Email</th>
                    <th>Kelamin</th>
                     <th>img</th>
                  </tr>
                  </thead>
                  <tbody>
                 <?php
                 $query_ambil_data = mysqli_query($db, "SELECT * FROM tb_dosen")or die(mysqli_error($db));
                 $rv=mysqli_num_rows($query_ambil_data);
                 if ($rv >0){
                    $no = 1;
                    while($data= mysqli_fetch_array($query_ambil_data)){
                        $nik = $data['nik'];
                         $nama = $data['nama'];
                          $kontak= $data['kontak'];
                          $email= $data['email'];
                           $kelamin= $data['kelamin'];
                          $img= $data['img'];
                          ?>
                          <tr>
                            <td ><?= $no++;?></td>
                            <td><?= $nik;?></td>
                            <td><?= $nama; ?></td>
                            <td><?= $kontak; ?></td>
                            <td><?= $email; ?></td>
                             <td><?= ($kelamin=='L')?'Laki-Laki':'Perempuan'; ?></td>
                          <td>
                            <?php 
                              if ($kelamin=='L'){
                             ?>
                             <button type="button" data-toggle="modal" data-target="#modal-foto" class="btn btn-default" 
                             data-nik = "<?= $nik ;?>">
                              <img src="<?= ($img!=NULL)?$img:'../aset_adminlte/img/dosen-lk.png' ?>" alt="foto mhs laki-laki" style = "width:50px">
                             </button>
                              
                             <?php
                              }else 
                              {
                                ?>
                                <button type="button" data-toggle = "modal" data-target = "#modal-foto" class="btn bt-default"
                                data-nik = "<?= $nik ?>">
                                 <img src="<?= ($img!=NULL)?$img:'../aset_adminlte/img/dosen-p.png' ?>" alt="foto dsn pr" style = "width:50px">
                                </button>
                                
                                <?php
                              }
                              ?>
                          </td>
                        <td>
                          <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-edit"
                          data-nik="<?= $nik; ?>"
                          data-nama="<?= $nama; ?>"
                          data-kontak="<?= $kontak; ?>"
                          data-email="<?=$email; ?>"
                          data-kelamin="<?= $kelamin; ?>">
                             <i class = "fas fa-edit"></i>
                          </button>
                          <a name="btn_edit" class="btn btn-sm fas fa-edit btn-warning" href="edit_data.php?nik=<?= $nik; ?>"><i class=""></i></a>
                          <a class="btn btn-sm btn-danger" href="proses_hapus.php?nik=<?=$nik;?>" onclick="return confirm('Apakah kamu yakin menghapus data ini?')"><i class="fas fa-trash"></i></a>
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
            <form action="proses_tambah.php"method="post">
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">nik</label>
                    <input type="text" name="nik" class="form-control" id="nik" placeholder="Masukan nik" require>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama</label>
                   <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">kontak</label>
                   <input type="number" name="kontak" class="form-control" id="kontak" placeholder="Masukan Nomor " required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">email</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Masukan email " required>
                  </div>
                  
                   <!-- select -->
                      <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select class="form-control"  name="kelamin" required>
                            <option value="">-- Pilih jenis kelamin -- </option>
                          
                          <option value="L" >Laki-Laki</option>
                          <option value="P" >Perempuan</option>
                        </select>
                      </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="btn-tambah">Simpan</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
<div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_edit.php"method="post">
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nik</label>
                    <input type="text" name="nik" class="form-control" value="<?= $nik; ?>" id="nik" placeholder="Masukkan NIk" readonly>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama</label>
                   <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">kontak</label>
                   <input type="number" name="kontak" class="form-control" id="kontak" placeholder="Masukan Nomor " required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">email</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Masukan email " required>
                  </div>
                  
                   <!-- select -->
                      <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select class="form-control"  name="kelamin" required>
                            <option value="">-- Pilih jenis kelamin -- </option>
                          
                          <option value="L" >Laki-Laki</option>
                          <option value="P" >Perempuan</option>
                        </select>
                      </div>
                     <div class="form-group">
                     <label>Img</label>
                     <input type="text" name="img" value="img" class="form-control">
                     </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="btn_edit">Simpan</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <div class="modal fade" id="modal-foto">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Foto Dosen</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_edit_foto.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">
             <div class = "form-group">
             <label>uplod foto </label>
             <input type="hidden" name="nik" hidden >
             <input type="file" class ="form-control" accept = "image/*" name = "foto" required>
             </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="btn_edit_foto">Simpan</button>
            </div>
            </form>
          </div>
        </div>
      </div>
     <div class="modal fade" id="modal-import">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Import Data Dosen</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="proses_import.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
             <label>Download </label>
              <a href="template/template_dosen.xls" class="btn btn-info btn-sm">
               <i class="fas fa-download mr-1"></i> Download Template</a>
           <input type="file" name="file_dosen" class="form-control" id="file_dosen" required>
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
    var nik = $(e.relatedTarget).data('nik');
    var nama = $(e.relatedTarget).data('nama');
    var kontak = $(e.relatedTarget).data('kontak');
    var email = $(e.relatedTarget).data('email');
    var kelamin = $(e.relatedTarget).data('kelamin');

    $(e.currentTarget).find('input[name="nik"]').val(nik);
    $(e.currentTarget).find('input[name="nama"]').val(nama);
    $(e.currentTarget).find('input[name="kontak"]').val(kontak);
    $(e.currentTarget).find('input[name="email"]').val(email);
    $(e.currentTarget).find('select[name="kelamin"]').val(kelamin);
  });

  $('#modal-foto').on('show.bs.modal', function(e){
    var nik = $(e.relatedTarget).data('nik');

    $(e.currentTarget).find('input[name="nik"]').val(nik);
  })
</script>

</body>
</html>