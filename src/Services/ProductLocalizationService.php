<?php
namespace App\Services;

use App\Models\Product;
use Core\Lang;

class ProductLocalizationService {
    /**
     * Dictionnaire de correspondances directes pour les produits clés du catalogue
     */
    private static array $translations = [
        'guide-pdf-personnalise-nom-photo' => [
            'en' => ['title' => '⭐ Personalized PDF Guide with Your Name & Cover Photo', 'desc' => 'Exclusive custom collector guide made with your names, travel dates and dedicated cover photo. Instant download + Free gift at airport.'],
            'ar' => ['title' => '⭐ دليلك السياحي المخصص بصيغة PDF مع اسمك وصورة الغلاف', 'desc' => 'إصدار تذكاري حصري يُصمم خصيصاً بأسماء المسافرين وتواريخ الإقامة. تحميل فوري وقسيمة هدية بمطار جربة.']
        ],
        'guide-djerba-pdf' => [
            'en' => ['title' => 'Official Djerba Guide 2026 PDF', 'desc' => 'Complete digital travel guide: interactive GPS maps, curated secret spots, beaches, restaurants and local tips.'],
            'ar' => ['title' => 'دليل جربة الرسمي 2026 بصيغة PDF', 'desc' => 'الدليل الشامل للسياحة في جربة: خرائط GPS تفاعلية، شواطئ عذراء، أفضل المطاعم وأسرار الخبراء المحليين.']
        ],
        'carte-gps-djerba' => [
            'en' => ['title' => 'Interactive Djerba GPS Map & Secret Coordinates', 'desc' => 'Complete GPS layer with 150+ geotagged spots: wild lagoons, hidden pottery shops, authentic menzels and sunset viewpoints.'],
            'ar' => ['title' => 'خريطة جربة التفاعلية وإحداثيات GPS السرية', 'desc' => 'أكثر من 150 موقعاً جغرافياً دقيقاً: شواطئ مخفية، ورش الفخار العريقة، الرياض التقليدية وأجمل إطلالات الغروب.']
        ],
        'pack-voyageur-djerba' => [
            'en' => ['title' => 'Complete Djerba Traveler Pack 2026 (Guide + GPS + Audio)', 'desc' => 'The complete digital collection: Official PDF Guide, interactive GPS map, and MP3 walking tours at a 35% discount.'],
            'ar' => ['title' => 'الباقة الشاملة للمسافر إلى جربة 2026 (دليل + GPS + صوتي)', 'desc' => 'الحزمة الرقمية الكاملة: الدليل الرسمي، خريطة GPS الشاملة، والجولات الصوتية MP3 بخصم حصري 35%.']
        ],
        'audio-guide-djerba' => [
            'en' => ['title' => 'Djerba Cultural MP3 Audio Guide & Walking Tours', 'desc' => '10 immersive audio episodes guiding you through Houmt Souk souks, Djerbahood street art, and El Ghriba synagogue.'],
            'ar' => ['title' => 'الدليل الصوتي الثقافي MP3 لجربة وجولاتها التاريخية', 'desc' => '10 مسارات صوتية ممتعة تصحبك في أزقة حومة السوق، لوحات جربة هود الفنية وكنيس الغريبة التاريخي.']
        ],
        'pass-excursion-quad' => [
            'en' => ['title' => 'Djerba Quad Desert & Secret Tracks VIP Pass', 'desc' => 'VIP excursion pass with priority access and direct local contact for an unforgettable quad riding experience across dunes and beaches.'],
            'ar' => ['title' => 'تذكرة كواد VIP عبر المسارات الصحراوية وشواطئ جربة', 'desc' => 'تذكرة رحلات VIP مع حجز مؤكد ومباشر لمغامرة شيقة على متن دراجات الكواد بين الكثبان الرملية والبحيرة.']
        ]
    ];

    /**
     * Retourne le titre traduit selon la locale active
     */
    public static function getTitle(Product $product, ?string $locale = null): string {
        $locale = $locale ?? Lang::getLocale();
        if ($locale === 'fr') {
            return $product->titleFr;
        }

        if (isset(self::$translations[$product->slug][$locale]['title'])) {
            return self::$translations[$product->slug][$locale]['title'];
        }

        return self::autoTranslateTitle($product->titleFr, $locale);
    }

    /**
     * Retourne la description traduite selon la locale active
     */
    public static function getDescription(Product $product, ?string $locale = null): string {
        $locale = $locale ?? Lang::getLocale();
        if (isset(self::$translations[$product->slug][$locale]['desc'])) {
            return self::$translations[$product->slug][$locale]['desc'];
        }

        if ($locale === 'en') {
            return 'Instant digital delivery via email with secure download token + Free Handcrafted Gift at Djerba Airport.';
        }
        if ($locale === 'ar') {
            return 'تسليم رقمي فوري عبر البريد الإلكتروني مع رمز تحميل آمن + قسيمة هدية تقليدية مجانية بمطار جربة.';
        }

        return 'Livraison numérique immédiate par e-mail avec token de téléchargement sécurisé + Coupon Cadeau DJE.';
    }

    /**
     * Détermine la catégorie du produit
     */
    public static function getCategoryTag(string $title): string {
        $titleLower = mb_strtolower($title);
        if (str_contains($titleLower, 'carte gps') || str_contains($titleLower, 'map')) {
            return 'gps';
        }
        if (str_contains($titleLower, 'pass') || str_contains($titleLower, 'excursion') || str_contains($titleLower, 'balade') || str_contains($titleLower, 'session') || str_contains($titleLower, 'jet') || str_contains($titleLower, 'quad')) {
            return 'pass';
        }
        if (str_contains($titleLower, 'pack')) {
            return 'pack';
        }
        if (str_contains($titleLower, 'audio')) {
            return 'audio';
        }
        return 'guide';
    }

    /**
     * Nom du fichier image associé au produit
     */
    public static function getProductImage(Product $prod): string {
        $titleLower = mb_strtolower($prod->titleFr);
        if (str_contains($titleLower, 'carte gps') || str_contains($titleLower, 'map')) {
            return 'shop_gps_map.jpg';
        }
        if (str_contains($titleLower, 'pass') || str_contains($titleLower, 'excursion') || str_contains($titleLower, 'balade') || str_contains($titleLower, 'session') || str_contains($titleLower, 'jet') || str_contains($titleLower, 'quad')) {
            return str_contains($titleLower, 'jet') ? 'service_jetski.jpg' : (str_contains($titleLower, 'quad') ? 'service_quad.jpg' : 'service_bateau_pirate.jpg');
        }
        if (str_contains($titleLower, 'pack')) {
            return 'hero.png';
        }
        if (str_contains($titleLower, 'audio')) {
            return 'shop_audio_guide.jpg';
        }
        return 'shop_guide_pdf.jpg';
    }

    /**
     * Traduction automatique des motifs courants pour les 80+ guides
     */
    private static function autoTranslateTitle(string $titleFr, string $locale): string {
        if ($locale === 'en') {
            $patterns = [
                'Guide Ultime' => 'Ultimate Guide',
                'Guide Secret' => 'Secret Guide',
                'Guide' => 'Guide',
                'Les Meilleurs' => 'Best',
                'Plages Secrètes & Lagunes Sauvages' => 'Secret Beaches & Wild Lagoons',
                'Gastronomie djerbienne' => 'Djerbian Gastronomy',
                'Hôtels de Charme' => 'Boutique Hotels',
                'Bien-être, Spas & Hammams' => 'Wellness, Spas & Hammams',
                'Photographie & Spots Sunset' => 'Photography & Sunset Spots',
                'Famille & Activités Enfants' => 'Family & Kids Activities',
                'Histoire & Patrimoine' => 'History & Heritage',
                'Potiers Ancestraux' => 'Ancestral Potters',
                'Carte GPS' => 'Interactive GPS Map',
                'Pack Voyage' => 'Travel Pack',
                'Pass VIP' => 'VIP Pass',
                'Audio-Guide' => 'Audio Guide'
            ];
            return strtr($titleFr, $patterns);
        }

        if ($locale === 'ar') {
            $patterns = [
                'Guide Ultime' => 'الدليل الشامل لـ',
                'Guide Secret' => 'الدليل السري لـ',
                'Guide' => 'دليل',
                'Les Meilleurs' => 'أفضل',
                'Plages Secrètes & Lagunes Sauvages' => 'الشواطئ السرية والبحيرات العذراء',
                'Gastronomie djerbienne' => 'فنون الطهي الجربي',
                'Hôtels de Charme' => 'الفنادق الأصيلة والرياض',
                'Bien-être, Spas & Hammams' => 'الاسترخاء والسبا والحمامات',
                'Photographie & Spots Sunset' => 'التصوير وأماكن الغروب',
                'Famille & Activités Enfants' => 'العائلات وأنشطة الأطفال',
                'Histoire & Patrimoine' => 'التاريخ والتراث',
                'Potiers Ancestraux' => 'صناع الفخار العريق',
                'Carte GPS' => 'خريطة GPS التفاعلية',
                'Pack Voyage' => 'الباقة الشاملة',
                'Pass VIP' => 'تذكرة VIP',
                'Audio-Guide' => 'دليل صوتي'
            ];
            return strtr($titleFr, $patterns);
        }

        return $titleFr;
    }
}
