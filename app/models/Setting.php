<?php

declare(strict_types=1);

class Setting extends BaseModel
{
    public function all(): array
    {
        if (!$this->tableExists('site_settings')) {
            return [];
        }

        return $this->db->query('SELECT setting_key, setting_value FROM site_settings ORDER BY setting_key ASC')->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function upsert(string $key, string $value): void
    {
        if (!$this->tableExists('site_settings')) {
            return;
        }

        $stmt = $this->db->prepare(
            'INSERT INTO site_settings (setting_key, setting_value) VALUES (:setting_key, :setting_value)
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)'
        );
        $stmt->execute(['setting_key' => $key, 'setting_value' => $value]);
    }

    private function tableExists(string $table): bool
    {
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
        $stmt = $this->db->query("SHOW TABLES LIKE '" . $table . "'");

        return (bool) $stmt->fetchColumn();
    }
}
