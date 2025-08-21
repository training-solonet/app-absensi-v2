<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }
    .sidebar {
      height: 100vh;
      background-color: #fff;
      box-shadow: 2px 0 10px rgba(0,0,0,0.1);
      padding: 20px;
      position: fixed;
      top: 0;
      left: 0;
      width: 240px;
    }
    .sidebar .nav-link {
      font-weight: 500;
      color: #333;
      margin-bottom: 10px;
    }
    .sidebar .nav-link.active {
      background: #ff7b54;
      color: #fff;
      border-radius: 8px;
      padding: 10px;
    }
    .content {
      margin-left: 260px;
      padding: 20px;
    }
    .card-custom {
      border-radius: 15px;
      border: none;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    .card-orange {
      background: linear-gradient(135deg, #ff7b54, #ff9f68);
      color: #fff;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="mb-4">PMB PEI</h4> 
    <div class="d-flex align-items-center mb-4">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin" width="50" class="me-2">
      <div>
        <span class="badge bg-warning text-dark">Administrator</span>
        <p class="mb-0">Iam Admin</p>
      </div>
    </div>
    <nav class="nav flex-column">
      <a class="nav-link active" href="#">Beranda</a>
      <a class="nav-link" href="#">Data Master</a>
      <a class="nav-link" href="#">Data Transaksi</a>
      <a class="nav-link" href="#">Pengumuman</a>
    </nav>
  </div>

  <!-- Content -->
  <div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3>Beranda</h3>
      <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y H:i:s') }}</span>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <div class="card card-custom card-orange p-4">
          <h4>Selamat Datang, Iam Admin</h4>
          <p>Terus pantau kegiatan penerimaan mahasiswa baru politeknik engineering indorama</p>
          <button class="btn btn-light">Lihat Pendaftar</button>
        </div>
      </div>
      <div class="col-md-6 mb-3">
        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="card card-custom p-3">
              <h6>Pendaftar</h6>
              <h3>1</h3>
              <small>Pendaftar saat ini</small>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="card card-custom p-3">
              <h6>Hasil Seleksi</h6>
              <h3>1/1</h3>
              <small>Sudah diumumkan</small>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="card card-custom p-3">
              <h6>Total Pengguna</h6>
              <h3>2</h3>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="card card-custom p-3">
              <h6>Jumlah Pembayaran</h6>
              <h3>Rp 0</h3>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</body>
</html>
