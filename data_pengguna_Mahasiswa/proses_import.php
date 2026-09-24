<?php
require_once '../database/koneksi.php';
// panggil library
require '../vendor/autoload.php';
// panggil fungsi phpspreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['btn_import'])) {

    // tampung nama file dari input file
    $file     = $_FILES['file_mahasiswa']['name'];
    $ekstensi = explode('.', $file);

    // pisahkan ekstensi dengan titik nama file
    $nama_file = 'file' . round(microtime(true)) . '.' . end($ekstensi);
    $alamat_sumber = $_FILES['file_mahasiswa']['tmp_name'];

    // membuat tujuan atau alamat file
    $alamat_tujuan = 'template/' . $nama_file;
    move_uploaded_file($alamat_sumber, $alamat_tujuan);

    // membaca sheet aktif
    $file_spreadsheet = IOFactory::load($alamat_tujuan);

    // tampung data jadi array
    $sheet = $file_spreadsheet->getActiveSheet();
    $data  = $sheet->toArray();

    foreach ($data as $index => $row) {
        // cek kolom judul, lewati baris pertama
        if ($index == 0) {
            continue;
        }

        $nim     = mysqli_real_escape_string($db, trim($row[1] ?? ''));
        $nama    = mysqli_real_escape_string($db, trim($row[2] ?? ''));
        $kontak  = mysqli_real_escape_string($db, trim($row[3] ?? ''));
        $email   = mysqli_real_escape_string($db, trim($row[4] ?? ''));
        $kelamin = mysqli_real_escape_string($db, trim($row[5] ?? ''));

        // cek jika data wajib kosong, lewati baris ini
        if ($nim == '' OR $nama == '') {
            continue;
        }

        // cek data mahasiswa dari database berdasarkan NIM (unik)
        $query_cek = mysqli_query($db, "SELECT nim FROM tb_mahasiswa WHERE nim = '$nim'") or die(mysqli_error($db));
        $rv = mysqli_num_rows($query_cek);

        // simpan hanya kalau NIM belum ada di database
        if ($rv == 0) {
            mysqli_query($db, "INSERT INTO tb_mahasiswa (nim, nama, kontak, email, kelamin) VALUES ('$nim', '$nama', '$kontak', '$email', '$kelamin')") or die(mysqli_error($db));
        }
    }

    // file sementara dihapus setelah semua baris selesai diproses
    unlink($alamat_tujuan);

    echo '<script>alert("Data Mahasiswa berhasil diimport");</script>';
   echo '<script>window.location.href = "../data_pengguna_Mahasiswa/";</script>';
}
?>