<?php 
require_once __DIR__ . '/koneksi.php'; 

// Data Destinasi Bromo Lengkap
$wisata_bromo = [
    ["nama" => "Penanjakan 1", "harga" => 220000],
    ["nama" => "Kawah Bromo", "harga" => 150000],
    ["nama" => "Pasir Berbisik", "harga" => 75000],
    ["nama" => "Bukit Teletubbies", "harga" => 50000],
    ["nama" => "Pura Luhur Poten", "harga" => 50000],
    ["nama" => "Bukit Kingkong", "harga" => 120000],
    ["nama" => "Bukit Cinta", "harga" => 100000],
    ["nama" => "Gunung Widodaren", "harga" => 100000],
    ["nama" => "Seruni Point", "harga" => 150000],
    ["nama" => "Padang Savana", "harga" => 50000],
    ["nama" => "Air Terjun Madakaripura", "harga" => 45000]
];

// Inisialisasi variabel untuk modal
$show_payment = false;
$id_transaksi = "";
$final_total = 0;
$nama_pembeli = "";
$metode_dipilih = "";

if (isset($_POST['bayar_tiket'])) {
    $nama_pembeli = mysqli_real_escape_string($koneksi, $_POST['nama_pembeli']);
    $jumlah_orang = (int)$_POST['jumlah'];
    $id_wisata_array = $_POST['id_wisata'] ?? [];
    $metode_dipilih = $_POST['metode_pembayaran'];

    if (!empty($id_wisata_array)) {
        $total_harga_per_orang = 0;
        $destinasi_pilihan = [];
        
        foreach ($id_wisata_array as $index) {
            $idx = $index - 1;
            $total_harga_per_orang += $wisata_bromo[$idx]['harga'];
            $destinasi_pilihan[] = $wisata_bromo[$idx]['nama'];
        }

        $final_total = $total_harga_per_orang * $jumlah_orang;
        $id_transaksi = "TRX-" . strtoupper(substr(md5(time()), 0, 8));
        $destinasi_str = implode(", ", $destinasi_pilihan);

        $query = "INSERT INTO pemesanan_tiket (id_transaksi, nama_pembeli, destinasi, jumlah_orang, total_bayar, status) 
                  VALUES ('$id_transaksi', '$nama_pembeli', '$destinasi_str', '$jumlah_orang', '$final_total', 'Menunggu Pembayaran')";
        
        if (mysqli_query($koneksi, $query)) {
            $show_payment = true; 
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tiket - BromoTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-950 text-white min-h-screen py-10 px-4">

<div class="max-w-2xl mx-auto">
    <div class="bg-white/10 backdrop-blur-xl border border-white/10 p-8 md:p-10 rounded-[2rem] shadow-2xl">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-amber-500/20 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                <i class="bi bi-ticket-perforated"></i>
            </div>
            <h2 class="text-3xl font-bold">Pesan Tiket Wisata</h2>
            <p class="text-slate-400">Pilih destinasi favoritmu untuk E-Ticket instan.</p>
        </div>

        <form action="" method="POST" class="space-y-6">
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2">Nama Pengunjung</label>
                <input type="text" name="nama_pembeli" class="w-full bg-slate-800/50 border border-slate-700 rounded-xl py-3 px-4 focus:ring-2 focus:ring-amber-500 outline-none transition" placeholder="Nama Lengkap" required>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2">Pilih Destinasi</label>
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-4 max-h-60 overflow-y-auto space-y-2">
                    <?php foreach($wisata_bromo as $index => $item): ?>
                    <label class="flex items-center justify-between p-3 hover:bg-white/5 rounded-lg cursor-pointer transition">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="id_wisata[]" value="<?= $index + 1 ?>" data-harga="<?= $item['harga'] ?>" onchange="updatePrice()" class="w-5 h-5 rounded border-slate-600 bg-slate-700 accent-amber-500">
                            <span class="text-sm"><?= $item['nama'] ?></span>
                        </div>
                        <span class="text-amber-500 font-bold text-sm">Rp<?= number_format($item['harga'], 0, ',', '.') ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2">Jumlah Orang</label>
                    <input type="number" name="jumlah" id="jumlah" min="1" value="1" class="w-full bg-slate-800/50 border border-slate-700 rounded-xl py-3 px-4 outline-none focus:ring-2 focus:ring-amber-500" oninput="updatePrice()">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2">Pembayaran</label>
                    <select name="metode_pembayaran" class="w-full bg-slate-800/50 border border-slate-700 rounded-xl py-3 px-4 outline-none focus:ring-2 focus:ring-amber-500" required>
                        <option value="" disabled selected>Pilih Metode</option>
                        <option value="DANA">DANA</option>
                        <option value="OVO">OVO</option>
                        <option value="BCA">BCA VA</option>
                    </select>
                </div>
            </div>

            <div class="bg-amber-500/10 border border-amber-500/20 p-6 rounded-2xl text-center">
                <span class="text-slate-400 text-sm">Total Bayar:</span>
                <h3 class="text-3xl font-black text-amber-500" id="total_bayar_display">Rp 0</h3>
            </div>

            <button type="submit" name="bayar_tiket" class="w-full bg-amber-600 hover:bg-amber-500 py-4 rounded-xl font-bold transition-all shadow-lg shadow-amber-900/50">
                Konfirmasi Pemesanan <i class="bi bi-arrow-right ml-2"></i>
            </button>
        </form>
    </div>
</div>

<script>
function updatePrice() {
    const checkboxes = document.querySelectorAll('input[name="id_wisata[]"]:checked');
    const jumlahOrang = document.getElementById('jumlah').value || 1;
    let totalHargaPerOrang = 0;
    checkboxes.forEach(cb => totalHargaPerOrang += parseInt(cb.getAttribute('data-harga')));
    document.getElementById('total_bayar_display').innerText = "Rp " + (totalHargaPerOrang * jumlahOrang).toLocaleString('id-ID');
}
</script>
</body>
</html>