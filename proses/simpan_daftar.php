<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>

<body>

</body>

</html>
<?php

session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}

include "../conn/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data yang dikirimkan dari form
    $nik = $_POST['nik'];
    $id_peserta = $_POST['id_peserta'];
    // $jk = $_POST['jk'];
    $id_paket = $_POST['id_paket'];
    $id_per = $_POST['id_per'];
    $foto = $_POST['foto'];
    $telp = $_POST['telp'];
    date_default_timezone_set('Asia/Jakarta');
    $date = date('d-m-Y');

    // Menghapus bagian data URL
    $foto = str_replace('data:image/png;base64,', '', $foto);
    $foto = str_replace(' ', '+', $foto);
    $data = base64_decode($foto);

    // Nama file unik
    $filename = uniqid() . '.png';
    $filepath = 'peserta/' . $filename;

    // Simpan file ke filesystem
    if (!file_exists('peserta')) {
        mkdir('peserta', 0777, true);
    }
    file_put_contents($filepath, $data);
    
    // $jklm = mysqli_query($koneksi, "UPDATE data_peserta SET jenis_kelamin='$jk' WHERE id_peserta='$id_peserta'");


    // Cek apakah peserta sudah terdaftar pada id_per yang sama di rekam_mcu
    $sql_check_duplicate = "SELECT * FROM rekam_mcu WHERE id_peserta = '$id_peserta' AND id_per = '$id_per'";
    $result_check = $koneksi->query($sql_check_duplicate);

    if ($result_check->num_rows > 0) {
        // Peserta sudah terdaftar, tampilkan pesan SweetAlert2
        echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Peserta sudah didaftarkan',
                    text: 'Peserta dengan ID ini sudah terdaftar pada perusahaan yang sama.'
                }).then(() => {
                    window.history.back(); // Kembali ke form sebelumnya
                });
            </script>";
        $koneksi->close();
        exit();
    }

    // Query untuk mendapatkan kode perusahaan dari tabel companies berdasarkan nik
    $sql_company_code = "SELECT kode FROM tb_per WHERE id_per = (SELECT id_per FROM data_peserta WHERE id_peserta = '$id_peserta')";
    $result_company_code = $koneksi->query($sql_company_code);

    // Memeriksa apakah query berhasil dieksekusi dan mengambil hasilnya
    if ($result_company_code && $result_company_code->num_rows > 0) {
        $row_company_code = $result_company_code->fetch_assoc();
        $company_code = $row_company_code['kode']; // Mendapatkan kode perusahaan
    } else {
        // Jika query tidak mengembalikan hasil atau ada masalah
        echo "Error: Kode perusahaan tidak ditemukan.";
        $koneksi->close();
        exit();
    }

    // Memeriksa apakah format nomor rekam medis berikutnya akan menggunakan 4 digit atau lebih
    $digit_count = 4; // Misalkan kita ingin format default dengan 4 digit, bisa diubah ke 5 jika ingin.

    if ($digit_count == 4) {
        // Query untuk mendapatkan nomor urutan terakhir (4 digit)
        $sql_last_sequence = "SELECT MAX(SUBSTRING(no_medrec, LENGTH('$company_code') + 1, 4)) AS last_sequence 
                          FROM rekam_mcu WHERE no_medrec LIKE '$company_code%____'"; // Cari yang hanya 4 digit setelah kode perusahaan
    } else {
        // Query untuk mendapatkan nomor urutan terakhir (lebih dari 4 digit)
        $sql_last_sequence = "SELECT MAX(SUBSTRING(no_medrec, LENGTH('$company_code') + 1)) AS last_sequence 
                          FROM rekam_mcu WHERE no_medrec LIKE '$company_code%' AND LENGTH(no_medrec) > LENGTH('$company_code') + 4";
    }

    $result_last_sequence = $koneksi->query($sql_last_sequence);

    // Memeriksa apakah query berhasil dieksekusi dan mengambil hasilnya
    if ($result_last_sequence && $result_last_sequence->num_rows > 0) {
        $row_last_sequence = $result_last_sequence->fetch_assoc();
        $last_sequence = $row_last_sequence['last_sequence']; // Mendapatkan nomor urutan terakhir

        // Menghitung nomor urutan berikutnya
        if ($last_sequence === null) {
            $next_sequence = 1;
        } else {
            $next_sequence = intval($last_sequence) + 1;
        }
    } else {
        // Jika query tidak mengembalikan hasil atau ada masalah
        $next_sequence = 1;
    }

    // Format nomor rekam medis dengan kode perusahaan dan urutan berikutnya
    $no_medrec = $company_code . str_pad($next_sequence, $digit_count, '0', STR_PAD_LEFT); // Misal: TAS0001 untuk 4 digit


    // Query untuk menyimpan nomor rekam medis ke dalam tabel rekam_mcu
    $sql_insert_rekam_mcu = "INSERT INTO rekam_mcu (no_medrec,id_per,tgl,id_peserta,foto) VALUES ('$no_medrec','$id_per','$date','$id_peserta','$filepath')";
    if ($koneksi->query($sql_insert_rekam_mcu) === TRUE) {
    } else {
        echo "Error: " . $sql_insert_rekam_mcu . "<br>" . $koneksi->error;
    }

    // Get selected examinations for the package
    $sql_package_examinations = "SELECT tipe_paket FROM tb_detail_paket WHERE id_paket = '$id_paket'";
    $result = $koneksi->query($sql_package_examinations);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tipe_paket = $row['tipe_paket'];

            // Insert into respective examination table based on examination_type
            switch ($tipe_paket) {
                case 'tb_umum':
                    $sql_pemeriksaan_fisik = "INSERT INTO tb_umum (no_medrec) VALUES ('$no_medrec')";
                    if ($koneksi->query($sql_pemeriksaan_fisik) !== TRUE) {
                        echo "Error: " . $sql_pemeriksaan_fisik . "<br>" . $koneksi->error;
                    }
                    break;
                case 'tb_ekg':
                    $sql_ekg = "INSERT INTO tb_ekg (no_medrec) VALUES ('$no_medrec')";
                    if ($koneksi->query($sql_ekg) !== TRUE) {
                        echo "Error: " . $sql_ekg . "<br>" . $koneksi->error;
                    }
                    break;
                case 'tb_lab':
                    $sql_laboratorium = "INSERT INTO tb_lab (no_medrec) VALUES ('$no_medrec')";
                    if ($koneksi->query($sql_laboratorium) !== TRUE) {
                        echo "Error: " . $sql_laboratorium . "<br>" . $koneksi->error;
                    }
                    break;
                case 'darah_lengkap':
                    $sql_laboratorium1 = "UPDATE tb_lab SET darah_lengkap='ya' WHERE no_medrec='$no_medrec'";
                    if ($koneksi->query($sql_laboratorium1) !== TRUE) {
                        echo "Error: " . $sql_laboratorium1 . "<br>" . $koneksi->error;
                    }
                    break;
                case 'urine_lengkap':
                    $sql_laboratorium2 = "UPDATE tb_lab SET urine_lengkap='ya' WHERE no_medrec='$no_medrec'";
                    if ($koneksi->query($sql_laboratorium2) !== TRUE) {
                        echo "Error: " . $sql_laboratorium2 . "<br>" . $koneksi->error;
                    }
                    break;
                case 'hbsag_crm':
                    $sql_hati1 = "UPDATE tb_lab SET hbsag_crm='ya' WHERE no_medrec='$no_medrec'";
                    if ($koneksi->query($sql_hati1) !== TRUE) {
                        echo "Error: " . $sql_hati1 . "<br>" . $koneksi->error;
                    }
                    break;
                case 'fungsi_hati':
                    $sql_hati2 = "UPDATE tb_lab SET fungsi_hati='ya' WHERE no_medrec='$no_medrec'";
                    if ($koneksi->query($sql_hati2) !== TRUE) {
                        echo "Error: " . $sql_hati2 . "<br>" . $koneksi->error;
                    }
                    break;
                case 'test_hcg':
                    $sql_hcg3 = "UPDATE tb_lab SET test_hcg='ya' WHERE no_medrec='$no_medrec'";
                    if ($koneksi->query($sql_hcg3) !== TRUE) {
                        echo "Error: " . $sql_hcg3 . "<br>" . $koneksi->error;
                    }
                    break;
                case 'test_narkoba':
                    $sql_hcg4 = "UPDATE tb_lab SET test_narkoba='ya' WHERE no_medrec='$no_medrec'";
                    if ($koneksi->query($sql_hcg4) !== TRUE) {
                        echo "Error: " . $sql_hcg4 . "<br>" . $koneksi->error;
                    }
                    break;
                case 'fungsi_ginjal':
                    $sql_hcg5 = "UPDATE tb_lab SET fungsi_ginjal='ya' WHERE no_medrec='$no_medrec'";
                    if ($koneksi->query($sql_hcg5) !== TRUE) {
                        echo "Error: " . $sql_hcg5 . "<br>" . $koneksi->error;
                    }
                    break;
                case 'kimia_darah':
                    $sql_hcg6 = "UPDATE tb_lab SET kimia_darah='ya' WHERE no_medrec='$no_medrec'";
                    if ($koneksi->query($sql_hcg6) !== TRUE) {
                        echo "Error: " . $sql_hcg6 . "<br>" . $koneksi->error;
                    }
                    break;
                case 'test_hiv':
                    $sql_hcg600 = "UPDATE tb_lab SET test_hiv='ya' WHERE no_medrec='$no_medrec'";
                    if ($koneksi->query($sql_hcg600) !== TRUE) {
                        echo "Error: " . $sql_hcg600 . "<br>" . $koneksi->error;
                    }
                    break;
                case 'tb_spirometri':
                    $sql_spirometri = "INSERT INTO tb_spirometri (no_medrec) VALUES ('$no_medrec')";
                    if ($koneksi->query($sql_spirometri) !== TRUE) {
                        echo "Error: " . $sql_spirometri . "<br>" . $koneksi->error;
                    }
                    break;
                case 'tb_audiometri':
                    $sql_audiometri = "INSERT INTO tb_audiometri (no_medrec) VALUES ('$no_medrec')";
                    if ($koneksi->query($sql_audiometri) !== TRUE) {
                        echo "Error: " . $sql_audiometri . "<br>" . $koneksi->error;
                    }
                    break;
                case 'tb_treadmil':
                    $sql_treadmil = "INSERT INTO tb_treadmil (no_medrec) VALUES ('$no_medrec')";
                    if ($koneksi->query($sql_treadmil) !== TRUE) {
                        echo "Error: " . $sql_treadmil . "<br>" . $koneksi->error;
                    }
                    break;
                case 'tb_radiologi':
                    $sql_radiologi = "INSERT INTO tb_radiologi (no_medrec) VALUES ('$no_medrec')";
                    if ($koneksi->query($sql_radiologi) !== TRUE) {
                        echo "Error: " . $sql_radiologi . "<br>" . $koneksi->error;
                    } else {
                        $add = mysqli_query($koneksi, "UPDATE tb_radiologi SET kesan_r = 'Normal Chest' WHERE no_medrec='$no_medrec'");
                    }
                    break;
                    // Add more cases if you have additional examination types
                default:
                    break;
            }
        }
        $slq = mysqli_query($koneksi, "SELECT * FROM data_peserta JOIN rekam_mcu ON data_peserta.id_peserta = rekam_mcu.id_peserta WHERE no_medrec = '$no_medrec'");
        $ron = mysqli_fetch_array($slq);
        // if ($ron['status'] == 'karyawan') {
        //     echo "
        //         <script>
        //         $(document).ready(function(){
        //             $('#successModal').modal('show');
        //         });
        //         </script>";
        // } 
        // else
        //  {
        echo "
            <script>
                alert('Data Berhasil Disimpan');
                document.location.href = '../proses/cetak.php?id_peserta={$id_peserta}';
            </script>";
        // }
    } else {
        echo "Tidak ada pemeriksaan yang dipilih untuk paket ini.";
    }

    $koneksi->close();
}
?>


<script>
    // Menampilkan pesan alert berhasil menggunakan SweetAlert2
    Swal.fire({
        icon: 'success',
        title: 'Peserta Berhasil didaftarkan',
        showConfirmButton: true
    }).then((result) => {
        // Menanyakan apakah ada pemeriksaan tambahan dengan SweetAlert2
        Swal.fire({
            title: 'Apakah ada pemeriksaan tambahan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user klik 'Ya', arahkan ke halaman tambahan
                window.location.href = "../proses/tambahan.php?no_medrec=<?php echo $no_medrec; ?>";
            } else {
                // Jika user klik 'Tidak', tanyakan apakah ingin cetak kartu
                Swal.fire({
                    title: 'Ingin Cetak Label?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika user klik 'Ya', arahkan ke halaman cetak kartu
                        window.location.href = "stiker.php?id_peserta=<?php echo $id_peserta; ?>";
                    } else {
                        // Jika user klik 'Tidak', arahkan ke halaman pendaftaran
                        window.location.href = "../view/daftar_peserta.php";
                    }
                });
            }
        });
    });
</script>