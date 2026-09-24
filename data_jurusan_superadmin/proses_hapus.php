<?php
require_once '../database/koneksi.php';

$kode=$_GET['id'];

if(isset($kode)){
    $query_hapus = mysqli_query($db,"DELETE FROM tb_jurusan WHERE kode_jurusan = '$kode'")or die (mysqli_error($db));
    echo '<script>alert("hapus data jurusan berhasil")</script>';
    echo '<script>window.location.href="../data_jurusan_superadmin"</script>';
}
?>