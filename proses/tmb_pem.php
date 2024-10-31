<?php

error_reporting(0);
ini_set('display_errors', 0);

require "../conn/koneksi.php";

$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$pem = mysqli_real_escape_string($koneksi, $_POST['pem']);

$sql = mysqli_query($koneksi, "SELECT sps FROM tb_dokter WHERE sps='$pem'");
$sql1 = mysqli_fetch_assoc($sql);


    $row = mysqli_query($koneksi, "INSERT INTO `tb_dokter`(`id`, `nama`, `sps`, `aktif`) VALUES ('','$nama','$pem','')");

    if ($row) {
        echo "
    <script>
    alert('Berhasil Disimpan');
    document.location.href = '../view/dokter.php'
    </script>";
    } else {
        echo "Error: ";
    }
