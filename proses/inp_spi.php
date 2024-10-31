<?php

include "../conn/koneksi.php";

$no_medrec = $_POST['no_medrec'];
$nilai_fvc = $_POST['nilai_fvc'];
$nilai_fev = $_POST['nilai_fev'];
$nilai_fcv = $_POST['nilai_fcv'];
$pred_fvc = $_POST['pred_fvc'];
$pred_fev = $_POST['pred_fev'];
$pred_fcv = $_POST['pred_fcv'];
$persen_fvc = $_POST['persen_fvc'];
$persen_fev = $_POST['persen_fev'];
$persen_fcv = $_POST['persen_fcv'];
$kesan_s = $_POST['kesan_s'];
$saran_s = $_POST['saran_s'];
$dokter_s = $_POST['dokter_s'];


if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));
    if (!in_array($imageExtension, $validImageExtension)) {
        echo
        "<script> alert('Invalid Image Extension')</script>";
    } elseif ($fileSize > 1000000) {
        echo
        "<script> alert('Image Size Too Large')</script>";
    } else {
        $newImageName = uniqid();
        $newImageName .= '.' . $imageExtension;

        move_uploaded_file($tmpName, 'sp/' . $newImageName);

        $sql = mysqli_query($koneksi, "UPDATE tb_spirometri SET 
        nilai_fvc='$nilai_fvc', 
        nilai_fev='$nilai_fev', 
        nilai_fcv='$nilai_fcv', 
        pred_fvc='$pred_fvc', 
        pred_fev='$pred_fev', 
        pred_fcv='$pred_fcv', 
        nilai_fvc='$nilai_fvc', 
        nilai_fev='$nilai_fev', 
        nilai_fcv='$nilai_fcv', 
        persen_fvc='$persen_fvc', 
        persen_fev='$persen_fev', 
        persen_fcv='$persen_fcv', 
        kesan_s='$kesan_s', 
        saran_s='$saran_s', 
        dokter_s='$dokter_s', 
        foto_sp='$newImageName', 
        status='1' 
        WHERE no_medrec='$no_medrec'");

        if ($sql > 0) {
            echo "
    <script>
    alert('Berhasil Disimpan');
    history. go(-2);
    </script>";
        } else {
            echo "Error: ";
        }
    }
} else{
    $sql = mysqli_query($koneksi, "UPDATE tb_spirometri SET 
        nilai_fvc='$nilai_fvc', 
        nilai_fev='$nilai_fev', 
        nilai_fcv='$nilai_fcv', 
        pred_fvc='$pred_fvc', 
        pred_fev='$pred_fev', 
        pred_fcv='$pred_fcv', 
        nilai_fvc='$nilai_fvc', 
        nilai_fev='$nilai_fev', 
        nilai_fcv='$nilai_fcv', 
        persen_fvc='$persen_fvc', 
        persen_fev='$persen_fev', 
        persen_fcv='$persen_fcv', 
        kesan_s='$kesan_s', 
        saran_s='$saran_s', 
        dokter_s='$dokter_s', 
        status='1' 
        WHERE no_medrec='$no_medrec'");

        if ($sql > 0) {
            echo "
    <script>
    alert('Berhasil Disimpan');
    history. go(-2);
    </script>";
        } else {
            echo "Error: ";
        }
}
