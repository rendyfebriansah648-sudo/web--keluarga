<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN | REJO MUSEUM</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto+Mono:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
            display: flex;
            flex-direction: column;
            cursor: none;
            overflow-x: hidden;
        }
        
        /* --- NAVIGATION --- */
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
            font-size: 1.5rem;
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
            margin-top: 80px;
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
            margin-bottom: 10px;
        }

        /* --- CONTROLS & TABLE --- */
        .controls {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin: 15px 0;
        }
        
        .controls input,
        .controls select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #555;
            background: #111;
            color: #fff;
        }
        
        .controls button {
            padding: 8px 14px;
            border: none;
            border-radius: 5px;
            background: #b38b4d;
            color: #000;
            font-weight: bold;
            transition: .3s;
        }
        
        .controls button:hover {
            background: #8e6d3a;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            opacity: 0;
            animation: fadeSlide 1s forwards 0.3s;
        }
        
        @keyframes fadeSlide { to { opacity: 1; } }
        
        th, td {
            padding: 12px;
            border: 1px solid rgba(179, 139, 77, .3);
            text-align: center;
        }
        
        th { background: rgba(179, 139, 77, .2); }
        tr:nth-child(even) { background: rgba(255, 255, 255, .05); }

        /* --- CUSTOM CURSOR --- */
        .cursor-dot,
        .cursor-outline {
            position: fixed;
            top: 0;
            left: 0;
            border-radius: 50%;
            pointer-events: none;
            z-index: 1000000;
            transition: opacity .2s;
        }
        .cursor-dot { width: 6px; height: 6px; background: #b38b4d; }
        .cursor-outline { width: 40px; height: 40px; border: 1px solid rgba(179, 139, 77, .5); }
        
        /* --- ACCESS DENIED MODAL --- */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(15px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999999;
        }
        .modal-overlay.active { display: flex; animation: modalFadeIn 0.5s ease forwards; }
        
        .modal-card {
            background: #111;
            border: 1px solid #b38b4d;
            padding: 40px;
            max-width: 450px;
            width: 90%;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(179, 139, 77, 0.2);
        }
        .modal-icon { font-size: 4rem; color: #ff4d4d; margin-bottom: 20px; animation: iconPulse 2s infinite; }
        .modal-card h3 { font-family: 'Playfair Display', serif; color: #b38b4d; margin-bottom: 15px; }
        .modal-card p { font-size: 0.9rem; color: #ccc; margin-bottom: 30px; line-height: 1.6; }
        .modal-btn {
            padding: 12px 30px;
            background: #b38b4d;
            color: #000;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }
        .modal-btn:hover { background: #fff; transform: scale(1.05); }

        @keyframes modalFadeIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
        @keyframes iconPulse { 0% { transform: scale(1); } 50% { transform: scale(1.1); } 100% { transform: scale(1); } }

        #toast {
            position: fixed; bottom: 20px; right: 20px;
            background: rgba(179, 139, 77, 0.95); color: #000;
            padding: 12px 22px; border-radius: 8px; opacity: 0;
            transition: 0.5s; z-index: 10003;
        }
        #toast.show { opacity: 1; transform: translateY(-10px); }
        
        @media(max-width:768px) { .cursor-dot, .cursor-outline { display: none!important; } }
    </style>
</head>

<body>

    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <div id="accessModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-icon"><i class="fa-solid fa-shield-halved"></i></div>
            <h3>Akses Ditolak</h3>
            <p>Maaf, Anda tidak memiliki izin untuk melihat arsip log ini. Halaman ini hanya untuk personel **ADMIN**.</p>
            <button class="modal-btn" onclick="location.replace('login.php')">Kembali ke Login</button>
        </div>
    </div>

    <nav>
        <div class="title">REJO MUSEUM ADMIN</div>
        <div>
            <span class="menu-btn" onclick="goHome()"><i class="fa-solid fa-house"></i> Portal</span> &nbsp;|&nbsp;
            <span class="menu-btn" onclick="logout()"><i class="fa-solid fa-right-from-bracket"></i> Logout</span>
        </div>
    </nav>

    <main>
        <h1>Selamat Datang Admin</h1>

        <div class="controls">
            <input type="text" id="searchUser" placeholder="Cari nama..." onkeyup="applyFilter()">
            <select id="filterRole" onchange="applyFilter()">
                <option value="">Semua Role</option>
                <option value="keluarga">Keluarga</option>
                <option value="admin">Admin</option>
            </select>
            <button onclick="loadLogs()"><i class="fa-solid fa-rotate"></i> Refresh</button>
            <button onclick="clearLog()"><i class="fa-solid fa-trash"></i> Hapus Semua</button>
            <button onclick="exportLog()"><i class="fa-solid fa-download"></i> Export JSON</button>
        </div>

        <table id="loginTable">
            <thead>
                <tr>
                    <th>Nama User</th>
                    <th>Role</th>
                    <th>Waktu Login</th>
                    <th>Device</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </main>

    <div id="toast"></div>

    <script>
        /* --- SECURITY CHECK --- */
        if (sessionStorage.getItem('rejo_auth') !== 'admin') {
            document.addEventListener('DOMContentLoaded', () => {
                document.getElementById('accessModal').classList.add('active');
            });
        } else {
            window.onload = loadLogs;
        }

        /* --- CURSOR LOGIC --- */
        if (window.matchMedia("(pointer:fine)").matches) {
            const dot = document.querySelector('.cursor-dot'),
                  out = document.querySelector('.cursor-outline');
            let mx = 0, my = 0, ox = 0, oy = 0;
            document.addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY; });
            function anim() {
                ox += (mx - ox) * 0.15; oy += (my - oy) * 0.15;
                dot.style.transform = `translate(${mx-3}px,${my-3}px)`;
                out.style.transform = `translate(${ox-20}px,${oy-20}px)`;
                requestAnimationFrame(anim);
            }
            anim();
        }

        /* --- LOGIC DATA --- */
        let logDataGlobal = [];

        function loadLogs() {
            fetch('api_logs.php?action=get')
                .then(res => res.json())
                .then(data => {
                    logDataGlobal = data;
                    renderTable(data);
                })
                .catch(err => showToast("Gagal mengambil data"));
        }

        function renderTable(data) {
            const tbody = document.querySelector('#loginTable tbody');
            tbody.innerHTML = '';
            data.forEach(entry => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${entry.name}</td>
                    <td>${entry.role}</td>
                    <td>${entry.time}</td>
                    <td><small style="font-size: 9px; color: #888;">${entry.device.substring(0, 50)}...</small></td>
                `;
                tbody.appendChild(tr);
            });
        }

        function applyFilter() {
            const role = document.getElementById('filterRole').value;
            const search = document.getElementById('searchUser').value.toLowerCase();
            const filtered = logDataGlobal.filter(e => {
                const matchRole = !role || e.role === role;
                const matchName = !search || e.name.toLowerCase().includes(search);
                return matchRole && matchName;
            });
            renderTable(filtered);
        }

        function clearLog() {
            if (confirm("Hapus semua history login?")) {
                fetch('api_logs.php?action=clear')
                    .then(res => res.json())
                    .then(res => { if(res.status === "success") loadLogs(); });
            }
        }

        function exportLog() {
            const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(logDataGlobal, null, 2));
            const dlAnchor = document.createElement('a');
            dlAnchor.setAttribute("href", dataStr);
            dlAnchor.setAttribute("download", "logs.json");
            dlAnchor.click();
            dlAnchor.remove();
        }

        function showToast(msg) {
            const t = document.getElementById('toast');
            t.innerText = msg;
            t.classList.add('show');
            setTimeout(() => { t.classList.remove('show') }, 2500);
        }

        function logout() {
            sessionStorage.clear();
            location.replace("login.php");
        }

        function goHome() { location.href = "keluarga.php"; }

        history.pushState(null, "", location.href);
        window.onpopstate = () => history.pushState(null, "", location.href);
    </script>

</body>

</html>