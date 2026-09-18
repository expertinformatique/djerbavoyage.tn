<?php
namespace Core;

abstract class Controller {
    protected function render(string $view, array $data = [], string $layout = 'layouts/main'): void {
        extract($data);
        
        ob_start();
        $viewPath = __DIR__ . '/../views/' . ltrim($view, '/') . '.php';
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            echo "Vue introuvable: {$viewPath}";
        }
        $content = ob_get_clean();

        $layoutPath = __DIR__ . '/../views/' . ltrim($layout, '/') . '.php';
        if (file_exists($layoutPath)) {
            require $layoutPath;
        } else {
            echo $content;
        }
    }

    protected function json(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function redirect(string $path): void {
        $finalUrl = (strpos($path, 'http') === 0) ? $path : url($path);
        if (!defined('PHPUNIT_RUNNING')) {
            header("Location: {$finalUrl}");
            exit;
        }
    }
}