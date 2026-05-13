<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Booking Sewa Mobil</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
        }
        .navbar {
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .hero-banner {
            background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
            border-radius: 20px;
            color: white;
            padding: 3rem 2rem;
        }
        .btn-modern {
            border-radius: 10px;
            font-weight: 500;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="../pages/home.php"><i class="bi bi-car-front-fill me-2"></i>Rental-Abdul-Alvin</a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <?php if(!isset($_SESSION['login'])): ?>
            <!-- Menu User -->
            <li class="nav-item"><a class="nav-link" href="../pages/home.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="../pages/booking.php">Booking</a></li>
            <li class="nav-item"><a class="nav-link" href="../pages/jadwal.php">Cek Jadwal</a></li>
            <li class="nav-item"><a class="nav-link" href="../pages/tracking.php">Lacak Status</a></li>
        <?php else: ?>
            <!-- Menu Admin -->
            <li class="nav-item"><a class="nav-link" href="../admin/dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="../admin/mobil.php"><i class="bi bi-car-front"></i> Kelola Mobil</a></li>
            <li class="nav-item"><a class="nav-link" href="../admin/booking.php"><i class="bi bi-journal-text"></i> Data Booking</a></li>
            <li class="nav-item"><a class="nav-link" href="../admin/jadwal.php"><i class="bi bi-calendar-check"></i> Jadwal Sewa</a></li>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav align-items-center">
        <?php if(isset($_SESSION['login'])): ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white fw-medium" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i> Halo, Admin
                </a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item text-danger" href="../admin/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </li>
        <?php else: ?>
            <li class="nav-item"><a class="btn btn-light btn-modern text-primary px-4 shadow-sm" href="../admin/login.php"><i class="bi bi-box-arrow-in-right"></i> Login Admin</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container">