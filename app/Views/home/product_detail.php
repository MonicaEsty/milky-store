<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('/shop') ?>">Shop</a></li>
            <?php if ($product['category_name']): ?>
                <li class="breadcrumb-item"><a href="<?= base_url('/shop?category=' . $product['category_id']) ?>"><?= $product['category_name'] ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active" aria-current="page"><?= $product['name'] ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6">
            <div class="product-image-container">
                <div class="main-image mb-3">
                    <img src="<?= base_url('images/' . $product['image']) ?>" 
                         alt="<?= $product['name'] ?>" 
                         class="img-fluid rounded shadow"
                         id="mainProductImage"
                         style="width: 100%; height: 400px; object-fit: cover;">
                </div>
                
                <!-- Thumbnail images (if you have multiple images in the future) -->
                <div class="thumbnail-images">
                    <div class="row">
                        <div class="col-3">
                            <img src="<?= base_url('images/' . $product['image']) ?>" 
                                 alt="<?= $product['name'] ?>" 
                                 class="img-fluid rounded thumbnail-img active"
                                 style="height: 80px; object-fit: cover; cursor: pointer;"
                                 onclick="changeMainImage(this.src)">
                        </div>
                        <!-- Add more thumbnails here if needed -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <div class="product-info">
                <!-- Product Title & Category -->
                <div class="mb-3">
                    <?php if ($product['category_name']): ?>
                        <span class="badge badge-primary mb-2"><?= $product['category_name'] ?></span>
                    <?php endif; ?>
                    <h1 class="h2 mb-0"><?= $product['name'] ?></h1>
                </div>

                <!-- Price -->
                <div class="price-section mb-4">
                    <h3 class="text-primary mb-0">Rp <?= number_format($product['price'], 0, ',', '.') ?></h3>
                    <small class="text-muted">Harga per box</small>
                </div>

                <!-- Stock Status -->
                <div class="stock-status mb-3">
                    <?php if ($product['stock'] > 0): ?>
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle"></i> Tersedia (<?= $product['stock'] ?> box)
                        </span>
                    <?php else: ?>
                        <span class="badge badge-danger">
                            <i class="fas fa-times-circle"></i> Stok Habis
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Product Description -->
                <div class="description mb-4">
                    <h5>Deskripsi Produk</h5>
                    <p><?= nl2br($product['description']) ?></p>
                </div>

                <!-- Product Details -->
                <div class="product-details mb-4">
                    <h5>Detail Produk</h5>
                    <ul class="list-unstyled">
                        <li><strong>Berat:</strong> <?= $product['weight'] ?? 300 ?> gram</li>
                        <li><strong>Kategori:</strong> <?= $product['category_name'] ?: 'Tidak ada kategori' ?></li>
                        <li><strong>Kondisi:</strong> Baru</li>
                        <li><strong>Masa Simpan:</strong> 3 hari di kulkas</li>
                    </ul>
                </div>

                <?php if ($product['stock'] > 0): ?>
                    <!-- Quantity & Add to Cart -->
                    <div class="purchase-section">
                        <form id="addToCartForm" action="<?= base_url('/cart/add') ?>" method="post" class="mb-3">
                            <div class="row align-items-end">
                                <div class="col-md-4">
                                    <label for="quantity" class="form-label">Jumlah:</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-outline-secondary" onclick="decreaseQuantity()">-</button>
                                        <input type="number" class="form-control text-center" id="quantity" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>">
                                        <button type="button" class="btn btn-outline-secondary" onclick="increaseQuantity()">+</button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    
                                    <?php if (session()->get('isLoggedIn')): ?>
                                        <button type="submit" class="btn btn-outline-primary btn-lg mr-2">
                                            <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                        </button>
                                    <?php else: ?>
                                        <a href="<?= base_url('/auth/login') ?>" class="btn btn-outline-primary btn-lg mr-2">
                                            <i class="fas fa-sign-in-alt"></i> Login untuk Membeli
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>

                        <?php if (session()->get('isLoggedIn')): ?>
                            <!-- Quick Checkout Button -->
                            <form action="<?= base_url('/checkout/quick') ?>" method="post" class="mb-3">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="quantity" id="quickCheckoutQuantity" value="1">
                                <button type="submit" class="btn btn-success btn-lg btn-block">
                                    <i class="fas fa-bolt"></i> Beli Sekarang
                                </button>
                            </form>
                        <?php endif; ?>

                        <!-- Shipping Info -->
                        <div class="shipping-info mt-3">
                            <small class="text-muted">
                                <i class="fas fa-truck"></i> Gratis ongkir untuk pembelian minimal Rp 100.000<br>
                                <i class="fas fa-clock"></i> Estimasi pengiriman 1-2 hari kerja<br>
                                <i class="fas fa-shield-alt"></i> Garansi kualitas produk
                            </small>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> 
                        Maaf, produk ini sedang habis. Silakan cek kembali nanti atau hubungi kami untuk informasi restock.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Product Tabs -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab">
                        Deskripsi Lengkap
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="ingredients-tab" data-toggle="tab" href="#ingredients" role="tab">
                        Komposisi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab">
                        Ulasan (0)
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="productTabsContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <div class="p-4">
                        <h5>Tentang <?= $product['name'] ?></h5>
                        <p><?= nl2br($product['description']) ?></p>
                        
                        <h6>Keunggulan Produk:</h6>
                        <ul>
                            <li>Dibuat dengan bahan-bahan premium berkualitas tinggi</li>
                            <li>Proses pembuatan higienis dan terjaga kebersihannya</li>
                            <li>Rasa yang autentik dan tidak terlalu manis</li>
                            <li>Kemasan yang menarik dan food grade</li>
                            <li>Cocok untuk berbagai acara dan moment spesial</li>
                        </ul>

                        <h6>Cara Penyimpanan:</h6>
                        <p>Simpan di dalam kulkas pada suhu 2-8°C. Konsumsi dalam waktu 3 hari setelah pembelian untuk kualitas terbaik.</p>
                    </div>
                </div>
                <div class="tab-pane fade" id="ingredients" role="tabpanel">
                    <div class="p-4">
                        <h5>Komposisi & Bahan</h5>
                        <p><strong>Bahan Utama:</strong></p>
                        <ul>
                            <li>Susu segar berkualitas tinggi</li>
                            <li>Cream cheese premium</li>
                            <li>Gula pasir</li>
                            <li>Telur segar</li>
                            <li>Tepung terigu protein sedang</li>
                            <li>Vanilla extract</li>
                        </ul>
                        
                        <p><strong>Informasi Alergen:</strong></p>
                        <p class="text-warning">
                            <i class="fas fa-exclamation-triangle"></i> 
                            Mengandung susu, telur, dan gluten. Diproduksi di fasilitas yang juga memproses kacang-kacangan.
                        </p>
                    </div>
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <div class="p-4">
                        <h5>Ulasan Pelanggan</h5>
                        <div class="text-center py-5">
                            <i class="fas fa-star-o fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada ulasan untuk produk ini.</p>
                            <p class="text-muted">Jadilah yang pertama memberikan ulasan!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Produk Terkait</h3>
            <div class="row">
                <?php foreach ($relatedProducts as $relatedProduct): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="<?= base_url('images/' . $relatedProduct['image']) ?>" 
                             class="card-img-top" 
                             alt="<?= $relatedProduct['name'] ?>"
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title"><?= $relatedProduct['name'] ?></h6>
                            <p class="card-text flex-grow-1"><?= substr($relatedProduct['description'], 0, 80) ?>...</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="text-primary">Rp <?= number_format($relatedProduct['price'], 0, ',', '.') ?></strong>
                                    <small class="text-muted">Stok: <?= $relatedProduct['stock'] ?></small>
                                </div>
                                <a href="<?= base_url('/product/' . $relatedProduct['id']) ?>" class="btn btn-outline-primary btn-sm btn-block">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function changeMainImage(src) {
    document.getElementById('mainProductImage').src = src;
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail-img').forEach(img => {
        img.classList.remove('active');
    });
    event.target.classList.add('active');
}

function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const maxValue = parseInt(quantityInput.max);
    
    if (currentValue < maxValue) {
        quantityInput.value = currentValue + 1;
        updateQuickCheckoutQuantity();
    }
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    
    if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
        updateQuickCheckoutQuantity();
    }
}

function updateQuickCheckoutQuantity() {
    const quantity = document.getElementById('quantity').value;
    document.getElementById('quickCheckoutQuantity').value = quantity;
}

// Update quick checkout quantity when quantity input changes
document.getElementById('quantity').addEventListener('change', updateQuickCheckoutQuantity);

// Image zoom effect
document.getElementById('mainProductImage').addEventListener('mouseover', function() {
    this.style.transform = 'scale(1.05)';
    this.style.transition = 'transform 0.3s ease';
});

document.getElementById('mainProductImage').addEventListener('mouseout', function() {
    this.style.transform = 'scale(1)';
});
</script>

<style>
.thumbnail-img.active {
    border: 2px solid #007bff;
}

.product-image-container {
    position: sticky;
    top: 20px;
}

.nav-tabs .nav-link {
    color: #6c757d;
}

.nav-tabs .nav-link.active {
    color: #007bff;
    border-color: #007bff #007bff #fff;
}

.input-group .btn {
    border-color: #ced4da;
}

.input-group .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.shipping-info {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    border-left: 4px solid #007bff;
}

.price-section h3 {
    font-weight: bold;
}

.stock-status .badge {
    font-size: 0.9em;
    padding: 8px 12px;
}
</style>
<?= $this->endSection() ?>
