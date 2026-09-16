<?php
/**
 * Currency — Gestion multi-devise (EUR / TND / USD)
 * Conversion depuis EUR avec taux de change fixes (configurables).
 * La conversion est faite UNIQUEMENT à l'affichage, jamais en base.
 */
namespace Core;

class Currency
{
    /** Devise par défaut */
    private static string $currency = 'EUR';

    /** Taux de change depuis EUR (mis à jour manuellement) */
    private static array $rates = [
        'EUR' => 1.00,
        'TND' => 3.35,
        'USD' => 1.08,
    ];

    /** Symboles des devises */
    private static array $symbols = [
        'EUR' => '€',
        'TND' => 'DT',
        'USD' => '$',
    ];

    /** Nombre de décimales par devise */
    private static array $decimals = [
        'EUR' => 2,
        'TND' => 3,
        'USD' => 2,
    ];

    /** Position du symbole : true = avant, false = après */
    private static array $symbolBefore = [
        'EUR' => false,
        'TND' => false,
        'USD' => true,
    ];

    /** Devises supportées */
    private static array $supported = ['EUR', 'TND', 'USD'];

    /** Initialise la devise depuis la session */
    public static function boot(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $currency = $_SESSION['currency'] ?? $_COOKIE['dv_currency'] ?? 'EUR';
        self::setCurrency(in_array($currency, self::$supported, true) ? $currency : 'EUR');
    }

    /** Change la devise active */
    public static function setCurrency(string $currency): void
    {
        if (!in_array($currency, self::$supported, true)) {
            $currency = 'EUR';
        }
        self::$currency = $currency;
    }

    /** Retourne la devise courante */
    public static function getCurrency(): string
    {
        return self::$currency;
    }

    /** Retourne le symbole de la devise courante */
    public static function getSymbol(string $currency = null): string
    {
        $c = $currency ?? self::$currency;
        return self::$symbols[$c] ?? $c;
    }

    /**
     * Convertit un montant depuis EUR et le formate.
     *
     * @param float  $amountEur Montant en EUR (tel que stocké en DB)
     * @param string|null $currency Devise cible (null = devise active)
     */
    public static function format(float $amountEur, string $currency = null): string
    {
        $c       = $currency ?? self::$currency;
        $rate    = self::$rates[$c] ?? 1.0;
        $dec     = self::$decimals[$c] ?? 2;
        $symbol  = self::$symbols[$c] ?? $c;
        $before  = self::$symbolBefore[$c] ?? false;

        $converted = $amountEur * $rate;
        $formatted = number_format($converted, $dec, '.', ' ');

        return $before
            ? $symbol . ' ' . $formatted
            : $formatted . ' ' . $symbol;
    }

    /** Convertit seulement (retourne un float) */
    public static function convert(float $amountEur, string $currency = null): float
    {
        $c    = $currency ?? self::$currency;
        $rate = self::$rates[$c] ?? 1.0;
        return round($amountEur * $rate, self::$decimals[$c] ?? 2);
    }

    /** Retourne la liste des devises supportées */
    public static function supported(): array
    {
        return self::$supported;
    }

    /** Retourne les taux de change courants (pour injection JS) */
    public static function rates(): array
    {
        return self::$rates;
    }

    /** Retourne le nom complet d'une devise */
    public static function name(string $currency): string
    {
        return match ($currency) {
            'EUR' => 'Euro',
            'TND' => 'Dinar Tunisien',
            'USD' => 'US Dollar',
            default => $currency,
        };
    }
}
