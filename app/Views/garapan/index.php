<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    /* CSS TAB Custom */
    .nav-tabs .nav-link {
        color: #495057; background-color: #e9ecef; border: 1px solid #dee2e6; margin-right: 2px; font-weight: bold;
    }
    .nav-tabs .nav-link.active {
        color: #fff !important; background-color: #28a745 !important; /* Hijau Aktif */
        border-color: #28a745 !important;
    }
    .detail-list { font-size: 13px; padding-left: 15px; margin-bottom: 0; }
    .detail-list li { margin-bottom: 3px; }
</style>

<?php if(session()->getFlashdata('success_print')): ?>
<script>document.addEventListener("DOMContentLoaded", function() { window.open('<?= base_url('garapan/print/'.session()->getFlashdata('success_print')) ?>', '_blank'); });</script>
<?php endif; ?>

<?php if(session()->getFlashdata('success_print_gaji')): ?>
<script>document.addEventListener("DOMContentLoaded", function() { window.open('<?= base_url('garapan/print-gaji/'.session()->getFlashdata('success_print_gaji')) ?>', '_blank', 'width=400,height=600'); });</script>
<?php endif; ?>

<div class="content-header">
    <div class="container-fluid"><h1>Manajemen Garapan</h1></div>
</div>

<section class="content">
    <div class="container-fluid">
        <?php if(session()->getFlashdata('success')): ?><div class="alert alert-success"><?= session()->getFlashdata('success') ?></div><?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div><?php endif; ?>

        <div class="card card-outline card-success card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="tab-aktif-tab" data-bs-toggle="pill" href="#tab-aktif" role="tab">Garapan Aktif (Proses)</a></li>
                    <li class="nav-item"><a class="nav-link" id="tab-riwayat-tab" data-bs-toggle="pill" href="#tab-riwayat" role="tab">Riwayat & Laporan</a></li>
                </ul>
            </div>
            
            <div class="card-body">
                <div class="tab-content">
                    
                    <div class="tab-pane fade show active" id="tab-aktif" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <button class="btn btn-warning fw-bold text-white" data-bs-toggle="modal" data-bs-target="#modalBuatSPK"><i class="bi bi-plus-lg"></i> Buat Garapan Keluar</button>
                            <div class="input-group" style="width: 350px;">
                                <input type="text" id="scanInputMain" class="form-control" placeholder="Scan QR / Ketik Faktur...">
                                <button class="btn btn-success text-white" onclick="cariGarapanDariInput()">Scan</button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Faktur & Tgl</th>
                                        <th>Tukang</th>
                                        <th>Detail Target</th>
                                        <th>Status</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
<?php if(empty($garapan_aktif)): ?>
    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada garapan aktif. Silakan buat SPK baru.</td></tr>
<?php else: ?>
    <?php foreach($garapan_aktif as $g): ?>
<tr id="row-<?= $g['no_faktur'] ?>" 
    data-id="<?= $g['id'] ?>" 
    data-tukang="<?= $g['nama_tukang'] ?>"
    data-faktur="<?= $g['no_faktur'] ?>"
    data-products="<?= htmlspecialchars(json_encode($g['detail_products'] ?? []), ENT_QUOTES, 'UTF-8') ?>">
        
        <td>
            <span class="fw-bold text-primary"><?= $g['no_faktur'] ?></span><br>
            <small class="text-muted"><i class="bi bi-calendar"></i> <?= $g['tanggal_spk'] ?></small>
        </td>

        <td class="fw-bold" style="vertical-align: top;"><?= $g['nama_tukang'] ?></td>
        
        <td class="p-2" style="vertical-align: top;">
            
            <div class="mb-2">
                <strong class="text-secondary" style="font-size:11px; text-transform:uppercase;">
                    <i class="bi bi-box-seam"></i> Material (Keluar):
                </strong>
                
                <?php if(!empty($g['detail_materials'])): ?>
                    <ul class="mb-0 ps-3" style="font-size:13px; color:#555;">
                        <?php foreach($g['detail_materials'] as $m): ?>
                            <li>
                                <?= $m['nama_material'] ?>
                                <span class="text-muted" style="font-size:11px;">(<?= $m['warna'] ?>)</span>
                                : <b><?= $m['qty'] ?> <?= $m['satuan'] ?></b>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="text-danger small fst-italic ms-3">- Data Material Kosong -</div>
                <?php endif; ?>
            </div>

            <div style="border-top: 1px dashed #ccc; margin: 8px 0;"></div>

            <div>
                <strong class="text-success" style="font-size:11px; text-transform:uppercase;">
                    <i class="bi bi-check-circle"></i> Target (Hasil):
                </strong>
                
                <?php if(!empty($g['detail_products'])): ?>
                    <ul class="mb-0 ps-3" style="font-size:13px; color:#000;">
                        <?php foreach($g['detail_products'] as $p): ?>
                            <li>
                                <?= $p['nama_barang'] ?>
                                <span class="badge bg-white text-dark border border-secondary" style="font-size:10px; padding: 1px 5px;">
                                    <?= $p['size'] ?>
                                </span>
                                : <b><?= $p['qty_target'] ?> Pcs</b>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="text-danger small fst-italic ms-3">- Data Target Kosong -</div>
                <?php endif; ?>
            </div>
        </td>

        <td><span class="badge bg-warning text-dark">Proses Jahit</span></td>

        <td>
            <button onclick="siapkanModalTerima('<?= $g['no_faktur'] ?>')" class="btn btn-success btn-sm w-100 mb-1">
                <i class="bi bi-box-seam"></i> Terima
            </button>
            <a href="<?= base_url('garapan/print/'.$g['id']) ?>" target="_blank" class="btn btn-secondary btn-sm w-100">
                <i class="bi bi-printer"></i> Cetak SPK
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
<?php endif; ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-riwayat" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Faktur</th>
                                        <th>Tukang</th>
                                        <th>Hasil & Retur</th>
                                        <th>Tgl Selesai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($garapan_riwayat as $r): ?>
<tr>
    <td><?= $r['no_faktur'] ?></td>
    <td><?= $r['nama_tukang'] ?></td>
    <td>
        <ul class="detail-list">
            <?php foreach($r['detail_products'] as $p): ?>
                <li>
                    <?= $p['nama_barang'] ?> (<?= $p['size'] ?>) 
                    Target: <?= $p['qty_target'] ?> | 
                    <span class="text-success fw-bold">Ok: <?= $p['qty_hasil'] ?></span>
                    <?php if($p['qty_retur'] > 0): ?> | <span class="text-danger fw-bold">Retur: <?= $p['qty_retur'] ?></span><?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </td>
    <td><?= $r['tanggal_selesai'] ?></td>
    <td>
        <a href="<?= base_url('garapan/print-gaji/'.$r['id']) ?>" target="_blank" class="btn btn-sm btn-primary mb-1 w-100" title="Cetak Slip Gaji"><i class="bi bi-cash-stack"></i> Upah</a>
        <a href="<?= base_url('garapan/print/'.$r['id']) ?>" target="_blank" class="btn btn-sm btn-secondary w-100 mb-1" title="Cetak SPK"><i class="bi bi-printer"></i> SPK</a>
        
        <?php if(session()->get('role') == 'owner'): ?>
            <a href="<?= base_url('garapan/delete/'.$r['id']) ?>"
               class="btn btn-sm btn-danger w-100"
               onclick="return confirm('PERINGATAN OWNER:\nData ini akan dihapus permanen.\nApakah Anda yakin?')">
               <i class="bi bi-trash"></i> Hapus
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
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modalTerimaBaru" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">Input Garapan Masuk (Diterima)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="" method="post" id="formTerimaBaru">
                <div class="modal-body bg-light">
                    
                    <div class="mb-3">
                        <label class="fw-bold">No. Faktur</label>
                        <div class="input-group">
                            <input type="text" id="terimaFakturDisplay" class="form-control bg-white fw-bold" readonly>
                            <button class="btn btn-success" type="button"><i class="bi bi-search"></i></button>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4 fw-bold">Tukang</div>
                        <div class="col-8" id="terimaTukangDisplay">: -</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="fw-bold small text-muted">Detail Target:</label>
                            <div class="card p-2">
                                <ul id="terimaTargetList" class="ps-3 mb-0" style="font-size:13px;"></ul>
                            </div>
                        </div>
                    </div>
                    
                    <hr>

<div class="row g-2 mb-3">
    <div class="col-6">
        <label class="fw-bold text-success small">Bonus (Opsional)</label>
        <div class="input-group input-group-sm">
            <span class="input-group-text bg-success text-white">Rp</span>
            <input type="text" name="bonus" id="inputBonus" class="form-control border-success fw-bold" placeholder="0" onkeyup="formatRupiah(this)">
        </div>
    </div>
    <div class="col-6">
        <label class="fw-bold text-danger small">Potongan (Opsional)</label>
        <div class="input-group input-group-sm">
            <span class="input-group-text bg-danger text-white">Rp</span>
            <input type="text" name="potongan" id="inputPotongan" class="form-control border-danger fw-bold" placeholder="0" onkeyup="formatRupiah(this)">
        </div>
    </div>
</div>

                    <div class="mb-3">
                        <label class="fw-bold">Aksi / Status Akhir</label>
                        <select name="aksi" id="pilihAksi" class="form-select form-select-lg border-success fw-bold" onchange="cekAksi()">
                            <option value="Selesai" selected>Diterima Lengkap (Selesai)</option>
                            <option value="Retur">Retur / Perbaikan (Ada yang rusak)</option>
                            <option value="Batal" class="text-danger">Cancel / Garapan Tidak Jadi</option>
                        </select>
                    </div>

                    <div id="areaRetur" class="p-2 border border-warning bg-white rounded mb-3" style="display:none;">
                        <label class="text-danger fw-bold small">Masukkan Jumlah Yang Rusak/Diretur:</label>
                        <div id="returInputs">
                            </div>
                    </div>

                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success fw-bold">
                        <i class="bi bi-save"></i> Proses & Update Stok
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalBuatSPK" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white"><h5 class="modal-title fw-bold">Input Garapan Keluar (SPK)</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="<?= base_url('garapan/store') ?>" method="post">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6"><label>No. Faktur</label><input type="text" name="no_faktur" class="form-control fw-bold" value="GP-<?= date('ymd') ?>-<?= rand(100,999) ?>" readonly></div>
                        <div class="col-md-3"><label>Tanggal</label><input type="date" name="tanggal_spk" class="form-control" value="<?= date('Y-m-d') ?>" required></div>
                        <div class="col-md-3">
                            <label>Pilih Penjahit</label>
                            <select name="worker_id" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <?php foreach($workers as $w): ?><option value="<?= $w['id'] ?>"><?= $w['nama_tukang'] ?></option><?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="card bg-light border mb-2"><div class="card-body p-2"><label class="fw-bold text-primary">1. Material Keluar</label>
                    <div id="container-material"><div class="row g-2 mb-2 item-row"><div class="col-8"><select name="material_id[]" class="form-select form-select-sm" required><option value="">-- Pilih Material --</option><?php foreach($materials as $m): ?><option value="<?= $m['id'] ?>"><?= $m['nama_material'] ?> (<?= $m['warna'] ?> | Stok: <?= $m['stok'] ?>)</option><?php endforeach; ?></select></div><div class="col-3"><input type="number" name="material_qty[]" class="form-control form-control-sm" placeholder="Qty" required></div><div class="col-1"></div></div></div>
                    <button type="button" class="btn btn-sm btn-primary mt-1" onclick="tambahMaterial()">+ Tambah</button></div></div>

                    <div class="card bg-light border"><div class="card-body p-2"><label class="fw-bold text-success">2. Target Produk</label>
                    <div id="container-produk"><div class="row g-2 mb-2 item-row"><div class="col-8"><select name="product_id[]" class="form-select form-select-sm" required><option value="">-- Pilih Produk --</option><?php foreach($products as $p): ?><option value="<?= $p['id'] ?>"><?= $p['nama_barang'] ?> (Size: <?= $p['size'] ?>)</option><?php endforeach; ?></select></div><div class="col-3"><input type="number" name="product_qty[]" class="form-control form-control-sm" placeholder="Target" required></div><div class="col-1"></div></div></div>
                    <button type="button" class="btn btn-sm btn-success mt-1" onclick="tambahProduk()">+ Tambah</button></div></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-warning text-white fw-bold"><i class="bi bi-printer"></i> Simpan & Cetak SPK</button></div>
            </form>
        </div>
    </div>
</div>

<script>
    // 1. FUNGSI UNTUK MENAMBAH BARIS INPUT (MODAL SPK)
    function tambahMaterial() {
        var html = `
        <div class="row g-2 mb-2 item-row">
            <div class="col-8">
                <select name="material_id[]" class="form-select form-select-sm">
                    <?php foreach($materials as $m): ?>
                        <option value="<?= $m['id'] ?>"><?= $m['nama_material'] ?> (<?= $m['warna'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-3"><input type="number" name="material_qty[]" class="form-control form-control-sm" placeholder="Qty"></div>
            <div class="col-1"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()">x</button></div>
        </div>`;
        document.getElementById('container-material').insertAdjacentHTML('beforeend', html);
    }

    function tambahProduk() {
        var html = `
        <div class="row g-2 mb-2 item-row">
            <div class="col-8">
                <select name="product_id[]" class="form-select form-select-sm">
                    <?php foreach($products as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= $p['nama_barang'] ?> (Size: <?= $p['size'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-3"><input type="number" name="product_qty[]" class="form-control form-control-sm" placeholder="Target"></div>
            <div class="col-1"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()">x</button></div>
        </div>`;
        document.getElementById('container-produk').insertAdjacentHTML('beforeend', html);
    }

    // 2. FUNGSI SCANNER INPUT (ENTER)
    function cariGarapanDariInput() {
        var keyword = document.getElementById('scanInputMain').value.trim();
        if(keyword == "") return;
        
        // Cek apakah elemen baris tabel ada?
        var row = document.getElementById('row-' + keyword);
        if(row) {
            siapkanModalTerima(keyword);
        } else {
            alert('Faktur ' + keyword + ' tidak ditemukan di tabel Garapan Aktif!');
        }
    }
    
    // Listener agar tekan Enter langsung scan
    var scanInput = document.getElementById("scanInputMain");
    if(scanInput){
        scanInput.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                cariGarapanDariInput();
            }
        });
    }

    // 3. FUNGSI UTAMA: MENYIAPKAN MODAL TERIMA
    function siapkanModalTerima(faktur) {
        console.log("Mencoba membuka modal untuk faktur:", faktur); // Cek Console F12 jika macet

        try {
            var row = document.getElementById('row-' + faktur);
            if(!row) {
                alert("Data baris tidak ditemukan (Error ID).");
                return;
            }

            // Ambil Data dari Atribut HTML
            var id = row.dataset.id;
            var tukang = row.dataset.tukang;
            var rawProducts = row.dataset.products;
            
            console.log("Raw JSON:", rawProducts); // Debugging

            var products = [];
            if(rawProducts && rawProducts !== "null") {
                products = JSON.parse(rawProducts);
            }

            // Isi Form di Modal
            document.getElementById('terimaFakturDisplay').value = faktur;
            document.getElementById('terimaTukangDisplay').innerText = ": " + tukang;
            document.getElementById('formTerimaBaru').action = "<?= base_url('garapan/terima/') ?>" + id;

            // Render List Target & Input Retur
            var listHtml = '';
            var returHtml = '';
            
            if(products.length === 0) {
                listHtml = '<li class="text-danger">Detail Target Kosong / Gagal Dimuat.</li>';
                returHtml = '<div class="text-danger">Tidak ada produk untuk diretur.</div>';
            } else {
                products.forEach(function(p) {
                    var nama = p.nama_barang || 'Item Tanpa Nama';
                    var size = p.size || '-';
                    var qty = p.qty_target || 0;
                    var pid = p.product_id || 0; // Pastikan ini ada

                    listHtml += `<li>${nama} (${size}): <b>${qty} Pcs</b></li>`;
                    
                    returHtml += `
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="font-size:12px;">${nama} (${size})</span>
                            <input type="number" name="qty_retur[${pid}]" class="form-control form-control-sm border-danger text-danger fw-bold" style="width:80px;" min="0" max="${qty}" placeholder="0">
                        </div>
                    `;
                });
            }

            document.getElementById('terimaTargetList').innerHTML = listHtml;
            document.getElementById('returInputs').innerHTML = returHtml;
            
            // Reset Pilihan
            document.getElementById('pilihAksi').value = 'Selesai';
            cekAksi();

            // Tampilkan Modal
            var myModal = new bootstrap.Modal(document.getElementById('modalTerimaBaru'));
            myModal.show();

        } catch (error) {
            console.error("Error JS:", error);
            alert("Terjadi kesalahan sistem saat membuka modal. Cek Console (F12).");
        }
    }

    // 4. FUNGSI CEK DROPDOWN AKSI
    function cekAksi() {
        var val = document.getElementById('pilihAksi').value;
        var area = document.getElementById('areaRetur');
        if(val == 'Retur') {
            area.style.display = 'block';
        } else {
            area.style.display = 'none';
        }
    }
    // Tambahkan fungsi ini di dalam <script> paling bawah
function formatRupiah(input) {
    // Hapus karakter selain angka
    var value = input.value.replace(/[^,\d]/g, '').toString();
    var split = value.split(',');
    var sisa = split[0].length % 3;
    var rupiah = split[0].substr(0, sisa);
    var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    input.value = rupiah;
}
</script>

<?= $this->endSection() ?>