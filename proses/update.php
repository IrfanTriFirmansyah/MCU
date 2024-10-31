<?php

require "../conn/koneksi.php";

// Mengamankan input dari form
$id = mysqli_real_escape_string($koneksi, $_POST['id']);
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$pem = mysqli_real_escape_string($koneksi, $_POST['pem']);

// Logika upload file tanda tangan
if(isset($_FILES['ttd']) && $_FILES['ttd']['error'] === 0) {
    $target_dir = "../proses/ttd/"; // Folder tempat menyimpan gambar
    $file_name = basename($_FILES['ttd']['name']);
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file benar-benar gambar
    $check = getimagesize($_FILES['ttd']['tmp_name']);
    if($check !== false) {
        // Validasi jenis file (hanya memperbolehkan png, jpg, jpeg)
        if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
            // Proses upload file
            if (move_uploaded_file($_FILES['ttd']['tmp_name'], $target_file)) {
                // Simpan ke database dengan nama file yang diupload
                $sql = mysqli_query($koneksi, "UPDATE tb_dokter SET nama='$nama', sps='$pem', ttd='$file_name' WHERE id='$id'");
                
                if ($sql) {
                    echo "
                    <script>
                    alert('Berhasil Simpan Perubahan');
                    document.location.href = '../view/dokter.php';
                    </script>";
                } else {
                    echo "Error: " . mysqli_error($koneksi);
                }
            } else {
                echo "Error: Gagal mengupload file.";
            }
        } else {
            echo "Error: Hanya file JPG, JPEG, & PNG yang diperbolehkan.";
        }
    } else {
        echo "Error: File bukan gambar.";
    }
} else {
    // Jika tidak ada file yang diupload, tetap update data lainnya
    $sql = mysqli_query($koneksi, "UPDATE tb_dokter SET nama='$nama', sps='$pem' WHERE id='$id'");
    
    if ($sql) {
        echo "
        <script>
        alert('Berhasil Simpan Perubahan');
        document.location.href = '../view/dokter.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

?>
