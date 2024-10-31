<?php
include "../conn/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['croppedImage']) && $_FILES['croppedImage']['error'] === UPLOAD_ERR_OK) {
        $imgDir = 'rad/';
        if (!is_dir($imgDir)) {
            mkdir($imgDir, 0777, true);
        }
        $no_medrec = $_POST['no_medrec'];

        $fileTmpPath = $_FILES['croppedImage']['tmp_name'];
        $fileName = uniqid() . '.png';
        $destPath = $imgDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $sql = "UPDATE tb_radiologi SET foto_r = '$destPath' WHERE no_medrec='$no_medrec'";
            if ($koneksi->query($sql) === TRUE) {
                echo "Gambar berhasil diupload dan disimpan ke database.";
            } else {
                echo "Error: " . $sql . "<br>" . $koneksi->error;
            }
        } else {
            echo "Error moving the uploaded file.";
        }
    } else {
        echo "No file uploaded or upload error.";
    }
}

$koneksi->close();
?>
