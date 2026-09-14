<?php
/**
 * Front Controller Principal — Djerba Voyage Platform
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}

require_once __DIR__ . '/../core/helpers.php';

// Autoloading simple pour App\ et Core\
spl_autoload_register(function ($class) {
    $prefixApp = 'App\\';
    $prefixCore = 'Core\\';
    $baseDir = __DIR__ . '/../';

    if (strpos($class, $prefixApp) === 0) {
        $relativeClass = substr($class, strlen($prefixApp));
        $file = $baseDir . 'src/' . str_replace('\\', '/', $relativeClass) . '.php';
        if (file_exists($file)) require_once $file;
    } else if (strpos($class, $prefixCore) === 0) {
        $relativeClass = substr($class, strlen($prefixCore));
        $file = $baseDir . 'core/' . str_replace('\\', '/', $relativeClass) . '.php';
        if (file_exists($file)) require_once $file;
    }
});

use Core\Container;
use Core\Database;
use Core\Router;
use Core\ExceptionHandler;
use App\Interfaces\ArticleRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\SettingsRepositoryInterface;
use App\Interfaces\CacheInterface;
use App\Interfaces\LocalServiceRepositoryInterface;
use App\Interfaces\BookingScheduleRepositoryInterface;
use App\Interfaces\ReviewRepositoryInterface;
use App\Repositories\PdoArticleRepository;
use App\Repositories\PdoOrderRepository;
use App\Repositories\PdoProductRepository;
use App\Repositories\PdoSettingsRepository;
use App\Repositories\PdoLocalServiceRepository;
use App\Repositories\PdoBookingScheduleRepository;
use App\Repositories\PdoReviewRepository;
use App\Services\CacheService;
use App\Services\SettingsService;
use App\Services\LoggerService;
use App\Services\FraudDetectionService;
use App\Services\AnalyticsService;
use App\Services\DownloadService;
use App\Services\StripeService;
use App\Services\PricingEstimationService;
use App\Services\ReviewService;
use App\Services\PassVoucherService;

// 1. Initialisation Container & Services Core
$container = new Container();
$pdo = Database::getInstance();

$logger = new LoggerService($pdo);
ExceptionHandler::register($logger);

$cache = new CacheService();
$settingsRepo = new PdoSettingsRepository($pdo);
$settingsService = new SettingsService($settingsRepo, $cache);
$analyticsService = new AnalyticsService($pdo);
$fraudService = new FraudDetectionService($pdo, $logger);
$downloadService = new DownloadService($pdo);
$stripeService = new StripeService();
$pricingService = new PricingEstimationService();
$localServiceRepo = new PdoLocalServiceRepository($pdo);
$bookingScheduleRepo = new PdoBookingScheduleRepository($pdo);
$reviewRepo = new PdoReviewRepository($pdo);
$reviewService = new ReviewService($reviewRepo);
$voucherService = new PassVoucherService();

// 2. Liaisons Repositories (DI Container)
$container->bind(ArticleRepositoryInterface::class, fn() => new PdoArticleRepository($pdo));
$container->bind(OrderRepositoryInterface::class, fn() => new PdoOrderRepository($pdo));
$container->bind(ProductRepositoryInterface::class, fn() => new PdoProductRepository($pdo));
$container->bind(LocalServiceRepositoryInterface::class, fn() => $localServiceRepo);
$container->bind(BookingScheduleRepositoryInterface::class, fn() => $bookingScheduleRepo);
$container->bind(ReviewRepositoryInterface::class, fn() => $reviewRepo);
$container->bind(SettingsRepositoryInterface::class, fn() => $settingsRepo);
$container->bind(CacheInterface::class, fn() => $cache);
$container->bind(SettingsService::class, fn() => $settingsService);
$container->bind(AnalyticsService::class, fn() => $analyticsService);
$container->bind(FraudDetectionService::class, fn() => $fraudService);
$container->bind(DownloadService::class, fn() => $downloadService);
$container->bind(StripeService::class, fn() => $stripeService);
$container->bind(PricingEstimationService::class, fn() => $pricingService);
$container->bind(ReviewService::class, fn() => $reviewService);
$container->bind(PassVoucherService::class, fn() => $voucherService);

// 3. Configuration des Routes
$router = new Router();

// Routes Publiques
$router->get('/', [App\Controllers\HomeController::class, 'index']);
$router->get('/services', [App\Controllers\LocalServicesController::class, 'index']);
$router->post('/api/services/estimate', [App\Controllers\LocalServicesController::class, 'estimate']);
$router->post('/api/services/checkout', [App\Controllers\LocalServicesController::class, 'checkout']);
$router->get('/reservation/planning/{orderNumber}', [App\Controllers\LocalServicesController::class, 'planning']);
$router->get('/pass/voucher/{orderNumber}', [App\Controllers\LocalServicesController::class, 'voucher']);
$router->post('/api/services/update-schedule', [App\Controllers\LocalServicesController::class, 'updateSchedule']);
$router->post('/api/services/update-airport', [App\Controllers\LocalServicesController::class, 'updateAirport']);

// SEO & Indexation Routes
$router->get('/sitemap.xml', [App\Controllers\SitemapController::class, 'sitemap']);
$router->get('/robots.txt', [App\Controllers\SitemapController::class, 'robots']);

$router->get('/guide', [App\Controllers\GuideController::class, 'index']);
$router->get('/guide/{slug}', [App\Controllers\GuideController::class, 'show']);
$router->get('/destinations/{slug}', [App\Controllers\DestinationController::class, 'show']);
$router->get('/shop', [App\Controllers\ShopController::class, 'index']);
$router->get('/concierge', [App\Controllers\ConciergeController::class, 'index']);
$router->post('/api/checkout/session', [App\Controllers\CheckoutController::class, 'createSession']);
$router->get('/checkout/success', [App\Controllers\CheckoutController::class, 'success']);
$router->get('/download', [App\Controllers\DownloadController::class, 'getFile']);

// Nouvelles Pages d'Information & Formulaires
$router->get('/a-propos', [App\Controllers\PageController::class, 'about']);
$router->get('/contact', [App\Controllers\PageController::class, 'contact']);
$router->post('/contact', [App\Controllers\PageController::class, 'contact']);
$router->get('/politique-de-confidentialite', [App\Controllers\PageController::class, 'privacy']);
$router->get('/divulgation-affiliation', [App\Controllers\PageController::class, 'affiliateDisclosure']);
$router->get('/newsletter', [App\Controllers\PageController::class, 'newsletter']);
$router->post('/newsletter', [App\Controllers\PageController::class, 'newsletter']);
$router->get('/faq', [App\Controllers\PageController::class, 'faq']);
$router->get('/activites', [App\Controllers\PageController::class, 'activities']);
$router->get('/itineraires', [App\Controllers\PageController::class, 'itineraries']);
$router->get('/avis', [App\Controllers\PageController::class, 'reviews']);
$router->get('/hotels-restaurants', [App\Controllers\PageController::class, 'hotelsRestaurants']);
$router->get('/meteo-climat', [App\Controllers\PageController::class, 'meteo']);
$router->get('/transports', [App\Controllers\PageController::class, 'transports']);
$router->get('/gastronomie', [App\Controllers\PageController::class, 'gastronomie']);

// Routes Administration
$router->get('/admin/login', [App\Controllers\Admin\AuthController::class, 'login']);
$router->post('/admin/login', [App\Controllers\Admin\AuthController::class, 'login']);
$router->get('/admin/logout', [App\Controllers\Admin\AuthController::class, 'logout']);
$router->get('/admin/dashboard', [App\Controllers\Admin\DashboardController::class, 'index']);
$router->get('/admin/services-bookings', [App\Controllers\Admin\ServicesAdminController::class, 'index']);
$router->post('/api/admin/services/transfer-status', [App\Controllers\Admin\ServicesAdminController::class, 'updateTransfer']);
$router->get('/admin/settings', [App\Controllers\Admin\SettingsAdminController::class, 'index']);
$router->post('/admin/settings', [App\Controllers\Admin\SettingsAdminController::class, 'index']);
$router->get('/admin/analytics', [App\Controllers\Admin\AnalyticsAdminController::class, 'index']);
$router->get('/admin/audit', [App\Controllers\Admin\AuditAdminController::class, 'index']);

// Dispatch de la requête HTTP
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $container);