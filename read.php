<?php

require_once 'db.php';

$result = mysqli_query($koneksi, "SELECT id, nama, nim, created_at FROM mahasiswa ORDER BY id DESC");

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode(['success' => true, "data" => $data]);

mysqli_free_result($result);

mysqli_close($koneksi);
?>