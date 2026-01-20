<?php

class Penilaian extends Controller
{

   public function index() {
        $tanggal = (isset($_POST['tgl'])) ? $_POST['tgl'] : date('Y-m-d');

        $data['judul'] = 'Penilaian Harian';
        $data['tanggal_pilihan'] = $tanggal;
        $data['siswa'] = $this->model('Siswa_model')->getAllSiswa();

        // PENTING: Cek status A dan B secara terpisah (Kirim 3 argumen)
        foreach ($data['siswa'] as $key => $s) {
            $nilaiA = $this->model('Penilaian_model')->getPenilaianBySiswaTanggal($s['id'], $tanggal, 'A');
            $nilaiB = $this->model('Penilaian_model')->getPenilaianBySiswaTanggal($s['id'], $tanggal, 'B');

            $data['siswa'][$key]['status_A'] = !empty($nilaiA) ? 'Selesai' : 'Belum';
            $data['siswa'][$key]['status_B'] = !empty($nilaiB) ? 'Selesai' : 'Belum';
        }

        $this->view('templates/header', $data);
        $this->view('penilaian/index', $data);
        $this->view('templates/footer');
    }

    public function input($id_siswa, $kelompok, $tanggal = null)
    {
        if ($tanggal == null) $tanggal = date('Y-m-d');

        $data['judul'] = 'Input Penilaian Harian';
        $data['siswa'] = $this->model('Siswa_model')->getSiswaById($id_siswa);
        $data['tanggal'] = $tanggal;
        $data['kelompok'] = $kelompok;

        // Ambil data indikator berdasarkan kelompok (A atau B)
        $raw_indikator = $this->model('Penilaian_model')->getIndikatorByKelompok($kelompok);

        // Siapkan struktur array agar tidak error di View
        $data['indikator'] = [
            'AGAMA' => [],
            'JATI_DIRI' => [],
            'STEAM' => []
        ];

        foreach ($raw_indikator as $i) {
            // Mengelompokkan berdasarkan field 'kategori' dan 'sub_elemen'
            $kat = $i['kategori'];
            $sub = $i['sub_elemen'];
            $data['indikator'][$kat][$sub][] = $i;
        }

        // Ambil history nilai di tanggal tersebut
        $data['nilai_existing'] = $this->model('Penilaian_model')->getPenilaianBySiswaTanggal($id_siswa, $tanggal, $kelompok);
        $data['foto_existing'] = $this->model('Penilaian_model')->getFotoBySiswaTanggal($id_siswa, $tanggal);

        $this->view('templates/header', $data);
        $this->view('penilaian/input', $data);
        $this->view('templates/footer');
    }

    public function simpan()
    {
        // Pastikan parameter kedua ($_FILES) dikirim ke model
        if ($this->model('Penilaian_model')->simpanPenilaianHarian($_POST, $_FILES)) {
            Flasher::setFlash('Penilaian harian', 'berhasil disimpan', 'success');
        } else {
            Flasher::setFlash('Gagal', 'menyimpan penilaian', 'danger');
        }

        $id_siswa = $_POST['id_siswa'];
        $kelompok = $_POST['kelompok'];
        $tanggal = $_POST['tanggal'];
        header('Location: ' . BASEURL . '/penilaian/input/' . $id_siswa . '/' . $kelompok . '/' . $tanggal);
        exit;
    }
}
