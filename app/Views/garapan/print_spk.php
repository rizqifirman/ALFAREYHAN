<!DOCTYPE html>
<html lang="id">
<head>
    <title>SPK Garapan - <?= $garapan['no_faktur'] ?></title>
    <style>
        body { font-family: 'Courier New', monospace; font-size: 12px; padding: 20px; }
        .box { border: 2px solid black; padding: 15px; margin-bottom: 10px; }
        .header { text-align: center; border-bottom: 2px dashed black; padding-bottom: 10px; margin-bottom: 15px; }
        
        /* Layout Informasi Atas */
        .info-table { width: 100%; border: none; margin-bottom: 15px; }
        .info-table td { border: none; vertical-align: top; padding: 2px; }
        .text-right { text-align: right; }
        
        /* Tabel Data */
        .data-table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .data-table th, .data-table td { border: 1px solid black; padding: 5px; text-align: left; }
        
        .qr-area { text-align: center; margin-top: 30px; border-top: 1px dashed #ccc; padding-top: 10px; }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body onload="window.print()">

    <div class="box">
        <div class="header">
            <h2 style="margin:0;">SURAT PERINTAH KERJA</h2>
            <p style="margin:5px;">NO. FAKTUR: <b><?= $garapan['no_faktur'] ?></b></p>
        </div>

        <table class="info-table">
            <tr>
                <td width="50%">
                    <b>Tanggal SPK:</b><br>
                    <?= date('d F Y', strtotime($garapan['tanggal_spk'])) ?>
                </td>
                <td width="50%" class="text-right">
                    <b>Penerima / Penjahit:</b><br>
                    <span style="font-size: 14px; font-weight: bold;"><?= $garapan['nama_tukang'] ?></span><br>
                    <?= $garapan['telepon'] ?><br>
                    <small><?= $garapan['alamat'] ?></small>
                </td>
            </tr>
        </table>
        
        <br>
        <b>1. BAHAN BAKU DIBAWA:</b>
        <table class="data-table">
            <thead>
                <tr style="background:#eee;"><th>Material</th><th>Detail / Warna</th><th style="text-align:center;">Qty</th></tr>
            </thead>
            <tbody>
                <?php foreach($materials as $m): ?>
                <tr>
                    <td><?= $m['nama_material'] ?></td>
                    <td><?= $m['warna'] ?></td>
                    <td style="text-align:center; font-weight:bold;"><?= $m['qty'] ?> <?= $m['satuan'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <br>
        <b>2. TARGET HASIL JAHITAN:</b>
        <table class="data-table">
            <thead>
                <tr style="background:#eee;"><th>Model Produk</th><th style="text-align:center;">Target Qty</th></tr>
            </thead>
            <tbody>
                <?php foreach($products as $p): ?>
                <tr>
                    <td>
                        <?= $p['nama_barang'] ?><br>
                        <small>Kode: <?= $p['kode_barang'] ?></small>
                    </td>
                    <td style="text-align:center; font-weight:bold; font-size:14px;"><?= $p['qty_target'] ?> PCS</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="qr-area">
            <p style="margin-bottom:5px;">Scan QR Code untuk Konfirmasi Selesai:</p>
            <div id="qrcode" style="display:inline-block;"></div>
            <br>
            <small style="letter-spacing: 2px; font-weight:bold;"><?= $garapan['no_faktur'] ?></small>
        </div>
    </div>

    <script type="text/javascript">
        new QRCode(document.getElementById("qrcode"), {
            text: "<?= $garapan['no_faktur'] ?>",
            width: 90,
            height: 90
        });
    </script>

</body>
</html>