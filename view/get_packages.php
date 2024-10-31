<?php
include '../conn/koneksi.php';

if (isset($_POST['id_per'])) {
    $id_per = $_POST['id_per'];
    $sql = "SELECT id_paket, nama_paket FROM tb_paket WHERE id_per='$id_per'";
    $result = $koneksi->query($sql);

    $options = "";
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['id_paket'] . "'>" . $row['nama_paket'] . "</option>";
    }
    echo $options;
}

$conn->close();
?>
