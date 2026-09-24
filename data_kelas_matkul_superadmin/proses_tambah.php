<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])) {

    $kode_akademik = trim(mysqli_real_escape_string($db, $_POST['kode_akademik']));
    $kode_jurusan  = trim(mysqli_real_escape_string($db, $_POST['kode_jurusan']));
    $kode_matkul   = trim(mysqli_real_escape_string($db, $_POST['kode_matkul']));
    $nik           = trim(mysqli_real_escape_string($db, $_POST['nik']));
    $nama_kelas    = trim(mysqli_real_escape_string($db, $_POST['nama_kelas']));

    $query_cek = mysqli_query($db, "SELECT * FROM tb_kelas_matkul 
                        WHERE kode_akademik = '$kode_akademik' 
                        AND kode_jurusan = '$kode_jurusan' 
                        AND kode_matkul = '$kode_matkul' 
                        AND nama_kelas = '$nama_kelas'") or die(mysqli_error($db));
    $rv = mysqli_num_rows($query_cek);

    if ($rv > 0) {
        echo '<script>alert("Data Kelas Matkul sudah ada!");</script>';
        echo '<script>window.location.href = "../data_kelas_matkul_superadmin/";</script>';
    } else {
        $query_simpan = mysqli_query($db, "INSERT INTO tb_kelas_matkul (kode_akademik, kode_jurusan, kode_matkul, nik, nama_kelas) VALUES ('$kode_akademik', '$kode_jurusan', '$kode_matkul', '$nik', '$nama_kelas')") or die(mysqli_error($db));

        echo '<script>alert("Data Kelas Matkul berhasil ditambahkan!");</script>';
        echo '<script>window.location.href = "../data_kelas_matkul_superadmin/";</script>';
    }
}
?>