<?php
namespace App\Repositories;

use App\Interfaces\SettingsRepositoryInterface;
use PDO;

class PdoSettingsRepository implements SettingsRepositoryInterface {
    public function __construct(private PDO $pdo) {}

    public function getAllAsKeyValue(): array {
        $stmt = $this->pdo->query("SELECT setting_key, setting_value FROM settings");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function set(string $key, mixed $value, string $group = 'general'): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO settings (setting_key, setting_value, setting_group) 
            VALUES (:key, :val, :group)
            ON DUPLICATE KEY UPDATE setting_value = :val, setting_group = :group
        ");
        return $stmt->execute([
            'key'   => $key,
            'val'   => (string)$value,
            'group' => $group
        ]);
    }
}