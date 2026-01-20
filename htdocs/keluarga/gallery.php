<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEMORY ARCHIVE | THE ETERNAL LINEAGE</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Montserrat:wght@400;600&family=Roboto+Mono:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        :root {
            --antique-gold: #b38b4d;
            --bg-dark: #0a0a0a;
        }

        body {
            background-color: var(--bg-dark);
            color: #fff;
            margin: 0;
            cursor: none !important; /* Sembunyikan kursor asli */
            overflow-x: hidden;
        }

        /* --- STYLING KURSOR EMAS --- */
        .cursor-dot, .cursor-outline {
            position: fixed;
            top: 0;
            left: 0;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            z-index: 10001; 
            pointer-events: none; 
            opacity: 0; /* Muncul saat mouse bergerak */
            transition: opacity 0.3s ease, width 0.3s, height 0.3s, background-color 0.3s;
        }
        .cursor-dot {
            width: 8px;
            height: 8px;
            background-color: var(--antique-gold);
        }
        .cursor-outline {
            width: 40px;
            height: 40px;
            border: 2px solid var(--antique-gold);
        }

        /* --- SPLASH SCREEN --- */
        #splash-screen {
            position: fixed;
            inset: 0;
            background-color: var(--bg-dark);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 1s ease, visibility 1s;
        }
        .welcome-text {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 8vw, 3rem);
            color: var(--antique-gold);
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1.5s forwards 0.5s;
        }
        .welcome-sub {
            font-family: 'Roboto Mono', monospace;
            font-size: 0.7rem;
            letter-spacing: 5px;
            color: #fff;
            margin-top: 15px;
            opacity: 0;
            animation: fadeInUp 1.5s forwards 1s;
        }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
        .fade-out { opacity: 0; visibility: hidden; }

        /* --- MODAL NOTIFIKASI KUSTOM --- */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .modal-overlay.show { opacity: 1; visibility: visible; }
        .modal-box {
            background: #111;
            border: 1px solid var(--antique-gold);
            padding: 40px;
            text-align: center;
            max-width: 400px;
            width: 90%;
            transform: scale(0.8);
            transition: 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .modal-overlay.show .modal-box { transform: scale(1); }
        .modal-box h3 { font-family: 'Playfair Display', serif; color: var(--antique-gold); margin-bottom: 10px; }
        .modal-box p { font-family: 'Roboto Mono', monospace; font-size: 0.8rem; color: #ccc; margin-bottom: 30px; }
        .modal-buttons { display: flex; gap: 15px; justify-content: center; }
        .btn-stay, .btn-exit { padding: 12px 20px; font-family: 'Roboto Mono', monospace; font-size: 0.7rem; cursor: pointer; border: none; transition: 0.3s; }
        .btn-stay { background: transparent; color: #fff; border: 1px solid #444 !important; }
        .btn-exit { background: var(--antique-gold); color: #000; font-weight: bold; }

        /* --- NAVIGASI --- */
        nav {
            background: rgba(10, 10, 10, 0.95);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
        }

        /* --- GALLERY GRID --- */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            padding: 40px 5%;
        }
        .gallery-item {
            position: relative;
            height: 400px;
            overflow: hidden;
            border: 1px solid rgba(179, 139, 77, 0.2);
            background: #111;
        }
        .js-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .js-reveal.appear { opacity: 1; transform: translateY(0); }
        .gallery-item img {
            width: 100%; height: 100%;
            object-fit: cover;
            filter: grayscale(80%);
            transition: 1s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .gallery-item:hover img { filter: grayscale(0%); transform: scale(1.1); }
        .photo-caption {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            padding: 30px 20px 20px;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.9));
            font-family: 'Roboto Mono', monospace;
            font-size: 0.7rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            body { cursor: auto !important; }
            .gallery-grid { grid-template-columns: 1fr; }
            .cursor-dot, .cursor-outline { display: none; }
        }
    </style>
</head>

<body>
    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <audio id="click-sound" preload="auto">
        <source src="https://www.soundjay.com/buttons/sounds/button-16.mp3" type="audio/mpeg">
    </audio>

    <div id="splash-screen">
        <div class="welcome-text">Memory Archive</div>
        <div class="welcome-sub">MENGINGAT SETIAP MOMEN</div>
    </div>

    <div id="exit-modal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon" style="font-size:3rem; margin-bottom:15px;">🏛️</div>
            <h3>Keluar dari Galeri?</h3>
            <p>Pastikan Anda sudah melihat semua kenangan.</p>
            <div class="modal-buttons">
                <button onclick="closeExitModal()" class="btn-stay">KEMBALI</button>
                <button id="confirm-exit-btn" class="btn-exit">IYA, KELUAR</button>
            </div>
        </div>
    </div>

    <nav>
        <div class="nav-title" style="font-family:'Playfair Display'; font-weight:900;">Mbah Rejo <span style="color:var(--antique-gold); font-style:italic; font-weight:400;">ARCHIVE</span></div>
        <a href="javascript:void(0)" onclick="confirmExit('index.php')" class="logout-btn" style="color:var(--antique-gold); text-decoration:none; font-family:'Roboto Mono'; border:1px solid var(--antique-gold); padding:5px 15px;">BACK</a>
    </nav>

    <header style="padding: 80px 5% 40px; text-align: center;">
        <p style="font-family:'Roboto Mono'; letter-spacing:4px; font-size:0.7rem; color:var(--antique-gold);">PRIVATE COLLECTION</p>
        <h1 style="font-family:'Playfair Display'; font-size:clamp(2rem, 8vw, 3.5rem); color:var(--antique-gold); margin:0;">Galeri Kenangan</h1>
    </header>

    <main>
        <div class="gallery-grid">
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/rumah.jpg" alt="Memory" loading="lazy">
                <div class="photo-caption">TEMPAT RUMAH KELUARGA TERBENTUK</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/mbah rejo.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">PENEMUAN FOTO MBAH REJO</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/WhatsApp Image 2026-01-05 at 18.55.34.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">MBAH TUNA DI TAMAN RUMAH</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/kenangan dapat kompresor.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">KENANGAN SAAT DAPAT KOMPRESOR</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/kenangan di makam ziarah.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">KENANGAN SAAT DI MAKAM ZIARAH</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/kenangan foto bersama saat ikut gerak jalan.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">KENANGAN SAAT IKUT GERAK JALAN</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/kenangan gita wisuda.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">KENANGAN SAAT GITA WISUDA</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/kenangan lisa gita firja.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">KENANGAN SAAT BERMAIN BERSAMA</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/kenangan makan bersama.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">KENANGAN SAAT MAKAN-MAKAN BERSAMA</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/kenangan makan gita saat kecil.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">KENANGAN SAAT GITA MASIH KECIL</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/kenangan mas firja wisuda.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">KENANGAN SAAT FIRJA WISUDA</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/kenangan mas firja.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">KENANGAN SAAT FIRJA COSPLAY</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/kenangan mbah tuna liburan.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">KENANGAN SAAT MBAH TUNA JALAN-JALAN</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/kenangan mbah.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">KENANGAN SAAT MBAH PAKDHE MAN GITA MAKAN BERSAMA</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/kenangan pakdhe man ziarah.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">KENANGAN SAAT PAKDHE MAN ZIARAH KE MAKAM GUSDUR</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/kenangan ricky sunat.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">KENANGAN SAAT RICKY SUNAT</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/kenangan saat gita belajar sepeda.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">KENANGAN SAAT GITA BELAJAR NAIK SEPEDA</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/kenangan saat baru beli laptop.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">KENANGAN SAAT BARU BELI LAPTOP</div>
            </div>
            <div class="gallery-item js-reveal">
                <img src="image-kenangan/kenangan saat gita menggambar.jpeg" alt="Memory" loading="lazy">
                <div class="photo-caption">KENANGAN SAAT GITA BELAJAR MENGGAMBAR</div>
            </div>
        </div>
    </main>

    <div style="text-align:center; margin: 60px auto;">
        <a href="javascript:void(0)" onclick="confirmExit('keluarga.php')" style="color:var(--antique-gold); text-decoration:none; font-family:'Roboto Mono'; font-size:0.8rem; letter-spacing:2px;">← KEMBALI KE HALAMAN KELUARGA</a>
    </div>

    <script>
        /* PROTEKSI SESI */
        if (!sessionStorage.getItem("rejo_auth")) { window.location.href = "login.php"; }

        const clickSnd = document.getElementById('click-sound');
        let exitUrl = "";

        // Fungsi Notifikasi Modal
        function confirmExit(url) {
            clickSnd.play().catch(()=>{});
            exitUrl = url;
            document.getElementById('exit-modal').classList.add('show');
        }
        function closeExitModal() { document.getElementById('exit-modal').classList.remove('show'); }
        document.getElementById('confirm-exit-btn').onclick = () => window.location.href = exitUrl;

        // Splash Screen
        window.addEventListener('load', () => {
            setTimeout(() => document.getElementById('splash-screen').classList.add('fade-out'), 2500);
        });

        // Reveal Animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('appear'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.js-reveal').forEach(el => observer.observe(el));

        // STABLE CURSOR LOGIC
        const dot = document.querySelector(".cursor-dot");
        const outline = document.querySelector(".cursor-outline");

        if (dot && outline) {
            window.addEventListener("mousemove", (e) => {
                const x = e.clientX;
                const y = e.clientY;
                dot.style.left = `${x}px`;
                dot.style.top = `${y}px`;
                dot.style.opacity = "1";
                outline.animate({ left: `${x}px`, top: `${y}px` }, { duration: 400, fill: "forwards" });
                outline.style.opacity = "1";
            });
        }

        const hoverables = document.querySelectorAll('a, button, .gallery-item');
        hoverables.forEach(item => {
            item.addEventListener('mouseenter', () => {
                outline.style.width = "65px"; outline.style.height = "65px";
                outline.style.backgroundColor = "rgba(179, 139, 77, 0.1)";
            });
            item.addEventListener('mouseleave', () => {
                outline.style.width = "40px"; outline.style.height = "40px";
                outline.style.backgroundColor = "transparent";
            });
        });
    </script>
</body>
</html>