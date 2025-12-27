<!DOCTYPE html>
<html lang="id">
<head>
    <title>Struk Upah - <?= $garapan['no_faktur'] ?></title>
    <style>
        body { font-family: 'Courier New', monospace; font-size: 12px; padding: 10px; width: 300px; }
        .header { text-align: center; border-bottom: 1px dashed black; margin-bottom: 10px; padding-bottom: 5px; }
        .total { border-top: 1px dashed black; margin-top: 10px; padding-top: 5px; text-align: right; font-size: 14px; font-weight: bold; }
        .item { margin-bottom: 5px; }
        .flex { display: flex; justify-content: space-between; }
        
        /* CSS Tambahan untuk Info Kontak */
        .info-tukang { margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px dashed #ccc; }
        .label { font-weight: bold; width: 60px; display: inline-block; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h3 style="margin:0;">SLIP UPAH JAHIT</h3>
        <small>ALFA REYHAN KONVEKSI</small><br>
        <small>Tgl Selesai: <?= date('d/m/Y H:i', strtotime($garapan['tanggal_selesai'] ?? 'now')) ?></small>
    </div>

    <div class="info-tukang">
        <div>Faktur : <b><?= $garapan['no_faktur'] ?></b></div>
        <div style="margin-top:5px;">
            <span class="label">Nama</span>: <b><?= $garapan['nama_tukang'] ?></b><br>
            <span class="label">Telp</span>: <?= !empty($garapan['telepon']) ? $garapan['telepon'] : '-' ?><br>
            <span class="label">Alamat</span>: <?= !empty($garapan['alamat']) ? $garapan['alamat'] : '-' ?>
        </div>
    </div>

    <div style="margin-bottom: 5px; font-weight:bold; text-decoration: underline;">Rincian Pekerjaan:</div>

    <?php 
    $grandTotal = 0; 
    if(!empty($products)):
        foreach($products as $p): 
            $qtyBayar = $p['qty_hasil']; 
            $subtotal = $qtyBayar * $p['ongkos_satuan'];
            $grandTotal += $subtotal;
    ?>
    <div class="item">
        <div><?= $p['nama_barang'] ?></div>
        <div class="flex">
            <span><?= $qtyBayar ?> x <?= number_format($p['ongkos_satuan']) ?></span>
            <span><?= number_format($subtotal) ?></span>
        </div>
        <?php if($p['qty_retur'] > 0): ?>
            <div style="font-size:10px; color:red;">*Retur/Rusak: <?= $p['qty_retur'] ?> (Tidak Dibayar)</div>
        <?php endif; ?>
    </div>
<?php endforeach; else: ?>
        <div class="item">Data produk tidak ditemukan.</div>
    <?php endif; ?>
    
    <div style="border-top: 1px dashed black; margin: 5px 0;"></div>

    <div class="item flex">
        <span>Subtotal Jahit:</span>
        <span>Rp <?= number_format($grandTotal, 0, ',', '.') ?></span>
    </div>

<?php 
        // Ambil data, jika kosong anggap 0
        $valBonus = $garapan['bonus'] ?? 0;
        $valPotongan = $garapan['potongan'] ?? 0;
        
        // Hitung Total Bersih
        $totalBersih = $grandTotal + $valBonus - $valPotongan;
    ?>

    <?php if($valBonus > 0): ?>
    <div class="item flex" style="color:green;">
        <span>+ Bonus:</span>
        <span>Rp <?= number_format($valBonus, 0, ',', '.') ?></span>
    </div>
    <?php endif; ?>

    <?php if($valPotongan > 0): ?>
    <div class="item flex" style="color:red;">
        <span>- Potongan:</span>
        <span>(Rp <?= number_format($valPotongan, 0, ',', '.') ?>)</span>
    </div>
    <?php endif; ?>

    <div class="total" style="font-size: 16px; border-top: 2px solid black; margin-top:5px;">
        TOTAL TERIMA: Rp <?= number_format($totalBersih, 0, ',', '.') ?>
    </div>
    
    <div style="text-align:center; margin-top:30px;">
        <br>
        <small>( <?= $garapan['nama_tukang'] ?> )</small>
    </div>
</body>
</html>