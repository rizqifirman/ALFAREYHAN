<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Data Produk</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 5px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; vertical-align: middle; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        .center { text-align: center; }
        .table-img { width: 40px; height: 40px; object-fit: cover; border: 1px solid #ccc; display: block; margin: auto; }
        .no-img { width: 40px; height: 40px; background: #eee; text-align: center; line-height: 40px; font-size: 9px; color: #999; border: 1px solid #ccc; margin: auto; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1>Laporan Stok Produk</h1>
        <p>Tanggal: <?= date('d-m-Y H:i') ?></p>
    </div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="8%">Gambar</th>
                <th>Kode</th>
                <th>Nama Produk</th>
                <th>Jenis</th>
                <th>Target</th>
                <th>Size</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($products as $p): ?>
            <tr>
                <td class="center"><?= $no++ ?></td>
                <td>
                    <?php 
                        $path = 'uploads/' . $p['gambar'];
                        if(!empty($p['gambar']) && $p['gambar'] != 'default.png' && file_exists(FCPATH . $path)): 
                    ?>
                        <img src="<?= base_url($path) ?>" class="table-img">
                    <?php else: ?>
                        <div class="no-img">No Img</div>
                    <?php endif; ?>
                </td>
                <td><?= $p['kode_barang'] ?></td>
                <td style="font-weight:bold;"><?= $p['nama_barang'] ?></td>
                <td><?= $p['jenis'] ?></td>
                <td><?= $p['target'] ?></td>
                <td class="center"><?= $p['size'] ?></td>
                <td class="center" style="font-weight:bold;"><?= $p['stok'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>