<!DOCTYPE html>
<html lang="en">
<head>
  
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
</head>
<body>
  
</body>
</html>
<?php

session_start();

include '../conn/koneksi.php';

$nama = $_POST['username'];
$pas = $_POST['password'];

$login = mysqli_query($koneksi, "select * from user where username='$nama' and password='$pas'");

$cek = mysqli_num_rows($login);

if ($cek > 0) {
    $data = mysqli_fetch_array($login);
    $_SESSION['nama'] = $data['username'];
    $_SESSION['akses'] = $data['akses'];
    // $_SESSION['akses'] = $data['akses'];
    $_SESSION['status'] = "login" ;
    echo "
    // <script>
    // alert('Selamat Datang');
    document.location.href = '../view/'
    </script>";
    
    
}
else{
    echo "
    <script>
		alert('Masukkan Data Dengan Benar!!..');
		history.go(-1);
		</script>
    ";
    
}
