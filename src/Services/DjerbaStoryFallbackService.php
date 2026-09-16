<?php
namespace App\Services;

class DjerbaStoryFallbackService {
    public function generate(array $context): array {
        $weather = $context['weather'];
        $angle = $context['angle'];
        $theme = $angle['theme'];
        $key = $this->resolveAngleKey($angle);

        $story = $this->getStoryData($key, $theme, $weather);

        return [
            'title_fr' => $story['title_fr'],
            'title_en' => $story['title_en'],
            'content_fr' => $story['content_fr'],
            'content_en' => "<p>Discover the rich history, legends and traditions of {$theme} in Djerba. Current temperature is {$weather['temp_c']}°C.</p>",
            'seo_description' => $story['seo_description'],
            'meta_keywords' => implode(', ', $angle['keywords']),
            'summary_ai' => "• Histoire & Traditions : Récit immersif sur {$theme}.\n• Météo en direct : {$weather['temp_c']}°C à Djerba.\n• Réservation d'expériences guidées et transferts VIP sur Djerba Voyage.",
            'image_prompt' => $angle['image_prompt'] ?? "scenic travel photography of {$theme} in Djerba Tunisia",
            'cta_services' => $angle['suggested_services']
        ];
    }

    public function resolveAngleKey(array $angle): string {
        if (!empty($angle['key'])) {
            return $angle['key'];
        }
        $theme = strtolower($angle['theme'] ?? '');
        if (str_contains($theme, 'potier') || str_contains($theme, 'guellala')) return 'pottery_heritage';
        if (str_contains($theme, 'marin') || str_contains($theme, 'éponge') || str_contains($theme, 'ajim')) return 'sponge_fishers';
        if (str_contains($theme, 'caravane') || str_contains($theme, 'sahara') || str_contains($theme, 'désert') || str_contains($theme, 'desert')) return 'desert_adventure';
        if (str_contains($theme, 'lotophage')) return 'lotophages_beaches';
        if (str_contains($theme, 'erriadh') || str_contains($theme, 'djerbahood')) return 'djerbahood_story';
        if (str_contains($theme, 'poissonnade') || str_contains($theme, 'souk') || str_contains($theme, 'culinaire')) return 'culinary_traditions';
        if (str_contains($theme, 'kitesurf') || str_contains($theme, 'lagune')) return 'lagoon_adventure';
        if (str_contains($theme, 'menzel') || str_contains($theme, 'houch')) return 'menzel_architecture';

        return 'menzel_architecture';
    }

    private function getStoryData(string $key, string $theme, array $weather): array {
        $stories = [
            'desert_adventure' => [
                'title_fr' => "Aventure Saharienne & Traces des Caravanes depuis Djerba",
                'title_en' => "Sahara Adventure & Caravan Trails from Djerba",
                'seo_description' => "Récit d'aventure : traversez les pistes des caravaniers du Grand Sud et les dunes ocres en quad depuis Djerba.",
                'content_fr' => "<p class='lead'>Depuis la nuit des temps, l'île de Djerba est la porte d'entrée des grandes épopées sahariennes. Lorsque le soleil décline et que la brise marine s'apaise, l'appel du désert résonne à travers les étendues ocres du Sud tunisien.</p>"
                    . "<h2>Sur les traces des caravaniers du Grand Sud</h2>"
                    . "<p>Autrefois, les caravanes chargées d'épices, de soieries et de dattes faisaient halte dans les fondouks de Djerba avant d'affronter les immensités du Grand Erg Oriental. Aujourd'hui, cette épopée se vit au guidon d'un quad puissant ou d'un buggy agile, sillonnant les pistes de sable fin entre Ksar Ghilane et Tataouine.</p>"
                    . "<blockquote>« Le désert ne se raconte pas, il se vit. Chaque crête de dune franchie dévoile un océan de silence et d'or. »</blockquote>"
                    . "<p>Partir à l'aventure depuis Djerba, c'est quitter la douceur des palmeraies pour plonger dans un décor grandiose où le temps s'efface. À la tombée de la nuit, le bivouac sous un ciel étoilé d'une pureté absolue offre aux voyageurs une émotion inoubliable, rythmée par les chants bédouins autour d'un thé à la menthe fumant.</p>"
                    . "<div class='c-article-tip'><h3>💡 L'astuce de notre guide bédouin</h3><p>Prévoyez un chèche traditionnel pour vous protéger du vent et privilégiez les départs matinaux pour profiter d'une lumière rasante spectaculaire sur les crêtes de sable.</p></div>"
                    . "<h2>Vivre l'expédition saharienne en toute sérénité</h2>"
                    . "<p>Nos circuits en quad et excursions dans le désert sont encadrés par des guides locaux certifiés qui connaissent chaque recoin des pistes millénaires. Une aventure palpitante à réserver directement pour marquer votre séjour d'une empreinte indélébile.</p>"
            ],
            'pottery_heritage' => [
                'title_fr' => "Secrets Millénaires des Potiers de Guellala à Djerba",
                'title_en' => "Millenary Secrets of Guellala Potters in Djerba",
                'seo_description' => "Immersion historique dans les ateliers troglodytiques de Guellala à Djerba : trois mille ans de poterie berbère et d'artisanat d'exception.",
                'content_fr' => "<p class='lead'>Au sommet de la seule colline de l'île, le village de Guellala perpétue un trésor artisanal unique au monde. Depuis plus de 3 000 ans, les maîtres potiers y façonnent l'argile selon des gestes transmis de père en fils depuis l'époque punique.</p>"
                    . "<h2>Les maîtres de l'argile sous la terre</h2>"
                    . "<p>Pour échapper à la chaleur de l'été et conserver l'humidité idéale de la terre glaise, les ateliers de Guellala sont creusés dans la roche calcaire. En descendant les marches d'un atelier souterrain, on découvre une atmosphère presque mystique où tournoient les tours en bois actionnés au pied avec une dextérité prodigieuse.</p>"
                    . "<blockquote>« L'argile de Guellala possède une mémoire : elle garde la fraîcheur de l'eau et adoucit l'huile d'olive de nos vergers millénaires. »</blockquote>"
                    . "<p>Des célèbres jarres géantes destinées au stockage de l'huile aux délicats tajines vernissés et chameaux magiques, chaque pièce raconte une page d'histoire djerbienne. Les fours traditionnels, alimentés aux feuilles de palmier et branchages d'olivier, cuisent encore les céramiques selon des rituels immuables.</p>"
                    . "<div class='c-article-tip'><h3>💡 Le conseil de l'artisan</h3><p>Prenez le temps d'échanger avec un maître potier et observez la démonstration du « chameau magique », une création ingénieuse qui ne se remplit que par le fond !</p></div>"
                    . "<h2>Une étape incontournable du patrimoine djerbien</h2>"
                    . "<p>Flâner à Guellala au crépuscule permet d'admirer les reflets dorés sur les poteries empilées le long des venelles blanches. Combinez votre visite avec nos circuits guidés pour découvrir les recoins les plus secrets de ce village de légende.</p>"
            ],
            'sponge_fishers' => [
                'title_fr' => "Mémoire des Marins et Pêcheurs d'Éponges d'Ajim à Djerba",
                'title_en' => "Memory of Sponge Divers and Fishermen of Ajim in Djerba",
                'seo_description' => "Récit d'histoire et de traditions maritimes à Ajim : plongez dans la mémoire des courageux pêcheurs d'éponges de Djerba.",
                'content_fr' => "<p class='lead'>À la pointe sud-ouest de l'île, le port d'Ajim résonne des récits héroïques des pêcheurs d'éponges. Longtemps surnommée la capitale méditerranéenne des éponges naturelles, la cité côtière conserve l'âme vibrante des hommes de la mer.</p>"
                    . "<h2>L'épopée des plongeurs en apnée</h2>"
                    . "<p>Dès le XIXe siècle, les marins djerbiens appareillaient sur de robustes felouques en bois pour de longues expéditions maritimes. Munis d'un simple miroir sous-marin (le kamaki) et de lourdes pierres de lest, les plongeurs bravaient les profondeurs des hauts-fonds pour récolter les précieuses éponges blondes, réputées pour leur finesse incomparable.</p>"
                    . "<blockquote>« La mer de Djerba est généreuse mais exigeante. Elle exige le respect des marées et le courage des hommes libres. »</blockquote>"
                    . "<p>Aujourd'hui encore, sur les quais d'Ajim, les barques colorées tanguent doucement au rythme des marées. On y croise les anciens ravaudant leurs filets sous la brise marine, prêts à partager une légende sur les cités englouties ou les décors mythiques ayant inspiré le tournage du premier Star Wars.</p>"
                    . "<div class='c-article-tip'><h3>💡 Regard d'initié</h3><p>Ne manquez pas de visiter les petits étals d'Ajim au petit matin : vous y trouverez d'authentiques éponges naturelles de Méditerranée d'une douceur exceptionnelle pour le corps.</p></div>"
                    . "<h2>Explorez les canaux marins d'Ajim</h2>"
                    . "<p>Une excursion maritime ou une balade guidée le long du canal d'Ajim offre une perspective saisissante sur la rencontre entre les eaux du golfe de Gabès et la lagune intérieure de Djerba.</p>"
            ],
            'lotophages_beaches' => [
                'title_fr' => "Légende des Lotophages & Rivages Sauvages de Djerba",
                'title_en' => "Legend of the Lotus-Eaters & Wild Shores of Djerba",
                'seo_description' => "Voyage dans les mythes de l'Odyssée d'Homère : explorez l'île des Lotophages et la magie des plages immaculées de Djerba.",
                'content_fr' => "<p class='lead'>Dans le chant IX de l'Odyssée, Homère raconte comment le héros Ulysse et ses compagnons firent escale sur une île enchantée où poussait un fruit mystérieux : le lotus. Ce pays mythique des Lotophages n'est autre que Djerba, l'île de la douceur éternelle.</p>"
                    . "<h2>Le pays où l'on oublie le retour</h2>"
                    . "<p>La légende dit que quiconque goûtait à ce fruit de douceur perdait tout désir de regagner sa patrie, envoûté par la clémence du climat, la bienveillance des habitants et la beauté surnaturelle des rivages d'or. Trois millénaires plus tard, le charme opère avec la même intensité.</p>"
                    . "<blockquote>« Les compagnons d'Ulysse voulaient rester à jamais parmi les Lotophages, savourant la brise marine et la paix infinie de l'île. »</blockquote>"
                    . "<p>De la plage sauvage de Sidi Mahres aux criques secrètes de la lagune de Lella Hadria, l'eau cristalline déploie des nuances de turquoise et d'émeraude dignes des récits antiques. Les flamants roses et les hérons cendrés y trouvent refuge, créant des tableaux vivants d'une rare poésie.</p>"
                    . "<div class='c-article-tip'><h3>💡 Conseil contemplation</h3><p>Pour ressentir la magie homérique, marchez le long de la lagune au lever du soleil, lorsque la brume matinale se dissipe et que l'eau turquoise se confond avec l'horizon.</p></div>"
                    . "<h2>Vivre la douceur djerbienne</h2>"
                    . "<p>Profitez pleinement de ces rivages préservés grâce à nos activités nautiques, transferts vers les plus belles plages et balades équestres au bord de l'eau.</p>"
            ],
            'djerbahood_story' => [
                'title_fr' => "Contes d'Erriadh & Ruelles Mystiques de Djerbahood",
                'title_en' => "Tales of Erriadh & Mystical Alleys of Djerbahood",
                'seo_description' => "Histoire et street art à Erriadh Djerbahood : entre la synagogue de la Ghriba et les fresques murales d'artistes du monde entier.",
                'content_fr' => "<p class='lead'>Le village d'Erriadh, autrefois nommé Hara Sghira, est l'un des plus anciens témoins de la cohabitation harmonieuse et multiséculaire de Djerba. En 2014, ce havre de paix blanchi à la chaux s'est métamorphosé en un musée de street art à ciel ouvert de renommée planétaire : Djerbahood.</p>"
                    . "<h2>La rencontre entre mémoire millénaire et art contemporain</h2>"
                    . "<p>Plus de 150 artistes venus d'une trentaine de pays ont posé leurs pinceaux sur les murs patinés des venelles traditionnelles. Chaque coin de rue réserve une surprise : une fresque monumentale épousant les contours d'une porte cloutée en bois bleu, un poème calligraphique ou un portrait saisissant d'intensité.</p>"
                    . "<blockquote>« À Erriadh, l'art ne s'impose pas : il murmure avec la pierre ancienne et danse sous les cascades de bougainvilliers en fleurs. »</blockquote>"
                    . "<p>À deux pas des fresques se dresse la vénérable synagogue de la Ghriba, fondée il y a plus de 2 500 ans par des prêtres fuyant la destruction du Temple de Jérusalem. Ses carreaux de faïence bleue et ses voûtes ouvragées témoignent d'une fraternité inaltérée entre les communautés musulmanes et juives de l'île.</p>"
                    . "<div class='c-article-tip'><h3>💡 Secret de visite</h3><p>Perdez-vous volontairement dans le dédale des impasses silencieuses aux heures douces de l'après-midi pour capturer les jeux d'ombres géométriques sur la chaux blanche.</p></div>"
                    . "<h2>Découvrir Erriadh avec un guide passionné</h2>"
                    . "<p>Réservez une visite guidée exclusive pour décoder le sens caché de chaque fresque et plonger dans les récits passionnants qui façonnent l'identité de ce village mythique.</p>"
            ],
            'culinary_traditions' => [
                'title_fr' => "Tradition de la Poissonnade et Secrets Culinaires de Djerba",
                'title_en' => "Fish Auction Tradition and Culinary Secrets of Djerba",
                'seo_description' => "Immersion gourmande au cœur des traditions culinaires de Djerba : la criée aux poissons de Houmt Souk et le savoureux riz djerbien.",
                'content_fr' => "<p class='lead'>S'il est un spectacle à ne manquer sous aucun prétexte, c'est l'effervescence matinale de la criée au marché central de Houmt Souk. Ici, le poisson ne s'achète pas comme ailleurs : il s'adjuge à la voix, en chapelets enfilés sur des brins de jonc selon un rituel vieux de plusieurs siècles.</p>"
                    . "<h2>Le spectacle vibrant de la criée de Houmt Souk</h2>"
                    . "<p>Perchés sur leurs estrades, les crieurs haranguent la foule d'un ton chantant et rythmé. Loups de mer, daurades royales, rougets de roche et poulpes fraîchement débarqués des barques sont âprement disputés par les restaurateurs et les familles djerbiennes.</p>"
                    . "<blockquote>« Le véritable secret de la cuisine djerbienne réside dans la fraîcheur absolue du produit et le dosage savant des épices du terroir : carvi, coriandre et piment séché au soleil. »</blockquote>"
                    . "<p>Une fois votre prise choisie, la tradition veut qu'on l'apporte aux petits gargotes attenantes au souk : le poisson y est grillé au feu de bois sous vos yeux, escorté de salade méchouia, de brik croustillante et du fameux riz djerbien cuit à la vapeur avec des herbes fraîches et du foie de veau ou de la seiche.</p>"
                    . "<div class='c-article-tip'><h3>💡 Rituel gourmand</h3><p>Terminez toujours votre repas par un thé à la menthe pignon infusé dans une théière en émail, symbole universel de l'hospitalité djerbienne.</p></div>"
                    . "<h2>Goûtez aux saveurs authentiques de l'île</h2>"
                    . "<p>Explorez notre sélection de tables d'hôtes et de packs gourmands pour déguster les meilleurs produits du terroir djerbien lors de votre voyage.</p>"
            ]
        ];

        return $stories[$key] ?? [
            'title_fr' => "L'Âme Secrète des Menzel & Houchs Blancs de Djerba",
            'title_en' => "The Secret Soul of Menzel & Whitewashed Houchs in Djerba",
            'seo_description' => "Découvrez l'architecture unique des Menzel fortifiés de Djerba, chefs-d'œuvre de sagesse bioclimatique et de patrimoine.",
            'content_fr' => "<p class='lead'>Inscrit au patrimoine mondial de l'UNESCO, le paysage culturel de Djerba se distingue par un modèle d'occupation du sol unique au monde : le Menzel traditionnel. Dissimulés au milieu de vergers ceints de hauts talus (les tabias), ces domaines familiaux reflètent le génie défensif et l'art de vivre des Djerbiens.</p>"
                . "<h2>Le Houch, sanctuaire d'intimité et de fraîcheur</h2>"
                . "<p>Au cœur du Menzel s'élève le Houch, une habitation carrée organisée autour d'un patio central à ciel ouvert. Ses murs épais blanchis à la chaux et ses toits en coupoles (les ghorfas) créent une climatisation naturelle remarquable, captant chaque goutte de rosée et maintenant une température délicieuse même en plein été.</p>"
                . "<blockquote>« Chez nous, la maison ne s'ouvre pas sur la rue, elle s'ouvre sur le ciel. Chaque voûte est un rempart de paix et de recueillement. »</blockquote>"
                . "<p>Véritable forteresse de sérénité, le Menzel possédait son propre puits, son pressoir à huile souterrain et ses citernes d'eau de pluie (les majels). Cette organisation ingénieuse a permis aux habitants de vivre en harmonie avec une terre aride pendant des millénaires.</p>"
                . "<div class='c-article-tip'><h3>💡 Expérience recommandée</h3><p>Séjourner dans un Menzel rénové en maison d'hôtes de charme est la manière la plus authentique de s'imprégner de l'âme et de la douceur djerbiennes.</p></div>"
                . "<h2>Réservez votre séjour d'exception</h2>"
                . "<p>Retrouvez nos hébergements de charme et nos services de conciergerie privée pour vivre un séjour inoubliable au cœur du patrimoine djerbien.</p>"
        ];
    }
}
