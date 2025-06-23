<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle fa-5x text-success"></i>
                    </div>
                    <h2 class="text-success">Pembayaran Berhasil!</h2>
                    <p class="lead">Terima kasih atas pembayaran Anda</p>
                    
                    <div class="alert alert-success">
                        <strong>No. Pesanan: <?= $order['order_number'] ?></strong><br>
                        <strong>Total: Rp <?= number_format($order['grand_total'], 0, ',', '.') ?></strong>
                    </div>

                    <p>Pesanan Anda sedang diproses dan akan segera dikirim. Anda akan menerima notifikasi melalui email untuk update status pesanan.</p>

                    <div class="mt-4">
                        <a href="<?= base_url('/customer/orders/' . $order['id']) ?>" class="btn btn-primary">
                            <i class="fas fa-eye"></i> Lihat Detail Pesanan
                        </a>
                        <a href="<?= base_url('/shop') ?>" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-bag"></i> Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
