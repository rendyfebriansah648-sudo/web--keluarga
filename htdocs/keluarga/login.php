<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN | REJO MUSEUM</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto+Mono:wght@300;400&display=swap" rel="stylesheet">
    <style>
        /* GENERAL */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0a0a0a; height: 100vh; overflow: hidden; font-family: 'Roboto Mono', monospace; color: white; cursor: none; }
        
        /* CUSTOM CURSOR */
        .cursor-dot, .cursor-outline { position: fixed; top: 0; left: 0; border-radius: 50%; pointer-events: none; z-index: 10000; transition: opacity .2s; }
        .cursor-dot { width: 6px; height: 6px; background: #b38b4d; z-index: 10001; }
        .cursor-outline { width: 40px; height: 40px; border: 1px solid rgba(179, 139, 77, .5); }

        /* SPLASH SCREEN */
        #splash-screen { position: fixed; inset: 0; background: #000; display: flex; justify-content: center; align-items: center; z-index: 9999; transition: opacity 2.5s ease, visibility 2.5s; }
        .welcome-text { font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 6vw, 2.6rem); color: #b38b4d; opacity: 0; animation: splashIn 3s forwards 1s; }
        @keyframes splashIn { to { opacity: 1; transform: scale(1); } }
        .fade-out { opacity: 0; visibility: hidden; }

        /* LOGIN BOX */
        .login-container { height: 100vh; display: flex; justify-content: center; align-items: center; padding: 20px; }
        .login-box { background: #111; padding: clamp(30px, 6vw, 50px) clamp(20px, 5vw, 40px); border: 1px solid rgba(179, 139, 77, .3); text-align: center; width: 100%; max-width: 420px; animation: loginFade 1.6s cubic-bezier(.22, 1, .36, 1); }
        @keyframes loginFade { from { opacity: 0; transform: translateY(30px) scale(.98); filter: blur(8px); } to { opacity: 1; transform: none; filter: none; } }
        
        input { width: 100%; padding: 15px; margin: 10px 0; background: #000; border: 1px solid #333; color: white; text-align: center; font-size: clamp(.85rem, 3vw, .95rem); outline: none; transition: .4s; }
        input:focus { border-color: #b38b4d; }
        button { width: 100%; padding: 15px; background: #b38b4d; border: none; color: #000; font-weight: bold; letter-spacing: 2px; font-size: clamp(.75rem, 3vw, .9rem); transition: .4s cubic-bezier(.22, 1, .36, 1); cursor: pointer; }
        button:hover { background: #8e6d3a; }
        #errorMessage { color: #ff4d4d; font-size: 11px; margin-top: 15px; }

        /* ANIMATIONS */
        @keyframes softShake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-4px); } 50% { transform: translateX(4px); } 75% { transform: translateX(-2px); } }
        .login-box.shake { animation: softShake .45s; }
        @keyframes unlockGlow { 50% { box-shadow: 0 0 40px rgba(179, 139, 77, .6); transform: scale(1.03); } 100% { opacity: 0; transform: scale(.95); } }
        .login-box.unlock { animation: unlockGlow 1.8s cubic-bezier(.22, 1, .36, 1) forwards; }

        /* ACCESS LOADING */
        #access-loading { position: fixed; inset: 0; background: #000; display: flex; justify-content: center; align-items: center; flex-direction: column; opacity: 0; pointer-events: none; transition: opacity 1s ease; z-index: 9998; }
        #access-loading.show { opacity: 1; }
        .scan-line { position: absolute; width: 100%; height: 2px; background: linear-gradient(to right, transparent, #b38b4d, transparent); animation: scan 2.5s linear infinite; }
        @keyframes scan { from { top: 0; } to { top: 100%; } }
        .access-text { letter-spacing: 6px; color: #b38b4d; margin-top: 20px; font-size: clamp(.7rem, 3vw, .9rem); }

        /* BIOMETRIC MODAL */
        #biometric-modal { position: fixed; inset: 0; background: rgba(0, 0, 0, .85); display: flex; justify-content: center; align-items: center; opacity: 0; visibility: hidden; transition: .8s; z-index: 10002; }
        #biometric-modal.show { opacity: 1; visibility: visible; }
        .biometric-box { background: #111; padding: 25px; text-align: center; border: 1px solid #b38b4d; width: 80%; max-width: 300px; }
        .biometric-icon { font-size: 4rem; color: #b38b4d; margin-bottom: 10px; animation: biometricPulse 1.4s infinite ease-in-out; }
        @keyframes biometricPulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.15); } }

        /* TOAST */
        .toast-container { position: fixed; bottom: 20px; right: 20px; z-index: 11000; display: flex; flex-direction: column; gap: 10px; }
        .toast { background: rgba(179, 139, 77, 0.9); color: #000; padding: 12px 20px; border-radius: 6px; font-weight: bold; animation: toastInOut 3s forwards; }
        @keyframes toastInOut { 0% { opacity: 0; transform: translateX(100%); } 10%, 80% { opacity: 1; transform: translateX(0); } 100% { opacity: 0; transform: translateX(100%); } }
        
        .grain { position: fixed; inset: 0; pointer-events: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.04'/%3E%3C/svg%3E"); z-index: 9997; }
    </style>
</head>

<body>
    <div id="splash-screen"><div class="welcome-text">The Eternal Lineage</div></div>
    <div class="grain"></div>
    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <div class="login-container">
        <div class="login-box">
            <h2 style="font-family:Playfair Display;color:#b38b4d;letter-spacing:3px">AUTHENTICATION</h2>
            <p style="color:#666;font-size:10px;margin:10px 0 20px">RESTRICTED ARCHIVE ACCESS</p>
            <input type="text" id="nameInput" placeholder="MASUKKAN NAMA">
            <input type="password" id="passInput" placeholder="KODE KELUARGA">
            <button onclick="checkPass()">ENTER ARCHIVE</button>
            <p id="errorMessage"></p>
        </div>
    </div>

    <div id="access-loading">
        <div class="scan-line"></div>
        <div class="access-text">ACCESS GRANTED</div>
    </div>

    <div id="biometric-modal">
        <div class="biometric-box">
            <div class="biometric-icon">🔒</div>
            <div class="biometric-text">Verifikasi Biometrik</div>
            <div class="biometric-text" style="font-size:.85rem;color:#bbb;">Sentuh sensor untuk melanjutkan</div>
            <button onclick="acceptBiometric()" style="margin-top:15px;padding:10px 20px;background:#b38b4d;border:none;color:#000;font-weight:bold;letter-spacing:1px;cursor:pointer;">Scan Sekarang</button>
        </div>
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <audio id="loginSound" preload="auto">
        <source src="https://www.orangefreesounds.com/wp-content/uploads/2020/04/Login-sound.mp3" type="audio/mpeg">
    </audio>

    <script>
        let locked = false;
        let biometricPassed = false;

        // ANTI BACK
        history.pushState(null, "", location.href)
        window.onpopstate = () => history.pushState(null, "", location.href)

        // SPLASH
        window.addEventListener('load', () => {
            setTimeout(() => document.getElementById('splash-screen').classList.add('fade-out'), 2500)
        })

        // CURSOR
        if (window.matchMedia("(pointer:fine)").matches) {
            const dot = document.querySelector('.cursor-dot'),
                  out = document.querySelector('.cursor-outline');
            let mx = 0, my = 0, ox = 0, oy = 0;
            document.addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY });
            function anim() {
                ox += (mx - ox) * 0.2; oy += (my - oy) * 0.2;
                dot.style.transform = `translate(${mx-3}px,${my-3}px)`;
                out.style.transform = `translate(${ox-20}px,${oy-20}px)`;
                requestAnimationFrame(anim);
            }
            anim();
        }

        function showBiometric() { document.getElementById('biometric-modal').classList.add('show'); }
        function acceptBiometric() { biometricPassed = true; document.getElementById('biometric-modal').classList.remove('show'); }

        function showToast(msg) {
            const t = document.createElement('div');
            t.className = 'toast'; t.innerText = msg;
            document.getElementById('toastContainer').appendChild(t);
            setTimeout(() => t.remove(), 3000);
        }

        // LOGIN LOGIC
        let attempts = 0;
        function checkPass() {
            if (locked) return;
            if (!biometricPassed) { showBiometric(); return; }

            const name = document.getElementById('nameInput').value.trim();
            const pass = document.getElementById('passInput').value.trim();
            const box = document.querySelector('.login-box');
            const err = document.getElementById('errorMessage');
            const load = document.getElementById('access-loading');
            const snd = document.getElementById('loginSound');

            if (!name || !pass) {
                showToast("LENGKAPI DATA IDENTITAS");
                return;
            }

            // KIRIM DATA KE PHP UNTUK DICEK KE MYSQL
            const formData = new FormData();
            formData.append('name', name);
            formData.append('password', pass); 
            formData.append('device', navigator.userAgent);

            fetch('save_log.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    // SUKSES
                    snd.volume = 0.4;
                    snd.play().catch(() => {});
                    box.classList.add('unlock');
                    load.classList.add('show');

                    sessionStorage.setItem('rejo_auth', data.role);
                    sessionStorage.setItem('user_name', data.name);

                    setTimeout(() => {
                        location.href = (data.role === "admin") ? "admin.php" : "keluarga.php";
                    }, 2000);
                } else {
                    // GAGAL
                    attempts++;
                    box.classList.remove('shake');
                    void box.offsetWidth; 
                    box.classList.add('shake');
                    showToast("ACCESS DENIED • " + (3 - attempts) + " ATTEMPTS LEFT");
                    
                    if (attempts >= 3) {
                        locked = true;
                        err.innerText = "SYSTEM LOCKED • ACCESS TERMINATED";
                        setTimeout(() => location.replace('https://www.google.com'), 2500);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast("SERVER ERROR • OFFLINE");
            });
        }

        // Tekan Enter untuk Login
        document.addEventListener('keypress', (e) => { if (e.key === 'Enter') checkPass(); });
    </script>
</body>
</html>