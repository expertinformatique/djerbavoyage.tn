<?php
namespace App\Services;

class TextImageBannerService {
    public function generateBanner(string $title, string $category = 'Djerba Voyage', string $format = '16:9', ?string $bgImage = null): string {
        $width = ($format === '9:16') ? 1080 : 1200;
        $height = ($format === '9:16') ? 1920 : 675;

        $img = imagecreatetruecolor($width, $height);
        imagealphablending($img, true);
        imagesavealpha($img, true);

        // Palette moderne méditerranéenne
        $navy = imagecolorallocate($img, 15, 23, 42); // slate-900
        $teal = imagecolorallocate($img, 13, 148, 136); // teal-600
        $emerald = imagecolorallocate($img, 16, 185, 129); // emerald-500
        $white = imagecolorallocate($img, 255, 255, 255);
        $slateLight = imagecolorallocate($img, 226, 232, 240);
        $darkOverlay = imagecolorallocatealpha($img, 10, 15, 30, 45);

        // Fond avec dégradé subtil
        for ($y = 0; $y < $height; $y++) {
            $ratio = $y / $height;
            $r = (int)(15 + $ratio * 10);
            $g = (int)(23 + $ratio * 25);
            $b = (int)(42 + $ratio * 35);
            $col = imagecolorallocate($img, $r, $g, $b);
            imageline($img, 0, $y, $width, $y, $col);
        }

        // Cercles décoratifs d'ambiance
        imagefilledellipse($img, $width - 150, 100, 400, 400, imagecolorallocatealpha($img, 20, 184, 166, 105));
        imagefilledellipse($img, 100, $height - 100, 500, 500, imagecolorallocatealpha($img, 14, 165, 233, 110));

        // Bordure / Carte intérieure
        $cardMargin = ($format === '9:16') ? 60 : 40;
        $cardBg = imagecolorallocatealpha($img, 15, 23, 42, 35);
        imagefilledrectangle($img, $cardMargin, $cardMargin, $width - $cardMargin, $height - $cardMargin, $cardBg);

        // Badge Catégorie
        $badgeText = strtoupper("🌴 " . mb_substr($category, 0, 35));
        $badgeY = $cardMargin + (($format === '9:16') ? 140 : 80);
        imagefilledrectangle($img, $cardMargin + 40, $badgeY - 25, $cardMargin + 40 + (strlen($badgeText) * 11), $badgeY + 12, $teal);
        imagestring($img, 4, $cardMargin + 50, $badgeY - 14, $badgeText, $white);

        // Titre Principal Wrappé
        $wrapped = wordwrap(strip_tags($title), ($format === '9:16') ? 30 : 45, "\n");
        $lines = explode("\n", $wrapped);
        $titleY = $badgeY + 70;

        foreach ($lines as $i => $line) {
            imagestring($img, 5, $cardMargin + 40, $titleY + ($i * 35), trim($line), $white);
            imagestring($img, 5, $cardMargin + 41, $titleY + ($i * 35), trim($line), $white); // Bold simulation
        }

        // Bas de carte / Signature
        $footerY = $height - $cardMargin - 50;
        imageline($img, $cardMargin + 40, $footerY - 20, $width - $cardMargin - 40, $footerY - 20, $teal);
        imagestring($img, 4, $cardMargin + 40, $footerY, "djerbavoyage.tn", $slateLight);
        imagestring($img, 3, $width - $cardMargin - 220, $footerY + 2, "Guide & Tourisme Djerba", $emerald);

        // Sauvegarde de l'image générée
        $filename = 'banner_' . substr(md5($title . time()), 0, 10) . '.jpg';
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        $outputDir = $rootPath . '/public/assets/images/banners';
        if (!is_dir($outputDir)) {
            @mkdir($outputDir, 0775, true);
        }

        $filePath = $outputDir . '/' . $filename;
        imagejpeg($img, $filePath, 90);
        imagedestroy($img);

        return 'assets/images/banners/' . $filename;
    }
}
