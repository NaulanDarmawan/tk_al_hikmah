<!DOCTYPE html>
<html>
<head>
    <title>Jurnal Harian - <?= $data['siswa']['nama_lengkap']; ?></title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; margin: 0; padding: 20px; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #17a2b8; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; color: #17a2b8; margin: 0; text-transform: uppercase; }
        .subtitle { font-size: 13px; color: #666; margin-top: 5px; }

        .info-table { width: 100%; margin-bottom: 20px; font-size: 12px; }
        .info-table td { padding: 4px 0; }

        /* Compact Layout Styles */
        .jurnal-item { 
            margin-bottom: 10px; 
            border: 1px solid #e2e8f0; 
            border-radius: 8px; 
            padding: 10px; 
            page-break-inside: avoid; 
            background: #fff;
        }

        .table-layout { width: 100%; border-collapse: collapse; }
        .td-text { vertical-align: top; padding-right: 15px; }
        .td-photo { width: 180px; vertical-align: top; text-align: right; }

        .date-badge { 
            display: inline-block;
            background: #e2e8f0; 
            color: #4a5568; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-weight: bold; 
            font-size: 11px;
            margin-bottom: 5px;
        }
        
        .score-badge { 
             padding: 4px 8px; 
             border-radius: 4px; 
             font-weight: bold; 
             font-size: 11px; 
             display: inline-block;
             margin-left: 5px;
        }
        .bb { background: #fee2e2; color: #991b1b; }
        .mb { background: #fef9c3; color: #854d0e; }
        .bsh { background: #dcfce7; color: #166534; }
        .bsb { background: #e0f2fe; color: #075985; }

        .meta-text { font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-top: 5px;}
        .deskripsi { font-size: 13px; font-weight: bold; color: #1e293b; line-height: 1.4; display: block; margin-top: 5px; }

        .foto-img { 
            width: 100%; 
            max-width: 180px; 
            max-height: 120px; 
            border-radius: 6px; 
            border: 2px solid #f1f5f9; 
            object-fit: contain; /* Dompdf doesn't fully support object-fit but helps in other viewers */
        }
        
        .chart-container { margin-bottom: 20px; text-align: center; border: 1px solid #e2e8f0; padding: 10px; border-radius: 8px; }

        .footer-note { text-align: center; font-size: 9px; color: #cbd5e1; margin-top: 20px; border-top: 1px solid #f1f5f9; padding-top: 10px; }
    </style>
</head>
<body>
        <div class="header">
            <h1 class="title">Jurnal Harian Perkembangan Anak</h1>
            <div class="subtitle">TK AL HIKMAH MALANG</div>
        </div>

        <table class="info-table">
            <tr>
                <td width="15%"><strong>Nama Lengkap</strong></td><td width="35%">: <?= $data['siswa']['nama_lengkap']; ?></td>
                <td width="15%"><strong>Periode</strong></td><td width="35%">: <?= date('d/m/Y', strtotime($data['range']['mulai'])); ?> - <?= date('d/m/Y', strtotime($data['range']['selesai'])); ?></td>
            </tr>
            <tr>
                <td><strong>NIS</strong></td><td>: <?= $data['siswa']['nis']; ?></td>
                <td><strong>Kelompok</strong></td><td>: <?= $_POST['kelompok']; ?></td>
            </tr>
        </table>

        <?php if(empty($data['jurnal'])) : ?>
            <div style="text-align: center; padding: 40px; border: 2px dashed #cbd5e1; color: #94a3b8; font-style: italic;">
                -- Belum ada data penilaian pada rentang tanggal ini --
            </div>
        <?php else : ?>
            
            <?php if(!empty($data['chartUrl'])): ?>
            <div class="chart-container">
                <img src="<?= $data['chartUrl']; ?>" style="max-height: 250px; width: auto; max-width: 100%;">
            </div>
            <?php endif; ?>

            <?php foreach($data['jurnal'] as $j) : ?>
            <div class="jurnal-item">
                <table class="table-layout">
                    <tr>
                        <td class="td-text">
                            <div>
                                <span class="date-badge"><?= date('d F Y', strtotime($j['tanggal'])); ?></span>
                                <span class="score-badge <?= strtolower($j['nilai']); ?>"><?= $j['nilai']; ?></span>
                            </div>
                            <!-- Meta Info Separated -->
                            <span class="meta-text"><?= $j['kategori']; ?> &bull; <?= $j['sub_elemen']; ?></span>
                            
                            <!-- Main Description -->
                            <span class="deskripsi"><?= $j['deskripsi']; ?></span>
                        </td>
                        
                        <?php if($j['foto']) : 
                            $path = $_SERVER['DOCUMENT_ROOT'] . '/sistem_rapor/public/img/penilaian/' . $j['foto'];
                            if(file_exists($path)):
                        ?>
                        <td class="td-photo">
                            <img src="<?= $path; ?>" class="foto-img">
                        </td>
                        <?php endif; endif; ?>
                    </tr>
                </table>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="footer-note">
            Digenerate secara otomatis oleh Sistem Rapor Digital | Tanggal Cetak: <?= date('d F Y H:i'); ?>
        </div>
</body>
</html>