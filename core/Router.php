<?php
namespace Core;

class Router {
    private array $routes = [];

    public function get(string $path, callable|array $handler): void {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, callable|array $handler): void {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, callable|array $handler): void {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_-]+)', $path);
        $pattern = "#^" . $pattern . "$#";
        $this->routes[] = compact('method', 'pattern', 'handler');
    }

    public function dispatch(string $method, string $uri, Container $container): mixed {
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';
        
        // Gérer les requêtes CORS preflight (OPTIONS)
        if (strtoupper($method) === 'OPTIONS') {
            http_response_code(200);
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
            exit;
        }

        // Nettoyer le préfixe si sous-dossier (ex: /djerbavoyage/public ou /djerbavoyage)
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $baseDir = str_replace('\\', '/', dirname($scriptName));
        $baseDir = rtrim($baseDir, '/');

        // Si l'application s'exécute via une réécriture transparente depuis la racine
        if ($baseDir === '/public' || str_ends_with($baseDir, '/public')) {
            if (!str_contains($uri, '/public')) {
                $baseDir = preg_replace('#/public$#', '', $baseDir);
            }
        }

        if ($baseDir !== '' && $baseDir !== '/' && stripos($path, $baseDir) === 0) {
            $path = substr($path, strlen($baseDir));
        }

        // Si la réécriture Apache ou Nginx injecte /public/ au début du chemin
        if (str_starts_with($path, '/public/')) {
            $path = substr($path, 7);
        }

        $path = '/' . trim($path, '/');

        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) && preg_match($route['pattern'], $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                $handler = $route['handler'];
                if (is_array($handler)) {
                    [$controllerClass, $action] = $handler;
                    $controller = $container->make($controllerClass);
                    return call_user_func_array([$controller, $action], $params);
                }

                return call_user_func_array($handler, $params);
            }
        }

        // Tenter une seconde passe en retirant tout préfixe /public résiduel
        if (str_contains($path, '/public')) {
            $cleanPath = '/' . trim(str_replace('/public', '', $path), '/');
            foreach ($this->routes as $route) {
                if ($route['method'] === strtoupper($method) && preg_match($route['pattern'], $cleanPath, $matches)) {
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    $handler = $route['handler'];
                    if (is_array($handler)) {
                        [$controllerClass, $action] = $handler;
                        $controller = $container->make($controllerClass);
                        return call_user_func_array([$controller, $action], $params);
                    }
                    return call_user_func_array($handler, $params);
                }
            }
        }

        http_response_code(404);
        if (str_contains($path, '/api/')) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['error' => 'Route API introuvable (' . $path . ')'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        require __DIR__ . '/../views/pages/404.php';
        exit;
    }
}