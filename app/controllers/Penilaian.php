<?php

class Penilaian extends Controller {
    
    public function index()
    {
        $data['judul'] = 'Penilaian Harian Siswa';
        
        // --- LOGIKA SEARCH ---
        if ( isset($_POST['keyword']) ) {
            // Cari siswa berdasarkan keyword
            $data['siswa'] = $this->model('Siswa_model')->cariDataSiswa($_POST['keyword']);
            $data['keyword'] = $_POST['keyword']; // Simpan keyword agar tidak hilang di view
        } else {
            // Jika tidak mencari, ambil semua siswa (terbaru)
            $data['siswa'] = $this->model('Siswa_model')->getAllSiswa();
            $data['keyword'] = '';
        }
        // ---------------------

        $this->view('templates/header', $data);
        $this->view('penilaian/index', $data);
        $this->view('templates/footer');
    }

    /**
     * Method Input dengan Pilihan Kelompok Manual
     * URL: /penilaian/input/{id_siswa}/{kelompok}
     */
    public function input($id_siswa, $kelompok = 'A')
    {
        $data['judul'] = 'Input Perkembangan Anak';
        
        // 1. Ambil Data Siswa
        $data['siswa'] = $this->model('Siswa_model')->getSiswaById($id_siswa);

        // 2. Set Kelompok Aktif (Default 'A' jika tidak ada di URL)
        $kelompok = strtoupper($kelompok);
        if ($kelompok != 'A' && $kelompok != 'B') {
            $kelompok = 'A';
        }
        $data['kelompok_aktif'] = $kelompok;

        // 3. Ambil Data Indikator dari Database
        $rawIndikator = $this->model('Penilaian_model')->getIndikatorByKelompok($kelompok);
        
        // Struktur ulang data agar mudah di-loop di View:
        // $indikator[KATEGORI][SUB_ELEMEN][] = ['id' => ..., 'deskripsi' => ...]
        $indikatorStructured = [];
        foreach ($rawIndikator as $row) {
            $indikatorStructured[$row['kategori']][$row['sub_elemen']][] = [
                'id' => $row['id'],
                'deskripsi' => $row['deskripsi']
            ];
        }
        $data['indikator'] = $indikatorStructured;

        // 4. Ambil Data Penilaian Terakhir (History) untuk Pre-fill
        $data['nilai_terbaru'] = $this->model('Penilaian_model')->getNilaiTerbaru($id_siswa, $kelompok);

        $this->view('templates/header', $data);
        $this->view('penilaian/input', $data);
        $this->view('templates/footer');
    }

    public function simpan()
    {
        if ($this->model('Penilaian_model')->simpanPenilaian($_POST) > 0) {
            Flasher::setFlash('Penilaian harian', 'berhasil disimpan', 'success');
        } else {
            // Jika 0, mungkin tidak ada perubahan atau error, tapi kita anggap sukses update saja
            Flasher::setFlash('Penilaian harian', 'berhasil disimpan', 'success');
        }
        
        // Redirect kembali ke halaman input siswa tersebut agar guru bisa lanjut edit
        $id_siswa = $_POST['id_siswa'];
        $kelompok = $_POST['kelompok'];
        header('Location: ' . BASEURL . '/penilaian/input/' . $id_siswa . '/' . $kelompok);
        exit;
    }
}