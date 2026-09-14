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
        $baseDir = rtrim(dirname($scriptName), '/\\');
        
        $prefix = ($baseDir && $baseDir !== '/' && $baseDir !== '\\') ? $baseDir : '';

        return $prefix . '/assets/' . $cleanPath . '?v=' . $v;
    }
}

if (!function_exists('url')) {
    function url(string $path = ''): string {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $baseDir = rtrim(dirname($scriptName), '/\\');
        $prefix = ($baseDir && $baseDir !== '/' && $baseDir !== '\\') ? $baseDir : '';
        return $prefix . '/' . ltrim($path, '/');
    }
}

if (!function_exists('e')) {
    function e(?string $value): string {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}
