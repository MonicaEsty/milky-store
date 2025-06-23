<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-clock fa-5x text-warning"></i>
                    </div>
                    <h2 class="text-warning">Pembayaran Pending</h2>
                    <p class="lead">Pembayaran Anda sedang diproses</p>
                    
                    <div class="alert alert-warning">
                        <strong>No. Pesanan: <?= $order['order_number'] ?></strong><br>
                        <strong>Total: Rp <?= number_format($order['grand_total'], 0, ',', '.') ?></strong>
                    </div>

                    <p>Silakan selesaikan pembayaran Anda sesuai dengan instruksi yang diberikan. Status pembayaran akan diupdate secara otomatis.</p>

                    <div class="mt-4">
                        <a href="<?= base_url('/customer/orders/' . $order['id']) ?>" class="btn btn-warning">
                            <i class="fas fa-eye"></i> Lihat Detail Pesanan
                        </a>
                        <a href="<?= base_url('/payment/process/' . $order['order_number']) ?>" class="btn btn-outline-warning">
                            <i class="fas fa-credit-card"></i> Coba Bayar Lagi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
