<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Detail Pesanan #<?= $order['order_number'] ?></h4>
                    <a href="<?= base_url('/customer/orders') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <!-- Order Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Informasi Pesanan</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td>No. Pesanan:</td>
                                    <td><strong><?= $order['order_number'] ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pesanan:</td>
                                    <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                </tr>
                                <tr>
                                    <td>Status Pesanan:</td>
                                    <td>
                                        <span class="badge badge-<?= $order['status'] == 'delivered' ? 'success' : ($order['status'] == 'pending' ? 'warning' : 'info') ?>">
                                            <?= ucfirst($order['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status Pembayaran:</td>
                                    <td>
                                        <span class="badge badge-<?= $order['payment_status'] == 'paid' ? 'success' : ($order['payment_status'] == 'pending' ? 'warning' : 'danger') ?>">
                                            <?= ucfirst($order['payment_status']) ?>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Alamat Pengiriman</h5>
                            <p><?= nl2br($order['shipping_address']) ?></p>
                            
                            <?php if ($order['notes']): ?>
                                <h5>Catatan</h5>
                                <p><?= nl2br($order['notes']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <h5>Item Pesanan</h5>
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
                                        <img src="<?= base_url('images/' . $item['image']) ?>"
   
 style="width: 50px; height: 50px; object-fit: cover;" class="mr-3">
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
                                    <th colspan="3" class="text-right">Total:</th>
                                    <th>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4">
                        <?php if ($order['payment_status'] == 'pending'): ?>
                            <a href="<?= base_url('/payment/process/' . $order['order_number']) ?>" class="btn btn-success">
                                <i class="fas fa-credit-card"></i> Bayar Sekarang
                            </a>
                        <?php endif; ?>
                        
                        <button onclick="window.print()" class="btn btn-info">
                            <i class="fas fa-print"></i> Cetak Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
@media print {
    .btn, .card-header .btn, nav, footer {
        display: none !important;
    }
    .container {
        max-width: 100% !important;
    }
}
</style>
<?= $this->endSection() ?>
