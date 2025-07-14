<?php
session_start(); include 'database.php';
$id = $_GET['id'] ?? null;
if (!$id || !isset($_SESSION['user_id'])) header("Location: index.php");
$stmt = $conn->prepare("SELECT * FROM barang WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $id, $_SESSION['user_id']); $stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE barang SET nama_barang=?, jumlah=?, watt=? WHERE id=? AND user_id=?");
    $stmt->bind_param("siiii", $_POST['nama_barang'], $_POST['jumlah'], $_POST['watt'], $id, $_SESSION['user_id']);
    $stmt->execute(); header("Location: index.php"); exit;
}
?>
<!DOCTYPE html>
<html><head><link rel="stylesheet" href="style.css"></head>
<body class="login-body">
<div class="login-container">
<h2>✏️ Edit Barang</h2>
<form method="POST">
<label>Nama</label><input name="nama_barang" value="<?= $data['nama_barang'] ?>">
<label>Jumlah</label><input type="number" name="jumlah" value="<?= $data['jumlah'] ?>">
<label>Watt</label><input type="number" name="watt" value="<?= $data['watt'] ?>">
<button>Simpan</button> <a href="index.php">← Batal</a>
</form></div></body></html>