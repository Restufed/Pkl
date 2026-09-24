<?php
require_once "../database/koneksi.php";
require '../vendor/autoload.php'; 
// panggil fungsi phpsspretsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// buka bufering
ob_start();
// buat nama file
$nama_file = "Data-Detail- Kelas Mata-Kuliah" . date('Y-m-d');
$query_panggil_peserta=mysqli_query($db,"SELECT * FROM tb_peserta ") or die (mysqli_error($db,));


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data-Detail-Kelas Mata Kuliah');

// Set header cells
$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'kelas');
$sheet->setCellValue('C1', 'nama Mahasiswa');

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];
// aplikasi dari konfigurasi styling style
$sheet->getStyle('A1:C1')->applyFromArray($styleArray);
// styling font mnjadi bold ke cell yang di tuju
$sheet->getStyle('A1:C1')->getFont()->setBold(true);
// styling lebar sel menjadi auto (sesuai panjng data )
foreach (array('A','B', 'C',) as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}
// buat no dri 1
$no = 1;
// bkin baris 2
$baris = 2;
// buat pengulngn data
while ($data = mysqli_fetch_assoc($query_panggil_mahsiswa)) {
    // tampung dri database tiap kolom 
    $id_kelas = $data['id_kelas'];
    $kode_jurusan = $data['kode_jurusan'];
    $kode_matkul = $data['kode_matkul'];
    $nik = $data['nik'];
    $nama_kelas = $data['nama kelas'];



// isi nilai cell dengan data 
    $sheet->setCellValue("A" . $baris, $no);
    $sheet->setCellValue("B" . $baris, $kode_akademik);
    $sheet->setCellValue("C" . $baris, $kode_jurusan);
    $sheet->setCellValue("D" . $baris, $kode_matkul);
    $sheet->setCellValue("E" . $baris, $nik);
    $sheet->setCellValue("F" . $baris, $nama_kelas);
    $baris++;
    $no++;
}

// Buat file excel
$filename = $nama_file . ".xlsx";
$writer = new Xlsx($spreadsheet);

ob_end_clean(); // Bersihkan output buffer

// Atur header untuk pengunduhan file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit();
?>