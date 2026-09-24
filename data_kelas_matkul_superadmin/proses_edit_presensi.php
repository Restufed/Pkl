<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn-edit'])) {
    $id_kelas         = trim(mysqli_real_escape_string($db, $_POST['id_kelas']));
    $id_pertemuan     = trim(mysqli_real_escape_string($db, $_POST['id_pertemuan']));
    $nim              = trim(mysqli_real_escape_string($db, $_POST['nim']));
    $status_kehadiran = ucfirst(strtolower(trim(mysqli_real_escape_string($db, $_POST['status_kehadiran']))));

    if ($id_pertemuan != '' && $nim != '') {
        $cek_data = mysqli_query($db, "SELECT id FROM tb_presensi WHERE id_pertemuan = '$id_pertemuan' AND nim = '$nim'") or die(mysqli_error($db));

        if (mysqli_num_rows($cek_data) > 0) {
            $query_aksi = mysqli_query($db, "UPDATE tb_presensi SET status_kehadiran = '$status_kehadiran' WHERE id_pertemuan = '$id_pertemuan' AND nim = '$nim'") or die(mysqli_error($db));
        } else {
            $query_aksi = mysqli_query($db, "INSERT INTO tb_presensi (nim, status_kehadiran, id_pertemuan) VALUES ('$nim', '$status_kehadiran', '$id_pertemuan')") or die(mysqli_error($db));
        }

        if ($query_aksi) {
            echo '<script>alert("Edit Status Presensi berhasil");</script>';
        } else {
            echo '<script>alert("Edit Status Presensi gagal");</script>';
        }
    } else {
        echo '<script>alert("Gagal: ID Pertemuan atau NIM kosong!");</script>';
    }

    echo '<script>window.location.href="presensi.php?id=' . $id_kelas . '";</script>';
}
?>