<?php
require_once 'db.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['nama']) || !isset($input['nim'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Parameter tidak lengkap"]);
    exit;
}

$nama = trim($input['nama']);
$nim = trim($input['nim']);

if ($nama === "" || $nim === "") {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Nama & NIM wajib diisi"]);
    exit;
}

$stmt = mysqli_prepare($koneksi, "INSERT INTO mahasiswa (nama, nim) VALUES (?, ?)");

mysqli_stmt_bind_param($stmt, "ss", $nama, $nim);

$ok = mysqli_stmt_execute($stmt);

if ($ok) {
    http_response_code(201);
    echo json_encode([
        "success" => true, 
        "message" => "Data disimpan", 
        "id" => mysqli_insert_id($koneksi)
    ]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Gagal menyimpan"]);
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>