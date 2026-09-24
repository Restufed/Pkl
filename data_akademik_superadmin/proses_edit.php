<?php
// periksa koneksi
require_once '../database/koneksi.php';

// tampilan pengguna input variabel
if (isset($_POST['btn-edit'])){
    $Kode_akademik = trim(mysqli_real_escape_string($db, $_POST['kode']));
    $Semester = trim(mysqli_real_escape_string($db, $_POST['semester']));
    $Tahun = trim(mysqli_real_escape_string($db, $_POST['tahun']));
    $status = trim(mysqli_real_escape_string($db, $_POST['status']));
    

    $query_edit_jurusan = mysqli_query($db, "UPDATE tb_akademik SET 
        Semester= '$Semester',
         Tahun='$Tahun',
          is_active= '$status'
        
        WHERE kode_akademik = '$Kode_akademik'") or die(mysqli_error($db));

        echo '<script>alert("Edit Data akademik  berhasil");
         window.location.href="index.php";</script>';
}
?>