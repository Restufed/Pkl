<?php
require_once '../database/koneksi.php' ;
// panggil libary
require  '../vendor/autoload.php';
// panggil fungsi phpspreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['btn_import'])){
    // tampung nama file dari input file
$file = $_FILES['file_data_matkul']['name'];

$ekstensi = explode('.',$file);
// pisahkan Ekstensi dengan titik nama file
$nama_file = 'file'.round(microtime(true)).'.'.end($ekstensi);
$alamat_sumber =$_FILES ['file_data_matkul']['tmp_name'];
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
   $kode_matkul = $row[1];
   $nama_matkul = $row[2];
// cek jika data kosong 
    if($kode_matkul=='' OR $nama_matkul == ''){
        continue;
    };
    // cek data jurusan dari database
   $query_cek = mysqli_query($db, "SELECT * FROM tb_matkul WHERE kode_matkul = '$kode_matkul' AND nama_matkul = '$nama_matkul'") or die(mysqli_error($db));
    $rv = mysqli_num_rows($query_cek);
    // cek jika datanya tidak ada didatabase 
    if ($rv==0){
        $query_simpan = mysqli_query($db, "INSERT INTO tb_matkul  VALUES ('$kode_matkul', '$nama_matkul')") or die(mysqli_error($db));
    }   
}
    unlink($alamat_tujuan);
    echo '<script>alert("Data Mata kuliah berhasil import");</script>';
    echo '<script>window.location.href = "../data_matkul_superadmin/";</script>';
}
 ?>