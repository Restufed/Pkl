<?php 
// Panggil koneksi tabel
require_once '../database/koneksi.php';

// Cek tombol ketika ditekan
if (isset($_POST['btn-tambah'])){ 
    // Ambil data ke variabel
    $nik    = trim(mysqli_real_escape_string($db, $_POST['nik']));
    $nama    = trim(mysqli_real_escape_string($db, $_POST['nama']));
    $kontak  = trim(mysqli_real_escape_string($db, $_POST['kontak']));
    $email   = trim(mysqli_real_escape_string($db, $_POST['email']));
    $kelamin = trim(mysqli_real_escape_string($db, $_POST['kelamin']));

    // Cek apakah NIM sudah terdaftar di tb_mahasiswa
    $query_cek = mysqli_query($db, "SELECT nik FROM tb_dosen WHERE nik='$nik'") or die(mysqli_error($db));
    $rv = mysqli_num_rows($query_cek);

    if ($rv > 0){
        // Tampilkan alert jika data sudah ada
        echo '<script>alert("Data dosen sudah terdaftar!"); window.location.href="tambah.php";</script>';
    } else { 
        $sandi = sha1($nik);
        $peran = 'D';
        $pin   = '12345';

        // Simpan data ke tb_mahasiswa
        $query_simpan = mysqli_query($db, "INSERT INTO tb_dosen VALUES ('$nik', '$nama', '$kontak', '$email', '$kelamin',NULL)") or die(mysqli_error($db));

        // Cek apakah username sudah ada di tb_pengguna
        $query_cek_pengguna = mysqli_query($db, "SELECT username FROM tb_pengguna WHERE username = '$nik'") or die(mysqli_error($db));
        $rv_pengguna = mysqli_num_rows($query_cek_pengguna);

        // Jika username belum ada, simpan ke tb_pengguna
        if ($rv_pengguna == 0) {
            $query_simpan_pengguna = mysqli_query($db, "INSERT INTO tb_pengguna VALUES (NULL, '$nik', '$sandi', '$peran', '$nama', '$pin')") or die(mysqli_error($db));
        }

        // Tampilkan alert sukses dan redirect
        echo '<script>alert("Tambah data dosen berhasil!"); window.location.href="index.php";</script>';
    }
} 
?>