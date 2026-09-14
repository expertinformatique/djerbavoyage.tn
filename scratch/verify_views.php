<?php
/**
 * Script de vérification automatisée des routes
 */
require_once __DIR__ . '/../core/helpers.php';
require_once __DIR__ . '/../core/Database.php';

$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_METHOD'] = 'GET';

$routes = [
    '/',
    '/a-propos',
    '/contact',
    '/newsletter',
    '/politique-de-confidentialite',
    '/divulgation-affiliation',
    '/faq',
    '/activites',
    '/itineraires',
    '/avis',
    '/shop',
    '/concierge',
    '/services',
    '/sitemap.xml',
    '/robots.txt'
];

echo "🧪 Vérification du rendu des pages front-end...\n";

foreach ($routes as $route) {
    $_SERVER['REQUEST_URI'] = $route;
    
    ob_start();
    try {
        require __DIR__ . '/../public/index.php';
        $output = ob_get_clean();
        $size = strlen($output);
        if ($size > 100) {
            echo "✅ Route '{$route}' rendered successfully ({$size} bytes)\n";
        } else {
            echo "❌ Route '{$route}' returned unexpectedly short response ({$size} bytes)\n";
        }
    } catch (Throwable $e) {
        ob_end_clean();
        echo "❌ Route '{$route}' failed: " . $e->getMessage() . "\n";
    }
}
