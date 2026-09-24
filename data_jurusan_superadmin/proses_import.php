<?php
require_once '../database/koneksi.php' ;
// panggil libary
require  '../vendor/autoload.php';
// panggil fungsi phpspreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['btn_import'])){
    // tampung nama file dari input file
$file = $_FILES['file_jurusan']['name'];

$ekstensi = explode('.',$file);
// pisahkan Ekstensi dengan titik nama file
$nama_file = 'file'.round(microtime(true)).'.'.end($ekstensi);
$alamat_sumber =$_FILES ['file_jurusan']['tmp_name'];
// membuat Tujuan atau alamat file 
$alamat_tujuan = 'template/'.$nama_file ;
move_uploaded_file($alamat_sumber,$alamat_tujuan);
// membaca Sheet aktif
$file_spreadshet = IOFactory::load($alamat_tujuan);
// tampung data jadi aray
$sheet= $file_spreadshet->getActiveSheet();
$data = $sheet->toArray();
foreach($data as $index => $row){
    // cek kolom judul
    if($index==0){
        continue ;
        // skip perulangan
    }
    // tampung data dari excel ke vaiabel berdasarkan kolom
   $kode_jurusan = $row[1];
   $nama_jurusan = $row[2];
// cek jika data kosong 
    if($kode_jurusan=='' OR $nama_jurusan == ''){
        continue;
    };
    // cek data jurusan dari database
   $query_cek = mysqli_query($db, "SELECT * FROM tb_jurusan WHERE kode_jurusan = '$kode_jurusan' AND nama_jurusan = '$nama_jurusan'") or die(mysqli_error($db));
    $rv = mysqli_num_rows($query_cek);
    // cek jika datanya tidak ada didatabase 
    if ($rv==0){
        $query_simpan = mysqli_query($db, "INSERT INTO tb_jurusan  VALUES ('$kode_jurusan', '$nama_jurusan')") or die(mysqli_error($db));
    }   
}
    unlink($alamat_tujuan);
    echo '<script>alert("Data Jurusan berhasil import");</script>';
    echo '<script>window.location.href = "../data_jurusan_superadmin/";</script>';
}
 ?>