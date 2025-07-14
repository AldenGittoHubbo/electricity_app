<?php
session_start(); include 'database.php';
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) header("Location: index.php");
$stmt = $conn->prepare("DELETE FROM barang WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $_GET['id'], $_SESSION['user_id']); $stmt->execute();
header("Location: index.php");
?>