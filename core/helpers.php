<?php
/**
 * Fonctions Helpers Globales — Djerba Voyage
 */

if (!function_exists('asset')) {
    function asset(string $path): string {
        $cleanPath = ltrim($path, '/');
        if (strpos($cleanPath, 'assets/') === 0) {
            $cleanPath = substr($cleanPath, 7);
        }
        $fullPath = __DIR__ . '/../public/assets/' . $cleanPath;
        $v = file_exists($fullPath) ? filemtime($fullPath) : '1.0.0';

        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $baseDir = str_replace('\\', '/', dirname($scriptName));
        $baseDir = rtrim($baseDir, '/');
        
        $prefix = ($baseDir && $baseDir !== '/') ? $baseDir : '';
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        if ($prefix === '/public' || str_ends_with($prefix, '/public')) {
            if (!str_contains($requestUri, '/public')) {
                $prefix = preg_replace('#/public$#', '', $prefix);
            }
        }

        return rtrim($prefix, '/') . '/assets/' . $cleanPath . '?v=' . $v;
    }
}

if (!function_exists('url')) {
    function url(string $path = ''): string {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $baseDir = str_replace('\\', '/', dirname($scriptName));
        $baseDir = rtrim($baseDir, '/');
        $prefix = ($baseDir && $baseDir !== '/') ? $baseDir : '';
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        if ($prefix === '/public' || str_ends_with($prefix, '/public')) {
            if (!str_contains($requestUri, '/public')) {
                $prefix = preg_replace('#/public$#', '', $prefix);
            }
        }
        return rtrim($prefix, '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('e')) {
    function e(?string $value): string {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Helper de traduction — alias de Core\Lang::t()
 * Usage : __('nav.home') ou __('hello.name', ['name' => 'Ahmed'])
 */
if (!function_exists('__')) {
    function __(string $key, array $replace = []): string {
        return \Core\Lang::t($key, $replace);
    }
}

/**
 * Helper de formatage monétaire — alias de Core\Currency::format()
 * Usage : money(9.90) → "9.90 €" ou "33.17 DT" selon la devise active
 *
 * @param float $amountEur Montant en EUR (tel que stocké en base)
 */
if (!function_exists('money')) {
    function money(float $amountEur): string {
        return \Core\Currency::format($amountEur);
    }
}

