<?php
namespace App\Repositories;

use App\Interfaces\SettingsRepositoryInterface;
use PDO;

class PdoSettingsRepository implements SettingsRepositoryInterface {
    public function __construct(private PDO $pdo) {}

    public function getAllAsKeyValue(): array {
        try {
            $stmt = $this->pdo->query("SELECT setting_key, setting_value FROM settings");
            return $stmt->fetchAll(PDO::FETCH_KEY_PAIR) ?: [];
        } catch (\Throwable $e) {
            $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
            @error_log("[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $rootPath . '/error.log');
            return [];
        }
    }

    public function set(string $key, mixed $value, string $group = 'general'): bool {
        try {
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
        } catch (\Throwable $e) {
            $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
            @error_log("[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $rootPath . '/error.log');
            return false;
        }
    }
}