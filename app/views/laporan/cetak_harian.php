<!DOCTYPE html>
<html>
<head>
    <title>Jurnal Harian - <?= $data['siswa']['nama_lengkap']; ?></title>
    <style>
        body { font-family: 'Arial', sans-serif; color: #333; margin: 0; padding: 0; }
        .container { padding: 20px; }
        .header { text-align: center; border-bottom: 3px solid #17a2b8; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 20px; font-weight: bold; color: #17a2b8; margin: 0; }
        .subtitle { font-size: 14px; color: #666; }

        .info-table { width: 100%; margin-bottom: 30px; font-size: 13px; }
        .info-table td { padding: 3px 0; }

        .jurnal-item { margin-bottom: 25px; border: 1px solid #dee2e6; border-radius: 10px; padding: 15px; page-break-inside: avoid; }
        .date-header { display: block; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px; }
        .tgl { font-weight: bold; color: #17a2b8; font-size: 14px; }

        .badge { padding: 5px 10px; border-radius: 5px; font-weight: bold; font-size: 12px; float: right; }
        .bb { background: #f8d7da; color: #721c24; }
        .mb { background: #fff3cd; color: #856404; }
        .bsh { background: #d4edda; color: #155724; }
        .bsb { background: #d1ecf1; color: #0c5460; }

        .kategori-label { font-size: 11px; color: #999; text-transform: uppercase; display: block; }
        .deskripsi { font-size: 15px; font-weight: bold; color: #2d3748; margin: 5px 0; display: block; }

        .foto-box { margin-top: 15px; text-align: center; }
        .foto-img { max-width: 300px; max-height: 200px; border-radius: 8px; border: 4px solid #f8fafc; }

        .footer-note { text-align: center; font-size: 10px; color: #aaa; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">JURNAL HARIAN PERKEMBANGAN ANAK</h1>
            <div class="subtitle">TK AL HIKMAH MALANG</div>
        </div>

        <table class="info-table">
            <tr>
                <td width="15%">Nama Lengkap</td><td width="35%">: <strong><?= $data['siswa']['nama_lengkap']; ?></strong></td>
                <td width="15%">Periode</td><td width="35%">: <?= date('d/m/Y', strtotime($data['range']['mulai'])); ?> - <?= date('d/m/Y', strtotime($data['range']['selesai'])); ?></td>
            </tr>
            <tr>
                <td>NIS</td><td>: <?= $data['siswa']['nis']; ?></td>
                <td>Kelompok</td><td>: <?= $_POST['kelompok']; ?></td>
            </tr>
        </table>

        <?php if(empty($data['jurnal'])) : ?>
            <div style="text-align: center; padding: 50px; border: 2px dashed #ccc; color: #999;">
                Belum ada data penilaian pada rentang tanggal ini.
            </div>
        <?php else : ?>
            <?php foreach($data['jurnal'] as $j) : ?>
            <div class="jurnal-item">
                <div class="date-header">
                    <span class="tgl"><?= date('l, d F Y', strtotime($j['tanggal'])); ?></span>
                    <span class="badge <?= strtolower($j['nilai']); ?>"><?= $j['nilai']; ?></span>
                </div>

                <span class="kategori-label"><?= $j['kategori']; ?> | <?= $j['sub_elemen']; ?></span>
                <span class="deskripsi"><?= $j['deskripsi']; ?></span>

                <?php if($j['foto']) : ?>
                <div class="foto-box">
                    <img src="<?= $_SERVER['DOCUMENT_ROOT'] . '/sistem_rapor/public/img/penilaian/' . $j['foto']; ?>" class="foto-img">
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="footer-note">
            Dokumen ini digenerate secara otomatis oleh Sistem Rapor Digital - <?= date('d/m/Y H:i'); ?>
        </div>
    </div>
</body>
</html>