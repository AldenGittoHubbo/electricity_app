<?php
$host = 'db';       // Ganti dari 'localhost' ke 'db'
$user = 'root';
$pass = 'root';     // Sesuai isi docker-compose.yml
$db   = 'listrik';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}
?>
