<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin - Milky Dessert Box' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: #fff;
        }

        .sidebar .nav-link:hover {
            color: #007bff;
        }

        .sidebar .nav-link.active {
            color: #007bff;
        }

        main {
            margin-left: 240px;
        }

        @media (max-width: 767.98px) {
            .sidebar {
                top: 5rem;
            }
            main {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Top navbar -->
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="<?= base_url('/admin') ?>">Milky Admin</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="<?= base_url('/auth/logout') ?>">Logout</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= uri_string() == 'admin' || uri_string() == 'admin/dashboard' ? 'active' : '' ?>" href="<?= base_url('/admin/dashboard') ?>">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(uri_string(), 'admin/products') !== false ? 'active' : '' ?>" href="<?= base_url('/admin/products') ?>">
                                <i class="fas fa-box"></i> Kelola Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(uri_string(), 'admin/categories') !== false ? 'active' : '' ?>" href="<?= base_url('/admin/categories') ?>">
                                <i class="fas fa-tags"></i> Kelola Kategori
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(uri_string(), 'admin/orders') !== false ? 'active' : '' ?>" href="<?= base_url('/admin/orders') ?>">
                                <i class="fas fa-shopping-cart"></i> Kelola Pesanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(uri_string(), 'admin/users') !== false ? 'active' : '' ?>" href="<?= base_url('/admin/users') ?>">
                                <i class="fas fa-users"></i> Kelola Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/') ?>">
                                <i class="fas fa-home"></i> Kembali ke Website
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>
