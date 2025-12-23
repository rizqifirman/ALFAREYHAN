<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Standar Ongkos Jahit</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <a href="<?= base_url('ongkos/export/excel') ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="bi bi-file-earmark-excel"></i> Excel</a>
                       <a href="<?= base_url('ongkos/print') ?>" target="_blank" class="btn btn-secondary btn-sm">
                        <i class="bi bi-printer"></i> Print
                    </a>
                    </div>

                    <button type="button" class="btn btn-warning text-white fw-bold btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-lg"></i> Tambah Ongkos
                    </button>
                </div>
            </div>
            
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <form action="" method="get" class="d-flex align-items-center">
                        <span class="me-2 text-secondary">Show</span>
                        <select name="per_page" class="form-select form-select-sm me-2" style="width: 70px;" onchange="this.form.submit()">
                            <option value="5" <?= ($perPage == 5) ? 'selected' : '' ?>>5</option>
                            <option value="10" <?= ($perPage == 10) ? 'selected' : '' ?>>10</option>
                        </select>
                        <span class="text-secondary">entries</span>
                    </form>

                    <form action="" method="get">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">Search:</span>
                            <input type="text" name="keyword" class="form-control" value="<?= $keyword ?>" placeholder="Nama/Kategori...">
                        </div>
                    </form>
                </div>

               <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Detail (Atribut)</th> <th>Ongkos Jahit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($ongkos as $row): ?>
                            <tr>
                                <td><?= $row['kode_ongkos'] ?></td>
                                <td class="text-center">
                                    <?php 
                                        $imgSource = 'default.png';
                                        // Cek apakah ada gambar dari produk (hasil JOIN tadi)
                                        if(!empty($row['gambar_produk']) && file_exists('uploads/'.$row['gambar_produk'])) {
                                            $imgSource = $row['gambar_produk'];
                                        }
                                    ?>
                                    
                                    <?php if($imgSource != 'default.png'): ?>
                                        <img src="<?= base_url('uploads/'.$imgSource) ?>" class="rounded border" style="width: 40px; height: 40px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded d-flex align-items-center justify-content-center text-white fw-bold bg-secondary" style="width: 40px; height: 40px; font-size: 10px;">No Img</div>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="fw-bold"><?= $row['nama_produk'] ?></td>
                                
                                <td>
                                    <?php 
                                        $details = json_decode($row['detail'], true);
                                        if($details && is_array($details)): 
                                            foreach($details as $key => $val):
                                    ?>
                                        <span class="badge bg-light text-dark border me-1 mb-1">
                                            <?= $key ?>: <b><?= $val ?></b>
                                        </span>
                                    <?php 
                                            endforeach;
                                        else: 
                                            echo '<span class="text-muted small">-</span>';
                                        endif; 
                                    ?>
                                </td>
                                
                                <td class="fw-bold text-success">Rp <?= number_format($row['biaya'], 0, ',', '.') ?></td>

                                <td>
                                    <button class="btn btn-info btn-sm text-white btn-edit" 
                                       data-bs-toggle="modal" data-bs-target="#modalEdit"
                                       data-id="<?= $row['id'] ?>"
                                       data-prodid="<?= $row['product_id'] ?>"
                                       data-biaya="<?= $row['biaya'] ?>"
                                       data-gambar="<?= $row['gambar'] ?>"
                                       data-detail='<?= $row['detail'] ?>'> <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <a href="<?= base_url('ongkos/delete/'.$row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white"><h5 class="modal-title fw-bold">Tambah Ongkos</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <form action="<?= base_url('ongkos/store') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        
                        <div class="mb-3">
                            <label class="fw-bold">Pilih Produk</label>
                            <select name="product_id" class="form-select" required>
                                <option value="">-- Pilih Produk --</option>
                                <?php foreach($products as $p): ?>
                                    <option value="<?= $p['id'] ?>"><?= $p['nama_barang'] ?> (Stok: <?= $p['stok'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">* Hanya produk yang sudah ada di Data Produk yang muncul.</small>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold d-flex justify-content-between">
                                Detail / Atribut
                                <button type="button" class="btn btn-sm btn-success py-0" onclick="addAttrRow('container-attr-tambah')">+ Tambah</button>
                            </label>
                            <div id="container-attr-tambah" class="border p-2 rounded bg-light">
                                <small class="text-muted fst-italic empty-msg">Belum ada atribut. Klik + Tambah.</small>
                            </div>
                        </div>

                        <div class="mb-3"><label class="fw-bold">Biaya Jahit (Rp)</label><input type="number" name="biaya" class="form-control" required></div>
                        
                    </div>
                    <div class="modal-footer"><button type="submit" class="btn btn-warning text-white">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white"><h5 class="modal-title fw-bold">Edit Ongkos</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <form action="<?= base_url('ongkos/update') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit_id">
                    
                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="fw-bold">Produk</label>
                            <select name="product_id" id="edit_product_id" class="form-select" required>
                                <?php foreach($products as $p): ?>
                                    <option value="<?= $p['id'] ?>"><?= $p['nama_barang'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold d-flex justify-content-between">
                                Detail / Atribut
                                <button type="button" class="btn btn-sm btn-success py-0" onclick="addAttrRow('container-attr-edit')">+ Tambah</button>
                            </label>
                            <div id="container-attr-edit" class="border p-2 rounded bg-light">
                                </div>
                        </div>

                        <div class="mb-3"><label class="fw-bold">Biaya Jahit</label><input type="number" name="biaya" id="edit_biaya" class="form-control" required></div>
                        
                    </div>
                    <div class="modal-footer"><button type="submit" class="btn btn-info text-white">Update</button></div>
                </form>
            </div>
        </div>
    </div>

<script>
    // Fungsi Menambah Baris Input Atribut
    function addAttrRow(containerId, key = '', val = '') {
        const container = document.getElementById(containerId);
        
        // Hapus pesan kosong jika ada
        const emptyMsg = container.querySelector('.empty-msg');
        if(emptyMsg) emptyMsg.remove();

        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" name="attr_key[]" class="form-control form-control-sm" placeholder="Jenis (Mis: Size)" value="${key}" required>
            <input type="text" name="attr_value[]" class="form-control form-control-sm" placeholder="Isi (Mis: XL)" value="${val}" required>
            <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">x</button>
        `;
        container.appendChild(div);
    }

    // Logic saat Tombol Edit ditekan
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.btn-edit');
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Ambil data dari atribut tombol
                const id = this.dataset.id;
                const prodId = this.dataset.prodid;
                const biaya = this.dataset.biaya;
                
                const detailJson = this.dataset.detail; // String JSON

                // Isi Form Standar
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_product_id').value = prodId;
                document.getElementById('edit_biaya').value = biaya;
                

                // Isi Form Atribut Dinamis
                const container = document.getElementById('container-attr-edit');
                container.innerHTML = ''; // Bersihkan dulu

                try {
                    const details = JSON.parse(detailJson);
                    // Loop object JSON dan buat input row
                    for (const [key, val] of Object.entries(details)) {
                        addAttrRow('container-attr-edit', key, val);
                    }
                } catch (e) {
                    // Jika JSON error/kosong
                    container.innerHTML = '<small class="text-muted fst-italic empty-msg">Belum ada atribut.</small>';
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>