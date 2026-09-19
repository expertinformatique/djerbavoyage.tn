<?php
namespace App\Services;

class DjerbaStoryFallbackService {
    public function generate(array $context): array {
        $weather = $context['weather'] ?? ['temp_c' => 28, 'condition' => 'Ensoleillé'];
        $angle = $context['angle'] ?? [];
        $key = $this->resolveAngleKey($angle);
        $story = DjerbaStoryDataProvider::getStory($key, $weather);

        $contentHtml = $this->buildFullContentHtml($story, $context);

        return [
            'title_fr' => $story['title_fr'],
            'title_en' => $story['title_en'],
            'content_fr' => $contentHtml,
            'content_en' => "<p>{$story['lead']}</p><p>Explore authentic traditions, guided excursions and curated heritage tours in Djerba, Tunisia. Current temperature: {$weather['temp_c']}°C.</p>",
            'seo_description' => $story['seo_description'],
            'meta_keywords' => implode(', ', $angle['keywords'] ?? ['djerba', 'tourisme tunisie', 'guide voyage']),
            'summary_ai' => "• Points clés : Immersion détaillée sur les traditions et circuits à Djerba.\n• Météo en direct : {$weather['temp_c']}°C sous un soleil radieux.\n• Conseils pratiques, tarifs indicatifs et réservation en ligne sécurisée.",
            'image_prompt' => $angle['image_prompt'] ?? 'high resolution authentic travel photography of Djerba Tunisia',
            'facebook_text' => "🌴 {$story['title_fr']} !\n\n" . substr($story['lead'], 0, 180) . "...\n\n💬 Et vous, quelle est votre activité préférée à Djerba ? Dites-le nous en commentaire !",
            'cta_services' => $angle['suggested_services'] ?? ['excursion-quad-djerba', 'visite-guidee-djerba']
        ];
    }

    public function resolveAngleKey(array $angle): string {
        if (!empty($angle['key'])) return $angle['key'];
        $t = strtolower($angle['theme'] ?? '');
        if (str_contains($t, 'potier') || str_contains($t, 'guellala')) return 'pottery_heritage';
        if (str_contains($t, 'quad') || str_contains($t, 'sahara') || str_contains($t, 'desert') || str_contains($t, 'ghilane')) return 'desert_adventure';
        return 'menzel_architecture';
    }

    private function buildFullContentHtml(array $story, array $context): string {
        $html = "<p class='lead'>{$story['lead']}</p>";

        foreach ($story['sections'] as $s) {
            $html .= "<h2>{$s['title']}</h2>";
            $html .= "<p>{$s['body']}</p>";
        }

        // Tableau comparatif structuré (critère Google Helpful Content & EEAT)
        if (!empty($story['table_rows'])) {
            $html .= "<h2>Comparatif des formules, durées et tarifs indicatifs</h2>";
            $html .= "<div class='table-responsive'><table class='c-article-table'><thead><tr>";
            foreach ($story['table_headers'] as $th) {
                $html .= "<th>" . htmlspecialchars($th, ENT_QUOTES, 'UTF-8') . "</th>";
            }
            $html .= "</tr></thead><tbody>";
            foreach ($story['table_rows'] as $row) {
                $html .= "<tr>";
                foreach ($row as $cell) {
                    $html .= "<td>" . htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') . "</td>";
                }
                $html .= "</tr>";
            }
            $html .= "</tbody></table></div>";
        }

        // Encadré astuce de terrain
        if (!empty($story['tip'])) {
            $html .= "<div class='c-article-tip'><blockquote>💡 <strong>Le conseil de l'équipe Djerba Voyage :</strong> {$story['tip']}</blockquote></div>";
        }

        // Section FAQ
        if (!empty($story['faq'])) {
            $html .= "<h2>Questions fréquentes posées par les voyageurs</h2>";
            $html .= "<div class='c-article-faq'>";
            foreach ($story['faq'] as $faq) {
                $html .= "<h3>" . htmlspecialchars($faq[0], ENT_QUOTES, 'UTF-8') . "</h3>";
                $html .= "<p>" . htmlspecialchars($faq[1], ENT_QUOTES, 'UTF-8') . "</p>";
            }
            $html .= "</div>";
        }

        // Maillage interne & Appel à l'action vers les services payants
        $ctaUrl = $story['cta_url'] ?? 'https://djerbavoyage.tn/services';
        $ctaText = $story['cta_text'] ?? 'Réserver vos activités à Djerba';
        $html .= "<h2>Organiser votre séjour sur-mesure à Djerba</h2>";
        $html .= "<p>Pour vivre cette expérience en toute sérénité, confiez vos réservations à des partenaires locaux certifiés. Notre équipe est à votre disposition pour planifier vos transferts VIP et circuits privés sur l'île.</p>";
        $html .= "<div class='c-article-cta-box'><p>👉 <a href='{$ctaUrl}' class='btn-cta'><strong>{$ctaText}</strong></a> ou consultez l'ensemble de notre <a href='https://djerbavoyage.tn/services'>catalogue d'excursions & activités à Djerba</a>.</p></div>";

        return $html;
    }
}
