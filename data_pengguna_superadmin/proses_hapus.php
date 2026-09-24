<?php
require_once '../database/koneksi.php';

$id=$_GET['id'];

if(isset($id)){
    $query_hapus = mysqli_query($db,"DELETE FROM tb_pengguna WHERE id = '$id'")or die (mysqli_error($db));
     echo '<script>alert("hapus data Pengguna berhasil")</script>';
    echo '<script>window.location.href="../data_pengguna_superadmin"</script>';
}
?>