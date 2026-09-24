<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])) {
    $kode_jurusan = trim(mysqli_real_escape_string($db, $_POST['kode']));
    $nama_jurusan = trim(mysqli_real_escape_string($db, $_POST['nama']));

    $query_cek = mysqli_query($db, "SELECT * FROM tb_jurusan WHERE kode_jurusan = '$kode_jurusan' OR nama_jurusan = '$nama_jurusan'") or die(mysqli_error($db));
    $rv = mysqli_num_rows($query_cek);

    if ($rv > 0) {
        echo '<script>alert("Data Jurusan sudah ada!");</script>';
        echo '<script>window.location.href = "../data_jurusan_superadmin/";</script>';
    } else {
        $query_simpan = mysqli_query($db, "INSERT INTO tb_jurusan  VALUES ('$kode_jurusan', '$nama_jurusan')") or die(mysqli_error($db));

        echo '<script>alert("Data Jurusan berhasil ditambahkan!");</script>';
        echo '<script>window.location.href = "../data_jurusan_superadmin/";</script>';
    }
}
?>