<?php

require "../conn/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama_per = $_POST['nama_per'];
    $kode = $_POST['kode'];

    $sql = mysqli_query($koneksi, "UPDATE tb_per SET nama_per='$nama_per', kode='$kode' WHERE id_per='$id'");

    if ($sql > 0) {
        echo "
<script>
alert('Berhasil Simpan Perubahan');
document.location.href = '../view/perusahaan.php'
</script>";
    } else {
        echo "Error: ";
    }
} else{
    $id = $_GET['id'];

    $sql = mysqli_query($koneksi, "DELETE FROM `tb_per` WHERE id_per='$id'");

    if ($sql > 0) {
        echo "
<script>
alert('Berhasil Hapus Data');
document.location.href = '../view/perusahaan.php'
</script>";
    } else {
        echo "Error: ";
    }
}
