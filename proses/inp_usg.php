<?php

include "../conn/koneksi.php";

$nik = $_POST['nik'];
$kesan_us = $_POST['kesan_us'];
$saran_us = $_POST['saran_us'];

$sql = mysqli_query($koneksi, "UPDATE tb_usg SET kesan_us='$kesan_us', saran_us='$saran_us', status='1' WHERE nik='$nik'");

if ($sql> 0) {
    echo "
    <script>
    alert('Berhasil Disimpan');
    document.location.href = '../view/pemeriksaan.php'
    </script>";
} else {
    echo "Error: ";
}
?>