<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
      font-family: 'Poppins', sans-serif;
      overflow: hidden;
    }

    .bubble {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.15);
      filter: blur(2px);
      animation: float 10s infinite;
    }

    .bubble:nth-child(1) {
      width: 120px; height: 120px;
      top: 10%; left: 15%;
    }
    .bubble:nth-child(2) {
      width: 200px; height: 200px;
      top: 50%; left: 70%;
      animation-duration: 15s;
    }
    .bubble:nth-child(3) {
      width: 80px; height: 80px;
      bottom: 15%; right: 20%;
      animation-duration: 12s;
    }

    @keyframes float {
      0% { transform: translateY(0); }
      50% { transform: translateY(-30px); }
      100% { transform: translateY(0); }
    }

    .login-card {
      position: relative;
      z-index: 5;
      width: 100%;
      max-width: 400px;
      padding: 2rem;
      border-radius: 20px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(15px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
      color: white;
    }

    .login-card h3 {
      text-align: center;
      margin-bottom: 1.5rem;
      font-weight: bold;
    }

    .form-control {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      border-radius: 10px;
      color: #fff;
    }

    .form-control::placeholder {
      color: rgba(255, 255, 255, 0.7);
    }

    .btn-custom {
      background: #ffb300;
      color: #000;
      font-weight: bold;
      border-radius: 50px;
      width: 100%;
      padding: 10px;
    }

    .extra-links {
      margin-top: 1rem;
      text-align: center;
    }
    .extra-links a {
      color: #fff;
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <!-- Background bubbles -->
  <div class="bubble"></div>
  <div class="bubble"></div>
  <div class="bubble"></div>

  <!-- Login Card -->
  <div class="login-card">
    <h3>Login</h3>
    
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    
    <form action="{{ route('prosesLogin') }}" method="POST">
      @csrf
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <button type="submit" class="btn btn-custom">Login</button>
    </form>
  </div>

  <div class="text-center mt-4">
        <div class="social-icons">
          <!-- Facebook -->
          <a href="https://www.facebook.com/solonetjalabuana" target="_blank">
            <i class="bi bi-facebook"></i>
          </a>
          <!-- Instagram -->
          <a href="https://www.instagram.com/solonet_internet/" target="_blank">
            <i class="bi bi-instagram"></i>
          </a>
          <!-- Website -->
          <a href="https://www.waze.com/id/live-map/directions/id/jawa-tengah/connectis-solonet?to=place.ChIJSRrvQpwWei4RbZ0N4I3fZu4" target="_blank">
            <i class="bi bi-globe"></i>
          </a>
        </div>
      </div>
</body>
</html>
