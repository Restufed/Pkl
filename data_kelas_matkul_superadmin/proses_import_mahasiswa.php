<?php
require_once '../database/koneksi.php' ;
// panggil libary
require  '../vendor/autoload.php';
// panggil fungsi phpspreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['btn_import'])){
    // tampung nama file dari input file
$file = $_FILES['file_kelas_matkul']['name'];
$id_kelas =trim(mysqli_real_escape_string($db, $_POST['id_kelas']));

$ekstensi = explode('.',$file);
// pisahkan Ekstensi dengan titik nama file
$nama_file = 'file'.round(microtime(true)).'.'.end($ekstensi);
$alamat_sumber =$_FILES ['file_kelas_matkul']['tmp_name'];
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
   $nim = $row[1];
// cek jika data kosong 
    if($nim==''){
        continue;
    };
    // cek data jurusan dari database
   $query_cek = mysqli_query($db, "SELECT * FROM tb_peserta WHERE nim = '$nim' AND id_kelas = '$id_kelas'") or die(mysqli_error($db));
    $rv = mysqli_num_rows($query_cek);
    // cek jika datanya tidak ada didatabase 
    if ($rv==0){
        $query_simpan = mysqli_query($db, "INSERT INTO tb_peserta  VALUES  (NULL, '$id_kelas','$nim')") or die(mysqli_error($db));
    }   
}
    unlink($alamat_tujuan);
    echo '<script>alert("Data Pesrta berhasil import");</script>';
   echo '<script>window.location.href = "../data_kelas_matkul_superadmin/detail_data.php?id='.$id_kelas.'";</script>';
}

  
 ?>