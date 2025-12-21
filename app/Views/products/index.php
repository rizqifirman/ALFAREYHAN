<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<style>
    @media print {
        /* Sembunyikan Sidebar, Tombol, Form saat nge-print */
        .app-sidebar, .app-header, .btn, .breadcrumb, form, .pagination { display: none !important; }
        .content-wrapper { margin: 0 !important; padding: 0 !important; }
        
        /* PERBAIKAN DISINI: Gunakan 'box-shadow' */
        .card { border: none !important; box-shadow: none !important; }
        
        /* Tampilkan tabel secara penuh */
        table { width: 100% !important; border-collapse: collapse; }
        th, td { border: 1px solid #000 !important; padding: 5px; }
    }
</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">PRODUK</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        
<div class="card">
    
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title fw-bold m-0">Master Data Produk</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-warning text-white fw-bold btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-lg"></i> Tambah Produk
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
                        <option value="50" <?= (isset($perPage) && $perPage == 50) ? 'selected' : '' ?>>50</option>
                    </select>
                    <span class="text-secondary me-3">entries</span>
                </form>
                <div class="btn-group">
                            <button type="button" class="btn btn-success btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalImport">
                                <i class="bi bi-upload"></i> Import CSV
                            </button>

                            <a href="<?= base_url('products/export/csv') ?>" target="_blank" class="btn btn-secondary btn-sm">
                                <i class="bi bi-filetype-csv"></i> CSV
                            </a>
                            <a href="<?= base_url('products/export/excel') ?>" target="_blank" class="btn btn-secondary btn-sm">
                                <i class="bi bi-file-earmark-excel"></i> Excel
                            </a>
                            <button type="button" onclick="window.print()" class="btn btn-secondary btn-sm">
                                <i class="bi bi-printer"></i> Print
                            </button>
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
                                <th>Nama Produk</th>
                                <th>Warna</th> <th>Jenis</th>
                                <th>Target</th>
                                <th>Size</th>
                                <th>Kain</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($products as $p): ?>
                            <tr>
                                <td><?= $p['kode_barang'] ?></td>
                                
                                <td class="text-center">
                                    <?php if($p['gambar'] != 'default.png' && file_exists('uploads/'.$p['gambar'])): ?>
                                        <img src="<?= base_url('uploads/'.$p['gambar']) ?>" 
                                             class="rounded border shadow-sm"
                                             style="width: 40px; height: 40px; object-fit: cover; cursor: pointer;"
                                             data-bs-toggle="modal" 
                                             data-bs-target="#modalLihatGambar"
                                             data-foto="<?= base_url('uploads/'.$p['gambar']) ?>"
                                             data-nama="<?= $p['nama_barang'] ?>"
                                             title="Klik untuk zoom">
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No Img</span>
                                    <?php endif; ?>
                                </td>

                                <td><?= $p['nama_barang'] ?></td>
                                
                                <td><?= $p['warna'] ?></td> 

                                <td><?= $p['jenis'] ?></td>
                                
                                <td><?= $p['target'] ?></td>
                                
                                <td><?= $p['size'] ?></td>
                                
                                <td><?= $p['kain'] ?></td>
                                
                                <td><span class="badge bg-success"><?= $p['stok'] ?> Pcs</span></td>

                                <td>
                                    <a href="#" class="btn btn-info btn-sm text-white" 
                                       data-bs-toggle="modal" data-bs-target="#modalEdit"
                                       data-id="<?= $p['id'] ?>"
                                       data-nama="<?= $p['nama_barang'] ?>"
                                       data-warna="<?= $p['warna'] ?>"
                                       data-jenis="<?= $p['jenis'] ?>"
                                       data-target="<?= $p['target'] ?>"
                                       data-size="<?= $p['size'] ?>"
                                       data-kain="<?= $p['kain'] ?>"
                                       data-stok="<?= $p['stok'] ?>">
                                       <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="<?= base_url('products/delete/'.$p['id']) ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Hapus?')">
                                       <i class="bi bi-trash-fill"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

        <div class="d-flex justify-content-end mt-3">
            <?= $pager->links('products', 'my_pagination') ?>
        </div>

    </div>
</div>

    </div>
</section>
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="<?= base_url('products/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="modal-body">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Produk</label>
                        <input type="text" name="nama_barang" class="form-control" placeholder="Masukkan nama produk..." required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Warna</label>
                        <input type="text" name="warna" class="form-control" placeholder="Contoh: Merah Maroon">
                    </div>
                    <div class="row">
                    <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jenis</label>
                            <input type="text" name="jenis" list="list_jenis" class="form-control" placeholder="Pilih atau ketik baru..." required autocomplete="off">
                            <datalist id="list_jenis">
                                <option value="Baju Taqwa">
                                <option value="Gamis">
                                <option value="Kaos">
                                <option value="Kemeja">
                                <option value="Celana">
                            </datalist>
                        </div>
                        <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Target</label>
                                <input type="text" name="target" list="list_target" class="form-control" placeholder="Pilih atau ketik baru..." required autocomplete="off">
                                <datalist id="list_target">
                                    <option value="Ayah">
                                    <option value="Ibu">
                                    <option value="Anak">
                                    <option value="Dewasa">
                                    <option value="Umum">
                                </datalist>
                            </div>
                    </div>

                    <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Size</label>
                        <input type="text" name="size" list="list_size" class="form-control" placeholder="Pilih/Ketik..." required autocomplete="off">
                        <datalist id="list_size">
                            <option value="S">
                            <option value="M">
                            <option value="L">
                            <option value="XL">
                            <option value="XXL">
                            <option value="All Size">
                        </datalist>
                    </div>
                            <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Kain</label>
                            <input type="text" name="kain" class="form-control" placeholder="Contoh: Toyobo" required>
                        </div>
                        <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Produk</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, JPEG. Maks 2MB.</small>
                    </div>

                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white fw-bold">Simpan</button>
                </div>

            </form>
            </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title fw-bold">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
           <form action="<?= base_url('products/update') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="id" id="edit_id"> 
    
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label fw-bold">Nama Produk</label>
            <input type="text" name="nama_barang" id="edit_nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="fw-bold">Warna</label>
            <input type="text" name="warna" id="edit_warna" class="form-control">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Jenis</label>
                <input type="text" name="jenis" id="edit_jenis" list="list_jenis" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Target</label>
                <input type="text" name="target" id="edit_target" list="list_target" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Size</label>
                <input type="text" name="size" id="edit_size" list="list_size" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Kain</label>
                <input type="text" name="kain" id="edit_kain" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Stok</label>
                <input type="number" name="stok" id="edit_stok" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Ganti Foto (Opsional)</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-info text-white fw-bold">Update Data</button>
    </div>
</form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalLihatGambar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white py-2">
                <h6 class="modal-title fw-bold" id="judulGambar">Preview Produk</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 text-center bg-light d-flex justify-content-center align-items-center" style="min-height: 200px;">
                <img src="" id="imgTampil" class="img-fluid" style="max-height: 500px; width: auto; display: block;">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- 1. LOGIKA UNTUK MODAL EDIT PRODUK ---
        var modalEdit = document.getElementById('modalEdit');
        if (modalEdit) {
            modalEdit.addEventListener('show.bs.modal', function (event) {
                // Ambil tombol yang diklik
                var button = event.relatedTarget;
                
                // Ambil data dari atribut data-... pada tombol
                var id = button.getAttribute('data-id');
                var nama = button.getAttribute('data-nama');
                var warna = button.getAttribute('data-warna');
                var jenis = button.getAttribute('data-jenis');
                var target = button.getAttribute('data-target');
                var size = button.getAttribute('data-size');
                var kain = button.getAttribute('data-kain');
                var stok = button.getAttribute('data-stok');

                // Masukkan data tersebut ke dalam input form (Berdasarkan ID)
                // Pastikan ID di sini SAMA PERSIS dengan id="..." di HTML Modal Edit
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_nama').value = nama;
                document.getElementById('edit_warna').value = warna;
                document.getElementById('edit_jenis').value = jenis;
                document.getElementById('edit_target').value = target;
                document.getElementById('edit_size').value = size;     // <--- Ini yang tadi terpotong
                document.getElementById('edit_kain').value = kain;
                document.getElementById('edit_stok').value = stok;
            });
        }

        // --- 2. LOGIKA UNTUK MODAL PREVIEW GAMBAR ---
        var modalGambar = document.getElementById('modalLihatGambar');
        if (modalGambar) {
            modalGambar.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var fotoSrc = button.getAttribute('data-foto');
                var namaProduk = button.getAttribute('data-nama');

                document.getElementById('imgTampil').src = fotoSrc;
                document.getElementById('judulGambar').textContent = namaProduk;
            });
        }
    });
</script>
<div class="modal fade" id="modalImport" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">Import Stok Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?= base_url('products/import') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <p class="text-muted small">
                            Fitur ini untuk upload banyak data sekaligus dari Excel/CSV.
                            <br>
                            <span class="text-danger">* Kode Barang yang sama akan di-update stoknya.</span>
                        </p>
                        <div class="mb-3">
                            <label class="fw-bold">Pilih File CSV</label>
                            <input type="file" name="file_csv" class="form-control" accept=".csv" required>
                        </div>
                        <div class="alert alert-info py-2" style="font-size: 0.85rem;">
                            <strong>Urutan Kolom Wajib (7 Kolom):</strong><br>
                            Kode, Nama, Jenis, Target, Size, Kain, Stok
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
    <?= $this->endSection() ?>