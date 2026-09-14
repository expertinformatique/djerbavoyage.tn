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
        $path = parse_url($uri, PHP_URL_PATH);
        
        // Nettoyer le préfixe si sous-dossier (ex: /Voyage/public)
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $baseDir = dirname($scriptName);
        if ($baseDir !== '/' && stristr($path, $baseDir) === $path) {
            $path = substr($path, strlen($baseDir));
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

        http_response_code(404);
        require __DIR__ . '/../views/pages/404.php';
        exit;
    }
}