<?php
require_once '../database/koneksi.php';
// panggil library
require '../vendor/autoload.php';
// panggil fungsi phpspreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['btn_import'])) {

    // tampung nama file dari input file
    $file     = $_FILES['file_kelas_matkul']['name'];
    $ekstensi = explode('.', $file);

    // pisahkan ekstensi dengan titik nama file
    $nama_file = 'file' . round(microtime(true)) . '.' . end($ekstensi);
    $alamat_sumber = $_FILES['file_kelas_matkul']['tmp_name'];

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
        $kode_jurusan  = mysqli_real_escape_string($db, trim($row[2] ?? ''));
        $kode_matkul   = mysqli_real_escape_string($db, trim($row[3] ?? ''));
        $nik           = mysqli_real_escape_string($db, trim($row[4] ?? ''));
        $nama_kelas    = mysqli_real_escape_string($db, trim($row[5] ?? ''));

        // cek jika data wajib kosong, lewati baris ini
       if ($kode_akademik == '' OR $kode_jurusan == '' OR $kode_matkul == '' OR $nik == '' OR $nama_kelas == '') {
            continue;
        }

        // cek jika data wajib kosong, lewati baris ini (DIRUBAH: disesuaikan dengan variabel kelas matkul)
       $query_cek = mysqli_query($db, "SELECT id FROM tb_kelas_matkul WHERE kode_akademik = '$kode_akademik' AND kode_jurusan = '$kode_jurusan' AND kode_matkul = '$kode_matkul' AND nik = '$nik' AND nama_kelas = '$nama_kelas'") or die(mysqli_error($db));
        $rv = mysqli_num_rows($query_cek);

        // cek data kelas matkul di database berdasarkan kombinasi unik (DIRUBAH: cek agar tidak ada kelas dengan data identik)
       if ($rv == 0) {
            mysqli_query($db, "INSERT INTO tb_kelas_matkul (kode_akademik, kode_jurusan, kode_matkul, nik, nama_kelas) VALUES ('$kode_akademik', '$kode_jurusan', '$kode_matkul', '$nik', '$nama_kelas')") or die(mysqli_error($db));
        }
    }

   // file sementara dihapus setelah semua baris selesai diproses
    unlink($alamat_tujuan);

    echo '<script>alert("Data Kelas Matkul  berhasil diimport");</script>';
    echo '<script>window.location.href = "../data_kelas_matkul_superadmin/";</script>';
}
?>