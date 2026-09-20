<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';

$runnerCode = <<<'PHP'
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$prompt = "Photorealistic DSLR photograph of Aventure en Quad à Djerba : Entre les Dunes d'Aghir et les Pistes Sauvages in Djerba, Tunisia";
$cleanPrompt = preg_replace('/[#()\[\]{}]/', ' ', $prompt);
$cleanPrompt = trim(preg_replace('/\s+/', ' ', $cleanPrompt));
$seed = mt_rand(10000, 999999);
$url = "https://image.pollinations.ai/prompt/" . rawurlencode($cleanPrompt) . "?seed=" . $seed;

echo "URL: $url\n";
$start = microtime(true);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$binary = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$err = curl_error($ch);
$dur = round(microtime(true) - $start, 2);
curl_close($ch);

echo "Code: $code | Err: $err | Time: {$dur}s | Len: " . strlen($binary) . "\n";
PHP;

$remoteUrl = "ftp://{$ftpHost}/djerbavoyage.tn/public/test_quad_curl.php";

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

$res = file_get_contents("https://djerbavoyage.tn/test_quad_curl.php");
echo $res . "\n";

// Cleanup
$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_QUOTE, ["DELE /djerbavoyage.tn/public/test_quad_curl.php"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
