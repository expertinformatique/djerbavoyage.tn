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

    /** Initialise la langue depuis la session */
    public static function boot(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
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

    /** Retourne le drapeau emoji d'une locale */
    public static function flag(string $locale): string
    {
        return match ($locale) {
            'fr' => '🇫🇷',
            'en' => '🇬🇧',
            'ar' => '🇹🇳',
            default => '🌐',
        };
    }
}
