<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Pembayaran Pesanan #<?= $order['order_number'] ?></h4>
                </div>
                <div class="card-body">
                    <!-- Order Summary -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Ringkasan Pesanan</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td>Subtotal:</td>
                                    <td class="text-right">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>Biaya Pengiriman:</td>
                                    <td class="text-right">
                                        <?php if ($order['shipping_cost'] > 0): ?>
                                            Rp <?= number_format($order['shipping_cost'], 0, ',', '.') ?>
                                        <?php else: ?>
                                            <span class="text-success">GRATIS</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr class="border-top">
                                    <td><strong>Total:</strong></td>
                                    <td class="text-right"><strong>Rp <?= number_format($order['grand_total'], 0, ',', '.') ?></strong></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Detail Pengiriman</h5>
                            <p><strong><?= $order['customer_name'] ?></strong></p>
                            <p><?= $order['customer_phone'] ?></p>
                            <p><?= nl2br($order['shipping_address']) ?></p>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <h5>Item Pesanan</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orderItems as $item): ?>
                                <tr>
                                    <td><?= $item['product_name'] ?></td>
                                    <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Payment Button -->
                    <div class="text-center">
                        <button id="pay-button" class="btn btn-primary btn-lg">
                            <i class="fas fa-credit-card"></i> Bayar Sekarang
                        </button>
                        <p class="text-muted mt-2">Anda akan diarahkan ke halaman pembayaran Midtrans</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $clientKey ?>"></script>
<script type="text/javascript">
document.getElementById('pay-button').onclick = function(){
    snap.pay('<?= $snapToken ?>', {
        onSuccess: function(result){
            console.log('Payment success:', result);
            window.location.href = '<?= base_url('/payment/success/' . $order['order_number']) ?>';
        },
        onPending: function(result){
            console.log('Payment pending:', result);
            window.location.href = '<?= base_url('/payment/pending/' . $order['order_number']) ?>';
        },
        onError: function(result){
            console.log('Payment error:', result);
            window.location.href = '<?= base_url('/payment/error/' . $order['order_number']) ?>';
        },
        onClose: function(){
            console.log('Payment popup closed');
            alert('Anda menutup popup pembayaran tanpa menyelesaikan pembayaran');
        }
    });
};
</script>
<?= $this->endSection() ?>
