<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran - <?= $order['order_number'] ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Courier New', monospace;
            background: #f8f9fa;
        }
        .receipt {
            max-width: 400px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border: 2px dashed #333;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .receipt-header {
            text-align: center;
            border-bottom: 1px dashed #333;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .receipt-title {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }
        .receipt-subtitle {
            font-size: 12px;
            margin: 5px 0;
        }
        .receipt-section {
            margin-bottom: 15px;
        }
        .receipt-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .receipt-item {
            border-bottom: 1px dotted #ccc;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .receipt-total {
            border-top: 1px dashed #333;
            padding-top: 10px;
            font-weight: bold;
        }
        .receipt-footer {
            text-align: center;
            border-top: 1px dashed #333;
            padding-top: 15px;
            margin-top: 15px;
            font-size: 12px;
        }
        .status-paid {
            background: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            display: inline-block;
        }
        @media print {
            body {
                background: white;
            }
            .receipt {
                box-shadow: none;
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="no-print text-center mb-3">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Cetak Bukti
            </button>
            <button onclick="window.close()" class="btn btn-secondary">
                <i class="fas fa-times"></i> Tutup
            </button>
        </div>

        <div class="receipt">
            <!-- Header -->
            <div class="receipt-header">
                <h1 class="receipt-title">MILKY DESSERT BOX</h1>
                <p class="receipt-subtitle">JL. Imam Bonjol No.207, Semarang</p>
                <p class="receipt-subtitle">Telp: +62 24 123 4567</p>
                <p class="receipt-subtitle">================================</p>
                <p class="receipt-subtitle">BUKTI PEMBAYARAN</p>
            </div>

            <!-- Order Info -->
            <div class="receipt-section">
                <div class="receipt-row">
                    <span>No. Pesanan:</span>
                    <span><?= $order['order_number'] ?></span>
                </div>
                <div class="receipt-row">
                    <span>Tanggal:</span>
                    <span><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></span>
                </div>
                <div class="receipt-row">
                    <span>Kasir:</span>
                    <span>SYSTEM</span>
                </div>
                <div class="receipt-row">
                    <span>Status:</span>
                    <span class="status-paid">LUNAS</span>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="receipt-section">
                <p style="margin: 0; font-weight: bold;">CUSTOMER:</p>
                <p style="margin: 0;"><?= $order['full_name'] ?></p>
                <p style="margin: 0; font-size: 12px;"><?= $order['email'] ?></p>
                <p style="margin: 0; font-size: 12px;"><?= $order['phone'] ?></p>
            </div>

            <!-- Items -->
            <div class="receipt-section">
                <p style="margin: 0; font-weight: bold;">ITEM PESANAN:</p>
                <p style="margin: 0; font-size: 12px;">================================</p>
                
                <?php foreach ($orderItems as $item): ?>
                <div class="receipt-item">
                    <div style="font-weight: bold;"><?= $item['product_name'] ?></div>
                    <div class="receipt-row">
                        <span><?= $item['quantity'] ?> x Rp <?= number_format($item['price'], 0, ',', '.') ?></span>
                        <span>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Totals -->
            <div class="receipt-section">
                <p style="margin: 0; font-size: 12px;">================================</p>
                <div class="receipt-row">
                    <span>Subtotal:</span>
                    <span>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></span>
                </div>
                <div class="receipt-row">
                    <span>Ongkos Kirim:</span>
                    <span>
                        <?php if ($order['shipping_cost'] > 0): ?>
                            Rp <?= number_format($order['shipping_cost'], 0, ',', '.') ?>
                        <?php else: ?>
                            GRATIS
                        <?php endif; ?>
                    </span>
                </div>
                <div class="receipt-row receipt-total">
                    <span>TOTAL:</span>
                    <span>Rp <?= number_format($order['grand_total'], 0, ',', '.') ?></span>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="receipt-section">
                <p style="margin: 0; font-size: 12px;">================================</p>
                <div class="receipt-row">
                    <span>Metode Bayar:</span>
                    <span><?= strtoupper($order['midtrans_payment_type'] ?? 'MIDTRANS') ?></span>
                </div>
                <?php if ($order['midtrans_transaction_id']): ?>
                <div class="receipt-row">
                    <span>Transaction ID:</span>
                    <span style="font-size: 10px;"><?= $order['midtrans_transaction_id'] ?></span>
                </div>
                <?php endif; ?>
                <div class="receipt-row">
                    <span>Waktu Bayar:</span>
                    <span><?= date('d/m/Y H:i', strtotime($order['midtrans_transaction_time'] ?? $order['updated_at'])) ?></span>
                </div>
            </div>

            <!-- Shipping Address -->
            <?php if ($order['shipping_address']): ?>
            <div class="receipt-section">
                <p style="margin: 0; font-weight: bold;">ALAMAT PENGIRIMAN:</p>
                <p style="margin: 0; font-size: 12px;"><?= nl2br($order['shipping_address']) ?></p>
            </div>
            <?php endif; ?>

            <!-- Footer -->
            <div class="receipt-footer">
                <p>================================</p>
                <p>TERIMA KASIH ATAS PEMBELIAN ANDA</p>
                <p>Barang yang sudah dibeli tidak dapat dikembalikan kecuali ada kerusakan</p>
                <p>================================</p>
                <p>Follow us:</p>
                <p>@milkydessertbox</p>
                <p>www.milkydessertbox.com</p>
                <p style="margin-top: 20px; font-size: 10px;">
                    Dicetak pada: <?= date('d/m/Y H:i:s') ?>
                </p>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
</body>
</html>
