<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Absensi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
    .sidebar {
      height: 100vh;
      background-color: #8DD8FF;
      box-shadow: 2px 0 10px rgba(0,0,0,0.1);
      padding: 20px;
      position: fixed;
      top: 0;
      left: 0;
      width: 240px;
      transition: background-color 0.3s ease;
    }
    .sidebar .nav-link {
      font-weight: 500;
      color: #333;
      margin-bottom: 10px;
    }
    .sidebar .nav-link.active {
      background: #687EFF;
      color: #fff;
      border-radius: 8px;
      padding: 10px;
    }
    .content { 
        margin-left: 260px; 
        padding: 20px; 
        padding-top: 80px; 
    }
    header.navbar { 
        background-color: #ffffff; 
        transition: background-color 0.3s ease; 
    }
    .card-custom { 
        border-radius: 12px; 
        border: none; 
        box-shadow: 0 4px 8px rgba(0,0,0,0.05); 
    }
  </style>
</head>
<body>

  <!-- Sidebar sama seperti dashboard -->
  <div class="sidebar p-3" id="sidebar">
    <div class="text-center mb-4">
      <img src="{{ asset('img/logo.png') }}" alt="Connectis Logo" width="120">
    </div>
    <div class="d-flex flex-column align-items-center text-center mb-4">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin" width="60" class="mb-2 rounded-circle">
      <div>
        <span class="badge bg-white text-dark">Administrator</span>
      </div>
    </div>
    <nav class="nav flex-column">   
      <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">Dashboard</a>
      <a class="nav-link {{ request()->is('siswa') ? 'active' : '' }}" href="{{ route('siswa.index') }}">Data Siswa</a>
      <a class="nav-link {{ request()->is('absensi') ? 'active' : '' }}" href="{{ url('/absensi') }}">Laporan Absensi</a>
    </nav>  
  </div>

  <!-- Content -->
  <div class="content">

    <!-- Header -->
    <header class="navbar shadow-sm px-4" id="header"
            style="position: fixed; top: 0; left: 240px; right: 0; z-index: 1000; height: 60px;">
      <div class="container-fluid d-flex justify-content-between align-items-center h-100">
        <h5 class="fw-bold mb-0 text-dark">Laporan Absensi</h5>
        <div class="d-flex align-items-center">
          <span class="text-muted me-3">
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y H:i:s') }}
          </span>

          <!-- Dropdown Profil -->
          <div class="dropdown">
            <a href="#" class="d-flex align-items-center" id="profileDropdown" 
               role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" 
                   alt="Profile" width="40" height="40" class="rounded-circle border border-2 border-primary">
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

    <!-- Filter & Tombol Export -->
    <div class="card card-custom mt-4 p-3">
      <div class="card-body">
        <form class="row g-3">
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
      </div>
    </div>

    <!-- Tabel Laporan Absensi -->
    <div class="card card-custom mt-4 p-3">
      <div class="card-body">
        <h5 class="fw-bold mb-3">Data Absensi</h5>
        <div class="table-responsive">
          <table class="table table-striped align-middle">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Budi Santoso</td>
                <td>XI RPL 1</td>
                <td>27-08-2025</td>
                <td>07:50</td>
                <td><span class="badge bg-success">Hadir</span></td>
              </tr>
              <tr>
                <td>2</td>
                <td>Inayah Fauziah</td>
                <td>XI RPL 2</td>
                <td>27-08-2025</td>
                <td>08:20</td>
                <td><span class="badge bg-danger">Terlambat</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function setTheme(sidebarColor, headerColor) {
      document.getElementById("sidebar").style.backgroundColor = sidebarColor;
      document.getElementById("header").style.backgroundColor = headerColor;
    }
  </script>
</body>
</html>
