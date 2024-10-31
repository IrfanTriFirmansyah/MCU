<?php

require "../conn/koneksi.php";

$id_peserta = $_GET['id_peserta'];

$sql = mysqli_query($koneksi, "DELETE FROM data_peserta WHERE id_peserta='$id_peserta'");

if ($sql > 0) {
    echo "
    <script>
    alert('Berhasil Menghapus Data');
    document.location.href = '../view/peserta.php'
    </script>";
} else {
    echo "Error: ";
}

?>