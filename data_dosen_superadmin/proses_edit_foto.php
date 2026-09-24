<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit_foto'])){
    $kode_brng = trim(mysqli_real_escape_string($db, $_POST['barang']));
    $file = $_FILES['foto']['name'];

    $ekstensi = explode('.', $file);
    $nama_file = 'foto-brg' . round(microtime(true)) . '.' . end($ekstensi);

    $alamat_sumber = $_FILES['foto']['tmp_name'];
    $alamat_tujuan = '../aset_adminlte/img/' . $nama_file;

    move_uploaded_file($alamat_sumber, $alamat_tujuan);

    $query_edit_foto = mysqli_query($db, "UPDATE tbl_barang SET foto_brng='$nama_file' WHERE kode_brng='$kode_brng'") or die(mysqli_error($db));

    echo '<script>alert("Edit Foto Barang Berhasil");</script>';
    echo '<script>window.location.href = "index.php";</script>';
}
?>