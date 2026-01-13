<?php

// PENTING! Kita akan memanggil library Dompdf
use Dompdf\Dompdf;

class Cetak extends Controller
{

    /**
     * Halaman index (Selector)
     * Ini adalah halaman yang diakses dari menu sidebar 'Cetak Rapor'
     */
    public function index()
    {
        $data['judul'] = 'Pilih Rapor untuk Dicetak';

        // Ambil tahun ajaran aktif dari DB
        $ta_aktif = $this->model('Pengaturan_model')->getSetting('tahun_ajaran_aktif');
        $data['tahun_ajaran_aktif'] = $ta_aktif;

        // Pisahkan tahunnya untuk dropdown
        $data['tahun_mulai'] = @explode('/', $ta_aktif)[0];
        // Jika tahun mulai kosong (misal data di DB rusak), pakai tahun sekarang
        if (empty($data['tahun_mulai'])) {
            $data['tahun_mulai'] = date('Y');
        }

        $this->view('templates/header', $data);
        $this->view('cetak/index', $data);
        $this->view('templates/footer');
    }

    /**
     * Method untuk mengambil daftar siswa (via AJAX)
     * Ini dipanggil oleh JavaScript saat guru memilih Kelas, Semester, TA
     */
    public function getDaftarSiswa()
    {
        if (isset($_POST['kelas']) && isset($_POST['tahun_ajaran'])) {

            // 1. Ambil data siswa berdasarkan pencarian nama (jika ada)
            if (isset($_POST['keyword']) && $_POST['keyword'] != '') {
                $siswa = $this->model('Siswa_model')->cariDataSiswa($_POST['keyword']);
            } else {
                $siswa = $this->model('Siswa_model')->getAllSiswa();
            }

            // 2. Filter siswa yang memiliki rapor di kelas/TA/semester tersebut
            $raporModel = $this->model('Rapor_model');
            $siswa_terfilter = [];

            foreach ($siswa as $s) {
                $rapor = $raporModel->getRaporBySiswa(
                    $s['id'],
                    $_POST['semester'],
                    $_POST['tahun_ajaran']
                );

                // Jika rapor ADA DAN kelasnya cocok
                if ($rapor && $rapor['kelas'] == $_POST['kelas']) {
                    // Masukkan ID Rapor ke data siswa agar mudah dicetak
                    $s['id_rapor'] = $rapor['id'];
                    $siswa_terfilter[] = $s;
                }
            }

            // Kirim data siswa yang sudah terfilter ke view (AJAX)
            // Kita 'include' view-nya dan kirim sebagai HTML
            $data['siswa_terfilter'] = $siswa_terfilter;
            $this->view('cetak/ajax_daftar_siswa', $data); // View AJAX ini akan kita buat
        }
    }

    /**
     * Method untuk Generate PDF
     * Ini akan dipanggil oleh tombol "Cetak" di samping nama siswa
     * URL: .../cetak/generatePdf/15 (15 adalah ID Rapor)
     */
    public function generatePdf($id_rapor)
    {
        // 1. Ambil data rapor dari DB
        $data_rapor = $this->model('Rapor_model')->getRaporById($id_rapor); // Method ini harus kita buat di model!

        // 2. Jika rapor ada, ambil juga data siswanya
        if ($data_rapor) {
            $data['rapor'] = $data_rapor;
            $data['siswa'] = $this->model('Siswa_model')->getSiswaById($data_rapor['id_siswa']);
        } else {
            echo "Data rapor tidak ditemukan.";
            exit;
        }

        // ... (di dalam method generatePdf) ...

        // 3. Ambil data sekolah dari DB
        $modelPengaturan = $this->model('Pengaturan_model'); // Panggil model
        $data['sekolah'] = [
            'nama_sekolah' => $modelPengaturan->getSetting('nama_sekolah'),
            'alamat_sekolah' => $modelPengaturan->getSetting('alamat_sekolah'),
            'nama_guru_kelas' => $modelPengaturan->getSetting('nama_guru_kelas'),     // <-- BARIS BARU
            'nama_kepala_sekolah' => $modelPengaturan->getSetting('nama_kepala_sekolah') // <-- BARIS BARU
        ];

        // Data default jika setting belum ada
        if (empty($data['sekolah']['nama_sekolah'])) $data['sekolah']['nama_sekolah'] = 'TK AL - HIKMAH';
        if (empty($data['sekolah']['alamat_sekolah'])) $data['sekolah']['alamat_sekolah'] = 'PURI CEMPAKA PUTIH I, KEDUNGKANDANG, KOTA MALANG';
        if (empty($data['sekolah']['nama_guru_kelas'])) $data['sekolah']['nama_guru_kelas'] = '(Nama Guru Belum Diatur)';
        if (empty($data['sekolah']['nama_kepala_sekolah'])) $data['sekolah']['nama_kepala_sekolah'] = '(Nama Kepsek Belum Diatur)';

        // ... (sisa kode untuk memanggil Dompdf) ...

        // 4. Panggil DOMPDF
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true); // IZINKAN GAMBAR
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);

        // 5. Render HTML (dari file view) menjadi string
        // (Kita gunakan ob_start untuk "menangkap" hasil view)
        ob_start();
        $this->view('cetak/template_rapor', $data); // Ini adalah file desain rapor kita
        $html = ob_get_clean();

        $dompdf->loadHtml($html);

        // 6. Atur ukuran kertas (misal: A4)
        $dompdf->setPaper('A4', 'portrait');

        // 7. Render HTML ke PDF
        $dompdf->render();

        // 8. Kirim PDF ke browser
        // (Nama file: Rapor-Nama Siswa-Semester.pdf)
        $nama_file = 'Rapor-' . $data['siswa']['nama_lengkap'] . '-Sem' . $data['rapor']['semester'] . '.pdf';
        $dompdf->stream($nama_file, ['Attachment' => 0]); // 0 = preview, 1 = download
    }
}
