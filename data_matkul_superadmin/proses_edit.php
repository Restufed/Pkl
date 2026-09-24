<?php
// periksa koneksi
require_once '../database/koneksi.php';

// tampilan pengguna input variabel
if (isset($_POST['btn-edit'])){
    $kode_matkul   = trim(mysqli_real_escape_string($db, $_POST['kode']));
    $nama_matkul= trim(mysqli_real_escape_string($db, $_POST['nama']));
    

    $query_edit_matkul = mysqli_query($db, "UPDATE tb_matkul SET 
        nama_matkul= '$nama_matkul'
        
        WHERE kode_matkul = '$kode_matkul'") or die(mysqli_error($db));

        echo '<script>alert("Edit mata kuliah berhasil");
         window.location.href="index.php";</script>';
}
?>