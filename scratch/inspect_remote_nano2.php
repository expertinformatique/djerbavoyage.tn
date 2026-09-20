<?php
$lines = explode("\n", file_get_contents('ftp://ftp.invoices.tn/djerbavoyage.tn/src/Services/NanoBananaImageService.php'));
for ($i = 135; $i <= 165; $i++) {
    if (isset($lines[$i])) echo ($i+1) . ': ' . $lines[$i] . "\n";
}
