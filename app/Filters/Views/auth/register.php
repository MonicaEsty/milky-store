<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Register</h4>
                </div>
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

                    <form action="<?= base_url('/auth/register') ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="full_name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" value="<?= old('full_name') ?>" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirm_password">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">No. Telepon</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= old('phone') ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea class="form-control" id="address" name="address" rows="3"><?= old('address') ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <p>Sudah punya akun? <a href="<?= base_url('/auth/login') ?>">Login di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
