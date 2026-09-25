<?php
/**
 * Lang — Service de localisation (FR / EN / AR)
 * Charge les fichiers lang/*.php et expose les traductions.
 */
namespace Core;

class Lang
{
    private static string $locale    = 'fr';
    private static array  $messages  = [];
    private static array  $supported = ['fr', 'en', 'ar'];

    /** Initialise la langue depuis l'URL, la session ou le cookie */
    public static function boot(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $requestedLang = $_GET['lang'] ?? null;
        if ($requestedLang && in_array($requestedLang, self::$supported, true)) {
            $_SESSION['lang'] = $requestedLang;
            if (!headers_sent()) {
                setcookie('dv_lang', $requestedLang, [
                    'expires'  => time() + (30 * 24 * 3600),
                    'path'     => '/',
                    'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]);
            }
        }

        $lang = $_SESSION['lang'] ?? $_COOKIE['dv_lang'] ?? 'fr';
        self::setLocale(in_array($lang, self::$supported, true) ? $lang : 'fr');
    }

    /** Change la locale active et recharge les messages */
    public static function setLocale(string $locale): void
    {
        if (!in_array($locale, self::$supported, true)) {
            $locale = 'fr';
        }
        self::$locale = $locale;

        $file = ROOT_PATH . '/lang/' . $locale . '.php';
        if (file_exists($file)) {
            self::$messages = require $file;
        } else {
            self::$messages = [];
        }
    }

    /** Retourne la locale courante */
    public static function getLocale(): string
    {
        return self::$locale;
    }

    /** Retourne la direction du texte : 'rtl' pour l'arabe, 'ltr' sinon */
    public static function getDir(): string
    {
        return self::$locale === 'ar' ? 'rtl' : 'ltr';
    }

    /** Retourne true si la langue active est RTL */
    public static function isRtl(): bool
    {
        return self::$locale === 'ar';
    }

    /**
     * Traduit une clé.
     * Supporte les placeholders : __('hello.name', ['name' => 'Ahmed'])
     */
    public static function t(string $key, array $replace = []): string
    {
        $line = self::$messages[$key] ?? $key;

        if (!empty($replace)) {
            foreach ($replace as $search => $value) {
                $line = str_replace(':' . $search, (string) $value, $line);
            }
        }

        return $line;
    }

    /** Retourne la liste des langues supportées */
    public static function supported(): array
    {
        return self::$supported;
    }

    /** Retourne le nom natif d'une locale */
    public static function nativeName(string $locale): string
    {
        return match ($locale) {
            'fr' => 'Français',
            'en' => 'English',
            'ar' => 'العربية',
            default => $locale,
        };
    }

    /** Retourne l'URL du drapeau SVG */
    public static function flagUrl(string $locale): string
    {
        $code = strtolower(trim($locale));
        $flagFile = match ($code) {
            'fr' => 'fr',
            'en', 'gb' => 'en',
            'ar', 'tn' => 'ar',
            'ie' => 'ie',
            default => 'fr',
        };

        if (function_exists('asset')) {
            return asset('images/flags/' . $flagFile . '.svg');
        }

        return '/assets/images/flags/' . $flagFile . '.svg';
    }

    /** Retourne le balisage HTML complet de l'icône de drapeau */
    public static function flag(string $locale, int $width = 20, int $height = 14): string
    {
        $code = strtolower(trim($locale));
        $url = self::flagUrl($code);
        $alt = strtoupper($code);

        return sprintf(
            '<img src="%s" alt="%s" class="c-flag" width="%d" height="%d" loading="lazy">',
            htmlspecialchars($url, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($alt, ENT_QUOTES, 'UTF-8'),
            $width,
            $height
        );
    }

    /** Retourne le drapeau emoji (fallback) */
    public static function flagEmoji(string $locale): string
    {
        return match (strtolower(trim($locale))) {
            'fr' => '🇫🇷',
            'en', 'gb' => '🇬🇧',
            'ar', 'tn' => '🇹🇳',
            'ie' => '🇮🇪',
            default => '🌐',
        };
    }
}

