<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';

$runnerCode = <<<'PHP'
<?php
set_time_limit(120);
$seed = mt_rand(1000, 99999);
$pollUrl = "https://image.pollinations.ai/prompt/" . rawurlencode("Photorealistic DSLR photograph of Kitesurf on turquoise lagoon in Djerba Tunisia") . "?seed=" . $seed;
echo "Calling Pollinations with 60s timeout...\nURL: $pollUrl\n";
$start = microtime(true);
$ch = curl_init($pollUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$bin = curl_exec($ch);
$pCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$pErr = curl_error($ch);
$pDur = round(microtime(true) - $start, 2);
curl_close($ch);

echo "Result => HTTP $pCode | Err: $pErr | Time: {$pDur}s | Len: " . strlen($bin) . "\n";
if ($pCode === 200 && strlen($bin) > 5000) {
    echo "SUCCESS! Image received successfully on production server!\n";
}
PHP;

$remoteUrl = "ftp://{$ftpHost}/djerbavoyage.tn/public/timeout_test_prod.php";

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

echo "Uploaded timeout test. Executing...\n";
$start = microtime(true);
$out = file_get_contents("https://djerbavoyage.tn/timeout_test_prod.php");
$dur = round(microtime(true) - $start, 2);
echo "Output (in {$dur}s):\n" . $out . "\n";

// Cleanup
$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_QUOTE, ["DELE /djerbavoyage.tn/public/timeout_test_prod.php"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
