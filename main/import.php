<?php
require '../vendor/autoload.php'; // Include PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

// Koneksi ke database
$host = 'localhost';
$dbname = 'mcu-v.03.2'; // Ganti dengan nama database Anda
$user = 'root'; // Ganti dengan username MySQL Anda
$pass = ''; // Ganti dengan password MySQL Anda

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses upload dan import Excel
if (isset($_POST['import'])) {
    $fileTmp = $_FILES['file']['tmp_name'];
    $fileExt = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    // Cek apakah file yang diupload adalah XLSX
    if ($fileExt == 'xlsx') {
        try {
            // Load file Excel langsung dari tmp_name (tanpa menyimpan file)
            $spreadsheet = IOFactory::load($fileTmp);
            $sheet = $spreadsheet->getActiveSheet();
            $rowIterator = $sheet->getRowIterator(2); // Mulai dari baris kedua (lewati header)

            // Loop melalui setiap baris dalam Excel
            foreach ($rowIterator as $row) {
                $no_medrec = $sheet->getCell('A' . $row->getRowIndex())->getValue();  // Kolom NIK
                $gula_darah_sewaktu = $sheet->getCell('B' . $row->getRowIndex())->getValue();  // Kolom Jenis Kelamin

                // Update data gula_darah_sewaktu di database berdasarkan NIK
                $sql = "UPDATE rekam_mcu SET ket = ? WHERE no_medrec = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $gula_darah_sewaktu, $no_medrec);
                $stmt->execute();
            }

            echo "<div class='alert alert-success'>Data berhasil diimport!</div>";
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Gagal membaca file Excel: " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Hanya file XLSX yang diizinkan.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Jenis Kelamin dari Excel (XLSX)</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Import Jenis Kelamin dari Excel (XLSX)</h2>

    <!-- Form Upload Excel -->
    <form action="import.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="file">Upload File Excel (XLSX)</label>
            <input type="file" class="form-control" name="file" id="file" required>
        </div>
        <button type="submit" name="import" class="btn btn-primary">Import Data</button>
    </form>

    <br>

    <?php if (isset($_POST['import'])): ?>
        <!-- Tampilkan pesan sukses atau gagal setelah upload -->
        <div class="alert alert-info">
            Proses import selesai.
        </div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
