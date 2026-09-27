<?php
/**
 * Point d'entrée direct API ChatBot IA — Djerba Voyage
 */
header('Content-Type: application/json; charset=utf-8');

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__, 2));
}

require_once ROOT_PATH . '/core/helpers.php';
require_once ROOT_PATH . '/core/Database.php';
require_once ROOT_PATH . '/core/Lang.php';

// Autoloader
spl_autoload_register(function ($class) {
    $prefixes = [
        'App\\' => ROOT_PATH . '/src/',
        'Core\\' => ROOT_PATH . '/core/'
    ];
    foreach ($prefixes as $prefix => $baseDir) {
        if (str_starts_with($class, $prefix)) {
            $rel = substr($class, strlen($prefix));
            $file = $baseDir . str_replace('\\', '/', $rel) . '.php';
            if (file_exists($file)) require_once $file;
        }
    }
});

use Core\Database;
use Core\Lang;
use App\Repositories\PdoChatConversationRepository;
use App\Services\ChatKnowledgeService;
use App\Services\GoogleAiService;
use App\Services\SmtpMailerService;
use App\Controllers\ChatBotController;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
    exit;
}

try {
    Lang::boot();
    $pdo = Database::getInstance();
    $repo = new PdoChatConversationRepository($pdo);
    $controller = new ChatBotController($repo, new ChatKnowledgeService(new GoogleAiService()), new SmtpMailerService());
    $controller->handleEndpoint();
} catch (Throwable $e) {
    @error_log("[" . date('Y-m-d H:i:s') . "] API CHAT ROOT ERROR: " . $e->getMessage() . PHP_EOL, 3, ROOT_PATH . '/error.log');
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur serveur.']);
}
