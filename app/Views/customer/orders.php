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
                    <a href="<?= base_url('/customer/dashboard') ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="<?= base_url('/customer/profile') ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-user"></i> Profil Saya
                    </a>
                    <a href="<?= base_url('/customer/orders') ?>" class="list-group-item list-group-item-action active">
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
                    <h4>Pesanan Saya</h4>
                </div>
                <div class="card-body">
                    <?php if (empty($orders)): ?>
                        <div class="alert alert-info text-center">
                            <h5>Belum ada pesanan</h5>
                            <p>Anda belum memiliki pesanan. Mulai berbelanja sekarang!</p>
                            <a href="<?= base_url('/shop') ?>" class="btn btn-primary">Mulai Belanja</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No. Pesanan</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status Pesanan</th>
                                        <th>Status Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?= $order['order_number'] ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                        <td>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                                        <td>
                                            <span class="badge badge-<?= $order['status'] == 'delivered' ? 'success' : ($order['status'] == 'pending' ? 'warning' : 'info') ?>">
                                                <?= ucfirst($order['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?= $order['payment_status'] == 'paid' ? 'success' : ($order['payment_status'] == 'pending' ? 'warning' : 'danger') ?>">
                                                <?= ucfirst($order['payment_status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('/customer/orders/' . $order['id']) ?>" class="btn btn-sm btn-primary">Detail</a>
                                            <?php if ($order['payment_status'] == 'pending'): ?>
                                                <a href="<?= base_url('/payment/process/' . $order['order_number']) ?>" class="btn btn-sm btn-success">Bayar</a>
                                            <?php endif; ?>
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

<?= $this->endSection() ?>
