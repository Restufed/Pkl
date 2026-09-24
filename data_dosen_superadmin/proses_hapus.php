<?php
require_once '../database/koneksi.php';

$nik=$_GET['nik'];

if(isset($nik)){
    $query_hapus = mysqli_query($db,"DELETE FROM tb_dosen WHERE nik = '$nik'")or die (mysqli_error($db));
    $query_hapus_pengguna = mysqli_query($db,"DELETE FROM tb_pengguna WHERE username = '$nik'")or die (mysqli_error($db));
     echo '<script>alert("hapus data Dosen berhasil </script>';
    echo '<script>window.location.href="../data_dosen_superadmin"</script>';
}
?>