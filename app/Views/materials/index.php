<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?> 

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">DATA MATERIAL</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        
        <div class="card">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title fw-bold m-0">Stok Bahan Baku</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-warning text-white fw-bold btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            <i class="bi bi-plus-lg"></i> Tambah Material
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <div class="d-flex align-items-center">
                        <form action="" method="get" class="d-flex align-items-center me-3">
                            <?php if(isset($keyword)): ?><input type="hidden" name="keyword" value="<?= $keyword ?>"><?php endif; ?>
                            <span class="me-2 text-secondary">Show</span>
                            <select name="per_page" class="form-select form-select-sm me-2" style="width: 70px;" onchange="this.form.submit()">
                                <option value="5" <?= (isset($perPage) && $perPage == 5) ? 'selected' : '' ?>>5</option>
                                <option value="10" <?= (isset($perPage) && $perPage == 10) ? 'selected' : '' ?>>10</option>
                                <option value="25" <?= (isset($perPage) && $perPage == 25) ? 'selected' : '' ?>>25</option>
                            </select>
                            <span class="text-secondary me-3">entries</span>
                        </form>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalImport">
                                <i class="bi bi-upload"></i> Import CSV
                            </button>

                            <a href="<?= base_url('materials/export/csv') ?>" target="_blank" class="btn btn-secondary btn-sm">
                                <i class="bi bi-filetype-csv"></i> CSV
                            </a>
                            <a href="<?= base_url('materials/export/excel') ?>" target="_blank" class="btn btn-secondary btn-sm">
                                <i class="bi bi-file-earmark-excel"></i> Excel
                            </a>
                        <a href="<?= base_url('materials/print') ?>" target="_blank" class="btn btn-secondary btn-sm">
                            <i class="bi bi-printer"></i> Print
                        </a>
                        </div>
                    </div>

                    <div>
                        <form action="" method="get">
                            <?php if(isset($perPage)): ?><input type="hidden" name="per_page" value="<?= $perPage ?>"><?php endif; ?>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">Search:</span>
                                <input type="text" name="keyword" class="form-control" style="width: 200px;" value="<?= isset($keyword) ? $keyword : '' ?>" placeholder="Nama/Kode...">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Gambar</th>
                                <th>Nama Material</th>
                                <th>Warna</th>
                                <th>Satuan</th>
                                <th>Harga Beli</th>
                                <th>Stok</th>
                                <th>Atribut</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($materials as $m): ?>
                            <tr>
                                <td><?= $m['kode_material'] ?></td>
                                
                                <td class="text-center">
                                    <?php if($m['gambar'] != 'default.png' && file_exists('uploads/'.$m['gambar'])): ?>
                                        <img src="<?= base_url('uploads/'.$m['gambar']) ?>" 
                                             class="rounded border shadow-sm img-preview"
                                             style="width: 40px; height: 40px; object-fit: cover;"
                                             data-bs-toggle="modal" 
                                             data-bs-target="#modalLihatGambar"
                                             data-foto="<?= base_url('uploads/'.$m['gambar']) ?>"
                                             data-nama="<?= $m['nama_material'] ?>"
                                             title="Klik untuk zoom">
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Img</span>
                                    <?php endif; ?>
                                </td>

                                <td><?= $m['nama_material'] ?></td>
                                <td><?= $m['warna'] ?></td>
                                <td><?= $m['satuan'] ?></td>
                                <td>Rp <?= number_format($m['harga_beli'], 0, ',', '.') ?></td>
                                <td><span class="badge bg-success"><?= $m['stok'] ?></span></td>
                                
                                <td>
                                    <?php 
                                        if($m['atribut']){
                                            $attrs = json_decode($m['atribut'], true);
                                            if($attrs){
                                                foreach($attrs as $a){
                                                    echo '<span class="badge bg-light text-dark border me-1">'.$a['name'].': '.$a['value'].'</span>';
                                                }
                                            }
                                        } 
                                    ?>
                                </td>

                                <td>
                                    <a href="#" class="btn btn-info btn-sm text-white" 
                                       data-bs-toggle="modal" data-bs-target="#modalEdit"
                                       data-id="<?= $m['id'] ?>"
                                       data-nama="<?= $m['nama_material'] ?>"
                                       data-warna="<?= $m['warna'] ?>"
                                       data-satuan="<?= $m['satuan'] ?>"
                                       data-stok="<?= $m['stok'] ?>"
                                       data-harga="<?= $m['harga_beli'] ?>"
                                       data-atribut="<?= htmlspecialchars($m['atribut'] ?? '') ?>">
                                       <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="<?= base_url('materials/delete/'.$m['id']) ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Hapus?')">
                                       <i class="bi bi-trash-fill"></i>
                                    </a>
                                </td>
                                <div class="modal fade" id="modalImport" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">Import Data CSV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?= base_url('materials/import') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <p class="text-muted">
                            Gunakan fitur ini untuk menambah data banyak sekaligus atau mengedit massal.
                            <br>
                            <small class="text-danger">* Jika <b>Kode Material</b> sama, data akan di-update.</small><br>
                            <small class="text-success">* Jika <b>Kode Material</b> belum ada, data baru dibuat.</small>
                        </p>
                        <div class="mb-3">
                            <label class="fw-bold">Pilih File CSV</label>
                            <input type="file" name="file_csv" class="form-control" accept=".csv" required>
                        </div>
                        <div class="alert alert-info py-2" style="font-size: 0.9rem;">
                            <strong>Urutan Kolom CSV (Wajib):</strong><br>
                            Kode, Nama, Warna, Satuan, Stok, Harga Beli, Atribut
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success text-white fw-bold">Upload & Proses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
                    <?= $pager->links('materials', 'my_pagination') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title fw-bold">Tambah Material</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <form action="<?= base_url('materials/store') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3"><label class="fw-bold">Nama Material</label><input type="text" name="nama_material" class="form-control" required></div>
                            <div class="col-md-6 mb-3"><label class="fw-bold">Warna</label><input type="text" name="warna" class="form-control"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label class="fw-bold">Quantity</label><input type="number" step="0.01" name="stok" class="form-control" required></div>
                            <div class="col-md-6 mb-3"><label class="fw-bold">Satuan</label>
                                <select name="satuan" class="form-select"><option value="Yard">Yard</option><option value="Meter">Meter</option><option value="Pcs">Pcs</option></select>
                            </div>
                        </div>
                        <div class="mb-3"><label class="fw-bold">Harga Beli</label><input type="number" name="harga_beli" class="form-control" value="0"></div>
                        <div class="mb-3"><label class="fw-bold">Foto</label><input type="file" name="foto" class="form-control"></div>
                        
                        <div class="mb-2 d-flex justify-content-between"><label class="fw-bold">Atribut</label><button type="button" class="btn btn-success btn-sm" id="btnAddAttr">+ Tambah</button></div>
                        <div id="attrContainer" class="p-2 border rounded bg-light"><small class="text-muted">Belum ada atribut.</small></div>
                    </div>
                    <div class="modal-footer"><button type="submit" class="btn btn-warning text-white">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white"><h5 class="modal-title fw-bold">Edit Material</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <form action="<?= base_url('materials/update') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3"><label class="fw-bold">Nama Material</label><input type="text" name="nama_material" id="edit_nama" class="form-control" required></div>
                            <div class="col-md-6 mb-3"><label class="fw-bold">Warna</label><input type="text" name="warna" id="edit_warna" class="form-control"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label class="fw-bold">Quantity</label><input type="number" step="0.01" name="stok" id="edit_stok" class="form-control" required></div>
                            <div class="col-md-6 mb-3"><label class="fw-bold">Satuan</label>
                                <select name="satuan" id="edit_satuan" class="form-select"><option value="Yard">Yard</option><option value="Meter">Meter</option><option value="Pcs">Pcs</option></select>
                            </div>
                        </div>
                        <div class="mb-3"><label class="fw-bold">Harga Beli</label><input type="number" name="harga_beli" id="edit_harga" class="form-control"></div>
                        <div class="mb-3"><label class="fw-bold">Ganti Foto</label><input type="file" name="foto" class="form-control"></div>
                        
                        <div class="mb-2 d-flex justify-content-between"><label class="fw-bold">Atribut</label><button type="button" class="btn btn-success btn-sm" id="btnAddAttrEdit">+ Tambah</button></div>
                        <div id="attrContainerEdit" class="p-2 border rounded bg-light"></div>
                    </div>
                    <div class="modal-footer"><button type="submit" class="btn btn-info text-white">Update</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLihatGambar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white py-2">
                    <h6 class="modal-title fw-bold" id="judulGambar">Preview</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0 text-center bg-light d-flex justify-content-center align-items-center" style="min-height: 200px;">
                    <img src="" id="imgTampil" class="img-fluid" style="max-height: 500px;">
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    // Fungsi Bikin Baris Atribut
    function createAttrRow(containerId, nameVal = '', valVal = '') {
        const container = document.getElementById(containerId);
        if(container.querySelector('.text-muted')) container.querySelector('.text-muted').remove();
        
        const row = document.createElement('div');
        row.className = 'row mb-2 align-items-center attr-row';
        row.innerHTML = `
            <div class="col-5"><input type="text" name="attr_name[]" class="form-control form-control-sm" placeholder="Nama" value="${nameVal}" required></div>
            <div class="col-6"><input type="text" name="attr_value[]" class="form-control form-control-sm" placeholder="Nilai" value="${valVal}" required></div>
            <div class="col-1"><button type="button" class="btn btn-danger btn-sm p-1" onclick="this.closest('.attr-row').remove()">x</button></div>
        `;
        container.appendChild(row);
    }

    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. LOGIC MODAL PREVIEW GAMBAR
        var modalGambar = document.getElementById('modalLihatGambar');
        if (modalGambar) {
            modalGambar.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var fotoSrc = button.getAttribute('data-foto');
                var nama = button.getAttribute('data-nama');

                document.getElementById('imgTampil').src = fotoSrc;
                document.getElementById('judulGambar').textContent = nama;
            });
        }

        // 2. LOGIC ATRIBUT (Tambah)
        document.getElementById('btnAddAttr').addEventListener('click', function() { createAttrRow('attrContainer'); });
        document.getElementById('btnAddAttrEdit').addEventListener('click', function() { createAttrRow('attrContainerEdit'); });

        // 3. LOGIC EDIT (Isi Form)
        var modalEdit = document.getElementById('modalEdit');
        if(modalEdit){
            modalEdit.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                document.getElementById('edit_id').value = button.getAttribute('data-id');
                document.getElementById('edit_nama').value = button.getAttribute('data-nama');
                document.getElementById('edit_warna').value = button.getAttribute('data-warna');
                document.getElementById('edit_satuan').value = button.getAttribute('data-satuan');
                document.getElementById('edit_stok').value = button.getAttribute('data-stok');
                document.getElementById('edit_harga').value = button.getAttribute('data-harga');

                const attrContainer = document.getElementById('attrContainerEdit');
                attrContainer.innerHTML = ''; 
                const jsonAttr = button.getAttribute('data-atribut');
                if (jsonAttr && jsonAttr !== 'null') {
                    try {
                        const attrs = JSON.parse(jsonAttr);
                        attrs.forEach(a => { createAttrRow('attrContainerEdit', a.name, a.value); });
                    } catch (e) {}
                }
            });
        }
    });
</script>

<?= $this->endSection() ?>