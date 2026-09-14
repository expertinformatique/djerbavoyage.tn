<?php
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['SCRIPT_NAME'] = '/public/index.php';
$_SERVER['HTTP_HOST'] = 'localhost';

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
    '/concierge'
];

require_once __DIR__ . '/../core/helpers.php';

echo "🧪 Vérification du rendu des pages front-end...\n";

foreach ($routes as $route) {
    $_SERVER['REQUEST_URI'] = $route;
    ob_start();
    try {
        include __DIR__ . '/../public/index.php';
        $output = ob_get_clean();
        $length = strlen($output);
        if ($length > 500) {
            echo "✅ Route '$route' rendered successfully ($length bytes)\n";
        } else {
            echo "⚠️ Route '$route' returned small output ($length bytes)\n";
        }
    } catch (Throwable $e) {
        ob_end_clean();
        echo "❌ Route '$route' FAILED: " . $e->getMessage() . "\n";
    }
}
