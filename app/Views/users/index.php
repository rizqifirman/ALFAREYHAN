
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1>Manajemen Akun Sistem</h1></div>
            <div class="col-sm-6 text-right">
                <button class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-person-plus-fill"></i> Tambah Akun Baru
                </button>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="card card-outline card-primary">
            <div class="card-body p-0">
                <table class="table table-striped table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 50px">No</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Role (Hak Akses)</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($users as $u): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td class="fw-bold"><?= $u['nama_lengkap'] ?></td>
                            <td><?= $u['username'] ?></td>
                            <td>
                                <?php 
                                    $badge = 'bg-secondary';
                                    if(strtolower($u['role']) == 'owner') $badge = 'bg-danger';
                                    if(strtolower($u['role']) == 'admin') $badge = 'bg-primary';
                                    if(strtolower($u['role']) == 'kasir') $badge = 'bg-success';
                                ?>
                                <span class="badge <?= $badge ?>"><?= ucfirst($u['role']) ?></span>
                            </td>
                            <td>
                                <?php if($u['status'] == 'Aktif'): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Non-Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm text-white" 
                                    onclick='editUser(<?= json_encode($u) ?>)'>
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                
                                <?php if(session()->get('id') != $u['id']): ?>
                                    <a href="<?= base_url('users/delete/'.$u['id']) ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin ingin menghapus akun ini?')">
                                       <i class="bi bi-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white"><h5 class="modal-title">Tambah Akun Baru</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
            <form action="<?= base_url('users/store') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3"><label>Nama Lengkap</label><input type="text" name="nama_lengkap" class="form-control" required></div>
                    <div class="mb-3"><label>Username (Login)</label><input type="text" name="username" class="form-control" required></div>
                    <div class="mb-3"><label>Password</label><input type="text" name="password" class="form-control" required></div>
                    <div class="mb-3">
                        <label>Role / Jabatan</label>
                        <select name="role" class="form-select" required>
                            <option value="Admin">Admin Produksi</option>
                            <option value="Kasir">Kasir / Toko</option>
                            <option value="Owner">Owner</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan Akun</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white"><h5 class="modal-title">Edit Akun</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="" method="post" id="formEditUser">
                <div class="modal-body">
                    <div class="mb-3"><label>Nama Lengkap</label><input type="text" name="nama_lengkap" id="editNama" class="form-control" required></div>
                    <div class="mb-3"><label>Username</label><input type="text" name="username" id="editUsername" class="form-control" required></div>
                    
                    <div class="mb-3 p-2 bg-light border rounded">
                        <label class="text-danger small">Ganti Password (Opsional)</label>
                        <input type="text" name="password" class="form-control form-control-sm" placeholder="Kosongkan jika tidak ingin mengganti password">
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <label>Role</label>
                            <select name="role" id="editRole" class="form-select">
                                <option value="Admin">Admin</option>
                                <option value="Kasir">Kasir</option>
                                <option value="Owner">Owner</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Status</label>
                            <select name="status" id="editStatus" class="form-select">
                                <option value="Aktif">Aktif</option>
                                <option value="Non-Aktif">Non-Aktif (Blokir)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-warning fw-bold">Update Data</button></div>
            </form>
        </div>
    </div>
</div>

<script>
    function editUser(data) {
        // Isi Form di Modal Edit
        document.getElementById('editNama').value = data.nama_lengkap;
        document.getElementById('editUsername').value = data.username;
        document.getElementById('editRole').value = data.role;
        document.getElementById('editStatus').value = data.status;
        
        // Set Action URL
        document.getElementById('formEditUser').action = "<?= base_url('users/update/') ?>" + data.id;
        
        // Tampilkan Modal
        new bootstrap.Modal(document.getElementById('modalEdit')).show();
    }
</script>

<?= $this->endSection() ?>

