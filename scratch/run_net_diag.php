<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';

$runnerCode = <<<'PHP'
<?php
echo "DNS check for image.pollinations.ai:\n";
$ip = gethostbyname('image.pollinations.ai');
echo "Resolved IP: $ip\n";

echo "Testing port 443 connect to $ip:\n";
$fp = @fsockopen($ip, 443, $errno, $errstr, 5);
if ($fp) {
    echo "Port 443 OPEN!\n";
    fclose($fp);
} else {
    echo "Port 443 CONNECT FAILED: $errno - $errstr\n";
}

echo "\nTesting other image generation APIs:\n";
$tests = [
    'https://lexica.art/api/v1/search?q=djerba',
    'https://picsum.photos/200/300',
    'https://images.unsplash.com',
    'https://api.github.com'
];
foreach ($tests as $t) {
    $ch = curl_init($t);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    $res = curl_exec($ch);
    $c = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $e = curl_error($ch);
    curl_close($ch);
    echo "$t => Code: $c, Err: $e\n";
}
PHP;

$remoteUrl = "ftp://{$ftpHost}/djerbavoyage.tn/public/net_diag_prod.php";

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

$out = file_get_contents("https://djerbavoyage.tn/net_diag_prod.php");
echo $out . "\n";

// Cleanup
$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_QUOTE, ["DELE /djerbavoyage.tn/public/net_diag_prod.php"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
