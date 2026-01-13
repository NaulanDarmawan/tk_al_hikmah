<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

class Migration {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function run() {
        $queries = [
            "ALTER TABLE rapor ADD COLUMN foto_agama VARCHAR(255) NULL",
            "ALTER TABLE rapor ADD COLUMN foto_jati_diri VARCHAR(255) NULL",
            "ALTER TABLE rapor ADD COLUMN foto_literasi_steam VARCHAR(255) NULL",
            "ALTER TABLE rapor ADD COLUMN foto_p5 VARCHAR(255) NULL"
        ];

        foreach ($queries as $query) {
            try {
                $this->db->query($query);
                $this->db->execute();
                echo "Success: $query\n";
            } catch (PDOException $e) {
                echo "Error/Exists: " . $e->getMessage() . "\n";
            }
        }
    }
}

$migration = new Migration();
$migration->run();
