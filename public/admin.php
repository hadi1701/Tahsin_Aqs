<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['roles'] != 'admin') {
    session_destroy(); // hapus semua session
    header("Location: login.php");
    exit; // sangat penting agar kode di bawahnya tidak tetap dijalankan
}

require_once '../module/dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Landing Page</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Poppins:wght@400;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f4f8;
      font-family: 'Segoe UI', sans-serif;
    }

    .header {
      text-align: right;
      padding: 1.5rem 2rem;
      font-size: 1.2rem;
      font-weight: 500;
      color: #333;
    }

    .hero-section {
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                  url('../img/adminbg.jpg') center/cover no-repeat;
      height: 100vh;
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 5%;
      }

      .hero-text h1 {
      font-size: 2.5rem;
      font-weight: 600;
      color: #ffffffff;
      }

    .card-container {
      display: flex;
      justify-content: center;
      gap: 2rem;
      flex-wrap: wrap;
      margin-top: 4rem;
      padding: 0 2rem;
    }

    .card {
      width: 18rem;
      border-radius: 1rem;
      transition: transform 0.6s ease, opacity 0.6s ease, box-shadow 0.3s;
      cursor: pointer;
      color: white;
      opacity: 0;
      transform: translateY(50px);
    }

    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 12px 25px rgba(0,0,0,0.2);
    }

    .card i {
      font-size: 3rem;
      margin-bottom: 1rem;
    }

    .card.validasi { background: linear-gradient(135deg, #6a11cb, #2575fc); }
    .card.daftar { background: linear-gradient(135deg, #ff416c, #ff4b2b); }
    .card.update { background: linear-gradient(135deg, #11998e, #38ef7d); }

    .card.show {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand fw-bold" href="admin.php">Dashboard Admin</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="validasi.php" class="nav-link">Validasi</a>
          </li>
          <li class="nav-item">
            <a href="daftar_peserta.php" class="nav-link">Peserta</a>
          </li>
          <li class="nav-item">
            <a href="progress_input.php" class="nav-link">Kemajuan</a>
          </li>
        </ul>

        <div class="d-flex ms-auto mt-2 mt-lg-0">
          <a href="../public/login.php" class="btn btn-warning btn-sm me-2">Logout</a>
        </div>
      </div>
    </div>
  </nav>

  <section class="hero-section">
        <div class="hero-text">
            <h1>Ahlan wa Sahlan, Admin Tahsinians</h1>
            <p>Terus Semangat Mengejar Ridho Allah SWT🧡</p>
    </section>
  
  <section class="mb-5">
      <div class="card-container">
        <div class="card text-center validasi" onclick="location.href='validasi.php'">
          <div class="card-body">
            <i class="fa-solid fa-user-check"></i>
            <h5 class="card-title">Validasi Admin</h5>
            <p class="card-text">Kelola dan verifikasi akun admin baru.</p>
          </div>
        </div>

        <div class="card text-center daftar" onclick="location.href='daftar_peserta.php'">
          <div class="card-body">
            <i class="fa-solid fa-users"></i>
            <h5 class="card-title">Daftar Peserta</h5>
            <p class="card-text">Lihat seluruh peserta yang terdaftar.</p>
          </div>
        </div>

        <div class="card text-center update" onclick="location.href='../admin/progress_input.php'">
          <div class="card-body">
            <i class="fa-solid fa-chart-line"></i>
            <h5 class="card-title">Update Kemajuan & Kekurangan</h5>
            <p class="card-text">Perbarui progres peserta di laman user.</p>
          </div>
        </div>
      </div>
  </section>
  <?php include '../component/footer.php'; ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Animasi muncul saat scroll
    const cards = document.querySelectorAll('.card');
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if(entry.isIntersecting) {
          entry.target.classList.add('show');
        }
      });
    }, { threshold: 0.3 });

    cards.forEach(card => observer.observe(card));
  </script>

</body>
</html>
