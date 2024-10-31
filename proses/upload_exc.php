<?php
require '../vendor/autoload.php';
require '../conn/koneksi.php';

if (isset($_POST['submit'])) {
    $err = "";
    $ekstensi = "";
    $success = "";

    $file_name = $_FILES['filexls']['name'];
    $file_data = $_FILES['filexls']['tmp_name'];

    if (empty($file_name)) {
        $err .= "<li>Silahkan masukkan file yang kamu inginkan.</li>";
    } else {
        $ekstensi = pathinfo($file_name)['extension'];
    }

    $ekstensi_allowed = array("xls", "xlsx");
    if (!in_array($ekstensi, $ekstensi_allowed)) {
        $err .= "<li>Silahkan masukkan file tipe xls, atau xlsx. File yang kamu masukkan <b>$file_name</b> punya tipe <b>$ekstensi</b></li>";
    }

    if (empty($err)) {
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_data);
        $spreadseet = $reader->load($file_data);
        $sheetData = $spreadseet->getActiveSheet()->toArray();

        $jumlahData = 0;
        for($i=1;$i<count($sheetData);$i++){
            $nik = $sheetData[$i]['1'];
            $nama = mysqli_real_escape_string($koneksi, $sheetData[$i]['2']);
            $jenis_kelamin = $sheetData[$i]['3'];
            $tgl_lahir = $sheetData[$i]['4'];
            $id_paket = $sheetData[$i]['5'];
            $id_per = $sheetData[$i]['6'];
            $telp = $sheetData[$i]['7'];
            $alamat = $sheetData[$i]['8'];
            $department = $sheetData[$i]['9'];
            $lokasi = $sheetData[$i]['10'];
            $status = $sheetData[$i]['11'];

            // Pengecekan apakah kombinasi NIK, id_per, dan id_paket sudah ada di database
            $checkQuery = "SELECT * FROM data_peserta WHERE nik = '$nik' AND id_per = '$id_per' AND id_paket = '$id_paket'";
            $checkResult = mysqli_query($koneksi, $checkQuery);

            if (mysqli_num_rows($checkResult) == 0) {
                // Jika kombinasi belum ada, lakukan INSERT
                $sql1 = "INSERT INTO data_peserta (
                    nik,
                    nama,
                    jenis_kelamin,
                    tgl_lahir,
                    id_paket,
                    id_per,
                    telp,
                    alamat,
                    department,
                    lokasi,
                    status
                    ) VALUES (
                        '$nik',
                        '$nama',
                        '$jenis_kelamin',
                        '$tgl_lahir',
                        '$id_paket',
                        '$id_per',
                        '$telp',
                        '$alamat',
                        '$department',
                        '$lokasi',
                        '$status'
                    )";

                mysqli_query($koneksi, $sql1);
                $jumlahData++;
            }
        }

        if($jumlahData > 0){
            $success = "$jumlahData data berhasil dimasukkan ke MySQL";
        } else {
            $success = "Tidak ada data baru yang dimasukkan, semua data sudah ada.";
        }
    }

    if ($err) {
?>
        <div class="alert alert-danger">
            <ul><?= $err ?></ul>
        </div>
    <?php
    }

    if ($success) {
    ?>
        <div class="alert alert-primary">
            <?= $success ?>
        </div>
<?php
    }
}
