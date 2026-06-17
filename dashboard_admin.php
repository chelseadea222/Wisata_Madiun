<?php
session_start();
require_once 'koneksi.php';

// --- 1. PROSES UPDATE STATUS (JIKA ADMIN KLIK SIMPAN) ---
if (isset($_POST['update_status'])) {
    $id = intval($_POST['id_item']);
    $tipe = $_POST['tipe_item'];
    $status_baru = mysqli_real_escape_string($koneksi, $_POST['status_baru']);

    if ($tipe === 'tiket') {
        mysqli_query($koneksi, "UPDATE pemesanan_tiket SET status = '$status_baru' WHERE id = $id");
    } elseif ($tipe === 'booking') {
        mysqli_query($koneksi, "UPDATE booking_penginapan SET status = '$status_baru' WHERE id = $id");
    }

    header("Location: dashboard_admin.php?update=success");
    exit;
}

// --- 2. AMBIL DATA GRAFIK ---
@require_once 'dashboard_admin.php';   
@require_once 'proses_dashboard_admin.php'; 

if (!isset($bps_labels) || empty($bps_labels)) {
    if (function_exists('getBpsData')) {
        $bpsData = getBpsData();
        $bps_labels = $bpsData['labels'];
        $bps_values = $bpsData['values'];
    } else {
        $bps_labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'];
        $bps_values = [10, 25, 40, 30, 50];
    }
}

if (!isset($monthlyStats)) {
    $monthlyStats = ['Jan' => 5, 'Feb' => 15, 'Mar' => 10, 'Apr' => 30, 'Mei' => 25];
}

// Proteksi halaman (Hanya Admin)
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header('Location: login.php');
    exit;
}

// --- 3. AMBIL STATISTIK RINGKAS ---
$total_tiket = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pemesanan_tiket"))['total'];
$cek_booking = mysqli_query($koneksi, "SHOW TABLES LIKE 'booking_penginapan'");
$total_booking = ($cek_booking && mysqli_num_rows($cek_booking) > 0) ? mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM booking_penginapan"))['total'] : 0;

// --- 4. AMBIL 10 DATA TERBARU ---
$result_tiket = mysqli_query($koneksi, "SELECT * FROM pemesanan_tiket ORDER BY tanggal_pesan DESC LIMIT 10");
$result_booking = ($cek_booking && mysqli_num_rows($cek_booking) > 0) ? mysqli_query($koneksi, "SELECT * FROM booking_penginapan ORDER BY tanggal_pesan DESC LIMIT 10") : null;
?>

<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MadiunTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { jakarta: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { brand: '#f59e0b', brandDark: '#0f172a' }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        @media print {
            nav, .no-print, .stats-row, .charts-row, #modalStatus { display: none !important; }
            .print-section { display: none !important; } 
            body.print-tiket .section-tiket { display: block !important; width: 100% !important; margin: 0 !important; }
            body.print-booking .section-booking { display: block !important; width: 100% !important; margin: 0 !important; }
            .bg-white { border: 1px solid #eee !important; box-shadow: none !important; }
            th:last-child, td:last-child { display: none !important; } /* Sembunyikan kolom Aksi saat print */
        }
    </style>
</head>
<body class="text-slate-700 antialiased selection:bg-brand selection:text-white">

    <?php if (isset($_GET['update']) && $_GET['update'] == 'success'): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Status pesanan berhasil diperbarui.',
                confirmButtonColor: '#f59e0b',
                timer: 2500
            });
            window.history.replaceState(null, null, window.location.pathname);
        });
    </script>
    <?php endif; ?>

    <nav class="no-print sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200/60 shadow-sm">
        <div class="max-w-[1400px] mx-auto px-6 h-16 flex justify-between items-center">
            <a href="#" class="text-xl font-black tracking-tight text-brandDark flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-brand flex items-center justify-center text-white text-sm"><i class="bi bi-geo-alt-fill"></i></div>
                Madiun<span class="text-brand">Track</span>
            </a>
            <div class="flex items-center gap-4">
                <span class="hidden md:inline text-xs font-bold bg-slate-100 text-slate-500 px-3 py-1.5 rounded-lg uppercase tracking-wider">Mode Admin</span>
                <a href="logout.php" onclick="return confirm('Yakin ingin keluar?')" 
                   class="bg-red-50 text-red-600 px-4 py-2 rounded-xl font-bold text-xs hover:bg-red-600 hover:text-white transition-all flex items-center gap-2">
                    <i class="bi bi-box-arrow-right"></i> LOGOUT
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-[1400px] mx-auto p-4 sm:p-6 lg:p-8 space-y-8">
        
        <div class="no-print">
            <h1 class="text-3xl font-extrabold text-brandDark tracking-tight">Dashboard Admin</h1>
            <p class="text-slate-500 text-sm mt-1">Pantau data operasional, perbarui status, dan ekspor data pengunjung.</p>
        </div>

        <div class="stats-row grid grid-cols-1 md:grid-cols-2 gap-6 no-print">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-between h-36 hover:shadow-md transition">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tiket Wisata Terjual</p>
                    <h3 class="text-4xl font-black text-brandDark"><?= number_format($total_tiket) ?></h3>
                </div>
                <div class="absolute -right-4 -bottom-4 bg-orange-50 text-orange-200 w-24 h-24 rounded-full flex items-center justify-center">
                    <i class="bi bi-ticket-perforated text-5xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-between h-36 hover:shadow-md transition">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Reservasi Penginapan</p>
                    <h3 class="text-4xl font-black text-brandDark"><?= number_format($total_booking) ?></h3>
                </div>
                <div class="absolute -right-4 -bottom-4 bg-blue-50 text-blue-200 w-24 h-24 rounded-full flex items-center justify-center">
                    <i class="bi bi-house-door text-5xl"></i>
                </div>
            </div>
        </div>

        <div class="charts-row grid grid-cols-1 md:grid-cols-2 gap-6 no-print">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm">
                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6 text-center">Tren Transaksi Bulanan</h4>
                <div class="h-56"><canvas id="chartLokal"></canvas></div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm">
                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6 text-center">Data Pengunjung Berdasarkan BPS</h4>
                <div class="h-56"><canvas id="chartBPS"></canvas></div>
            </div>
        </div>

        <div class="print-section section-tiket bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden mt-8">
            <div class="px-8 py-6 border-b border-slate-100 flex flex-col sm:flex-row gap-4 justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <div class="w-8 h-8 rounded-full bg-orange-100 text-brand flex items-center justify-center"><i class="bi bi-ticket-perforated-fill"></i></div>
                    <h5 class="font-black text-slate-800 uppercase tracking-tight text-sm">10 Tiket Wisata Terbaru</h5>
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button onclick="exportToExcel('.section-tiket table', 'Data_Tiket_Wisata')" class="no-print bg-emerald-600 text-white px-4 py-2.5 rounded-xl text-[10px] font-bold hover:bg-emerald-700 transition-all shadow-md active:scale-95 flex items-center gap-2 flex-1 sm:flex-none justify-center">
                        <i class="bi bi-file-earmark-excel"></i> EXCEL
                    </button>
                    <button onclick="printOnly('print-tiket')" class="no-print bg-brandDark text-white px-4 py-2.5 rounded-xl text-[10px] font-bold hover:bg-slate-800 transition-all shadow-md active:scale-95 flex items-center gap-2 flex-1 sm:flex-none justify-center">
                        <i class="bi bi-printer"></i> CETAK
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-400 text-[10px] uppercase font-bold tracking-widest">
                        <tr>
                            <th class="px-8 py-5">Nama Pembeli</th>
                            <th class="px-8 py-5">Destinasi</th>
                            <th class="px-8 py-5 text-center">Status</th>
                            <th class="px-8 py-5 text-center no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if($result_tiket && mysqli_num_rows($result_tiket) > 0): while($row = mysqli_fetch_assoc($result_tiket)): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-5 font-bold text-slate-900"><?= htmlspecialchars($row['nama_pembeli'] ?? 'Anonim') ?></td>
                            <td class="px-8 py-5 text-xs text-slate-500 font-medium"><?= htmlspecialchars($row['destinasi'] ?? '-') ?></td>
                            <td class="px-8 py-5 text-center">
                                <?php $status_tiket = $row['status'] ?? 'Menunggu Pembayaran'; ?>
                                <?php if($status_tiket == 'Lunas'): ?>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase"><i class="bi bi-check-circle-fill me-1"></i> Lunas</span>
                                <?php else: ?>
                                    <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase"><i class="bi bi-clock-fill me-1"></i> <?= htmlspecialchars($status_tiket) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-5 text-center no-print">
                                <button onclick="bukaModalStatus('tiket', <?= $row['id'] ?>, '<?= $status_tiket ?>')" class="bg-slate-100 text-slate-600 hover:bg-brand hover:text-white w-8 h-8 rounded-lg flex items-center justify-center mx-auto transition-colors">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="4" class="px-8 py-10 text-center text-sm text-slate-400">Belum ada data transaksi tiket.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="print-section section-booking bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden mt-8">
            <div class="px-8 py-6 border-b border-slate-100 flex flex-col sm:flex-row gap-4 justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center"><i class="bi bi-house-door-fill"></i></div>
                    <h5 class="font-black text-slate-800 uppercase tracking-tight text-sm">10 Booking Penginapan Terbaru</h5>
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button onclick="exportToExcel('.section-booking table', 'Data_Booking_Penginapan')" class="no-print bg-emerald-600 text-white px-4 py-2.5 rounded-xl text-[10px] font-bold hover:bg-emerald-700 transition-all shadow-md active:scale-95 flex items-center gap-2 flex-1 sm:flex-none justify-center">
                        <i class="bi bi-file-earmark-excel"></i> EXCEL
                    </button>
                    <button onclick="printOnly('print-booking')" class="no-print bg-brandDark text-white px-4 py-2.5 rounded-xl text-[10px] font-bold hover:bg-slate-800 transition-all shadow-md active:scale-95 flex items-center gap-2 flex-1 sm:flex-none justify-center">
                        <i class="bi bi-printer"></i> CETAK
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-400 text-[10px] uppercase font-bold tracking-widest">
                        <tr>
                            <th class="px-8 py-5">Nama Pemesan</th>
                            <th class="px-8 py-5">Detail Penginapan</th>
                            <th class="px-8 py-5 text-center">Status</th>
                            <th class="px-8 py-5 text-center no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if($result_booking && mysqli_num_rows($result_booking) > 0): while($row = mysqli_fetch_assoc($result_booking)): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-5 font-bold text-slate-900">
                                <?= htmlspecialchars($row['nama_lengkap'] ?? 'Anonim') ?>
                                <div class="text-xs text-slate-400 font-normal mt-1"><i class="bi bi-whatsapp"></i> <?= htmlspecialchars($row['no_hp'] ?? '-') ?></div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="font-bold text-slate-700"><?= htmlspecialchars($row['tipe_penginapan'] ?? '-') ?></span>
                                <span class="text-xs text-slate-500 ml-1">(<?= htmlspecialchars($row['durasi'] ?? '0') ?> Malam)</span>
                                <div class="text-xs text-brand font-medium mt-1">Check-in: <?= date('d M Y', strtotime($row['tgl_checkin'] ?? '')) ?></div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <?php $status_booking = $row['status'] ?? 'Menunggu Pembayaran'; ?>
                                <?php if($status_booking == 'Lunas'): ?>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase"><i class="bi bi-check-circle-fill me-1"></i> Lunas</span>
                                <?php else: ?>
                                    <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase"><i class="bi bi-clock-fill me-1"></i> <?= htmlspecialchars($status_booking) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-5 text-center no-print">
                                <button onclick="bukaModalStatus('booking', <?= $row['id'] ?>, '<?= $status_booking ?>')" class="bg-slate-100 text-slate-600 hover:bg-brand hover:text-white w-8 h-8 rounded-lg flex items-center justify-center mx-auto transition-colors">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="4" class="px-8 py-10 text-center text-sm text-slate-400">Belum ada data booking penginapan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <div id="modalStatus" class="hidden fixed inset-0 z-[100] bg-slate-900/40 backdrop-blur-sm flex justify-center items-center opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-3xl p-6 w-11/12 max-w-sm shadow-2xl transform scale-95 transition-transform duration-300" id="modalBox">
            <div class="flex justify-between items-center mb-5">
                <h3 class="font-black text-lg text-slate-800">Ubah Status</h3>
                <button onclick="tutupModalStatus()" class="text-slate-400 hover:text-red-500 text-xl"><i class="bi bi-x-lg"></i></button>
            </div>
            
            <form action="dashboard_admin.php" method="POST">
                <input type="hidden" name="id_item" id="input_id_item">
                <input type="hidden" name="tipe_item" id="input_tipe_item">
                
                <div class="mb-6">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Pilih Status Baru</label>
                    <div class="relative">
                        <select name="status_baru" id="input_status_baru" class="w-full bg-slate-50 border border-slate-200 text-slate-700 font-bold rounded-xl px-4 py-3.5 appearance-none focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition">
                            <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
                            <option value="Diproses">Diproses</option>
                            <option value="Lunas">Lunas</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                        <i class="bi bi-chevron-down absolute right-4 top-4 text-slate-400 pointer-events-none"></i>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="tutupModalStatus()" class="flex-1 bg-slate-100 text-slate-600 font-bold py-3.5 rounded-xl hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" name="update_status" class="flex-1 bg-brand text-white font-bold py-3.5 rounded-xl hover:bg-amber-600 shadow-lg shadow-brand/30 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // LOGIKA MODAL POP-UP
        const modal = document.getElementById('modalStatus');
        const modalBox = document.getElementById('modalBox');

        function bukaModalStatus(tipe, id, statusSaatIni) {
            document.getElementById('input_id_item').value = id;
            document.getElementById('input_tipe_item').value = tipe;
            document.getElementById('input_status_baru').value = statusSaatIni;
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalBox.classList.remove('scale-95');
            }, 10);
        }

        function tutupModalStatus() {
            modal.classList.add('opacity-0');
            modalBox.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // LOGIKA CETAK PER BAGIAN
        function printOnly(className) {
            document.body.classList.add(className);
            window.print();
            setTimeout(() => { document.body.classList.remove(className); }, 1000);
        }

       // LOGIKA EXPORT KE EXCEL ASLI (.XLS)
        function exportToExcel(tableSelector, filename) {
            let table = document.querySelector(tableSelector);

            // 1. Kloning tabel agar tabel asli di web tidak rusak saat kita hapus kolom "Aksi"
            let tableClone = table.cloneNode(true);
            
            // 2. Hapus kolom terakhir (Aksi) dari setiap baris
            let rows = tableClone.querySelectorAll("tr");
            for (let i = 0; i < rows.length; i++) {
                if (rows[i].children.length > 0) {
                    rows[i].removeChild(rows[i].lastElementChild);
                }
            }

            // 3. Buat template HTML khusus yang bisa dibaca sebagai tabel rapi oleh Microsoft Excel
            let uri = 'data:application/vnd.ms-excel;base64,';
            let template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta charset="utf-8"></head><body><table border="1">{table}</table></body></html>';
            
            let base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) };
            let format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) };
            
            let ctx = { worksheet: 'Data Laporan', table: tableClone.innerHTML };
            
            // 4. Proses Download File
            let downloadLink = document.createElement("a");
            
            let date = new Date();
            let dateString = date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate();
            
            downloadLink.download = filename + "_" + dateString + ".xls";
            downloadLink.href = uri + base64(format(template, ctx));
            
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

        // KONFIGURASI GRAFIK
        const chartConfig = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, border: { display: false }, ticks: { font: { family: "'Plus Jakarta Sans', sans-serif", size: 10 } } },
                y: { grid: { color: '#f1f5f9', borderDash: [5, 5] }, border: { display: false }, ticks: { font: { family: "'Plus Jakarta Sans', sans-serif", size: 10 } } }
            }
        };

        new Chart(document.getElementById('chartLokal'), {
            type: 'line',
            data: {
                labels: <?= json_encode(array_keys($monthlyStats)) ?>,
                datasets: [{
                    data: <?= json_encode(array_values($monthlyStats)) ?>,
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    fill: true, tension: 0.4, pointRadius: 5, pointBackgroundColor: '#fff', borderWidth: 3
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
                    backgroundColor: '#0f172a',
                    borderRadius: 6, barThickness: 24
                }]
            },
            options: chartConfig
        });
    </script>
</body>
</html>