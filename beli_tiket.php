<?php 
require_once __DIR__ . '/koneksi.php'; 

// Data Destinasi Madiun Lengkap (Sudah ditambahkan Harga & Icon)
$wisata_madiun = [
    ["nama" => "Pahlawan Street Center (PSC)", "harga" => 10000, "icon" => "bi-building-fill", "lokasi" => "Kartoharjo", "img" => "https://assets-a1.kompasiana.com/items/album/2024/12/12/img-0113-675a6be334777c25d2352533.jpeg", "desc" => "Malioboro-nya Kota Madiun yang dihiasi replika ikon dunia ikonik seperti Patung Merlion dan Menara Eiffel."],
    ["nama" => "Taman Sumber Umis", "harga" => 5000, "icon" => "bi-tree-fill", "lokasi" => "Manguharjo", "img" => "https://lh3.googleusercontent.com/gps-cs-s/APNQkAH8uUwWANvaY_KcCc_DOCFanpBPe5Sn2-35TARv1y8vM2jR3gkRkGiqO3fMKHXbccYp-6BUTWPF5vIggnb5Ami70_Cp3RGjqIXl3AGoR0kRWbG6oKpkYc4NGZXu3vlgmQLXR_4U=s680-w680-h510-rw", "desc" => "Taman kota indah di pusat Madiun yang memiliki replika Ka'bah dengan suasana malam yang megah."],
    ["nama" => "Alun-Alun Kota Madiun", "harga" => 5000, "icon" => "bi-people-fill", "lokasi" => "Manguharjo", "img" => "https://i.pinimg.com/736x/38/0e/4e/380e4ee1282c408ecc7ea699bbfed5f7.jpg", "desc" => "Pusat aktivitas warga dengan ruang terbuka hijau luas, Masjid Agung, dan dikelilingi jajaran kuliner lokal."],
    ["nama" => "Taman Bantaran Kali Madiun", "harga" => 5000, "icon" => "bi-water", "lokasi" => "Manguharjo", "img" => "https://i.pinimg.com/736x/48/d3/1c/48d31cfe40c5fbbf57aae4657076c328.jpg", "desc" => "Spot santai di pinggir sungai dengan fasilitas olahraga, gazebo, jembatan gantung, dan pemandangan asri."],
    ["nama" => "Monumen Kresek", "harga" => 10000, "icon" => "bi-bank2", "lokasi" => "Wungu", "img" => "https://i.pinimg.com/736x/e1/7f/3d/e17f3d23eb9e1ebaf93a0a110e042856.jpg", "desc" => "Monumen bersejarah yang penuh dengan nilai edukasi perjuangan bangsa, dikelilingi taman rindang yang tenang."],
    ["nama" => "Madiun Umbul Square", "harga" => 20000, "icon" => "bi-ticket-detailed-fill", "lokasi" => "Dolopo", "img" => "https://images.unsplash.com/photo-1534447677768-be436bb09401?q=80&w=800", "desc" => "Taman hiburan keluarga terpadu yang menyediakan wahana permainan air, kincir ria, dan mini zoo satwa."],
    ["nama" => "Taman Trembesi", "harga" => 10000, "icon" => "bi-tree", "lokasi" => "Kartoharjo", "img" => "https://static.promediateknologi.id/crop/0x0:0x0/1200x0/webp/photo/p1/867/2024/01/27/Picsart_24-01-27_20-24-31-261-729900772.jpg", "desc" => "Kawasan hutan kota mini dengan jajaran pohon trembesi raksasa yang sejuk, rindang, dan alami."],
    ["nama" => "Waduk Bening Widas", "harga" => 15000, "icon" => "bi-droplet-fill", "lokasi" => "Saradan", "img" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQPN1tWAOQZVv-zr1HOZUONGea7I93Af8RVg&s", "desc" => "Wisata air waduk yang menawarkan panorama alam pegunungan, spot memancing, dan bumi perkemahan."],
    ["nama" => "Desa Wisata Brumbun", "harga" => 25000, "icon" => "bi-geo-fill", "lokasi" => "Wungu", "img" => "https://images.unsplash.com/photo-1530866495561-507c9faab2ed?q=80&w=800", "desc" => "Destinasi wisata alam pedesaan lereng Wilis yang menawarkan aktivitas river tubing menantang."],
    ["nama" => "Ngrowo Bening Edupark", "harga" => 15000, "icon" => "bi-flower1", "lokasi" => "Taman", "img" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRV1kaTQ4BcEAhSbmwe6UaDPV17HGbXQ5MUKw&s", "desc" => "Taman edukasi agrowisata perkotaan, tempat belajar menanam sayur hidroponik, peternakan, dan bersantai."],
    ["nama" => "Hutan Pinus NONGKO IJO", "harga" => 10000, "icon" => "bi-signpost-split-fill", "lokasi" => "Kare", "img" => "https://indonesiatraveler.id/wp-content/uploads/2020/10/Madiun-Nongko-Ijo3-e1602582835404.jpg", "desc" => "Pesona air terjun tersembunyi di lereng Gunung Wilis yang menyuguhkan udara sejuk dan air super jernih."]
];

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
            $total_harga_per_orang += $wisata_madiun[$idx]['harga'];
            $destinasi_pilihan[] = $wisata_madiun[$idx]['nama'];
        }

        $final_total = $total_harga_per_orang * $jumlah_orang;
        $id_transaksi = "TRX-" . strtoupper(substr(md5(time()), 0, 8));
        $destinasi_str = implode(", ", $destinasi_pilihan);

        $query = "INSERT INTO pemesanan_tiket (id_transaksi, nama_pembeli, destinasi, jumlah_orang, total_bayar, status) 
                  VALUES ('$id_transaksi', '$nama_pembeli', '$destinasi_str', '$jumlah_orang', '$final_total', 'Menunggu Pembayaran')";
        
        if (mysqli_query($koneksi, $query)) {
            // Redirect ke konfirmasi pembayaran
            echo "<script>
                    alert('Pesanan berhasil! Silakan selesaikan pembayaran Anda.');
                    window.location.href = 'konfirmasi_pembayaran.php?id=" . $id_transaksi . "';
                  </script>";
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard Tiket - MadiunTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow: hidden; height: 100vh; }
        
        /* Percantik Scrollbar internal */
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* ======== SOLUSI PERUBAHAN WARNA SAAT DIKLIK ======== */
        .custom-checkbox input:checked + div {
            background-color: #f59e0b !important; 
            border-color: #f59e0b !important; 
            box-shadow: 0 4px 14px -3px rgba(245, 158, 11, 0.4);
        }
        .custom-checkbox input:checked + div h4,
        .custom-checkbox input:checked + div p.price-text {
            color: #ffffff !important; 
        }
        .custom-checkbox input:checked + div .icon-main { 
            color: white !important; 
            background: rgba(255,255,255,0.2) !important; 
        }
        .custom-checkbox input:checked + div .icon-check { display: block !important; }
        .custom-checkbox input:checked + div .circle-check { border-color: transparent !important; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 flex flex-col"> 

    <header class="bg-white h-[70px] flex-none px-6 border-b border-slate-200 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-4">
            <button onclick="window.location.href='landingpage.php'" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                <i class="bi bi-arrow-left text-xl"></i>
            </button>
            <div>
                <h1 class="text-xl font-extrabold text-slate-800 leading-tight">MadiunTrack</h1>
                <p class="text-[11px] text-slate-500 font-semibold uppercase tracking-wider">Ticketing Dashboard</p>
            </div>
        </div>
    </header>

    <main class="flex-1 flex flex-col lg:flex-row gap-4 p-4 lg:p-6 min-h-0 max-w-screen-2xl mx-auto w-full">
        
        <form action="" method="POST" id="formPemesanan" class="w-full flex flex-col lg:flex-row gap-4 lg:gap-6 min-h-0 h-full">
            
            <div class="flex-1 bg-white rounded-3xl p-5 shadow-sm border border-slate-200 flex flex-col min-h-0 h-full">
                
                <div class="flex justify-between items-center mb-4 flex-none">
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                            <i class="bi bi-geo-alt-fill text-amber-500"></i> Destinasi Wisata
                        </h2>
                        <p class="text-xs text-slate-500 mt-1">Pilih destinasi yang ingin Anda kunjungi.</p>
                    </div>
                    <span class="text-xs font-bold bg-amber-100 text-amber-600 px-3 py-1.5 rounded-lg" id="counter_destinasi">0 Terpilih</span>
                </div>
                
                <div class="flex-1 overflow-y-auto custom-scroll pr-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        <?php foreach($wisata_madiun as $index => $item): ?>
                        <label class="custom-checkbox cursor-pointer relative block">
                            <input type="checkbox" name="id_wisata[]" value="<?= $index + 1 ?>" data-harga="<?= $item['harga'] ?>" onchange="updatePrice()" class="peer sr-only">
                            
                            <div class="flex items-center p-3 rounded-2xl border-2 border-slate-100 bg-slate-50 transition-all duration-300 hover:border-amber-200 h-full">
                                
                                <div class="icon-main w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-500 mr-3 transition-colors">
                                    <i class="bi <?= $item['icon'] ?? 'bi-geo' ?> text-lg"></i>
                                </div>
                                
                                <div class="flex-1 transition-colors">
                                    <h4 class="font-bold text-sm text-slate-800 line-clamp-1 transition-colors"><?= $item['nama'] ?></h4>
                                    <p class="price-text text-xs font-bold text-amber-500 mt-0.5 transition-colors">Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                                </div>
                                
                                <div class="circle-check w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center bg-white transition-all ml-2">
                                    <i class="bi bi-check-lg text-amber-500 text-[10px] hidden icon-check"></i>
                                </div>
                                
                            </div>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-[350px] xl:w-[400px] flex-none flex flex-col gap-4 min-h-0">
                
                <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-200 flex-1 flex flex-col justify-between">
                    
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-800 mb-4 border-b border-slate-100 pb-3">Lengkapi Data</h3>
                        
                        <div class="mb-4">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nama Pengunjung</label>
                            <input type="text" name="nama_pembeli" id="nama_pembeli" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-sm font-semibold focus:bg-white focus:ring-2 focus:ring-amber-500 outline-none transition-all" placeholder="Sesuai KTP" required>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Jumlah</label>
                                <div class="flex items-center justify-between bg-slate-50 rounded-xl p-1 border border-slate-200">
                                    <button type="button" onclick="adjustQty(-1)" class="w-8 h-8 rounded-lg bg-white shadow-sm text-slate-600 flex items-center justify-center hover:bg-slate-200"><i class="bi bi-dash"></i></button>
                                    <input type="number" name="jumlah" id="jumlah" min="1" value="1" class="w-8 text-center bg-transparent font-bold text-sm outline-none" readonly>
                                    <button type="button" onclick="adjustQty(1)" class="w-8 h-8 rounded-lg bg-slate-200 text-slate-800 flex items-center justify-center hover:bg-slate-300"><i class="bi bi-plus"></i></button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Metode</label>
                                <select name="metode_pembayaran" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-3 text-sm font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-amber-500" required>
                                    <option value="" disabled selected>Pilih...</option>
                                    <option value="DANA">DANA</option>
                                    <option value="OVO">OVO</option>
                                    <option value="BCA">BCA Virtual</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-900 rounded-2xl p-5 text-white mt-auto">
                        <span class="text-xs text-slate-400 font-semibold block mb-1">Total Pembayaran</span>
                        <h3 class="text-3xl font-black text-amber-500 mb-4" id="total_bayar_display">Rp 0</h3>
                        
                        <button type="button" onclick="submitForm()" class="w-full bg-amber-500 hover:bg-amber-400 text-slate-900 py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-amber-500/20 active:scale-95 flex justify-center items-center gap-2">
                            Bayar Sekarang <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>

                </div>
            </div>

        </form>
    </main>

    <script>
        function updatePrice() {
            const checkboxes = document.querySelectorAll('input[name="id_wisata[]"]:checked');
            const jumlahOrang = parseInt(document.getElementById('jumlah').value) || 1;
            
            document.getElementById('counter_destinasi').innerText = `${checkboxes.length} Terpilih`;

            let totalHargaPerOrang = 0;
            checkboxes.forEach(cb => {
                totalHargaPerOrang += parseInt(cb.getAttribute('data-harga'));
            });

            const totalAkhir = totalHargaPerOrang * jumlahOrang;
            document.getElementById('total_bayar_display').innerText = "Rp " + totalAkhir.toLocaleString('id-ID');
        }

        function adjustQty(change) {
            const input = document.getElementById('jumlah');
            let currentVal = parseInt(input.value);
            let newVal = currentVal + change;
            if(newVal >= 1) {
                input.value = newVal;
                updatePrice();
            }
        }

        function submitForm() {
            const form = document.getElementById('formPemesanan');
            const checkedDest = document.querySelectorAll('input[name="id_wisata[]"]:checked').length;
            
            if(!document.getElementById('nama_pembeli').value) { alert("Harap isi Nama Pengunjung."); return; }
            if(checkedDest === 0) { alert("Pilih minimal satu destinasi."); return; }
            if(!form.metode_pembayaran.value) { alert("Pilih metode pembayaran."); return; }
            
            const submitInput = document.createElement('input');
            submitInput.type = 'hidden'; submitInput.name = 'bayar_tiket'; submitInput.value = 'true';
            form.appendChild(submitInput);
            
            form.submit();
        }

        document.addEventListener('DOMContentLoaded', updatePrice);
    </script>
</body>
</html>