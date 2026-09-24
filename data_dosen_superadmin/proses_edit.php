<?php 
require_once '../database/koneksi.php';

// Cek apakah tombol submit diklik 
if (isset($_POST['btn-edit']) || isset($_POST['btn_edit'])){
    $nik   = trim(mysqli_real_escape_string($db, $_POST['nik']));
    $nama    = trim(mysqli_real_escape_string($db, $_POST['nama']));
    $kontak  = trim(mysqli_real_escape_string($db, $_POST['kontak']));
    $email   = trim(mysqli_real_escape_string($db, $_POST['email']));
    $kelamin = trim(mysqli_real_escape_string($db, $_POST['kelamin']));
   
    $query_edit_dosen = mysqli_query($db, "UPDATE tb_dosen SET 
        nama    = '$nama',
        kontak  = '$kontak',
        email   = '$email',
        kelamin = '$kelamin' 
        WHERE nik = '$nik'") or die(mysqli_error($db));

    $query_edit_pengguna = mysqli_query($db, "UPDATE tb_dosen SET 
        nama = '$nama' 
        WHERE nik = '$nik'") or die(mysqli_error($db));

    echo '<script>alert("Edit data dosen berhasil"); window.location.href="../data_dosen_superadmin";</script>';
    exit();
}
?>