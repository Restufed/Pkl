<?php
require_once '../database/koneksi.php';

if (isset($_GET['id'], )) {

    $id = mysqli_real_escape_string($db, $_GET['id']);

    $query_hapus = mysqli_query($db, "DELETE FROM tb_kelas_matkul WHERE id = '$id'") or die(mysqli_error($db));

    if ($query_hapus) {
        echo '<script>alert("Hapus data kelas matkul berhasil");</script>';
        echo '<script>window.location.href="../data_kelas_matkul_superadmin";</script>';
    } else {
        echo '<script>alert("Hapus data kelas matkul gagal");</script>';
        echo '<script>window.location.href="../data_kelas_matkul_superadmin";</script>';
    }
}
?>