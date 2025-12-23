<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Standar Ongkos Jahit</title>
    <style>
        /* CSS Sederhana & Bersih khusus Print */
        body { font-family: Arial, sans-serif; font-size: 12px; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 5px 0; color: #555; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px 8px; text-align: left; vertical-align: middle; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        
        .badge { 
            display: inline-block; padding: 2px 5px; margin: 0 2px;
            border: 1px solid #ccc; background: #f9f9f9; border-radius: 3px; font-size: 11px; 
        }
        .harga { font-weight: bold; text-align: right; }
        .no { text-align: center; width: 40px; }
    </style>
</head>
<body onload="window.print()"> <div class="header">
        <h1>Daftar Standar Ongkos Jahit</h1>
        <p>Data per Tanggal: <?= date('d-m-Y H:i') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="no">No</th>
                <th>Kode ID</th>
                <th>Nama Produk</th>
                <th>Detail / Atribut</th>
                <th>Ongkos Jahit</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($ongkos as $row): ?>
            <tr>
                <td class="no"><?= $no++ ?></td>
                <td><?= $row['kode_ongkos'] ?></td>
                <td><?= $row['nama_produk'] ?></td>
                
                <td>
                    <?php 
                        $details = json_decode($row['detail'], true);
                        if($details && is_array($details)) {
                            foreach($details as $key => $val) {
                                echo "<span class='badge'>$key: <b>$val</b></span>";
                            }
                        } else {
                            echo "-";
                        }
                    ?>
                </td>
                
                <td class="harga">Rp <?= number_format($row['biaya'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>