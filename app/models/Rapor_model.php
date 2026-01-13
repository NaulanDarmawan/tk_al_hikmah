<?php

class Rapor_model
{
    private $table = 'rapor';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getRaporBySiswa($id_siswa, $semester, $tahun_ajaran)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE 
                            id_siswa = :id_siswa AND 
                            semester = :semester AND 
                            tahun_ajaran = :tahun_ajaran');

        $this->db->bind('id_siswa', $id_siswa);
        $this->db->bind('semester', $semester);
        $this->db->bind('tahun_ajaran', $tahun_ajaran);

        return $this->db->single();
    }

    public function tambahDataRapor($data)
    {
        $query = "INSERT INTO rapor (
            id_siswa, semester, tahun_ajaran, kelas, nama_wali_kelas,
            sakit, izin, alpha, 
            narasi_agama, narasi_jati_diri, narasi_literasi_steam, 
            narasi_p5, refleksi_ortu,
            foto_agama, foto_jati_diri, foto_literasi_steam, foto_p5
          ) VALUES (
            :id_siswa, :semester, :tahun_ajaran, :kelas, :nama_wali_kelas,
            :sakit, :izin, :alpha, 
            :narasi_agama, :narasi_jati_diri, :narasi_literasi_steam, 
            :narasi_p5, :refleksi_ortu,
            :foto_agama, :foto_jati_diri, :foto_literasi_steam, :foto_p5
          )";

        $this->db->query($query);
        $this->db->bind('id_siswa', $data['id_siswa']);
        $this->db->bind('semester', $data['semester']);
        $this->db->bind('tahun_ajaran', $data['tahun_ajaran']);
        $this->db->bind('kelas', $data['kelas']);
        $this->db->bind('nama_wali_kelas', $data['nama_wali_kelas']);
        $this->db->bind('sakit', $data['sakit']);
        $this->db->bind('izin', $data['izin']);
        $this->db->bind('alpha', $data['alpha']);
        $this->db->bind('narasi_agama', $data['narasi_agama']);
        $this->db->bind('narasi_jati_diri', $data['narasi_jati_diri']);
        $this->db->bind('narasi_literasi_steam', $data['narasi_literasi_steam']);
        $this->db->bind('narasi_p5', $data['narasi_p5']);

        $this->db->bind('refleksi_ortu', $data['refleksi_ortu']);
        $this->db->bind('foto_agama', $data['foto_agama']);
        $this->db->bind('foto_jati_diri', $data['foto_jati_diri']);
        $this->db->bind('foto_literasi_steam', $data['foto_literasi_steam']);
        $this->db->bind('foto_p5', $data['foto_p5']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahDataRapor($data)
    {
        // TAMBAHKAN 'nama_wali_kelas'
        $query = "UPDATE rapor SET
                    kelas = :kelas,
                    nama_wali_kelas = :nama_wali_kelas,
                    sakit = :sakit,
                    izin = :izin,
                    alpha = :alpha,
                    narasi_agama = :narasi_agama,
                    narasi_jati_diri = :narasi_jati_diri,
                    narasi_literasi_steam = :narasi_literasi_steam,
                    narasi_p5 = :narasi_p5,
                    refleksi_ortu = :refleksi_ortu,
                    foto_agama = :foto_agama,
                    foto_jati_diri = :foto_jati_diri,
                    foto_literasi_steam = :foto_literasi_steam,
                    foto_p5 = :foto_p5
                  WHERE id = :id_rapor";

        $this->db->query($query);
        $this->db->bind('kelas', $data['kelas']);
        $this->db->bind('nama_wali_kelas', $data['nama_wali_kelas']); // <-- BARU
        $this->db->bind('sakit', $data['sakit']);
        $this->db->bind('izin', $data['izin']);
        $this->db->bind('alpha', $data['alpha']);
        $this->db->bind('narasi_agama', $data['narasi_agama']);
        $this->db->bind('narasi_jati_diri', $data['narasi_jati_diri']);
        $this->db->bind('narasi_literasi_steam', $data['narasi_literasi_steam']);
        $this->db->bind('narasi_p5', $data['narasi_p5']);
        $this->db->bind('refleksi_ortu', $data['refleksi_ortu']);
        $this->db->bind('foto_agama', $data['foto_agama']);
        $this->db->bind('foto_jati_diri', $data['foto_jati_diri']);
        $this->db->bind('foto_literasi_steam', $data['foto_literasi_steam']);
        $this->db->bind('foto_p5', $data['foto_p5']);
        $this->db->bind('id_rapor', $data['id_rapor']);

        $this->db->execute();
        return $this->db->rowCount();
    }
    public function getRaporById($id_rapor)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind('id', $id_rapor);
        return $this->db->single();
    }
}
