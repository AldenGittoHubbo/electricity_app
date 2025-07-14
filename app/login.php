<?php
session_start();
include 'database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? AND password = SHA2(?, 256)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login | Kalkulator Listrik</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="login-body">
    <div class="login-wrapper">
        <h1 class="app-title">🔌 Kalkulator Biaya Listrik Bulanan</h1>
        <div class="login-container">
            <h2>Login Pengguna</h2>
            <p class="subtitle">Masuk untuk melihat dan menghitung konsumsi listrik rumahmu</p>
            <?php if (isset($_GET['signup']) && $_GET['signup'] == 'success'): ?>
                <p style="color: #00ff88;">Registrasi berhasil! Silakan login.</p>
            <?php endif; ?>
            <form method="POST">
                <label>👤 Username</label>
                <input type="text" name="username" required>
                <label>🔒 Password</label>
                <input type="password" name="password" required>
                <button type="submit">Masuk</button>
                <?php if ($error): ?>
                    <p class="error"><?= $error ?></p>
                <?php endif; ?>
            </form>
            <p class="credit">© <?= date('Y') ?> ListrikApp</p>
            <p style="margin-top:10px">
                Belum punya akun? <a href="signup.php">Daftar di sini</a>
            </p>
        </div>
</body>

</html>