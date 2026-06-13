<?php
/**
 * File: landingpage.php
 * Deskripsi: Landing Page Terpadu MadiunTrack 
 * Fitur: Navbar Custom, Quick Menu, Destinasi Kotak Panjang, Estimasi & Kuliner Scroll
 */
require_once __DIR__ . '/koneksi.php'; 

// 1. DATA DESTINASI WISATA (Lengkap 11 Lokasi di Madiun & Sekitarnya)
$wisata_madiun = [
    ["nama" => "Pahlawan Street Center (PSC)", "lokasi" => "Kartoharjo", "img" => "https://assets-a1.kompasiana.com/items/album/2024/12/12/img-0113-675a6be334777c25d2352533.jpeg", "desc" => "Malioboro-nya Kota Madiun yang dihiasi replika ikon dunia ikonik seperti Patung Merlion dan Menara Eiffel."],
    ["nama" => "Taman Sumber Umis", "lokasi" => "Manguharjo", "img" => "https://lh3.googleusercontent.com/gps-cs-s/APNQkAH8uUwWANvaY_KcCc_DOCFanpBPe5Sn2-35TARv1y8vM2jR3gkRkGiqO3fMKHXbccYp-6BUTWPF5vIggnb5Ami70_Cp3RGjqIXl3AGoR0kRWbG6oKpkYc4NGZXu3vlgmQLXR_4U=s680-w680-h510-rw", "desc" => "Taman kota indah di pusat Madiun yang memiliki replika Ka'bah dengan suasana malam yang megah."],
    ["nama" => "Alun-Alun Kota Madiun", "lokasi" => "Manguharjo", "img" => "https://i.pinimg.com/736x/38/0e/4e/380e4ee1282c408ecc7ea699bbfed5f7.jpg", "desc" => "Pusat aktivitas warga dengan ruang terbuka hijau luas, Masjid Agung, dan dikelilingi jajaran kuliner lokal."],
    ["nama" => "Taman Bantaran Kali Madiun", "lokasi" => "Manguharjo", "img" => "https://i.pinimg.com/736x/48/d3/1c/48d31cfe40c5fbbf57aae4657076c328.jpg", "desc" => "Spot santai di pinggir sungai dengan fasilitas olahraga, gazebo, jembatan gantung, dan pemandangan asri."],
    ["nama" => "Monumen Kresek", "lokasi" => "Wungu", "img" => "https://i.pinimg.com/736x/e1/7f/3d/e17f3d23eb9e1ebaf93a0a110e042856.jpg", "desc" => "Monumen bersejarah yang penuh dengan nilai edukasi perjuangan bangsa, dikelilingi taman rindang yang tenang."],
    ["nama" => "Madiun Umbul Square", "lokasi" => "Dolopo", "img" => "https://images.unsplash.com/photo-1534447677768-be436bb09401?q=80&w=800", "desc" => "Taman hiburan keluarga terpadu yang menyediakan wahana permainan air, kincir ria, dan mini zoo satwa."],
    ["nama" => "Taman Trembesi", "lokasi" => "Kartoharjo", "img" => "https://static.promediateknologi.id/crop/0x0:0x0/1200x0/webp/photo/p1/867/2024/01/27/Picsart_24-01-27_20-24-31-261-729900772.jpg", "desc" => "Kawasan hutan kota mini dengan jajaran pohon trembesi raksasa yang sejuk, rindang, dan alami."],
    ["nama" => "Waduk Bening Widas", "lokasi" => "Saradan", "img" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQPN1tWAOQZVv-zr1HOZUONGea7I93Af8RVg&s", "desc" => "Wisata air waduk yang menawarkan panorama alam pegunungan, spot memancing, dan bumi perkemahan."],
    ["nama" => "Desa Wisata Brumbun", "lokasi" => "Wungu", "img" => "https://images.unsplash.com/photo-1530866495561-507c9faab2ed?q=80&w=800", "desc" => "Destinasi wisata alam pedesaan lereng Wilis yang menawarkan aktivitas river tubing menantang."],
    ["nama" => "Ngrowo Bening Edupark", "lokasi" => "Taman", "img" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRV1kaTQ4BcEAhSbmwe6UaDPV17HGbXQ5MUKw&s", "desc" => "Taman edukasi agrowisata perkotaan, tempat belajar menanam sayur hidroponik, peternakan, dan bersantai."],
    ["nama" => "Hutan Pinus NONGKO IJO", "lokasi" => "Kare", "img" => "https://indonesiatraveler.id/wp-content/uploads/2020/10/Madiun-Nongko-Ijo3-e1602582835404.jpg", "desc" => "Pesona air terjun tersembunyi di lereng Gunung Wilis yang menyuguhkan udara sejuk dan air super jernih."]
];

// 2. DATA KOORDINAT DESTINASI (Untuk rute peta)
// 1. DATA DESTINASI WISATA TERPADU (Koordinat + Gambar + Deskripsi Singkat)

// Tambahkan ini di bagian atas file, bersama variabel lainnya
$estimasi_jalur = [
    ["opsi" => "Jalur Dalam Kota", "biaya" => "Rp 15.000", "transport" => "Mobil/Motor", "img" => "https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=800"],
    ["opsi" => "Jalur Lereng Wilis", "biaya" => "Rp 50.000", "transport" => "Mobil/Motor", "img" => "https://images.unsplash.com/photo-1441974231531-c6227db76b6e?q=80&w=800"],
    ["opsi" => "Jalur Dalam Kota", "biaya" => "Rp 15.000", "transport" => "Mobil/Motor", "img" => "https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=800"],
    ["opsi" => "Jalur Lereng Wilis", "biaya" => "Rp 50.000", "transport" => "Mobil/Motor", "img" => "https://images.unsplash.com/photo-1441974231531-c6227db76b6e?q=80&w=800"]
];
$koordinat_destinasi = $estimasi_jalur; // Agar sinkron dengan kode HTML Anda
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MadiunTrack - Jelajahi Keindahan Kota Madiun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { jakarta: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: '#0e7490',    
                        brandDark: '#083344', 
                        accent: '#ea580c',   
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

    <nav class="bg-white/90 backdrop-blur-lg sticky top-0 z-50 py-4 border-b border-slate-200 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-brand rounded-xl shadow-md shadow-brand/30 flex items-center justify-center text-white transition-transform group-hover:scale-105">
                    <i class="bi bi-geo-alt-fill text-lg"></i>
                </div>
                <span class="text-2xl font-black tracking-tight text-brandDark">
                    MADIUN<span class="text-accent">TRACK</span>
                </span>
            </a>
            
            <div class="hidden md:flex gap-8 font-semibold text-sm text-slate-500 items-center">
                <a href="#destinasi" class="hover:text-brand transition-colors">Destinasi</a>
                <a href="#estimasi" class="hover:text-brand transition-colors">Estimasi</a>
            </div>
        </div>
    </nav>

    <header class="relative h-[550px] md:h-[600px] flex flex-col justify-center items-center text-center px-4">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1588666309990-d68f08e3d4a6?q=80&w=1920" class="w-full h-full object-cover" alt="Madiun">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-slate-900/50 to-slate-900/90"></div>
        </div>

        <div class="relative z-10 w-full max-w-3xl mx-auto -mt-10">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight drop-shadow-lg tracking-tight">
                Jelajahi Pesona <br/><span class="text-accent">Kota Madiun</span>
            </h1>
            <p class="text-base md:text-lg text-slate-200 mb-10 font-medium">Temukan destinasi wisata, kuliner legendaris, dan rencanakan perjalanan Anda dengan mudah.</p>
            
            <div class="bg-white p-2 rounded-full flex items-center w-full shadow-2xl transition-all focus-within:ring-4 focus-within:ring-brand/30">
                <div class="flex-1 px-5 flex items-center gap-3 text-slate-400">
                    <i class="bi bi-search text-brand text-lg"></i>
                    <input type="text" id="search-input" placeholder="Ketik destinasi impianmu..." class="w-full outline-none bg-transparent font-medium text-slate-800 placeholder-slate-400">
                </div>
                <button id="btn-cari" class="bg-brand text-white px-8 py-3.5 rounded-full font-bold hover:bg-brandDark transition shadow-md">Cari</button>
            </div>
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php 
            $menu_items = [
                ['href' => 'booking.php', 'icon' => 'bi-house-door', 'title' => 'Penginapan'],
                ['href' => 'beli_tiket.php', 'icon' => 'bi-ticket-perforated', 'title' => 'Beli Tiket'],
                ['href' => '#estimasi', 'icon' => 'bi-map', 'title' => 'Rute Jalan']
            ];
            foreach($menu_items as $item): ?>
            <a href="<?= $item['href'] ?>" class="group relative bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_50px_rgba(14,116,144,0.15)] border border-white/50 hover:border-brand/30 flex flex-col items-center text-center gap-6 transition-all duration-500 hover:-translate-y-3">
                <div class="absolute inset-0 rounded-[2.5rem] bg-gradient-to-br from-brand/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative w-20 h-20 rounded-3xl bg-brand/5 text-brand flex items-center justify-center text-4xl group-hover:scale-110 group-hover:bg-brand group-hover:text-white transition-all duration-500">
                    <i class="bi <?= $item['icon'] ?>"></i>
                </div>
                <h4 class="relative font-black text-lg text-brandDark tracking-wide group-hover:text-brand transition-colors">
                    <?= $item['title'] ?>
                </h4>
            </a>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="destinasi" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-brandDark tracking-tight mb-2">Destinasi Populer</h2>
                <div class="w-16 h-1.5 bg-accent rounded-full"></div>
            </div>
        </div>

        <div class="relative flex items-center">
            <button onclick="scrollSection('destinasi-scroll', 'left')" class="absolute -left-5 z-20 w-12 h-12 rounded-full bg-white shadow-xl border border-slate-100 flex items-center justify-center text-slate-600 hover:bg-brand hover:text-white transition-all hidden md:flex">
                <i class="bi bi-chevron-left text-lg"></i>
            </button>

            <div id="destinasi-scroll" class="flex overflow-x-auto gap-6 pb-4 snap-x snap-mandatory no-scrollbar scroll-smooth w-full">
                <?php foreach ($wisata_madiun as $w): ?>
                <div class="destinasi-card w-[85vw] sm:w-[400px] flex-shrink-0 bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col snap-start group">
                    <div class="relative h-56 overflow-hidden">
                        <img src="<?= htmlspecialchars($w['img']) ?>" alt="<?= htmlspecialchars($w['nama']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                        <div class="absolute top-4 left-4 bg-black/50 backdrop-blur-md text-white px-3 py-1.5 rounded-full text-xs font-bold flex items-center gap-1.5">
                            <i class="bi bi-geo-alt-fill text-accent"></i> <?= htmlspecialchars($w['lokasi']) ?>
                        </div>
                    </div>
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

            <button onclick="scrollSection('destinasi-scroll', 'right')" class="absolute -right-5 z-20 w-12 h-12 rounded-full bg-white shadow-xl border border-slate-100 flex items-center justify-center text-slate-600 hover:bg-brand hover:text-white transition-all hidden md:flex">
                <i class="bi bi-chevron-right text-lg"></i>
            </button>
        </div>
    </section>

    <section id="estimasi" class="bg-brandDark py-24 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
            <div class="mb-14">
                <h2 class="text-3xl md:text-4xl font-extrabold mb-3">Estimasi Perjalanan</h2>
                <p class="text-slate-400 font-medium">Pilih rute perjalanan paling efisien menuju Kota Madiun</p>
            </div>

            <div class="relative flex items-center">
                <button onclick="scrollSection('estimasi-scroll', 'left')" class="absolute -left-5 z-20 w-12 h-12 rounded-full bg-white text-brand shadow-xl border border-slate-100 flex items-center justify-center hover:bg-brand hover:text-white transition-all hidden md:flex">
                    <i class="bi bi-chevron-left text-lg"></i>
                </button>

                <div id="estimasi-scroll" class="flex overflow-x-auto gap-6 pb-6 snap-x snap-mandatory no-scrollbar scroll-smooth w-full">
                    <?php foreach ($estimasi_jalur as $e): ?>
                    <div class="w-[300px] flex-shrink-0 bg-slate-800 rounded-3xl p-6 border border-white/10 shadow-lg snap-start">
                        <img src="<?= htmlspecialchars($e['img'] ?? '') ?>" class="w-full h-40 object-cover rounded-xl mb-4">
                        <h3 class="text-white font-black text-xl mb-2"><?= htmlspecialchars($e['opsi'] ?? 'Rute') ?></h3>
                        <p class="text-accent font-bold mb-4"><?= htmlspecialchars($e['biaya'] ?? '-') ?></p>
                        <div class="text-slate-300 text-sm"><i class="bi bi-car-front-fill"></i> <?= htmlspecialchars($e['transport'] ?? '-') ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <button onclick="scrollSection('estimasi-scroll', 'right')" class="absolute -right-5 z-20 w-12 h-12 rounded-full bg-white text-brand shadow-xl border border-slate-100 flex items-center justify-center hover:bg-brand hover:text-white transition-all hidden md:flex">
                    <i class="bi bi-chevron-right text-lg"></i>
                </button>
            </div>

            <div class="flex justify-center mt-10">
                <a id="btn-cek-rute" href="#" class="bg-accent text-white px-10 py-4 rounded-full flex items-center gap-3 font-bold hover:bg-[#d04b06] transition-all shadow-lg shadow-accent/40">
                    <i class="bi bi-map-fill"></i> Lihat Peta Rute
                </a>
            </div>
        </div>
    </section>

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
                <p class="text-slate-400 text-sm">© 2026 MadiunTrack. All rights reserved.</p>
                <div class="flex gap-4 text-slate-400">
                    <a href="#" class="hover:text-brand"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="hover:text-brand"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="hover:text-brand"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. FUNGSI PENCARIAN & AUTO SCROLL
        const searchInput = document.getElementById('search-input');
        const btnCari = document.getElementById('btn-cari');

        if (searchInput) {
            const filterDestinasi = () => {
                const query = searchInput.value.toLowerCase();
                const cards = document.querySelectorAll('.destinasi-card'); // Mengambil data berdasarkan class
                
                cards.forEach(card => {
                    const titleElement = card.querySelector('h3');
                    if(titleElement) {
                        const title = titleElement.innerText.toLowerCase();
                        card.style.display = title.includes(query) ? "flex" : "none";
                    }
                });
            };

            // Saat pengguna mengetik
            searchInput.addEventListener('input', filterDestinasi);

            // Saat tombol cari ditekan
            if (btnCari) {
                btnCari.addEventListener('click', function(e) {
                    e.preventDefault();
                    filterDestinasi();
                    document.getElementById('destinasi').scrollIntoView({ behavior: 'smooth' });
                });
            }

            // Saat menekan tombol Enter di keyboard
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    filterDestinasi();
                    document.getElementById('destinasi').scrollIntoView({ behavior: 'smooth' });
                }
            });
        }

        // 2. FUNGSI SCROLL KONTROL
        window.scrollSection = function(containerId, direction) {
            const container = document.getElementById(containerId);
            if (!container) return;
            // Secara dinamis menghitung lebar kartu agar akurat baik untuk destinasi maupun estimasi
            const firstCard = container.querySelector('div');
            const cardWidth = firstCard ? (firstCard.offsetWidth + 24) : 324; 
            container.scrollBy({ 
                left: direction === 'left' ? -cardWidth : cardWidth, 
                behavior: 'smooth' 
            });
        };

        // 3. FUNGSI UPDATE TOMBOL RUTE
        const estimasiData = <?= json_encode($estimasi_jalur) ?>;
        const btnCekRute = document.getElementById('btn-cek-rute');

        function setupScrollObserver(containerId) {
            const container = document.getElementById(containerId);
            if (!container) return;

            const updateRouteLink = () => {
                const firstCard = container.querySelector('div');
                const cardWidth = firstCard ? (firstCard.offsetWidth + 24) : 324; 
                const index = Math.round(container.scrollLeft / cardWidth);

                if (btnCekRute && estimasiData[index]) {
                    btnCekRute.href = `peta_rute.php?jalur=${encodeURIComponent(estimasiData[index].opsi)}`;
                }
            };

            // Beri jeda sedikit agar layout selesai dimuat, lalu setel link default
            setTimeout(updateRouteLink, 150);
            
            // Perbarui saat digeser
            container.addEventListener('scroll', updateRouteLink);
        }

        setupScrollObserver('estimasi-scroll');
    });
    </script>
</body>
</html>