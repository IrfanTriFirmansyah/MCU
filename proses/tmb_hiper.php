<?php

require "../conn/koneksi.php";


if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $row = mysqli_query($koneksi, "INSERT INTO `tb_dokter`(`id`, `nama`, `sps`, `aktif`) VALUES ('','$nama','hiperkes','1')");

    if ($row > 0) {
        echo "
    <script>
    alert('Berhasil Disimpan');
    document.location.href = '../view/dokter.php'
    </script>";
    } else {
        echo "Error: ";
    }
}

if (isset($_POST['edit'])) {
    $dkt = mysqli_real_escape_string($koneksi, $_POST['dkt']);
    $sql1 = mysqli_query($koneksi, "UPDATE tb_dokter SET aktif='1' WHERE aktif='2'");
    $sql = mysqli_query($koneksi, "UPDATE tb_dokter SET aktif='2' WHERE nama='$dkt'");

    if ($sql > 0) {
        echo "
    <script>
    alert('Simpan Perubahan Berhasil    ');
    document.location.href = '../view/dokter.php'
    </script>";
    } else {
        echo "Error: ";
    }
}
