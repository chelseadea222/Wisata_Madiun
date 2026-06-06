<?php
session_start();
require_once 'koneksi.php';

// --- 1. AMBIL DATA GRAFIK ---
require_once 'api_dashboard_admin.php';   
require_once 'proses_dashboard_admin.php'; 

if (!isset($bps_labels) || empty($bps_labels)) {
    $bpsData = getBpsData();
    $bps_labels = $bpsData['labels'];
    $bps_values = $bpsData['values'];
}

// Proteksi halaman
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header('Location: login.php');
    exit;
}

// 2. Ambil statistik ringkas
$total_tiket = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pemesanan_tiket"))['total'];
$total_ulasan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM ulasan_wisata"))['total'];
$total_keluhan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM keluhan"))['total'];

// 3. Ambil 10 data terbaru
$result_tiket = mysqli_query($koneksi, "SELECT * FROM pemesanan_tiket ORDER BY tanggal_pesan DESC LIMIT 10");
$result_keluhan = mysqli_query($koneksi, "SELECT * FROM keluhan ORDER BY tanggal_kirim DESC LIMIT 10");
$result_ulasan = mysqli_query($koneksi, "SELECT * FROM ulasan_wisata ORDER BY tanggal_ulasan DESC LIMIT 10");
?>

<!DOCTYPE html>
<html lang="id" class="h-full bg-[#fbfcfd]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BromoTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* CSS KHUSUS CETAK PER BAGIAN */
        @media print {
            nav, .no-print, .stats-row, .charts-row { display: none !important; }
            .print-section { display: none !important; } 
            
            /* Tampilkan hanya bagian yang dipilih */
            body.print-transaksi .section-transaksi { display: block !important; width: 100% !important; margin: 0 !important; }
            body.print-ulasan .section-ulasan { display: block !important; width: 100% !important; margin: 0 !important; }
            body.print-keluhan .section-keluhan { display: block !important; width: 100% !important; margin: 0 !important; }
            
            .bg-white { border: 1px solid #eee !important; box-shadow: none !important; }
        }
    </style>
</head>
<body class="text-[#334155] antialiased">

    <nav class="no-print sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-16 flex justify-between items-center">
            <a href="#" class="text-xl font-bold tracking-tight text-slate-900">
                Bromo<span class="text-orange-600">Track</span>
            </a>
            <a href="logout.php" onclick="return confirm('Yakin ingin keluar?')" 
               class="bg-red-50 text-red-600 px-4 py-2 rounded-xl font-bold text-xs hover:bg-red-100 transition-all flex items-center gap-2">
                <i class="bi bi-box-arrow-right"></i> LOGOUT
            </a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 space-y-8">
        
        <div class="no-print">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Ringkasan Aktivitas</h1>
            <p class="text-slate-500 text-sm">Pantau data operasional dan backup laporan secara berkala.</p>
        </div>

        <div class="stats-row grid grid-cols-1 md:grid-cols-3 gap-6 no-print">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-between h-32">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Tiket</p>
                    <h3 class="text-3xl font-extrabold text-slate-900"><?= number_format($total_tiket) ?></h3>
                </div>
                <div class="absolute -right-2 -bottom-2 bg-orange-50 text-orange-200 w-20 h-20 rounded-full flex items-center justify-center opacity-60">
                    <i class="bi bi-ticket-perforated text-4xl"></i>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-between h-32">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Ulasan Masuk</p>
                    <h3 class="text-3xl font-extrabold text-slate-900"><?= number_format($total_ulasan) ?></h3>
                </div>
                <div class="absolute -right-2 -bottom-2 bg-blue-50 text-blue-200 w-20 h-20 rounded-full flex items-center justify-center opacity-60">
                    <i class="bi bi-chat-heart text-4xl"></i>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-between h-32">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Laporan Keluhan</p>
                    <h3 class="text-3xl font-extrabold text-slate-900"><?= number_format($total_keluhan) ?></h3>
                </div>
                <div class="absolute -right-2 -bottom-2 bg-red-50 text-red-200 w-20 h-20 rounded-full flex items-center justify-center opacity-60">
                    <i class="bi bi-exclamation-triangle text-4xl"></i>
                </div>
            </div>
        </div>

        <div class="charts-row grid grid-cols-1 md:grid-cols-2 gap-6 no-print">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 italic text-center">Tren Penjualan</h4>
                <div class="h-44"><canvas id="chartLokal"></canvas></div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 italic text-center">Data Wisatawan</h4>
                <div class="h-44"><canvas id="chartBPS"></canvas></div>
            </div>
        </div>

        <div class="print-section section-transaksi bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/20">
                <div class="flex items-center gap-3">
                    <i class="bi bi-lightning-charge-fill text-orange-500 text-xl"></i>
                    <h5 class="font-bold text-slate-800 uppercase tracking-tight text-sm">10 Transaksi Terbaru</h5>
                </div>
                <button onclick="printOnly('print-transaksi')" class="no-print bg-[#0f172a] text-white px-4 py-2 rounded-xl text-[10px] font-bold hover:bg-slate-700 transition-all">
                    <i class="bi bi-printer me-1"></i> CETAK DATA TIKET
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-400 text-[10px] uppercase font-bold tracking-widest border-b border-slate-50">
                        <tr><th class="px-8 py-4">Pembeli</th><th class="px-8 py-4 text-center">Status</th><th class="px-8 py-4 text-center">Aksi</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 italic">
                        <?php while($row = mysqli_fetch_assoc($result_tiket)): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5 text-sm font-bold text-slate-900"><?= $row['nama_pembeli'] ?></td>
                            <td class="px-8 py-5 text-center text-[10px] font-black text-slate-500 uppercase"><?= $row['status'] ?></td>
                            <td class="px-8 py-5 text-center">
                                <?php if($row['status'] == 'Lunas'): ?> <i class="bi bi-patch-check-fill text-blue-500"></i> 
                                <?php else: ?> <span class="text-slate-300 text-[10px]">Diproses</span> <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="print-section section-ulasan bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/20">
                <div class="flex items-center gap-3">
                    <i class="bi bi-star-fill text-yellow-400 text-xl"></i>
                    <h5 class="font-bold text-slate-800 uppercase tracking-tight text-sm">10 Ulasan Terbaru</h5>
                </div>
                <button onclick="printOnly('print-ulasan')" class="no-print bg-[#0f172a] text-white px-4 py-2 rounded-xl text-[10px] font-bold hover:bg-slate-700 transition-all">
                    <i class="bi bi-printer me-1"></i> CETAK DATA ULASAN
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-400 text-[10px] uppercase font-bold tracking-widest border-b border-slate-50">
                        <tr><th class="px-8 py-4">Pengunjung</th><th class="px-8 py-4 text-center">Rating</th><th class="px-8 py-4">Komentar</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 italic">
                        <?php while($row = mysqli_fetch_assoc($result_ulasan)): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5 text-sm font-bold text-slate-900"><?= $row['nama_user'] ?></td>
                            <td class="px-8 py-5 text-center"><div class="flex justify-center text-yellow-400 text-[10px] gap-0.5"><?= str_repeat('<i class="bi bi-star-fill"></i>', $row['rating']) ?></div></td>
                            <td class="px-8 py-5 text-sm text-slate-500 italic">"<?= $row['ulasan'] ?>"</td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="print-section section-keluhan bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/20">
                <div class="flex items-center gap-3">
                    <i class="bi bi-exclamation-circle-fill text-red-600 text-xl"></i>
                    <h5 class="font-bold text-red-600 uppercase tracking-tight text-sm">10 Laporan Keluhan</h5>
                </div>
                <button onclick="printOnly('print-keluhan')" class="no-print bg-[#0f172a] text-white px-4 py-2 rounded-xl text-[10px] font-bold hover:bg-slate-700 transition-all">
                    <i class="bi bi-printer me-1"></i> CETAK DATA KELUHAN
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-400 text-[10px] uppercase font-bold tracking-widest border-b border-slate-50">
                        <tr><th class="px-8 py-4">Pelapor</th><th class="px-8 py-4 text-center">Kategori</th><th class="px-8 py-4">Pesan</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 italic">
                        <?php while($row = mysqli_fetch_assoc($result_keluhan)): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5 text-sm font-bold text-slate-900"><?= $row['nama_pelapor'] ?></td>
                            <td class="px-8 py-5 text-center"><span class="bg-red-50 text-red-600 px-3 py-1 rounded-md text-[9px] font-black uppercase tracking-wider"><?= $row['kategori'] ?></span></td>
                            <td class="px-8 py-5 text-slate-600 text-xs leading-snug"><?= $row['pesan_keluhan'] ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        // LOGIKA CETAK PER BAGIAN
        function printOnly(className) {
            document.body.classList.add(className);
            window.print();
            setTimeout(() => { document.body.classList.remove(className); }, 1000);
        }

        // KONFIGURASI GRAFIK
        const chartConfig = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, border: { display: false }, ticks: { font: { size: 10 } } },
                y: { grid: { color: '#f1f5f9', borderDash: [5, 5] }, border: { display: false }, ticks: { font: { size: 10 } } }
            }
        };

        new Chart(document.getElementById('chartLokal'), {
            type: 'line',
            data: {
                labels: <?= json_encode(array_keys($monthlyStats)) ?>,
                datasets: [{
                    data: <?= json_encode(array_values($monthlyStats)) ?>,
                    borderColor: '#ea580c',
                    backgroundColor: 'rgba(234, 88, 12, 0.05)',
                    fill: true, tension: 0.4, pointRadius: 4, pointBackgroundColor: '#fff', borderWidth: 2.5
                }]
            },
            options: chartConfig
        });

        new Chart(document.getElementById('chartBPS'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($bps_labels) ?>,
                datasets: [{
                    data: <?= json_encode($bps_values) ?>,
                    backgroundColor: '#3b82f6',
                    borderRadius: 5, barThickness: 15
                }]
            },
            options: chartConfig
        });
    </script>
</body>
</html>