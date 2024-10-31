<?php

use function PHPSTORM_META\map;

session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include "../conn/koneksi.php";

$no_medrec = $_POST['no_medrec'];
// $rhy = $_POST['rhy'];
// $pw = $_POST['pw'];
// $pr = $_POST['pr'];
// $qrs = $_POST['qrs'];
// $st = $_POST['st'];
// $qt = $_POST['qt'];
// $foto = $_POST['foto'];
$kesan_e = $_POST['kesan_e'];
$kes_e = $_POST['kes_e'];
$saran_e = $_POST['saran_e'];
$dokter_e = $_POST['dokter_e'];

if (!empty($_FILES['image']['name'])) {
    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));
    if (!in_array($imageExtension, $validImageExtension)) {
        echo
        "<script> alert('Invalid Image Extension')</script>";
    } elseif ($fileSize > 1000000000) {
        echo
        "<script> alert('Image Size Too Large')</script>";
    } else {
        $newImageName = uniqid();
        $newImageName .= '.' . $imageExtension;

        move_uploaded_file($tmpName, 'ekg/' . $newImageName);


        $sql = mysqli_query($koneksi, "UPDATE tb_ekg SET  foto_ekg='$newImageName', kesan_e='$kesan_e', saran_e='$saran_e', kes_e='$kes_e', dokter_e='$dokter_e',status='1' WHERE no_medrec='$no_medrec'");

        if ($sql > 0) {
            echo "
    <script>
    alert('Data Berhasil Disimpan');
    history. go(-2);
    </script>";
        } else {
            echo "Error: ";
        }
    }
} else {
    $sql = mysqli_query($koneksi, "UPDATE tb_ekg SET  kesan_e='$kesan_e', saran_e='$saran_e', kes_e='$kes_e', dokter_e='$dokter_e',status='1' WHERE no_medrec='$no_medrec'");

    if ($sql > 0) {
        echo "
    <script>
    alert('Data Berhasil Disimpan');
    history. go(-2);
    </script>";
    } else {
        echo "Error: ";
    }
}
