<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Produk</h1>
    <a href="<?= base_url('/admin/products/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Produk
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <img src="<?= base_url('images/' . $product['image']) ?>" alt="<?= $product['name'] ?>" style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product['category_name'] ?? 'Tidak ada kategori' ?></td>
                        <td>Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                        <td><?= $product['stock'] ?></td>
                        <td>
                            <span class="badge badge-<?= $product['is_active'] ? 'success' : 'secondary' ?>">
                                <?= $product['is_active'] ? 'Aktif' : 'Tidak Aktif' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('/admin/products/edit/' . $product['id']) ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?= base_url('/admin/products/delete/' . $product['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
