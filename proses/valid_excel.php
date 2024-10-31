<?php
require "../conn/koneksi.php";

$start_id = intval($_GET['start_id']);
$end_id = intval($_GET['end_id']);

// Ensure start_id is less than or equal to end_id
if ($start_id > $end_id) {
    echo json_encode(['count' => 0]);
    exit;
}

$query = "
SELECT COUNT(*) as count FROM rekam_mcu WHERE CAST(SUBSTRING(id, 4) AS UNSIGNED) BETWEEN ? AND ?
";
$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($result);
$count = $row['count'];

echo json_encode(['count' => $count]);
