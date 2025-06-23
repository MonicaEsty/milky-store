<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Users</h1>
    <div>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
            <i class="fas fa-plus"></i> Tambah User
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h4><?= count($users) ?></h4>
                <p>Total Customer</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h4><?= count(array_filter($users, function($u) { return $u['is_active'] == 1; })) ?></h4>
                <p>User Aktif</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h4><?= count(array_filter($users, function($u) { return $u['is_active'] == 0; })) ?></h4>
                <p>User Nonaktif</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h4><?= count(array_filter($users, function($u) { return strtotime($u['created_at']) > strtotime('-30 days'); })) ?></h4>
                <p>User Baru (30 hari)</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="usersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Status</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td>
                            <strong><?= $user['username'] ?></strong>
                            <?php if (strtotime($user['created_at']) > strtotime('-7 days')): ?>
                                <span class="badge badge-info badge-sm">Baru</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $user['full_name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['phone'] ?: '-' ?></td>
                        <td>
                            <span class="badge badge-<?= $user['is_active'] ? 'success' : 'secondary' ?>">
                                <?= $user['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-info" onclick="viewUser(<?= htmlspecialchars(json_encode($user)) ?>)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-warning" onclick="editUser(<?= htmlspecialchars(json_encode($user)) ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="<?= base_url('/admin/users/toggle-status/' . $user['id']) ?>" method="post" class="d-inline">
                                    <button type="submit" class="btn btn-<?= $user['is_active'] ? 'secondary' : 'success' ?>" 
                                            onclick="return confirm('Yakin ingin <?= $user['is_active'] ? 'menonaktifkan' : 'mengaktifkan' ?> user ini?')">
                                        <i class="fas fa-<?= $user['is_active'] ? 'ban' : 'check' ?>"></i>
                                    </button>
                                </form>
                                <a href="<?= base_url('/admin/users/orders/' . $user['id']) ?>" class="btn btn-primary">
                                    <i class="fas fa-shopping-bag"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User Baru</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="<?= base_url('/admin/users/store') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_username">Username</label>
                                <input type="text" class="form-control" id="add_username" name="username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_email">Email</label>
                                <input type="email" class="form-control" id="add_email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="add_full_name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="add_full_name" name="full_name" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_password">Password</label>
                                <input type="password" class="form-control" id="add_password" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_phone">Telepon</label>
                                <input type="text" class="form-control" id="add_phone" name="phone">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="add_address">Alamat</label>
                        <textarea class="form-control" id="add_address" name="address" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail User</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="viewUserContent">
                <!-- Content will be populated by JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editUserForm" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_username">Username</label>
                                <input type="text" class="form-control" id="edit_username" name="username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_email">Email</label>
                                <input type="email" class="form-control" id="edit_email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_full_name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="edit_full_name" name="full_name" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_password">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                                <input type="password" class="form-control" id="edit_password" name="password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_phone">Telepon</label>
                                <input type="text" class="form-control" id="edit_phone" name="phone">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_address">Alamat</label>
                        <textarea class="form-control" id="edit_address" name="address" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="edit_is_active" name="is_active" value="1">
                            <label class="custom-control-label" for="edit_is_active">User Aktif</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function viewUser(user) {
    const content = `
        <table class="table table-borderless">
            <tr><td><strong>ID:</strong></td><td>${user.id}</td></tr>
            <tr><td><strong>Username:</strong></td><td>${user.username}</td></tr>
            <tr><td><strong>Nama Lengkap:</strong></td><td>${user.full_name}</td></tr>
            <tr><td><strong>Email:</strong></td><td>${user.email}</td></tr>
            <tr><td><strong>Telepon:</strong></td><td>${user.phone || '-'}</td></tr>
            <tr><td><strong>Alamat:</strong></td><td>${user.address || '-'}</td></tr>
            <tr><td><strong>Status:</strong></td><td>
                <span class="badge badge-${user.is_active == 1 ? 'success' : 'secondary'}">
                    ${user.is_active == 1 ? 'Aktif' : 'Nonaktif'}
                </span>
            </td></tr>
            <tr><td><strong>Terdaftar:</strong></td><td>${new Date(user.created_at).toLocaleDateString('id-ID')}</td></tr>
            <tr><td><strong>Terakhir Update:</strong></td><td>${new Date(user.updated_at).toLocaleDateString('id-ID')}</td></tr>
        </table>
    `;
    document.getElementById('viewUserContent').innerHTML = content;
    $('#viewUserModal').modal('show');
}

function editUser(user) {
    document.getElementById('editUserForm').action = '<?= base_url('/admin/users/update/') ?>' + user.id;
    document.getElementById('edit_username').value = user.username;
    document.getElementById('edit_email').value = user.email;
    document.getElementById('edit_full_name').value = user.full_name;
    document.getElementById('edit_phone').value = user.phone || '';
    document.getElementById('edit_address').value = user.address || '';
    document.getElementById('edit_is_active').checked = user.is_active == 1;
    $('#editUserModal').modal('show');
}

// DataTable initialization
$(document).ready(function() {
    $('#usersTable').DataTable({
        "pageLength": 25,
        "order": [[ 0, "desc" ]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });
});
</script>
<?= $this->endSection() ?>
