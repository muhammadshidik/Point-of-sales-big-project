<?php
session_start();
require_once 'admin/controller/Koneksi.php';
require_once 'admin/controller/functions.php';

if (isset($_POST['register'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $id_level = $_POST['id_level'];

  $queryValidationEmail = mysqli_query($config, "SELECT * FROM user WHERE email = '$email'");
  $queryValidationUsername = mysqli_query($config, "SELECT * FROM user WHERE username = '$username'");
  if (mysqli_num_rows($queryValidationEmail) > 0) {
    header("location: ?error=emailAlreadyRegistered");
    die;
  } elseif (mysqli_num_rows($queryValidationUsername) > 0) {
    header("location: ?error=usernameAlreadyRegistered");
    die;
  } elseif (!isset($_POST['terms'])) {
    header("location: ?error=notAgreeTerms");
    die;
  } else {
    $queryRegister = mysqli_query($config, "INSERT INTO user (id_level, username, email, password) VALUES ('$id_level', '$username', '$email', '$password')");
    if (!$queryRegister) {
      header("location: ?error=registerFailed");
      die;
    } else {
      header("location: Login.php?register=success");
      die;
    }
  }
}
$queryLevel = mysqli_query($config, "SELECT * FROM level ORDER BY id ASC"); // 🔹 Tambahan supaya $queryLevel ada
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Regsiter | CV. AL- Ikhlas</title>
   <link rel="icon" href="admin/content/uploads/Foto/dpn.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      height: 100vh;
      background: linear-gradient(-45deg, #74ebd5, #9face6, #a1c4fd, #c2e9fb, #fbc2eb, #f6d365, #fdcbf1, #a18cd1, #ff9a9e);
      background-size: 900% 900%;
      animation: gradientShift 30s ease infinite;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }

    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      25% { background-position: 50% 50%; }
      50% { background-position: 100% 50%; }
      75% { background-position: 50% 50%; }
      100% { background-position: 0% 50%; }
    }

    .card {
      background: white;
      border: none;
      border-radius: 20px;
      padding: 30px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .form-control:focus {
      box-shadow: none;
      border-color: #6c63ff;
    }

    .btn-primary {
      background-color: #6c63ff;
      border: none;
    }

    .btn-primary:hover {
      background-color: #5a54d1;
    }

    .form-check-label a {
      text-decoration: none;
    }
  </style>
</head>
<body>

<div class="card">
   <div class="text-center mb-4">
      <img src="admin/content/uploads/Foto/logo-dapur-mama-niar.png" alt="Logo" class="mb-3" style="max-width: 100px;">
      <h2 class="fw-semibold">Dapur Mama Niar</h2>
      <p class="text-muted mb-0">Silakan daftarkan akun Anda</p>
    </div> 

  <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?php
        switch ($_GET['error']) {
          case 'emailAlreadyRegistered': echo 'Email sudah didaftarkan!'; break;
          case 'usernameAlreadyRegistered': echo 'Username sudah digunakan!'; break;
          case 'notAgreeTerms': echo 'Kamu harus menyetujui syarat & ketentuan.'; break;
          case 'registerFailed': echo 'Registrasi gagal. Coba lagi.'; break;
        }
      ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif ?>

  <form method="POST" action="">
    <div class="mb-3">
      <input type="text" class="form-control" name="username" placeholder="Username" required value="<?= $_POST['username'] ?? '' ?>">
    </div>
    <div class="mb-3">
      <input type="email" class="form-control" name="email" placeholder="Email" required value="<?= $_POST['email'] ?? '' ?>">
    </div>
    <div class="mb-3">
      <select class="form-select" name="id_level" required>
        <option value="">-- Pilih Level --</option>
        <?php while ($level = mysqli_fetch_assoc($queryLevel)) : ?>
          <option value="<?= $level['id'] ?>"><?= $level['level_name'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-3">
      <div class="input-group">
        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
        <span class="input-group-text"><i class="bi bi-eye-slash" id="togglePassword" style="cursor:pointer;"></i></span>
      </div>
    </div>
    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" name="terms" id="terms">
      <label class="form-check-label" for="terms">
        Saya menyetujui <a href="#" class="text-primary">syarat & ketentuan</a>
      </label>
    </div>
    <div class="d-grid">
      <button type="submit" name="register" class="btn btn-primary">Daftar Sekarang</button>
    </div>
  </form>

  <div class="text-center mt-3">
    <small>Sudah punya akun? <a href="index.php" class="text-decoration-none text-primary">Login</a></small>
  </div>
</div>

<script>
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');

  togglePassword.addEventListener('click', function () {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash');
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
