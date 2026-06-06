<?php
session_start();
// PERBAIKAN: Karena file ini di dalam folder api, panggil koneksi langsung
require_once __DIR__ . '/koneksi.php'; 

// Ambil data dari tabel pemesanan_tiket
$query = mysqli_query($koneksi, "SELECT * FROM pemesanan_tiket ORDER BY id_pemesanan DESC");

if (!$query) {
    die("Query Gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan - BromoTrack</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: auto; }
        h2 { color: #2c3e50; text-align: center; margin-bottom: 30px; border-bottom: 3px solid #E8621A; display: inline-block; padding-bottom: 5px; }
        .card-riwayat {
            background: white; border-radius: 12px; padding: 20px; margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-left: 8px solid #E8621A;
            display: flex; justify-content: space-between; align-items: center;
        }
        .info-pembeli h3 { margin: 0; color: #E8621A; font-size: 1.2em; }
        .info-pembeli p { margin: 5px 0; color: #666; font-size: 0.9em; }
        .status-badge { background: #e8f5e9; color: #2e7d32; padding: 5px 12px; border-radius: 20px; font-size: 0.8em; font-weight: bold; text-transform: uppercase; }
        .total-harga { text-align: right; }
        .total-harga strong { font-size: 1.2em; color: #2c3e50; }
        .btn-kembali { display: block; width: fit-content; margin: 20px auto; padding: 10px 20px; background: #2c3e50; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>

<div class="container">
    <div style="text-align: center;">
        <h2>Riwayat Pemesanan Tiket</h2>
    </div>

    <?php if (mysqli_num_rows($query) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($query)): ?>
            <div class="card-riwayat">
                <div class="info-pembeli">
                    <p style="margin-bottom: 2px;"><small>ID: #BRM-<?= $row['id_pemesanan'] ?></small></p>
                    <h3><?= htmlspecialchars($row['nama_pembeli'] ?? '') ?></h3>
                    <p><strong>Destinasi:</strong> <?= htmlspecialchars($row['destinasi'] ?? '') ?></p>
                    <p><strong>Pax:</strong> <?= $row['jumlah_orang'] ?> Orang</p>
                    <span class="status-badge">Lunas / Terkonfirmasi</span>
                </div>
                
                <div class="total-harga">
                    <span>Total Pembayaran</span>
                    <strong>Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></strong>
                    <p style="font-size: 0.7em; color: #bbb; margin-top: 5px;"><?= date('d M Y, H:i', strtotime($row['tanggal_pesan'])) ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div style="text-align: center; padding: 50px; color: #999;">
            <p>Belum ada riwayat pemesanan.</p>
        </div>
    <?php endif; ?>

    <a href="landingpage.php" class="btn-kembali">Kembali ke Beranda</a>
</div>
</body>
</html>