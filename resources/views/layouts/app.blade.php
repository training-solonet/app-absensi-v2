<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PMB PEI - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-white border-end vh-100 p-3" style="width: 250px;">
            <h4 class="mb-4">PMB PEI</h4>
            <div class="text-center mb-3">
                <img src="https://via.placeholder.com/80" class="rounded-circle mb-2" alt="avatar">
                <p class="fw-bold mb-0">{{ Auth::user()->name }}</p>
                <span class="badge bg-warning text-dark">Administrator</span>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="{{ route('dashboard') }}" class="nav-link active">🏠 Beranda</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link">📂 Data Master</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link">💰 Data Transaksi</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link">📢 Pengumuman</a></li>
            </ul>
            <form action="{{ route('logout') }}" method="POST" class="mt-4">
                @csrf
                <button class="btn btn-danger w-100">Logout</button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4 bg-light">
            @yield('content')
        </div>
    </div>
</body>
</html>
