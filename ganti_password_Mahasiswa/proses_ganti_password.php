<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn-ganti'])) {
    $username   = trim(mysqli_real_escape_string($db, $_POST['user'] ?? ''));
    $pw_baru    = trim(mysqli_real_escape_string($db, $_POST['pwbaru'] ?? ''));
    $c_password = trim(mysqli_real_escape_string($db, $_POST['password'] ?? ''));

    if($pw_baru = $c_password){
        $pw_enkripsi = sha1($pw_baru);
        $query_ganti_password =mysqli_query($db, "UPDATE tb_mahasiswa SET sandi = '$pw_enkripsi' WHERE
         username = '$username'") or die(mysqli_error($db));

        echo '<script>alert("Ganti password telah berhasil!");</script>';
        echo '<script>window.location.href = "../logout.php";</script>';
    } else { 
        echo '<script>alert("Password baru dan konfirmasi password tidak cocok!");</script>';
        echo '<script>window.location.href = "index.php";</script>';
    }

}
?>