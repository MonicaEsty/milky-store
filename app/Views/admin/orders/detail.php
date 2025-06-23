<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Pesanan #<?= $order['order_number'] ?></h1>
    <div>
        <a href="<?= base_url('/admin/orders') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <?php if ($order['payment_status'] == 'paid'): ?>
            <a href="<?= base_url('/admin/orders/receipt/' . $order['id']) ?>" class="btn btn-info" target="_blank">
                <i class="fas fa-receipt"></i> Lihat Bukti Pembayaran
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <!-- Order Information -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Informasi Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>No. Pesanan:</strong></td>
                                <td><?= $order['order_number'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Pesanan:</strong></td>
                                <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status Pesanan:</strong></td>
                                <td>
                                    <form action="<?= base_url('/admin/orders/update-status/' . $order['id']) ?>" method="post" class="d-inline">
                                        <select name="status" class="form-control form-control-sm d-inline-block" style="width: auto;" onchange="this.form.submit()">
                                            <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="paid" <?= $order['status'] == 'paid' ? 'selected' : '' ?>>Paid</option>
                                            <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                            <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                            <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                            <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status Pembayaran:</strong></td>
                                <td>
                                    <span class="badge badge-<?= $order['payment_status'] == 'paid' ? 'success' : ($order['payment_status'] == 'pending' ? 'warning' : 'danger') ?>">
                                        <?= ucfirst($order['payment_status']) ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Metode Pembayaran:</strong></td>
                                <td><?= $order['midtrans_payment_type'] ? ucfirst($order['midtrans_payment_type']) : 'Midtrans' ?></td>
                            </tr>
                            <?php if ($order['midtrans_transaction_id']): ?>
                            <tr>
                                <td><strong>Transaction ID:</strong></td>
                                <td><?= $order['midtrans_transaction_id'] ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if ($order['midtrans_transaction_time']): ?>
                            <tr>
                                <td><strong>Waktu Pembayaran:</strong></td>
                                <td><?= date('d/m/Y H:i', strtotime($order['midtrans_transaction_time'])) ?></td>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card mt-3">
            <div class="card-header">
                <h5>Item Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderItems as $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if ($item['image']): ?>
                                            <img src="<?= base_url('images/' . $item['image']) ?>" alt="<?= $item['name'] ?>" style="width: 50px; height: 50px; object-fit: cover;" class="mr-3">
                                        <?php endif; ?>
                                        <span><?= $item['product_name'] ?></span>
                                    </div>
                                </td>
                                <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Subtotal:</th>
                                <th>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-right">Biaya Pengiriman:</th>
                                <th>
                                    <?php if ($order['shipping_cost'] > 0): ?>
                                        Rp <?= number_format($order['shipping_cost'], 0, ',', '.') ?>
                                    <?php else: ?>
                                        <span class="text-success">GRATIS</span>
                                    <?php endif; ?>
                                </th>
                            </tr>
                            <tr class="table-primary">
                                <th colspan="3" class="text-right">Total:</th>
                                <th>Rp <?= number_format($order['grand_total'], 0, ',', '.') ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Information -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Informasi Customer</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Nama:</strong></td>
                        <td><?= $order['full_name'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td><?= $order['email'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Telepon:</strong></td>
                        <td><?= $order['phone'] ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Alamat Pengiriman</h5>
            </div>
            <div class="card-body">
                <p><?= nl2br($order['shipping_address']) ?></p>
            </div>
        </div>

        <?php if ($order['notes']): ?>
        <div class="card mt-3">
            <div class="card-header">
                <h5>Catatan</h5>
            </div>
            <div class="card-body">
                <p><?= nl2br($order['notes']) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Order Timeline -->
        <div class="card mt-3">
            <div class="card-header">
                <h5>Timeline Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <i class="fas fa-shopping-cart text-primary"></i>
                        <div class="timeline-content">
                            <h6>Pesanan Dibuat</h6>
                            <small><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></small>
                        </div>
                    </div>
                    
                    <?php if ($order['payment_status'] == 'paid' && $order['midtrans_transaction_time']): ?>
                    <div class="timeline-item">
                        <i class="fas fa-credit-card text-success"></i>
                        <div class="timeline-content">
                            <h6>Pembayaran Berhasil</h6>
                            <small><?= date('d/m/Y H:i', strtotime($order['midtrans_transaction_time'])) ?></small>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($order['status'] == 'processing'): ?>
                    <div class="timeline-item">
                        <i class="fas fa-cogs text-info"></i>
                        <div class="timeline-content">
                            <h6>Sedang Diproses</h6>
                            <small><?= date('d/m/Y H:i', strtotime($order['updated_at'])) ?></small>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($order['status'] == 'shipped'): ?>
                    <div class="timeline-item">
                        <i class="fas fa-truck text-warning"></i>
                        <div class="timeline-content">
                            <h6>Sedang Dikirim</h6>
                            <small><?= date('d/m/Y H:i', strtotime($order['updated_at'])) ?></small>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($order['status'] == 'delivered'): ?>
                    <div class="timeline-item">
                        <i class="fas fa-check-circle text-success"></i>
                        <div class="timeline-content">
                            <h6>Pesanan Selesai</h6>
                            <small><?= date('d/m/Y H:i', strtotime($order['updated_at'])) ?></small>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item i {
    position: absolute;
    left: -35px;
    top: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: white;
    border: 2px solid;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -26px;
    top: 20px;
    width: 2px;
    height: calc(100% + 10px);
    background: #dee2e6;
}

.timeline-content h6 {
    margin: 0;
    font-size: 14px;
}

.timeline-content small {
    color: #6c757d;
}
</style>
<?= $this->endSection() ?>
