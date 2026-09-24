<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])){
    $id_kelas = trim(mysqli_real_escape_string($db, $_POST['id_kelas']));
    $judul_pertemuan = trim(mysqli_real_escape_string($db, $_POST['judul_pertemuan']));

    $query_ambil_pertemuan_terakhir = mysqli_query($db, "SELECT max(pertemuan_ke) AS pertemuan_ke FROM tb_pertemuan WHERE id_kelas='$id_kelas'") or die(mysqli_error($db));

    $pertemuan_ke = 1;
    $data_pertemuan = mysqli_fetch_array($query_ambil_pertemuan_terakhir);
    $pertemuan_terakhir = $data_pertemuan['pertemuan_ke'];
    $tanggal = Date('Y-m-d');
    $status_pertemuan = 1;

    if ($pertemuan_terakhir == NULL OR $pertemuan_terakhir == 0){
        $query_simpan = mysqli_query($db, "INSERT INTO tb_pertemuan VALUES (NULL, '$id_kelas', '$status_pertemuan', '$tanggal', '$judul_pertemuan', '$pertemuan_ke')") or die(mysqli_error($db));
        
        $id_pertemuan = mysqli_insert_id($db);
        $query_peserta = mysqli_query($db, "SELECT nim FROM tb_peserta WHERE id_kelas = '$id_kelas'") or die(mysqli_error($db));

        while ($data_peserta = mysqli_fetch_array($query_peserta)) {
            $nim = $data_peserta['nim'];
            $status_kehadiran = 'alpa';
            $simpan_presensi = mysqli_query($db, "INSERT INTO tb_presensi VALUES (NULL, '$nim', '$status_kehadiran', '$id_pertemuan')") or die(mysqli_error($db));
        }

        echo '<script>alert("presensi telah berhasil");</script>';
        echo '<script>window.location.href = "presensi.php?id_pertemuan='.$id_pertemuan.'";</script>';

    } else {
        $pertemuan_ke = $pertemuan_terakhir + 1;
        $query_simpan = mysqli_query($db, "INSERT INTO tb_pertemuan VALUES (NULL, '$id_kelas', '$status_pertemuan', '$tanggal', '$judul_pertemuan', '$pertemuan_ke')") or die(mysqli_error($db));
        
        $id_pertemuan = mysqli_insert_id($db); 
        $query_peserta = mysqli_query($db, "SELECT nim FROM tb_peserta WHERE id_kelas = '$id_kelas'") or die(mysqli_error($db));

        while ($data_peserta = mysqli_fetch_array($query_peserta)) {
            $nim = $data_peserta['nim'];
            $status_kehadiran = 'alpa';
            $simpan_presensi = mysqli_query($db, "INSERT INTO tb_presensi VALUES (NULL, '$nim', '$status_kehadiran', '$id_pertemuan')") or die(mysqli_error($db));
        }

        echo '<script>alert("tambah pertemuan telah berhasil");</script>';
        echo '<script>window.location.href = "presensi.php?id_pertemuan='.$id_pertemuan.'";</script>';
    } 
}
?>