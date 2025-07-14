<?php
session_start();
include 'database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        $error = 'Password tidak cocok.';
    } elseif (strlen($username) < 3 || strlen($password) < 5) {
        $error = 'Username minimal 3 karakter dan password minimal 5 karakter.';
    } else {
        $stmt = $conn->prepare("SELECT id FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $check = $stmt->get_result();

        if ($check->num_rows > 0) {
            $error = "Username sudah digunakan.";
        } else {
            $stmt = $conn->prepare("INSERT INTO user (username, password) VALUES (?, SHA2(?, 256))");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();

            // Redirect ke login setelah sukses
            header("Location: login.php?signup=success");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sign Up | Kalkulator Listrik</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
    <div class="login-container">
        <h2>📝 Daftar Akun Baru</h2>
        <p class="subtitle">Buat akun untuk menyimpan data listrikmu</p>
        <form method="POST">
            <label>👤 Username</label>
            <input type="text" name="username" required>

            <label>🔒 Password</label>
            <input type="password" name="password" required>

            <label>🔁 Konfirmasi Password</label>
            <input type="password" name="confirm" required>

            <button type="submit">Daftar</button>
            <p style="margin-top:10px">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </p>
        </form>
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
    </div>
</body>
</html>