<?php
// periksa koneksi
require_once '../database/koneksi.php';

// tampilan pengguna input variabel
if (isset($_POST['btn-edit'])){
    $kode   = trim(mysqli_real_escape_string($db, $_POST['kode']));
    $nama_jurusan= trim(mysqli_real_escape_string($db, $_POST['nama']));
    

    $query_edit_jurusan = mysqli_query($db, "UPDATE tb_jurusan SET 
        nama_jurusan= '$nama_jurusan'
        
        WHERE kode_jurusan = '$kode'") or die(mysqli_error($db));

        echo '<script>alert("Edit mata kuliah berhasil");
         window.location.href="index.php";</script>';
}
?>