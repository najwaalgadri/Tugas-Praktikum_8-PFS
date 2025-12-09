<?php
require_once 'db.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['id']) || !isset($input['nama']) || !isset($input['nim'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Parameter tidak lengkap"]);
    exit;
}

$id = intval($input['id']);
$nama = trim($input['nama']);
$nim = trim($input['nim']);

if ($id <= 0 || $nama === "" || $nim === "") {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Data tidak valid"]);
    exit;
}

$stmt = mysqli_prepare($koneksi, "UPDATE mahasiswa SET nama = ?, nim = ? WHERE id = ?");

mysqli_stmt_bind_param($stmt, "ssi", $nama, $nim, $id);

$ok = mysqli_stmt_execute($stmt);

if ($ok) {
    echo json_encode(["success" => true, "message" => "Data diperbarui"]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Gagal memperbarui"]);
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>