<?php
require_once '../database/koneksi.php';

if (isset($_GET['id_pertemuan'])) {
    $id_pertemuan = $_GET['id_pertemuan'];
    $nim = $_SESSION['user'];
    
    $query_status = mysqli_query($db, "SELECT status FROM tb_pertemuan WHERE id = '$id_pertemuan'") or die(mysqli_error($db));
    $data_status  = mysqli_fetch_array($query_status);
    $status       = $data_status['status'];
   

    if ($status == 0) {
        echo '<script>alert("Presensi Telah Ditutup");</script>';
        echo '<script>window.location.href="../presensi_mahasiswa";</script>';
    } else {
        $query_cek = mysqli_query($db, "SELECT status_kehadiran FROM tb_presensi WHERE nim='$nim' AND id_pertemuan='$id_pertemuan'") or die(mysqli_error($db));
        
        if (mysqli_num_rows($query_cek) > 0) {
            $data_presensi = mysqli_fetch_array($query_cek);
            $kehadiran = $data_presensi['status_kehadiran'];
            
            if ($kehadiran == 'Hadir') {
                echo '<script>alert("Kamu Telah Melakukan presensi ini");</script>';
                echo '<script>window.location.href="../presensi_mahasiswa";</script>';
            } else {
                mysqli_query($db, "UPDATE tb_presensi SET status_kehadiran = 'Hadir' WHERE nim = '$nim' AND id_pertemuan = '$id_pertemuan'") or die(mysqli_error($db));
                echo '<script>alert("Presensi Berhasil");</script>';
                echo '<script>window.location.href="../presensi_mahasiswa";</script>';
            }
        } else {
            mysqli_query($db, "INSERT INTO tb_presensi (nim, status_kehadiran, id_pertemuan) VALUES ('$nim', 'Hadir', '$id_pertemuan')") or die(mysqli_error($db));
            echo '<script>alert("Presensi Berhasil");</script>';
            echo '<script>window.location.href="../presensi_mahasiswa";</script>';
        }
    }
}
?>