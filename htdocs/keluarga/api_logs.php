<?php
header('Content-Type: application/json');

// --- KONFIGURASI DATABASE ---
$host = "localhost";
$user = "root";      // Sesuaikan dengan username DB Anda
$pass = "";          // Sesuaikan dengan password DB Anda
$db   = "rejo_museum";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Koneksi Gagal"]);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

// --- LOGIKA AMBIL DATA ---
if ($action == 'get') {
    // Sesuaikan nama tabel dengan tabel log Anda (misal: login_log)
    $sql = "SELECT name, role, time, device FROM login_log ORDER BY time DESC";
    $result = $conn->query($sql);
    
    $logs = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $logs[] = $row;
        }
    }
    echo json_encode($logs);

// --- LOGIKA HAPUS DATA ---
} else if ($action == 'clear') {
    $sql = "DELETE FROM login_log";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
}

$conn->close();
?>