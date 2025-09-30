<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Siswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff;
    }
    .sidebar {
      height: 100vh;
      background-color: #3F63E0; /* match reference */
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
    .sidebar.collapsed .text-center img[alt="Logo"] {
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
    .sidebar .nav-link:hover { background: rgba(255,255,255,0.12); color: #fff; }
    .sidebar .nav-link i { font-size: 18px; color: inherit; }
    .sidebar.collapsed .nav-link {
      justify-content: center;
    }
    .sidebar .nav-link.active { background: rgba(255,255,255,0.18); color: #FFFFFF; }
    .sidebar .nav-link.active::before { content: ''; position: absolute; left: -8px; top: 50%; transform: translateY(-50%); width: 4px; height: 24px; background: #F4D03F; border-radius: 2px; }
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
      background-color:#3F63E0;
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
    /* DataTables length control spacing */
    .dt-container .dt-length label {
      display: inline-flex;
      align-items: center;
      gap: 8px; /* space between select and text */
    }
    .dt-container .dt-length select {
      margin-right: 6px; /* fallback spacing */
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar p-3" id="sidebar">
    <div class="text-center mb-4">
      <img src="{{ asset('img/logo.png') }}" alt="Logo" width="120">
    </div>

    <!-- Profil Admin -->
    <div class="d-flex flex-column align-items-center text-center mb-4">
      <a href="{{ route('profile') }}" class="text-decoration-none">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin" width="60" class="mb-2 rounded-circle">
      </a>
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
      <a href="{{ route('data-uid') }}" class="nav-link">
        <i class="bi bi-credit-card-2-front"></i>
        <span>Data UID</span>
    </a>
    </nav>  

    <!-- Tombol Panah -->
    <button class="toggle-btn" id="toggleBtn">
      <i class="bi bi-chevron-left"></i>
    </button>
  </div>

  <!-- Content -->
  <div class="content" id="content">

    <!-- Header -->
    <header class="navbar shadow-sm px-4" id="header">
      <div class="container-fluid d-flex justify-content-between align-items-center h-100">
        <h5 class="fw-bold mb-0 text-light">Data Siswa</h5>

        <div class="d-flex align-items-center">
        <span class="text-white me-3" id="live-clock"></span>

          <!-- Dropdown Profil -->
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

      <div class="table-responsive">
      <table class="table table-bordered table-striped" id="siswaTable">
        <thead style="background-color: #8DD8FF;">
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Sekolah</th> 
          </tr>
        </thead>
        <tbody>
          @forelse($siswas as $siswa)
            <tr>
              <td>{{ $siswa->id }}</td>
              <td>{{ $siswa->name }}</td>
              <td>{{ $siswa->schools }}</td> 
            </tr>
          @empty
          @endforelse
        </tbody>
      </table>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function() {
    $('#siswaTable').DataTable();
  });
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

    // Format tanggal
    const tanggal = now.toLocaleDateString('id-ID', {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    });

    // Format jam
    const jam = now.toLocaleTimeString('id-ID', {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit'
    });

    // Gabung dengan tanda |
    document.getElementById('live-clock').textContent = `${tanggal} | ${jam}`;
  }

  setInterval(updateClock, 1000);
  updateClock();
</script>
</body>
</html>
