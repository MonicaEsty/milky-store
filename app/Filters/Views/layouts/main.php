<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Milky Dessert Box' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    
    <style>
        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 0;
        }

        .navbar-brand img {
            height: 60px;
            margin-right: 10px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
        }

        .navbar-brand span {
            font-weight: bold;
            color: #333;
            font-size: 1.2em;
        }

        .nav-icons {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .nav-icons a {
            margin-right: 15px;
        }

        .nav-icons a:last-child {
            margin-right: 0;
        }

        .navbar-nav .nav-item .nav-link {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 0 15px;
            color: #333;
            text-decoration: none;
            font-weight: bold;
            position: relative;
            margin-right: 5px;
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: #007bff;
        }

        .carousel-item {
            height: 70vh;
            background-size: cover;
            background-position: center;
        }

        .service {
            background-color: #d8b28fef;
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
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm animate__animated animate__fadeInDown">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <img src="<?= base_url('images/logo.png') ?>" alt="Logo">
                <span>MILKY DESSERT BOX</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
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
                </ul>
                <div class="nav-icons">
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
                            <a href="<?= base_url('/auth/login') ?>"><i class="icon user-icon fas fa-user"></i></a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a href="#"><i class="icon heart-icon fas fa-heart"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/cart') ?>"><i class="icon cart-icon fas fa-shopping-cart"></i></a>
                    </li>
                </div>
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
    <?= $this->renderSection('content') ?>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-2">
        <div class="container mx-auto px-4 text-center">
            <p style="font-family: 'Roboto', sans-serif;">&copy; 2024 MILKY DESSERT BOX. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>
