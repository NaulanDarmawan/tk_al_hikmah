<?php

class Siswa_model
{
    // Nama tabel yang akan kita kelola
    private $table = 'siswa';

    // Database handler (dari app/core/Database.php)
    private $db;

    public function __construct()
    {
        // Instansiasi kelas Database
        $this->db = new Database;
    }

    /**
     * Mengambil semua data siswa dari database.
     */
    public function getAllSiswa()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC');

        return $this->db->resultSet();
    }

    /**
     * Mengambil satu data siswa berdasarkan ID.
     * @param int $id ID siswa
     */
    public function getSiswaById($id)
    {
        // Siapkan query untuk mengambil data berdasarkan ID
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');

        // Binding data (untuk menghindari SQL Injection)
        $this->db->bind('id', $id);

        // Eksekusi query dan kembalikan 1 baris data
        return $this->db->single();
    }

    public function tambahDataSiswa($data)
    {
        // Siapkan query SQL untuk INSERT dengan SEMUA KOLOM
        $query = "INSERT INTO siswa (
            nisn, nis, nama_lengkap, nama_panggilan,
            berat_badan, tinggi_badan, jenis_kelamin,
            tempat_lahir, tanggal_lahir, agama, anak_ke,
            nama_ayah, nama_ibu, hp_ortu, pekerjaan_ayah, pekerjaan_ibu,
            alamat_jalan, kode_pos, kecamatan, kab_kota, provinsi, foto
          )
          VALUES (
            :nisn, :nis, :nama_lengkap, :nama_panggilan,
            :berat_badan, :tinggi_badan, :jenis_kelamin,
            :tempat_lahir, :tanggal_lahir, :agama, :anak_ke,
            :nama_ayah, :nama_ibu, :hp_ortu, :pekerjaan_ayah, :pekerjaan_ibu,
            :alamat_jalan, :kode_pos, :kecamatan, :kab_kota, :provinsi, :foto
          )";

        // Persiapkan query-nya
        $this->db->query($query);

        // Binding SEMUA data (mencocokkan :placeholder dengan data dari form)
        $this->db->bind('nisn', $data['nisn']);
        $this->db->bind('nis', $data['nis']);
        $this->db->bind('nama_lengkap', $data['nama_lengkap']);
        $this->db->bind('nama_panggilan', $data['nama_panggilan']);
        $this->db->bind('berat_badan', $data['berat_badan']);
        $this->db->bind('tinggi_badan', $data['tinggi_badan']);
        $this->db->bind('jenis_kelamin', $data['jenis_kelamin']);
        $this->db->bind('tempat_lahir', $data['tempat_lahir']);
        $this->db->bind('tanggal_lahir', $data['tanggal_lahir']);
        $this->db->bind('agama', $data['agama']);
        $this->db->bind('anak_ke', $data['anak_ke']);
        $this->db->bind('nama_ayah', $data['nama_ayah']);
        $this->db->bind('nama_ibu', $data['nama_ibu']);
        $this->db->bind('hp_ortu', $data['hp_ortu']);
        $this->db->bind('pekerjaan_ayah', $data['pekerjaan_ayah']);
        $this->db->bind('pekerjaan_ibu', $data['pekerjaan_ibu']);
        $this->db->bind('alamat_jalan', $data['alamat_jalan']);
        $this->db->bind('kode_pos', $data['kode_pos']);
        $this->db->bind('kecamatan', $data['kecamatan']);
        $this->db->bind('kab_kota', $data['kab_kota']);
        $this->db->bind('provinsi', $data['provinsi']);
        $this->db->bind('foto', $data['foto']);

        // Eksekusi query
        $this->db->execute();

        // Kembalikan jumlah baris yang terpengaruh oleh query
        return $this->db->rowCount();
    }

    /**
     * Mengubah data siswa di database.
     * @param array $data Data siswa dari $_POST
     */
    public function ubahDataSiswa($data)
    {
        // Query untuk UPDATE data
        $query = "UPDATE siswa SET
                    nisn = :nisn,
                    nis = :nis,
                    nama_lengkap = :nama_lengkap,
                    nama_panggilan = :nama_panggilan,
                    berat_badan = :berat_badan,
                    tinggi_badan = :tinggi_badan,
                    jenis_kelamin = :jenis_kelamin,
                    tempat_lahir = :tempat_lahir,
                    tanggal_lahir = :tanggal_lahir,
                    agama = :agama,
                    anak_ke = :anak_ke,
                    nama_ayah = :nama_ayah,
                    nama_ibu = :nama_ibu,
                    hp_ortu = :hp_ortu,
                    pekerjaan_ayah = :pekerjaan_ayah,
                    pekerjaan_ibu = :pekerjaan_ibu,
                    alamat_jalan = :alamat_jalan,
                    kode_pos = :kode_pos,
                    kecamatan = :kecamatan,
                    kab_kota = :kab_kota,
                    provinsi = :provinsi,
                    foto = :foto
                  WHERE id = :id";

        // Persiapkan query
        $this->db->query($query);

        // Binding SEMUA data (INI YANG SUDAH DIPERBAIKI TOTAL)
        $this->db->bind('nisn', $data['nisn']);
        $this->db->bind('nis', $data['nis']);
        $this->db->bind('nama_lengkap', $data['nama_lengkap']);
        $this->db->bind('nama_panggilan', $data['nama_panggilan']);
        $this->db->bind('berat_badan', $data['berat_badan']);
        $this->db->bind('tinggi_badan', $data['tinggi_badan']);
        $this->db->bind('jenis_kelamin', $data['jenis_kelamin']);
        $this->db->bind('tempat_lahir', $data['tempat_lahir']);
        $this->db->bind('tanggal_lahir', $data['tanggal_lahir']);
        $this->db->bind('agama', $data['agama']);
        $this->db->bind('anak_ke', $data['anak_ke']);
        $this->db->bind('nama_ayah', $data['nama_ayah']);
        $this->db->bind('nama_ibu', $data['nama_ibu']);
        $this->db->bind('hp_ortu', $data['hp_ortu']);
        $this->db->bind('pekerjaan_ayah', $data['pekerjaan_ayah']);
        $this->db->bind('pekerjaan_ibu', $data['pekerjaan_ibu']);
        $this->db->bind('alamat_jalan', $data['alamat_jalan']);
        $this->db->bind('kode_pos', $data['kode_pos']);
        $this->db->bind('kecamatan', $data['kecamatan']);
        $this->db->bind('kab_kota', $data['kab_kota']);
        $this->db->bind('provinsi', $data['provinsi']);
        $this->db->bind('foto', $data['foto']);
        $this->db->bind('id', $data['id']);

        // Eksekusi
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function hapusDataSiswa($id)
    {
        // 1. AMBIL DATA DULU (Kita butuh nama fotonya)
        // Kita pakai method getSiswaById yang sudah ada di model ini
        $siswa = $this->getSiswaById($id);

        // 2. CEK DAN HAPUS FISIK FOTO
        // Jangan hapus jika itu foto 'default.jpg' (foto bawaan sistem)
        if ($siswa['foto'] != 'default.jpg') {
            $target = 'img/' . $siswa['foto'];

            // Cek apakah file aslinya ada di folder?
            if (file_exists($target)) {
                unlink($target); // Hapus file dari folder
            }
        }

        // 3. BARU HAPUS DATA DI DATABASE
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";

        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function cariDataSiswa($keyword)
    {
        // Kode Anda saat ini (diurutkan berdasarkan nama)
        $query = "SELECT * FROM siswa WHERE
                    nama_lengkap LIKE :keyword OR
                    nis LIKE :keyword OR
                    nisn LIKE :keyword
                  ORDER BY nama_lengkap ASC";

        $this->db->query($query);
        $this->db->bind('keyword', '%' . $keyword . '%');

        return $this->db->resultSet();
    }

}
