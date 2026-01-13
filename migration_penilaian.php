<?php

// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'tk_al_hikmah_db');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Terhubung ke database.\n";

    // 1. Buat Tabel Indikator
    $sqlIndikator = "CREATE TABLE IF NOT EXISTS indikator (
        id INT AUTO_INCREMENT PRIMARY KEY,
        kelompok ENUM('A', 'B') NOT NULL,
        kategori ENUM('AGAMA', 'JATI_DIRI', 'STEAM') NOT NULL,
        sub_elemen TEXT NOT NULL,
        deskripsi TEXT NOT NULL
    ) ENGINE=InnoDB;";
    
    $pdo->exec($sqlIndikator);
    echo "Tabel 'indikator' berhasil dibuat/diperiksa.\n";

    // 2. Buat Tabel Penilaian
    $sqlPenilaian = "CREATE TABLE IF NOT EXISTS penilaian (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_siswa INT NOT NULL,
        id_indikator INT NOT NULL,
        tanggal DATE NOT NULL,
        nilai ENUM('BB', 'MB', 'BSH', 'BSB') NOT NULL,
        foto VARCHAR(255) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_indikator) REFERENCES indikator(id) ON DELETE CASCADE,
        FOREIGN KEY (id_siswa) REFERENCES siswa(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;";

    $pdo->exec($sqlPenilaian);
    echo "Tabel 'penilaian' berhasil dibuat/diperiksa.\n";

    // 3. Kosongkan Tabel Indikator (Reset Data Master)
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    $pdo->exec("TRUNCATE TABLE indikator");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    echo "Tabel 'indikator' dikosongkan untuk seeding ulang.\n";

    // 4. Data Indikator (Dari Controller)
    $indikator_tka = [
        'AGAMA' => [
            '1) Murid percaya kepada Tuhan Yang Maha Esa sebagai pencipta dirinya, makhluk lain dan alam, serta mulai mengenal dan mempraktikkan ajaran pokok sesuai dengan agama dan kepercayaannya' => [
                'Menyebutkan contoh ciptaan Tuhan (seperti manusia, hewan, tumbuhan)',
                'Mengucapkan doa sebelum dan sesudah melakukan kegiatan dengan bimbingan',
                'Menirukan gerakan ibadah sederhana sesuai agamanya',
                'Menyebutkan hari-hari besar agama yang dianutnya'
            ],
            '2) Murid menghargai diri sendiri dan memiliki rasa syukur terhadap Tuhan YME sehingga dapat berpartisipasi aktif dalam menjaga kebersihan, kesehatan, dan keselamatan dirinya' => [
                'Mencuci tangan sebelum dan sesudah makan dengan bimbingan',
                'Membuang sampah pada tempatnya dengan bimbingan',
                'Mengenali benda-benda yang berbahaya dengan bimbingan',
                'Menyebutkan makanan yang sehat dan tidak sehat'
            ],
            '3) Murid menghargai sesama manusia dengan berbagai perbedaannya sehingga mempraktikkan perilaku baik dan berakhlak mulia' => [
                'Mengucapkan terima kasih setelah menerima sesuatu dengan bimbingan',
                'Meminta maaf jika melakukan kesalahan dengan bimbingan',
                'Menyebutkan nama dan jenis kelamin teman-temannya',
                'Bermain bersama teman tanpa membedakan jenis kelamin'
            ],
            '4) Murid menghargai alam dan seluruh makhluk hidup ciptaan Tuhan Yang Maha Esa' => [
                'Menyiram tanaman dengan bimbingan',
                'Membuang sampah pada tempatnya saat di alam terbuka',
                'Memberi makan hewan peliharaan dengan bimbingan',
                'Menyebutkan nama-nama hewan dan tumbuhan di sekitarnya'
            ]
        ],
        'JATI_DIRI' => [
            '1) Murid mengenali identitas dirinya yang terbentuk oleh karakteristik fisik dan gender, minat, kebutuhan, agama, dan sosial budaya' => [
                'Memilih satu jenis dari 2-3 pilihan yang tersedia (misalnya: mainan, makanan, pakaian)',
                'Memilih satu dari berbagai kegiatan atau benda yang disediakan',
                'Menyebut nama anggota keluarga lain, teman, dan jenis kelamin mereka',
                'Mulai melafalkan doa-doa pendek dan melakukan ibadah sesuai dengan agamanya'
            ],
            '2) Murid mengenali kebiasaan-kebiasaan di lingkungan keluarga, satuan pendidikan, dan masyarakat' => [
                'Bersikap sopan dan peduli melalui kata-kata dan perbuatan dengan bimbingan (misalnya: mengucapkan maaf, permisi, terima kasih)',
                'Mulai menunjukkan keinginan untuk menolong orang tua, pendidik, dan teman',
                'Menyebutkan tempat di lingkungan sekitarnya',
                'Mengikuti aturan'
            ],
            '3) Murid mengenali, mengekspresikan, dan mengelola emosi diri, serta membangun hubungan sosial secara sehat' => [
                'Menjalin pertemanan dengan anak lain',
                'Menggunakan kalimat pendek untuk berinteraksi dengan anak atau orang dewasa untuk menyatakan apa yang dilihat dan dirasa',
                'Berbicara sesuai dengan kebutuhan (kapan harus bertanya atau berpendapat)',
                'Mempertahankan haknya dengan mencari bantuan dari orang lain, misalnya meminta bantuan kepada orang dewasa'
            ],
            '4) Murid mengenali perannya sebagai bagian dari keluarga, satuan pendidikan, masyarakat dan warga negara Indonesia sehingga dapat menyesuaikan diri dengan lingkungan, aturan dan norma yang berlaku, dan mengetahui keberadaan negara lain di dunia' => [
                'Bersikap sopan dan peduli melalui kata-kata dan perbuatan dengan bimbingan',
                'Mulai menunjukkan keinginan untuk menolong orang tua, pendidik, dan teman',
                'Menyebutkan tempat di lingkungan sekitarnya',
                'Mengikuti aturan',
                'Menyebutkan nama anggota keluarga dan jenis kelamin mereka'
            ],
            '5) Murid memiliki fungsi gerak (motorik kasar, halus, dan taktil) untuk merawat dirinya, membangun kemandirian dan berkegiatan' => [
                'Melakukan berbagai kegiatan motorik kasar dan halus dengan keseimbangan, kontrol, dan kelincahan',
                'Melakukan kegiatan yang menunjukkan kemampuan bergelayutan atau berkibar',
                'Melakukan kegiatan yang menunjukkan kemampuan melompat, meloncat, dan berlari secara terkoordinasi',
                'Melakukan kegiatan yang menunjukkan kemampuan menggunakan anggota tubuh untuk gerakan halus yang terkontrol (misalnya, meronce)'
            ]
        ],
        'STEAM' => [
            '1) Murid mengenali dan memahami berbagai informasi, mengomunikasikan perasaan dan pikiran secara lisan, tulisan, atau menggunakan berbagai media serta membangun percakapan, menunjukkan minat, dan berpartisipasi dalam kegiatan pramembaca' => [
                'Menceritakan kembali apa yang didengar dengan kosakata yang terbatas',
                'Melaksanakan perintah sederhana sesuai dengan aturan yang diberikan',
                'Menggunakan kalimat pendek untuk berinteraksi dengan anak atau orang dewasa',
                'Berbicara sesuai dengan kebutuhan (kapan harus bertanya atau berpendapat)',
                'Menceritakan kembali isi cerita secara sederhana',
                'Menulis huruf-huruf dengan meniru contoh',
                'Menceritakan isi buku meskipun tidak sesuai dengan tulisan'
            ],
            '2) Murid memiliki kepekaan bilangan; mengidentifikasi pola; memiliki kesadaran tentang bentuk, posisi, dan ruang; menyadari adanya persamaan dan perbedaan karakteristik antar objek; mampu melakukan pengukuran dengan satuan tidak baku; dan memiliki kesadaran mengenai waktu' => [
                'Menghubungkan benda-benda konkret dengan lambang bilangan 1-10',
                'Melaksanakan kegiatan yang menunjukkan kemampuan mengenal benda dengan mengelompokkan berbagai benda berdasarkan ukuran (misalnya: besar-kecil, panjang-pendek, tebal-tipis, berat-ringan)',
                'Melaksanakan kegiatan yang menunjukkan kemampuan memasangkan benda dengan pasangannya',
                'Melaksanakan kegiatan yang menunjukkan kemampuan mengurutkan benda berdasarkan ukuran dari yang terpendek hingga yang terpanjang, terkecil hingga terbesar',
                'Melaksanakan kegiatan yang menunjukkan kemampuan mengenal benda berdasarkan bentuk, ukuran, dan warna melalui kegiatan mengelompokkan'
            ],
            '3) Murid mampu mengamati, menyebutkan alasan, pilihan atau keputusannya, mampu memecahkan masalah sederhana, serta mengetahui hubungan sebab akibat dari suatu kondisi atau situasi yang dipengaruhi oleh hukum alam dan kondisi sosial' => [
                'Mampu menyelesaikan masalah sederhana dengan bantuan orang dewasa',
                'Melanjutkan kegiatan hingga selesai',
                'Memilih satu jenis dari 2-3 pilihan yang tersedia',
                'Memilih satu dari berbagai kegiatan atau benda yang disediakan',
                'Menyebutkan nama dan kegunaan benda-benda alam',
                'Mengungkapkan hasil karya yang dibuat secara sederhana dan berhubungan dengan lingkungan alam',
                'Menunjukkan proses perkembangbiakan makhluk hidup (misal: kupu-kupu, ayam, katak)'
            ],
            '4) Murid menunjukkan kemampuan awal menggunakan dan merekayasa teknologi serta untuk mencari informasi, gagasan, dan keterampilan secara aman dan bertanggung jawab' => [
                'Menggunakan benda-benda teknologi sederhana (misal: gunting, sekop, palu, cangkul, pisau, gunting kuku, sikat gigi, sendok, pembuka tutup botol, spons, roda pada kendaraan)',
                'Mengenali bahan pembuatan teknologi sederhana',
                'Menggunakan alat teknologi sederhana sesuai fungsinya secara aman dan bertanggung jawab'
            ],
            '5) Murid mengeksplorasi berbagai proses seni, mengekspresikannya, serta mengapresiasi karya seni' => [
                'Mengapresiasi penampilan karya seni anak lain dengan bimbingan, seperti bertepuk tangan dan memuji',
                'Menampilkan karya seni sederhana di hadapan anak-anak atau orang lain',
                'Mengungkapkan hasil karya yang dibuat secara sederhana dan berhubungan dengan lingkungan alam',
                'Menunjukkan minat terhadap aktivitas seni (seperti menyanyi, menari, atau menggambar)'
            ]
        ]
    ];

    $indikator_tkb = [
        'AGAMA' => [
            '1) Murid percaya kepada Tuhan Yang Maha Esa sebagai pencipta dirinya, makhluk lain dan alam, serta mulai mengenal dan mempraktikkan ajaran pokok sesuai dengan agama dan kepercayaannya' => [
                'Menceritakan contoh-contoh ciptaan Tuhan dan kegunaannya',
                'Mengucapkan doa-doa pendek sesuai dengan agamanya',
                'Melakukan ibadah sesuai aturan menurut keyakinannya dengan bimbingan',
                'Menyebutkan tempat ibadah dan hari besar agama lain'
            ],
            '2) Murid menghargai diri sendiri dan memiliki rasa syukur terhadap Tuhan YME sehingga dapat berpartisipasi aktif dalam menjaga kebersihan, kesehatan, dan keselamatan dirinya' => [
                'Melakukan kebiasaan hidup bersih dan sehat secara mandiri (seperti mandi, gosok gigi, mencuci tangan)',
                'Memilih makanan dan minuman yang bersih, sehat, dan bergizi',
                'Mengenali dan menghindari benda-benda yang berbahaya',
                'Menggunakan toilet secara mandiri'
            ],
            '3) Murid menghargai sesama manusia dengan berbagai perbedaannya sehingga mempraktikkan perilaku baik dan berakhlak mulia' => [
                'Mengucapkan terima kasih setelah menerima sesuatu secara spontan',
                'Meminta maaf jika melakukan kesalahan secara spontan',
                'Menyebutkan perbedaan karakteristik teman seperti warna kulit, jenis rambut',
                'Menunjukkan sikap toleran terhadap perbedaan teman (agama, suku, budaya)'
            ],
            '4) Murid menghargai alam dan seluruh makhluk hidup ciptaan Tuhan Yang Maha Esa' => [
                'Merawat tanaman di sekitar sekolah atau rumah',
                'Memilah sampah organik dan anorganik',
                'Menceritakan cara merawat hewan peliharaan',
                'Menjelaskan pentingnya menjaga kelestarian hewan dan tumbuhan'
            ]
        ],
        'JATI_DIRI' => [
            '1) Murid mengenali identitas dirinya yang terbentuk oleh karakteristik fisik dan gender, minat, kebutuhan, agama, dan sosial budaya' => [
                'Memilih satu jenis dari 3 atau lebih pilihan yang tersedia',
                'Memilih kegiatan atau benda yang paling sesuai dengan kebutuhan dari beberapa pilihan yang ada',
                'Mengucapkan doa-doa pendek dan menjalankan ibadah sesuai agamanya (contoh: doa sebelum dan sesudah kegiatan)',
                'Menyebutkan hari-hari besar agama dan tempat ibadah agama lain'
            ],
            '2) Murid mengenali kebiasaan-kebiasaan di lingkungan keluarga, satuan pendidikan, dan masyarakat' => [
                'Secara spontan menunjukkan perilaku sopan dan peduli melalui kata-kata dan perbuatan (misalnya: mengucapkan maaf, permisi, terima kasih)',
                'Memiliki keinginan untuk menolong orang tua, pendidik, dan teman',
                'Menyebutkan nama anggota keluarga dan teman serta ciri-ciri khusus mereka seperti warna kulit, warna rambut, jenis rambut, dan lainnya',
                'Membuat dan mengikuti aturan'
            ],
            '3) Murid mengenali, mengekspresikan, dan mengelola emosi diri, serta membangun hubungan sosial secara sehat' => [
                'Mengungkapkan keinginan, perasaan, dan pendapat dengan kalimat sederhana dalam berkomunikasi dengan anak atau orang dewasa',
                'Beradaptasi dengan wajar dalam situasi baru',
                'Mempertahankan hak-haknya untuk melindungi diri sendiri',
                'Mengungkapkan perasaan dan ide dengan pilihan kata yang sesuai saat berkomunikasi'
            ],
            '4) Murid mengenali perannya sebagai bagian dari keluarga, satuan pendidikan, masyarakat dan warga negara Indonesia sehingga dapat menyesuaikan diri dengan lingkungan, aturan dan norma yang berlaku, dan mengetahui keberadaan negara lain di dunia' => [
                'Secara spontan menunjukkan perilaku sopan dan peduli',
                'Memiliki keinginan untuk menolong orang tua, pendidik, dan teman',
                'Menyebutkan nama anggota keluarga dan teman serta ciri-ciri khusus mereka',
                'Membuat dan mengikuti aturan',
                'Menunjukkan sikap toleran terhadap perbedaan (agama, suku, budaya)'
            ],
            '5) Murid memiliki fungsi gerak (motorik kasar, halus, dan taktil) untuk merawat dirinya, membangun kemandirian dan berkegiatan' => [
                'Melakukan berbagai gerakan terkoordinasi dengan kontrol, keseimbangan, dan kelincahan',
                'Melakukan kegiatan yang menunjukkan kemampuan menggerakkan mata, tangan, kaki, dan kepala secara terkoordinasi dalam menirukan gerakan teratur (misalnya, senam dan tarian)',
                'Melakukan kegiatan yang menunjukkan kemampuan bermain fisik dengan aturan',
                'Melakukan kegiatan yang menunjukkan keterampilan menggunakan tangan kanan dan kiri dalam berbagai aktivitas (misalnya, mengancingkan baju, mengikat tali sepatu, menggambar, menempel, memotong, makan)'
            ]
        ],
        'STEAM' => [
            '1) Murid mengenali dan memahami berbagai informasi, mengomunikasikan perasaan dan pikiran secara lisan, tulisan, atau menggunakan berbagai media serta membangun percakapan, menunjukkan minat, dan berpartisipasi dalam kegiatan pramembaca' => [
                'Menceritakan kembali apa yang didengar dengan kosakata yang lebih kaya',
                'Melaksanakan perintah yang lebih kompleks sesuai dengan aturan yang diberikan',
                'Mengungkapkan keinginan, perasaan, dan pendapat dengan kalimat sederhana dalam berkomunikasi',
                'Menunjukkan bentuk-bentuk simbol',
                'Membuat gambar dengan beberapa coretan/tulisan yang sudah berbentuk huruf/kata',
                'Menulis huruf-huruf dari namanya sendiri',
                'Menunjukkan minat membaca buku-buku yang dikenali'
            ],
            '2) Murid memiliki kepekaan bilangan; mengidentifikasi pola; memiliki kesadaran tentang bentuk, posisi, dan ruang; menyadari adanya persamaan dan perbedaan karakteristik antar objek; mampu melakukan pengukuran dengan satuan tidak baku; dan memiliki kesadaran mengenai waktu' => [
                'Melaksanakan kegiatan yang menunjukkan kemampuan mengenal benda dengan mengelompokkan berbagai benda di lingkungannya berdasarkan ukuran, pola, fungsi, sifat, suara, tekstur, fungsi, dan ciri-ciri lainnya',
                'Melaksanakan kegiatan yang menunjukkan kemampuan mengenal benda dengan menghubungkan satu benda dengan benda lainnya',
                'Melaksanakan kegiatan yang menunjukkan kemampuan mengenal benda dengan menghubungkan nama benda dengan tulisan sederhana melalui berbagai aktivitas',
                'Melaksanakan kegiatan yang menunjukkan kemampuan mengenal benda berdasarkan lima seriasi atau lebih, bentuk, ukuran, warna, atau jumlah melalui kegiatan mengurutkan benda'
            ],
            '3) Murid mampu mengamati, menyebutkan alasan, pilihan atau keputusannya, mampu memecahkan masalah sederhana, serta mengetahui hubungan sebab akibat dari suatu kondisi atau situasi yang dipengaruhi oleh hukum alam dan kondisi sosial' => [
                'Mampu menyelesaikan sendiri masalah sederhana yang dihadapi',
                'Menyelesaikan tugas meskipun menghadapi kesulitan',
                'Memilih satu jenis dari 3 atau lebih pilihan yang tersedia',
                'Memilih kegiatan atau benda yang paling sesuai dengan kebutuhan dari beberapa pilihan yang ada',
                'Menceritakan peristiwa alam melalui percobaan sederhana',
                'Mengungkapkan hasil karya yang dibuat secara lengkap dan berhubungan dengan lingkungan alam',
                'Menceritakan proses perkembangbiakan makhluk hidup',
                'Menjelaskan lingkungan sekitarnya secara sederhana'
            ],
            '4) Murid menunjukkan kemampuan awal menggunakan dan merekayasa teknologi serta untuk mencari informasi, gagasan, dan keterampilan secara aman dan bertanggung jawab' => [
                'Melakukan kegiatan dengan menggunakan alat teknologi sederhana sesuai fungsinya secara aman dan bertanggung jawab',
                'Membuat alat teknologi sederhana (misal: baling-baling, pesawat mainan, kereta mainan, mobil-mobilan, telepon mainan dengan benang)',
                'Melakukan proses kerja sesuai prosedur (misal: membuat wedang jahe dimulai dari menyediakan air panas, jahe, gula, dan gelas)',
                'Menggunakan teknologi sederhana untuk mencari informasi dengan bimbingan orang dewasa'
            ],
            '5) Murid mengeksplorasi berbagai proses seni, mengekspresikannya, serta mengapresiasi karya seni' => [
                'Mengapresiasi penampilan karya seni anak lain, misalnya dengan bertepuk tangan dan memuji',
                'Membuat karya seni sesuai kreativitasnya, baik itu seni musik, visual, gerak, dan tari yang dibuatnya maupun yang dibuat oleh orang lain',
                'Mengungkapkan perasaan dan ide dengan pilihan kata yang sesuai saat berkomunikasi',
                'Menampilkan karya seni dengan menggabungkan berbagai media (misalnya menggambar dan bercerita, atau menari dan bernyanyi)'
            ]
        ]
    ];

    // 5. Insert Data
    $stmt = $pdo->prepare("INSERT INTO indikator (kelompok, kategori, sub_elemen, deskripsi) VALUES (:kelompok, :kategori, :sub_elemen, :deskripsi)");

    // Insert TKA
    foreach ($indikator_tka as $kategori => $sub_elemen_list) {
        foreach ($sub_elemen_list as $sub_elemen => $indikator_list) {
            foreach ($indikator_list as $deskripsi) {
                $stmt->execute([
                    ':kelompok' => 'A',
                    ':kategori' => $kategori,
                    ':sub_elemen' => $sub_elemen,
                    ':deskripsi' => $deskripsi
                ]);
            }
        }
    }

    // Insert TKB
    foreach ($indikator_tkb as $kategori => $sub_elemen_list) {
        foreach ($sub_elemen_list as $sub_elemen => $indikator_list) {
            foreach ($indikator_list as $deskripsi) {
                $stmt->execute([
                    ':kelompok' => 'B',
                    ':kategori' => $kategori,
                    ':sub_elemen' => $sub_elemen,
                    ':deskripsi' => $deskripsi
                ]);
            }
        }
    }

    echo "Data indikator berhasil di-seed.\n";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
