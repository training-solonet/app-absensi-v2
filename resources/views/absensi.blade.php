<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Absensi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }

    .sidebar {
      height: 100vh;
      background-color: #8DD8FF;
      box-shadow: 2px 0 10px rgba(0,0,0,0.1);
      padding: 20px;
      position: fixed;
      top: 0;
      left: 0;
      width: 240px;
      transition: all 0.3s ease;
      z-index: 1000;
    }

    .sidebar.collapsed {
      width: 70px !important;
      overflow: hidden;
    }

    .sidebar.collapsed .nav-link span,
    .sidebar.collapsed .badge,
    .sidebar.collapsed .text-center img[alt="Connectis Logo"] {
      display: none !important;
    }

    .sidebar .nav-link {
      font-weight: 500;
      color: #333;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
    }

    .sidebar .nav-link i {
      font-size: 18px;
      margin-right: 8px;
    }

    .sidebar.collapsed .nav-link {
      justify-content: center;
    }

    .sidebar .nav-link.active {
      background: #687EFF;
      color: #fff;
      border-radius: 8px;
      padding: 10px;
    }

    .toggle-btn {
      position: absolute;
      top: 50%;
      right: -15px;
      transform: translateY(-50%);
      background: #fff;
      border: none;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
      cursor: pointer;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1100;
    }

    .content {
      margin-left: 260px;
      padding: 20px;
      padding-top: 80px;
      transition: all 0.3s ease;
    }

    .content.collapsed {
      margin-left: 80px !important;
    }

    header.navbar {
      background-color: #96EFFF;
      position: fixed;
      top: 0;
      left: 240px;
      right: 0;
      height: 60px;
      z-index: 900;
      transition: all 0.3s ease;
    }

    header.navbar.collapsed {
      left: 70px;
    }

    .card-custom {
      border-radius: 12px;
      border: none;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar p-3" id="sidebar">
    <!-- Logo -->
    <div class="text-center mb-4">
      <img src="{{ asset('img/logo.png') }}" alt="Connectis Logo" width="120">
    </div>

    <!-- Profil Admin -->
    <div class="d-flex flex-column align-items-center text-center mb-4">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin" width="60" class="mb-2 rounded-circle">
      <div>
        <span class="badge bg-white text-dark">Administrator</span>
      </div>
    </div>

    <!-- Navigasi -->
    <nav class="nav flex-column">
      <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
      </a>
      <a class="nav-link {{ request()->is('siswa') ? 'active' : '' }}" href="{{ route('siswa.index') }}">
        <i class="bi bi-people-fill"></i> <span>Data Siswa</span>
      </a>
      <a class="nav-link {{ request()->is('absensi') ? 'active' : '' }}" href="{{ url('/absensi') }}">
        <i class="bi bi-clipboard-check"></i> <span>Laporan Absensi</span>
      </a>
    </nav>

    <!-- Tombol Toggle -->
    <button class="toggle-btn" id="toggleBtn">
      <i class="bi bi-chevron-left"></i>
    </button>
  </div>

  <!-- Content -->
  <div class="content" id="content">
    <!-- Header -->
    <header class="navbar shadow-sm px-4" id="header">
      <div class="container-fluid d-flex justify-content-between align-items-center h-100">
        <h5 class="fw-bold mb-0 text-dark">Laporan Absensi</h5>
        <div class="d-flex align-items-center">
          <span class="text-muted me-3" id="live-clock"></span>

          <!-- Dropdown Profil -->
          <div class="dropdown">
            <a href="#" class="d-flex align-items-center" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Profile" width="40" height="40" class="rounded-circle border border-2 border-primary">
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown">
              <li class="dropdown-header">Pilih Warna Tema</li>
              <li><button class="dropdown-item" onclick="setTheme('#8DD8FF','#ffffff')">Biru Muda</button></li>
              <li><button class="dropdown-item" onclick="setTheme('#28a745','#218838')">Hijau</button></li>
              <li><button class="dropdown-item" onclick="setTheme('#6f42c1','#5a32a3')">Ungu</button></li>
              <li><button class="dropdown-item" onclick="setTheme('#fd7e14','#e8590c')">Oranye</button></li>
              <li><button class="dropdown-item" onclick="setTheme('#007bff','#0056b3')">Biru Tua</button></li>
              <li><button class="dropdown-item" onclick="setTheme('#dc3545','#bd2130')">Merah</button></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item d-flex align-items-center text-danger" href="/login">
                  <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </header>

    <!-- Card Laporan Absensi -->
    <div class="card card-custom mt-4 p-3">
      <div class="card-body">
        <!-- Filter -->
        <form class="row g-3 mb-4">
          <div class="col-md-4">
            <label for="tanggal" class="form-label">Pilih Tanggal</label>
            <input type="date" id="tanggal" class="form-control">
          </div>
          <div class="col-md-4">
            <label for="kelas" class="form-label">Pilih Kelas</label>
            <select id="kelas" class="form-select">
              <option value="">Semua</option>
              <option>XI RPL 1</option>
              <option>XI RPL 2</option>
            </select>
          </div>
        </form>

        <!-- Tabel -->
        <h5 class="fw-bold mb-3">Data Absensi</h5>
            <div class="table-responsive">
              <table class="table table-striped align-middle">
                <thead class="table-light">
                  <tr>
                        <th>ID</th>
                        <th>ID Siswa</th>
                        <th>Tanggal</th>
                        <th>Waktu Masuk</th>
                        <th>Waktu Keluar</th>
                        <th>Keterangan</th>
                        <th>Catatan</th>
                      </tr>
                    </thead>
                  <tbody>
              @forelse($absensi as $absen)
              <tr>
                <td>{{ $absensi->id }}</td>
                <td>{{ $absensi->id_siswa }}</td>
                <td>{{ $absensi->tanggal }}</td>
                <td>{{ $absensi->waktu_masuk }}</td>
                <td>{{ $absensi->waktu_keluar }}</td>
                <td>{{ $absensi->keterangan }}</td>
                <td>{{ $absensi->catatan }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center">Belum ada data absensi</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function setTheme(sidebarColor, headerColor) {
      document.getElementById("sidebar").style.backgroundColor = sidebarColor;
      document.getElementById("header").style.backgroundColor = headerColor;
    }

    const sidebar = document.getElementById("sidebar");
    const content = document.getElementById("content");
    const header = document.getElementById("header"); 
    const toggleBtn = document.getElementById("toggleBtn");
    const icon = toggleBtn.querySelector("i");

    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("collapsed");
      content.classList.toggle("collapsed");
      header.classList.toggle("collapsed");

      if (sidebar.classList.contains("collapsed")) {
        icon.classList.replace("bi-chevron-left", "bi-chevron-right");
      } else {
        icon.classList.replace("bi-chevron-right", "bi-chevron-left");
      }
    });

    // Live Clock
    function updateClock() {
      const now = new Date();
      const tanggal = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
      const jam = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

      document.getElementById('live-clock').textContent = `${tanggal} | ${jam}`;
    }
    setInterval(updateClock, 1000);
    updateClock();
  </script>
</body>
</html>
