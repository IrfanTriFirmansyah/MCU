<?php
// require 'vendor/autoload.php';
// use Endroid\QrCode\QrCode;
// use Endroid\QrCode\Writer\PngWriter;

// include "../conn/koneksi.php";

// // Ambil data karyawan
// $sql = "SELECT id, nama, alamat FROM testing";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         $dataDiri = "Nama: " . $row["nama"] . "\nAlamat: " . $row["alamat"];
//         $qrCode = new QrCode($dataDiri);
//         $qrCode->setSize(300);

//         // Buat string QR code untuk disimpan ke database
//         $qrCodeString = base64_encode($qrCode->writeString());

//         // Update database dengan QR code
//         $updateSql = "UPDATE testing SET qr_code='$qrCodeString' WHERE id=" . $row["id"];
//         $conn->query($updateSql);
//     }
// }

// $conn->close();
// echo "QR codes generated and stored successfully.";
?>