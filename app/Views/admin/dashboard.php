<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $totalProducts ?></h4>
                        <p>Total Produk</p>
                    </div>
                    <div>
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $totalOrders ?></h4>
                        <p>Total Pesanan</p>
                    </div>
                    <div>
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $totalUsers ?></h4>
                        <p>Total Customer</p>
                    </div>
                    <div>
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>Rp <?= number_format($totalRevenue, 0, ',', '.') ?></h4>
                        <p>Total Pendapatan</p>
                    </div>
                    <div>
                        <i class="fas fa-money-bill fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="card">
    <div class="card-header">
        <h5>Pesanan Terbaru</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($recentOrders, 0, 10) as $order): ?>
                    <tr>
                        <td><?= $order['order_number'] ?></td>
                        <td><?= $order['full_name'] ?></td>
                        <td>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                        <td>
                            <span class="badge badge-<?= $order['status'] == 'paid' ? 'success' : ($order['status'] == 'pending' ? 'warning' : 'secondary') ?>">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                        <td>
                            <a href="<?= base_url('/admin/orders/' . $order['id']) ?>" class="btn btn-sm btn-primary">Detail</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
