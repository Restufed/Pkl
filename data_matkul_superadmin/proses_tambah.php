<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])){
    $kode_matkul = trim(mysqli_real_escape_string($db, $_POST['kode']));
    $nama_matkul = trim(mysqli_real_escape_string($db, $_POST['nama']));

    $query_cek = mysqli_query($db, "SELECT * FROM tb_matkul WHERE kode_matkul = '$kode_matkul' OR nama_matkul = '$nama_matkul'") or die(mysqli_error($db));
    $rv = mysqli_num_rows($query_cek);

    if ($rv > 0){
        echo '<script>alert("Data Mata Kuliah sudah ada!"); window.location.href="../data_matkul_superadmin/";</script>';
    } else {
        $query_simpan = mysqli_query($db, "INSERT INTO tb_matkul VALUES ('$kode_matkul','$nama_matkul')") or die(mysqli_error($db));

        echo '<script>alert("Data Mata Kuliah berhasil ditambahkan!"); window.location.href="../data_matkul_superadmin/";</script>';
    }
}
?>