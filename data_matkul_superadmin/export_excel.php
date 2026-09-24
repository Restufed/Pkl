<?php
require_once "../database/koneksi.php";
require '../vendor/autoload.php'; 
// panggil fungsi phpsspretsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// buka bufering
ob_start();
// buat nama file
$nama_file = "Data-Mata Kuliah-" . date('Y-m-d');
$query_panggil_matkul=mysqli_query($db,"SELECT * FROM tb_matkul ") or die (mysqli_error($db,));


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Mata kuliah');

// Set header cells
$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'kode Matkul');
$sheet->setCellValue('C1', 'nama Matkul');

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
foreach (array('A','B', 'C') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}
// buat no dri 1
$no = 1;
// bkin baris 2
$baris = 2;
// buat pengulngn data
while ($data = mysqli_fetch_assoc($query_panggil_matkul)) {
    // tampung dri database tiap kolom 
    $kode_matkul = $data['kode_matkul'];
    $nama_matkul = $data['nama_matkul'];
// isi nilai cell dengan data 
    $sheet->setCellValue("A" . $baris, $no);
    $sheet->setCellValue("B" . $baris, $kode_matkul);
    $sheet->setCellValue("C" . $baris, $nama_matkul);
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