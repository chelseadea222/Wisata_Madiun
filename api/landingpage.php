<?php
/**
 * File: landingpage.php
 * Deskripsi: Landing Page Terpadu MadiunTrack 
 * Fitur: Navbar Custom, Quick Menu, Destinasi Kotak Panjang, Estimasi & Kuliner Scroll
 */
require_once __DIR__ . '/koneksi.php'; 

// 1. DATA DESTINASI WISATA (Lengkap 11 Lokasi di Madiun & Sekitarnya)
$wisata_madiun = [
    ["nama" => "Pahlawan Street Center (PSC)", "lokasi" => "Kartoharjo", "img" => "https://images.unsplash.com/photo-1625244724108-a728149186e0?q=80&w=800", "desc" => "Malioboro-nya Kota Madiun yang dihiasi replika ikon dunia ikonik seperti Patung Merlion dan Menara Eiffel."],
    ["nama" => "Taman Sumber Umis", "lokasi" => "Kartoharjo", "img" => "https://images.unsplash.com/photo-1564507592333-c60657eea523?q=80&w=800", "desc" => "Taman kota indah di pusat Madiun yang memiliki replika Ka'bah dengan suasana malam yang megah."],
    ["nama" => "Alun-Alun Kota Madiun", "lokasi" => "Manguharjo", "img" => "https://images.unsplash.com/photo-1596422846543-75c6fc1f7f67?q=80&w=800", "desc" => "Pusat aktivitas warga dengan ruang terbuka hijau luas, Masjid Agung, dan dikelilingi jajaran kuliner lokal."],
    ["nama" => "Taman Bantaran Kali Madiun", "lokasi" => "Manguharjo", "img" => "https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800", "desc" => "Spot santai di pinggir sungai dengan fasilitas olahraga, gazebo, jembatan gantung, dan pemandangan asri."],
    ["nama" => "Monumen Kresek", "lokasi" => "Wungu", "img" => "https://images.unsplash.com/photo-1599946347371-68eb71b16afc?q=80&w=800", "desc" => "Monumen bersejarah yang penuh dengan nilai edukasi perjuangan bangsa, dikelilingi taman rindang yang tenang."],
    ["nama" => "Madiun Umbul Square", "lokasi" => "Dolopo", "img" => "https://images.unsplash.com/photo-1534447677768-be436bb09401?q=80&w=800", "desc" => "Taman hiburan keluarga terpadu yang menyediakan wahana permainan air, kincir ria, dan mini zoo satwa."],
    ["nama" => "Taman Trembesi", "lokasi" => "Kartoharjo", "img" => "https://images.unsplash.com/photo-1448375240586-882707db888b?q=80&w=800", "desc" => "Kawasan hutan kota mini dengan jajaran pohon trembesi raksasa yang sejuk, rindang, dan alami."],
    ["nama" => "Waduk Bening Widas", "lokasi" => "Saradan", "img" => "https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=800", "desc" => "Wisata air waduk yang menawarkan panorama alam pegunungan, spot memancing, dan bumi perkemahan."],
    ["nama" => "Desa Wisata Brumbun", "lokasi" => "Wungu", "img" => "https://images.unsplash.com/photo-1530866495561-507c9faab2ed?q=80&w=800", "desc" => "Destinasi wisata alam pedesaan lereng Wilis yang menawarkan aktivitas river tubing menantang."],
    ["nama" => "Ngrowo Bening Edupark", "lokasi" => "Taman", "img" => "https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?q=80&w=800", "desc" => "Taman edukasi agrowisata perkotaan, tempat belajar menanam sayur hidroponik, peternakan, dan bersantai."],
    ["nama" => "Air Terjun Kudusan", "lokasi" => "Kare", "img" => "https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?q=80&w=800", "desc" => "Pesona air terjun tersembunyi di lereng Gunung Wilis yang menyuguhkan udara sejuk dan air super jernih."]
];

// 2. DATA ESTIMASI JALUR MENUJU MADIUN
$estimasi_jalur = [
    ["opsi" => "Rute Surabaya", "img" => "https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=800", "biaya" => "± Rp 80rb - 150rb", "transport" => "Tol Trans Jawa / Kereta Api"],
    ["opsi" => "Rute Solo / Jogja", "img" => "https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?q=80&w=800", "biaya" => "± Rp 60rb - 120rb", "transport" => "Kereta Api / Jalur Nasional"],
    ["opsi" => "Rute Jakarta", "img" => "https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=800", "biaya" => "± Rp 250rb - 500rb", "transport" => "Tol Trans Jawa / Bus Eksekutif"],
    ["opsi" => "Rute Kediri / Nganjuk", "img" => "https://images.unsplash.com/photo-1588666309990-d68f08e3d4a6?q=80&w=800", "biaya" => "± Rp 30rb - 70rb", "transport" => "Motor / Mobil / Bus Provinsi"]
];

// 3. DATA KULINER MADIUN
$kuliner_madiun = [
    ["nama" => "Nasi Pecel Madiun Asli", "img" => "https://images.unsplash.com/photo-1512058560366-cd242d4ba351?q=80&w=500", "status" => "Sedang Buka"],
    ["nama" => "Pentol Corah Madiun", "img" => "https://images.unsplash.com/photo-1582878826629-29b7ad1cdc43?q=80&w=500", "status" => "Sedang Buka"],
    ["nama" => "Brem Tradisional Madiun", "img" => "https://images.unsplash.com/photo-1559925393-8be0ec4767c8?q=80&w=500", "status" => "Sedang Buka"],
    ["nama" => "Madumongso Legit", "img" => "https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=500", "status" => "Tutup Sementara"]
];
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MadiunTrack - Jelajahi Keindahan Kota Madiun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Konfigurasi Tailwind Terpusat -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { jakarta: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: '#0e7490',    /* Cyan/Teal Utama */
                        brandDark: '#083344', /* Cyan Gelap */
                        accent: '#ea580c',   /* Oranye */
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Hilangkan Scrollbar tapi tetap bisa di-scroll */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

    <!-- NAVBAR -->
    <nav class="bg-white/90 backdrop-blur-lg sticky top-0 z-50 py-4 border-b border-slate-200 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <!-- Logo -->
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-brand rounded-xl shadow-md shadow-brand/30 flex items-center justify-center text-white transition-transform group-hover:scale-105">
                    <i class="bi bi-geo-alt-fill text-lg"></i>
                </div>
                <span class="text-2xl font-black tracking-tight text-brandDark">
                    MADIUN<span class="text-accent">TRACK</span>
                </span>
            </a>
            
            <!-- Link Menu (Desktop) -->
            <div class="hidden md:flex gap-8 font-semibold text-sm text-slate-500 items-center">
                <a href="#destinasi" class="hover:text-brand transition-colors">Destinasi</a>
                <a href="#estimasi" class="hover:text-brand transition-colors">Estimasi</a>
                <a href="#kuliner" class="hover:text-brand transition-colors">Kuliner</a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="relative h-[550px] md:h-[600px] flex flex-col justify-center items-center text-center px-4">
        <!-- Latar Belakang Hero -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1588666309990-d68f08e3d4a6?q=80&w=1920" class="w-full h-full object-cover" alt="Madiun">
            <!-- Overlay Gradien yang lebih halus -->
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-slate-900/50 to-slate-900/90"></div>
        </div>

        <div class="relative z-10 w-full max-w-3xl mx-auto -mt-10">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight drop-shadow-lg tracking-tight">
                Jelajahi Pesona <br/><span class="text-accent">Kota Madiun</span>
            </h1>
            <p class="text-base md:text-lg text-slate-200 mb-10 font-medium">Temukan destinasi wisata, kuliner legendaris, dan rencanakan perjalanan Anda dengan mudah.</p>
            
            <!-- Kolom Pencarian -->
            <div class="bg-white p-2 rounded-full flex items-center w-full shadow-2xl transition-all focus-within:ring-4 focus-within:ring-brand/30">
                <div class="flex-1 px-5 flex items-center gap-3 text-slate-400">
                    <i class="bi bi-search text-brand text-lg"></i>
                    <input type="text" placeholder="Ketik destinasi impianmu..." class="w-full outline-none bg-transparent font-medium text-slate-800 placeholder-slate-400">
                </div>
                <button class="bg-brand text-white px-8 py-3.5 rounded-full font-bold hover:bg-brandDark transition shadow-md">Cari</button>
            </div>
        </div>
    </header>

    <!-- QUICK MENU SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <a href="#kuliner" class="bg-white p-6 rounded-[2rem] shadow-xl shadow-slate-200/50 flex items-center gap-5 hover:-translate-y-2 transition-all duration-300 group border border-slate-100">
                <div class="w-16 h-16 rounded-2xl bg-brand/10 text-brand flex items-center justify-center text-3xl group-hover:bg-brand group-hover:text-white transition-colors">
                    <i class="bi bi-egg-fried"></i>
                </div>
                <div>
                    <h4 class="font-bold text-xl text-brandDark">Kuliner Lokal</h4>
                    <p class="text-slate-500 text-sm mt-1">Cicipi cita rasa otentik.</p>
                </div>
            </a>
            
            <a href="booking.php" class="bg-white p-6 rounded-[2rem] shadow-xl shadow-slate-200/50 flex items-center gap-5 hover:-translate-y-2 transition-all duration-300 group border border-slate-100">
                <div class="w-16 h-16 rounded-2xl bg-brand/10 text-brand flex items-center justify-center text-3xl group-hover:bg-brand group-hover:text-white transition-colors">
                    <i class="bi bi-house-door"></i>
                </div>
                <div>
                    <h4 class="font-bold text-xl text-brandDark">Penginapan</h4>
                    <p class="text-slate-500 text-sm mt-1">Hotel & Homestay nyaman.</p>
                </div>
            </a>
            
            <a href="beli_tiket.php" class="bg-white p-6 rounded-[2rem] shadow-xl shadow-slate-200/50 flex items-center gap-5 hover:-translate-y-2 transition-all duration-300 group border border-slate-100">
                <div class="w-16 h-16 rounded-2xl bg-brand/10 text-brand flex items-center justify-center text-3xl group-hover:bg-brand group-hover:text-white transition-colors">
                    <i class="bi bi-ticket-perforated"></i>
                </div>
                <div>
                    <h4 class="font-bold text-xl text-brandDark">Paket Wisata</h4>
                    <p class="text-slate-500 text-sm mt-1">Jelajahi tanpa ribet.</p>
                </div>
            </a>

        </div>
    </section>

    <!-- DESTINASI WISATA SECTION -->
    <section id="destinasi" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-brandDark tracking-tight mb-2">Destinasi Populer</h2>
                <div class="w-16 h-1.5 bg-accent rounded-full"></div>
            </div>
            
            <!-- Navigasi Panah -->
            <div class="hidden md:flex gap-3">
                <button onclick="scrollSection('destinasi-scroll', 'left')" class="w-12 h-12 rounded-full bg-white shadow-md border border-slate-100 flex items-center justify-center text-slate-600 hover:bg-brand hover:text-white hover:border-brand transition-all">
                    <i class="bi bi-chevron-left text-lg"></i>
                </button>
                <button onclick="scrollSection('destinasi-scroll', 'right')" class="w-12 h-12 rounded-full bg-white shadow-md border border-slate-100 flex items-center justify-center text-slate-600 hover:bg-brand hover:text-white hover:border-brand transition-all">
                    <i class="bi bi-chevron-right text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Scroll Container -->
        <div id="destinasi-scroll" class="flex overflow-x-auto gap-6 pb-12 snap-x snap-mandatory no-scrollbar scroll-smooth -mx-4 px-4 sm:mx-0 sm:px-0">
            <?php foreach ($wisata_madiun as $w): ?>
            <div class="w-[85vw] sm:w-[400px] flex-shrink-0 bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col snap-start group">
                <!-- Gambar & Label -->
                <div class="relative h-56 overflow-hidden">
                    <img src="<?= $w['img'] ?>" alt="<?= htmlspecialchars($w['nama']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute top-4 left-4 bg-black/50 backdrop-blur-md text-white px-3 py-1.5 rounded-full text-xs font-bold flex items-center gap-1.5">
                        <i class="bi bi-geo-alt-fill text-accent"></i> <?= htmlspecialchars($w['lokasi']) ?>
                    </div>
                </div>
                <!-- Konten Card -->
                <div class="p-6 flex flex-col flex-grow text-left">
                    <h3 class="font-extrabold text-xl text-brandDark mb-2 line-clamp-1"><?= htmlspecialchars($w['nama']) ?></h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-3">"<?= htmlspecialchars($w['desc']) ?>"</p>
                    
                    <div class="mt-auto pt-4 border-t border-slate-100">
                        <a href="informasi_destinasi.php?item=<?= urlencode($w['nama']) ?>" class="w-full bg-brand/10 text-brand px-6 py-3 rounded-xl flex justify-center items-center gap-2 text-sm font-bold hover:bg-brand hover:text-white transition-colors group/btn">
                            Lihat Detail Wisata <i class="bi bi-arrow-right transition-transform group-hover/btn:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ESTIMASI PERJALANAN SECTION -->
    <section id="estimasi" class="bg-brandDark py-24 border-t border-slate-800 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="mb-14">
                <h2 class="text-3xl md:text-4xl font-extrabold mb-3">Estimasi Perjalanan</h2>
                <p class="text-slate-400 font-medium">Pilih rute perjalanan paling efisien menuju Kota Madiun</p>
            </div>

            <div id="estimasi-scroll" class="flex overflow-x-auto gap-6 pb-10 snap-x snap-mandatory no-scrollbar scroll-smooth -mx-4 px-4 sm:mx-0 sm:px-0">
                <?php foreach ($estimasi_jalur as $index => $e): ?>
                <div class="w-[85vw] sm:w-[450px] lg:w-[500px] flex-shrink-0 bg-slate-800 rounded-3xl overflow-hidden relative snap-center h-[350px] shadow-2xl border border-white/10 group">
                    <img src="<?= $e['img'] ?>" alt="<?= $e['opsi'] ?>" class="w-full h-full object-cover opacity-40 group-hover:scale-110 group-hover:opacity-30 transition duration-700">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent flex flex-col justify-end p-8 text-left">
                        <span class="inline-flex w-max items-center gap-1.5 px-3 py-1 rounded-full bg-green-500/20 text-green-400 border border-green-500/30 text-xs font-bold mb-4 uppercase tracking-widest">
                            <i class="bi bi-circle-fill text-[8px] animate-pulse"></i> Jalur Aktif
                        </span>
                        <h3 class="text-white font-black text-3xl mb-2"><?= htmlspecialchars($e['opsi']) ?></h3>
                        <p class="text-accent font-bold text-xl mb-4"><?= $e['biaya'] ?></p>
                        
                        <div class="flex items-center gap-3 text-slate-300 text-sm font-semibold border-t border-white/10 pt-4">
                            <i class="bi bi-car-front-fill opacity-70"></i>
                            <span><?= $e['transport'] ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Dots Estimasi -->
            <div class="flex justify-center gap-2 mt-2 mb-12">
                <?php foreach ($estimasi_jalur as $index => $e): ?>
                <button onclick="scrollToIndex('estimasi-scroll', <?= $index ?>)" class="estimasi-dot w-2 h-2 rounded-full bg-slate-600 transition-all duration-300" data-idx="<?= $index ?>"></button>
                <?php endforeach; ?>
            </div>

            <!-- Tombol Aksi Utama -->
            <div class="flex justify-center">
                <a id="btn-cek-rute" href="peta_rute.php?jalur=<?= urlencode($estimasi_jalur[0]['opsi']) ?>" class="bg-accent text-white px-10 py-4 rounded-full flex items-center justify-center gap-3 text-base font-bold hover:bg-[#d04b06] hover:-translate-y-1 transition-all shadow-lg shadow-accent/40">
                    <i class="bi bi-map-fill"></i> Lihat Peta Rute
                </a>
            </div>
        </div>
    </section>

    <!-- KULINER SECTION -->
    <section id="kuliner" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-brandDark mb-10 text-center md:text-left">Kuliner Wajib Coba</h2>
            
            <div id="kuliner-scroll" class="flex overflow-x-auto gap-6 pb-8 snap-x snap-mandatory no-scrollbar scroll-smooth -mx-4 px-4 sm:mx-0 sm:px-0">
                <?php foreach ($kuliner_madiun as $index => $k): ?>
                <div class="w-[70vw] sm:w-[350px] flex-shrink-0 bg-white rounded-3xl overflow-hidden shadow-md snap-start h-[300px] relative group border border-slate-100">
                    <img src="<?= $k['img'] ?>" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/30 to-transparent flex flex-col justify-end p-6 text-left">
                        
                        <?php if($k['status'] == 'Sedang Buka'): ?>
                            <span class="text-green-400 text-xs font-bold mb-2 flex items-center gap-1.5"><i class="bi bi-clock-fill"></i> Sedang Buka</span>
                        <?php else: ?>
                            <span class="text-red-400 text-xs font-bold mb-2 flex items-center gap-1.5"><i class="bi bi-clock-history"></i> Tutup Sementara</span>
                        <?php endif; ?>
                        
                        <h3 class="text-white font-extrabold text-xl leading-tight"><?= htmlspecialchars($k['nama']) ?></h3>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="flex justify-center md:justify-start gap-2 mt-2">
                <?php foreach ($kuliner_madiun as $index => $k): ?>
                <button onclick="scrollToIndex('kuliner-scroll', <?= $index ?>)" class="kuliner-dot w-2 h-2 rounded-full bg-slate-300 transition-all duration-300" data-idx="<?= $index ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-200 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center">
            <div class="flex items-center gap-2 opacity-50 mb-6 text-brandDark">
                <i class="bi bi-geo-alt-fill text-2xl"></i>
                <span class="text-2xl font-black tracking-tight">MADIUNTRACK</span>
            </div>
            <p class="text-slate-500 text-sm text-center mb-8 max-w-sm">
                Portal informasi dan pemesanan tiket wisata terpadu untuk wilayah Madiun dan sekitarnya.
            </p>
            <div class="w-full border-t border-slate-100 pt-8 text-center flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-400 text-sm">&copy; 2026 MadiunTrack. All rights reserved.</p>
                <div class="flex gap-4 text-slate-400">
                    <a href="#" class="hover:text-brand"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="hover:text-brand"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="hover:text-brand"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JAVASCRIPT LOGIC (Scroll & Sinkronisasi Dots) -->
    <script>
        const estimasiData = <?= json_encode($estimasi_jalur) ?>;
        const btnCekRute = document.getElementById('btn-cek-rute');

        // Fungsi Panah Scroll (Untuk Destinasi)
        function scrollSection(containerId, direction) {
            const container = document.getElementById(containerId);
            const cardWidth = container.querySelector('div').offsetWidth + 24; // Width + Gap(6)
            container.scrollBy({ left: direction === 'left' ? -cardWidth : cardWidth, behavior: 'smooth' });
        }

        // Fungsi Dots Click
        function scrollToIndex(containerId, index) {
            const container = document.getElementById(containerId);
            const cardWidth = container.querySelector('div').offsetWidth + 24; 
            container.scrollTo({ left: cardWidth * index, behavior: 'smooth' });
        }

        // Sinkronisasi Active Dot saat Scroll
        function setupScrollObserver(containerId, dotClass, activeColor, activeWidth, inactiveColor, isEstimasi = false) {
            const container = document.getElementById(containerId);
            const dots = document.querySelectorAll(`.${dotClass}`);
            if (!container) return;

            const updateDots = () => {
                const cardWidth = container.querySelector('div').offsetWidth + 24;
                const index = Math.round(container.scrollLeft / cardWidth);
                
                dots.forEach((dot, i) => {
                    if(i === index) {
                        dot.classList.remove(inactiveColor, 'w-2');
                        dot.classList.add(activeColor, activeWidth);
                    } else {
                        dot.classList.add(inactiveColor, 'w-2');
                        dot.classList.remove(activeColor, activeWidth);
                    }
                });

                // Update Tombol khusus Estimasi
                if (isEstimasi && estimasiData[index]) {
                    const ruteNama = encodeURIComponent(estimasiData[index].opsi);
                    btnCekRute.href = `peta_rute.php?jalur=${ruteNama}`;
                }
            };

            container.addEventListener('scroll', updateDots);
            // Inisialisasi tampilan awal
            updateDots();
        }

        // Pasang Observer
        window.addEventListener('DOMContentLoaded', () => {
            // Setup Estimasi (Warna Teal terang untuk background gelap)
            setupScrollObserver('estimasi-scroll', 'estimasi-dot', 'bg-accent', 'w-8', 'bg-slate-600', true);
            
            // Setup Kuliner (Warna Teal gelap untuk background terang)
            setupScrollObserver('kuliner-scroll', 'kuliner-dot', 'bg-brand', 'w-8', 'bg-slate-300', false);
        });
    </script>
</body>
</html>