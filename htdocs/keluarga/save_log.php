<?php
header('Content-Type: application/json');

/* --- KONFIGURASI DATABASE --- */
$host = "localhost";
$user = "root";      // Username default XAMPP
$pass = "";          // Password default XAMPP (kosong)
$db   = "rejo_museum";

// Koneksi ke Database
$conn = new mysqli($host, $user, $pass, $db);

// Cek Koneksi
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Koneksi Database Gagal"]);
    exit;
}

/* --- PROSES DATA DARI FRONTEND --- */
$name   = isset($_POST['name']) ? $_POST['name'] : '';
$pwd    = isset($_POST['password']) ? $_POST['password'] : '';
$device = isset($_POST['device']) ? $_POST['device'] : '';

// 1. Cek Sandi di Tabel Users
$sql  = "SELECT role FROM users WHERE password_code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $pwd);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $role = $user['role'];

    // 2. Simpan Riwayat Login ke Tabel login_log
    $log_sql = "INSERT INTO login_log (name, role, device) VALUES (?, ?, ?)";
    $log_stmt = $conn->prepare($log_sql);
    $log_stmt->bind_param("sss", $name, $role, $device);
    $log_stmt->execute();

    // Berikan respons sukses
    echo json_encode([
        "status" => "success", 
        "role" => $role, 
        "name" => $name
    ]);
} else {
    // Berikan respons gagal
    echo json_encode(["status" => "error", "message" => "Sandi Tidak Terdaftar"]);
}

$conn->close();
?>