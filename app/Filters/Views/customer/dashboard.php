<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5>Menu Customer</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= base_url('/customer/dashboard') ?>" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="<?= base_url('/customer/profile') ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-user"></i> Profil Saya
                    </a>
                    <a href="<?= base_url('/customer/orders') ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-bag"></i> Pesanan Saya
                    </a>
                    <a href="<?= base_url('/cart') ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-cart"></i> Keranjang
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4>Dashboard Customer</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Selamat datang, <?= session()->get('full_name') ?>!</h5>
                            <p class="text-muted">Kelola akun dan pesanan Anda dari dashboard ini.</p>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-shopping-bag fa-2x mb-2"></i>
                                    <h4><?= count($recentOrders) ?></h4>
                                    <p>Total Pesanan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                                    <h4><?= count(array_filter($recentOrders, function($order) { return $order['status'] == 'delivered'; })) ?></h4>
                                    <p>Pesanan Selesai</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-clock fa-2x mb-2"></i>
                                    <h4><?= count(array_filter($recentOrders, function($order) { return in_array($order['status'], ['pending', 'paid', 'processing']); })) ?></h4>
                                    <p>Pesanan Aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="mt-4">
                        <h5>Pesanan Terbaru</h5>
                        <?php if (empty($recentOrders)): ?>
                            <div class="alert alert-info">
                                <p class="mb-0">Anda belum memiliki pesanan. <a href="<?= base_url('/shop') ?>">Mulai berbelanja sekarang!</a></p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No. Pesanan</th>
                                            <th>Tanggal</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recentOrders as $order): ?>
                                        <tr>
                                            <td><?= $order['order_number'] ?></td>
                                            <td><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                                            <td>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                                            <td>
                                                <span class="badge badge-<?= $order['status'] == 'delivered' ? 'success' : ($order['status'] == 'pending' ? 'warning' : 'info') ?>">
                                                    <?= ucfirst($order['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('/customer/orders/' . $order['id']) ?>" class="btn btn-sm btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
