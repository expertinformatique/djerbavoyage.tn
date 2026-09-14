<?php
namespace App\Controllers;

use Core\Controller;
use App\Services\AnalyticsService;
use App\Services\SettingsService;
use Core\Security;

class PageController extends Controller {
    public function __construct(
        private SettingsService $settings,
        private AnalyticsService $analytics
    ) {}

    public function about(): void {
        $this->analytics->trackPageView('/a-propos');
        $this->render('pages/about', [
            'seoTitle'       => 'À Propos de Djerba Voyage | Notre Histoire & Mission',
            'seoDescription' => 'Découvrez qui nous sommes : une équipe de passionnés de Djerba dédiée aux itinéraires authentiques et aux guides éco-responsables.',
            'settings'       => $this->settings
        ]);
    }

    public function contact(): void {
        $this->analytics->trackPageView('/contact');
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = Security::sanitize($_POST['name'] ?? '');
            $email = Security::sanitize($_POST['email'] ?? '');
            $message = Security::sanitize($_POST['message'] ?? '');

            if ($name && $email && $message) {
                $success = "Merci " . $name . ", votre message a bien été envoyé ! Nous vous répondrons sous 24h.";
            }
        }

        $this->render('pages/contact', [
            'seoTitle'       => 'Contactez-nous | Djerba Voyage',
            'seoDescription' => 'Une question sur nos guides PDF ou notre conciergerie ? Écrivez-nous directement.',
            'success'        => $success,
            'settings'       => $this->settings
        ]);
    }

    public function privacy(): void {
        $this->analytics->trackPageView('/politique-de-confidentialite');
        $this->render('pages/privacy', [
            'seoTitle'       => 'Politique de Confidentialité & RGPD | Djerba Voyage',
            'seoDescription' => 'Engagement de confidentialité, données personnelles et conformité RGPD de la plateforme Djerba Voyage.',
            'settings'       => $this->settings
        ]);
    }

    public function affiliateDisclosure(): void {
        $this->analytics->trackPageView('/divulgation-affiliation');
        $this->render('pages/affiliate-disclosure', [
            'seoTitle'       => 'Transparence & Divulgation d\'Affiliation | Djerba Voyage',
            'seoDescription' => 'Informations légales sur notre modèle économique d\'affiliation (Booking.com, GetYourGuide, Viator).',
            'settings'       => $this->settings
        ]);
    }

    public function newsletter(): void {
        $this->analytics->trackPageView('/newsletter');
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = Security::sanitize($_POST['email'] ?? '');
            if ($email) {
                $success = "Félicitations ! Vous êtes inscrit à la newsletter Djerba Voyage. Un e-mail de confirmation vous a été envoyé.";
            }
        }

        $this->render('pages/newsletter', [
            'seoTitle'       => 'Inscription Newsletter Djerba | Bons Plans & Guides Inédits',
            'seoDescription' => 'Recevez nos meilleurs bons plans, promotions secrètes d\'hôtels et nouveaux guides sur Djerba.',
            'success'        => $success,
            'settings'       => $this->settings
        ]);
    }

    public function faq(): void {
        $this->analytics->trackPageView('/faq');
        $this->render('pages/faq', [
            'seoTitle'       => 'Foire Aux Questions (FAQ) | Djerba Voyage',
            'seoDescription' => 'Toutes les réponses à vos questions sur Djerba : climat, transports, guides PDF et conciergerie VIP.',
            'settings'       => $this->settings
        ]);
    }

    public function activities(): void {
        $this->analytics->trackPageView('/activites');
        $this->render('pages/activities', [
            'seoTitle'       => 'Les Meilleures Activités et Excursions à Djerba 2026',
            'seoDescription' => 'Kitesurf, balade en quad dans les dunes, sortie en bateau pirate à Île aux Flamingos, visite guidée de Djerbahood.',
            'settings'       => $this->settings
        ]);
    }

    public function itineraries(): void {
        $this->analytics->trackPageView('/itineraires');
        $this->render('pages/itineraires', [
            'seoTitle'       => 'Itinéraires Sur-Mesure 3, 5 et 7 Jours à Djerba',
            'seoDescription' => 'Découvrez nos circuits optimisés pour explorer Djerba au meilleur rythme : culture, plages, gastronomie et souks.',
            'settings'       => $this->settings
        ]);
    }

    public function reviews(): void {
        $this->analytics->trackPageView('/avis');
        $this->render('pages/reviews', [
            'seoTitle'       => 'Avis Voyageurs & Témoignages Clients | Djerba Voyage',
            'seoDescription' => 'Lisez les avis vérifiés de nos voyageurs sur nos guides PDF et nos prestations de conciergerie privée.',
            'settings'       => $this->settings
        ]);
    }

    public function hotelsRestaurants(): void {
        $this->analytics->trackPageView('/hotels-restaurants');
        $this->render('pages/hotels-restaurants', [
            'seoTitle'       => 'Hôtels de Charme, Ryads & Meilleurs Restaurants à Djerba 2026',
            'seoDescription' => 'Sélection exclusive des plus beaux hôtels, menzels traditionnels et tables gastronomiques secrètes à Djerba.',
            'settings'       => $this->settings
        ]);
    }

    public function meteo(): void {
        $this->analytics->trackPageView('/meteo-climat');
        $this->render('pages/meteo-climat', [
            'seoTitle'       => 'Météo, Climat & Quand Partir à Djerba | Guide 2026',
            'seoDescription' => 'Températures mensuelles, météo de l\'eau et prévisions pour planifier votre voyage à Djerba.',
            'settings'       => $this->settings
        ]);
    }

    public function transports(): void {
        $this->analytics->trackPageView('/transports');
        $this->render('pages/transports', [
            'seoTitle'       => 'Transports, Taxis & Location de Voiture à Djerba',
            'seoDescription' => 'Comment se déplacer facilement à Djerba : taxis jaunes, loueurs de voiture fiables et bac d\'Ajim.',
            'settings'       => $this->settings
        ]);
    }

    public function gastronomie(): void {
        $this->analytics->trackPageView('/gastronomie');
        $this->render('pages/gastronomie', [
            'seoTitle'       => 'Gastronomie Djerbienne & Spécialités Culinaires',
            'seoDescription' => 'Découvrez les saveurs de Djerba : couscous au poisson, tajines traditionnels et huileries d\'olive.',
            'settings'       => $this->settings
        ]);
    }
}
