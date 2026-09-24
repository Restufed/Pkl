<?php
require_once '../database/koneksi.php';

if (isset($_GET['id'], $_GET['id_kelas'])) {

    $id_peserta = mysqli_real_escape_string($db, $_GET['id']);
    $id_kelas   = mysqli_real_escape_string($db, $_GET['id_kelas']);

    
    $query_hapus = mysqli_query($db, "DELETE FROM tb_peserta WHERE id = '$id_peserta'") or die(mysqli_error($db));

    if ($query_hapus) {
        echo '<script>alert("Hapus data Data Mahasiswa berhasil dikeluarkan");</script>';
        echo '<script>window.location.href = "../data_kelas_matkul_superadmin/detail_data.php?id='.$id_kelas.'";</script>';
    } else {
       echo '<script>alert("Gagal mengeluarkan mahasiswa dari kelas");</script>';
       echo '<script>window.location.href = "../data_kelas_matkul_superadmin/detail_data.php?id='.$id_kelas.'";</script>';
    }
}
?>