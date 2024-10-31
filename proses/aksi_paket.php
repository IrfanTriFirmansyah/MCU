<?php

require "../conn/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $id_per = $_POST['id_per'];
    $harga_male = str_replace('.', '', $_POST['harga_male']);
    $harga_female = str_replace('.', '', $_POST['harga_female']);
    $bayar = $_POST['bayar'];
    $pemeriksaan = $_POST['pemeriksaan'];

    $sql = "INSERT INTO tb_paket (nama_paket, id_per, harga_male, harga_female, bayar) VALUES ('$nama', '$id_per', '$harga_male', '$harga_female', '$bayar')";

    if ($koneksi->query($sql) === TRUE) {
        $id_paket = $koneksi->insert_id;

        // Insert pemeriksaan for the package
        foreach ($pemeriksaan as $examination) {
            $sql = "INSERT INTO tb_detail_paket (id_paket, tipe_paket) VALUES ('$id_paket', '$examination')";
            $koneksi->query($sql);
        }

        echo "
        <script>
        alert('Berhasil Menyimpan Paket');
        document.location.href = '../view/paket.php'
        </script>";
    } else {
        echo "Error: ";
    }
} 
else {
    $id = $_GET['id'];

    $sql = mysqli_query($koneksi, "DELETE FROM `tb_paket` WHERE id_paket='$id'");

    if ($sql > 0) {
        echo "
<script>
alert('Berhasil Hapus Data');
document.location.href = '../view/paket.php'
</script>";
    } else {
        echo "Error: ";
    }
}
