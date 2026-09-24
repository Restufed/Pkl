<?php
require_once '../database/koneksi.php';

$nim=$_GET['nim'];

if(isset($nim)){
    $query_hapus = mysqli_query($db,"DELETE FROM tb_mahasiswa WHERE nim = '$nim'")or die (mysqli_error($db));
    $query_hapus_pengguna = mysqli_query($db,"DELETE FROM tb_pengguna WHERE username = '$nim'")or die (mysqli_error($db));
     echo '<script>alert("hapus data Mahasiswa berhasil")</script>';
    echo '<script>window.location.href="../data_pengguna_Mahasiswa"</script>';
}
?>