<?php


$koneksi = mysqli_connect("localhost","root","","mcu-v.03.2");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

?>


