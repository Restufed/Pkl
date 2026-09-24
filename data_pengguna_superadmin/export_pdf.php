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
$pdf->Cell(30, 4, 'Data Pengguna', 0, 1, 'C');
$pdf->Ln(5);

// Header Tabel (Total Lebar: 15 + 65 + 60 + 50 = 190 mm)
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(15, 6, 'No', 1, 0, 'C');
$pdf->Cell(65, 6, 'Nama', 1, 0, 'C');
$pdf->Cell(60, 6, 'Username', 1, 0, 'C');
$pdf->Cell(50, 6, 'Peran', 1, 1, 'C');

// Query Data Pengguna
$query_panggil_pengguna = mysqli_query($db, "SELECT * FROM tb_pengguna") or die(mysqli_error($db));
$rv = mysqli_num_rows($query_panggil_pengguna);

$pdf->SetFont('Times', '', 11);
if ($rv > 0) {
    $no = 1;
    while ($data = mysqli_fetch_array($query_panggil_pengguna)) {
        $nama     = $data['nama'];
        $username = $data['username'];
        $peran    = $data['peran'];

        // Konversi Kode Peran
        if ($peran == 'S') {
            $text_peran = 'Super Admin';
        } else if ($peran == 'D') {
            $text_peran = 'Dosen';
        } else {
            $text_peran = 'Mahasiswa';
        }

        // Isi Tabel
        $pdf->Cell(15, 6, $no++, 1, 0, 'C');
        $pdf->Cell(65, 6, $nama, 1, 0, 'L');
        $pdf->Cell(60, 6, $username, 1, 0, 'L');
        $pdf->Cell(50, 6, $text_peran, 1, 1, 'C');
    }
}

$pdf->Output();
?>