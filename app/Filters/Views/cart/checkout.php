<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Checkout</h2>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Pengiriman</h5>
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

                    <form action="<?= base_url('/cart/process') ?>" method="post">
                        <div class="form-group">
                            <label for="customer_phone">No. Telepon</label>
                            <input type="text" class="form-control" id="customer_phone" name="customer_phone" 
                                   value="<?= old('customer_phone') ?>" required 
                                   placeholder="Contoh: 08123456789">
                        </div>
                        
                        <div class="form-group">
                            <label for="shipping_address">Alamat Lengkap</label>
                            <textarea class="form-control" id="shipping_address" name="shipping_address" 
                                      rows="4" required placeholder="Masukkan alamat lengkap untuk pengiriman"><?= old('shipping_address') ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="notes">Catatan (Opsional)</label>
                            <textarea class="form-control" id="notes" name="notes" 
                                      rows="3" placeholder="Catatan khusus untuk pesanan Anda"><?= old('notes') ?></textarea>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="agree_terms" required>
                                <label class="custom-control-label" for="agree_terms">
                                    Saya setuju dengan <a href="#" data-toggle="modal" data-target="#termsModal">syarat dan ketentuan</a>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            <i class="fas fa-credit-card"></i> Lanjut ke Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Order Summary -->
            <div class="card">
                <div class="card-header">
                    <h5>Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($cartItems as $item): ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <small><?= $item['name'] ?></small><br>
                            <small class="text-muted"><?= $item['quantity'] ?>x Rp <?= number_format($item['price'], 0, ',', '.') ?></small>
                        </div>
                        <small>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></small>
                    </div>
                    <?php endforeach; ?>
                    
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Biaya Pengiriman:</span>
                        <span>
                            <?php 
                            $shippingCost = $total >= 100000 ? 0 : 15000;
                            if ($shippingCost > 0): ?>
                                Rp <?= number_format($shippingCost, 0, ',', '.') ?>
                            <?php else: ?>
                                <span class="text-success">GRATIS</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <?php if ($total >= 100000): ?>
                        <small class="text-success">🎉 Selamat! Anda mendapat gratis ongkir</small>
                    <?php else: ?>
                        <small class="text-muted">Gratis ongkir untuk pembelian min. Rp 100.000</small>
                    <?php endif; ?>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong class="text-primary">Rp <?= number_format($total + $shippingCost, 0, ',', '.') ?></strong>
                    </div>
                </div>
            </div>

            <!-- Payment Methods Info -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6>Metode Pembayaran</h6>
                </div>
                <div class="card-body">
                    <small class="text-muted">
                        <i class="fas fa-credit-card"></i> Kartu Kredit/Debit<br>
                        <i class="fas fa-university"></i> Transfer Bank<br>
                        <i class="fas fa-mobile-alt"></i> E-Wallet (GoPay, OVO, DANA)<br>
                        <i class="fas fa-qrcode"></i> QRIS
                    </small>
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
                
                <h6>4. Pengembalian</h6>
                <p>Produk dapat dikembalikan dalam 24 jam jika ada kerusakan atau tidak sesuai pesanan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
