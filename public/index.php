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

// Chargement automatique des variables d'environnement (.env)
if (file_exists(ROOT_PATH . '/.env')) {
    $envLines = file(ROOT_PATH . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envLines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($name, $val) = explode('=', $line, 2);
            $name = trim($name);
            $val = trim($val, " \t\n\r\0\x0B\"'");
            $_ENV[$name] = $val;
            putenv("{$name}={$val}");
        }
    }
}

require_once __DIR__ . '/../core/helpers.php';

// Autoloading simple pour App\ et Core\
spl_autoload_register(function ($class) {
    $prefixApp  = 'App\\';
    $prefixCore = 'Core\\';
    $baseDir    = __DIR__ . '/../';

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

// Initialisation Localisation (Langue + Devise) — après autoloader
use Core\Lang;
use Core\Currency;
Lang::boot();
Currency::boot();



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
use App\Interfaces\NewsletterRepositoryInterface;
use App\Interfaces\AiLeadRepositoryInterface;
use App\Interfaces\ContactRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\PdoArticleRepository;
use App\Repositories\PdoOrderRepository;
use App\Repositories\PdoProductRepository;
use App\Repositories\PdoSettingsRepository;
use App\Repositories\PdoLocalServiceRepository;
use App\Repositories\PdoBookingScheduleRepository;
use App\Repositories\PdoReviewRepository;
use App\Repositories\PdoNewsletterRepository;
use App\Repositories\PdoAiLeadRepository;
use App\Repositories\PdoContactRepository;
use App\Repositories\PdoUserRepository;
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
use App\Services\AiRecommendationService;
use App\Services\SmtpMailerService;
use App\Services\NewsletterService;
use App\Services\AiLeadService;
use App\Services\ContactService;
use App\Controllers\LocaleController;

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
$stripeService = new StripeService($settingsService);
$pricingService = new PricingEstimationService();
$localServiceRepo = new PdoLocalServiceRepository($pdo);
$bookingScheduleRepo = new PdoBookingScheduleRepository($pdo);
$reviewRepo = new PdoReviewRepository($pdo);
$reviewService = new ReviewService($reviewRepo);
$voucherService = new PassVoucherService();
$aiRecommendationService = new AiRecommendationService();
$newsletterRepo = new PdoNewsletterRepository($pdo);
$smtpMailerService = new SmtpMailerService();
$spamService = new \App\Services\SpamProtectionService($pdo);
$newsletterService = new NewsletterService($newsletterRepo, $smtpMailerService, $spamService);
$aiLeadRepo = new PdoAiLeadRepository($pdo);
$aiLeadService = new AiLeadService($aiLeadRepo, $smtpMailerService, $spamService);
$contactRepo = new PdoContactRepository($pdo);
$contactService = new ContactService($contactRepo, $smtpMailerService, $spamService);

// 2. Liaisons Repositories (DI Container)
$container->bind(ArticleRepositoryInterface::class, fn() => new PdoArticleRepository($pdo));
$container->bind(OrderRepositoryInterface::class, fn() => new PdoOrderRepository($pdo));
$container->bind(ProductRepositoryInterface::class, fn() => new PdoProductRepository($pdo));
$container->bind(LocalServiceRepositoryInterface::class, fn() => $localServiceRepo);
$container->bind(BookingScheduleRepositoryInterface::class, fn() => $bookingScheduleRepo);
$container->bind(ReviewRepositoryInterface::class, fn() => $reviewRepo);
$container->bind(NewsletterRepositoryInterface::class, fn() => $newsletterRepo);
$container->bind(AiLeadRepositoryInterface::class, fn() => $aiLeadRepo);
$container->bind(ContactRepositoryInterface::class, fn() => $contactRepo);
$container->bind(UserRepositoryInterface::class, fn() => new PdoUserRepository($pdo));
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
$container->bind(AiRecommendationService::class, fn() => $aiRecommendationService);
$container->bind(SmtpMailerService::class, fn() => $smtpMailerService);
$container->bind(NewsletterService::class, fn() => $newsletterService);
$container->bind(AiLeadService::class, fn() => $aiLeadService);
$container->bind(ContactService::class, fn() => $contactService);
$personalizedPdfService = new \App\Services\PersonalizedPdfService();
$container->bind(\App\Services\PersonalizedPdfService::class, fn() => $personalizedPdfService);
$container->bind(\App\Services\SpamProtectionService::class, fn() => $spamService);
$articlePdfService = new \App\Services\ArticlePdfService();
$container->bind(\App\Services\ArticlePdfService::class, fn() => $articlePdfService);
$djerbaContextFetcher = new \App\Services\DjerbaContextFetcherService();
$container->bind(\App\Services\DjerbaContextFetcherService::class, fn() => $djerbaContextFetcher);
$aiImageService = new \App\Services\AiImageService();
$container->bind(\App\Services\AiImageService::class, fn() => $aiImageService);
$sitemapService = new \App\Services\SitemapService(new PdoProductRepository($pdo), $localServiceRepo, new PdoArticleRepository($pdo));
$container->bind(\App\Services\SitemapService::class, fn() => $sitemapService);
$facebookPublisher = new \App\Services\FacebookPublisherService($settingsService);
$container->bind(\App\Services\FacebookPublisherService::class, fn() => $facebookPublisher);
$facebookReelPublisher = new \App\Services\FacebookReelPublisherService($settingsService);
$container->bind(\App\Services\FacebookReelPublisherService::class, fn() => $facebookReelPublisher);
$reelVideoProvider = new \App\Services\ReelVideoProviderService();
$container->bind(\App\Services\ReelVideoProviderService::class, fn() => $reelVideoProvider);
$tiktokPublisher = new \App\Services\TikTokPublisherService($settingsService);
$container->bind(\App\Services\TikTokPublisherService::class, fn() => $tiktokPublisher);
$aiArticleGenerator = new \App\Services\AiArticleGeneratorService(
    $djerbaContextFetcher,
    new PdoArticleRepository($pdo),
    $aiImageService,
    $sitemapService,
    $facebookPublisher,
    $facebookReelPublisher,
    $reelVideoProvider,
    $tiktokPublisher
);
$container->bind(\App\Services\AiArticleGeneratorService::class, fn() => $aiArticleGenerator);


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
$router->post('/api/ai-lead/submit', [App\Controllers\AiLeadController::class, 'submit']);
$router->get('/pdf/preview', [App\Controllers\PersonalizedPdfController::class, 'preview']);
$router->post('/api/pdf/personalized-order', [App\Controllers\PersonalizedPdfController::class, 'submitOrder']);
$router->get('/api/auto-blog/generate', [App\Controllers\AutoBlogController::class, 'generate']);
$router->post('/api/auto-blog/generate', [App\Controllers\AutoBlogController::class, 'generate']);

// SEO & Indexation Routes
$router->get('/sitemap.xml', [App\Controllers\SitemapController::class, 'sitemap']);
$router->get('/robots.txt', [App\Controllers\SitemapController::class, 'robots']);

$router->get('/guide', [App\Controllers\GuideController::class, 'index']);
$router->get('/guide/{slug}/pdf', [App\Controllers\GuideController::class, 'pdf']);
$router->get('/guide/{slug}', [App\Controllers\GuideController::class, 'show']);
$router->get('/destinations/{slug}', [App\Controllers\DestinationController::class, 'show']);
$router->get('/shop', [App\Controllers\ShopController::class, 'index']);
$router->get('/shop/{slug}', [App\Controllers\ShopController::class, 'show']);
$router->get('/concierge', [App\Controllers\ConciergeController::class, 'index']);
$router->post('/api/concierge/checkout', [App\Controllers\ConciergeController::class, 'checkout']);
$router->post('/api/checkout/session', [App\Controllers\CheckoutController::class, 'createSession']);
$router->get('/checkout/success', [App\Controllers\CheckoutController::class, 'success']);
$router->get('/download', [App\Controllers\DownloadController::class, 'getFile']);

// Nouvelles Pages d'Information & Formulaires
$router->get('/a-propos', [App\Controllers\PageController::class, 'about']);
$router->get('/contact', [App\Controllers\ContactController::class, 'index']);
$router->post('/contact', [App\Controllers\ContactController::class, 'submit']);
$router->post('/api/contact', [App\Controllers\ContactController::class, 'submit']);
$router->get('/politique-de-confidentialite', [App\Controllers\PageController::class, 'privacy']);
$router->get('/divulgation-affiliation', [App\Controllers\PageController::class, 'affiliateDisclosure']);
$router->get('/newsletter', [App\Controllers\NewsletterController::class, 'index']);
$router->post('/newsletter', [App\Controllers\NewsletterController::class, 'subscribe']);
$router->post('/api/newsletter/subscribe', [App\Controllers\NewsletterController::class, 'subscribe']);
$router->get('/newsletter/unsubscribe/{token}', [App\Controllers\NewsletterController::class, 'unsubscribe']);
$router->get('/faq', [App\Controllers\PageController::class, 'faq']);
$router->get('/activites', [App\Controllers\PageController::class, 'activities']);
$router->get('/itineraires', [App\Controllers\PageController::class, 'itineraries']);
$router->get('/avis', [App\Controllers\PageController::class, 'reviews']);
$router->get('/hotels-restaurants', [App\Controllers\PageController::class, 'hotelsRestaurants']);
$router->get('/meteo-climat', [App\Controllers\PageController::class, 'meteo']);
$router->get('/transports', [App\Controllers\PageController::class, 'transports']);
$router->get('/gastronomie', [App\Controllers\PageController::class, 'gastronomie']);

// Bindings Repository dans le container
$container->bind(\App\Interfaces\ProductRepositoryInterface::class, fn() => new \App\Repositories\PdoProductRepository(\Core\Database::getInstance()));
$container->bind(\App\Interfaces\OrderRepositoryInterface::class, fn() => new \App\Repositories\PdoOrderRepository(\Core\Database::getInstance()));

// Routes Administration
$router->get('/admin/login', [App\Controllers\Admin\AuthController::class, 'login']);
$router->post('/admin/login', [App\Controllers\Admin\AuthController::class, 'login']);
$router->get('/admin/logout', [App\Controllers\Admin\AuthController::class, 'logout']);
$router->get('/admin/dashboard', [App\Controllers\Admin\DashboardController::class, 'index']);
$router->get('/admin/services-bookings', [App\Controllers\Admin\ServicesAdminController::class, 'index']);
$router->post('/api/admin/services/transfer-status', [App\Controllers\Admin\ServicesAdminController::class, 'updateTransfer']);
$router->get('/admin/settings', [App\Controllers\Admin\SettingsAdminController::class, 'index']);
$router->post('/admin/settings', [App\Controllers\Admin\SettingsAdminController::class, 'index']);
$router->get('/admin/tiktok/connect', [App\Controllers\Admin\TikTokAdminController::class, 'connect']);
$router->get('/admin/tiktok/callback', [App\Controllers\Admin\TikTokAdminController::class, 'callback']);
$router->get('/admin/analytics', [App\Controllers\Admin\AnalyticsAdminController::class, 'index']);
$router->get('/admin/newsletter', [App\Controllers\Admin\NewsletterAdminController::class, 'index']);
$router->get('/admin/audit', [App\Controllers\Admin\AuditAdminController::class, 'index']);

// Nouvelles routes pour Produits et Commandes
$router->get('/admin/products', [App\Controllers\Admin\ProductsAdminController::class, 'index']);
$router->get('/admin/products/create', [App\Controllers\Admin\ProductsAdminController::class, 'create']);
$router->post('/admin/products/create', [App\Controllers\Admin\ProductsAdminController::class, 'create']);
$router->get('/admin/products/edit', [App\Controllers\Admin\ProductsAdminController::class, 'edit']);
$router->post('/admin/products/edit', [App\Controllers\Admin\ProductsAdminController::class, 'edit']);
$router->post('/admin/products/delete', [App\Controllers\Admin\ProductsAdminController::class, 'delete']);

$router->get('/admin/orders', [App\Controllers\Admin\OrdersAdminController::class, 'index']);
$router->post('/admin/orders/update-status', [App\Controllers\Admin\OrdersAdminController::class, 'updateStatus']);
$router->get('/api/admin/orders/details', [App\Controllers\Admin\OrdersAdminController::class, 'details']);

// Routes Gestion des Utilisateurs Admin
$router->get('/admin/users', [App\Controllers\Admin\UsersAdminController::class, 'index']);
$router->post('/admin/users/create', [App\Controllers\Admin\UsersAdminController::class, 'create']);
$router->post('/admin/users/update', [App\Controllers\Admin\UsersAdminController::class, 'update']);
$router->post('/admin/users/delete', [App\Controllers\Admin\UsersAdminController::class, 'delete']);

// Routes Gestion des Articles & Blog
$router->get('/admin/articles', [App\Controllers\Admin\ArticlesAdminController::class, 'index']);
$router->get('/admin/articles/create', [App\Controllers\Admin\ArticlesAdminController::class, 'create']);
$router->post('/admin/articles/create', [App\Controllers\Admin\ArticlesAdminController::class, 'create']);
$router->get('/admin/articles/edit', [App\Controllers\Admin\ArticlesAdminController::class, 'edit']);
$router->post('/admin/articles/edit', [App\Controllers\Admin\ArticlesAdminController::class, 'edit']);
$router->post('/admin/articles/delete', [App\Controllers\Admin\ArticlesAdminController::class, 'delete']);
$router->post('/admin/articles/generate-ai', [App\Controllers\Admin\ArticlesAdminController::class, 'generateAi']);

// Route de changement de locale (langue + devise)
$router->post('/api/locale', [LocaleController::class, 'switch']);

// Dispatch de la requête HTTP
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $container);