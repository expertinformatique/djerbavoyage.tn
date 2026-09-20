<?php
function cleanAndCropToLandscape(string $filePath, string $destPath): bool {
    if (!extension_loaded('gd') || !file_exists($filePath)) {
        return false;
    }
    
    $srcImg = @imagecreatefromstring(file_get_contents($filePath));
    if (!$srcImg) return false;
    
    $origW = imagesx($srcImg);
    $origH = imagesy($srcImg);
    
    // Watermark is located in the bottom 30px
    // Crop to 16:9 ratio centered vertically/horizontally, avoiding bottom 35px
    $safeH = $origH - 35;
    
    $targetRatio = 16 / 9;
    
    // Determine crop dimensions
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
    
    // Create new HD 1200x675 image
    $dstW = 1200;
    $dstH = 675;
    $dstImg = imagecreatetruecolor($dstW, $dstH);
    
    imagecopyresampled($dstImg, $srcImg, 0, 0, $cropX, $cropY, $dstW, $dstH, $cropW, $cropH);
    
    imagejpeg($dstImg, $destPath, 92);
    
    imagedestroy($srcImg);
    imagedestroy($dstImg);
    return true;
}

$ok = cleanAndCropToLandscape(__DIR__ . '/menzel_unesco_prod.jpg', __DIR__ . '/menzel_cropped.jpg');
echo "Crop result: " . ($ok ? "SUCCESS" : "FAILED") . "\n";
if ($ok) {
    echo "Cropped size: " . filesize(__DIR__ . '/menzel_cropped.jpg') . " bytes\n";
}
