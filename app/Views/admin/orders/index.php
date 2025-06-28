<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Pesanan</h1>
    <div>
        <select class="form-control d-inline-block" style="width: auto;" onchange="filterOrders(this.value)">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="paid">Paid</option>
            <option value="processing">Processing</option>
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h4><?= count(array_filter($orders, function($o) { return $o['status'] == 'pending'; })) ?></h4>
                <small>Pending</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h4><?= count(array_filter($orders, function($o) { return $o['payment_status'] == 'paid'; })) ?></h4>
                <small>Paid</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h4><?= count(array_filter($orders, function($o) { return $o['status'] == 'processing'; })) ?></h4>
                <small>Processing</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h4><?= count(array_filter($orders, function($o) { return $o['status'] == 'shipped'; })) ?></h4>
                <small>Shipped</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-secondary text-white">
            <div class="card-body text-center">
                <h4><?= count(array_filter($orders, function($o) { return $o['status'] == 'delivered'; })) ?></h4>
                <small>Delivered</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <h4><?= count(array_filter($orders, function($o) { return $o['status'] == 'cancelled'; })) ?></h4>
                <small>Cancelled</small>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="ordersTable">
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status Pesanan</th>
                        <th>Status Pembayaran</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr data-status="<?= $order['status'] ?>">
                        <td>
                            <strong><?= $order['order_number'] ?></strong>
                            <?php if (!empty($order['midtrans_payment_type'])): ?>
                                 <br><small class="text-muted"><?= ucfirst($order['midtrans_payment_type']) ?></small>
                            <?php endif; ?>

                        </td>
                        <td>
                            <strong><?= $order['full_name'] ?></strong>
                            <br><small class="text-muted"><?= $order['email'] ?></small>
                        </td>
                        <td>
                            <strong>Rp <?= number_format($order['grand_total'], 0, ',', '.') ?></strong>
                            <?php if ($order['shipping_cost'] > 0): ?>
                                <br><small class="text-muted">+ Ongkir: Rp <?= number_format($order['shipping_cost'], 0, ',', '.') ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <select class="form-control form-control-sm" onchange="updateOrderStatus(<?= $order['id'] ?>, this.value)">
                                <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="paid" <?= $order['status'] == 'paid' ? 'selected' : '' ?>>Paid</option>
                                <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                        </td>
                        <td>
                            <span class="badge badge-<?= $order['payment_status'] == 'paid' ? 'success' : ($order['payment_status'] == 'pending' ? 'warning' : 'danger') ?>">
                                <?= ucfirst($order['payment_status']) ?>
                            </span>
                            <?php if (isset($order['midtrans_transaction_time']) && $order['midtrans_transaction_time']): ?>
                                <br><small class="text-muted"><?= date('d/m/Y H:i', strtotime($order['midtrans_transaction_time'])) ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                        <td>
                            <div class="btn-group-vertical btn-group-sm">
                                <a href="<?= base_url('/admin/orders/' . $order['id']) ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <?php if ($order['payment_status'] == 'paid'): ?>
                                    <a href="<?= base_url('/admin/orders/receipt/' . $order['id']) ?>" class="btn btn-info btn-sm" target="_blank">
                                        <i class="fas fa-receipt"></i> Bukti
                                    </a>
                                <?php endif; ?>
                                <button class="btn btn-warning btn-sm" onclick="showOrderNotes(<?= $order['id'] ?>, '<?= addslashes($order['notes']) ?>')">
                                    <i class="fas fa-sticky-note"></i> Catatan
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Order Notes Modal -->
<div class="modal fade" id="orderNotesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Catatan Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="orderNotesContent"></div>
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
function updateOrderStatus(orderId, status) {
    if (confirm('Yakin ingin mengubah status pesanan?')) {
        fetch('<?= base_url('/admin/orders/update-status/') ?>' + orderId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'status=' + status
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal mengubah status pesanan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}

function filterOrders(status) {
    const rows = document.querySelectorAll('#ordersTable tbody tr');
    rows.forEach(row => {
        if (status === '' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function showOrderNotes(orderId, notes) {
    const content = notes ? notes : 'Tidak ada catatan untuk pesanan ini.';
    document.getElementById('orderNotesContent').innerHTML = '<p>' + content + '</p>';
    $('#orderNotesModal').modal('show');
}
</script>
<?= $this->endSection() ?>
