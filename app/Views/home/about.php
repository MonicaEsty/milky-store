<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <!-- Hero Section -->
    <div class="jumbotron jumbotron-fluid" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('<?= base_url('images/About.jpg') ?>'); background-size: cover; background-position: center;">
        <div class="container text-center text-white">
            <h1 class="display-4">Tentang Milky Dessert Box</h1>
            <p class="lead">Menghadirkan kelezatan dessert premium untuk setiap momen spesial Anda</p>
        </div>
    </div>

    <!-- About Content -->
    <div class="row mt-5">
        <div class="col-md-6">
            <h2>Cerita Kami</h2>
            <p>Milky Dessert Box lahir dari kecintaan kami terhadap dessert berkualitas tinggi. Sejak didirikan pada tahun 2020, kami berkomitmen untuk menghadirkan dessert box premium dengan cita rasa yang tak terlupakan.</p>
            
            <p>Setiap produk kami dibuat dengan bahan-bahan pilihan terbaik dan proses yang higienis. Kami percaya bahwa setiap gigitan harus memberikan pengalaman yang istimewa.</p>

            <h3>Visi Kami</h3>
            <p>Menjadi brand dessert box terdepan di Indonesia yang menghadirkan inovasi rasa dan kualitas terbaik untuk pelanggan.</p>

            <h3>Misi Kami</h3>
            <ul>
                <li>Menghadirkan dessert berkualitas premium dengan harga terjangkau</li>
                <li>Memberikan pelayanan terbaik kepada setiap pelanggan</li>
                <li>Terus berinovasi dalam menciptakan varian rasa baru</li>
                <li>Menjaga kualitas dan kebersihan dalam setiap proses produksi</li>
            </ul>
        </div>
        <div class="col-md-6">
           <img src="<?= base_url('images/logo.png') ?>" alt="About Us" class="img-fluid rounded" width="150" height="auto">

            
            <div class="mt-4">
                <h3>Mengapa Memilih Kami?</h3>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="text-center">
                            <i class="fas fa-award fa-3x text-primary mb-2"></i>
                            <h5>Kualitas Premium</h5>
                            <p>Bahan-bahan pilihan terbaik</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="text-center">
                            <i class="fas fa-heart fa-3x text-danger mb-2"></i>
                            <h5>Dibuat dengan Cinta</h5>
                            <p>Setiap produk dibuat dengan perhatian detail</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="text-center">
                            <i class="fas fa-shipping-fast fa-3x text-success mb-2"></i>
                            <h5>Pengiriman Cepat</h5>
                            <p>Diantar fresh ke tangan Anda</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="text-center">
                            <i class="fas fa-users fa-3x text-info mb-2"></i>
                            <h5>Pelayanan Terbaik</h5>
                            <p>Customer service yang responsif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="container">
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="text-center mb-4">Tim Kami</h2>
        </div>
    </div>

    <div class="d-flex justify-content-center flex-wrap gap-5">
        <div class="text-center" style="max-width: 250px;">
            <img src="<?= base_url('images/chef.jpg') ?>" alt="Chef" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
            <h5>Chef Maria</h5>
            <p class="text-muted mb-1">Head Chef</p>
            <p class="mb-0">Berpengalaman 10+ tahun dalam dunia pastry dan dessert</p>
        </div>

        <div class="text-center" style="max-width: 250px;">
            <img src="<?= base_url('images/manager.jpg') ?>" alt="Manager" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
            <h5>Budi Santoso</h5>
            <p class="text-muted mb-1">Operations Manager</p>
            <p class="mb-0">Memastikan kualitas dan standar produksi terjaga</p>
        </div>

        <div class="text-center" style="max-width: 250px;">
            <img src="<?= base_url('images/cs.jpg') ?>" alt="Customer Service" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
            <h5>Sari Dewi</h5>
            <p class="text-muted mb-1">Customer Relations</p>
            <p class="mb-0">Siap membantu Anda dengan pelayanan terbaik</p>
        </div>
    </div>
</div>

</div>


<?= $this->endSection() ?>
