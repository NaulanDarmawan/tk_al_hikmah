<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rapor <?php echo $data['siswa']['nama_lengkap']; ?></title>
    <style>
        /* Mengatur font dasar dan halaman */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Wrapper utama untuk memberi padding */
        .wrapper {
            padding: 20px;
            width: 96%;
            margin: 0 auto;
        }

        /* --- STYLING HEADER --- */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo {
            width: 80px;
            /* Sesuaikan ukuran logo */
        }

        .school-info {
            text-align: center;
        }

        .school-info h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }

        .school-info h2 {
            margin: 0;
            font-size: 20px;
            font-weight: normal;
        }

        .school-info p {
            margin: 0;
            font-size: 12px;
        }

        /* --- STYLING INFO SISWA --- */
        .student-info-table {
            width: 100%;
            margin-top: 20px;
            font-size: 12px;
            /* Border luar yang lucu */
            border: 2px dashed #76D7C4;
            border-radius: 10px;
            padding: 10px;
        }

        .student-info-table td {
            padding: 4px 8px;
            vertical-align: top;
        }

        .student-photo {
            width: 90px;
            height: 120px;
            object-fit: cover;
            border: 3px solid #ddd;
            border-radius: 5px;
        }

        .info-label {
            width: 100px;
            /* Lebar label (cth: Nama) */
        }

        .info-separator {
            width: 10px;
            /* Lebar titik dua (:) */
        }

        /* --- STYLING KONTEN RAPOR (NARASI) --- */
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #16A085;
            /* Warna tema anak-anak */
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 2px solid #EAECEE;
            padding-bottom: 5px;
        }

        .narrative-box {
            border: 1px solid #EAECEE;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background: #FDFEFE;
            /* Efek bayangan halus */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            page-break-inside: avoid;
        }

        .narrative-title {
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            padding: 0;
            margin-bottom: 8px;
            color: #1ABC9C;
        }

        .narrative-content {
            font-size: 12px;
            line-height: 1.6;
            text-align: justify;
        }

        /* --- STYLING ABSENSI & TTD --- */
        .footer-table {
            width: 100%;
            margin-top: 25px;
            font-size: 12px;
        }

        /* Tabel Absensi */
        .absence-table {
            width: 40%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        .absence-table th,
        .absence-table td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
        }

        .absence-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        /* Tabel TTD */
        .signature-table {
            width: 100%;
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            page-break-inside: avoid;
        }

        .signature-table td {
            width: 33.3%;
            padding: 10px;
            height: 100px;
            /* Memberi ruang untuk TTD */
            vertical-align: top;
        }

        .signature-name {
            margin-top: 50px;
            /* Jarak dari TTD ke nama */
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <?php
    // Helper untuk mengubah path gambar menjadi base64
    // Ini WAJIB agar Dompdf bisa membaca gambar
    function getBase64Image($path) {
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return '';
    }

    // 1. Foto Siswa
    $pathToPhoto = 'img/' . $data['siswa']['foto'];
    if (!file_exists($pathToPhoto) || $data['siswa']['foto'] == 'default.jpg') {
        $pathToPhoto = 'img/default.jpg'; // Tampilkan default jika foto tidak ada
    }
    $imgBase64Photo = getBase64Image($pathToPhoto);

    // 2. Logo Sekolah (Asumsi Anda punya file 'logo.png' di folder 'public/img/')
    $pathToLogo = 'img/logo.png';
    $imgBase64Logo = getBase64Image($pathToLogo);
    ?>

    <div class="wrapper">

        <table class="header-table">
            <tr>
                <td style="width: 100px; text-align: center;">
                    <?php if ($imgBase64Logo): ?>
                        <img src="<?php echo $imgBase64Logo; ?>" alt="Logo Sekolah" class="logo">
                    <?php endif; ?>
                </td>
                <td class="school-info">
                    <h1>LAPORAN CAPAIAN PEMBELAJARAN</h1>
                    <h2><?php echo htmlspecialchars($data['sekolah']['nama_sekolah']); ?></h2>
                    <p>TAHUN AJARAN <?php echo htmlspecialchars($data['rapor']['tahun_ajaran']); ?></p>
                    <p style="font-size: 10px;"><?php echo htmlspecialchars($data['sekolah']['alamat_sekolah']); ?></p>
                </td>
                <td style="width: 100px;">&nbsp;</td>
            </tr>
        </table>

        <table class="student-info-table">
            <tr>
                <td style="width: 45%;">
                    <table>
                        <tr>
                            <td class="info-label">Nama Siswa</td>
                            <td class="info-separator">:</td>
                            <td><strong><?php echo htmlspecialchars($data['siswa']['nama_lengkap']); ?></strong></td>
                        </tr>
                        <tr>
                            <td class="info-label">Nama Panggilan</td>
                            <td class="info-separator">:</td>
                            <td><?php echo htmlspecialchars($data['siswa']['nama_panggilan']); ?></td>
                        </tr>
                        <tr>
                            <td class="info-label">NIS / NISN</td>
                            <td class="info-separator">:</td>
                            <td><?php echo htmlspecialchars($data['siswa']['nis']); ?> / <?php echo htmlspecialchars($data['siswa']['nisn']); ?></td>
                        </tr>
                        <tr>
                            <td class="info-label">Kelas</td>
                            <td class="info-separator">:</td>
                            <td><?php echo htmlspecialchars($data['rapor']['kelas']); ?></td>
                        </tr>
                        <tr>
                            <td class="info-label">Semester</td>
                            <td class="info-separator">:</td>
                            <td><?php echo htmlspecialchars($data['rapor']['semester']); ?></td>
                        </tr>
                    </table>
                </td>
                <td style="width: 35%;">
                    <table>
                        <tr>
                            <td class="info-label">Tinggi Badan</td>
                            <td class="info-separator">:</td>
                            <td><?php echo htmlspecialchars($data['siswa']['tinggi_badan']); ?> cm</td>
                        </tr>
                        <tr>
                            <td class="info-label">Berat Badan</td>
                            <td class="info-separator">:</td>
                            <td><?php echo htmlspecialchars($data['siswa']['berat_badan']); ?> Kg</td>
                        </tr>
                        <tr>
                            <td class="info-label">TTL</td>
                            <td class="info-separator">:</td>
                            <td><?php echo htmlspecialchars($data['siswa']['tempat_lahir']); ?>, <?php echo date('d F Y', strtotime($data['siswa']['tanggal_lahir'])); ?></td>
                        </tr>
                        <tr>
                            <td class="info-label">Jenis Kelamin</td>
                            <td class="info-separator">:</td>
                            <td><?php echo htmlspecialchars($data['siswa']['jenis_kelamin']); ?></td>
                        </tr>
                    </table>
                </td>
                <td style="width: 20%; text-align: center; vertical-align: middle;">
                    <img src="<?php echo $imgBase64Photo; ?>" alt="Foto Siswa" class="student-photo">
                </td>
            </tr>
        </table>

        <h3 class="section-title">A. CAPAIAN PEMBELAJARAN</h3>

        <div class="narrative-box">
            <h4 class="narrative-title">1. Nilai Agama dan Budi Pekerti</h4>
            <div class="narrative-content">
                <?php echo nl2br(htmlspecialchars($data['rapor']['narasi_agama'])); ?>
                <?php
                if (!empty($data['rapor']['foto_agama'])) {
                    $path = 'img/rapor/' . $data['rapor']['foto_agama'];
                    $imgData = getBase64Image($path);
                    if ($imgData) {
                        echo '<div style="text-align: center; margin-top: 10px;"><img src="' . $imgData . '" style="max-width: 100%; max-height: 200px; border-radius: 5px; border: 1px solid #ddd;"></div>';
                    }
                }
                ?>
            </div>
        </div>

        <div class="narrative-box">
            <h4 class="narrative-title">2. Jati Diri</h4>
            <div class="narrative-content">
                <?php echo nl2br(htmlspecialchars($data['rapor']['narasi_jati_diri'])); ?>
                <?php
                if (!empty($data['rapor']['foto_jati_diri'])) {
                    $path = 'img/rapor/' . $data['rapor']['foto_jati_diri'];
                    $imgData = getBase64Image($path);
                    if ($imgData) {
                        echo '<div style="text-align: center; margin-top: 10px;"><img src="' . $imgData . '" style="max-width: 100%; max-height: 200px; border-radius: 5px; border: 1px solid #ddd;"></div>';
                    }
                }
                ?>
            </div>
        </div>

        <div class="narrative-box">
            <h4 class="narrative-title">3. Dasar Literasi, Matematika, Sains, Teknologi, Rekayasa, dan Seni</h4>
            <div class="narrative-content">
                <?php echo nl2br(htmlspecialchars($data['rapor']['narasi_literasi_steam'])); ?>
                <?php
                if (!empty($data['rapor']['foto_literasi_steam'])) {
                    $path = 'img/rapor/' . $data['rapor']['foto_literasi_steam'];
                    $imgData = getBase64Image($path);
                    if ($imgData) {
                        echo '<div style="text-align: center; margin-top: 10px;"><img src="' . $imgData . '" style="max-width: 100%; max-height: 200px; border-radius: 5px; border: 1px solid #ddd;"></div>';
                    }
                }
                ?>
            </div>
        </div>

        <div class="narrative-box">
            <h4 class="narrative-title">4. Projek Penguatan Profil Pelajar Pancasila (P5) / Kokurikuler</h4>
            <div class="narrative-content">
                <?php echo nl2br(htmlspecialchars($data['rapor']['narasi_p5'])); ?>
                <?php
                if (!empty($data['rapor']['foto_p5'])) {
                    $path = 'img/rapor/' . $data['rapor']['foto_p5'];
                    $imgData = getBase64Image($path);
                    if ($imgData) {
                        echo '<div style="text-align: center; margin-top: 10px;"><img src="' . $imgData . '" style="max-width: 100%; max-height: 200px; border-radius: 5px; border: 1px solid #ddd;"></div>';
                    }
                }
                ?>
            </div>
        </div>
        <table class="footer-table">
            <tr>
                <td style="vertical-align: top;">
                    <h3 class="section-title" style="margin-top: 0;">B. KETIDAKHADIRAN</h3>
                    <table class="absence-table">
                        <thead>
                            <tr>
                                <th>Sakit</th>
                                <th>Izin</th>
                                <th>Alpha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $data['rapor']['sakit']; ?> Hari</td>
                                <td><?php echo $data['rapor']['izin']; ?> Hari</td>
                                <td><?php echo $data['rapor']['alpha']; ?> Hari</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="width: 5%;"></td>
                <td style="vertical-align: top;">
                    <h3 class="section-title" style="margin-top: 0;">C. REFLEKSI ORANG TUA</h3>
                    <div class="narrative-box" style=" min-height: 100px;">
                        <div class="narrative-content">
                            <?php echo nl2br(htmlspecialchars($data['rapor']['refleksi_ortu'])); ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>


        <table class="signature-table">
            <tr>
                <td>
                    Mengetahui,<br>Orang Tua / Wali
                    <br><br><br><br>
                    <div class="signature-name">
                        (..............................)
                    </div>
                </td>
                <td>
                </td>
                <td>
                    Malang, <?php echo date('d F Y'); ?>
                    <br>Guru Kelas
                    <br><br><br><br>
                    <div class="signature-name">
                        <?php echo htmlspecialchars($data['rapor']['nama_wali_kelas']); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center; height: auto;">
                    Mengetahui,<br>Kepala <?php echo htmlspecialchars($data['sekolah']['nama_sekolah']); ?>
                    <br><br><br><br>
                    <div class="signature-name">
                        <?php echo htmlspecialchars($data['sekolah']['nama_kepala_sekolah']); ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>