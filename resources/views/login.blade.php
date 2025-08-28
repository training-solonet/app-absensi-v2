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
      background: #fff7f0;
    }

    .wrapper {
      display: flex;  
      height: 100vh; 
      overflow: hidden;
    }

    .left-section {
      position: relative;
      width: 50%;             
      height: 100vh;           
      background: #8DD8FF;
      color: white;
      clip-path: ellipse(100% 100% at 0% 100%);
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .left-section img.logo {
      max-width: 500px;
      height: auto;
      position: absolute;
      top: 40%;
      left: 50%;
      transform: translateX(-50%);
    }

    .left-section img.illustration {
      max-width: 350px;
      position: absolute;
      top: 80%;        
      left: 80%;       
      transform: translate(-50%, -50%);
      z-index: 5;
      overflow: visible; 
    }
    .right-section {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 50px;
    }

    .btn-custom {
      background: #4E71FF;
      color: white;
      border-radius: 100px;
      display: block;
      margin: 0 auto;      
      max-width: 250px;    
    }

    .social-icons a {
      text-decoration: none;
      color: #444;          
      font-size: 30px;      
      margin: 0 12px;       
      transition: color 0.3s ease;
    }
    .social-icons a:hover .bi-facebook {
      color: #1877f2;
    }
    .social-icons a:hover .bi-instagram {
      color: #e1306c;
    }
    .social-icons a:hover .bi-globe {
      color: #28a745;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <!-- Kiri -->
    <div class="left-section">
      <img src="{{ asset('img/solonet.png') }}" alt="Logo" class="logo">
      <img src="{{ asset('img/software.png') }}" alt="Ilustrasi" class="illustration">
    </div>

    <!-- Kanan -->
    <div class="right-section d-flex flex-column align-items-center justify-content-center">
      <h3 class="mb-4">Masuk</h3>
      <form action="{{ route('prosesLogin') }}" method="POST">
        @csrf
        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-custom w-20">MASUK</button>
      </form>

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
    </div>
  </div>
</body>
</html>
