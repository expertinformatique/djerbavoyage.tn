<?php
/**
 * LocaleController — Gestion de la langue et de la devise
 * Route : POST /api/locale
 * Stocke les préférences en session + cookie (30 jours) et redirige.
 */
namespace App\Controllers;

use Core\Controller;

class LocaleController extends Controller
{
    private const SUPPORTED_LANGS      = ['fr', 'en', 'ar'];
    private const SUPPORTED_CURRENCIES = ['EUR', 'TND', 'USD'];
    private const COOKIE_TTL           = 30 * 24 * 3600; // 30 jours

    public function switch(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $lang     = $_POST['lang']     ?? $_SESSION['lang']     ?? 'fr';
        $currency = $_POST['currency'] ?? $_SESSION['currency'] ?? 'EUR';

        // Validation
        if (!in_array($lang, self::SUPPORTED_LANGS, true)) {
            $lang = 'fr';
        }
        if (!in_array($currency, self::SUPPORTED_CURRENCIES, true)) {
            $currency = 'EUR';
        }

        // Stockage session
        $_SESSION['lang']     = $lang;
        $_SESSION['currency'] = $currency;

        // Persistance cookie
        $cookieParams = [
            'expires'  => time() + self::COOKIE_TTL,
            'path'     => '/',
            'secure'   => isset($_SERVER['HTTPS']),
            'httponly' => true,
            'samesite' => 'Lax',
        ];
        setcookie('dv_lang',     $lang,     $cookieParams);
        setcookie('dv_currency', $currency, $cookieParams);

        // Redirection vers la page précédente
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        $this->redirect($referer);
    }
}
