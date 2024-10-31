<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<main class="content">
    <div class="container-fluid p-0" style="display: flex; align-items: center; justify-content: space-between;">
        <h1 style="font-size: 40px; font-weight: bold;">Download PDF</h1>
        <a href="download_data.php" class="btn btn-danger"><i data-feather="arrow-left"></i> Kembali</a>
    </div><br>

    <div class="row w-100 p-3 border border-primary border-start-0 border-end-0 border-bottom-0 border-4 rounded-3" style="background-color: white; margin-left: 1px;">
        <form id="searchForm" method="get" action="../proses/rek_pdf.php" style="display: flex; flex-direction: column;">
            <label for="start_id">Pilih Perusahaan :</label>
            <select name="company" id="company" class="form-select mt-3 mb-3">
                <?php

                // Query untuk mendapatkan daftar perusahaan
                $result = $koneksi->query("SELECT * FROM tb_per");

                // Loop untuk membuat pilihan dropdown
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['kode'] . "'>" . $row['nama_per'] . "</option>";
                }

                ?>
            </select>
            <label for="start_id">Nomor Rekam Medis Awal :</label>
            <input type="text" id="start_id" class="form-control mt-3 mb-3" name="start_num" required>
            <label for="end_id">Nomor Rekam Medis Akhir :</label>
            <input type="text" id="end_id" class="form-control mt-3 mb-3" name="end_num" required>
            <button type="button" class="btn btn-primary" onclick="searchData()"><i data-feather="printer"></i> Proses Print</button>
        </form>

    </div>
</main>


<?php
include '../main/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    function searchData() {
        var startId = document.getElementById('start_id').value;
        var endId = document.getElementById('end_id').value;

        // Validasi input
        if (!startId || !endId) {
            Swal.fire({
                title: 'Error',
                text: 'Mohon isi kedua ID.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Buat request ke server untuk memeriksa jumlah hasil
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../proses/valid_pdf.php?start_id=' + startId + '&end_id=' + endId, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.count > 10) {
                    Swal.fire({
                        title: "Kesalahan",
                        text: "Maksimal 10 Peserta",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                } else {
                    // Jika jumlah hasil <= 10, kirim form
                    document.getElementById('searchForm').submit();
                }
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memeriksa data.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        };
        xhr.send();
    }
</script>