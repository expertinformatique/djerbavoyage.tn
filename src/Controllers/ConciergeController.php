<?php
namespace App\Controllers;

use Core\Controller;
use App\Services\AnalyticsService;
use App\Services\SettingsService;
use App\Services\DownloadService;

class ConciergeController extends Controller {
    public function __construct(
        private SettingsService $settings,
        private AnalyticsService $analytics
    ) {}

    public function index(): void {
        $this->analytics->trackPageView('/concierge');

        $this->render('pages/concierge', [
            'seoTitle'       => 'Conciergerie Djerba | Itinéraire Sur-Mesure',
            'seoDescription' => 'Confiez l\'organisation de votre séjour à Djerba à nos experts locaux.',
            'conciergePrice' => $this->settings->get('concierge_price', '29.00'),
            'settings'       => $this->settings
        ]);
    }
}