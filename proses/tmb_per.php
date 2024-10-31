<?php

include "../conn/koneksi.php";
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$kode = mysqli_real_escape_string($koneksi, $_POST['kode']);

$sql = mysqli_query($koneksi,"INSERT INTO `tb_per`(`nama_per`, `kode`) VALUES ('$nama','$kode')");

if ($sql> 0) {
    echo "
    <script>
    alert('Data Berhasil Disimpan');
    document.location.href = '../view/perusahaan.php'
    </script>";
} else {
    echo "Error: ";
}
?>