<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
      overflow-x: hidden; /* prevent horizontal cut-off on mobile */
    }
    .sidebar {
      height: 100vh;
      background-color: #3F63E0; 
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
      background: #F4D03F; 
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

    #header h5 {
      margin-right: 10px; 
    }

    #live-clock {
      margin-left: 12px; 
    }

    header.navbar .dropdown > a img {
      margin-right: 6px; 
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
      padding-left: 10px !important; /* Tambahan agar kiri lebih mepet */
      padding-right: 20px !important; /* Tambahan agar kanan tidak kepotong */
    }
    header.navbar.collapsed {
      left: 70px;
    }

    #header .container-fluid {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: nowrap !important;
    }

    #header .d-flex.align-items-center:first-child {
      margin-left: -5px; /* Mepetkan icon dan teks ke kiri */
      gap: 6px;
    }

    #header .d-flex.align-items-center:last-child {
      gap: 10px;
      padding-right: 6px;
    }

    #live-clock {
      white-space: nowrap;
      font-size: 0.9rem;
      color: #fff;
    }

  @media (max-width: 575.98px) {
      #header .container-fluid {
        flex-direction: row !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 0 !important;
      }
      .content { margin-left: 0; padding-top: 70px; }
      header.navbar { left: 0; }
  .sidebar { width: 80%; max-width: 320px; transform: translateX(-100%); visibility: hidden; }
  .sidebar.open { transform: translateX(0); visibility: visible; }
      #live-clock {
        font-size: 0.8rem;
        white-space: nowrap;
      }
      #header h5 {
        font-size: 1rem;
      }
      #header .d-flex.align-items-center:first-child {
        margin-left: -6px;
      }
      #header .d-flex.align-items-center:last-child {
        padding-right: 2px;
      }
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

    .overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.35); z-index: 950; display: none; }
    .overlay.show { display: block; }

    .chart-donut { position: relative; height: 140px; }
    .chart-bar { position: relative; height: 260px; }
    @media (max-width: 575.98px) {
      .chart-donut { height: 120px; }
      .chart-bar { height: 220px; }
    }
    @media (min-width: 992px) {
      .chart-donut { height: 160px; }
      .chart-bar { height: 300px; }
    }

    @media (max-width: 991.98px) {
      .content { margin-left: 0; padding-top: 70px; }
      header.navbar { left: 0; }
      .toggle-btn { display: none; }
      .sidebar { width: 80%; max-width: 260px; transform: translateX(-100%); visibility: hidden; }
      .sidebar.open { transform: translateX(0); visibility: visible; }
      .overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.35); z-index: 950; display: none; }
      .overlay.show { display: block; }
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
<div class="overlay" id="overlay"></div>

<div class="content" id="content">

  <!-- Header -->
  <header class="navbar shadow-sm px-4" id="header">
    <div class="container-fluid d-flex justify-content-between align-items-center h-100">
      <div class="d-flex align-items-center">
        <button class="btn btn-link text-white d-lg-none p-0" id="mobileMenuBtn" aria-label="Menu" style="margin-left:-6px;">
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
                 alt="Profile" width="42" height="42" class="rounded-circle border-2 border-primary">
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
            <h6 class="mb-1">Terlambat/Tidak Hadir</h6>
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
    <!-- Statistik Kehadiran Bulan Ini -->
    <div class="col-md-6">
      <div class="card card-custom p-3 h-100">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h5 class="fw-bold mb-0">Jumlah Hadir</h5>
          <form method="GET" action="{{ route('dashboard') }}" class="d-flex gap-2">
            <select name="month" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 180px;">
              @foreach($fullMonthNames as $key => $month)
                <option value="{{ $key }}" @if(($selectedMonth ?? now()->month) == $key) selected @endif>
                  {{ $month }} 
                </option>
              @endforeach
            </select>
          </form>
        </div>
        
        <div class="mt-2" style="max-height: 300px; overflow-y: auto;">
          @forelse($absensiBulanIni ?? [] as $absen)
            @php
                $namaSiswa = $absen->nama_siswa ?? 'Siswa #' . ($absen->id ?? '?');
            @endphp
            <div class="d-flex justify-content-between align-items-center px-0 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
              <div class="d-flex align-items-center text-truncate" style="max-width: 70%;">
                <i class="bi bi-person-circle me-2 text-secondary" style="font-size:1.2rem; flex-shrink: 0;"></i>
                <span class="text-truncate" title="{{ $namaSiswa }}">
                  {{ ucwords(strtolower($namaSiswa)) }}
                </span>
              </div>
              <span class="badge bg-primary rounded-pill" style="flex-shrink: 0;">
                {{ $absen->total_hadir ?? 0 }}x
              </span>
            </div>
          @empty
            <div class="text-muted py-2">
              <i class="bi bi-info-circle me-1"></i> Belum ada data kehadiran untuk bulan ini
            </div>
          @endforelse
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card card-custom p-3 h-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="fw-bold mb-0">Jumlah Terlambat</h5>
          <form method="GET" action="{{ route('dashboard') }}" class="d-flex gap-2">
          </form>
        </div>
        <div class="mt-2" style="max-height: 300px; overflow-y: auto;">
          @forelse(($terlambatPerSiswa ?? []) as $row)
            @php
                $namaSiswa = $row->siswa->name ?? 'Siswa #' . ($row->id_siswa ?? '?');
            @endphp
            <div class="d-flex justify-content-between align-items-center px-0 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
              <div class="d-flex align-items-center text-truncate" style="max-width: 70%;">
                <i class="bi bi-person-circle me-2 text-secondary" style="font-size:1.2rem; flex-shrink: 0;"></i>
                <span class="text-truncate" title="{{ $namaSiswa }}">
                  {{ ucwords(strtolower($namaSiswa)) }}
                </span>
              </div>
              <span class="badge bg-danger rounded-pill" style="flex-shrink: 0;">
                {{ $row->total ?? 0 }}x
              </span>
            </div>
          @empty
            <div class="text-muted py-2">
              <i class="bi bi-info-circle me-1"></i> Belum ada data terlambat untuk bulan ini
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <!-- Data Keterlambatan (terbaru) -->
  <div class="card card-custom mt-4 p-3">
    <div class="card-body">
      @php
          $terlambat = $terlambat ?? collect();
      @endphp
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0">Data Keterlambatan</h5>
      </div>
      <div class="row g-3">
        @forelse($terlambat as $row)
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
                  <h6 class="mb-1 fw-bold text-primary">{{ ucwords(string:strtolower($row->siswa->name ?? '-')) }}</h6>
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
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // === kode JS kamu tetap sama ===
  const sidebar = document.getElementById("sidebar");
  const content = document.getElementById("content");
  const header = document.getElementById("header");
  const toggleBtn = document.getElementById("toggleBtn");
  const icon = toggleBtn.querySelector("i");
  const overlay = document.getElementById('overlay');
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const toggleIcon = toggleBtn ? toggleBtn.querySelector('i') : null;

  function openMobileSidebar() {
    sidebar.classList.add('open');
    overlay.classList.add('show');
    if (mobileMenuBtn) {
      const mi = mobileMenuBtn.querySelector('i');
      if (mi) { mi.classList.remove('bi-list'); mi.classList.add('bi-x'); }
    }
  }
  function closeMobileSidebar() {
    sidebar.classList.remove('open');
    overlay.classList.remove('show');
    if (mobileMenuBtn) {
      const mi = mobileMenuBtn.querySelector('i');
      if (mi) { mi.classList.remove('bi-x'); mi.classList.add('bi-list'); }
    }
  }

  // mobile menu button toggles overlay sidebar on small screens
  if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      if (window.innerWidth < 992) {
        if (sidebar.classList.contains('open')) closeMobileSidebar();
        else openMobileSidebar();
      }
    });
  }

  // document click closes mobile sidebar if open
  document.addEventListener('click', function(ev) {
    const target = ev.target;
    if (sidebar.classList.contains('open') && !sidebar.contains(target) && !(mobileMenuBtn && mobileMenuBtn.contains(target))) {
      closeMobileSidebar();
    }
  });

  if (overlay) overlay.addEventListener('click', closeMobileSidebar);

  // Keep desktop toggle behavior for the left chevron button
  if (toggleBtn) {
    toggleBtn.addEventListener('click', function() {
      sidebar.classList.toggle('collapsed');
      content.classList.toggle('collapsed');
      header.classList.toggle('collapsed');
      if (toggleIcon) {
        if (sidebar.classList.contains('collapsed')) toggleIcon.classList.replace('bi-chevron-left', 'bi-chevron-right');
        else toggleIcon.classList.replace('bi-chevron-right','bi-chevron-left');
      }
    });
  }

  // reset on resize
  window.addEventListener('resize', function() {
    if (window.innerWidth >= 992) {
      if (sidebar.classList.contains('open')) sidebar.classList.remove('open');
      if (overlay.classList.contains('show')) overlay.classList.remove('show');
      const mi = mobileMenuBtn ? mobileMenuBtn.querySelector('i') : null;
      if (mi && mi.classList.contains('bi-x')) mi.classList.replace('bi-x','bi-list');
    }
  });


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
