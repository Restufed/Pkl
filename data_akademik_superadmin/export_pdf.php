<?php
require_once '../database/koneksi.php';
require('../aset_adminlte/fpdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('../aset_adminlte/img/logo.png', 10, 12, 40);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 8, 'Fakultas Sains Dan Teknologi', 0, 2, 'C');
        $this->Cell(30, 6, 'Prodi Informatika', 0, 2, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 4, 'Jalan Raya Pagojengan KM.3, Kecamatan Paguyangan, Kab. Brebes', 0, 2, 'C');
        $this->Cell(30, 4, 'Provinsi Jawa Tengah, 52276', 0, 0, 'C');
        $this->SetLineWidth(1);
        $this->Line(10, 37, 200, 37);
        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Judul Laporan
$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(80);
$pdf->Cell(30, 4, 'Data Akademik', 0, 1, 'C');
$pdf->Ln(5);

// Header Tabel
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(15, 6, 'No', 1, 0, 'C');
$pdf->Cell(45, 6, 'Kode Akademik', 1, 0, 'C');
$pdf->Cell(40, 6, 'Semester', 1, 0, 'C');
$pdf->Cell(40, 6, 'Tahun', 1, 0, 'C');
$pdf->Cell(45, 6, 'Status', 1, 1, 'C');

// Query Data Akademik
$query_panggil_akademik = mysqli_query($db, "SELECT * FROM tb_akademik") or die(mysqli_error($db));
$rv = mysqli_num_rows($query_panggil_akademik);

$pdf->SetFont('Times', '', 11);
if ($rv > 0) {
    $no = 1;
    while ($data = mysqli_fetch_array($query_panggil_akademik)) {
        $kode_akademik = $data['kode_akademik'];
        $semester      = ($data['Semester'] == 'GN') ? 'Genap' : 'Ganjil';
        $tahun         = $data['Tahun'];
        $status        = ($data['is_active'] == '1') ? 'Aktif' : 'Tidak Aktif';

        $pdf->Cell(15, 6, $no++, 1, 0, 'C');
        $pdf->Cell(45, 6, $kode_akademik, 1, 0, 'C');
        $pdf->Cell(40, 6, $semester, 1, 0, 'C');
        $pdf->Cell(40, 6, $tahun, 1, 0, 'C');
        $pdf->Cell(45, 6, $status, 1, 1, 'C');
    }
}

$pdf->Output();
?>