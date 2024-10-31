<?php

session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}

include "../conn/koneksi.php";

$nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$jk = mysqli_real_escape_string($koneksi, $_POST['jk']);
$tgl = mysqli_real_escape_string($koneksi, $_POST['tgl']);
// $tmp = mysqli_real_escape_string($koneksi, $_POST['tmp']);
$paket = mysqli_real_escape_string($koneksi, $_POST['paket']);
$asal = mysqli_real_escape_string($koneksi, $_POST['asal']);
$telp = mysqli_real_escape_string($koneksi, $_POST['telp']);
$alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

$date = new DateTime($tgl);
$formatDate = $date->format('d-m-Y');

$fileName = $_FILES["image"]["name"];
$fileSize = $_FILES["image"]["size"];
$tmpName = $_FILES["image"]["tmp_name"];

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));
    if (!in_array($imageExtension, $validImageExtension)) {
        echo
        "<script> alert('Invalid Image Extension')</script>
    document.location.href = '../view/pendaftaran_baru.php'
    ";
    } elseif ($fileSize > 10000000) {
        echo
        "<script> alert('Image Size Too Large')
    document.location.href = '../view/pendaftaran_baru.php'</script>
    ";
    } else {
        $newImageName = uniqid();
        $newImageName .= '.' . $imageExtension;

        move_uploaded_file($tmpName, 'PesertaBaru/' . $newImageName);


        $sql = mysqli_query($koneksi, "INSERT INTO data_peserta (nik,nama,jenis_kelamin,tgl_lahir,id_per,id_paket,foto_lama,telp,alamat,status) VALUES ('$nik','$nama','$jk','$formatDate','$asal','$paket','$newImageName','$telp','$alamat','cakar')");

        if ($sql > 0) {
            echo "
    <script>
    alert('Data Berhasil Disimpan');
    document.location.href = '../view/pendaftaran.php'
    </script>";
        } else {
            echo "Error: ";
        }
    }
} else {


    $sql = mysqli_query($koneksi, "INSERT INTO data_peserta (nik,nama,jenis_kelamin,tgl_lahir,id_per,id_paket,telp,alamat,status) VALUES ('$nik','$nama','$jk','$formatDate','$asal','$paket','$telp','$alamat','cakar')");

    if ($sql > 0) {
        echo "
    <script>
    alert('Data Berhasil Disimpan');
    document.location.href = '../view/pendaftaran.php'
    </script>";
    } else {
        echo "Error: ";
    }
}
