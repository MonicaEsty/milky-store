<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Produk</h1>
    <a href="<?= base_url('/admin/products') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
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

        <form action="<?= base_url('/admin/products/update/' . $product['id']) ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Produk</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $product['name']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_id">Kategori</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>" <?= old('category_id', $product['category_id']) == $category['id'] ? 'selected' : '' ?>>
                                            <?= $category['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?= old('description', $product['description']) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="price">Harga</label>
                                <input type="number" class="form-control" id="price" name="price" value="<?= old('price', $product['price']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="stock">Stok</label>
                                <input type="number" class="form-control" id="stock" name="stock" value="<?= old('stock', $product['stock']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="weight">Berat (gram)</label>
                                <input type="number" class="form-control" id="weight" name="weight" value="<?= old('weight', $product['weight'] ?? 300) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image">Gambar Produk (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" <?= old('is_active', $product['is_active']) ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="is_active">Produk Aktif</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6>Gambar Saat Ini</h6>
                        </div>
                        <div class="card-body text-center">
                            <?php if ($product['image']): ?>
                                <img src="<?= base_url('images/' . $product['image']) ?>" alt="<?= $product['name'] ?>" class="img-fluid" style="max-height: 200px;">
                            <?php else: ?>
                                <div class="text-muted">
                                    <i class="fas fa-image fa-3x"></i>
                                    <p>Tidak ada gambar</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Produk
                </button>
                <a href="<?= base_url('/admin/products') ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
