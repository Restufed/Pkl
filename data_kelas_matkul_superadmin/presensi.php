<?php
require_once '../database/koneksi.php';
$halaman = 'data_kelas_matkul_superadmin';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail Data Kelas & Presensi</title>

  <?php include '../library.php'; ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
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
          Hallo, <?php if (isset($_SESSION['nama'])) { echo $_SESSION['nama']; } else { echo 'Admin'; } ?> <i class="fas fa-user-secret"></i>
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
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="content">
      <div class="container-fluid">

        <!-- CARD DETAIL KELAS & QR CODE -->
        <div class="card card-outline card-primary mb-4">
          <div class="card-header">
            <h3 class="card-title">Data Kelas Mata Kuliah</h3>
          </div>
          <div class="card-body">
            <?php
            // --- Ambil parameter dari URL ---
            $id_kelas         = isset($_GET['id']) ? $_GET['id'] : '';
            $id_pertemuan_get = isset($_GET['id_pertemuan']) ? $_GET['id_pertemuan'] : '';

            $id_pertemuan          = '';
            $judul_pertemuan       = '-';
            $tanggal               = date('Y-m-d');
            $status_pertemuan_raw  = null;

            // --- Query pertemuan: pakai id_pertemuan kalau dikirim, kalau tidak baru fallback ke yang terbaru ---
          
                $query_pertemuan = mysqli_query(
                    $db,
                    "SELECT *
                     FROM tb_pertemuan
                     WHERE id = '$id_pertemuan_get'
                     "
                ) or die(mysqli_error($db));
            
            $data_pertemuan = mysqli_fetch_assoc($query_pertemuan);

            if ($data_pertemuan) {
                $id_pertemuan          = $data_pertemuan['id'];
                $judul_pertemuan       = $data_pertemuan['judul_pertemuan'];
                $tanggal               = $data_pertemuan['tanggal'];
                $status_pertemuan_raw  = $data_pertemuan['status'];
            }

            // Normalisasi status: hanya '1'/1 yang dianggap "terbuka".
            $absen_terbuka = ($status_pertemuan_raw === '1' || $status_pertemuan_raw === 1);

            $tanggal_baru = date_create($tanggal);

            // --- Data kelas ---
            $query_kelas = mysqli_query(
                $db,
                "SELECT kode_akademik, kode_jurusan, kode_matkul, nik, nama_kelas
                 FROM tb_kelas_matkul WHERE id = '$id_kelas'"
            ) or die(mysqli_error($db));
            $data = mysqli_fetch_assoc($query_kelas);

            $kode_akademik = $data['kode_akademik'];
            $kode_jurusan  = $data['kode_jurusan'];
            $kode_matkul   = $data['kode_matkul'];
            $nik           = $data['nik'];
            $nama_kelas    = $data['nama_kelas'];

            // --- Data dosen ---
            $query_dosen = mysqli_query(
                $db,
                "SELECT nik, nama, kelamin FROM tb_dosen WHERE nik = '$nik'"
            ) or die(mysqli_error($db));
            $data_dosen = mysqli_fetch_assoc($query_dosen);

            $kelamin    = $data_dosen['kelamin'];
            $nama_dosen = $data_dosen['nama'];
            $nik_dosen  = $data_dosen['nik'];

            $foto_dosen = '../aset_adminlte/img/dosen-p.png';
            if ($kelamin == 'L') {
                $foto_dosen = '../aset_adminlte/img/dosen-lk.png';
            }

            // --- Akademik ---
            $query_akademik = mysqli_query(
                $db,
                "SELECT Tahun, Semester FROM tb_akademik WHERE kode_akademik = '$kode_akademik'"
            ) or die(mysqli_error($db));
            $data_akademik = mysqli_fetch_assoc($query_akademik);

            $tahun = $data_akademik['Tahun'];
            $sem   = $data_akademik['Semester'];
            $semester = ($sem == 'GN') ? 'Genap' : 'Ganjil';

            // --- Jurusan ---
            $query_jurusan = mysqli_query(
                $db,
                "SELECT nama_jurusan FROM tb_jurusan WHERE kode_jurusan = '$kode_jurusan'"
            ) or die(mysqli_error($db));
            $data_jurusan = mysqli_fetch_assoc($query_jurusan);
            $nama_jurusan = $data_jurusan['nama_jurusan'];

            // --- Mata kuliah ---
            $query_matkul = mysqli_query(
                $db,
                "SELECT nama_matkul FROM tb_matkul WHERE kode_matkul = '$kode_matkul'"
            ) or die(mysqli_error($db));
            $data_matkul = mysqli_fetch_assoc($query_matkul);
            $nama_matkul = $data_matkul['nama_matkul'];
            ?>

            <div class="row">
              <div class="col-md-4 text-center">
                 <button type="button" data-toggle="modal" data-target="#modal-foto" class="btn btn-default mb-2" data-nik="<?= $nik; ?>">
                    <img src="<?= $foto_dosen; ?>" alt="foto dosen" style="width:180px; height:auto;" class="img-fluid rounded">
                 </button>

                <div class="mt-3" style="width: 200px; margin: 0 auto;">
                  <?php if ($status_pertemuan_raw == 0) { ?>
                    <a href="proses_status_pertemuan.php?id=<?= $id_pertemuan_get; ?>&status=1&id_kelas=<?= $id_kelas; ?>" class="btn btn-sm btn-success btn-block" onclick="return confirm('Yakin ingin membuka absen?')">
                        <i class="fas fa-door-open"></i> Buka Absen
                    </a>
                  <?php } else { ?>
                    <a href="proses_status_pertemuan.php?id=<?= $id_pertemuan_get; ?>&status=0&id_kelas=<?= $id_kelas; ?>" class="btn btn-sm btn-warning btn-block" onclick="return confirm('Yakin ingin menutup absen?')">
                        <i class="fas fa-door-closed"></i> Tutup Absen
                    </a>
                  <?php } ?>
                </div>
              </div>

              <div class="col-md-4">
                <table class="table table-borderless table-sm">
                  <tr>
                    <td width="40%"><strong>Periode Akademik</strong></td>
                    <td width="5%">:</td>
                    <td><?= $tahun; ?> - <?= $semester; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Jurusan</strong></td>
                    <td>:</td>
                    <td><?= $nama_jurusan; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Mata Kuliah</strong></td>
                    <td>:</td>
                    <td><?= $nama_matkul; ?> - <?= $kode_matkul; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Dosen</strong></td>
                    <td>:</td>
                    <td><?= $nama_dosen; ?> - <?= $nik_dosen; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Nama Kelas</strong></td>
                    <td>:</td>
                    <td><?= $nama_kelas; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Judul Pertemuan</strong></td>
                    <td>:</td>
                    <td><?= $judul_pertemuan; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Tanggal</strong></td>
                    <td>:</td>
                    <td class="font-weight-bold"><?= date_format($tanggal_baru, "l, d F Y") ?></td>
                  </tr>
                </table>
              </div>

              <!-- AREA QR CODE -->
              <div class="col-md-4 text-center">
                <?php
                  if (!$absen_terbuka) {
                      echo '<p class="text-muted mt-4">Absen belum dibuka.<br>Klik "Buka Absen" untuk menampilkan QR Code.</p>';
                  } elseif ($id_pertemuan == '') {
                      echo '<p class="text-muted mt-4">QR Code tidak tersedia (Belum ada data pertemuan).</p>';
                  } else {
                      // --- Cek 1: ekstensi GD wajib ada, phpqrcode butuh ini buat render PNG ---
                      if (!extension_loaded('gd')) {
                          echo '<p class="text-danger mt-4"><strong>QR gagal dibuat:</strong> ekstensi GD PHP belum aktif. Buka php.ini, aktifkan <code>extension=gd</code>, lalu restart Apache/XAMPP.</p>';
                      } else {
                          // --- Cek 2: file library qrlib.php harus ada di path ini ---
                          $lib_path = '../aset_adminlte/phpqrcode/qrlib.php';
                          if (!file_exists($lib_path)) {
                              echo '<p class="text-danger mt-4"><strong>QR gagal dibuat:</strong> library tidak ditemukan di <code>' . htmlspecialchars(realpath('.') . '/' . $lib_path) . '</code>. Cek ulang lokasi folder phpqrcode.</p>';
                          } else {
                              require_once($lib_path);

                              // URL relative, ikut host manapun yang dipakai akses server
                              $isi_qr   = $id_pertemuan_get;
                              $fileName = 'file_qr_' . md5($id_pertemuan) . '.png';
                              $alamat_tujuan = 'qr/' . $fileName;

                              // --- Cek 3: folder qr/ harus bisa dibuat & ditulis ---
                              if (!file_exists('qr')) {
                                  @mkdir('qr', 0777, true);
                              }

                              if (!is_dir('qr') || !is_writable('qr')) {
                                  echo '<p class="text-danger mt-4"><strong>QR gagal dibuat:</strong> folder <code>qr/</code> tidak bisa ditulis. Set permission (misal <code>chmod -R 777 qr</code>) atau cek ownership foldernya.</p>';
                              } else {
                                  // Regenerate tiap kali dibuka biar QR selalu sesuai file/isi terbaru
                                  if (file_exists($alamat_tujuan)) {
                                      @unlink($alamat_tujuan);
                                  }

                                  try {
                                      QRcode::png($isi_qr, $alamat_tujuan, QR_ECLEVEL_H, 6);
                                  } catch (Throwable $e) {
                                      echo '<p class="text-danger mt-4"><strong>QR gagal dibuat:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
                                  }

                                  // --- Cek 4: file PNG-nya benar-benar kebuat ---
                                  if (file_exists($alamat_tujuan)) {
                                      ?>
                                      <img src="<?= $alamat_tujuan . '?t=' . time(); ?>" alt="foto_qr" style="width:220px" class="img-thumbnail shadow-sm">
                                      <?php
                                  } else {
                                      echo '<p class="text-danger mt-4"><strong>QR gagal dibuat:</strong> QRcode::png() dipanggil tapi file PNG tidak muncul di <code>' . htmlspecialchars($alamat_tujuan) . '</code>.</p>';
                                  }
                              }
                          }
                      }
                  }
                ?>

                <?php if ($absen_terbuka) { ?>
                  <div class="mt-2 text-center">
                    Sisa Waktu Absen:
                    <div id="timer" class="font-weight-bold text-danger" style="font-size: 1.5rem;">05:00</div>
                  </div>
                <?php } ?>
              </div>
            </div>

            <div class="mt-3">
              <a href="pertemuan.php?id=<?= $id_kelas; ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
             
            </div>
          </div>
        </div>

        
        <div class="card card-outline card-secondary">
          <div class="card-header">
            <h3 class="card-title">Daftar Presensi Mahasiswa</h3>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="5%" class="text-center">No</th>
                  <th>Nama Mahasiswa</th>
                  <th width="20%" class="text-center">Status</th>
                  <th width="10%" class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $q_mhs = mysqli_query($db, "SELECT
                                            tb_peserta.nim,
                                            tb_mahasiswa.nama,
                                            IFNULL(tb_presensi.status_kehadiran, 'Alpa') as status_kehadiran
                                          FROM tb_peserta
                                          JOIN tb_mahasiswa ON tb_peserta.nim = tb_mahasiswa.nim
                                          LEFT JOIN tb_presensi ON tb_peserta.nim = tb_presensi.nim AND tb_presensi.id_pertemuan = '$id_pertemuan'
                                          WHERE tb_peserta.id_kelas = '$id_kelas'")
                                      or die(mysqli_error($db));

              $no = 1;
              while ($mhs = mysqli_fetch_assoc($q_mhs)) {
                  $st_asli = $mhs['status_kehadiran'];
                  $st_cek  = strtolower($st_asli);
              ?>
              <tr>
                  <td class="text-center"><?= $no++; ?></td>
                  <td><?= $mhs['nama']; ?> - <?= $mhs['nim']; ?></td>
                  <td class="text-center">
                    <?php
                      if ($st_cek == 'hadir') {
                        echo '<span class="badge badge-success">Hadir</span>';
                      } else if ($st_cek == 'izin') {
                        echo '<span class="badge badge-warning">Izin</span>';
                      } else if ($st_cek == 'sakit') {
                        echo '<span class="badge badge-info">Sakit</span>';
                      } else {
                        echo '<span class="badge badge-danger">Alpa</span>';
                      }
                    ?>
                  </td>
                  <td class="text-center">
                    <button type="button"
                      class="btn btn-primary btn-sm"
                      data-toggle="modal"
                      data-target="#modal-edit-presensi"
                      data-nim="<?= $mhs['nim']; ?>"
                      data-status="<?= $st_asli; ?>">
                      <i class="fas fa-edit"></i> edit
                    </button>
                  </td>
              </tr>
              <?php
              }
              ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- MODAL EDIT PRESENSI -->
  <div class="modal fade" id="modal-edit-presensi">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Status Presensi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="proses_edit_presensi.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="id_kelas" value="<?= $id_kelas; ?>">
            <input type="hidden" name="id_pertemuan" value="<?= $id_pertemuan; ?>">
            <input type="hidden" name="nim" id="modal_nim">

            <div class="form-group">
              <label for="status_kehadiran">Status Kehadiran</label>
              <select name="status_kehadiran" id="modal_status" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="Hadir">Hadir</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
                <option value="Alpa">Alpa</option>
              </select>
            </div>
          </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" name="btn-edit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <footer class="main-footer">
    <strong> &copy; </strong> All rights reserved.
  </footer>

</div>

<?php include '../script.php'; ?>

<script>
  $('#modal-edit-presensi').on('show.bs.modal', function(e){
    var nim    = $(e.relatedTarget).data('nim');
    var status = $(e.relatedTarget).data('status');

    $(e.currentTarget).find('#modal_nim').val(nim);
    $(e.currentTarget).find('#modal_status').val(status);
  });

  var absenTerbuka = <?= $absen_terbuka ? 'true' : 'false'; ?>;

  if (absenTerbuka) {
    var durasiMenit = 5;
    var totalDetik = durasiMenit * 60;

    var countdown = setInterval(function() {
      var menit = Math.floor(totalDetik / 60);
      var detik = totalDetik % 60;

      menit = menit < 10 ? "0" + menit : menit;
      detik = detik < 10 ? "0" + detik : detik;

      var elTimer = document.getElementById("timer");
      if (elTimer) {
        elTimer.innerHTML = menit + ":" + detik;
      }

      if (totalDetik <= 0) {
        clearInterval(countdown);
        alert("Waktu presensi 5 menit telah habis! Absen ditutup.");
        window.location.href = "proses_status_pertemuan.php?id=<?= $id_pertemuan; ?>&status=0&id_kelas=<?= $id_kelas; ?>";
      }

      totalDetik--;
    }, 1000);
  }
</script>
</body>
</html>