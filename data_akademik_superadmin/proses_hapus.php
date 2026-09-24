<?php
require_once '../database/koneksi.php';

$kode=$_GET['kode'];

if(isset($kode)){
    $query_hapus = mysqli_query($db,"DELETE FROM tb_akademik WHERE kode_akademik = '$kode'")or die (mysqli_error($db));
    echo '<script>alert("hapus data akademik berhasil")</script>';
    echo '<script>window.location.href="../data_akademik_superadmin"</script>';
}
?>