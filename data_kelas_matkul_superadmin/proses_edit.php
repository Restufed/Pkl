<?php
// Periksa koneksi
require_once '../database/koneksi.php';
// tampilkan pengguna variabel
if (isset($_POST['btn-edit'])){
    $kode          = trim(mysqli_real_escape_string($db, $_POST['kode']));
    $nama_jurusan  = trim(mysqli_real_escape_string($db, $_POST['nama']));

    $query_edit_matkul = mysqli_query($db, "UPDATE tb_matkul SET nama_matkul = '$nama_jurusan' WHERE kode_matkul = '$kode'") or die(mysqli_error($db));

    if ($query_edit_matkul) {
        echo '<script>alert("Edit mata kuliah berhasil");</script>';
        echo '<script>window.location.href="index.php";</script>';
    } else {
        echo '<script>alert("Edit mata kuliah gagal");</script>';
        echo '<script>window.location.href="index.php";</script>';
    }
}
?>