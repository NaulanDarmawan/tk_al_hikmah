<?php

class Rapor extends Controller
{

    /**
     * Halaman Daftar Siswa (Titik Awal)
     * Kembali ke daftar sederhana (1 tombol per siswa)
     */
    public function index()
    {
        $data['judul'] = 'Input Rapor Siswa';

        // --- LOGIKA SEARCH BARU ---
        // Cek apakah ada keyword pencarian
        if (isset($_POST['keyword'])) {
            $data['siswa'] = $this->model('Siswa_model')->cariDataSiswa($_POST['keyword']);
            $data['keyword'] = $_POST['keyword'];
        } else {
            // Jika tidak ada, tampilkan semua
            $data['siswa'] = $this->model('Siswa_model')->getAllSiswa();
            $data['keyword'] = '';
        }
        // --- AKHIR LOGIKA SEARCH ---

        // Ambil Konteks Terakhir (untuk mengisi Tahun Ajaran)
        $konteks = $_SESSION['konteks_rapor_terakhir'] ?? null;
        if ($konteks) {
            $data['tahun_ajaran'] = $konteks['tahun_ajaran'];
            $data['tahun_ajaran_url'] = str_replace('/', '-', $konteks['tahun_ajaran']);
        } else {
            $ta_aktif = $this->model('Pengaturan_model')->getSetting('tahun_ajaran_aktif');
            $data['tahun_ajaran'] = $ta_aktif;
            $data['tahun_ajaran_url'] = str_replace('/', '-', $ta_aktif);
        }

        // CEK STATUS Rapor (kita hanya perlu cek untuk siswa yang tampil)
        $raporModel = $this->model('Rapor_model');
        $status_rapor_sem1 = [];
        $status_rapor_sem2 = [];

        foreach ($data['siswa'] as $siswa) { // Loop ini sekarang lebih efisien
            $rapor_sem1 = $raporModel->getRaporBySiswa($siswa['id'], 'I', $data['tahun_ajaran']);
            $status_rapor_sem1[$siswa['id']] = ($rapor_sem1) ? true : false;

            $rapor_sem2 = $raporModel->getRaporBySiswa($siswa['id'], 'II', $data['tahun_ajaran']);
            $status_rapor_sem2[$siswa['id']] = ($rapor_sem2) ? true : false;
        }
        $data['status_sem1'] = $status_rapor_sem1;
        $data['status_sem2'] = $status_rapor_sem2;

        $this->view('templates/header', $data);
        $this->view('rapor/index', $data);
        $this->view('templates/footer');
    }

    /**
     * Halaman Form Input Rapor (Sekarang Cerdas)
     * INI ADALAH PERBAIKANNYA
     * Parameter ke-2 dan ke-3 sekarang OPSIONAL (ditandai dengan = null)
     */
    public function input($id_siswa, $semester = null, $tahun_ajaran_url = null)
    {
        $data['judul'] = 'Form Input Rapor';
        $data['siswa'] = $this->model('Siswa_model')->getSiswaById($id_siswa);
        $raporModel = $this->model('Rapor_model');

        // Ambil nama guru default DARI PENGATURAN
        $nama_guru_default = $this->model('Pengaturan_model')->getSetting('nama_guru_kelas');

        // --- LOGIKA KONTEKS DINAMIS ---
        if ($semester && $tahun_ajaran_url) {
            // JIKA URL LENGKAP
            $data['semester'] = $semester;
            $data['tahun_ajaran_full'] = str_replace('-', '/', $tahun_ajaran_url);
            // Ambil 'kelas' & 'guru' dari session agar tetap sticky
            $data['kelas'] = $_SESSION['konteks_rapor_terakhir']['kelas'] ?? 'TK-A';
            $data['nama_wali_kelas'] = $_SESSION['konteks_rapor_terakhir']['nama_wali_kelas'] ?? $nama_guru_default;
        } else {
            // JIKA URL SINGKAT
            $konteks = $_SESSION['konteks_rapor_terakhir'] ?? null;
            if ($konteks) {
                // Jika ADA, gunakan konteks terakhir
                $data['kelas'] = $konteks['kelas'];
                $data['semester'] = $konteks['semester'];
                $data['tahun_ajaran_full'] = $konteks['tahun_ajaran'];
                $data['nama_wali_kelas'] = $konteks['nama_wali_kelas'] ?? $nama_guru_default;
            } else {
                // Jika TIDAK ADA, buat data default
                $data['kelas'] = 'TK-A';
                $data['semester'] = 'I';
                $data['tahun_ajaran_full'] = $this->model('Pengaturan_model')->getSetting('tahun_ajaran_aktif');
                $data['nama_wali_kelas'] = $nama_guru_default;
            }
        }

        $data['tahun_mulai'] = @explode('/', $data['tahun_ajaran_full'])[0];

        // Cari rapor di DB
        $data['rapor'] = $raporModel->getRaporBySiswa(
            $id_siswa,
            $data['semester'],
            $data['tahun_ajaran_full']
        );

        // Jika rapor tidak ketemu, siapkan data default
        if ($data['rapor'] == false) {
            $data['rapor'] = [
                'id' => null,
                'kelas' => $data['kelas'],
                'nama_wali_kelas' => $data['nama_wali_kelas'], // <-- BARU: Masukkan nama wali
                'sakit' => 0,
                'izin' => 0,
                'alpha' => 0,
                'narasi_agama' => '',
                'narasi_jati_diri' => '',
                'narasi_literasi_steam' => '',
                'narasi_p5' => '',
                'refleksi_ortu' => ''
            ];
        } else {
            // Jika rapor KETEMU, gunakan data dari DB
            $data['kelas'] = $data['rapor']['kelas'];
            $data['nama_wali_kelas'] = $data['rapor']['nama_wali_kelas']; // <-- BARU: Ambil dari DB
        }

        // Simpan konteks ini ke session agar "sticky"
        $_SESSION['konteks_rapor_terakhir'] = [
            'kelas'         => $data['kelas'],
            'semester'      => $data['semester'],
            'tahun_ajaran'  => $data['tahun_ajaran_full'],
            'nama_wali_kelas' => $data['nama_wali_kelas'] // <-- BARU: Simpan guru ke session
        ];

        $this->view('templates/header', $data);
        $this->view('rapor/form', $data);
        $this->view('templates/footer');
    }

    /**
     * Method Simpan
     */
    public function simpan()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $raporModel = $this->model('Rapor_model');
            $data_form = $_POST; // $_POST sudah berisi 'nama_wali_kelas' dari form

            // Simpan konteks (ide "sticky" Anda)
            $_SESSION['konteks_rapor_terakhir'] = [
                'kelas'         => $data_form['kelas'],
                'semester'      => $data_form['semester'],
                'tahun_ajaran'  => $data_form['tahun_ajaran'],
                'nama_wali_kelas' => $data_form['nama_wali_kelas'] // <-- BARU
            ];

            // Cek apakah data ini (untuk siswa, semester, ta) SUDAH ADA
            $rapor_lama = $raporModel->getRaporBySiswa(
                $data_form['id_siswa'],
                $data_form['semester'],
                $data_form['tahun_ajaran']
            );

            // --- LOGIKA UPLOAD FOTO ---
            $uploadDir = 'img/rapor/'; // Relative to public
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $fields = ['foto_agama', 'foto_jati_diri', 'foto_literasi_steam', 'foto_p5'];

            foreach ($fields as $field) {
                // 1. Cek apakah ada file baru diupload
                if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES[$field]['tmp_name'];
                    $fileName = $_FILES[$field]['name'];
                    $fileType = $_FILES[$field]['type'];
                    
                    if (in_array($fileType, $allowedTypes)) {
                        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                        $newFileName = uniqid() . '_' . $field . '.' . $fileExtension;
                        $dest_path = $uploadDir . $newFileName;

                        if (move_uploaded_file($fileTmpPath, $dest_path)) {
                            $data_form[$field] = $newFileName;

                            // HAPUS FOTO LAMA JIKA ADA
                            if ($rapor_lama && !empty($rapor_lama[$field])) {
                                $path_foto_lama = 'img/rapor/' . $rapor_lama[$field];
                                if (file_exists($path_foto_lama)) {
                                    unlink($path_foto_lama);
                                }
                            }
                        } else {
                            $data_form[$field] = null; // Gagal upload
                        }
                    } else {
                         $data_form[$field] = null; // Tipe salah
                    }
                } else {
                    // 2. Jika TIDAK ada file baru, gunakan data LAMA (jika ada)
                    if ($rapor_lama && isset($rapor_lama[$field])) {
                        $data_form[$field] = $rapor_lama[$field];
                    } else {
                        $data_form[$field] = null;
                    }
                }
            }
            // --- AKHIR LOGIKA UPLOAD ---

            $hasil = 0;
            if ($rapor_lama) {
                // UPDATE
                // Cek jika ID Rapor dari form kosong (karena data lama tapi form baru)
                if (empty($data_form['id_rapor'])) {
                    $data_form['id_rapor'] = $rapor_lama['id'];
                }
                $hasil = $raporModel->ubahDataRapor($data_form);
            } else {
                // INSERT
                $hasil = $raporModel->tambahDataRapor($data_form);
            }

            // ... (sisa kode notifikasi dan redirect tidak berubah) ...
            if ($hasil > 0) {
                Flasher::setFlash('Rapor siswa', 'berhasil disimpan', 'success');
            } elseif ($hasil == 0) {
                Flasher::setFlash('Info', 'tidak ada data yang berubah', 'info');
            } else {
                Flasher::setFlash('Rapor siswa', 'gagal disimpan', 'danger');
            }

            header('Location: ' . BASEURL . '/rapor');
            exit;
        }
    }
}
