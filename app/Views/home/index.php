<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Carousel Section -->
<section id="home">
    <div id="carouselExampleIndicators" class="carousel slide animate__animated animate__fadeIn" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('<?= base_url('images/banner.jpg') ?>');">
                <div class="overlay" style="background: rgba(0, 0, 0, 0.5); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
                <div class="container h-full flex items-center justify-center text-center text-white relative">
                    <div style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);" class="animate__animated animate__fadeInUp">
                        <h1 class="text-5xl font-bold text-center text-white" style="font-family: 'Roboto', sans-serif; color: #ffcc00;">MILKY DESSERT BOX</h1>
                        <div class="text-center mt-6">
                            <a href="<?= base_url('/shop') ?>" class="btn btn-lg btn-primary" style="font-family: 'Roboto', sans-serif; letter-spacing: 1px; background-color: #322800; border-color:#322800;">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('<?= base_url('images/carousel.jpg') ?>');">
                <div class="overlay" style="background: rgba(0, 0, 0, 0.5); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
                <div class="container h-full flex items-center justify-center text-center text-white relative">
                    <div style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);" class="animate__animated animate__fadeInUp">
                        <h1 class="text-5xl font-bold text-center text-white" style="font-family: 'Roboto', sans-serif; color: #ffcc00;">Makes Your Day With Milky Dessert Box</h1>
                        <div class="text-center mt-6">
                            <a href="<?= base_url('/shop') ?>" class="btn btn-lg btn-primary" style="font-family: 'Roboto', sans-serif; letter-spacing: 1px; background-color: #322800; border-color: #322800;">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('<?= base_url('images/banner2.jpg') ?>');">
                <div class="overlay" style="background: rgba(0, 0, 0, 0.5); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
                <div class="container h-full flex items-center justify-center text-center text-white relative">
                    <div style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);" class="animate__animated animate__fadeInUp">
                        <h1 class="text-5xl font-bold text-center text-white" style="font-family: 'Roboto', sans-serif; color: #ffcc00;">Special Promo Buy 1 Get 1!</h1>
                        <div class="text-center mt-6">
                            <a href="<?= base_url('/shop') ?>" class="btn btn-lg btn-primary" style="font-family: 'Roboto', sans-serif; letter-spacing: 1px; background-color: #322800; border-color: #322800;">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>

<!-- Products Section -->
<section id="shop" class="py-12 bg-gray-100">
    <div class="container">
        <h3 class="text-center mb-5">Featured Products</h3>
        <div class="row justify-content-center">
            <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card" style="width: 18rem;">
                    <img src="<?= base_url('images/' . $product['image']) ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                    <div class="card-body">
                        <h5 class="card-title font-bold text-center mb-3"><?= $product['name'] ?></h5>
                        <p class="card-text"><?= substr($product['description'], 0, 100) ?>...</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Rp <?= number_format($product['price'], 0, ',', '.') ?></li>
                        <li class="list-group-item">Stock: <?= $product['stock'] ?></li>
                    </ul>
                    <div class="card-body text-center">
                        <?php if (session()->get('isLoggedIn')): ?>
                            <form action="<?= base_url('/cart/add') ?>" method="post" class="d-inline">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                            </form>
                        <?php else: ?>
                            <a href="<?= base_url('/auth/login') ?>" class="btn btn-primary">Login to Buy</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Service Section -->
<section class="service">
    <div class="container">
        <h3>SERVICE</h3>
        <div class="box">
            <div class="col-4">
                <div class="icon"><i class="fas fa-trophy"></i></div>
                <h4>HIGH QUALITY</h4>
                <p>Crafted From Top Materials</p>
            </div>
            <div class="col-4">
                <div class="icon"><i class="fas fa-shield-alt"></i></div>
                <h4>WARRANTY PROTECTION</h4>
                <p>Quality Guarantee</p>
            </div>
            <div class="col-4">
                <div class="icon"><i class="fas fa-shipping-fast"></i></div>
                <h4>FREE SHIPPING</h4>
                <p>Free Delivery Service</p>
            </div>
            <div class="col-4">
                <div class="icon"><i class="fas fa-headset"></i></div>
                <h4>24/7 SUPPORT</h4>
                <p>Always Ready to Help</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info Section -->
<section class="contact-info">
    <div class="container">
        <h3>CONTACT INFO</h3>
        <div class="box">
            <div class="col-4">
                <h2>Address</h2>
                <p>JL. Imam Bonjol No.207, Pendrikan</p>
                <p>Kidul, Kec. Semarang Tengah, Kota</p>
                <p>Semarang, Jawa Tengah 50131</p>
            </div>
            <div class="col-4">
                <h2>Email</h2>
                <p>info@milkystore.com</p>
                <p>support@milkystore.com</p>
            </div>
            <div class="col-4">
                <h2>Phone</h2>
                <p>+62 24 123 4567</p>
                <p>+62 812 3456 7890</p>
            </div>
            <div class="col-4">
                <h2>Contact Person</h2>
                <p>Customer Service</p>
                <p>Available 24/7</p>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
