<?php 
require_once '../database/koneksi.php';

// Cek apakah tombol submit diklik 
if (isset($_POST['btn-edit']) || isset($_POST['btn_edit'])){
    $nim     = trim(mysqli_real_escape_string($db, $_POST['nim']));
    $nama    = trim(mysqli_real_escape_string($db, $_POST['nama']));
    $kontak  = trim(mysqli_real_escape_string($db, $_POST['kontak']));
    $email   = trim(mysqli_real_escape_string($db, $_POST['email']));
    $kelamin = trim(mysqli_real_escape_string($db, $_POST['kelamin']));
   
    $query_edit_mahasiswa = mysqli_query($db, "UPDATE tb_mahasiswa SET 
        nama    = '$nama',
        kontak  = '$kontak',
        email   = '$email',
        kelamin = '$kelamin' 
        WHERE nim = '$nim'") or die(mysqli_error($db));

    $query_edit_pengguna = mysqli_query($db, "UPDATE tb_pengguna SET 
        nama = '$nama' 
        WHERE username = '$nim'") or die(mysqli_error($db));

    echo '<script>alert("Edit data Mahasiswa berhasil"); window.location.href="../data_pengguna_Mahasiswa";</script>';
    exit();

}
?>