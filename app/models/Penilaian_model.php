<?php

class Penilaian_model
{
    private $table_indikator = 'indikator';
    private $table_penilaian = 'penilaian';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getIndikatorByKelompok($kelompok)
    {
        $this->db->query('SELECT * FROM ' . $this->table_indikator . ' WHERE kelompok = :kelompok ORDER BY id ASC');
        $this->db->bind('kelompok', $kelompok);
        return $this->db->resultSet();
    }

    public function getNilaiTerbaru($id_siswa, $kelompok)
    {
        // Ambil nilai terakhir untuk setiap indikator bagi siswa tertentu
        // Kita gunakan subquery atau join untuk mendapatkan data terbaru per indikator
        $query = "SELECT p.*
                  FROM " . $this->table_penilaian . " p
                  JOIN " . $this->table_indikator . " i ON p.id_indikator = i.id
                  WHERE p.id_siswa = :id_siswa AND i.kelompok = :kelompok
                  AND p.id IN (
                      SELECT MAX(id)
                      FROM " . $this->table_penilaian . "
                      WHERE id_siswa = :id_siswa
                      GROUP BY id_indikator
                  )";

        $this->db->query($query);
        $this->db->bind('id_siswa', $id_siswa);
        $this->db->bind('kelompok', $kelompok);

        $results = $this->db->resultSet();

        // Re-map results by id_indikator for easier access in view
        $mapped = [];
        foreach ($results as $row) {
            $mapped[$row['id_indikator']] = $row;
        }
        return $mapped;
    }

    public function getPenilaianBySiswaTanggal($id_siswa, $tanggal, $kelompok)
    {
        $this->db->query("SELECT id_indikator, nilai FROM penilaian WHERE id_siswa = :id_siswa AND tanggal = :tanggal AND kelompok = :kelompok");
        $this->db->bind('id_siswa', $id_siswa);
        $this->db->bind('tanggal', $tanggal);
        $this->db->bind('kelompok', $kelompok);

        $result = $this->db->resultSet();
        $nilaiArr = [];
        foreach ($result as $row) {
            $nilaiArr[$row['id_indikator']] = $row['nilai'];
        }
        return $nilaiArr;
    }

    public function simpanPenilaianHarian($data, $files = null)
    {
        $id_siswa = $data['id_siswa'];
        $tanggal = $data['tanggal'];
        $kelompok = $data['kelompok'];

        // PATH ABSOLUT: Lebih aman untuk Laragon/XAMPP
        $folder_tujuan = dirname(__DIR__, 2) . '/public/img/penilaian/';

        if (!file_exists($folder_tujuan)) {
            mkdir($folder_tujuan, 0777, true);
        }

        foreach ($data['skala'] as $id_indikator => $skala) {
            // 1. Cari data lama khusus untuk baris ini (siswa + indikator + tgl)
            $this->db->query("SELECT foto FROM penilaian WHERE id_siswa = :id_siswa AND id_indikator = :id_indikator AND tanggal = :tanggal");
            $this->db->bind('id_siswa', $id_siswa);
            $this->db->bind('id_indikator', $id_indikator);
            $this->db->bind('tanggal', $tanggal);
            $row_lama = $this->db->single();
            $nama_file_foto = ($row_lama) ? $row_lama['foto'] : null;

            // 2. Logika Hapus (Jika tombol X diklik)
            if (isset($data['hapus_foto'][$id_indikator]) && $data['hapus_foto'][$id_indikator] == '1') {
                if ($nama_file_foto && file_exists($folder_tujuan . $nama_file_foto)) {
                    unlink($folder_tujuan . $nama_file_foto);
                }
                $nama_file_foto = null;
            }

            // 3. Logika Upload Baru
            if (isset($files['foto']['name'][$id_indikator]) && $files['foto']['error'][$id_indikator] == 0) {
                // Hapus yang lama dulu kalau mau ganti foto baru
                if ($nama_file_foto && file_exists($folder_tujuan . $nama_file_foto)) {
                    unlink($folder_tujuan . $nama_file_foto);
                }

                $ext = pathinfo($files['foto']['name'][$id_indikator], PATHINFO_EXTENSION);
                $nama_file_baru = "IMG_" . $id_siswa . "_" . $id_indikator . "_" . time() . "." . $ext;

                if (move_uploaded_file($files['foto']['tmp_name'][$id_indikator], $folder_tujuan . $nama_file_baru)) {
                    $nama_file_foto = $nama_file_baru;
                }
            }

            // 4. Simpan (REPLACE INTO akan mengupdate jika id_siswa+id_indikator+tgl sudah ada)
            $query = "REPLACE INTO penilaian (id_siswa, id_indikator, tanggal, kelompok, nilai, foto)
                  VALUES (:id_siswa, :id_indikator, :tanggal, :kelompok, :skala, :foto)";

            $this->db->query($query);
            $this->db->bind('id_siswa', $id_siswa);
            $this->db->bind('id_indikator', $id_indikator);
            $this->db->bind('tanggal', $tanggal);
            $this->db->bind('kelompok', $kelompok);
            $this->db->bind('skala', $skala);
            $this->db->bind('foto', $nama_file_foto);
            $this->db->execute();
        }
        return true;
    }

    // Helper untuk cek data hari ini
    public function getPenilaianHarian($id_siswa, $id_indikator, $tanggal)
    {
        $query = "SELECT * FROM " . $this->table_penilaian . "
                  WHERE id_siswa = :id_siswa AND id_indikator = :id_indikator AND tanggal = :tanggal";
        $this->db->query($query);
        $this->db->bind('id_siswa', $id_siswa);
        $this->db->bind('id_indikator', $id_indikator);
        $this->db->bind('tanggal', $tanggal);
        return $this->db->single();
    }

    // Helper untuk satu indikator
    public function getNilaiTerbaruPerIndikator($id_siswa, $id_indikator)
    {
        $query = "SELECT * FROM " . $this->table_penilaian . "
                  WHERE id_siswa = :id_siswa AND id_indikator = :id_indikator
                  ORDER BY id DESC LIMIT 1";
        $this->db->query($query);
        $this->db->bind('id_siswa', $id_siswa);
        $this->db->bind('id_indikator', $id_indikator);
        return $this->db->single();
    }

    public function getFotoBySiswaTanggal($id_siswa, $tanggal)
    {
        $this->db->query("SELECT id_indikator, foto FROM penilaian WHERE id_siswa = :id_siswa AND tanggal = :tanggal");
        $this->db->bind('id_siswa', $id_siswa);
        $this->db->bind('tanggal', $tanggal);

        $result = $this->db->resultSet();
        $fotoArr = [];
        foreach ($result as $row) {
            $fotoArr[$row['id_indikator']] = $row['foto'];
        }
        return $fotoArr;
    }
}
