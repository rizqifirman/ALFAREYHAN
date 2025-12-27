<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Data Tukang</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px 8px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1>Daftar Pekerja / Tukang</h1>
        <p>Data per Tanggal: <?= date('d-m-Y H:i') ?></p>
    </div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>ID Tukang</th>
                <th>Nama Lengkap</th>
                <th>No. Telepon</th>
                <th>Alamat Domisili</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($workers as $w): ?>
            <tr>
                <td style="text-align:center;"><?= $no++ ?></td>
                <td><?= $w['kode_tukang'] ?></td>
                <td style="font-weight:bold;"><?= $w['nama_tukang'] ?></td>
                <td><?= $w['telepon'] ?></td>
                <td><?= $w['alamat'] ?></td>
                <td style="text-align:center;">
                    <?= ($w['status'] == 'Aktif') ? 'AKTIF' : 'TIDAK AKTIF' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>