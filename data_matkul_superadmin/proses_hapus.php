<?php
require_once '../database/koneksi.php';

$kode = $_GET['id'] ?? '';

if (isset($_GET['id'])) {
    $query_hapus = mysqli_query($db, "DELETE FROM tb_matkul WHERE kode_matkul = '$kode'") or die(mysqli_error($db));
    echo '<script>alert("Hapus data Matkul berhasil!"); window.location.href="../data_matkul_superadmin/";</script>';
}
?>