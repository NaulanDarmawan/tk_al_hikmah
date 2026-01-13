<?php

class Siswa extends Controller
{

    /**
     * Method default untuk controller Siswa.
     * Akan menampilkan halaman daftar semua siswa.
     */
    public function index()
    {
        $data['judul'] = 'Daftar Siswa';

        // Cek apakah ada keyword pencarian yang dikirim
        if (isset($_POST['keyword'])) {
            // Jika ada, jalankan method cari
            $data['siswa'] = $this->model('Siswa_model')->cariDataSiswa($_POST['keyword']);
            // Simpan keyword untuk ditampilkan kembali di form
            $data['keyword'] = $_POST['keyword'];
        } else {
            // Jika tidak ada, tampilkan semua siswa
            $data['siswa'] = $this->model('Siswa_model')->getAllSiswa();
            // Set keyword kosong
            $data['keyword'] = '';
        }

        // Tampilkan ke view
        $this->view('templates/header', $data);
        $this->view('siswa/index', $data); // Kirim data ke view
        $this->view('templates/footer');
    }

    /**
     * Method untuk menampilkan halaman detail satu siswa.
     * @param int $id ID siswa yang diambil dari URL
     */
    public function detail($id)
    {
        // 1. Siapkan data untuk view
        $data['judul'] = 'Detail Siswa';

        // 2. Ambil data dari model berdasarkan $id
        $data['siswa'] = $this->model('Siswa_model')->getSiswaById($id);

        // 3. Tampilkan ke view
        $this->view('templates/header', $data);
        $this->view('siswa/detail', $data); // View detail akan kita buat nanti
        $this->view('templates/footer');
    }
    public function tambah()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Panggil method upload
            $foto = $this->upload();

            // Jika upload gagal (return false), hentikan proses
            if ($foto === false) {
                header('Location: ' . BASEURL . '/siswa');
                exit;
            }

            // Jika upload berhasil (atau default), masukkan nama file ke $_POST
            $_POST['foto'] = $foto;

            // Lanjutkan proses simpan ke model
            if ($this->model('Siswa_model')->tambahDataSiswa($_POST) > 0) {
                Flasher::setFlash('Data siswa', 'berhasil ditambahkan', 'success');
                header('Location: ' . BASEURL . '/siswa');
                exit;
            } else {
                Flasher::setFlash('Data siswa', 'gagal ditambahkan', 'danger');
                header('Location: ' . BASEURL . '/siswa');
                exit;
            }
        }
    }
    public function hapus($id)
    {
        if ($this->model('Siswa_model')->hapusDataSiswa($id) > 0) {
            Flasher::setFlash('Data siswa', 'berhasil dihapus', 'success');
            header('Location: ' . BASEURL . '/siswa');
            exit;
        } else {
            Flasher::setFlash('Data siswa', 'gagal dihapus', 'danger');
            header('Location: ' . BASEURL . '/siswa');
            exit;
        }
    }

    public function getubahdata()
    {
        // Panggil model 'getSiswaById' dengan ID dari data POST (kiriman AJAX)
        $data = $this->model('Siswa_model')->getSiswaById($_POST['id']);

        // Kembalikan data sebagai JSON
        echo json_encode($data);
    }

    public function ubah()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Cek apakah user mengupload foto baru
            if ($_FILES['foto']['error'] === 4) {
                // Jika tidak ada foto baru, pakai nama foto lama
                $foto = $_POST['fotoLama'];
            } else {
                // Jika ada foto baru, upload
                $foto = $this->upload();

                // Jika upload gagal, hentikan
                if ($foto === false) {
                    header('Location: ' . BASEURL . '/siswa');
                    exit;
                }

                // (Opsional) Hapus file foto lama jika bukan default.jpg
                if ($_POST['fotoLama'] != 'default.jpg') {
                    @unlink('img/' . $_POST['fotoLama']);
                }
            }

            // Masukkan nama file foto (baru atau lama) ke $_POST
            $_POST['foto'] = $foto;

            // Lanjutkan proses update ke model
            $hasil_update = $this->model('Siswa_model')->ubahDataSiswa($_POST);


            // Cek hasilnya dengan urutan yang benar
            if ($hasil_update > 0) {
                // 1. SUKSES: Ada baris yang berubah (hasil > 0)
                Flasher::setFlash('Data siswa', 'berhasil diubah', 'success');
                header('Location: ' . BASEURL . '/siswa');
                exit;
            } elseif ($hasil_update == 0) {
                // 2. SUKSES: Tidak ada baris yang berubah (hasil == 0)
                // Kita gunakan tipe 'info' (biru) agar tidak terlihat seperti error
                Flasher::setFlash('Info', 'tidak ada data yang diubah', 'info');
                header('Location: ' . BASEURL . '/siswa');
                exit;
            } else {
                Flasher::setFlash('Data siswa', 'gagal diubah', 'danger');
                header('Location: ' . BASEURL . '/siswa');
                exit;
            }
        }
    }
    private function upload()
    {
        $namaFile = $_FILES['foto']['name'];
        $ukuranFile = $_FILES['foto']['size'];
        $error = $_FILES['foto']['error'];
        $tmpName = $_FILES['foto']['tmp_name'];

        // 1. Cek apakah ada gambar yang di-upload
        if ($error === 4) { // 4 = UPLOAD_ERR_NO_FILE
            return 'default.jpg'; // Jika tidak ada, pakai foto default
        }

        // 2. Cek ekstensi file
        $ekstensiValid = ['jpg', 'jpeg', 'png', 'gif'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if (!in_array($ekstensiGambar, $ekstensiValid)) {
            Flasher::setFlash('Upload Gagal', 'yang Anda pilih bukan gambar!', 'danger');
            return false; // Kembalikan false jika gagal
        }

        // 3. Cek ukuran file (misal: maks 2MB)
        if ($ukuranFile > 2000000) {
            Flasher::setFlash('Upload Gagal', 'ukuran gambar terlalu besar! (Maks 2MB)', 'danger');
            return false;
        }

        // 4. Lolos pengecekan, generate nama file baru
        // uniqid() untuk memberi string acak
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;

        // 5. Pindahkan file ke folder public/img/
        if (move_uploaded_file($tmpName, 'img/' . $namaFileBaru)) {
            return $namaFileBaru; // Kembalikan nama file baru jika sukses
        } else {
            Flasher::setFlash('Upload Gagal', 'terjadi kesalahan saat memindah file.', 'danger');
            return false;
        }
    }
}
