<?php
require_once '../database/koneksi.php';

if (isset($_GET['id'], $_GET['status'], $_GET['id_kelas'])) {

    $id_pertemuan = mysqli_real_escape_string($db, $_GET['id']);
    $status       = mysqli_real_escape_string($db, $_GET['status']);
    $id_kelas     = mysqli_real_escape_string($db, $_GET['id_kelas']);
    echo $status ;
    echo $id_pertemuan;
    $query_status = mysqli_query($db, "UPDATE tb_pertemuan SET status = '$status' WHERE id = '$id_pertemuan'") or die(mysqli_error($db));

    if ($query_status) {
        echo '<script>alert("Status pertemuan berhasil diperbarui");</script>';
        echo '<script>window.location.href = "presensi.php?id=' . $id_kelas . '&id_pertemuan=' . $id_pertemuan . '";</script>';
    } else {
        echo '<script>alert("Gagal memperbarui status pertemuan");</script>';
        echo '<script>window.location.href = "presensi.php?id=' . $id_kelas . '&id_pertemuan=' . $id_pertemuan . '";</script>';
    }
} else {
    echo '<script>alert("Parameter tidak lengkap"); window.history.back();</script>';
}
?>