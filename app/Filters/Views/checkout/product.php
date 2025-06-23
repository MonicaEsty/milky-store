<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('/shop') ?>">Shop</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('/product/' . $product['id']) ?>"><?= $product['name'] ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </nav>
        </div>
    </div>

    <h2 class="mb-4">
        <i class="fas fa-bolt text-warning"></i> Quick Checkout
    </h2>
    
    <div class="row">
        <div class="col-md-8">
            <!-- Product Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-shopping-bag"></i> Ringkasan Produk</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <img src="<?= base_url('images/' . $product['image']) ?>" 
                                 alt="<?= $product['name'] ?>" 
                                 class="img-fluid rounded"
                                 style="height: 120px; object-fit: cover;">
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-1"><?= $product['name'] ?></h5>
                            <p class="text-muted mb-1"><?= substr($product['description'], 0, 100) ?>...</p>
                            <small class="text-muted">Berat: <?= $product['weight'] ?? 300 ?>g</small>
                        </div>
                        <div class="col-md-3 text-right">
                            <div class="mb-2">
                                <strong>Rp <?= number_format($product['price'], 0, ',', '.') ?></strong>
                                <small class="text-muted d-block">x <?= $quantity ?> box</small>
                            </div>
                            <h5 class="text-primary mb-0">
                                Rp <?= number_format($subtotal, 0, ',', '.') ?>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Information Form -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-truck"></i> Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <?php if (session()->get('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session()->get('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/checkout/product/process') ?>" method="post">
                        <!-- Customer Info (Pre-filled) -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="customer_name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="customer_name" 
                                       value="<?= $user['full_name'] ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="customer_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="customer_email" 
                                       value="<?= $user['email'] ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="customer_phone">No. Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="customer_phone" name="customer_phone" 
                                   value="<?= old('customer_phone', $user['phone']) ?>" required 
                                   placeholder="Contoh: 08123456789">
                            <small class="text-muted">Nomor telepon akan digunakan untuk koordinasi pengiriman</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="shipping_address">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="shipping_address" name="shipping_address" 
                                      rows="4" required placeholder="Masukkan alamat lengkap untuk pengiriman"><?= old('shipping_address', $user['address']) ?></textarea>
                            <small class="text-muted">Pastikan alamat lengkap dan mudah ditemukan oleh kurir</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="notes">Catatan Tambahan (Opsional)</label>
                            <textarea class="form-control" id="notes" name="notes" 
                                      rows="3" placeholder="Catatan khusus untuk pesanan Anda (warna kemasan, waktu pengiriman, dll)"><?= old('notes') ?></textarea>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="agree_terms" required>
                                <label class="custom-control-label" for="agree_terms">
                                    Saya setuju dengan <a href="#" data-toggle="modal" data-target="#termsModal">syarat dan ketentuan</a> pembelian
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('/product/' . $product['id']) ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Produk
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-credit-card"></i> Lanjut ke Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Order Summary Sidebar -->
        <div class="col-md-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header">
                    <h5><i class="fas fa-receipt"></i> Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal (<?= $quantity ?> item):</span>
                        <span>Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Biaya Pengiriman:</span>
                        <span>
                            <?php if ($shippingCost > 0): ?>
                                Rp <?= number_format($shippingCost, 0, ',', '.') ?>
                            <?php else: ?>
                                <span class="text-success font-weight-bold">GRATIS</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    
                    <?php if ($subtotal >= 100000): ?>
                        <div class="alert alert-success py-2 px-3 mb-3">
                            <small>
                                <i class="fas fa-gift"></i> 
                                Selamat! Anda mendapat gratis ongkir
                            </small>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info py-2 px-3 mb-3">
                            <small>
                                <i class="fas fa-info-circle"></i> 
                                Tambah Rp <?= number_format(100000 - $subtotal, 0, ',', '.') ?> lagi untuk gratis ongkir
                            </small>
                        </div>
                    <?php endif; ?>
                    
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong class="text-primary h5">Rp <?= number_format($grandTotal, 0, ',', '.') ?></strong>
                    </div>

                    <!-- Payment Methods Info -->
                    <div class="payment-methods">
                        <h6 class="mb-2">Metode Pembayaran:</h6>
                        <div class="row text-center">
                            <div class="col-6 mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-credit-card fa-lg d-block mb-1"></i>
                                    Kartu Kredit
                                </small>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-university fa-lg d-block mb-1"></i>
                                    Transfer Bank
                                </small>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-mobile-alt fa-lg d-block mb-1"></i>
                                    E-Wallet
                                </small>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-qrcode fa-lg d-block mb-1"></i>
                                    QRIS
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Security Badge -->
                    <div class="text-center mt-3 pt-3 border-top">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt text-success"></i>
                            Pembayaran aman dengan enkripsi SSL
                        </small>
                    </div>
                </div>
            </div>

            <!-- Delivery Info -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6><i class="fas fa-truck"></i> Informasi Pengiriman</h6>
                    <ul class="list-unstyled mb-0">
                        <li><small><i class="fas fa-clock text-primary"></i> Estimasi 1-2 hari kerja</small></li>
                        <li><small><i class="fas fa-box text-primary"></i> Kemasan aman & higienis</small></li>
                        <li><small><i class="fas fa-thermometer-half text-primary"></i> Dengan cooling box</small></li>
                        <li><small><i class="fas fa-phone text-primary"></i> Tracking via WhatsApp</small></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Syarat dan Ketentuan</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>1. Pemesanan</h6>
                <p>Dengan melakukan pemesanan, Anda menyetujui untuk membeli produk sesuai dengan spesifikasi yang tertera.</p>
                
                <h6>2. Pembayaran</h6>
                <p>Pembayaran harus dilakukan dalam waktu 24 jam setelah pemesanan. Pesanan akan otomatis dibatalkan jika tidak ada pembayaran.</p>
                
                <h6>3. Pengiriman</h6>
                <p>Produk akan dikirim dalam 1-2 hari kerja setelah pembayaran dikonfirmasi. Biaya pengiriman gratis untuk pembelian minimal Rp 100.000.</p>
                
                <h6>4. Kualitas Produk</h6>
                <p>Kami menjamin kualitas produk fresh dan higienis. Produk dikirim dengan cooling box untuk menjaga kesegaran.</p>
                
                <h6>5. Pengembalian</h6>
                <p>Produk dapat dikembalikan dalam 24 jam jika ada kerusakan atau tidak sesuai pesanan dengan bukti foto.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Auto-format phone number
document.getElementById('customer_phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.startsWith('0')) {
        value = '62' + value.substring(1);
    }
    if (!value.startsWith('62')) {
        value = '62' + value;
    }
    e.target.value = value;
});

// Character counter for notes
document.getElementById('notes').addEventListener('input', function(e) {
    const maxLength = 500;
    const currentLength = e.target.value.length;
    
    if (!document.getElementById('notesCounter')) {
        const counter = document.createElement('small');
        counter.id = 'notesCounter';
        counter.className = 'text-muted';
        e.target.parentNode.appendChild(counter);
    }
    
    document.getElementById('notesCounter').textContent = `${currentLength}/${maxLength} karakter`;
    
    if (currentLength > maxLength) {
        e.target.value = e.target.value.substring(0, maxLength);
    }
});
</script>
<?= $this->endSection() ?>
