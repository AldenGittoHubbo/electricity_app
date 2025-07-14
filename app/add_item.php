<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $watt = $_POST['watt'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO barang (nama_barang, jumlah, watt, user_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siii", $nama, $jumlah, $watt, $user_id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Tambah Barang Elektronik</h1>
    <form method="POST">
        <label>Nama Barang:</label><br>
        <input type="text" name="nama_barang" required><br>
        <label>Jumlah:</label><br>
        <input type="number" name="jumlah" required><br>
        <label>Daya (Watt):</label><br>
        <input type="number" name="watt" required><br><br>
        <button type="submit">Simpan</button>
    </form>
    <a href="index.php">← Kembali</a>
</body>
</html>