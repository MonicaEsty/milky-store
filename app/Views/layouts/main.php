<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $title ?? 'Milky Dessert Box' ?></title>

  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Tailwind CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
  <!-- Animate.css -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />

  <style>
    body {
      background-color: #fff1f2;
    }

    .navbar {
      background-color: #ffdce5 !important;
      padding: 10px 0;
    }

    .navbar-brand img {
      height: 60px;
      margin-right: 10px;
    }

    .navbar-brand span {
      font-weight: bold;
      color: #000;
      font-size: 1.2em;
    }

    .navbar-nav {
      flex-direction: row;
    }

    .navbar-nav .nav-item {
      margin-left: 10px;
      margin-right: 10px;
    }

    .navbar-nav .nav-link {
      color: #000 !important;
      font-weight: bold;
      display: flex;
      align-items: center;
    }

    .navbar-nav .nav-link i {
      margin-right: 5px;
    }

    .carousel-item {
    height: 70vh; /* Sesuaikan tinggi carousel sesuai kebutuhan */
    background-size: cover;
    background-position: center;
}

    .dropdown-menu {
      background-color: #ffdce5;
    }

    .dropdown-item:hover {
      background-color: #f8cdda;
    }

    .btn, .button {
      background-color: #f8bbd0;
      color: #000;
      border: none;
    }

    .btn:hover, .button:hover {
      background-color: #f48fb1;
      color: #000;
    }
    .btn-babypink {
  background-color: #f8bbd0;
  color: black;
  border: none;
}
.btn-babypink:hover {
  background-color: #f48fb1;
  color: black;
}

    footer.bg-gray-900 {
      background-color: #f8bbd0 !important;
      color: #000;
    }

    .service {
      background-color: #ffe4ec;
      padding: 30px 0;
      margin-top: 30px;
    }

    .contact-info {
      background-color: white;
      padding: 50px 0;
      margin-top: 30px;
      margin-bottom: 50px;
    }

    .box {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .col-4 {
      text-align: center;
      flex: 1;
    }
  </style>
</head>
<body class="bg-pink-50">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm animate__animated animate__fadeInDown">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">
      <img src="<?= base_url('images/logo.png') ?>" alt="Logo" />
      <span>MILKY DESSERT BOX</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon"><i class="fas fa-bars text-black"></i></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto d-flex align-items-center">
        <li class="nav-item animate__animated animate__fadeInRight animate__delay-1s">
          <a class="nav-link" href="<?= base_url('/') ?>"><i class="fas fa-home"></i> Home</a>
        </li>
        <li class="nav-item animate__animated animate__fadeInRight animate__delay-2s">
          <a class="nav-link" href="<?= base_url('/about') ?>"><i class="fas fa-info-circle"></i> About</a>
        </li>
        <li class="nav-item animate__animated animate__fadeInRight animate__delay-3s">
          <a class="nav-link" href="<?= base_url('/shop') ?>"><i class="fas fa-concierge-bell"></i> Shop</a>
        </li>
        <li class="nav-item animate__animated animate__fadeInRight animate__delay-4s">
          <a class="nav-link" href="<?= base_url('/contact') ?>"><i class="fas fa-envelope"></i> Contact</a>
        </li>

        <?php if (session()->get('isLoggedIn')): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
              <i class="fas fa-user"></i> <?= session()->get('full_name') ?>
            </a>
            <div class="dropdown-menu">
              <?php if (session()->get('role') == 'admin'): ?>
                <a class="dropdown-item" href="<?= base_url('/admin') ?>">Dashboard Admin</a>
              <?php else: ?>
                <a class="dropdown-item" href="<?= base_url('/customer/dashboard') ?>">Dashboard</a>
                <a class="dropdown-item" href="<?= base_url('/customer/orders') ?>">Pesanan Saya</a>
              <?php endif; ?>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?= base_url('/auth/logout') ?>">Logout</a>
            </div>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/auth/login') ?>"><i class="fas fa-user"></i></a>
          </li>
        <?php endif; ?>

        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fas fa-heart"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('/cart') ?>"><i class="fas fa-shopping-cart"></i></a>
        </li>
      </ul>
    </div>
    
  </div>
</nav>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<!-- Main Content -->
<section class="mt-4 mb-5 px-3">
  <?= $this->renderSection('content') ?>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-center py-3">
  <div class="container">
    <p class="m-0">&copy; 2024 MILKY DESSERT BOX. All Rights Reserved.</p>
  </div>
</footer>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
