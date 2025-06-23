<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Hubungi Kami</h2>
            <p class="text-center text-muted mb-5">Kami siap membantu Anda. Jangan ragu untuk menghubungi kami!</p>
        </div>
    </div>

    <div class="row">
        <!-- Contact Information -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title">Informasi Kontak</h4>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-map-marker-alt text-primary"></i> Alamat</h5>
                        <p>JL. Imam Bonjol No.207, Pendrikan Kidul<br>
                        Kec. Semarang Tengah, Kota Semarang<br>
                        Jawa Tengah 50131</p>
                    </div>

                    <div class="mb-4">
                        <h5><i class="fas fa-phone text-success"></i> Telepon</h5>
                        <p>+62 24 123 4567<br>
                        +62 812 3456 7890</p>
                    </div>

                    <div class="mb-4">
                        <h5><i class="fas fa-envelope text-info"></i> Email</h5>
                        <p>info@milkystore.com<br>
                        support@milkystore.com</p>
                    </div>

                    <div class="mb-4">
                        <h5><i class="fas fa-clock text-warning"></i> Jam Operasional</h5>
                        <p>Senin - Jumat: 08:00 - 20:00<br>
                        Sabtu - Minggu: 09:00 - 18:00</p>
                    </div>

                    <div class="mb-4">
                        <h5><i class="fas fa-share-alt text-danger"></i> Media Sosial</h5>
                        <div class="d-flex">
                            <a href="#" class="btn btn-outline-primary btn-sm mr-2">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="#" class="btn btn-outline-info btn-sm mr-2">
                                <i class="fab fa-instagram"></i> Instagram
                            </a>
                            <a href="#" class="btn btn-outline-success btn-sm">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title">Kirim Pesan</h4>
                    
                    <form action="<?= base_url('/contact/send') ?>" method="post">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">No. Telepon</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subjek</label>
                            <select class="form-control" id="subject" name="subject" required>
                                <option value="">Pilih Subjek</option>
                                <option value="Pertanyaan Produk">Pertanyaan Produk</option>
                                <option value="Keluhan">Keluhan</option>
                                <option value="Saran">Saran</option>
                                <option value="Kerjasama">Kerjasama</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Pesan</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Tulis pesan Anda di sini..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-paper-plane"></i> Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Lokasi Kami</h5>
                </div>
                <div class="card-body p-0">
                    <div style="width: 100%; height: 400px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                        <div class="text-center">
                            <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Peta akan ditampilkan di sini</p>
                            <small class="text-muted">Integrasi dengan Google Maps atau penyedia peta lainnya</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="text-center mb-4">Pertanyaan yang Sering Diajukan</h3>
            <div class="accordion" id="faqAccordion">
                <div class="card">
                    <div class="card-header" id="faq1">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse1">
                                Bagaimana cara memesan produk?
                            </button>
                        </h2>
                    </div>
                    <div id="collapse1" class="collapse show" data-parent="#faqAccordion">
                        <div class="card-body">
                            Anda dapat memesan produk melalui website kami dengan cara mendaftar terlebih dahulu, kemudian pilih produk yang diinginkan dan tambahkan ke keranjang belanja.
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header" id="faq2">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse2">
                                Berapa lama waktu pengiriman?
                            </button>
                        </h2>
                    </div>
                    <div id="collapse2" class="collapse" data-parent="#faqAccordion">
                        <div class="card-body">
                            Waktu pengiriman biasanya 1-2 hari kerja untuk area Semarang dan sekitarnya. Untuk area luar kota, waktu pengiriman 2-3 hari kerja.
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header" id="faq3">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse3">
                                Apakah ada minimum order?
                            </button>
                        </h2>
                    </div>
                    <div id="collapse3" class="collapse" data-parent="#faqAccordion">
                        <div class="card-body">
                            Tidak ada minimum order. Anda dapat memesan mulai dari 1 box dessert.
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header" id="faq4">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse4">
                                Bagaimana cara pembayaran?
                            </button>
                        </h2>
                    </div>
                    <div id="collapse4" class="collapse" data-parent="#faqAccordion">
                        <div class="card-body">
                            Kami menerima pembayaran melalui transfer bank, e-wallet (OVO, GoPay, DANA), dan kartu kredit melalui sistem pembayaran Midtrans.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
