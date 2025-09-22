<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }
    .sidebar {
      height: 100vh;
      background-color: #3F63E0; /* blue base like reference */
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
      font-weight: 600;
      color: #EAF2FF;
      margin: 4px 8px 10px 8px;
      display: flex;
      align-items: center;
      gap: 10px;
      border-radius: 12px;
      padding: 10px 12px;
      position: relative;
    }
    .sidebar .nav-link i {
      font-size: 18px;
      color: inherit;
    }
    .sidebar .nav-link:hover { 
      background: rgba(255,255,255,0.12);
      color: #FFFFFF;
    }
    .sidebar.collapsed .nav-link {
      justify-content: center;
    }
    .sidebar .nav-link.active {
      background: rgba(255,255,255,0.18);
      color: #FFFFFF;
    }
    .sidebar .nav-link.active::before {
      content: '';
      position: absolute;
      left: -8px;
      top: 50%;
      transform: translateY(-50%);
      width: 4px;
      height: 24px;
      background: #F4D03F; /* yellow accent */
      border-radius: 2px;
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
      background-color: #3F63E0;
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
      border-radius: 15px;
      border: none;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    .card-orange { 
      background: linear-gradient(135deg, #60B5FF, #ff9f68); 
      color: #fff;
    }
    .square-box {
      border-radius: 0 !important;
      background: #ffffff !important;
      color: #333 !important;
      border: 1px solid #e5e7eb !important; 
      box-shadow: none !important;
      min-height: 260px; 
    }
    .summary-card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      transition: transform 0.2s ease;
    }
    .summary-card:hover {
      transform: translateY(-3px);
    }
    .summary-card h6 {
      color: #666;
      font-weight: 500;
    }
    .summary-card h3 {
      font-weight: bold;
      color: #333;
    }
    .icon-wrapper {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      background: linear-gradient(135deg, #4E71FF, #6a8dff);
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
      font-size: 20px;
    }

    /* Overlay for mobile */
    .overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.35); z-index: 950; display: none; }
    .overlay.show { display: block; }

    /* Mobile responsiveness */
    @media (max-width: 991.98px) {
      .content { margin-left: 0; padding-top: 70px; }
      header.navbar { left: 0; }
      .toggle-btn { display: none; }
      .sidebar { width: 80%; max-width: 260px; transform: translateX(-100%); }
      .sidebar.open { transform: translateX(0); }
    }
  </style>
</head>
<body>
  
<!-- Sidebar -->
<div class="sidebar p-3" id="sidebar">
  <div class="text-center mb-4">
    <img src="{{ asset('img/logo.png')}}" alt="Connectis Logo" width="120">
  </div>

  <div class="d-flex flex-column align-items-center text-center mb-4">
    <a href="{{ route('profile') }}" class="text-decoration-none">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" 
           alt="Admin" width="60" class="mb-2 rounded-circle">
    </a>
    <div>
      <span class="badge bg-white text-dark">Administrator</span>
    </div>
  </div>

  <nav class="nav flex-column">   
    <a class="nav-link active" href="/dashboard">
      <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
    </a>
    <a class="nav-link" href="{{ route('siswa.index') }}">
      <i class="bi bi-people-fill"></i> <span>Data Siswa</span>
    </a>
    <a class="nav-link" href="{{ url('/absensi') }}">
      <i class="bi bi-clipboard-check"></i> <span>Laporan Absensi</span>
    </a>
    <li class="nav-item">
    <a href="{{ route('data-uid') }}" class="nav-link">
        <i class="bi bi-credit-card-2-front"></i>
        <span>Data UID</span>
    </a>
</li>
  </nav>  

  <button class="toggle-btn" id="toggleBtn">
    <i class="bi bi-chevron-left"></i>
  </button>
</div>
<!-- Overlay for mobile -->
<div class="overlay" id="overlay"></div>

<!-- Content -->
<div class="content" id="content">

  <!-- Header -->
  <header class="navbar shadow-sm px-4" id="header">
    <div class="container-fluid d-flex justify-content-between align-items-center h-100">
      <div class="d-flex align-items-center">
        <button class="btn btn-link text-white d-lg-none me-2 p-0" id="mobileMenuBtn" aria-label="Menu">
          <i class="bi bi-list" style="font-size: 1.5rem;"></i>
        </button>
        <h5 class="fw-bold mb-0 text-light">Dashboard</h5>
      </div>
  
      <div class="d-flex align-items-center">
        <span class="text-white me-3" id="live-clock"></span>
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center" id="profileDropdown" 
             role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" 
                 alt="Profile" width="40" height="40" class="rounded-circle border-2 border-primary">
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown">
            <li>
              <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-items-center text-danger border-0 bg-transparent">
                  <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </header>

  <!-- Dashboard Content -->
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-4 mb-3">
        <div class="summary-card d-flex justify-content-between align-items-center p-3">
          <div>
            <h6 class="mb-1">Jumlah Siswa PKL</h6>
            <h3 class="mb-0">{{ $totalSiswa ?? 0 }}</h3>
          </div>
          <div class="icon-wrapper">
            <i class="bi bi-people-fill"></i>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="summary-card d-flex justify-content-between align-items-center p-3">
          <div>
            <h6 class="mb-1">Hadir</h6>
            <h3 class="mb-0">{{ $hadirHariIni ?? 0 }}</h3>
          </div>
          <div class="icon-wrapper">
            <i class="bi bi-calendar-check"></i>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="summary-card d-flex justify-content-between align-items-center p-3">
          <div>
            <h6 class="mb-1">Belum/Tidak Hadir</h6>
            <h3 class="mb-0">{{ $belumAtauTidakHadir ?? 0 }}</h3>
          </div>
          <div class="icon-wrapper">
            <i class="bi bi-geo-alt"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mb-3"> 
    <div class="col-md-6">
      <div class="card card-custom p-3">
        <h5 class="fw-bold mb-3">Statistics Absen</h5>
        <div class="row text-center">
          <div class="col-md-4">
            <canvas id="izinChart" width="120" height="120"></canvas>
            <p class="mt-2 mb-0">Rata-rata izin</p>
          </div>
          <div class="col-md-4">
            <canvas id="terlambatChart" width="120" height="120"></canvas>
            <p class="mt-2 mb-0">Rata-rata terlambat</p>
          </div>
          <div class="col-md-4">
            <canvas id="hadirChart" width="120" height="120"></canvas>
            <p class="mt-2 mb-0">Rata-rata masuk</p>
          </div>
        </div>  
      </div>
    </div>
  </div>

  <!-- Data Keterlambatan -->
  <div class="card card-custom mt-4 p-3">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0">Data Keterlambatan</h5>
        <span class="badge bg-primary">{{ ($terlambat ?? collect())->count() }} siswa</span>
      </div>
      <div class="row g-3">
        @forelse(($terlambat ?? []) as $row)
          @php
            $tgl = \Carbon\Carbon::parse($row->tanggal ?? now());
            $label = $tgl->isToday() ? 'Terlambat Hari Ini' : ($tgl->isYesterday() ? 'Terlambat Kemarin' : $tgl->translatedFormat('d M Y'));
          @endphp
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-body d-flex align-items-center">
                <div class="me-3 text-secondary">
                  <i class="bi bi-person-circle" style="font-size:2.2rem;"></i>
                </div>
                <div>
                  <h6 class="mb-1 fw-bold text-uppercase text-primary">{{ $row->siswa->name ?? '-' }}</h6>
                  <small class="text-danger">{{ $label }}</small>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <div class="text-center text-muted">Belum ada data terlambat</div>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div> 

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
  const overlay = document.getElementById("overlay");
  const mobileMenuBtn = document.getElementById("mobileMenuBtn");

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

  function openSidebarMobile() {
    sidebar.classList.add('open');
    overlay.classList.add('show');
  }
  function closeSidebarMobile() {
    sidebar.classList.remove('open');
    overlay.classList.remove('show');
  }
  if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', openSidebarMobile);
  if (overlay) overlay.addEventListener('click', closeSidebarMobile);
  function updateClock() {
    const now = new Date();
    const tanggal = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    const jam = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    document.getElementById('live-clock').textContent = `${tanggal} | ${jam}`;
  }
  setInterval(updateClock, 1000);
  updateClock();
  Chart.register({
    id: 'centerText',
    afterDraw(chart, args, pluginOptions) {
      const {ctx, chartArea} = chart;
      if (!chartArea) return;
      const text = pluginOptions?.text || '';
      ctx.save();
      const centerX = (chartArea.left + chartArea.right) / 2;
      const centerY = (chartArea.top + chartArea.bottom) / 2;
      ctx.font = 'bold 18px Poppins, Arial, sans-serif';
      ctx.fillStyle = '#333';
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      ctx.fillText(text, centerX, centerY);
      ctx.restore();
    }
  });

  function buatChart(id, value, color) {
    const el = document.getElementById(id);
    if (!el) return;
    return new Chart(el, {
      type: 'doughnut',
      data: {
        datasets: [{
          data: [value, 100 - value],
          backgroundColor: [color, '#e9ecef'],
          borderWidth: 0
        }]
      },
      options: {
        cutout: '75%',
        plugins: { 
          legend: { display: false }, 
          tooltip: { enabled: false },
          centerText: { text: `${value}%` }
        }
      }
    });
  }
  const izinPct = {{ $izinPct ?? 0 }};
  const terlambatPct = {{ $terlambatPct ?? 0 }};
  const hadirPct = {{ $hadirPct ?? 0 }};
  buatChart('izinChart', izinPct, '#f39c12');
  buatChart('terlambatChart', terlambatPct, '#e74c3c');
  buatChart('hadirChart', hadirPct, '#27ae60');
</script>
</body>
</html>
