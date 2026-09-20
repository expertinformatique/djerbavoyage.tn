<?php
namespace App\Services;

class NanoBananaImageService {
    private string $apiKey;
    private string $model;
    private bool $enabled;
    /** @var callable|null */
    private $httpRequester = null;

    public function __construct(
        ?string $apiKey = null, 
        ?string $model = null, 
        ?bool $enabled = null,
        private ?SettingsService $settingsService = null
    ) {
        $this->apiKey = $apiKey 
            ?? $this->settingsService?->get('nano_banana_api_key')
            ?? $_ENV['NANO_BANANA_API_KEY'] 
            ?? getenv('NANO_BANANA_API_KEY') 
            ?? $_ENV['GEMINI_API_KEY'] 
            ?? getenv('GEMINI_API_KEY') 
            ?? '';
        $this->model = $model 
            ?? $this->settingsService?->get('nano_banana_model')
            ?? $_ENV['NANO_BANANA_MODEL'] 
            ?? getenv('NANO_BANANA_MODEL') 
            ?? 'nano-banana-pro-preview';
        $this->enabled = $enabled 
            ?? filter_var($this->settingsService?->get('nano_banana_enabled', $_ENV['NANO_BANANA_ENABLED'] ?? 'true'), FILTER_VALIDATE_BOOLEAN);
    }

    public function setHttpRequester(?callable $requester): void {
        $this->httpRequester = $requester;
    }

    public function isEnabled(): bool {
        return $this->enabled && !empty($this->apiKey);
    }

    public function getModel(): string {
        return $this->model;
    }

    public function buildPhotorealisticPrompt(string $prompt, array $context = []): string {
        $clean = trim(strip_tags($prompt));
        if (empty($clean)) {
            $clean = $context['angle']['theme'] ?? 'plage et architecture traditionnelle de Djerba';
        }

        return "Photorealistic DSLR photograph of " . $clean . " in Djerba, Tunisia. "
            . "Authentic real-life travel photography, natural bright golden hour sunlight, crisp details, "
            . "authentic Tunisian atmosphere, Mediterranean colors, 35mm lens, sharp focus, 8k resolution, "
            . "real photograph, no illustration, no CGI, no 3D render, no watermark.";
    }

    public function generate(string $prompt, string $slug, string $rootPath, array $context = []): ?string {
        if (!$this->isEnabled()) {
            return null;
        }

        $fullPrompt = $this->buildPhotorealisticPrompt($prompt, $context);
        $modelsToTry = array_unique([$this->model, 'nano-banana-pro-preview', 'gemini-2.5-flash-image', 'gemini-3.1-flash-image']);

        foreach ($modelsToTry as $candidateModel) {
            $imageBinary = $this->requestNanoBananaImage($candidateModel, $fullPrompt, $rootPath);
            if ($imageBinary !== null) {
                return $this->saveImageToDisk($imageBinary, $slug, $rootPath);
            }
        }

        return null;
    }

    private function requestNanoBananaImage(string $model, string $prompt, string $rootPath): ?string {
        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . $this->apiKey;
        $payload = [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ]
        ];

        try {
            $jsonResponse = $this->executePost($endpoint, $payload);
            if (!$jsonResponse) {
                return null;
            }

            $data = json_decode($jsonResponse, true);
            if (isset($data['error'])) {
                $msg = $data['error']['message'] ?? 'Erreur inconnue';
                @error_log("[" . date('Y-m-d H:i:s') . "] [NanoBanana] {$model} erreur: {$msg}" . PHP_EOL, 3, $rootPath . '/error.log');
                return null;
            }

            $parts = $data['candidates'][0]['content']['parts'] ?? [];
            foreach ($parts as $part) {
                if (!empty($part['inlineData']['data'])) {
                    return base64_decode($part['inlineData']['data']);
                }
            }
        } catch (\Throwable $e) {
            @error_log("[" . date('Y-m-d H:i:s') . "] [NanoBanana] Exception: " . $e->getMessage() . PHP_EOL, 3, $rootPath . '/error.log');
        }

        return null;
    }

    private function saveImageToDisk(string $binaryData, string $slug, string $rootPath): ?string {
        $blogDir = $rootPath . '/public/assets/images/blog';
        if (!is_dir($blogDir) && !@mkdir($blogDir, 0777, true) && !is_dir($blogDir)) {
            return null;
        }

        $filename = $slug . '.jpg';
        $fullPath = $blogDir . '/' . $filename;

        if (@file_put_contents($fullPath, $binaryData) !== false) {
            return 'images/blog/' . $filename;
        }

        return null;
    }

    private function executePost(string $url, array $payload): ?string {
        if ($this->httpRequester !== null) {
            return ($this->httpRequester)($url, $payload);
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($code === 200 && $response) ? $response : null;
    }
}
