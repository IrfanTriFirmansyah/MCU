<?php

error_reporting(0);
ini_set('display_errors', 0);

include "../conn/koneksi.php";

$no_medrec = $_GET['no_medrec'];

$sql = mysqli_query($koneksi, "SELECT * FROM rekam_mcu 
JOIN data_peserta ON rekam_mcu.id_peserta = data_peserta.id_peserta 
WHERE no_medrec = '$no_medrec'");
$row = mysqli_fetch_array($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal on Load</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Button trigger modal (optional, not needed for auto-open) -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
      Launch Modal
    </button> -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= $row['nama'] ?></h5>
                    <!-- <a href="../view/pendaftaran.php"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a> -->
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheck1" name="spiro">
                            <label class="form-check-label" for="flexSwitchCheck1">Spirometri</label>
                        </div>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheck2" name="trigliserida_ya">
                            <label class="form-check-label" for="flexSwitchCheck2">Trigliserida</label>
                        </div>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheck3" name="hdl_ya">
                            <label class="form-check-label" for="flexSwitchCheck3">HDL</label>
                        </div>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheck4" name="ldl_ya">
                            <label class="form-check-label" for="flexSwitchCheck4">LDL</label>
                        </div>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheck5" name="gd2_ya">
                            <label class="form-check-label" for="flexSwitchCheck5">Gula Darah Puasa</label>
                        </div>
                        <button type="submit" name="sub" class="btn btn-primary mt-2 w-100">Tambahkan Pemeriksaan</button>
                    </form>
                </div>
                <h3>Tambahan :</h3>
                <?php
                $trig = mysqli_query($koneksi, "SELECT * FROM data_peserta WHERE id_peserta = '$row[id_peserta]' AND tambahan LIKE '%trig%' ");
                $tr = mysqli_fetch_array($trig);

                if ($tr > 0) {
                ?>
                    <label for="">- Trigliserida</label>
                <?php
                } ?>
                <?php
                $trig = mysqli_query($koneksi, "SELECT * FROM data_peserta WHERE id_peserta = '$row[id_peserta]' AND tambahan LIKE '%ldl%' ");
                $tr = mysqli_fetch_array($trig);

                if ($tr > 0) {
                ?>
                    <label for="">- LDL</label>
                <?php
                } ?>
                <?php
                $trig = mysqli_query($koneksi, "SELECT * FROM data_peserta WHERE id_peserta = '$row[id_peserta]' AND tambahan LIKE '%hdl%' ");
                $tr = mysqli_fetch_array($trig);

                if ($tr > 0) {
                ?>
                    <label for="">- HDL</label>
                <?php
                } ?>
                <?php
                $trig = mysqli_query($koneksi, "SELECT * FROM data_peserta WHERE id_peserta = '$row[id_peserta]' AND tambahan LIKE '%gdp%' ");
                $tr = mysqli_fetch_array($trig);

                if ($tr > 0) {
                ?>
                    <label for="">- Gula Darah 2 Jam PP</label>
                <?php
                } ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script to open the modal when the page loads
        window.addEventListener('load', function() {
            var myModal = new bootstrap.Modal(document.getElementById('myModal'));
            myModal.show();
        });
    </script>
</body>

</html>

<?php

if (isset($_POST['sub'])) {
    $spiro = $_POST['spiro'];
    $trigliserida_ya = $_POST['trigliserida_ya'];
    $ldl_ya = $_POST['ldl_ya'];
    $hdl_ya = $_POST['hdl_ya'];
    $gdp_ya = $_POST['gd2_ya'];

    if (!$spiro && !$ldl_ya && !$trigliserida_ya && !$hdl_ya && !$gdp_ya) {
?>
        <script>
            alert('Tidak Ada Pemeriksaan Tambahan');
            document.location.href = '../view/peserta.php ?>';
        </script>
    <?php
    } else {
        if ($spiro > 0) {
            $set = mysqli_query($koneksi, "INSERT INTO tb_spirometri (no_medrec) VALUES ('$no_medrec')");
        } else {
        }
        if ($trigliserida_ya > 0) {
            $set = mysqli_query($koneksi, "UPDATE tb_lab SET trigliserida_ya = 'ya' WHERE no_medrec = '$no_medrec'");
        } else {
        }
        if ($hdl_ya > 0) {
            $set = mysqli_query($koneksi, "UPDATE tb_lab SET hdl_ya = 'ya' WHERE no_medrec = '$no_medrec'");
        } else {
        }
        if ($ldl_ya > 0) {
            $set = mysqli_query($koneksi, "UPDATE tb_lab SET ldl_ya = 'ya' WHERE no_medrec = '$no_medrec'");
        } else {
        }
        if ($gdp_ya > 0) {
            $set = mysqli_query($koneksi, "UPDATE tb_lab SET gd2_ya = 'ya' WHERE no_medrec = '$no_medrec'");
        } else {
        }
        $id_peserta = $row['id_peserta'];
    ?>
        <script>
            alert('Pemeriksaan Berhasil Diperbarui');
            document.location.href = 'stiker.php?id_peserta=<?php echo $id_peserta; ?>';
        </script>
<?php
    }
}

?>