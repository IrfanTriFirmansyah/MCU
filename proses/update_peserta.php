<?php

require "../conn/koneksi.php";

$id_peserta = mysqli_real_escape_string($koneksi, $_POST['id_peserta']);
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
$jk = mysqli_real_escape_string($koneksi, $_POST['jk']);
$tgl = mysqli_real_escape_string($koneksi, $_POST['tgl']);
$telp = mysqli_real_escape_string($koneksi, $_POST['telp']);
$alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

$date = new DateTime($tgl);
$formatDate = $date->format('d-m-Y');

$sql = mysqli_query($koneksi, "UPDATE data_peserta SET 
nama='$nama', 
nik='$nik', 
jenis_kelamin='$jk', 
tgl_lahir='$formatDate',  
telp='$telp',  
alamat='$alamat'
WHERE id_peserta='$id_peserta'");

if ($sql > 0) {
    echo "
<script>
alert('Berhasil Simpan Perubahan');
history.go(-1);
</script>";
} else {
    echo "Error: ";
}
