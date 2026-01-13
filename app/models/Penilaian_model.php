<?php

class Penilaian_model {
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

    public function simpanPenilaian($data)
    {
        $id_siswa = $data['id_siswa'];
        $tanggal = $data['tanggal'];
        $nilai_input = $data['nilai']; // Array [id_indikator => nilai]
        $hapus_foto_input = $data['hapus_foto'] ?? []; // Array [id_indikator => 1/0]
        $files = $_FILES['foto'] ?? []; // Array file upload

        $count = 0;

        foreach ($nilai_input as $id_indikator => $nilai) {
            // 1. Cek apakah sudah ada data untuk (siswa, indikator, tanggal) ini?
            $existingData = $this->getPenilaianHarian($id_siswa, $id_indikator, $tanggal);
            
            // Tentukan foto lama untuk keperluan cleanup/carry-over
            // Jika update hari ini, foto lama adalah foto dari record hari ini.
            // Jika insert baru, foto lama adalah foto dari record terakhir (history).
            if ($existingData) {
                $foto_lama_db = $existingData['foto'];
            } else {
                $lastData = $this->getNilaiTerbaruPerIndikator($id_siswa, $id_indikator);
                $foto_lama_db = ($lastData && !empty($lastData['foto'])) ? $lastData['foto'] : null;
            }

            $foto_name = null;
            $hapus_foto = isset($hapus_foto_input[$id_indikator]) && $hapus_foto_input[$id_indikator] == '1';
            $is_upload_baru = false;

            // 2. Handle File Upload
            if (isset($files['name'][$id_indikator]) && $files['error'][$id_indikator] == 0) {
                $is_upload_baru = true;
                $tmp_name = $files['tmp_name'][$id_indikator];
                $name = $files['name'][$id_indikator];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $new_name = uniqid() . '.' . $ext;
                $target = 'img/penilaian/' . $new_name;
                
                if (!file_exists('img/penilaian')) {
                    mkdir('img/penilaian', 0777, true);
                }

                if (move_uploaded_file($tmp_name, $target)) {
                    $foto_name = $new_name;
                    
                    // Cleanup: Hapus foto lama jika ada (baik dari hari ini atau history yg di-replace)
                    // Note: Jika insert baru dan carry-over foto history, kita JANGAN hapus file fisiknya karena masih dipakai record lama.
                    // Tapi jika UPDATE record hari ini, kita boleh hapus file fisik foto lama record hari ini.
                    if ($existingData && $foto_lama_db && file_exists('img/penilaian/' . $foto_lama_db)) {
                        unlink('img/penilaian/' . $foto_lama_db);
                    }
                }
            } elseif ($hapus_foto) {
                // User minta hapus foto
                $foto_name = null;
                
                // Cleanup: Hanya hapus fisik jika kita sedang UPDATE record hari ini
                if ($existingData && $foto_lama_db && file_exists('img/penilaian/' . $foto_lama_db)) {
                    unlink('img/penilaian/' . $foto_lama_db);
                }
            } else {
                // Tidak ada perubahan foto
                // Jika Update: Tetap pakai foto yang ada di DB (tidak berubah)
                // Jika Insert: Carry over foto dari history
                $foto_name = $foto_lama_db;
            }

            // 3. Eksekusi Query (Insert atau Update)
            if ($existingData) {
                // UPDATE
                $query = "UPDATE " . $this->table_penilaian . " 
                          SET nilai = :nilai, foto = :foto 
                          WHERE id = :id";
                $this->db->query($query);
                $this->db->bind('nilai', $nilai);
                $this->db->bind('foto', $foto_name);
                $this->db->bind('id', $existingData['id']);
            } else {
                // INSERT
                $query = "INSERT INTO " . $this->table_penilaian . " 
                          (id_siswa, id_indikator, tanggal, nilai, foto) 
                          VALUES (:id_siswa, :id_indikator, :tanggal, :nilai, :foto)";
                $this->db->query($query);
                $this->db->bind('id_siswa', $id_siswa);
                $this->db->bind('id_indikator', $id_indikator);
                $this->db->bind('tanggal', $tanggal);
                $this->db->bind('nilai', $nilai);
                $this->db->bind('foto', $foto_name);
            }
            
            $this->db->execute();
            $count++;
        }

        return $count;
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
}
