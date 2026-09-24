<?php
require_once '../database/koneksi.php';

// Pastikan name tombol di HTML disesuaikan (misal: name="btn_tambah_siswa")
if (isset($_POST['btn_tambah_siswa'])) {

    $id_kelas = trim(mysqli_real_escape_string($db, $_POST['id_kelas']));
    $nim      = trim(mysqli_real_escape_string($db, $_POST['nim']));

    // Cek apakah mahasiswa sudah terdaftar di kelas
    $query_cek = mysqli_query($db, "SELECT * FROM tb_peserta WHERE nim = '$nim' AND id_kelas = '$id_kelas'") or die(mysqli_error($db));
    $rv        = mysqli_num_rows($query_cek);

    if ($rv > 0) {
        echo '<script>alert("Data mahasiswa sudah terdaftar di kelas ini");</script>';
        echo '<script>window.location.href = "../data_kelas_matkul_superadmin/detail_data.php?id='.$id_kelas.'";</script>';
    } else {
        // Query INSERT menyebutkan nama kolom secara eksplisit agar lebih aman
        $query_simpan = mysqli_query($db, "INSERT INTO tb_peserta (id_kelas, nim) VALUES ('$id_kelas', '$nim')") or die(mysqli_error($db));

        if ($query_simpan) {
            echo '<script>alert("Tambah peserta kelas telah berhasil");</script>';
            echo '<script>window.location.href = "../data_kelas_matkul_superadmin/detail_data.php?id='.$id_kelas.'";</script>';
        } else {
            echo '<script>alert("Gagal menambahkan peserta kelas");</script>';
            echo '<script>window.location.href = "../data_kelas_matkul_superadmin/detail_data.php?id='.$id_kelas.'";</script>';
        }
    }

}
?>