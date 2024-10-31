<?php

include "../conn/koneksi.php";

header('Content-Type: application/json');

$response = array();

if (isset($_POST['nik'])) {
    $nik = $_POST['nik'];


    // Mendapatkan biodata berdasarkan NIK
    $sql = "SELECT * FROM data_peserta WHERE NIK = '$nik'";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response['nama'] = $row['Nama'];
        // Menghasilkan respons dalam format JSON
        echo json_encode($row);
    } else {
        // Jika NIK tidak ditemukan, kirim respons JSON dengan nilai null
        $response['error'] = "NIK tidak ditemukan";
    }
}
echo json_encode($response);
