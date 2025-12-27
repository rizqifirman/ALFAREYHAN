<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Data Material</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 5px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; vertical-align: middle; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        .center { text-align: center; }
        .right { text-align: right; }
        .table-img { width: 40px; height: 40px; object-fit: cover; border: 1px solid #ccc; display: block; margin: auto; }
        .no-img { width: 40px; height: 40px; background: #eee; text-align: center; line-height: 40px; font-size: 9px; color: #999; border: 1px solid #ccc; margin: auto; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1>Laporan Stok Material</h1>
        <p>Tanggal: <?= date('d-m-Y H:i') ?></p>
    </div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="8%">Gambar</th>
                <th>Kode</th>
                <th>Nama Material</th>
                <th>Warna</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($materials as $m): ?>
            <tr>
                <td class="center"><?= $no++ ?></td>
                <td>
                    <?php 
                        $img = isset($m['gambar']) ? $m['gambar'] : 'default.png';
                        $path = 'uploads/materials/' . $img;
                        if (!file_exists(FCPATH . $path)) { $path = 'uploads/' . $img; }
                        
                        if(!empty($img) && $img != 'default.png' && file_exists(FCPATH . $path)): 
                    ?>
                        <img src="<?= base_url($path) ?>" class="table-img">
                    <?php else: ?>
                        <div class="no-img">No Img</div>
                    <?php endif; ?>
                </td>
                <td><?= $m['kode_material'] ?></td>
                <td style="font-weight:bold;"><?= $m['nama_material'] ?></td>
                <td><?= isset($m['warna']) ? $m['warna'] : '-' ?></td>
                <td class="center"><?= isset($m['satuan']) ? $m['satuan'] : 'Pcs' ?></td>
                <td class="center" style="font-weight:bold;"><?= $m['stok'] ?></td>
                <td class="right">Rp <?= isset($m['harga_beli']) ? number_format($m['harga_beli'], 0, ',', '.') : '0' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>