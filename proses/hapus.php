<?php

require "../conn/koneksi.php";

$nama = $_GET['nama'];

$sql = mysqli_query($koneksi, "DELETE FROM tb_dokter WHERE nama='$nama'");

if ($sql > 0) {
    echo "
    <script>
    alert('Berhasil Menghapus Data');
    document.location.href = '../view/dokter.php'
    </script>";
} else {
    echo "Error: ";
}

?>