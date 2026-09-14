<?php
namespace Core;

use App\Services\LoggerService;
use Throwable;

class ExceptionHandler {
    public static function register(LoggerService $logger): void {
        set_exception_handler(function (Throwable $e) use ($logger) {
            $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__);
            $logFormatted = "[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL;

            // 1. Journalisation dans error.log à la racine du projet (Règle 8)
            @error_log($logFormatted, 3, $rootPath . '/error.log');
            @error_log($logFormatted);

            // 2. Journalisation via LoggerService
            try {
                $logger->log(
                    event: 'system_exception',
                    severity: 'critical',
                    message: $e->getMessage(),
                    payload: [
                        'file'  => $e->getFile(),
                        'line'  => $e->getLine(),
                        'trace' => $e->getTraceAsString()
                    ]
                );
            } catch (Throwable) {
                // Ignore logger failure to avoid cascade loops
            }

            http_response_code(500);
            $viewPath = $rootPath . '/views/pages/500.php';
            if (file_exists($viewPath)) {
                require $viewPath;
            } else {
                echo "<h1>Erreur Serveur 500</h1><p>Une erreur interne s'est produite.</p>";
            }
        });
    }
}