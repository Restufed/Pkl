<?php
require_once "../database/koneksi.php";
require '../vendor/autoload.php'; 

// panggil fungsi phpspreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// buka buffering
ob_start();

// buat nama file
$nama_file = "Data-Akademik-" . date('Y-m-d');
$query_panggil_akademik = mysqli_query($db, "SELECT * FROM tb_akademik") or die(mysqli_error($db));

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Akademik');

// Set header cells
$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'Kode Akademik');
$sheet->setCellValue('C1', 'Semester');
$sheet->setCellValue('D1', 'Tahun');
$sheet->setCellValue('E1', 'Status');

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];

// aplikasi dari konfigurasi styling style
$sheet->getStyle('A1:E1')->applyFromArray($styleArray);

// styling font menjadi bold ke cell yang dituju
$sheet->getStyle('A1:E1')->getFont()->setBold(true);

// styling lebar sel menjadi auto (sesuai panjang data)
foreach (array('A', 'B', 'C', 'D', 'E') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// buat no dari 1
$no = 1;
// bikin baris 2
$baris = 2;

// buat pengulangan data
while ($data = mysqli_fetch_assoc($query_panggil_akademik)) {
    // tampung dari database tiap kolom 
    $kode_akademik = $data['kode_akademik'];
    $Semester      = ($data['Semester'] == 'GN') ? 'Genap' : 'Ganjil';
    $Tahun         = $data['Tahun'];
    $is_active     = ($data['is_active'] == '1') ? 'Aktif' : 'Tidak Aktif';

    // isi nilai cell dengan data 
    $sheet->setCellValue("A" . $baris, $no);
    $sheet->setCellValue("B" . $baris, $kode_akademik);
    $sheet->setCellValue("C" . $baris, $Semester);
    $sheet->setCellValue("D" . $baris, $Tahun);
    $sheet->setCellValue("E" . $baris, $is_active);

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