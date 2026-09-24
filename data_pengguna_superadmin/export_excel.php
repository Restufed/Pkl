<?php
require_once "../database/koneksi.php";
require '../vendor/autoload.php'; 

// Panggil fungsi PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Buka buffering
ob_start();

// Buat nama file
$nama_file = "Data-Pengguna-" . date('Y-m-d');

// Query data dari tb_pengguna
$query_panggil_pengguna = mysqli_query($db, "SELECT * FROM tb_pengguna") or die(mysqli_error($db));

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Pengguna');

// Set header cells
$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'NAMA');
$sheet->setCellValue('C1', 'USERNAME');
$sheet->setCellValue('D1', 'PERAN');

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];

// Aplikasi dari konfigurasi styling style
$sheet->getStyle('A1:D1')->applyFromArray($styleArray);

// Styling font menjadi bold ke cell yang dituju
$sheet->getStyle('A1:D1')->getFont()->setBold(true);

// Styling lebar sel menjadi auto (sesuai panjang data)
foreach (array('A', 'B', 'C', 'D') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Buat no dari 1
$no = 1;
// Baris data dimulai dari baris 2
$baris = 2;

// Pengulangan data
while ($data = mysqli_fetch_assoc($query_panggil_pengguna)) {
    $nama     = $data['nama'];
    $username = $data['username'];
    $peran    = $data['peran'];

    // Konversi kode peran menjadi teks yang mudah dibaca
    if ($peran == 'S') {
        $text_peran = 'Super Admin';
    } else if ($peran == 'D') {
        $text_peran = 'Dosen';
    } else {
        $text_peran = 'Mahasiswa';
    }

    // Isi nilai cell dengan data
    $sheet->setCellValue("A" . $baris, $no);
    $sheet->setCellValue("B" . $baris, $nama);
    $sheet->setCellValue("C" . $baris, $username);
    $sheet->setCellValue("D" . $baris, $text_peran);

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