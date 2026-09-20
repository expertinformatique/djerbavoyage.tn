/**
 * AI Recommendation Catalog — Real services, multiple variants & secret spots for Djerba
 * Multi-language support (FR / AR / EN)
 */

const getLang = () => (typeof document !== 'undefined' && document.documentElement ? document.documentElement.lang : 'fr');

export const ROTATING_BADGES = getLang() === 'ar' ? [
    '✨ الأكثر طلباً',
    '🔥 رائج الآن',
    '💎 جوهرة نادرة',
    '🌿 بيئي فاخر',
    '⭐ خيار ممتاز',
    '🌊 لا يُفوَّت'
] : (getLang() === 'en' ? [
    '✨ Top Favorite',
    '🔥 Trending',
    '💎 Hidden Gem',
    '🌿 Eco-Chic',
    '⭐ Top Choice',
    '🌊 Must-See'
] : [
    '✨ Coup de Cœur',
    '🔥 Tendance',
    '💎 Pépite',
    '🌿 Éco-Chic',
    '⭐ Top Choix',
    '🌊 Incontournable'
]);

export const SECRET_TIPS = getLang() === 'ar' ? [
    { title: "مزاد الأسماك بميناء حومة السوق", desc: "احضر عند الساعة 4 مساءً للميناء لمشاهدة المزاد التقليدي للأسماك بالطريقة القديمة: عرض عريق وممتع!" },
    { title: "غروب الشمس في ملاحات أغير", desc: "أقل ازدحاماً من سيدي محرز، وتوفر حافة الملاحات مرآة مائية وردية ساحرة عند الغروب." },
    { title: "خزافو قلالة تحت الأرض", desc: "اطلب زيارة الورش التغارودية المحفورة في الطين، حيث تبقى الحرارة لطيفة طوال السنة." },
    { title: "شاي بالنعناع في الشيشخان", desc: "استمتع بشاي بالصنوبر وحلويات قزلان في أحد أجمل أفنية حومة السوق السرية." },
    { title: "شاطئ السقيع الهادئ", desc: "مياه شفافة ضحالة وبحيرة هادئة، مثالية لجولة صباحية بعيداً عن الصخب." },
    { title: "جداريات جربة هود الخفية", desc: "اسلك الأزقة الفرعية شرق قرية الرياض لاكتشاف الجداريات الفنية المحفوظة للفنانين العالميين." }
] : [
    { title: "La Criée du Port d'Houmt Souk", desc: "Arrivez à 16h au port pour assister aux enchères traditionnelles de poissons à la corde : spectacle authentique garanti !" },
    { title: "Coucher de soleil aux Salines d'Aghir", desc: "Moins fréquenté que Sidi Mahres, le bord des salines offre un miroir d'eau rose spectaculaire au crépuscule." },
    { title: "Les Potiers Souterrains de Guellala", desc: "Demandez à visiter les ateliers troglodytes creusés dans l'argile, où la température reste fraîche toute l'année." },
    { title: "Thé à la menthe chez Chichkhan", desc: "Savourez un thé aux pignons et cornes de gazelle dans l'une des cours intérieures les plus secrètes d'Houmt Souk." },
    { title: "La Plage Sauvage de Seguiet", desc: "Une eau transparente peu profonde et un lagon paisible, parfait pour une balade matinale loin de l'agitation." },
    { title: "Fresques Cachées de Djerbahood", desc: "Empruntez les venelles secondaires vers l'est du village d'Erriadh pour découvrir les fresques preserved des artistes internationaux." }
];

const VARIANTS_FR = {
    culture: [
        {
            title: "Immersion Patrimoine, Menzels & Ruelles d'Art",
            itineraryTitle: "Circuit Djerbahood, Souks & Ateliers de Guellala",
            itineraryDesc: "Jour 1 : Djerbahood & Synagogue de la Ghriba. Jour 2 : Fondouks d'Houmt Souk & Musée de Guellala. Jour 3 : Fort Borj El Kebir.",
            hotel: "Dar Dhiafa (Erriadh)",
            hotelDesc: "Menzel historique séculaire avec patio fleuri, fontaines et suites d'exception.",
            altHotel: "Dar Bibine (Maison d'hôtes design & art)",
            activities: [
                { name: "Randonnée Dromadaire Ateliers de Guellala", price: "38 €", slug: "chameau-caravane-plage" },
                { name: "Pack Duo Quad & Dromadaire", price: "45 €", slug: "quad-lagune-sunset" }
            ],
            restaurant: "Dar Hassine (Cour ombragée & briks artisanales)"
        },
        {
            title: "Odyssée Historique, Forts & Traditions Ancestrales",
            itineraryTitle: "De la Chaussée Romaine aux Ports de Pêcheurs",
            itineraryDesc: "Jour 1 : Houmt Souk & marché aux épices. Jour 2 : Potiers de Guellala & côte sud. Jour 3 : Mosquées fortifiées et port d'Ajim.",
            hotel: "Dar El Gaïed (Houmt Souk)",
            hotelDesc: "Demeure patricienne du XIXe restaurée avec jardins intérieurs calmes.",
            altHotel: "Dar Sultan (Luxe & Hammam privé)",
            activities: [
                { name: "Circuit Quad Pistes Sauvages d'Erriadh", price: "35 €", slug: "quad-lagune-sunset" },
                { name: "Traversée Bateau Pirate Île Flamants Roses", price: "35 €", slug: "base-nautique-jet-ski" }
            ],
            restaurant: "Le Caravansérail (Dîner aux chandelles dans un fondouk)"
        }
    ],
    beach: [
        {
            title: "Plage Privée, Lagon Turquoise & Thalasso Marine",
            itineraryTitle: "Sidi Mahres, Île aux Flamants Roses & Soirée Mer",
            itineraryDesc: "Jour 1 : Farniente sur le sable blanc de Sidi Mahres. Jour 2 : Excursion bateau pirate. Jour 3 : Rituel spa & thalasso.",
            hotel: "Radisson Blu Palace Resort & Thalasso 5★",
            hotelDesc: "Pieds dans l'eau avec parcours marin thalasso d'exception.",
            altHotel: "Iberostar Selection Djerba Beach 4★",
            activities: [
                { name: "Vol Parachute Ascensionnel Lagon", price: "40 €", slug: "base-nautique-jet-ski" },
                { name: "Traversée Bateau Pirate Flamants Roses", price: "35 €", slug: "base-nautique-jet-ski" }
            ],
            restaurant: "Le Moussaillon (Grillades de poissons & calamars frais)"
        },
        {
            title: "Échappée Lagon Sauvage, Catamaran & Coucher de Soleil",
            itineraryTitle: "Lagune d'Aghir, Bains de Soleil & Croisière Sunset",
            itineraryDesc: "Jour 1 : Navigation catamaran au sunset. Jour 2 : Paddle translucide sur lagon calme. Jour 3 : Détente piscine et massage aux huiles.",
            hotel: "Hasdrubal Prestige Thalassa 5★",
            hotelDesc: "Resort de prestige bordé d'un immense lagon d'eau de mer privée.",
            altHotel: "Sentido Djerba Beach 4★",
            activities: [
                { name: "Excursion Catamaran Luxe & Sunset", price: "45 €", slug: "base-nautique-jet-ski" },
                { name: "Location Stand-Up Paddle & Kayak Translucide", price: "20 €", slug: "base-nautique-jet-ski" }
            ],
            restaurant: "La Lagune Sunset Lounge (Tapas de la mer & vue coucher de soleil)"
        }
    ],
    adventure: [
        {
            title: "Sensations Pures : Raid Quad Salines & Kitesurf",
            itineraryTitle: "Pistes Oasiennes, Dunes Blanches & Glisse Aérienne",
            itineraryDesc: "Jour 1 : Randonnée quad coucher de soleil vers la lagune. Jour 2 : Session kitesurf ou jet-ski à Aghir. Jour 3 : Galop pur-sang sur la plage.",
            hotel: "Menzel Cajou Aghir",
            hotelDesc: "Boutique-hôtel avec piscine lagon, à 5 minutes des meilleurs spots de glisse.",
            altHotel: "Seabel Rives Bleues Resort & Spa",
            activities: [
                { name: "Randonnée Quad & Buggy Coucher de Soleil", price: "40 €", slug: "quad-lagune-sunset" },
                { name: "Session & Stage Kitesurf Lagon", price: "90 €", slug: "base-nautique-kitesurf" }
            ],
            restaurant: "Table d'Hôtes Al Jazeera (Plats rustiques & agneau grillé)"
        },
        {
            title: "Aventure Tout-Terrain & Safari Nocturne Nomade",
            itineraryTitle: "Raid Buggy 800cc, Salines Sauvages & Feu de Camp",
            itineraryDesc: "Jour 1 : Pilotage buggy Can-Am dans les pistes salées. Jour 2 : Jet-ski grand large. Jour 3 : Safari quad nocturne sous les étoiles.",
            hotel: "Sentido Djerba Beach 4★",
            hotelDesc: "Hôtel convivial en bord de mer, base parfaite pour les sports.",
            altHotel: "Houch El Khadra (Éco-domaine oasien)",
            activities: [
                { name: "Randonnée Buggy Can-Am Extreme 800cc", price: "75 €", slug: "quad-lagune-sunset" },
                { name: "Safari Quad Nocturne & Feux de Camp", price: "50 €", slug: "quad-lagune-sunset" }
            ],
            restaurant: "Dîner Barbecue Poisson dans une Cabane de Pêcheur"
        }
    ],
    food: [
        {
            title: "Haute Gastronomie Insulaire, Vins Fins & Ryads",
            itineraryTitle: "Dégustation Poissons Nobles & Dîner aux Chandelles",
            itineraryDesc: "Jour 1 : Poissons frais et langoustes au port. Jour 2 : Atelier dégustation huiles d'olive bio & vins. Jour 3 : Dîner gastronomique en ryad.",
            hotel: "Hasdrubal Prestige Thalassa 5★",
            hotelDesc: "Palace réputé pour sa table gastronomique et son service haut de gamme.",
            altHotel: "Dar Zahra (Suite de charme avec jacuzzi)",
            activities: [
                { name: "Dîner Gastronomique Haroun Port", price: "45 €", slug: "diner-spectacle-bedouin" },
                { name: "Dîner Romantique Privé sur la Plage aux Bougies", price: "75 €", slug: "diner-spectacle-bedouin" }
            ],
            restaurant: "Le Haroun (Port d'Houmt Souk — Poissons du jour & fruits de mer)"
        },
        {
            title: "Terroir Authentique : Couscous Djerbien & Gargoulette",
            itineraryTitle: "Marché des Épices, Gargoulette sous Terre & Pâtisseries",
            itineraryDesc: "Jour 1 : Dégustation d'agneau à la gargoulette cuite à l'étouffée. Jour 2 : Dîner spectacle nomade. Jour 3 : Thé à la menthe et douceurs de Djerba.",
            hotel: "Dar Dhiafa (Erriadh)",
            hotelDesc: "Immersion dans un ryad d'exception avec petits-déjeuners gourmands du terroir.",
            altHotel: "Menzel Tazi (Potager bio & cuisine maison)",
            activities: [
                { name: "Dîner Spectacle Bédouin sous Tente", price: "38 €", slug: "diner-spectacle-bedouin" },
                { name: "Soirée Gargoulette d'Agneau sous Terre", price: "36 €", slug: "diner-spectacle-bedouin" }
            ],
            restaurant: "Es Sofra (Couscous traditionnel au mérou & gargoulette djerbienne)"
        }
    ],
    sahara: [
        {
            title: "Expédition Portes du Sahara, Matmata & Source Chaude",
            itineraryTitle: "De Djerba aux Dunes du Grand Sud en 4x4",
            itineraryDesc: "Jour 1 : Maisons troglodytes de Matmata & décors Star Wars. Jour 2 : Baignade source chaude de Ksar Ghilane. Jour 3 : Coucher de soleil sur l'Erg.",
            hotel: "Nuit Insolite dans un Ksar Berbère / Bivouac Saharien",
            hotelDesc: "Expérience inoubliable sous le ciel étoilé du grand désert.",
            altHotel: "Radisson Blu Palace (Retour confort à Djerba)",
            activities: [
                { name: "Excursion Grand Sud & Portes du Sahara (4x4)", price: "95 €", slug: "sahara-ksar-ghilane" },
                { name: "Bain Thermal Source Chaude Ksar Ghilane", price: "70 €", slug: "sahara-ksar-ghilane" }
            ],
            restaurant: "Dîner Bédouin dans les Dunes sous les Étoiles"
        },
        {
            title: "Grand Raid Sud : Ksour de Tataouine & Chenini Berbère",
            itineraryTitle: "Villages Perchés, Greniers Fortifiés & Pistes du Sud",
            itineraryDesc: "Jour 1 : Traversée vers Tataouine & Ksar Ouled Soltane. Jour 2 : Village berbère millénaire de Chenini. Jour 3 : Retour par la Chaussée Romaine.",
            hotel: "Hôtel Troglodyte Matmata & Menzel de Charme Djerba",
            hotelDesc: "Architecture souterraine millénaire puis détente au bord de l'eau.",
            altHotel: "Dar El Gaïed (Maison patricienne Houmt Souk)",
            activities: [
                { name: "Excursion 4x4 Ksour de Tataouine & Chenini", price: "85 €", slug: "sahara-ksar-ghilane" },
                { name: "Caravane Dromadaire avec Thé Bédouin", price: "30 €", slug: "chameau-caravane-plage" }
            ],
            restaurant: "Table Berbère Traditionnelle de Chenini"
        }
    ]
};

const VARIANTS_AR = {
    culture: [
        {
            title: "انغماس في التراث ومنازل الرياض وأزقة الفنون",
            itineraryTitle: "مسار جربة هود، الأسواق وورش قلالة",
            itineraryDesc: "اليوم 1: جربة هود وكنيس الغريبة. اليوم 2: الفنادق العريقة بحومة السوق ومتحف قلالة. اليوم 3: برج الغازي مصطفى.",
            hotel: "دار الضيافة (الرياض)",
            hotelDesc: "منزل تقليدي تاريخي مع فناء مزهر ونافورات وأجنحة فاخرة.",
            altHotel: "دار ببين (بيت ضيافة فني ومعماري)",
            activities: [
                { name: "جولة الجمال بورش قلالة", price: "38 €", slug: "chameau-caravane-plage" },
                { name: "باقة دمج دراجة رباعية وجمل", price: "45 €", slug: "quad-lagune-sunset" }
            ],
            restaurant: "دار حسين (فناء مظلل وبريك تقليدي)"
        },
        {
            title: "ملحمة تاريخية، حصون وتقاليد عريقة",
            itineraryTitle: "من القنطرة الرومانية إلى موانئ الصيادين",
            itineraryDesc: "اليوم 1: حومة السوق وسوق التوابل. اليوم 2: خزافو قلالة والساحل الجنوبي. اليوم 3: المساجد المحصنة وميناء أجيم.",
            hotel: "دار القايد (حومة السوق)",
            hotelDesc: "منزل من القرن التاسع عشر تم تجديده بحدائق داخلية هادئة.",
            altHotel: "دار السلطان (فخامة وحمام خاص)",
            activities: [
                { name: "جولة رباعيات في المسارات الطبيعية بالرياض", price: "35 €", slug: "quad-lagune-sunset" },
                { name: "رحلة سفينة القرصان لجزيرة النحام الوردي", price: "35 €", slug: "base-nautique-jet-ski" }
            ],
            restaurant: "الفندق العتيق (عشاء على الشموع في فندق قديم)"
        }
    ],
    beach: [
        {
            title: "شاطئ خاص، بحيرة فيروزية وعلاج بالماء",
            itineraryTitle: "سيدي محرز، جزيرة النحام الوردي وجمال البحر",
            itineraryDesc: "اليوم 1: استرخاء على الرمال البيضاء لسيدي محرز. اليوم 2: رحلة السفينة المقرصنة. اليوم 3: جلسة سبا وعلاج بالماء.",
            hotel: "راديسون بلو بالاس ريزورت وسبا 5 نجوم",
            hotelDesc: "مباشرة على البحر مع مركز عالمي للعلاج بالماء.",
            altHotel: "إيبيروستار سيلكشن جربة بيتش 4 نجوم",
            activities: [
                { name: "طيران بالمظلة المائية فوق البحيرة", price: "40 €", slug: "base-nautique-jet-ski" },
                { name: "رحلة سفينة القرصان لجزيرة النحام الوردي", price: "35 €", slug: "base-nautique-jet-ski" }
            ],
            restaurant: "الملاح (مشويات أسماك طازجة وكلامار)"
        },
        {
            title: "هروب إلى البحيرة الهادئة وجولة كتماران",
            itineraryTitle: "بحيرة أغير، حمامات شمس وغروب ساحر",
            itineraryDesc: "اليوم 1: إبحار بالكتماران عند الغروب. اليوم 2: التجديف على بحيرة هادئة. اليوم 3: استرخاء بالمسبح وتدليك بالزيوت.",
            hotel: "هاسدروبال برستيج ثالاسا 5 نجوم",
            hotelDesc: "منتجع فاخر يطل على بحيرة ماء بحر خاصة.",
            altHotel: "سنتيدو جربة بيتش 4 نجوم",
            activities: [
                { name: "جولة كتماران فاخرة عند الغروب", price: "45 €", slug: "base-nautique-jet-ski" },
                { name: "استئجار لوح تجديف وشاف شاف شفاف", price: "20 €", slug: "base-nautique-jet-ski" }
            ],
            restaurant: "استراحة صالة الغروب (مقبلات بحرية وإطلالة غروب)"
        }
    ],
    adventure: [
        {
            title: "إثارة مطلقة: جولة رباعيات في الملاحات وكايت سيرف",
            itineraryTitle: "مسارات واحات، كثبان بيضاء وركوب الأمواج",
            itineraryDesc: "اليوم 1: جولة رباعية عند الغروب باتجاه البحيرة. اليوم 2: جلسة كايت سيرف أو جت سكي في أغير. اليوم 3: ركوب خيل على الشاطئ.",
            hotel: "منزل كاجو أغير",
            hotelDesc: "فندق بوتيك مع مسبح بحيرة، على بعد 5 دقائق من أفضل مناطق الرياضات المائية.",
            altHotel: "سيبل ريف بلو ريزورت وسبا",
            activities: [
                { name: "جولة رباعيات وباقي عند غروب الشمس", price: "40 €", slug: "quad-lagune-sunset" },
                { name: "تدريب كايت سيرف في البحيرة", price: "90 €", slug: "base-nautique-kitesurf" }
            ],
            restaurant: "طاولة ضيوف الجزيرة (أطباق محلية ولحم مشوي)"
        },
        {
            title: "مغامرة لكل الطرقات وصفاري ليلي بدوي",
            itineraryTitle: "سباق باغي 800cc وملاحات طبيعية",
            itineraryDesc: "اليوم 1: قيادة باغي في المسارات المالحية. اليوم 2: جت سكي في عرض البحر. اليوم 3: صفاري رباعيات ليلي تحت النجوم.",
            hotel: "سنتيدو جربة بيتش 4 نجوم",
            hotelDesc: "فندق ممتع على البحر، قاعدة مثالية للرياضات.",
            altHotel: "حوش الخضراء (ضيعة بيئية)",
            activities: [
                { name: "جولة باغي إكستريم 800cc", price: "75 €", slug: "quad-lagune-sunset" },
                { name: "صفاري رباعيات ليلي وسهرة على النار", price: "50 €", slug: "quad-lagune-sunset" }
            ],
            restaurant: "عشاء أسماك مشوية في كوخ صيد تقليدي"
        }
    ],
    food: [
        {
            title: "مطبخ الجزيرة الفاخر، عصائر وطاولات عريقة",
            itineraryTitle: "تذوق الأسماك الممتازة وعشاء على أضواء الشموع",
            itineraryDesc: "اليوم 1: أسماك طازجة ولانجوست بالميناء. اليوم 2: ورشة تذوق زيت الزيتون والأطباق. اليوم 3: عشاء فاخر بالرياض.",
            hotel: "هاسدروبال برستيج ثالاسا 5 نجوم",
            hotelDesc: "قصر معروف بطاولته الفاخرة وخدمته عالية المستوى.",
            altHotel: "دار زهراء (جناح ساحر مع جاكوزي)",
            activities: [
                { name: "عشاء فاخر في مطعم هارون بميناء حومة السوق", price: "45 €", slug: "diner-spectacle-bedouin" },
                { name: "عشاء رومانسي خاص على الشاطئ", price: "75 €", slug: "diner-spectacle-bedouin" }
            ],
            restaurant: "مطعم هارون (ميناء حومة السوق — أسماك اليوم)"
        },
        {
            title: "أصالة التراث: كسكسي جربي وقلوشة القلة تحت الأرض",
            itineraryTitle: "سوق التوابل، لحم القلة في الفخار والحلويات",
            itineraryDesc: "اليوم 1: تذوق لحم الضأن المطهو بالقلة. اليوم 2: عشاء بدوي مع عروض سحرية. اليوم 3: شاي بالنعناع وحلويات جربة.",
            hotel: "دار الضيافة (الرياض)",
            hotelDesc: "انغماس في رياض استثنائي مع فطور صباح محلي لذيذ.",
            altHotel: "منزل التازي (مطبخ بيئي منزلي)",
            activities: [
                { name: "عشاء وعرض بدوي تحت الخيمة", price: "38 €", slug: "diner-spectacle-bedouin" },
                { name: "سهرة لحم القلة بالطهي البطيء", price: "36 €", slug: "diner-spectacle-bedouin" }
            ],
            restaurant: "السفرة (كسكسي تقليدي بالمناني وقلة جربية)"
        }
    ],
    sahara: [
        {
            title: "رحلة أبواب الصحراء، مطماطة والنبع الحار",
            itineraryTitle: "من جربة إلى كثبان الجنوب الكبير بدفع رباعي 4x4",
            itineraryDesc: "اليوم 1: البيوت المغارات بمطماطة وديكورات حرب النجوم. اليوم 2: سباحة بالنبع الحار بقصار غيلان. اليوم 3: غروب الشمس على الكثبان.",
            hotel: "ليلة مميزة في قصر بربري / مخيم صحراوي",
            hotelDesc: "تجربة لا تُنسى تحت السماء المرصعة بالنجوم في الصحراء الكبرى.",
            altHotel: "راديسون بلو بالاس (عودة مريحة لجربة)",
            activities: [
                { name: "رحلة الجنوب الكبير وأبواب الصحراء (4x4)", price: "95 €", slug: "sahara-ksar-ghilane" },
                { name: "حمام حراري بالنبع الحار قصر غيلان", price: "70 €", slug: "sahara-ksar-ghilane" }
            ],
            restaurant: "عشاء بدوي بين الكثبان تحت النجوم"
        },
        {
            title: "المسار الكبير للجنوب: قصور تطاوين وشنني البربرية",
            itineraryTitle: "قرى جبلية، مخازن محصنة ومسارات صحراوية",
            itineraryDesc: "اليوم 1: العبور لتطاوين وقصر أولاد سلطان. اليوم 2: قرية شنني البربرية العريقة. اليوم 3: العودة عبر القنطرة الرومانية.",
            hotel: "فندق غار بمطماطة ومنزل تقليدي بجربة",
            hotelDesc: "معمار تحت الأرض عريق ثم استرخاء على الشاطئ.",
            altHotel: "دار القايد (منزل عتيق بحومة السوق)",
            activities: [
                { name: "رحلة 4x4 لقصور تطاوين وشنني", price: "85 €", slug: "sahara-ksar-ghilane" },
                { name: "قافلة جمال مع شاي بدوي", price: "30 €", slug: "chameau-caravane-plage" }
            ],
            restaurant: "طاولة بربرية تقليدية بشنني"
        }
    ]
};

export const RECOMMENDATION_VARIANTS = getLang() === 'ar' ? VARIANTS_AR : VARIANTS_FR;
