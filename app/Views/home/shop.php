<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <!-- Sidebar Filter -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5>Filter Produk</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/shop') ?>" method="get">
                        <div class="form-group">
                            <label for="search">Cari Produk</label>
                            <input type="text" class="form-control" id="search" name="search" value="<?= $keyword ?>" placeholder="Nama produk...">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                        <a href="<?= base_url('/shop') ?>" class="btn btn-secondary btn-sm">Reset</a>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>Kategori</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="<?= base_url('/shop') ?>" 
                               class="<?= !$selectedCategory ? 'font-weight-bold text-primary' : 'text-dark' ?>">
                                Semua Kategori
                            </a>
                        </li>
                        <?php foreach ($categories as $category): ?>
                            <li class="mb-2">
                                <a href="<?= base_url('/shop?category=' . $category['id']) ?>"
                                   class="<?= $selectedCategory == $category['id'] ? 'font-weight-bold text-primary' : 'text-dark' ?>">
                                    <?= $category['name'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Produk Kami</h3>
                <span class="text-muted"><?= count($products) ?> produk ditemukan</span>
            </div>

            <div class="row">
                <?php if (empty($products)): ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <h5>Tidak ada produk ditemukan</h5>
                            <p>Coba ubah kata kunci pencarian atau filter yang digunakan.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 product-card">
                            <div class="position-relative">
                                <img src="<?= base_url('images/' . $product['image']) ?>" 
                                     class="card-img-top" 
                                     alt="<?= $product['name'] ?>"
                                     style="height: 200px; object-fit: cover;">
                                
                                <!-- Quick View Button -->
                                <div class="product-overlay">
                                    <a href="<?= base_url('/product/' . $product['id']) ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>
                                </div>
                                
                                <!-- Stock Badge -->
                                <?php if ($product['stock'] <= 5 && $product['stock'] > 0): ?>
                                    <span class="badge badge-warning position-absolute" style="top: 10px; right: 10px;">
                                        Stok Terbatas
                                    </span>
                                <?php elseif ($product['stock'] == 0): ?>
                                    <span class="badge badge-danger position-absolute" style="top: 10px; right: 10px;">
                                        Habis
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= $product['name'] ?></h5>
                                <p class="card-text flex-grow-1"><?= substr($product['description'], 0, 100) ?>...</p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong class="text-primary">Rp <?= number_format($product['price'], 0, ',', '.') ?></strong>
                                        <small class="text-muted">Stok: <?= $product['stock'] ?></small>
                                    </div>
                                    
                                    <div class="btn-group w-100">
                                        <a href="<?= base_url('/product/' . $product['id']) ?>" 
                                           class="btn btn-outline-primary btn-sm">
                                            Detail
                                        </a>
                                        
                                        <?php if (session()->get('isLoggedIn')): ?>
                                            <?php if ($product['stock'] > 0): ?>
                                                <form action="<?= base_url('/cart/add') ?>" method="post" class="d-inline">
                                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-cart-plus"></i>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <button class="btn btn-secondary btn-sm" disabled>Habis</button>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <a href="<?= base_url('/auth/login') ?>" class="btn btn-outline-secondary btn-sm">
                                                Login
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}
</style>
<?= $this->endSection() ?>
