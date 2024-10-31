<?php
if (isset($_GET['start_id']) && isset($_GET['end_id'])) {
    $start_id = $_GET['start_id'];
    $end_id = $_GET['end_id'];

    // Konversi ID ke angka untuk perbandingan
    $start_num = (int) filter_var($start_id, FILTER_SANITIZE_NUMBER_INT);
    $end_num = (int) filter_var($end_id, FILTER_SANITIZE_NUMBER_INT);

    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mcu-v02"; // Ganti dengan nama database Anda

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Menyiapkan query
    $sql = "SELECT COUNT(*) as count FROM rekam_mcu WHERE CAST(SUBSTRING(id, 4) AS UNSIGNED) BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $start_num, $end_num);

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    echo json_encode(['count' => $row['count']]);
}
?>
