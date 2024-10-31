<?php

include "../conn/koneksi.php";

$no_medrec = mysqli_real_escape_string($koneksi, $_POST['no_medrec']);
$ekspertise_r = mysqli_real_escape_string($koneksi, $_POST['ekspertise_r']);
$kesan_r = mysqli_real_escape_string($koneksi, $_POST['kesan_r']);
$saran_r = mysqli_real_escape_string($koneksi, $_POST['saran_r']);
$dokter_r = mysqli_real_escape_string($koneksi, $_POST['dokter_r']);

if (!empty($_FILES['image']['name'])) {
    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));
    if (!in_array($imageExtension, $validImageExtension)) {
        echo "
    <script>
    alert('File yang diperbolehkan hanya JPG, JPEG, PNG');
    document.location.href = '../view/pemeriksaan.php'
    </script>";
    } elseif ($fileSize > 10000000) {
        echo
        "<script> alert('Image Size Too Large')</script>";
    }else{
        $newImageName = uniqid();
    $newImageName .= '.' . $imageExtension;

    move_uploaded_file($tmpName, 'rad/' . $newImageName);

    $sql = mysqli_query($koneksi, "UPDATE tb_radiologi SET ekspertise_r='$ekspertise_r', kesan_r='$kesan_r', saran_r='$saran_r', dokter_r='$dokter_r', foto_r='$newImageName', status='1' WHERE no_medrec='$no_medrec'");

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

    $sql1 = mysqli_query($koneksi, "UPDATE tb_radiologi SET ekspertise_r='$ekspertise_r', kesan_r='$kesan_r', saran_r='$saran_r', dokter_r='$dokter_r', status='1' WHERE no_medrec='$no_medrec'");

    if ($sql1 > 0) {
        echo "
    <script>
    alert('Data Berhasil Disimpan');
    history. go(-2);
    </script>";
    } else {
        echo "Error: ";
    }
}
