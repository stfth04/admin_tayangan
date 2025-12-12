<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin</title>
    <link rel="icon" type="image/png" href="/logo_bps.png">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* (CSS persis seperti yang kamu kirim) */
        /* ---------- General ---------- */
        body {
            background-color: #f2f6fa;
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background-color: #286090;
            color: white;
        }
        .navbar a { color: white !important; text-decoration: none; }

        /* ---------- Upload area ---------- */
        .upload-area {
            border-radius: 15px;
            background: #D9D9D9;
            text-align: center;
            padding: 110px;
            transition: background 0.3s;
        }
        .icon-upload { font-size: 60px; color: #999; }

        /* ---------- Form controls ---------- */
        .form-control, .form-select {
            border-radius: 20px;
            background-color: #D9D9D9;
        }

        .upload-section {
            /* adjust to match previous look */
            margin-left: -75px;
        }

        /* ---------- Buttons ---------- */
        .btn-simpan {
            background-color: #47d160;
            border: none;
            border-radius: 20px;
            color: white;
            width: 150px;
            padding: 8px 40px;
            font-size: 14px;
        }
        .btn-simpan:hover { background-color: #3cb155; }

        .btn-aksi {
            background: none;
            border: none;
            color: #f7941d;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-aksi:hover { text-decoration: underline; }

        /* ---------- Playlist styles ---------- */
        .btn-add-playlist {
            background-color: #5a5555;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            font-size: 16px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .playlist-btn-wrapper { margin-bottom: 20px; margin-top: 10px; margin-left: 30px; }

        .popup-playlist-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4); display: flex; justify-content: center; align-items: center;
            z-index: 9999;
        }
        .popup-playlist-box {
            background: #e5eff6; padding: 30px; width: 350px; text-align: center; border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
        }
        .popup-title { font-size: 22px; font-weight: 600; margin-bottom: 20px; }
        .popup-input {
            width: 100%; padding: 10px 15px; border-radius: 25px; border: none; background: #d9d9d9; margin-bottom: 20px;
        }
        .btn-buat-playlist { background: #2e6c96; color: white; border: none; padding: 10px 30px; border-radius: 25px; font-size: 16px; cursor: pointer; }
        .btn-buat-playlist:hover { background: #245979; }

        .playlist-card {
            width: 150px; background: #ffffff; border-radius: 10px; padding: 10px; box-shadow: 0px 2px 6px rgba(0,0,0,0.15);
            text-align: center; font-size: 14px; margin-left: 30px; cursor: pointer;
        }
        .playlist-thumb { width: 100%; height: 100px; background: #bdbdbd; border-radius: 6px; margin-bottom: 8px; }

        .playlist-detail { background: #dfe9f0; padding: 40px; border-radius: 10px; margin-top: 20px; }
        .playlisttitle { font-size: 24px; 
            font-weight: 600; 
            margin-top: -34px; 
            margin-left: 127px; }
        .playlist-detail-buttons { 
            display:flex; 
            gap:20px; 
            margin-bottom:30px; 
            margin: 5px 0 5px 0;  
            margin-left: 850px;
            margin-top:-40px
        }
        .btn-play-all, .btn-add-content { 
            background: #d7d5d5; 
            border:none; 
            border-radius:25px; 
            padding:10px 5px; 
            cursor:pointer; 
            font-size:14px; 
            width: 200px;
            padding-right: 70px;
        }
        .btn-play-all:hover, .btn-add-content:hover { background: #c6c5c5; }
        .playlist-empty { color:#8c8c8c; margin-top:100px; text-align:center; font-size:16px; }

        /* ---------- Table ---------- */
        .table-container { 
        background-color: white; 
        border-radius: 10px;
        padding: 20px; }
        thead { 
        background-color: #f7941d !important; 
        color: white !important; }
        th, td { 
        vertical-align: middle; 
        text-align: center; }
        .table img { 
        width: 120px; 
        border-radius: 5px; }

        /* small helpers */
        .d-none { 
        display: none !important; }

        .btn-back {
        width: 43px;
        height: 43px;
        cursor: pointer;
        margin-left: 60px;
        margin-top:22px;
    }

            .item-box {
            position: relative;
            margin-top:28px;
            margin-right: 35px;
        }

.more-menu {
    position: absolute;
    top: 10px;
    right: 0;
    background: #e9f1f8;
    border-radius: 18px;
    padding: 10px 0;
    width: 250px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 999;
}

.more-item {
    padding: 10px 20px;
    font-size: 18px;
    cursor: pointer;
}

.more-item:hover {
    background: rgba(0,0,0,0.05);
}

.d-none {
    display: none !important;
}

.icon-more {
    position: absolute;
    top: -68px;   /* 👉 naikkan ke atas */
    right: 10px;
    width: 35px;
}

/* POPUP WRAPPER */
.popup-jadwal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.35);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

/* BOX */
.jadwal-box {
    width: 430px;
    background: #e8f3fc;
    border-radius: 18px;
    padding: 25px 30px;
    box-shadow: 0 8px 26px rgba(0,0,0,0.2);
    text-align: center;
}

/* TITLE */
.jadwal-title {
    font-size: 20px;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 25px;
}

/* INPUT ROW */
.jadwal-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

/* INPUT COLUMN */
.jadwal-col {
    width: 47%;
    text-align: center;
}

.jadwal-col label {
    display: block;
    font-weight: 600;
    font-size: 17px;
    margin-bottom: 8px;
}

/* INPUT WRAPPER */
.jadwal-input {
    position: relative;
    background: #d9d9d9;
    border-radius: 20px;
    padding: 8px 12px;
}

.jadwal-input input {
    width: 100%;
    border: none;
    background: transparent;
    font-size: 15px;
    text-align: center;
    outline: none;
    padding-right: 35px;
    font-weight: 500;
}

/* ICON */
.icon-calendar {
    position: absolute;
    width: 20px;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.7;
}

/* DIVIDER */
.divider {
    margin: 18px 0;
    opacity: 0.4;
}

/* BUTTON WRAPPER */
.jadwal-actions {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

/* BATAL BUTTON */
.btn-cancel {
    width: 50%;
    padding: 9px 0;
    background: #d9d9d9;
    border: none;
    border-radius: 18px;
    font-weight: 600;
    cursor: pointer;
}

/* SIMPAN BUTTON */
.btn-save {
    width: 50%;
    padding: 9px 0;
    background: #206486;
    color: white;
    border: none;
    border-radius: 18px;
    font-weight: 600;
    cursor: pointer;
}

.btn-save:hover {
    opacity: 0.9;
}

/* OVERLAY */
.popup-ganti {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.35);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

/* BOX */
.ganti-box {
    width: 430px;
    background: #e8f3fc;
    border-radius: 18px;
    padding: 25px 30px;
    box-shadow: 0 8px 26px rgba(0,0,0,0.2);
    text-align: center;
}

/* TITLE */
.ganti-title {
    font-size: 20px;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 25px;
}

/* INPUT WRAPPER */
.ganti-input-wrap {
    background: #d9d9d9;
    border-radius: 20px;
    padding: 12px 18px;
    margin-bottom: 20px;
    position: relative;
}

.ganti-input-wrap label {
    display: block;
    font-weight: 600;
    font-size: 17px;
    margin-bottom: 8px;
}

.ganti-input {
    width: 100%;
    border: none;
    background: transparent;
    font-size: 16px;
    outline: none;
    text-align: center;
    font-weight: 500;
}

/* DIVIDER */
.divider {
    margin: 18px 0;
    opacity: 0.4;
}

/* BUTTON WRAPPER */
.ganti-actions {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

/* CANCEL BUTTON */
.btn-cancel {
    width: 50%;
    padding: 9px 0;
    background: #d9d9d9;
    border: none;
    border-radius: 18px;
    font-weight: 600;
    cursor: pointer;
}

/* SAVE BUTTON */
.btn-save {
    width: 50%;
    padding: 9px 0;
    background: #206486;
    color: white;
    border: none;
    border-radius: 18px;
    font-weight: 600;
    cursor: pointer;
}

.btn-save:hover {
    opacity: 0.9;
}


/* ===== POPUP HAPUS (BARU, MENYAMAI JADWAL & GANTI NAMA) ===== */
.popup-hapus {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.35);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.hapus-box {
    width: 430px;
    background: #e8f3fc;                 /* sama seperti popup lain */
    border-radius: 18px;
    padding: 30px 35px;
    box-shadow: 0 8px 26px rgba(0,0,0,0.2);
    text-align: center;
}

.hapus-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #1a1a1a;
}

.hapus-text {
    font-size: 17px;
    color: #333;
    margin-bottom: 30px;
}

/* TOMBOL */
.hapus-actions {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.btn-hapus-cancel {
    width: 50%;
    padding: 10px 0;
    border: none;
    border-radius: 18px;
    background: #d9d9d9;
    font-weight: 600;
    cursor: pointer;
}

.btn-hapus-yes {
    width: 50%;
    padding: 10px 0;
    border: none;
    border-radius: 18px;
    background: #206486;
    color: white;
    font-weight: 600;
    cursor: pointer;
}

.btn-hapus-yes:hover {
    opacity: 0.9;
}
/* pop up select playlist */
.d-none { display: none; }
#popupPilihPlaylist {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}
.popup-box {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
}
.playlist-card {
    border: 1px solid #ccc;
    padding: 10px;
    cursor: pointer;
}
.playlist-card.selected-playlist {
    border-color: #007bff;
    background: #e7f1ff;
}
    </style>
</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg px-4 py-3" style="background-color: #336F97;">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <img src="/logo_bps.png" alt="Logo" width="80" class="me-2">
            <div class="text-white">
                <strong>BADAN PUSAT STATISTIK</strong><br>
                PROVINSI KALIMANTAN SELATAN
            </div>
        </div>

        <div class="ms-auto text-end text-white me-3">
            <div id="time"></div>
            <div id="date"></div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-light btn-sm ms-3 rounded-pill d-flex align-items-center gap-2">
                <img src="/logout.png" alt="Logout Icon" width="18" height="18"> Log Out
            </button>
        </form>
    </div>
</nav>

<script>
    function updateDateTime() {
        const now = new Date();

        // ambil waktu UTC
        const utcHours = now.getUTCHours();
        const minutes = now.getUTCMinutes();

        // WITA = UTC + 8
        const witaHours = (utcHours + 8) % 24;

        const hours = witaHours.toString().padStart(2, '0');
        const mins = minutes.toString().padStart(2, '0');

        // tanggal dalam indonesia
        const options = { 
            weekday: 'long', 
            day: 'numeric', 
            month: 'long', 
            year: 'numeric'
        };

        // generate tanggal normal (pakai waktu lokal)
        const dateString = now.toLocaleDateString('id-ID', options);

        document.getElementById('time').textContent = `${hours}:${mins} WITA`;
        document.getElementById('date').textContent = dateString;
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>

<!-- Tabs -->
<div style="background-color: #336F97; color: white; border-top: 5px solid #8DBEDE;">
    <div class="container d-flex justify-content-start gap-4 py-3">
        <a href="#" class="text-white fw-bold text-decoration-none active-tab" onclick="showTab('upload', event)">Upload File</a>
        <a href="#" class="text-white text-decoration-none" onclick="showTab('kelola', event)">Kelola Konten</a>
        <a href="#" class="text-white text-decoration-none" onclick="showTab('playlist', event)">Playlist</a>
    </div>
</div>

{{-- ========================= UPLOAD TAB ========================= --}}
<div id="upload" class="tab-content {{ session('show_tab', 'upload') == 'upload' ? '' : 'd-none' }}">
    <div class="container mt-4">
        <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row align-items-start">
                <!-- Upload column -->
                <div class="col-md-8 upload-section">
                    <h5><strong>Upload File</strong></h5>

                    <div class="upload-area" id="uploadArea">
                        <div class="icon-upload mb-2" id="iconArea">
                            <img src="{{ asset('icon.png') }}" alt="Upload Icon" width="60">
                        </div>

                        <p id="uploadText" style="color: #9A9A9A;">Klik atau seret file ke area ini</p>

                        <img id="previewImage" src="" alt="" style="display:none; max-width: 200px; margin-top:10px; margin-left:165px; border-radius:8px;">
                        <video id="previewVideo" controls style="display:none; max-width:200px; margin-top:10px; margin-left:165px; border-radius:8px;"></video>

                        <!-- NOTE: name="file" supaya ContentController menerima -->
                        <input type="file" name="file" id="fileInput" hidden accept="image/*,video/*">
                    </div>
                </div>

                <!-- Properti column -->
                <div class="col-md-4">
                    <h6><strong>Properti</strong></h6>

                    <div class="mb-3">
                        <label for="nama_file" class="form-label">Nama File</label>
                        <input type="text" id="nama_file" name="nama_file" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="resolusi" class="form-label">Resolusi</label>
                        <select id="resolusi" name="resolusi" class="form-select">
                            <option>1920x1080</option>
                            <option>1280x720</option>
                            <option>1024x768</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="orientasi" class="form-label">Orientasi</label>
                        <select id="orientasi" name="orientasi" class="form-select">
                            <option>Landscape</option>
                            <option>Portrait</option>
                        </select>
                    </div>

                    <div class="btn-area mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn-simpan">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ========================= PILIH PLAYLIST ========================= --}}
<div id="popupPilihPlaylist" class="d-none">
    <div class="popup-box">
        <h3>Pilih Playlist</h3>
        <div id="playlistList" class="d-flex flex-wrap gap-3 mt-3">
            @foreach($playlists as $playlist)
                <div class="playlist-card"
                     data-id="{{ $playlist->id }}"
                     onclick="selectPlaylist({{ $playlist->id }}, this)">
                    <div class="playlist-thumb"></div>
                    <div class="playlist-info">
                        <p class="playlist-title">{{ $playlist->nama_playlist }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="popup-actions mt-3">
            <button onclick="submitAddToPlaylist()">TAMBAH</button>
            <button onclick="closePopupPlaylist()">BATAL</button>
        </div>
    </div>
</div>


{{-- ========================= KELOLA TAB ========================= --}}

<div id="kelola" class="tab-content {{ session('show_tab') == 'kelola' ? '' : 'd-none' }}">
    <div class="container mt-5">
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No/ID</th>
                        <th>Konten</th>
                        <th>Jenis Konten</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($konten as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @php
                                    $ext = strtolower(pathinfo($item->file ?? '', PATHINFO_EXTENSION));
                                @endphp

                                @if(in_array($ext, ['mp4','mov','avi','mkv','webm']))
                                    <video src="{{ asset('storage/'.$item->file) }}" style="width:200px; height:auto;" controls></video>
                                @else
                                    <img src="{{ asset('storage/'.$item->file) }}" style="max-width:120px;">
                                @endif

                                <br>
                                <small><strong>{{ $item->nama_file }}</strong></small>
                            </td>
                            <td>{{ $item->jenis }}</td>
                            <td>
                                <button class="btn-aksi" onclick="window.selectedKontenId={{ $item->id }}; openPopupPlaylist();">+</button>

                                {{-- Hapus Konten --}}
                                <form action="{{ route('contents.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-aksi text-danger" onclick="return confirm('Hapus konten ini?')">Hapus</button>
                                </form>

                                <button class="btn-aksi text-secondary">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ========================= PLAYLIST TAB ========================= --}}
<div id="playlist" class="tab-content {{ session('show_tab') == 'playlist' ? '' : 'd-none' }}">
    <div class="playlist-btn-wrapper">
        <button class="btn-add-playlist">+ Playlist</button>
    </div>

    <form id="add-to-playlist-form" style="display: none;">
        @csrf
        <input type="hidden" name="konten_id" id="konten_id">
        <input type="hidden" name="playlist_id" id="playlist_id">
    </form>

    <div id="playlistList" class="d-flex flex-wrap gap-3 mt-3">
        @foreach($playlists as $playlist)
            <div class="playlist-card" data-id="{{ $playlist->id }}" data-name="{{ $playlist->nama_playlist }}">
                <div class="playlist-thumb"></div>
                <div class="playlist-info">
                    <p id="playlistName-{{ $playlist->id }}" class="playlist-title">{{ $playlist->nama_playlist }}</p>
                </div>
            </div>
        @endforeach
    </div>


    {{-- Popup Add Playlist --}}
    <div id="popupPlaylist" class="popup-playlist-overlay d-none" aria-hidden="true">
        <div class="popup-playlist-box" role="dialog" aria-modal="true">
            <h3 class="popup-title">Beri nama playlist</h3>
            <input type="text" id="playlistTitle" class="popup-input" placeholder="Judul">

            <form action="{{ route('playlist.store') }}" method="POST" id="formPlaylist">
                @csrf
                <input type="hidden" id="judul_playlist" name="judul">
                <button type="submit" class="btn-buat-playlist">BUAT</button>
            </form>
        </div>
    </div>
</div>

{{-- ========================= PLAYLIST DETAIL (local client-side detail) ========================= --}}
<div id="playlistDetail" class="tab-content d-none">
    {{-- If no playlist selected, show message --}}
    <div id="playlistDetailContent">
        <h2 class="playlisttitle">Pilih playlist</h2>
        <p class="playlist-empty">Pilih playlist di tab Playlist atau buat baru.</p>
    </div>
</div>


{{-- ========================= SCRIPTS (single place) ========================= --}}
<script>
    // showTab helper (keperluan navbar tabs)
    function showTab(tabId, event) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('d-none'));
        document.getElementById(tabId).classList.remove('d-none');

        // highlight active tab link
        document.querySelectorAll('.container.d-flex a').forEach(a => a.classList.remove('active-tab'));
        if (event && event.target) event.target.classList.add('active-tab');
    }

    // openTab for programmatic navigation (used by server side session show_tab)
    function openTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('d-none'));
        document.getElementById(tabId).classList.remove('d-none');
        }

   
function addToPlaylist(kontenId) {
    const playlistSelect = document.querySelector('#default-playlist-id');
    if (!playlistSelect || !playlistSelect.value) {
        alert('Silakan pilih playlist terlebih dahulu!');
        return;
    }

    const playlistId = playlistSelect.value;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/playlist-content-add', {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({
            konten_id: kontenId,
            playlist_id: playlistId
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Konten berhasil ditambahkan ke playlist!');
            openTab('playlist'); // pindah ke tab playlist
        } else if (data.error) {
            alert(data.error);
        }
    })
    .catch(err => {
        console.error(err);
        alert('Gagal menambahkan ke playlist. Cek console untuk detail.');
    });
}


    // OPEN
function openJadwal() {
    document.getElementById("popupJadwal").classList.remove("d-none");
}

// CLOSE
function closeJadwal() {
    document.getElementById("popupJadwal").classList.add("d-none");
}

// SAVE
function saveJadwal() {
    const mulai = document.getElementById("tglMulai").value;
    const selesai = document.getElementById("tglSelesai").value;

    if (!mulai || !selesai) {
        alert("Tanggal tidak boleh kosong!");
        return;
    }

    console.log("Mulai:", mulai);
    console.log("Selesai:", selesai);

    closeJadwal();
}

 let activePlaylistId = null;

function openGanti(id, nama) {
    activePlaylistId = id;
    document.getElementById("namaBaru").value = nama;
    document.getElementById("popupGanti").classList.remove("d-none");
}

function closeGanti() {
    document.getElementById("popupGanti").classList.add("d-none");
}

function saveGanti() {
    let nama = document.getElementById("namaBaru").value.trim();
    if (nama === "" || !activePlaylistId) return;

    fetch("{{ route('playlist.updateName') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            id: activePlaylistId,
            nama_playlist: nama
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Update nama pada card tanpa reload
            location.reload();
        }
        closeGanti();
    })
    .catch(err => console.error(err));
}

// =========== GLOBAL POPUP HAPUS ===========

// Menyimpan ID playlist yang ingin dihapus
let deleteId = null;

// Tampilkan popup hapus
function openHapus(id, name) {
    deleteId = id;

    document.getElementById("hapusText").innerText =
        `Yakin ingin menghapus playlist "${name}"?`;

    document.getElementById("popupHapus").classList.remove("d-none");
}

// Tutup popup hapus
function closeHapus() {
    deleteId = null;
    document.getElementById("popupHapus").classList.add("d-none");
}

// Konfirmasi hapus
function confirmHapus() {
    if (!deleteId) return;

    fetch(`/playlist/delete/${deleteId}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const card = document.querySelector(`.playlist-card[data-id="${deleteId}"]`);
            if (card) card.remove();

            closeHapus();
            openTab('playlist');
        }
    });
}


    // Single event listener for clicks on playlist cards (delegation)
    document.addEventListener('click', function(e) {
        // Playlist-card click
        const card = e.target.closest('.playlist-card');
        if (card) {
            const name = card.getAttribute('data-name') || 'Playlist';
            const id = card.getAttribute('data-id');

            // update playlist detail content (client-only)
            const detail = document.getElementById('playlistDetailContent');
           detail.innerHTML = `
            <div class="playlist-header">
                <img src="{{ asset('logoback.png') }}" class="btn-back" onclick="openTab('playlist')" />
                <h2 class="playlisttitle">${escapeHtml(name)}</h2>
            </div>
            <div class="playlist-detail-buttons">
                <button class="btn-play-all">► Putar Semua</button>
                <button class="btn-add-content" data-playlist-id="${id}">Tambah Konten +</button>
            </div>

            <div class="item-box">
                <img src="{{ asset('logotitik3.png') }}" class="icon-more" onclick="toggleMenu(this)">
                
                <!-- MENU YANG MUNCUL -->
                <div class="more-menu d-none">
                    <div class="more-item" onclick="openJadwal()">Jadwal</div>
                    <div class="more-item" onclick="openHapus(${id},'${escapeHtml(name)}')">Hapus Playlist</div>
                    <div class="more-item"onclick="openGanti(${id}, '${escapeHtml(name)}')">Ganti Nama</div>
                </div>
            </div>

        `;


// KONFIRMASI HAPUS
let deleteId = null; // Menyimpan id playlist yang mau dihapus

// === TAMPILKAN POPUP HAPUS ===
function openHapus(id, name) {
    deleteId = id;

    // Isi teks konfirmasi
    document.getElementById("hapusText").innerText =
        `Yakin ingin menghapus playlist "${name}"?`;

    // Tampilkan popup
    document.getElementById("popupHapus").classList.remove("d-none");
}

// === TUTUP POPUP HAPUS ===
function closeHapus() {
    document.getElementById("popupHapus").classList.add("d-none");
    deleteId = null;
}

// === KONFIRMASI HAPUS (AJAX) ===
function confirmHapus() {
    if (!deleteId) return;

    fetch(`/playlist/delete/${deleteId}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {

            // Hapus card dari halaman tanpa reload
            const card = document.querySelector(`.playlist-card[data-id="${deleteId}"]`);
            if (card) card.remove();

            closeHapus();
            openTab('playlist'); // jika ingin kembali ke tab playlist
        }
    })
    .catch(err => console.error(err));
}




            // show detail and hide playlist list
            document.getElementById('playlist').classList.add('d-none');
            document.getElementById('playlistDetail').classList.remove('d-none');

            return; // stop here for card clicks
        }

        // btn-add-playlist (open popup)
        if (e.target.closest('.btn-add-playlist')) {
            document.getElementById('popupPlaylist').classList.remove('d-none');
            return;
        }
        

        // popup overlay click to close
        if (e.target.id === 'popupPlaylist') {
            e.target.classList.add('d-none');
            return;
        }

        // click on dynamic "Tambah Konten +" inside playlist detail
        if (e.target.closest('.btn-add-content')) {
    const btn = e.target.closest('.btn-add-content');
    const playlistId = btn.getAttribute('data-playlist-id');

    const kontenId = window.selectedKontenId;
    if (!kontenId) {
        alert("Pilih konten dari tab Kelola Konten dulu.");
        return;
    }

    document.getElementById('playlist_id').value = playlistId;
    document.getElementById('konten_id').value = kontenId;

    document.getElementById('formAddContent').submit();
    return;
}

    });

    // escape HTML helper
    function escapeHtml(unsafe) {
        return String(unsafe)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // popup add playlist: sync hidden input before submission
    document.querySelector('#formPlaylist')?.addEventListener('submit', function(e) {
        const title = document.getElementById('playlistTitle').value.trim();
        if (!title) {
            e.preventDefault();
            alert('Masukkan judul playlist.');
            return false;
        }
        document.getElementById('judul_playlist').value = title;
    });

    // make "BUAT" button also fill hidden input if user clicks button outside form (older logic)
    document.querySelector('.btn-buat-playlist')?.addEventListener('click', function() {
        document.getElementById('judul_playlist').value = document.getElementById('playlistTitle').value || '';
    });

    // Upload area interactions: click zone triggers hidden input
    document.getElementById('uploadArea')?.addEventListener('click', function () {
        document.getElementById('fileInput').click();
    });

    // Preview image/video for selected file
    document.getElementById('fileInput')?.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            const previewImg = document.getElementById('previewImage');
            const previewVid = document.getElementById('previewVideo');
            const iconArea = document.getElementById('iconArea');
            const text = document.getElementById('uploadText');

            iconArea.style.display = 'none';
            text.style.display = 'none';

            if (file.type.startsWith('image/')) {
                previewVid.style.display = 'none';
                previewImg.style.display = 'block';
                previewImg.src = e.target.result;

            } else if (file.type.startsWith('video/')) {
                previewImg.style.display = 'none';
                previewVid.style.display = 'block';
                previewVid.src = e.target.result;
                previewVid.muted = true;
                previewVid.autoplay = true;
                previewVid.play().catch(()=>{});

            }
        };
        reader.readAsDataURL(file);
    });

    // If server set show_tab in session, open that tab after DOM ready
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('show_tab'))
            openTab("{{ session('show_tab') }}");
        @endif
    });

    // Fungsi toggle menu titik tiga
function toggleMenu(el){
    // Tutup semua menu lain agar tidak dobel
    document.querySelectorAll('.more-menu').forEach(menu => {
        if(menu !== el.parentElement.querySelector('.more-menu')){
            menu.classList.add('d-none');
        }
    });

    // Toggle menu pada item yang diklik
    const target = el.parentElement.querySelector('.more-menu');
    target.classList.toggle('d-none');
}

document.addEventListener('click', function(e){
    const clickedInside = e.target.closest('.item-box');
    
    // Jika klik di luar item playlist
    if(!clickedInside){
        document.querySelectorAll('.more-menu').forEach(menu => {
            menu.classList.add('d-none');
        });
    }
});
</script>

<!-- POPUP JADWAL -->
<div class="popup-jadwal d-none" id="popupJadwal">

    <div class="jadwal-box">
        <h3 class="jadwal-title">Jadwal</h3>

        <div class="jadwal-row">
            <div class="jadwal-col">
                <label>Mulai</label>
                <div class="jadwal-input">
                    <input type="date" id="tglMulai">
                    <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" class="icon-calendar">
                </div>
            </div>

            <div class="jadwal-col">
                <label>Selesai</label>
                <div class="jadwal-input">
                    <input type="date" id="tglSelesai">
                    <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" class="icon-calendar">
                </div>
            </div>
        </div>

        <hr class="divider">

        <div class="jadwal-actions">
            <button class="btn-cancel" onclick="closeJadwal()">Batal</button>
            <button class="btn-save" onclick="saveJadwal()">Simpan</button>
        </div>
    </div>

</div>

<!-- POPUP GANTI NAMA -->
<div class="popup-ganti d-none" id="popupGanti">

    <div class="ganti-box">
        <h3 class="ganti-title">Ganti Nama</h3>

        <div class="ganti-input-wrap">
            <label>Nama Baru</label>
            <input type="text" id="namaBaru" class="ganti-input" placeholder="Masukkan nama baru">
        </div>

        <div class="ganti-actions">
            <button class="btn-cancel" onclick="closeGanti()">Batal</button>
            <button class="btn-save" onclick="saveGanti()">Simpan</button>
        </div>
    </div>

</div>

<!-- POPUP HAPUS PLAYLIST -->
<div class="popup-hapus d-none" id="popupHapus">
    <div class="hapus-box">
        <h3 class="hapus-title">Hapus Playlist</h3>

        <p id="hapusText" class="hapus-text">
            Yakin ingin menghapus playlist?
        </p>

        <div class="hapus-actions">
            <button class="btn-hapus-cancel" onclick="closeHapus()">TIDAK</button>
            <button class="btn-hapus-yes" onclick="confirmHapus()">YA</button>
        </div>
    </div>
</div>

<div class="popup-hapus d-none" id="popupTambahKePlaylist">
    <div class="hapus-box">
        <h3 class="hapus-title">Tambah Ke Playlist</h3>

        <p class="hapus-text">Pilih playlist untuk konten ini:</p>

        <div id="playlistList" style="text-align:left; margin-bottom:20px;">
            <!-- daftar playlist akan dimasukkan lewat JS -->
        </div>

        <div class="hapus-actions">
            <button class="btn-hapus-cancel" onclick="closeTambahKePlaylist()">BATAL</button>
        </div>
    </div>
</div>


<!-- ====================== SCRIPT LOAD PLAYLIST DETAIL ====================== -->
<script>
async function loadPlaylistDetail(playlistId) {
    const res = await fetch(`/playlist/${playlistId}`);
    const data = await res.json();

    const items = data.items;

    let html = `
        <div class="playlist-header">
            <img src="/logoback.png" class="btn-back" onclick="openTab('playlist')" />
            <h2 class="playlisttitle">${data.playlist.nama_playlist}</h2>
        </div>

        <div class="playlist-detail-buttons">
            <button class="btn-play-all">► Putar Semua</button>
            <button class="btn-add-content" data-playlist-id="${playlistId}">Tambah Konten +</button>
        </div>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Urutan</th>
                    <th>Konten</th>
                    <th>Durasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
    `;

    if (items.length === 0) {
        html += `<tr><td colspan="4" class="text-center text-muted">Belum ada konten</td></tr>`;
    } else {
        items.forEach((item, index) => {
            const ext = item.file.split('.').pop().toLowerCase();
            const isVideo = ['mp4','mov','avi','mkv','webm'].includes(ext);

            html += `
                <tr>
                    <td>${index + 1}</td>
                    <td>
                        ${isVideo 
                            ? `<video src="/storage/${item.file}" style="width:100px;" controls></video>`
                            : `<img src="/storage/${item.file}" style="width:100px;">`
                        }
                        <br><small>${item.nama_file}</small>
                    </td>
                    <td>1 Menit</td>
                    <td><a href="/playlist/remove/${data.playlist.id}/${item.id}" class="text-danger">Hapus</a></td>
                </tr>
            `;
        });
    }

    html += `</tbody></table>`;

    document.getElementById('playlistDetailContent').innerHTML = html;
}

let selectedPlaylistId = null;

function selectPlaylist(id, el) {
    selectedPlaylistId = id;
    document.querySelectorAll('.playlist-card').forEach(card => card.classList.remove('selected-playlist'));
    el.classList.add('selected-playlist');
}

function openPopupPlaylist() {
    document.getElementById('popupPilihPlaylist').classList.remove('d-none');
}

function closePopupPlaylist() {
    document.getElementById('popupPilihPlaylist').classList.add('d-none');
}

function submitAddToPlaylist() {
    if (!selectedPlaylistId || !window.selectedKontenId) {
        alert("Silakan pilih playlist dan konten terlebih dahulu!");
        return;
    }

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/playlist-content-add', {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({
            playlist_id: selectedPlaylistId,
            konten_id: window.selectedKontenId
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Konten berhasil ditambahkan ke playlist!');
            closePopupPlaylist();
            openTab('playlist');
        } else {
            alert(data.error);
        }
    });
}
</script>
<!-- ====================== END SCRIPT ====================== -->

</body>
</html>
