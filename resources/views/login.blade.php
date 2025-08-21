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
      width: 50%;             
      height: 100vh;           
      background: #8DD8FF;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;

      clip-path: ellipse(100% 100% at 0% 100%);
    }

   .left-section img {
    max-width: 500px;
    height: auto;      
    margin: 10px 0;
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

    .social-icons i {
      font-size: 1.5rem;
      margin: 0 10px;
      color: #555;
      transition: 0.3s;
    }
    .social-icons i:hover {
      color: #ff7e5f;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <!-- Kiri -->
    <div class="left-section">
      <img src="{{ asset('img/solonet.png') }}" alt="Logo">
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
          <a href="#"><i class="bi bi-facebook"></i></a>
          <a href="#"><i class="bi bi-instagram"></i></a>
          <a href="#"><i class="bi bi-globe"></i></a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
