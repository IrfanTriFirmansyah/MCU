<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../index.html?pesan=belum_login");
}
include '../main/header.php';

?>

<main class="content">
    <div class="container-fluid p-0" style="display: flex; align-items: center; justify-content: space-between;">
        <h1 style="font-size: 40px; font-weight: bold;">Upload Peserta MCU</h1>
        <div>
            <a href="../main/Template.xlsx" download class="btn btn-success"><i data-feather="download"></i> Download Template</a>
            <a href="pendaftaran_baru.php" class="btn btn-danger"><i data-feather="arrow-left"></i> Kembali</a>
        </div>
    </div><br>

    <?php
    include "../proses/upload_exc.php";
    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="w-100 p-4 border border-primary border-start-0 border-end-0 border-bottom-0 border-4 rounded-3" style="background-color: white; margin-left: 1px; display: flex; justify-content: center; align-items: center; flex-direction: column;">
            <h3><b>Upload File</b></h3>
            <input type="file" class="form-control" name="filexls" required>
            <button type="submit" name="submit" class="btn btn-primary mt-3 w-25"><i data-feather="upload"></i> Upload Data</button>
        </div>
    </form>
</main>


<?php

include '../main/footer.php';
?>