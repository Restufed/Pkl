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
$pdf->Cell(30, 4, 'Data presensi', 0, 1, 'C');
$pdf->Ln(5);

$id_kelas = $_GET['id_kelas'];
$query_kelas = mysqli_query($db, "SELECT * FROM tb_kelas_matkul WHERE id= '$id_kelas'") or die(mysqli_error($db));
                $data = mysqli_fetch_array($query_kelas);

                $kode_akademik = isset($data['kode_akademik']) ? $data['kode_akademik'] : '';
                $kode_jurusan  = isset($data['kode_jurusan']) ? $data['kode_jurusan'] : '';
                $kode_matkul   = isset($data['kode_matkul']) ? $data['kode_matkul'] : '';
                $nik           = isset($data['nik']) ? $data['nik'] : '';

                
                $query_dosen = mysqli_query($db, "SELECT * FROM tb_dosen WHERE nik = '$nik'") or die(mysqli_error($db));
                $data_dosen  = mysqli_fetch_array($query_dosen);
                $kelamin = isset($data_dosen['kelamin']) ? $data_dosen['kelamin'] : '';
                $img     = isset($data_dosen['img']) ? $data_dosen['img'] : NULL;
$query_akademik = mysqli_query($db, "SELECT Tahun, Semester FROM tb_akademik WHERE kode_akademik = '$kode_akademik'") or die(mysqli_error($db));
                        $data_akademik  = mysqli_fetch_array($query_akademik);
                        
                        $tahun_akademik = isset($data_akademik['Tahun']) ? $data_akademik['Tahun'] : '';
                        $sem_akademik   = isset($data_akademik['Semester']) ? $data_akademik['Semester'] : '';
                        
                        if ($sem_akademik == 'GN') {
                            $text_semester = 'Genap';
                        } else {
                            $text_semester = 'Ganjil';
                        }

                        $query_jurusan = mysqli_query($db, "SELECT nama_jurusan FROM tb_jurusan WHERE kode_jurusan = '$kode_jurusan'") or die(mysqli_error($db));
                        $data_jurusan  = mysqli_fetch_array($query_jurusan);
                        if (isset($data_jurusan['nama_jurusan'])) {
                            
                        }
      $query_matkul = mysqli_query($db, "SELECT nama_matkul FROM tb_matkul WHERE kode_matkul = '$kode_matkul'") or die(mysqli_error($db));
                        $data_matkul  = mysqli_fetch_array($query_matkul);
                        $nama_matkul  = isset($data_matkul['nama_matkul']) ? $data_matkul['nama_matkul'] : '';   
                        
  $nama_dosen = isset($data_dosen['nama']) ? $data_dosen['nama'] : '';
                        $nik_dosen  = isset($data_dosen['nik']) ? $data_dosen['nik'] : '';
 
                         
// Header Tabel
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(100, 6, 'Periode Akademik: '.$tahun_akademik , 0, 0, 'L');
$pdf->Cell(20, 6, 'Dosen : '.$nama_dosen, 0, 1, 'L');
$pdf->Cell(100, 6, 'Mata Kuliah: '.$nama_matkul , 0, 0, 'L');
$pdf->Cell(20, 6, 'Jurusan : '.$data_jurusan['nama_jurusan'], 0, 1, 'L');
$pdf->Cell(100, 6, 'Nama Kelas: '.$data['nama_kelas'] , 0, 1, 'L');

$query_pertemuan = mysqli_query($db,"SELECT * FROM tb_pertemuan WHERE id_kelas='$id_kelas' ")or die (mysqli_error($db));
$rv =mysqli_num_rows($query_pertemuan);
   if ($rv>0){
    while ($data_pertemuan = mysqli_fetch_array($query_pertemuan)){
        $id_pertemuan = $data_pertemuan ['id'];
  $pdf->Cell(20, 6, 'pertemuan ke : '.$data_pertemuan ['pertemuan_ke'], 0, 1, 'L');
    $query_presensi = (mysqli_query($db,"SELECT * FROM tb_presensi WHERE id_pertemuan='$id_pertemuan'")) or die(mysqli_error($db));
    $pdf->Cell(15, 6, 'NO ', 1, 0, 'L');
$pdf->Cell(60, 6, 'Nama Mahasiswa ', 1, 0, 'L');
$pdf->Cell(50, 6, 'Status Kehadiran ', 1, 1, 'L');
$no = 1;
while ($data_presensi = mysqli_fetch_array($query_presensi)){
    $nim =$data_presensi['nim'];
    $query_mhs = mysqli_query($db, "SELECT nama FROM tb_mahasiswa WHERE nim = '$nim' ")or die(mysqli_error($db));
    $data_mhs= mysqli_fetch_array($query_mhs);
    $nama_mhs = $data_mhs['nama'];
    $status_kehadiran = $data_presensi['status_kehadiran'];
$pdf->Cell(15, 6, $no++ , 1, 0, 'L');
$pdf->Cell(60, 6, $nama_mhs, 1, 0, 'L');
$pdf->Cell(50, 6, $status_kehadiran , 1, 1, 'L');




}

    }
   }



$pdf->Output();
?>