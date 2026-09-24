<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])) {
    $Kode_akademik = trim(mysqli_real_escape_string($db, $_POST['kode']));
    $Semester = trim(mysqli_real_escape_string($db, $_POST['semester']));
    $Tahun = trim(mysqli_real_escape_string($db, $_POST['tahun']));
    $status = trim(mysqli_real_escape_string($db, $_POST['status']));

    $query_cek = mysqli_query($db, "SELECT kode_akademik FROM tb_akademik WHERE kode_akademik = '$Kode_akademik'") or die(mysqli_error($db));
    $rv = mysqli_num_rows($query_cek);

    if ($rv > 0) {
        echo '<script>alert("Data akademik sudah ada!");</script>';
        echo '<script>window.location.href = "../data_akademik_superadmin/";</script>';
    } else {
        $query_simpan = mysqli_query($db, "INSERT INTO tb_akademik  VALUES ('$Kode_akademik', '$Semester','$Tahun','$status')") or die(mysqli_error($db));

        echo '<script>alert("Data akademik berhasil ditambahkan!");</script>';
        echo '<script>window.location.href = "../data_akademik_superadmin/";</script>';
    }
}
?>