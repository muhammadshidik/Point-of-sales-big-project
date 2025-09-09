<?php
session_start();
require_once 'admin/controller/koneksi.php';
require_once 'admin/controller/functions.php';

if (isset($_POST['login'])) {
  $email    = $_POST['email'];
  $password = $_POST['password'];

  $queryLogin = mysqli_query($config, "SELECT * FROM user WHERE email='$email' AND password='$password'");

  if (mysqli_num_rows($queryLogin) > 0) {
    $rowLogin = mysqli_fetch_assoc($queryLogin);

    $_SESSION['id']       = $rowLogin['id'];
    $_SESSION['username'] = $rowLogin['username'];

    header("location:Menu.php");
    die;
  } else {
    header("location:Login.php?Login=failed");
    die;
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Cv. Al-Ikhlas</title>
  <link rel="icon" href="admin/content/uploads/Foto/logo-dapur-mama-niar.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      height: 100vh;
      background: linear-gradient(-45deg, #74ebd5, #9face6, #a1c4fd, #c2e9fb, #fbc2eb, #f6d365, #fdcbf1, #a18cd1, #ff9a9e);
      background-size: 900% 900%;
      animation: gradientBG 30s ease infinite;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }

    @keyframes gradientBG {
      0% {
        background-position: 0% 50%;
      }

      25% {
        background-position: 50% 50%;
      }

      50% {
        background-position: 100% 50%;
      }

      75% {
        background-position: 50% 50%;
      }

      100% {
        background-position: 0% 50%;
      }
    }

    .login-card {
      max-width: 460px;
      width: 100%;
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 20px;
      padding: 2rem;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(6px);
    }

    .form-control:focus {
      border-color: #6c63ff;
      box-shadow: none;
    }

    .btn-primary {
      background-color: #6c63ff;
      border: none;
    }

    .btn-primary:hover {
      background-color: #5a54d1;
    }

    .footer-text {
      position: fixed;
      bottom: 10px;
      width: 100%;
      text-align: center;
      color: #ffffffcc;
      font-size: 14px;
    }
  </style>
</head>

<body>

  <div class="login-card">
    <div class="text-center mb-4">
      <img src="admin/content/uploads/Foto/logo-dapur-mama-niar.png" alt="Logo" class="mb-3" style="max-width: 100px;" type="image/x-icon">
      <h2 class="fw-semibold">Cv. Al-Ikhlas</h2>
      <p class="text-muted mb-0">Silakan masuk ke akun Anda</p>
    </div>

    <?php if (isset($_GET['login']) && $_GET['login'] === 'failed'): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Email atau Password salah.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Akun berhasil didaftarkan, silakan login.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <div class="input-group">
          <span class="input-group-text bg-white"><i class="bi bi-envelope-fill text-primary"></i></span>
          <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan email" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <span class="input-group-text bg-white"><i class="bi bi-lock-fill text-primary"></i></span>
          <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" required>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="rememberMe" checked>
          <label class="form-check-label" for="rememberMe">Ingat saya</label>
        </div>
        <div class="text-end">
          <a href="#" class="text-decoration-none small text-primary">Lupa Password?</a><br>
          <a href="register.php" class="text-decoration-none small text-primary">Daftar Akun</a>
        </div>
      </div>

      <button type="submit" name="login" class="btn btn-primary w-100 py-2 fw-semibold">
        <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
      </button>
    </form>
  </div>

  <footer>
    <div class="footer-text">
      &copy; <?= date('Y') ?> <strong>Muhammad Siddiq</strong>. All rights reserved.
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>