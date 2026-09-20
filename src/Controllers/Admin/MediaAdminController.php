<?php
namespace App\Controllers\Admin;

use Core\Controller;

/**
 * Gestionnaire de Médias — Images (/images/, /images/blog/, uploads) et Vidéos
 */
class MediaAdminController extends Controller {

    private function requireAuth(): void {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }
        if (empty($_SESSION['admin_logged'])) {
            $this->redirect('/admin/login');
        }
    }

    public function index(): void {
        $this->requireAuth();
        $tab = in_array($_GET['tab'] ?? '', ['images', 'videos']) ? $_GET['tab'] : 'images';
        $images = $this->scanMediaFiles('images');
        $videos = $this->scanMediaFiles('videos');

        $flashSuccess = $_SESSION['admin_flash_success'] ?? null;
        $flashError   = $_SESSION['admin_flash_error'] ?? null;
        unset($_SESSION['admin_flash_success'], $_SESSION['admin_flash_error']);

        $this->render('admin/media/index', [
            'images'       => $images,
            'videos'       => $videos,
            'tab'          => $tab,
            'flashSuccess' => $flashSuccess,
            'flashError'   => $flashError,
        ], 'layouts/admin');
    }

    public function upload(): void {
        $this->requireAuth();
        $type   = trim($_POST['media_type'] ?? 'image');
        $folder = in_array($_POST['folder'] ?? '', ['blog', 'uploads']) ? $_POST['folder'] : 'uploads';

        if (empty($_FILES['media_files'])) {
            $_SESSION['admin_flash_error'] = "Aucun fichier sélectionné.";
            $this->redirect('/admin/media');
            return;
        }

        $files = $_FILES['media_files'];
        $uploaded = 0;
        $count = is_array($files['name']) ? count($files['name']) : 1;

        for ($i = 0; $i < $count; $i++) {
            $name    = is_array($files['name']) ? $files['name'][$i] : $files['name'];
            $tmpName = is_array($files['tmp_name']) ? $files['tmp_name'][$i] : $files['tmp_name'];
            $error   = is_array($files['error']) ? $files['error'][$i] : $files['error'];

            if ($error !== UPLOAD_ERR_OK || empty($name)) continue;

            $ok = ($type === 'video')
                ? $this->saveVideo($name, $tmpName)
                : $this->saveImage($name, $tmpName, $folder);

            if ($ok) $uploaded++;
        }

        $_SESSION[$uploaded > 0 ? 'admin_flash_success' : 'admin_flash_error'] =
            $uploaded > 0 ? "{$uploaded} fichier(s) téléversé(s) avec succès." : "Échec du téléversement.";
        $this->redirect('/admin/media?tab=' . ($type === 'video' ? 'videos' : 'images'));
    }

    public function delete(): void {
        $this->requireAuth();
        $file   = basename(trim($_POST['file'] ?? ''));
        $type   = trim($_POST['type'] ?? 'image');
        $folder = in_array($_POST['folder'] ?? '', ['blog', 'uploads']) ? $_POST['folder'] : 'uploads';

        if (empty($file)) {
            $_SESSION['admin_flash_error'] = "Fichier non spécifié.";
            $this->redirect('/admin/media');
            return;
        }

        $fullPath = ($type === 'video')
            ? ROOT_PATH . '/public/assets/videos/uploads/' . $file
            : ROOT_PATH . '/public/assets/images/' . $folder . '/' . $file;

        if (file_exists($fullPath) && is_file($fullPath) && unlink($fullPath)) {
            $_SESSION['admin_flash_success'] = "Fichier « {$file} » supprimé.";
        } else {
            $_SESSION['admin_flash_error'] = "Impossible de supprimer ce fichier.";
        }

        $this->redirect('/admin/media?tab=' . ($type === 'video' ? 'videos' : 'images'));
    }

    private function saveImage(string $name, string $tmpName, string $folder = 'uploads'): bool {
        $dir = ROOT_PATH . '/public/assets/images/' . $folder . '/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $prefix = ($folder === 'blog') ? 'blog_' : 'img_';
        $safe = uniqid($prefix) . '_' . preg_replace('/[^a-zA-Z0-9.\-_]/', '', basename($name));
        return move_uploaded_file($tmpName, $dir . $safe);
    }

    private function saveVideo(string $name, string $tmpName): bool {
        $dir = ROOT_PATH . '/public/assets/videos/uploads/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $safe = uniqid('vid_') . '_' . preg_replace('/[^a-zA-Z0-9.\-_]/', '', basename($name));
        return move_uploaded_file($tmpName, $dir . $safe);
    }

    public function scanMediaFiles(string $type): array {
        $baseDirs = ($type === 'images') ? [
            ['dir' => ROOT_PATH . '/public/assets/images/', 'prefix' => '', 'group' => 'Images du site', 'folder' => 'site', 'deletable' => false],
            ['dir' => ROOT_PATH . '/public/assets/images/blog/', 'prefix' => 'blog/', 'group' => 'Blog & Articles', 'folder' => 'blog', 'deletable' => true],
            ['dir' => ROOT_PATH . '/public/assets/images/uploads/', 'prefix' => 'uploads/', 'group' => 'Téléversements', 'folder' => 'uploads', 'deletable' => true],
        ] : [
            ['dir' => ROOT_PATH . '/public/assets/videos/', 'prefix' => '', 'group' => 'Vidéos du site', 'folder' => 'site', 'deletable' => false],
            ['dir' => ROOT_PATH . '/public/assets/videos/uploads/', 'prefix' => 'uploads/', 'group' => 'Téléversements', 'folder' => 'uploads', 'deletable' => true],
        ];

        $results = [];
        $exts = ($type === 'images') ? ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'] : ['mp4', 'webm', 'ogg', 'mov', 'avi'];
        $ignore = ['.', '..', '.gitkeep', 'index.php', '.htaccess'];

        foreach ($baseDirs as $entry) {
            if (!is_dir($entry['dir'])) continue;
            foreach (scandir($entry['dir']) as $f) {
                if (in_array($f, $ignore, true)) continue;
                $path = $entry['dir'] . $f;
                if (!is_file($path)) continue;

                $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                if (!in_array($ext, $exts, true)) continue;

                $results[] = [
                    'name'      => $f,
                    'path'      => $entry['prefix'] . $f,
                    'url'       => ($type === 'images') ? '/images/' . $entry['prefix'] . $f : '/assets/videos/' . $entry['prefix'] . $f,
                    'asset_url' => '/assets/' . $type . '/' . $entry['prefix'] . $f,
                    'size'      => filesize($path),
                    'modified'  => filemtime($path),
                    'group'     => $entry['group'],
                    'folder'    => $entry['folder'],
                    'deletable' => $entry['deletable'],
                ];
            }
        }
        usort($results, fn($a, $b) => $b['modified'] - $a['modified']);
        return $results;
    }
}
