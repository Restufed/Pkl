<?php
require_once "../database/koneksi.php";
require '../vendor/autoload.php'; 
// panggil fungsi phpsspretsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// buka bufering
ob_start();
// buat nama file
$nama_file = "Data-Dosen-" . date('Y-m-d');
$query_panggil_mahsiswa=mysqli_query($db,"SELECT * FROM tb_dosen ") or die (mysqli_error($db,));


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Dosen');

// Set header cells
$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'nik');
$sheet->setCellValue('C1', 'nama ');
$sheet->setCellValue('D1', 'kontak ');
$sheet->setCellValue('E1', 'email ');
$sheet->setCellValue('F1', 'jenis kelamin ');

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];
// aplikasi dari konfigurasi styling style
$sheet->getStyle('A1:F1')->applyFromArray($styleArray);
// styling font mnjadi bold ke cell yang di tuju
$sheet->getStyle('A1:F1')->getFont()->setBold(true);
// styling lebar sel menjadi auto (sesuai panjng data )
foreach (array('A','B', 'C','D','E','F',) as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}
// buat no dri 1
$no = 1;
// bkin baris 2
$baris = 2;
// buat pengulngn data
while ($data = mysqli_fetch_assoc($query_panggil_mahsiswa)) {
    // tampung dri database tiap kolom 
    $nik = $data['nik'];
    $nama = $data['nama'];
    $kontak = $data['kontak'];
    $email = $data['email'];
    $jenis_kelamin = $data['kelamin'];



// isi nilai cell dengan data 
    $sheet->setCellValue("A" . $baris, $no);
    $sheet->setCellValue("B" . $baris, $nik);
    $sheet->setCellValue("C" . $baris, $nama);
    $sheet->setCellValue("D" . $baris, $kontak);
    $sheet->setCellValue("E" . $baris, $email);
    $sheet->setCellValue("F" . $baris, $jenis_kelamin);
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