<?php
namespace App\Controllers;

use Core\Controller;
use App\Services\DownloadService;

class DownloadController extends Controller {
    public function __construct(private DownloadService $downloadService) {}

    public function getFile(): void {
        $token = $_GET['token'] ?? '';
        $data = $this->downloadService->validateToken($token);

        if (!$data) {
            http_response_code(403);
            echo "<h1>403 Accès Refusé</h1><p>Jeton de téléchargement invalide ou expiré.</p>";
            exit;
        }

        $this->downloadService->decrementDownloads($token);

        $filePath = __DIR__ . '/../../' . ltrim($data['file_path'], '/');
        
        // Si le fichier réel n'existe pas encore en dev, renvoyer un PDF exemple généré à la volée
        if (!file_exists($filePath)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . sanitize_filename($data['title_fr']) . '.pdf"');
            echo "%PDF-1.4 %Djerba Voyage PDF Sample\n1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj 2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj 3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] >> endobj xref 0 4 0000000000 65535 f 0000000009 00000 n 0000000058 00000 n 0000000115 00000 n trailer << /Size 4 /Root 1 0 R >> startxref 190 %%EOF";
            exit;
        }

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }
}

function sanitize_filename(string $string): string {
    return preg_replace('/[^a-zA-Z0-9_-]/', '_', $string);
}