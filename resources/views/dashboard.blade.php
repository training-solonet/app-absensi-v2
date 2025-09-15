<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
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
      background-color: #1679AB;
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
      color: #fff; 
      margin-bottom: 10px;
      display: flex;
      align-items: center;
    }
    .sidebar .nav-link:hover { 
      color: #fff; 
    }
    .sidebar .nav-link i {
      font-size: 18px;
      margin-right: 8px;
    }
    .sidebar.collapsed .nav-link {
      justify-content: center;
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
      background-color: #1679AB;
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
    .sidebar .nav-link.active {
      background: #205781;
      color: #fff;    
      border-radius: 8px;
      padding: 10px;
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
  </style>
</head>
<body>
  
<!-- Sidebar -->
<div class="sidebar p-3" id="sidebar">
  <div class="text-center mb-4">
    <img src="{{ asset('img/logo.png')}}" alt="Connectis Logo" width="120">
  </div>

  <div class="d-flex flex-column align-items-center text-center mb-4">
    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" 
         alt="Admin" width="60" class="mb-2 rounded-circle">
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

<!-- Content -->
<div class="content" id="content">

  <!-- Header -->
  <header class="navbar shadow-sm px-4" id="header">
    <div class="container-fluid d-flex justify-content-between align-items-center h-100">
      <h5 class="fw-bold mb-0 text-light">Dashboard</h5>
  
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
              <a class="dropdown-item d-flex align-items-center" href="{{ route('profile') }}">
                <i class="bi bi-person-circle me-2"></i> Profile
              </a>
            </li>
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
  <div class="row mb-3">
    <!-- Card Selamat Datang -->
    <div class="col-md-6">
      <div class="card card-custom card-orange p-3 text-center">
        <div class="row align-items-center">
          <div class="col-8 text-start">
            <h4>Selamat Datang, I'am Admin</h4>
            <p>Terus pantau kegiatan penerimaan mahasiswa baru dan absensi siswa PKL</p>
          </div>
          <div class="col-4 text-end">
            <img src="{{ asset('img/absen.png') }}" alt="Welcome Image" class="img-fluid" style="max-height:100px;">
          </div> 
        </div>
      </div>
    </div>

    <!-- Statistik Absen (Donut Chart) -->
    <div class="col-md-6">
      <div class="card card-custom p-3">
        <h5 class="fw-bold mb-3">Statistics Absen</h5>
        <div class="row text-center">
          <div class="col-md-4">
            <canvas id="izinChart" width="120" height="120"></canvas>
            <p class="mt-2">Rata rata Izin</p>
          </div>
          <div class="col-md-4">
            <canvas id="alpaChart" width="120" height="120"></canvas>
            <p class="mt-2">Rata rata Alpa</p>
          </div>
          <div class="col-md-4">
            <canvas id="hadirChart" width="120" height="120"></canvas>
            <p class="mt-2">Rata rata Hadir</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Cards -->
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-4 mb-3">
        <div class="summary-card d-flex justify-content-between align-items-center p-3">
          <div>
            <h6 class="mb-1">Jumlah Siswa PKL</h6>
            <h3 class="mb-0">10</h3>
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
            <h3 class="mb-0">7</h3>
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
            <h3 class="mb-0">3</h3>
          </div>
          <div class="icon-wrapper">
            <i class="bi bi-geo-alt"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Data Keterlambatan -->
  <div class="card card-custom mt-4 p-3">
    <div class="card-body">
      <h5 class="fw-bold mb-3">Data Keterlambatan</h5>
      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead class="table-light">
            <tr>
              <th>Nama</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
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
    const tanggal = now.toLocaleDateString('id-ID', {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    });
    const jam = now.toLocaleTimeString('id-ID', {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit'
    });
    document.getElementById('live-clock').textContent = `${tanggal} | ${jam}`;
  }
  setInterval(updateClock, 1000);
  updateClock();

  // Fungsi untuk buat donut chart
  function buatChart(id, value, color) {
    return new Chart(document.getElementById(id), {
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
          tooltip: { enabled: false }
=======
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
>>>>>>> f43b43a0f91106ee22064ebb62744ea43e8dd97e
        }

        .sidebar {
            height: 100vh;
            background-color: #607EAA;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
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
            color: #fff;
            /* default putih sebelum diklik */
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link:hover {
            color: #fff;
        }

        .sidebar .nav-link i {
            font-size: 18px;
            margin-right: 8px;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
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
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
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
            background-color: #607EAA;
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

        .sidebar .nav-link.active {
            background: #687EFF;
            color: #fff;
            border-radius: 8px;
            padding: 10px;
        }

        .card-custom {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .card-orange {
            background: linear-gradient(135deg, #60B5FF, #ff9f68);
            color: #fff;
        }

        .summary-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
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
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar p-3" id="sidebar">
        <div class="text-center mb-4">
            <img src="{{ asset('img/logo.png') }}" alt="Connectis Logo" width="120">
        </div>

        <div class="d-flex flex-column align-items-center text-center mb-4">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin" width="60"
                class="mb-2 rounded-circle">
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
        </nav>

        <button class="toggle-btn" id="toggleBtn">
            <i class="bi bi-chevron-left"></i>
        </button>
    </div>

    <!-- Content -->
    <div class="content" id="content">

        <!-- Header -->
        <header class="navbar shadow-sm px-4" id="header">
            <div class="container-fluid d-flex justify-content-between align-items-center h-100">
                <h5 class="fw-bold mb-0 text-light">Dashboard</h5>

                <div class="d-flex align-items-center">
                    <span class="text-white me-3" id="live-clock"></span>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center" id="profileDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Profile"
                                width="40" height="40" class="rounded-circle border-2 border-primary">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('profile') }}">
                                    <i class="bi bi-person-circle me-2"></i> Profile
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item d-flex align-items-center text-danger border-0 bg-transparent">
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
        <div class="row mb-3">
            <!-- Card Selamat Datang -->
            <div class="col-md-6">
                <div class="card card-custom card-orange p-3 text-center">
                    <div class="row align-items-center">
                        <div class="col-8 text-start">
                            <h4>Selamat Datang, I'am Admin</h4>
                            <p>Terus pantau kegiatan penerimaan mahasiswa baru dan absensi siswa PKL</p>
                        </div>
                        <div class="col-4 text-end">
                            <img src="{{ asset('img/absen.png') }}" alt="Welcome Image" class="img-fluid"
                                style="max-height:100px;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Absen (Donut Chart) -->
            <div class="col-md-6">
                <div class="card card-custom p-3">
                    <h5 class="fw-bold mb-3">Statistics Absen</h5>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <canvas id="izinChart" width="120" height="120"></canvas>
                            <p class="mt-2">Rata rata Izin</p>
                        </div>
                        <div class="col-md-4">
                            <canvas id="alpaChart" width="120" height="120"></canvas>
                            <p class="mt-2">Rata rata Alpa</p>
                        </div>
                        <div class="col-md-4">
                            <canvas id="hadirChart" width="120" height="120"></canvas>
                            <p class="mt-2">Rata rata Hadir</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="summary-card d-flex justify-content-between align-items-center p-3">
                        <div>
                            <h6 class="mb-1">Jumlah Siswa PKL</h6>
                            <h3 class="mb-0">10</h3>
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
                            <h3 class="mb-0">7</h3>
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
                            <h3 class="mb-0">3</h3>
                        </div>
                        <div class="icon-wrapper">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Keterlambatan -->
        <div class="card card-custom mt-4 p-3">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Data Keterlambatan</h5>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jam</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
            const tanggal = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            const jam = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('live-clock').textContent = `${tanggal} | ${jam}`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Fungsi untuk buat donut chart
        function buatChart(id, value, color) {
            return new Chart(document.getElementById(id), {
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
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: false
                        }
                    }
                }
            });
        }

        // Generate chart
        buatChart('izinChart', 5, '#f39c12');
        buatChart('alpaChart', 36, '#27ae60');
        buatChart('hadirChart', 12, '#e74c3c');
    </script>
</body>

</html>
