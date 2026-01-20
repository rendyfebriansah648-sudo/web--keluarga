<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KELUARGA | REJO MUSEUM</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto+Mono:wght@300;400&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #0a0a0a;
            color: white;
            font-family: 'Roboto Mono', monospace;
            min-height: 100vh;
            overflow-x: hidden;
            cursor: none;
            display: flex;
            flex-direction: column;
        }
        
        nav {
            width: 100%;
            background: rgba(0, 0, 0, .85);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
        }
        
        nav .title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: #b38b4d;
            letter-spacing: 2px;
        }
        
        nav .menu-btn {
            cursor: pointer;
            color: #ccc;
            font-size: 1.1rem;
            transition: .3s;
        }
        
        nav .menu-btn:hover {
            color: #fff;
        }
        
        main {
            margin-top: 70px;
            padding: 20px;
            flex: 1;
            animation: fadeIn 1.4s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px) }
            to { opacity: 1; transform: none }
        }
        
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 6vw, 3rem);
            color: #b38b4d;
            text-align: center;
            margin-bottom: 20px;
        }
        
        h2 {
            color: #b38b4d;
            text-align: center;
            margin: 10px 0;
        }
        
        p {
            font-size: clamp(.9rem, 3vw, 1rem);
            color: #ccc;
            margin-bottom: 20px;
            line-height: 1.5;
            text-align: center;
        }
        
        .btn-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 28px;
            background: #b38b4d;
            color: #000;
            font-weight: bold;
            text-decoration: none;
            font-size: clamp(.8rem, 3vw, 1rem);
            letter-spacing: 1px;
            border-radius: 5px;
            transition: .3s ease, transform .3s ease;
            margin: 6px;
            cursor: none;
            border: none;
        }
        
        .btn-link:hover {
            background: #8e6d3a;
            transform: scale(1.05);
        }
        
        .sub-nav {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            margin-top: 20px;
        }
        
        /* MODAL STYLES */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(8px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 100000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .modal-overlay.active {
            display: flex;
            opacity: 1;
        }
        
        .modal-card {
            background: #111;
            border: 1px solid #b38b4d;
            padding: 30px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        
        .modal-card h3 {
            font-family: 'Playfair Display', serif;
            color: #b38b4d;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }
        
        .modal-card p {
            font-size: 0.9rem;
            margin-bottom: 25px;
        }
        
        .modal-btns {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        
        .modal-btn {
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: none;
            transition: 0.3s;
            border: none;
            font-family: 'Roboto Mono', monospace;
        }
        
        .btn-confirm { background: #b38b4d; color: #000; }
        .btn-cancel { background: transparent; color: #fff; border: 1px solid #444; }
        
        .modal-btn:hover { transform: scale(1.05); }

        /* CURSOR */
        .cursor-dot, .cursor-outline {
            position: fixed; top: 0; left: 0; border-radius: 50%;
            pointer-events: none; z-index: 1000000; transition: opacity .2s;
        }
        .cursor-dot { width: 6px; height: 6px; background: #b38b4d; }
        .cursor-outline { width: 40px; height: 40px; border: 1px solid rgba(179, 139, 77, .5); }

        #toast {
            position: fixed; bottom: 20px; right: 20px;
            background: rgba(179, 139, 77, 0.95); color: #000;
            padding: 12px 22px; border-radius: 8px; opacity: 0;
            pointer-events: none; transition: 0.5s; z-index: 10003;
        }
        #toast.show { opacity: 1; transform: translateY(-10px); }
        
        #creator {
            display: flex; flex-direction: column; align-items: center; margin-top: 30px;
        }
        #creator img {
            width: 120px; height: 120px; border-radius: 50%;
            border: 2px solid #b38b4d; margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <div class="modal-overlay" id="confirmModal">
        <div class="modal-card">
            <h3 id="modalTitle">Konfirmasi</h3>
            <p id="modalMsg">Apakah anda yakin ingin melanjutkan?</p>
            <div class="modal-btns">
                <button class="modal-btn btn-cancel" onclick="closeModal()">Batal</button>
                <button class="modal-btn btn-confirm" id="confirmBtn">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>

    <nav>
        <div class="title">REJO MUSEUM PORTAL</div>
        <div>
            <span class="menu-btn" onclick="triggerAction('home')"><i class="fa-solid fa-house"></i> Home</span> &nbsp;|&nbsp;
            <span class="menu-btn" onclick="triggerAction('logout')"><i class="fa-solid fa-right-from-bracket"></i> Logout</span>
        </div>
    </nav>

    <main>
        <h1 id="welcomeText">Selamat Datang di Web Keluarga Mbah Rejo</h1>
        <h2 id="userName"></h2>
        <p>Pilih bagian yang ingin kamu kunjungi dari museum digital keluarga besar Rejo:</p>

        <div class="sub-nav">
            <button class="btn-link" onclick="triggerAction('link', 'index.php')"><i class="fa-solid fa-landmark"></i> Museum Utama</button>
            <button class="btn-link" onclick="triggerAction('link', 'gallery.php')"><i class="fa-solid fa-image"></i> Galeri Foto</button>
            <button class="btn-link" onclick="triggerAction('link', 'timeline.php')"><i class="fa-solid fa-clock-rotate-left"></i> Timeline</button>
            <button class="btn-link" onclick="triggerAction('link', 'archives.php')"><i class="fa-solid fa-folder-open"></i> Arsip</button>
            <button class="btn-link" onclick="triggerAction('link', 'video.php')"><i class="fa-solid fa-video"></i> Video Kenangan</button>
        </div>

        <div id="creator">
            <img src="image/rens.jpg" alt="Foto Pembuat">
            <p>Dibuat oleh: <strong>RENDY FERBIANSAH</strong></p>
        </div>
    </main>

    <div id="toast"></div>

    <audio id="clickSound">
        <source src="https://www.soundjay.com/buttons/sounds/button-16.mp3" type="audio/mpeg">
    </audio>

    <script>
        /* Session Check */
        if (!sessionStorage.getItem("rejo_auth")) {
            location.replace("login.php");
        }
        const userName = sessionStorage.getItem("user_name");
        document.getElementById("userName").innerText = userName ? "Halo, " + userName + "!" : "";

        /* Modal Logic */
        const modal = document.getElementById('confirmModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalMsg = document.getElementById('modalMsg');
        const confirmBtn = document.getElementById('confirmBtn');

        function triggerAction(type, target) {
            playClick();
            modal.classList.add('active');
            
            if (type === 'logout') {
                modalTitle.innerText = "Keluar Sesi";
                modalMsg.innerText = "Apakah anda yakin ingin mengakhiri sesi ini?";
                confirmBtn.onclick = () => { logout(); };
            } else if (type === 'home') {
                modalTitle.innerText = "Kembali ke Beranda";
                modalMsg.innerText = "Kembali ke halaman utama portal?";
                confirmBtn.onclick = () => { location.href = "keluarga.php"; };
            } else {
                modalTitle.innerText = "Masuk Museum";
                modalMsg.innerText = "Buka halaman kenangan ini?";
                confirmBtn.onclick = () => { location.href = target; };
            }
        }

        function closeModal() {
            playClick();
            modal.classList.remove('active');
        }

        /* Cursor */
        if (window.matchMedia("(pointer:fine)").matches) {
            const dot = document.querySelector('.cursor-dot'),
                  out = document.querySelector('.cursor-outline');
            let mx = 0, my = 0, ox = 0, oy = 0;
            document.addEventListener('mousemove', e => {
                mx = e.clientX; my = e.clientY;
            });

            function anim() {
                ox += (mx - ox) * 0.2;
                oy += (my - oy) * 0.2;
                dot.style.transform = `translate(${mx-3}px,${my-3}px)`;
                out.style.transform = `translate(${ox-20}px,${oy-20}px)`;
                requestAnimationFrame(anim);
            }
            anim();
        }

        function playClick() {
            const snd = document.getElementById('clickSound');
            snd.currentTime = 0; snd.volume = 0.25;
            snd.play().catch(() => {});
        }

        function showToast(msg) {
            const t = document.getElementById('toast');
            t.innerText = msg;
            t.classList.add('show');
            setTimeout(() => { t.classList.remove('show'); }, 2500);
        }

        function logout() {
            sessionStorage.clear();
            showToast("Logout Berhasil");
            setTimeout(() => location.replace("login.php"), 800);
        }
    </script>
</body>
</html>