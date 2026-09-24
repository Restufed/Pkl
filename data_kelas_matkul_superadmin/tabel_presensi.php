<?php 
require_once '../database/koneksi.php';

$id_kelas     = isset($_GET['id']) ? mysqli_real_escape_string($db, $_GET['id']) : '';
$id_pertemuan = isset($_GET['id_pertemuan']) ? mysqli_real_escape_string($db, $_GET['id_pertemuan']) : '';
?>

<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th width="5%">No</th>
      <th>Nama Mahasiswa</th>
      <th width="20%" class="text-center">Status</th>
      <th width="10%" class="text-center">Aksi</th>
    </tr>
  </thead>
  <tbody>
  <?php 
  
  $q_mhs = mysqli_query($db, "SELECT tb_peserta.id as id_peserta, tb_peserta.nim, tb_mahasiswa.nama, COALESCE(tb_presensi.status_kehadiran, 'alpa') as status_kehadiran 
                            FROM tb_peserta 
                            JOIN tb_mahasiswa ON tb_peserta.nim = tb_mahasiswa.nim 
                            LEFT JOIN tb_presensi ON tb_peserta.nim = tb_presensi.nim AND tb_presensi.id_pertemuan = '$id_pertemuan'
                            WHERE tb_peserta.id_kelas = '$id_kelas'") 
                        or die(mysqli_error($db));

  $no = 1;
  while ($mhs = mysqli_fetch_array($q_mhs)) {
      $status = strtolower($mhs['status_kehadiran']); 
  ?>
  <tr>
      <td class="text-center"><?= $no++; ?></td>
      <td><?= $mhs['nama']; ?> - <?= $mhs['nim']; ?></td>
      <td class="text-center text-capitalize">
        <?php 
            if ($status == 'hadir') {
                echo '<span class="badge badge-success">Hadir</span>';
            } elseif ($status == 'izin') {
                echo '<span class="badge badge-warning">Izin</span>';
            } elseif ($status == 'sakit') {
                echo '<span class="badge badge-info">Sakit</span>';
            } else {
                echo '<span class="badge badge-danger">Alpa</span>';
            }
        ?>
      </td>
      <td class="text-center">
        <button type="button" 
          class="btn btn-primary btn-sm"
          data-toggle="modal" 
          data-target="#modal-edit-presensi"
          data-nim="<?= $mhs['nim']; ?>"
          data-status="<?= $status; ?>">
          <i class="fas fa-edit"></i> edit
        </button>
      </td>
  </tr>
  <?php 
  } 
  ?>
  </tbody>
</table>