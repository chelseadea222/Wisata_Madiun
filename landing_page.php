<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MadiunTrack - Jelajahi Pesona Kota Gadis</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { jakarta: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: '#f59e0b', /* amber-500 */
                        brandDark: '#0f172a', /* slate-900 */
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        
        /* Animasi Mengambang Halus */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delay { animation: float 6s ease-in-out infinite; animation-delay: 2s; }
        .animate-float-fast { animation: float 4s ease-in-out infinite; animation-delay: 1s; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 selection:bg-brand selection:text-white flex flex-col min-h-screen">

    <nav class="w-full h-20 px-6 md:px-12 lg:px-20 flex justify-between items-center bg-white/80 backdrop-blur-lg fixed top-0 z-50 border-b border-slate-200/60 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-brand flex items-center justify-center shadow-lg shadow-brand/30 text-white">
                <i class="bi bi-geo-alt-fill text-xl"></i>
            </div>
            <h2 class="text-brandDark text-2xl font-black tracking-tight">
                Madiun<span class="text-brand">Track</span>
            </h2>
        </div>
        
        <div class="hidden md:flex items-center gap-8">
            <a href="#" class="text-sm font-bold text-brand relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-1/2 after:h-[2px] after:bg-brand">Beranda</a>
            <a href="login.php" class="bg-brandDark hover:bg-slate-800 text-white text-sm font-bold px-7 py-2.5 rounded-full transition-all shadow-md active:scale-95">Sign In</a>
        </div>
    </nav>

    <main class="flex-1 flex items-center pt-20">
        <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 lg:px-20 py-12 flex flex-col-reverse lg:flex-row items-center gap-12 lg:gap-8 min-h-[calc(100vh-5rem)]">
            
            <div class="w-full lg:w-5/12 flex flex-col justify-center text-center lg:text-left z-10">
                
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-orange-100 border border-orange-200 mx-auto lg:mx-0 w-fit mb-6">
                    <span class="text-brand"><i class="bi bi-geo-fill"></i></span>
                    <span class="text-[10px] sm:text-xs font-black uppercase tracking-widest text-orange-800">Pesona Kota Pendekar</span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-[4rem] font-black tracking-tighter leading-[1.1] mb-6 text-brandDark">
                    Jelajahi <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand to-orange-500">Madiun</span> <br class="hidden lg:block"/>
                    Lebih Mudah.
                </h1>
                
                <p class="text-slate-500 text-sm md:text-base font-medium mb-10 leading-relaxed max-w-lg mx-auto lg:mx-0">
Jelajahi banyaknya pesona wisata Madiun dengan lebih praktis. Akses e-tiket, booking penginapan, serta panduan rute cerdas kini bisa kamu nikmati cukup dari satu layar.                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 w-full justify-center lg:justify-start">
                    <a href="beli_tiket.php" class="bg-brand hover:bg-amber-600 text-white font-bold py-4 px-8 rounded-2xl text-sm transition-all flex items-center justify-center gap-3 shadow-xl shadow-brand/30 active:scale-95 group">
                        <span>Pesan Tiket</span>
                        <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="peta_rute.php" class="bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold py-4 px-8 rounded-2xl text-sm transition-all flex items-center justify-center gap-3 shadow-sm active:scale-95">
                        <i class="bi bi-map-fill text-brand"></i> Cek Rute Wisata
                    </a>
                </div>
                
            </div>

            <div class="w-full lg:w-7/12 relative h-[450px] lg:h-[650px] flex items-center justify-center lg:justify-end mt-4 lg:mt-0">
                
                <div class="absolute w-[300px] h-[300px] lg:w-[500px] lg:h-[500px] bg-brand/20 rounded-full blur-3xl lg:right-10 z-0 animate-pulse"></div>

                <div class="relative z-10 w-[90%] lg:w-[85%] h-[85%] lg:h-[90%] rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white animate-float">
                    <img src="https://www.shutterstock.com/image-photo/tugu-selamat-datang-kota-madiun-260nw-2554572911.jpg" class="w-full h-full object-cover" alt="Wisata Alam Madiun">
                    <div class="absolute inset-0 bg-gradient-to-t from-brandDark/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 lg:bottom-10 lg:left-10 text-white">
                        <h3 class="font-black text-2xl lg:text-3xl flex items-center gap-2">
                            <i class="bi bi-geo-alt-fill text-brand"></i> Kota Madiun
                        </h3>
                        <p class="text-sm text-slate-300 font-medium mt-1">Madiun Pesona Kota Gadis, Ketangguhan Kota Pendekar</p>
                    </div>
                </div>

                </div>

            </div>

        </div>
    </main>

</body>
</html>