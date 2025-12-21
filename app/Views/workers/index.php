<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<style>
    @media print {
        body * { visibility: hidden; }
        .table-responsive, .table-responsive * { visibility: visible; }
        .table-responsive { position: absolute; left: 0; top: 0; width: 100%; }
        /* Sembunyikan kolom Aksi saat print */
        th:last-child, td:last-child { display: none !important; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black !important; padding: 5px; color: black !important; }
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">DATA TUKANG</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title fw-bold m-0">Daftar Pekerja</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-warning text-white fw-bold btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            <i class="bi bi-plus-lg"></i> Tambah Tukang
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <form action="" method="get" class="d-flex align-items-center me-3">
                            <span class="me-2 text-secondary">Show</span>
                            <select name="per_page" class="form-select form-select-sm me-2" style="width: 70px;" onchange="this.form.submit()">
                                <option value="5" <?= ($perPage == 5) ? 'selected' : '' ?>>5</option>
                                <option value="10" <?= ($perPage == 10) ? 'selected' : '' ?>>10</option>
                            </select>
                            <span class="text-secondary me-3">entries</span>
                        </form>

                        <div class="btn-group">
                            <a href="<?= base_url('workers/export/csv') ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="bi bi-filetype-csv"></i> CSV</a>
                            <a href="<?= base_url('workers/export/excel') ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="bi bi-file-earmark-excel"></i> Excel</a>
                            <button type="button" onclick="window.print()" class="btn btn-secondary btn-sm"><i class="bi bi-printer"></i> Print</button>
                        </div>
                    </div>

                    <div>
                        <form action="" method="get">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">Search:</span>
                                <input type="text" name="keyword" class="form-control" style="width: 200px;" value="<?= $keyword ?>" placeholder="Nama/Alamat...">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nama Tukang</th>
                                <th>No. Telepon</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($workers as $w): ?>
                            <tr>
                                <td><?= $w['kode_tukang'] ?></td>
                                <td><?= $w['nama_tukang'] ?></td>
                                <td><?= $w['telepon'] ?></td>
                                <td><?= $w['alamat'] ?></td>
                                
                                <td>
                                    <?php if($w['status'] == 'Aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <a href="#" class="btn btn-info btn-sm text-white" 
                                       data-bs-toggle="modal" data-bs-target="#modalEdit"
                                       data-id="<?= $w['id'] ?>"
                                       data-nama="<?= $w['nama_tukang'] ?>"
                                       data-telepon="<?= $w['telepon'] ?>"
                                       data-alamat="<?= $w['alamat'] ?>"
                                       data-status="<?= $w['status'] ?>">
                                       <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="<?= base_url('workers/delete/'.$w['id']) ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Hapus data ini?')">
                                       <i class="bi bi-trash-fill"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <?= $pager->links('workers', 'my_pagination') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white"><h5 class="modal-title fw-bold">Tambah Tukang</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <form action="<?= base_url('workers/store') ?>" method="post">
                    <div class="modal-body">
                        <div class="mb-3"><label class="fw-bold">Nama Tukang</label><input type="text" name="nama_tukang" class="form-control" required></div>
                        <div class="mb-3"><label class="fw-bold">No. Telepon</label><input type="number" name="telepon" class="form-control" required></div>
                        <div class="mb-3"><label class="fw-bold">Alamat</label><textarea name="alamat" class="form-control" rows="2"></textarea></div>
                        <div class="mb-3"><label class="fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="submit" class="btn btn-warning text-white">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white"><h5 class="modal-title fw-bold">Edit Tukang</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <form action="<?= base_url('workers/update') ?>" method="post">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-body">
                        <div class="mb-3"><label class="fw-bold">Nama Tukang</label><input type="text" name="nama_tukang" id="edit_nama" class="form-control" required></div>
                        <div class="mb-3"><label class="fw-bold">No. Telepon</label><input type="number" name="telepon" id="edit_telepon" class="form-control" required></div>
                        <div class="mb-3"><label class="fw-bold">Alamat</label><textarea name="alamat" id="edit_alamat" class="form-control" rows="2"></textarea></div>
                        <div class="mb-3"><label class="fw-bold">Status</label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="submit" class="btn btn-info text-white">Update</button></div>
                </form>
            </div>
        </div>
    </div>

</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalEdit = document.getElementById('modalEdit');
        modalEdit.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            document.getElementById('edit_id').value = button.getAttribute('data-id');
            document.getElementById('edit_nama').value = button.getAttribute('data-nama');
            document.getElementById('edit_telepon').value = button.getAttribute('data-telepon');
            document.getElementById('edit_alamat').value = button.getAttribute('data-alamat');
            document.getElementById('edit_status').value = button.getAttribute('data-status');
        });
    });
</script>

<?= $this->endSection() ?>