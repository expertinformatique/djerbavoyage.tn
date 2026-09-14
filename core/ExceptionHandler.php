<?php
namespace Core;

use App\Services\LoggerService;
use Throwable;

class ExceptionHandler {
    public static function register(LoggerService $logger): void {
        set_exception_handler(function (Throwable $e) use ($logger) {
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

            http_response_code(500);
            $viewPath = __DIR__ . '/../views/pages/500.php';
            if (file_exists($viewPath)) {
                require $viewPath;
            } else {
                echo "<h1>Erreur Serveur 500</h1><p>Une erreur interne s'est produite.</p>";
            }
        });
    }
}