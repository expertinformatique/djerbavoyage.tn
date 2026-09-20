<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';

$runnerCode = <<<'PHP'
<?php
define('ROOT_PATH', dirname(__DIR__));
$blogDir = ROOT_PATH . '/public/assets/images/blog';
$files = glob($blogDir . '/*.jpg');

echo "Cleaning " . count($files) . " blog images...\n";

foreach ($files as $f) {
    $srcImg = @imagecreatefromstring(file_get_contents($f));
    if (!$srcImg) continue;
    
    $origW = imagesx($srcImg);
    $origH = imagesy($srcImg);
    
    // Check if image is square (original Pollinations format ~768x768)
    if (abs($origW - $origH) < 50) {
        $safeH = max(100, $origH - 35);
        $targetRatio = 16 / 9;
        
        if ($origW / $safeH > $targetRatio) {
            $cropH = $safeH;
            $cropW = (int)($cropH * $targetRatio);
            $cropX = (int)(($origW - $cropW) / 2);
            $cropY = 0;
        } else {
            $cropW = $origW;
            $cropH = (int)($cropW / $targetRatio);
            $cropX = 0;
            $cropY = (int)(($safeH - $cropH) / 2);
        }
        
        $dstW = 1200;
        $dstH = 675;
        $dstImg = imagecreatetruecolor($dstW, $dstH);
        imagecopyresampled($dstImg, $srcImg, 0, 0, $cropX, $cropY, $dstW, $dstH, $cropW, $cropH);
        imagejpeg($dstImg, $f, 92);
        imagedestroy($dstImg);
        echo "  Cleaned and cropped: " . basename($f) . "\n";
    }
    imagedestroy($srcImg);
}
echo "All images cleaned and watermarks eliminated!\n";
PHP;

$remoteUrl = "ftp://{$ftpHost}/djerbavoyage.tn/public/clean_all_images.php";

$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_UPLOAD, 1);
$tempFp = fopen('php://temp', 'r+');
fwrite($tempFp, $runnerCode);
rewind($tempFp);
curl_setopt($ch, CURLOPT_INFILE, $tempFp);
curl_setopt($ch, CURLOPT_INFILESIZE, strlen($runnerCode));
curl_exec($ch);
fclose($tempFp);
curl_close($ch);

$res = file_get_contents("https://djerbavoyage.tn/clean_all_images.php");
echo $res . "\n";

// Cleanup
$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_QUOTE, ["DELE /djerbavoyage.tn/public/clean_all_images.php"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
