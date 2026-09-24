<?php 
require_once '../database/koneksi.php';

// Cek apakah ada data POST yang dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    
    // Ambil input form
    $nim     = trim(mysqli_real_escape_string($db, $_POST['nim']));
    $nama    = trim(mysqli_real_escape_string($db, $_POST['nama']));
    $kontak  = trim(mysqli_real_escape_string($db, $_POST['kontak']));
    $email   = trim(mysqli_real_escape_string($db, $_POST['email']));
    $kelamin = trim(mysqli_real_escape_string($db, $_POST['kelamin']));

    // Cek duplikasi NIM di tb_mahasiswa
    $query_cek = mysqli_query($db, "SELECT nim FROM tb_mahasiswa WHERE nim='$nim'") or die(mysqli_error($db));
    
    if (mysqli_num_rows($query_cek) > 0) {
        echo '<script>alert("Data mahasiswa dengan NIM tersebut sudah terdaftar!"); window.location.href="tambah.php";</script>';
    } else { 
        $sandi = sha1($nim);
        $peran = 'M';
        $pin   = '12345';

        // 1. Simpan ke tb_mahasiswa
        $query_simpan = mysqli_query($db, "INSERT INTO tb_mahasiswa (`nim`, `nama`, `kontak`, `email`, `kelamin`, `img`) VALUES ('$nim', '$nama', '$kontak', '$email', '$kelamin', NULL)") or die(mysqli_error($db));

        // 2. Cek dan simpan akun ke tb_pengguna
        $query_cek_pengguna = mysqli_query($db, "SELECT username FROM tb_pengguna WHERE username = '$nim'") or die(mysqli_error($db));
        
        if (mysqli_num_rows($query_cek_pengguna) == 0) {
            $query_simpan_pengguna = mysqli_query($db, "INSERT INTO tb_pengguna (`username`, `sandi`, `peran`, `nama`, `pin`) VALUES ('$nim', '$sandi', '$peran', '$nama', '$pin')") or die(mysqli_error($db));
        }

        echo '<script>alert("Tambah data Mahasiswa berhasil!"); window.location.href="index.php";</script>';
    }

} else {
    // Jika file dibuka langsung tanpa form, kembalikan ke index
    header('Location: index.php');
    exit();
}
?>