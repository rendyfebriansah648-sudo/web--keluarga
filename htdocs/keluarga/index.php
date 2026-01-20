<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REJO MUSEUM | THE ETERNAL LINEAGE</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Montserrat:wght@400;600&family=Roboto+Mono:wght@100;400;700&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        :root {
            --antique-gold: #b38b4d;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            cursor: none !important;
            overflow-x: hidden;
        }

        /* --- STYLES SPLASH SCREEN --- */
        #splash-screen {
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at center, #1a1a1a 0%, #000 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            overflow: hidden;
            transition: opacity 3s cubic-bezier(0.4, 0, 0.2, 1), visibility 3s;
        }

        /* Animasi Khusus untuk Sub-Text Splash Screen */
        .sub-text-anim {
            font-family: 'Roboto Mono', monospace;
            letter-spacing: 12px;
            color: #fff;
            margin-top: 25px;
            text-transform: uppercase;
            font-size: 0.8rem;

            /* Inisialisasi awal untuk animasi */
            opacity: 0;
            transform: translateY(20px);

            /* Menjalankan animasi: nama, durasi, status akhir, delay */
            animation: fadeInUpSub 2.5s forwards ease-out 2s;
        }

        /* Logika Pergerakan */
        @keyframes fadeInUpSub {
            to {
                opacity: 0.6;
                /* Sesuai permintaan Anda di awal */
                transform: translateY(0);
            }
        }

        /* Pastikan Welcome Text juga punya animasi agar sinkron */
        .welcome-text-anim {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 8vw, 4.5rem);
            color: #b38b4d;
            opacity: 0;
            transform: scale(0.9);
            animation: cinematicIn 3s forwards ease-out 0.5s;
        }

        @keyframes cinematicIn {
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(#b38b4d 1px, transparent 1px);
            background-size: 60px 60px;
            filter: blur(1px);
            opacity: 0.15;
            animation: particleMove 35s linear infinite;
        }

        @keyframes particleMove {
            from {
                transform: translateY(0);
            }

            to {
                transform: translateY(-1000px);
            }
        }

        .welcome-text-anim {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 8vw, 4.5rem);
            color: var(--antique-gold);
            text-shadow: 0 0 30px rgba(179, 139, 77, 0.4);
            opacity: 0;
            transform: scale(0.85);
            animation: cinematicIn 4.5s forwards ease-out 1s;
        }

        @keyframes cinematicIn {
            0% {
                opacity: 0;
                transform: scale(0.85);
                filter: blur(15px);
            }

            100% {
                opacity: 1;
                transform: scale(1);
                filter: blur(0);
            }
        }

        .fade-out {
            opacity: 0;
            visibility: hidden;
        }

        /* --- KURSOR FIX --- */
        .cursor-dot,
        .cursor-outline {
            position: fixed;
            top: 0;
            left: 0;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            z-index: 1000000;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .cursor-dot {
            width: 8px;
            height: 8px;
            background: var(--antique-gold);
        }

        .cursor-outline {
            width: 40px;
            height: 40px;
            border: 2px solid var(--antique-gold);
        }

        /* --- REVEAL ANIMATION --- */
        .reveal {
            opacity: 0;
            transform: translateY(40px) scale(0.98);
            filter: blur(10px);
            transition: all 1.2s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }

        /* --- MODAL NOTIFIKASI KUSTOM --- */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(15px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 100000;
            opacity: 0;
            visibility: hidden;
            transition: 0.4s;
        }

        .modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .modal-box {
            background: #111;
            border: 1px solid var(--antique-gold);
            padding: 40px;
            text-align: center;
            max-width: 400px;
            width: 90%;
            transform: scale(0.9);
            transition: 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .modal-overlay.show .modal-box {
            transform: scale(1);
        }

        .modal-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .modal-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .modal-buttons button {
            padding: 12px 25px;
            font-family: 'Roboto Mono';
            font-size: 0.75rem;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: 0.3s;
        }

        .btn-stay {
            background: transparent;
            color: #fff;
            border: 1px solid #444 !important;
        }

        .btn-exit {
            background: var(--antique-gold);
            color: #000;
        }

        /* FOTO LOGIC */
        .grayscale img {
            filter: grayscale(100%);
        }

        .bio-card:hover .grayscale img {
            filter: grayscale(0%);
            transition: 0.8s;
        }

        .dead-card {
            border-left: 4px solid #333 !important;
        }
    </style>
</head>

<body>

    <audio id="click-sound" preload="auto">
        <source src="https://www.soundjay.com/buttons/sounds/button-16.mp3" type="audio/mpeg">
    </audio>

    <div id="splash-screen">
        <div class="particles"></div>
        <div class="welcome-text-anim">Selamat Datang</div>
        <div class="sub-text-anim">KELUARGA MBAH REJO</div>
    </div>

    <div id="exit-modal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon">🏛️</div>
            <h3 style="font-family:'Playfair Display'; color:var(--antique-gold); font-size:1.8rem;">Akhiri Sesi?</h3>
            <p style="font-family:'Roboto Mono'; font-size:0.8rem; color:#ccc;">Apakah Anda yakin ingin keluar dari Museum Digital?</p>
            <div class="modal-buttons">
                <button onclick="closeExitModal()" class="btn-stay">KEMBALI</button>
                <button onclick="processLogout()" class="btn-exit">KELUAR</button>
            </div>
        </div>
    </div>

    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <nav>
        <div class="nav-title">Rejo <span>MUSEUM</span></div>
        <div class="nav-links">
            <a href="keluarga.php" class="logout-btn" style="text-decoration:none; margin-right:20px;">[ PORTAL ]</a>
            <span onclick="confirmLogout()" class="logout-btn" style="cursor:pointer">[ KELUAR ]</span>
        </div>
    </nav>

    <header class="hero">
        <p class="hero-sub reveal">GARIS KETURUNAN & WARISAN</p>
        <h1 class="reveal">Akar yang Kuat,<br>Masa Depan yang Hebat.</h1>
    </header>

    <main class="container">

        <div class="section-label reveal">GENERATION I: THE ANCESTORS</div>

        <article class="bio-card reveal">
            <div class="bio-visual">
                <div class="bio-photo"><img src="image/mbah rejo.jpeg"></div>
                <div class="role-badge">THE PATRIARCH</div>
            </div>
            <div class="bio-details">
                <h2>Kakek REJO</h2>
                <div class="bio-tagline">"Hadir dalam doa, hidup dalam warisan nilai."</div>
                <p class="bio-content">Pilar utama dan akar dari seluruh keturunan. Sosok yang dikenal karena ketegasannya dalam memegang prinsip kejujuran.</p>
                <div class="bio-hobby">Hobi: Berkebun & Membaca Doa</div>
            </div>
        </article>

        <article class="bio-card reveal">
            <div class="bio-visual">
                <div class="bio-photo"><img src="image/mbah tuna.jpeg"></div>
                <div class="role-badge">THE MATRIARCH</div>
            </div>
            <div class="bio-details">
                <h2>Nenek SATUNAH</h2>
                <div class="bio-tagline">"Kasih sayang adalah perekat abadi."</div>
                <p class="bio-content">Ibu besar yang lembut tutur katanya. Doa-doanya menjadi benteng spiritual yang menjaga keutuhan keluarga besar Rejo.</p>
                <div class="bio-hobby">Hobi: Memasak & Merajut Kasih</div>
            </div>
        </article>

        <article class="bio-card reveal">
            <div class="bio-visual">
                <div class="bio-photo"><img src="image/pakdhe man.jpeg"></div>
                <div class="role-badge">THE ELDER</div>
            </div>
            <div class="bio-details">
                <h2>Paman NGATEMAN</h2>
                <p class="bio-content">Sebagai anak tertua, beliau adalah penengah bijaksana dan penjaga tradisi yang dihormati oleh seluruh adik-adiknya.</p>
                <div class="bio-hobby">Hobi: Diskusi & Menikmati Kopi</div>
            </div>
        </article>

        <div class="section-label reveal">GENERATION II: THE GUARDIANS</div>

        <article class="bio-card reveal">
            <div class="bio-visual">
                <div class="bio-photo"><img src="image/pakdhe atem.jpeg"></div>
                <div class="role-badge">THE SUPPORT</div>
            </div>
            <div class="bio-details">
                <h2>PAK DHE ATEM</h2>
                <p class="bio-content">Sosok andalan keluarga, jembatan silaturahmi yang selalu memastikan kehangatan dalam setiap pertemuan keluarga.</p>
                <div class="bio-hobby">Hobi: Olahraga & Otomotif</div>
            </div>
        </article>

        <article class="bio-card reveal">
            <div class="bio-visual">
                <div class="bio-photo"><img src="image/bibi.jpg"></div>
                <div class="role-badge">THE NURTURER</div>
            </div>
            <div class="bio-details">
                <h2>BIBI</h2>
                <p class="bio-content">Wanita tangguh dengan ketulusan hati yang luar biasa, selalu memberikan perhatian besar kepada kebahagiaan para keponakan.</p>
                <div class="bio-hobby">Hobi: Wisata Kuliner</div>
            </div>
        </article>

        <article class="bio-card reveal">
            <div class="bio-visual">
                <div class="bio-photo"><img src="image/ayah.jpg"></div>
                <div class="role-badge">THE GUARDIAN</div>
            </div>
            <div class="bio-details">
                <h2>Ayah MOCH. YULI SAMSUL</h2>
                <p class="bio-content">Mentor kehidupan yang mengajarkan bahwa setiap rintangan harus dihadapi dengan kepala tegak dan hati yang bersih.</p>
                <div class="bio-hobby">Hobi: Membaca & Memperbaiki Barang</div>
            </div>
        </article>

        <article class="bio-card reveal">
            <div class="bio-visual">
                <div class="bio-photo"><img src="image/ibu.jpg"></div>
                <div class="role-badge">THE COMPASS</div>
            </div>
            <div class="bio-details">
                <h2>Ibu SUMIATI</h2>
                <p class="bio-content">Ibu yang penuh kesabaran. Perannya sebagai guru pertama bagi anak-anak sangatlah krusial dalam mendidik budi pekerti.</p>
                <div class="bio-hobby">Hobi: Bercocok Tanam</div>
            </div>
        </article>

        <article class="bio-card reveal">
            <div class="bio-visual">
                <div class="bio-photo"><img src="image/om.jpg"></div>
                <div class="role-badge">THE PROTECTOR</div>
            </div>
            <div class="bio-details">
                <h2>OM</h2>
                <p class="bio-content">Pribadi energik yang selalu mencairkan suasana. Sosok yang selalu membawa semangat baru dalam setiap kebersamaan.</p>
                <div class="bio-hobby">Hobi: Fotografi & Jalan-jalan</div>
            </div>
        </article>

        <article class="bio-card reveal">
            <div class="bio-visual">
                <div class="bio-photo"><img src="image/tante.jpeg"></div>
                <div class="role-badge">THE SYMPATHIZER</div>
            </div>
            <div class="bio-details">
                <h2>TANTE</h2>
                <p class="bio-content">Sosok penyayang dengan empati yang sangat tinggi, memberikan warna kelembutan di tengah keluarga besar.</p>
                <div class="bio-hobby">Hobi: Mendengarkan Musik</div>
            </div>
        </article>

        <div class="section-label reveal">GENERATION III: THE ARCHITECTS</div>

        <article class="bio-card dead-card reveal">
            <div class="bio-visual">
                <div class="bio-photo grayscale"><img src="image/Error Wallpaper - Wallpaper Sun.jpg"></div>
                <div class="role-badge">ETERNAL LIGHT</div>
            </div>
            <div class="bio-details">
                <h2>MAS ARDIANTO</h2>
                <p class="bio-content">Meski raga telah tiada, semangat dan kenangannya tetap abadi di hati kami semua. Doa kami akan selalu mengalir.</p>
                <div class="bio-hobby">Kenangan Abadi</div>
            </div>
        </article>

        <article class="bio-card reveal">
            <div class="bio-visual">
                <div class="bio-photo"><img src="image/mbak.jpg"></div>
                <div class="role-badge">GENTLE SOUL</div>
            </div>
            <div class="bio-details">
                <h2>MBAK</h2>
                <p class="bio-content">Anak sulung yang mandiri dan bertanggung jawab, menjadi inspirasi bagi adik-adiknya untuk terus maju.</p>
                <div class="bio-hobby">Hobi: Desain & Menata Ruang</div>
            </div>
        </article>

        <article class="bio-card reveal">
            <div class="bio-visual">
                <div class="bio-photo"><img src="image/mas.jpg"></div>
                <div class="role-badge">STALWART HEART</div>
            </div>
            <div class="bio-details">
                <h2>MAS</h2>
                <p class="bio-content">Laki-laki tangguh dengan rasa persaudaraan yang luar biasa kuat, pelindung bagi saudara-saudaranya.</p>
                <div class="bio-hobby">Hobi: Gaming & Teknologi</div>
            </div>
        </article>

        <article class="bio-card highlight-card reveal">
            <div class="bio-visual">
                <div class="bio-photo"><img src="image/rens.jpg"></div>
                <div class="role-badge">THE CREATOR</div>
            </div>
            <div class="bio-details">
                <h2>M. RENDY FERBIANSAH</h2>
                <p class="bio-content">Sang pembuat museum digital ini. Mendedikasikan keterampilannya untuk mengabadikan sejarah keluarga.</p>
                <div class="bio-hobby">Hobi: Coding & Audio System</div>
            </div>
        </article>

        <article class="bio-card reveal">
            <div class="bio-visual">
                <div class="bio-photo"><img src="image/gita_.jpeg"></div>
                <div class="role-badge">CREATIVE SPIRIT</div>
            </div>
            <div class="bio-details">
                <h2>RAFAILA GITA SAIDAH</h2>
                <p class="bio-content">Jiwa seni yang kental dan pandangan modern, pembawa warna baru dalam menjaga tradisi keluarga.</p>
                <div class="bio-hobby">Hobi: Seni & Melukis</div>
            </div>
        </article>

        <article class="bio-card reveal">
            <div class="bio-visual">
                <div class="bio-photo"><img src="image/ricky.jpeg"></div>
                <div class="role-badge">BRAVE EXPLORER</div>
            </div>
            <div class="bio-details">
                <h2>RICKY TIRTA RAMADHAN</h2>
                <p class="bio-content">Pemuda penuh semangat dan rasa ingin tahu yang besar, tidak pernah takut untuk mencoba hal baru.</p>
                <div class="bio-hobby">Hobi: Petualangan & Olahraga</div>
            </div>
        </article>

        <article class="bio-card reveal">
            <div class="bio-visual">
                <div class="bio-photo"><img src="image/lisa.jpeg"></div>
                <div class="role-badge">JOYFUL BLOOM</div>
            </div>
            <div class="bio-details">
                <h2>ALYSSA ALFATUNISA (LISA)</h2>
                <p class="bio-content">Anggota termuda pembawa tawa. Kebahagiaan kecil yang selalu mencerahkan hari-hari keluarga.</p>
                <div class="bio-hobby">Hobi: Bermain & Bernyanyi</div>
            </div>
        </article>

        <section class="memory-gate reveal">
            <div class="memory-content">
                <h2>Saksi Bisu Rumah Kenangan</h2><a href="gallery.php" class="memory-btn">EKSPLORASI GALERI</a>
            </div>
            <div class="memory-preview"><img src="image-kenangan/rumah.jpg"></div>
        </section>

    </main>

    <script>
        // Sesi
        if (!sessionStorage.getItem("rejo_auth")) {
            window.location.href = "login.php";
        }

        // Logout Modal
        const clickSnd = document.getElementById('click-sound');

        function confirmLogout() {
            clickSnd.play().catch(() => {});
            document.getElementById('exit-modal').classList.add('show');
        }

        function closeExitModal() {
            document.getElementById('exit-modal').classList.remove('show');
        }

        function processLogout() {
            sessionStorage.clear();
            window.location.href = "login.php";
        }

        // Splash & Scroll
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('splash-screen').classList.add('fade-out');
            }, 4000);
        });
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) e.target.classList.add('active');
            });
        }, {
            threshold: 0.1
        });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Kursor Smooth
        const dot = document.querySelector(".cursor-dot");
        const out = document.querySelector(".cursor-outline");
        window.addEventListener("mousemove", (e) => {
            dot.style.opacity = "1";
            out.style.opacity = "1";
            dot.style.left = e.clientX + "px";
            dot.style.top = e.clientY + "px";
            out.animate({
                left: e.clientX + "px",
                top: e.clientY + "px"
            }, {
                duration: 500,
                fill: "forwards"
            });
        });
    </script>
</body>

</html>