<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BromoTrack - Sistem Tracking Wisata Terpadu</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { jakarta: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brandDark: '#0f172a',    /* Biru Navy */
                        brandAccent: '#E8621A',  /* Oranye Bromo */
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-brandDark text-white h-screen flex flex-col overflow-hidden relative">

    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1590060931165-8b63e800a7fa?q=80&w=1920&auto=format&fit=crop" 
             class="w-full h-full object-cover opacity-20 grayscale" alt="Gunung Bromo">
        <div class="absolute inset-0 bg-gradient-to-b from-brandDark/80 via-brandDark/60 to-brandDark"></div>
    </div>

    <header class="relative z-10 w-full p-6 md:px-12 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <i class="bi bi-geo-alt-fill text-brandAccent text-2xl"></i>
            <h2 class="text-white text-xl font-extrabold italic leading-tight uppercase tracking-tighter">
                Bromo<span class="text-brandAccent">Track</span>
            </h2>
        </div>
        <div class="hidden md:block">
            <span class="px-3 py-1 bg-white/10 border border-white/20 rounded-full text-[9px] font-black uppercase tracking-[0.2em]">
                System V.1.0
            </span>
        </div>
    </header>

    <main class="relative z-10 flex-1 flex flex-col justify-center items-center text-center px-6">
        
        <p class="text-brandAccent text-[10px] md:text-xs font-black uppercase tracking-[0.3em] mb-4 md:mb-6 flex items-center gap-2">
            <span class="w-8 h-[2px] bg-brandAccent"></span> Access Control System <span class="w-8 h-[2px] bg-brandAccent"></span>
        </p>
        
        <h1 class="text-5xl md:text-7xl font-black italic uppercase tracking-tighter leading-none mb-6">
            Start Your <br />
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-500">Journey Here</span>
        </h1>
        
        <p class="text-slate-400 text-xs md:text-sm font-semibold max-w-lg mb-12 leading-relaxed">
            Sistem tracking wisata terpadu untuk pendataan, keamanan, dan pengalaman eksplorasi yang lebih baik di kawasan Taman Nasional Bromo Tengger Semeru.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 w-full max-w-md justify-center">
            
            <a href="login.php" 
               class="w-full sm:w-auto bg-brandAccent hover:bg-orange-700 text-white font-black py-4 px-8 rounded-xl text-[10px] tracking-[0.2em] uppercase italic transition-all flex items-center justify-center gap-2 shadow-[0_0_20px_rgba(232,98,26,0.3)] hover:-translate-y-1">
                Sign In <i class="bi bi-box-arrow-in-right text-lg"></i>
            </a>

            <a href="register.php" 
               class="w-full sm:w-auto bg-transparent border-2 border-slate-600 hover:border-white text-slate-300 hover:text-white font-black py-4 px-8 rounded-xl text-[10px] tracking-[0.2em] uppercase italic transition-all flex items-center justify-center gap-2 hover:-translate-y-1">
                <i class="bi bi-person-plus-fill"></i> Register
            </a>
            
        </div>
    </main>

    <footer class="relative z-10 w-full p-6 text-center">
        <p class="text-slate-500 text-[9px] font-bold uppercase tracking-widest italic">
            &copy; 2026 BromoTrack Integrated System
        </p>
    </footer>

</body>
</html>