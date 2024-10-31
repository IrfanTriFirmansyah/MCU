<?php

include "../conn/koneksi.php";

$no_medrec = mysqli_real_escape_string($koneksi, $_POST['no_medrec']);
$dokter = mysqli_real_escape_string($koneksi, $_POST['dokter']);
$ket = mysqli_real_escape_string($koneksi, $_POST['ket']);
$kesimpulan = mysqli_real_escape_string($koneksi, $_POST['kesimpulan']);
$saran = mysqli_real_escape_string($koneksi, $_POST['Saran']);

$sql = mysqli_query($koneksi,"UPDATE rekam_mcu SET dokter='$dokter', ket='$ket', kesimpulan='$kesimpulan', saran='$saran' WHERE no_medrec='$no_medrec'");

if ($sql> 0) {
    echo "
    <script>
    alert('Data Berhasil Disimpan');
    history. go(-2);
    </script>";
} else {
    echo "Error: ";
}
?>