<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Kategori</h1>
    <button class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">
        <i class="fas fa-plus"></i> Tambah Kategori
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= $category['id'] ?></td>
                        <td><?= $category['name'] ?></td>
                        <td><?= substr($category['description'], 0, 50) ?>...</td>
                        <td>
                            <span class="badge badge-<?= $category['is_active'] ? 'success' : 'secondary' ?>">
                                <?= $category['is_active'] ? 'Aktif' : 'Tidak Aktif' ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($category['created_at'])) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="editCategory(<?= htmlspecialchars(json_encode($category)) ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="<?= base_url('/admin/categories/delete/' . $category['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="<?= base_url('/admin/categories/store') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add_name">Nama Kategori</label>
                        <input type="text" class="form-control" id="add_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="add_description">Deskripsi</label>
                        <textarea class="form-control" id="add_description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kategori</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editCategoryForm" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_name">Nama Kategori</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="edit_is_active" name="is_active" value="1">
                            <label class="custom-control-label" for="edit_is_active">Kategori Aktif</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function editCategory(category) {
    document.getElementById('editCategoryForm').action = '<?= base_url('/admin/categories/update/') ?>' + category.id;
    document.getElementById('edit_name').value = category.name;
    document.getElementById('edit_description').value = category.description;
    document.getElementById('edit_is_active').checked = category.is_active == 1;
    $('#editCategoryModal').modal('show');
}
</script>
<?= $this->endSection() ?>
