<?php
require_once '../database/koneksi.php';
$halaman = 'presensi_mahasiswa';

if ($_SESSION['peran'] != 'M') {
    echo '<script>window.location.href = "../logout.php";</script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Mahasiswa - Scan QR Code</title>

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
          Hallo, <?php if (isset($_SESSION['nama'])) { echo $_SESSION['nama']; } else { echo 'Mahasiswa'; } ?> <i class="fas fa-user-secret"></i>
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
      <?php include '../sidebar_Mahasiswa.php'; ?>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content pt-3">
      <div class="container-fluid">
        
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card card-primary card-outline">
              <div class="card-header text-center">
                <h3 class="card-title float-none font-weight-bold">
                  <i class="fas fa-qrcode mr-1"></i> Scan QR Code Presensi
                </h3>
              </div>
              <div class="card-body">
                <div class="col-12">
                  <!-- Div pembungkus kamera scanner -->
                  <div id="reader" style="width: 100%;"></div>
                  <!-- Elemen penampung pesan status (yang sebelumnya dicari oleh JS tapi tidak ada) -->
                  <div id="result-message" class="text-center"></div>
                </div>
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

<?php include '../script.php'; ?>

<!-- 1. IMPORT LIBRARY HTML5 QRCODE SCANNER -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
  function onScanSuccess(decodedText, decodedResult) {
    // Hentikan scan sementara agar tidak mengirim berulang-ulang
    html5QrcodeScanner.clear();

    // Tampilkan pesan loading/proses
    var messageBox = document.getElementById('result-message');
    messageBox.className = 'alert alert-info mt-3';
    messageBox.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Memproses presensi...';

    // Kirim ID Pertemuan (hasil scan QR) ke proses_presensi.php
    window.location.href = "proses_presensi.php?id_pertemuan=" +decodedText;
  }

  function onScanFailure(error) {
    // Abaikan error saat memindai frame (biasa terjadi ketika belum menemukan QR Code)
  }

  // Inisialisasi Scanner di div #reader
  let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { 
      fps: 10, 
      qrbox: { width: 250, height: 250 } 
    },
    /* verbose= */ false
  );
  
  html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>

</body>
</html>