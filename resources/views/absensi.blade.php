<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Absensi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
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

        .sidebar .nav-link:hover { background: rgba(255,255,255,0.12); color: #fff; }

        .sidebar .nav-link i { font-size: 18px; color: inherit; }

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
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.35);
            z-index: 950;
            display: none;
        }
        .overlay.show { display: block; }

        @media (max-width: 991.98px) {
            .content {
                margin-left: 0;
                padding-top: 70px;
            }
            header.navbar {
                left: 0;
            }
            .toggle-btn { 
                display: none;
            }
            .sidebar {
                width: 80%;
                max-width: 260px;
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
        }
        .dt-container .dt-length label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .dt-container .dt-length select {
            margin-right: 6px; 
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
            <a href="{{ route('profile') }}" class="text-decoration-none">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin" width="60"
                    class="mb-2 rounded-circle">
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

        <!-- Tombol Toggle -->
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
                    <h5 class="fw-bold mb-0 text-light">Laporan Absensi</h5>
                </div>
                <div class="d-flex align-items-center">
                    <span class="text-white me-3" id="live-clock"></span>

                    <!-- Dropdown Profil -->
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center" id="profileDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Profile"
                                width="40" height="40" class="rounded-circle border-2 border-primary">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown">
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item d-flex align-items-center text-danger border-0 bg-transparent">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
        </header>

        <!-- Card Laporan Absensi -->
        <div class="card card-custom mt-4 p-3">
            <div class="card-body">
                <!-- Filter -->
                <form class="row g-3 mb-4" method="GET" action="{{ url('/absensi') }}">
                    <div class="col-md-4">
                        <label for="tanggal" class="form-label">Pilih Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ isset($selectedDate) ? $selectedDate->toDateString() : '' }}">                    </div>
                    <div class="col-md-4">
                        <label for="namaSiswa" class="form-label">Pilih nama siswa</label>
                        <select id="namaSiswa" class="form-select">
                            <option value="">Open this select menu</option>
                            @php
                                $listSiswa = isset($siswas) && $siswas
                                    ? collect($siswas)
                                    : (isset($absen) ? collect($absen)->pluck('siswa')->filter()->unique('id') : collect());
                            @endphp
                            @foreach($listSiswa as $siswa)
                                @php
                                    $sid = is_object($siswa) ? ($siswa->id ?? $siswa->id_siswa ?? '') : (is_array($siswa) ? ($siswa['id'] ?? '') : '');
                                    $sname = is_object($siswa) ? ($siswa->name ?? '') : (is_array($siswa) ? ($siswa['name'] ?? '') : (string)$siswa);
                                @endphp
                @endphp
                @if(!empty($sname))
                    <option value="{{ $sname }}">{{ $sname }}</option>
                @endif
                @endforeach
                </select>
            </div>
        </form>

        @php
            $prevDateDisplay = isset($selectedDate)
                ? \Carbon\Carbon::parse($selectedDate)->subDay()->translatedFormat('d F Y')
                : \Carbon\Carbon::yesterday()->translatedFormat('d F Y');
        @endphp
        
        <!-- Tabel -->
        <h5 class="fw-bold mb-3">Data Absensi</h5>
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="absensiTable">
                <thead style="background-color: #8DD8FF;">
                  <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Waktu Masuk</th>
                        <th>Waktu Keluar</th>
                        <th>Keterangan</th>
                        <th>Catatan</th>
                      </tr>
                    </thead>
                  <tbody>
              @forelse($absen as $absensi)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $absensi->siswa->name }}</td>
                <td>{{ date('d/m/Y', strtotime($absensi->tanggal)) }}</td>
                <td>{{ date('H:i:s', strtotime($absensi->waktu_masuk)) }}</td>
                <td>{{ date('H:i:s', strtotime($absensi->waktu_keluar)) }}</td>
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
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
      const table = $('#absensiTable').DataTable();
      // Filter berdasarkan nama siswa (kolom index 1)
      $('#namaSiswa').on('change', function() {
        table.column(1).search(this.value).draw();
      });
      // Ketika tanggal berubah, submit form agar data dimuat dari server sesuai tanggal
      $('#tanggal').on('change', function() {
        $(this).closest('form')[0].submit();
      });
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

        // Mobile: open/close sidebar
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
    </script>
</body>
</html>
