<?php
require_once '../database/koneksi.php';
// panggil library
require '../vendor/autoload.php';
// panggil fungsi phpspreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['btn_import'])) {

    // tampung nama file dari input file
    $file     = $_FILES['file_akademik']['name'];
    $ekstensi = explode('.', $file);

    // pisahkan ekstensi dengan titik nama file
    $nama_file = 'file' . round(microtime(true)) . '.' . end($ekstensi);
    $alamat_sumber = $_FILES['file_akademik']['tmp_name'];

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

        $kode_akademik = mysqli_real_escape_string($db, trim($row[1] ?? ''));
        $Semester = mysqli_real_escape_string($db, trim($row[2] ?? ''));
        $Tahun = mysqli_real_escape_string($db, trim($row[3] ?? ''));
        $is_active     = mysqli_real_escape_string($db, trim($row[4] ?? '1'));

       

        // cek jika data wajib kosong, lewati baris ini
       if ($kode_akademik == '' OR $Semester == '' OR $Tahun == '' ) {
            continue;
        }

        // cek jika data wajib kosong, lewati baris ini (DIRUBAH: disesuaikan dengan variabel kelas matkul)
       $query_cek = mysqli_query($db, "SELECT  FROM tb_akademik WHERE kode_akademik = '$kode_akademik'' ") or die(mysqli_error($db));
        $rv = mysqli_num_rows($query_cek);

        // cek data kelas matkul di database berdasarkan kombinasi unik (DIRUBAH: cek agar tidak ada kelas dengan data identik)
       if ($rv == 0) {
        mysqli_query($db, "INSERT INTO tb_akademik (kode_akademik, Semester, Tahun, is_active) VALUES ('$kode_akademik', '$Semester', '$Tahun', '1')") or die(mysqli_error($db));        }
    }

   // file sementara dihapus setelah semua baris selesai diproses
    unlink($alamat_tujuan);

    echo '<script>alert("Data Kelas Matkul  berhasil diimport");</script>';
    echo '<script>window.location.href = "../data_akademik_superadmin/";</script>';
}
?>