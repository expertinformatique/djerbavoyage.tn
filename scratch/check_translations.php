<?php
define('ROOT_PATH', __DIR__ . '/..');

$fr = require ROOT_PATH . '/lang/fr.php';
$en = require ROOT_PATH . '/lang/en.php';
$ar = require ROOT_PATH . '/lang/ar.php';

echo "=== KEY COUNTS ===\n";
echo "FR keys: " . count($fr) . "\n";
echo "EN keys: " . count($en) . "\n";
echo "AR keys: " . count($ar) . "\n";

echo "\n=== KEYS IN FR BUT MISSING IN AR ===\n";
$missingInAr = array_diff_key($fr, $ar);
foreach ($missingInAr as $k => $v) {
    echo "  - $k => '$v'\n";
}

echo "\n=== KEYS IN EN BUT MISSING IN AR ===\n";
$missingInArFromEn = array_diff_key($en, $ar);
foreach ($missingInArFromEn as $k => $v) {
    if (!isset($missingInAr[$k])) {
        echo "  - $k => '$v'\n";
    }
}

// Find all __() or Lang::t() in views and controllers
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(ROOT_PATH . '/views'));
$usedKeys = [];
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (preg_match_all('/__\(\s*[\'"]([^\'"]+)[\'"]/', $content, $matches)) {
            foreach ($matches[1] as $k) {
                $usedKeys[$k][] = str_replace(ROOT_PATH, '', $file->getPathname());
            }
        }
        if (preg_match_all('/Lang::t\(\s*[\'"]([^\'"]+)[\'"]/', $content, $matches)) {
            foreach ($matches[1] as $k) {
                $usedKeys[$k][] = str_replace(ROOT_PATH, '', $file->getPathname());
            }
        }
    }
}

// Also check controllers/src
$filesSrc = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(ROOT_PATH . '/src'));
foreach ($filesSrc as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (preg_match_all('/__\(\s*[\'"]([^\'"]+)[\'"]/', $content, $matches)) {
            foreach ($matches[1] as $k) {
                $usedKeys[$k][] = str_replace(ROOT_PATH, '', $file->getPathname());
            }
        }
        if (preg_match_all('/Lang::t\(\s*[\'"]([^\'"]+)[\'"]/', $content, $matches)) {
            foreach ($matches[1] as $k) {
                $usedKeys[$k][] = str_replace(ROOT_PATH, '', $file->getPathname());
            }
        }
    }
}

echo "\n=== KEYS USED IN CODE BUT MISSING IN AR ===\n";
foreach ($usedKeys as $k => $locations) {
    if (!isset($ar[$k])) {
        echo "  - $k (used in " . implode(', ', array_unique($locations)) . ")\n";
    }
}

echo "\n=== KEYS IN AR WITH EMPTY VALUE ===\n";
foreach ($ar as $k => $v) {
    if (trim($v) === '') {
        echo "  - $k (EMPTY)\n";
    }
}
