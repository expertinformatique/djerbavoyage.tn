<?php
require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/../core/helpers.php";

$rootPath = dirname(__DIR__);
if (file_exists($rootPath . '/.env')) {
    foreach (file($rootPath . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (strpos($line, '=') !== false && strpos(trim($line), '#') !== 0) {
            list($k, $v) = explode('=', $line, 2);
            putenv(trim($k) . '=' . trim($v, " \t\n\r\0\x0B\"'"));
            $_ENV[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
        }
    }
}
require_once __DIR__ . "/../src/Services/NanoBananaImageService.php";

$service = new App\Services\NanoBananaImageService();
$rootPath = dirname(__DIR__);

echo "Service enabled: " . ($service->isEnabled() ? "YES" : "NO") . "
";
echo "Model: " . $service->getModel() . "
";

$prompt = "Dynamic kitesurfer catching air above shallow translucent turquoise lagoon in Djerba Tunisia, vibrant kite canopy against deep blue sky, sunlit spray";
$slug = "test-live-nano-" . time();

$res = $service->generate($prompt, $slug, $rootPath);
echo "Result: " . var_export($res, true) . "
";

if ($res && file_exists($rootPath . "/public/" . $res)) {
    echo "File size: " . filesize($rootPath . "/public/" . $res) . " bytes
";
    echo "MD5: " . md5_file($rootPath . "/public/" . $res) . "
";
}
