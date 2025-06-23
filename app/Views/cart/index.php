<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Keranjang Belanja</h2>
    
    <?php if (empty($cartItems)): ?>
        <div class="alert alert-info text-center">
            <h4>Keranjang belanja kosong</h4>
            <p>Silakan tambahkan produk ke keranjang terlebih dahulu.</p>
            <a href="<?= base_url('/shop') ?>" class="btn btn-primary">Mulai Belanja</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <?php foreach ($cartItems as $item): ?>
                        <div class="row align-items-center border-bottom py-3">
                            <div class="col-md-2">
                                <img src="<?= base_url('images/' . $item['image']) ?>" alt="<?= $item['name'] ?>" class="img-fluid">
                            </div>
                            <div class="col-md-4">
                                <h6><?= $item['name'] ?></h6>
                                <small class="text-muted">Stok tersedia: <?= $item['stock'] ?></small>
                            </div>
                            <div class="col-md-2">
                                <strong>Rp <?= number_format($item['price'], 0, ',', '.') ?></strong>
                            </div>
                            <div class="col-md-2">
                                <form action="<?= base_url('/cart/update') ?>" method="post" class="d-inline">
                                    <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>" class="form-control form-control-sm" onchange="this.form.submit()">
                                </form>
                            </div>
                            <div class="col-md-2">
                                <form action="<?= base_url('/cart/remove') ?>" method="post" class="d-inline">
                                    <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus item ini dari keranjang?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span>Subtotal:</span>
                            <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Total:</span>
                            <strong class="text-primary">Rp <?= number_format($total, 0, ',', '.') ?></strong>
                        </div>
                        <a href="<?= base_url('/cart/checkout') ?>" class="btn btn-primary btn-block mt-3">
                            Lanjut ke Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
