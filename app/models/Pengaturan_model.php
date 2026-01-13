<?php

class Pengaturan_model
{
    private $table = 'pengaturan';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * Mengambil satu nilai pengaturan berdasarkan kuncinya.
     * @param string $key Kunci pengaturan (cth: 'tahun_ajaran_aktif')
     */
    public function getSetting($key)
    {
        $this->db->query('SELECT setting_value FROM ' . $this->table . ' WHERE setting_key = :key');
        $this->db->bind('key', $key);

        $row = $this->db->single();

        // Cek jika datanya ada, kembalikan nilainya, jika tidak, kembalikan null
        if ($row) {
            return $row['setting_value'];
        } else {
            return null;
        }
    }

    /**
     * Mengubah satu nilai pengaturan di database.
     * @param string $key Kunci pengaturan (cth: 'tahun_ajaran_aktif')
     * @param string $value Nilai baru
     */
    public function updateSetting($key, $value)
    {
        $query = "UPDATE " . $this->table . " SET 
                    setting_value = :setting_value 
                  WHERE 
                    setting_key = :setting_key";

        $this->db->query($query);
        $this->db->bind('setting_value', $value);
        $this->db->bind('setting_key', $key);

        $this->db->execute();

        return $this->db->rowCount();
    }
}
