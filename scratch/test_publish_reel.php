<?php
// Test complet de publication d'un Reel sur Meta Graph API
$pageId = "136561653049793";
$token = $_ENV['FB_PAGE_ACCESS_TOKEN'] ?? getenv('FB_PAGE_ACCESS_TOKEN') ?: 'YOUR_FACEBOOK_PAGE_ACCESS_TOKEN';

// Télécharger une petite vidéo MP4 d'exemple (nature/plage, libre de droits, 2 secondes, ~300 Ko)
$sampleVideoUrl = "https://www.w3schools.com/html/mov_bbb.mp4";
$localVideo = __DIR__ . '/sample_reel.mp4';

if (!file_exists($localVideo)) {
    echo "Downloading sample MP4 video...\n";
    $vData = file_get_contents($sampleVideoUrl);
    if ($vData) {
        file_put_contents($localVideo, $vData);
        echo "Downloaded " . strlen($vData) . " bytes.\n";
    } else {
        die("Failed to download sample video.\n");
    }
}

$fileSize = filesize($localVideo);
echo "Video size: $fileSize bytes\n";

// ÉTAPE 1 : Initialiser la session Reel
echo "Step 1: Initializing reel upload session...\n";
$ch = curl_init("https://graph.facebook.com/v19.0/{$pageId}/video_reels");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'upload_phase' => 'start',
    'access_token' => $token
]));
$initRes = json_decode(curl_exec($ch), true);
curl_close($ch);

print_r($initRes);
$videoId = $initRes['video_id'] ?? null;
$uploadUrl = $initRes['upload_url'] ?? null;

if (!$videoId || !$uploadUrl) {
    die("Failed to initialize Reel upload session.\n");
}

// ÉTAPE 2 : Uploader le fichier binaire vers l'URL d'upload fournie par Meta
echo "Step 2: Uploading binary video to $uploadUrl ...\n";
$videoData = file_get_contents($localVideo);
$ch = curl_init($uploadUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $videoData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: OAuth {$token}",
    "offset: 0",
    "file_size: {$fileSize}",
    "Content-Type: application/octet-stream"
]);
$uploadRes = curl_exec($ch);
$uploadCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Upload HTTP Code: $uploadCode\n";
echo "Upload Response: $uploadRes\n";

// ÉTAPE 3 : Publier le Reel
echo "Step 3: Publishing the Reel...\n";
$caption = "🌊 Douceur et eaux cristallines à Djerba... Prêt pour une pause au paradis ? 🌴✨\n\n#Djerba #Reels #Tunisie #Voyage #PhotoDjerba";
$ch = curl_init("https://graph.facebook.com/v19.0/{$pageId}/video_reels");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'upload_phase' => 'finish',
    'video_id' => $videoId,
    'video_state' => 'PUBLISHED',
    'description' => $caption,
    'access_token' => $token
]));
$publishRes = curl_exec($ch);
$publishCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Publish HTTP Code: $publishCode\n";
echo "Publish Response: $publishRes\n";
