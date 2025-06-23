<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-times-circle fa-5x text-danger"></i>
                    </div>
                    <h2 class="text-danger">Pembayaran Gagal</h2>
                    <p class="lead">Terjadi kesalahan dalam proses pembayaran</p>
                    
                    <div class="alert alert-danger">
                        <strong>No. Pesanan: <?= $order['order_number'] ?></strong><br>
                        <strong>Total: Rp <?= number_format($order['grand_total'], 0, ',', '.') ?></strong>
                    </div>

                    <p>Pembayaran Anda tidak dapat diproses. Silakan coba lagi atau hubungi customer service kami untuk bantuan.</p>

                    <div class="mt-4">
                        <a href="<?= base_url('/payment/process/' . $order['order_number']) ?>" class="btn btn-danger">
                            <i class="fas fa-credit-card"></i> Coba Bayar Lagi
                        </a>
                        <a href="<?= base_url('/contact') ?>" class="btn btn-outline-danger">
                            <i class="fas fa-phone"></i> Hubungi Customer Service
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
