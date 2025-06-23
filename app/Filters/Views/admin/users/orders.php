<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Riwayat Pesanan - <?= $user['full_name'] ?></h1>
    <a href="<?= base_url('/admin/users') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Users
    </a>
</div>

<!-- User Info Card -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <strong>Username:</strong><br>
                <?= $user['username'] ?>
            </div>
            <div class="col-md-3">
                <strong>Email:</strong><br>
                <?= $user['email'] ?>
            </div>
            <div class="col-md-3">
                <strong>Telepon:</strong><br>
                <?= $user['phone'] ?: '-' ?>
            </div>
            <div class="col-md-3">
                <strong>Status:</strong><br>
                <span class="badge badge-<?= $user['is_active'] ? 'success' : 'secondary' ?>">
                    <?= $user['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Orders Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h4><?= count($orders) ?></h4>
                <p>Total Pesanan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h4><?= count(array_filter($orders, function($o) { return $o['payment_status'] == 'paid'; })) ?></h4>
                <p>Pesanan Lunas</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h4>Rp <?= number_format(array_sum(array_map(function($o) { return $o['payment_status'] == 'paid' ? $o['grand_total'] : 0; }, $orders)), 0, ',', '.') ?></h4>
                <p>Total Belanja</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h4><?= count(array_filter($orders, function($o) { return $o['status'] == 'pending'; })) ?></h4>
                <p>Pesanan Pending</p>
            </div>
        </div>
    </div>
</div>

<!-- Orders Table -->
<div class="card">
    <div class="card-body">
        <?php if (empty($orders)): ?>
            <div class="alert alert-info text-center">
                <h5>Belum ada pesanan</h5>
                <p>User ini belum pernah melakukan pesanan.</p>
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
                            <td>
                                <strong><?= $order['order_number'] ?></strong>
                                <?php if ($order['midtrans_payment_type']): ?>
                                    <br><small class="text-muted"><?= ucfirst($order['midtrans_payment_type']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                            <td>
                                <strong>Rp <?= number_format($order['grand_total'], 0, ',', '.') ?></strong>
                                <?php if ($order['shipping_cost'] > 0): ?>
                                    <br><small class="text-muted">+ Ongkir: Rp <?= number_format($order['shipping_cost'], 0, ',', '.') ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge badge-<?= $order['status'] == 'delivered' ? 'success' : ($order['status'] == 'pending' ? 'warning' : 'info') ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-<?= $order['payment_status'] == 'paid' ? 'success' : ($order['payment_status'] == 'pending' ? 'warning' : 'danger') ?>">
                                    <?= ucfirst($order['payment_status']) ?>
                                </span>
                                <?php if ($order['midtrans_transaction_time']): ?>
                                    <br><small class="text-muted"><?= date('d/m/Y H:i', strtotime($order['midtrans_transaction_time'])) ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group-vertical btn-group-sm">
                                    <a href="<?= base_url('/admin/orders/' . $order['id']) ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <?php if ($order['payment_status'] == 'paid'): ?>
                                        <a href="<?= base_url('/admin/orders/receipt/' . $order['id']) ?>" class="btn btn-info btn-sm" target="_blank">
                                            <i class="fas fa-receipt"></i> Bukti
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
