<?php
session_start();
include 'database.php';
if (!isset($_SESSION['user_id'])) header("Location: login.php");
$stmt = $conn->prepare("SELECT * FROM barang WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$tarif = $conn->query("SELECT per_kwh FROM tarif WHERE id=1")->fetch_assoc()['per_kwh'];
$barang_data = [];
$total_kwh = 0;
while ($row = $result->fetch_assoc()) {
    $barang_data[] = $row;
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="dashboard-body">
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>🔋 Halo, <?= htmlspecialchars($_SESSION['username']) ?></h2>
            <div class="dashboard-nav">
                <a href="add_item.php">+ Tambah Barang</a>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
        <h3>📋 Daftar Barang</h3>
        <table>
            <tr>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Watt</th>
                <th>Jam/Hari</th>
                <th>kWh/Bulan</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($barang_data as $r):
                $kwh = ($r['jumlah'] * $r['watt'] * 4 * 30) / 1000;
                $total_kwh += $kwh; ?>
                <tr>
                    <td><?= $r['nama_barang'] ?></td>
                    <td><?= $r['jumlah'] ?></td>
                    <td><?= $r['watt'] ?></td>
                    <td>4</td>
                    <td><?= number_format($kwh, 2) ?></td>
                    <td><a href="edit_item.php?id=<?= $r['id'] ?>">✏️</a> <a href="delete_item.php?id=<?= $r['id'] ?>" onclick="return confirm('Hapus?')">🗑️</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <h3>💡 Estimasi Biaya</h3>
        <p><?= number_format($total_kwh, 2) ?> kWh × Rp<?= number_format($tarif) ?> = Rp<strong><?= number_format($total_kwh * $tarif, 0, ',', '.') ?></strong></p>
        <canvas id="grafikKwh"></canvas>
        <script>
            const ctx = document.getElementById('grafikKwh').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [<?= implode(',', array_map(fn($r) => "'{$r['nama_barang']}'", $barang_data)) ?>],
                    datasets: [{
                        label: 'Total kWh / Bulan',
                        data: [<?= implode(',', array_map(fn($r) => ($r['jumlah'] * $r['watt'] * 4 * 30) / 1000, $barang_data)) ?>],
                        backgroundColor: '#00d4ff'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#fff'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#fff'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        </script>
    </div>
</body>

</html>