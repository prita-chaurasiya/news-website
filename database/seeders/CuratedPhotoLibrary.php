<?php

namespace Database\Seeders;

class CuratedPhotoLibrary
{
    /**
     * Build standard high-res WebP Unsplash URL with consistent crops.
     */
    public static function buildUrl(string $photoId, int $width = 1600, int $height = 900): string
    {
        return "https://images.unsplash.com/{$photoId}?auto=format&fit=crop&w={$width}&h={$height}&q=80&fm=webp";
    }

    /**
     * Curated Unsplash photo IDs grouped by category.
     * All photos are selected for professional editorial newsroom quality.
     */
    public static array $categories = [
        'politics' => [
            ['id' => 'photo-1541872703-74c5e44368f9', 'caption' => 'Corridors of governance and parliamentary assembly.', 'credit' => 'Unsplash'],
            ['id' => 'photo-1540910419892-4a36d2c3266c', 'caption' => 'Ministerial press podium before policy address.', 'credit' => 'AFP / Unsplash'],
            ['id' => 'photo-1589829545856-d10d557cf95f', 'caption' => 'Constitutional bench hearing in national capital.', 'credit' => 'The Chronicle / AP'],
            ['id' => 'photo-1529107386315-e1a2ed48a620', 'caption' => 'Bilateral summit delegations in executive chamber.', 'credit' => 'PIB / Unsplash'],
            ['id' => 'photo-1575517111478-7f6afd0973db', 'caption' => 'Central Secretariat North Block during evening twilight.', 'credit' => 'Unsplash'],
            ['id' => 'photo-1517048676732-d65bc937f952', 'caption' => 'Cabinet Committee on Economic Affairs meeting table.', 'credit' => 'The Chronicle / Photo'],
            ['id' => 'photo-1555848962-6e79363ec58f', 'caption' => 'Plenary hall delegates reviewing electoral reform bill.', 'credit' => 'PTI / Unsplash'],
            ['id' => 'photo-1577495508048-b635879837f1', 'caption' => 'Electronic voting tally board during legislative voting.', 'credit' => 'AFP / Unsplash'],
            ['id' => 'photo-1505373877841-8d25f7d46678', 'caption' => 'National security dialogue convention in New Delhi.', 'credit' => 'The Chronicle / AP'],
            ['id' => 'photo-1534528741775-53994a69daeb', 'caption' => 'Chief election commissioner briefing media corps.', 'credit' => 'PIB / Unsplash'],
            ['id' => 'photo-1526470608268-f674ce90ebd4', 'caption' => 'Inter-state council conference on fiscal federalism.', 'credit' => 'PTI / Unsplash'],
            ['id' => 'photo-1451187580459-43490279c0fa', 'caption' => 'Strategic policy mapping command room.', 'credit' => 'The Chronicle / AP'],
        ],

        'india' => [
            ['id' => 'photo-1587474260584-136574528ed5', 'caption' => 'India Gate war memorial illuminated at sunset.', 'credit' => 'Unsplash'],
            ['id' => 'photo-1596176530529-78163a4f7af2', 'caption' => 'Bandra-Worli Sea Link crossing the Arabian Sea.', 'credit' => 'The Chronicle / Photo'],
            ['id' => 'photo-1609137144822-4a3901b0f946', 'caption' => 'Vande Bharat Express traversing high-speed rail corridor.', 'credit' => 'Indian Railways / Unsplash'],
            ['id' => 'photo-1509391365360-2e959784a276', 'caption' => 'Ultra-mega solar park installation in Rajasthan desert.', 'credit' => 'SECI / Unsplash'],
            ['id' => 'photo-1566552881560-0be86c532107', 'caption' => 'Bengaluru electronic city technology boulevard.', 'credit' => 'The Chronicle / AP'],
            ['id' => 'photo-1516214104703-d870798883c5', 'caption' => 'Western Ghats ecological sanctuary and catchment area.', 'credit' => 'Forest Survey / Unsplash'],
            ['id' => 'photo-1532375810709-75b1da00537c', 'caption' => 'Mughal sandstone ramparts of historic Red Fort.', 'credit' => 'The Chronicle / Photo'],
            ['id' => 'photo-1570168007204-dfb528c6958f', 'caption' => 'Mumbai financial district high-rise skyline at dusk.', 'credit' => 'Bloomberg / Unsplash'],
            ['id' => 'photo-1582510003544-4d00b7f74220', 'caption' => 'Granite gopuram architecture of Thanjavur temple.', 'credit' => 'ASI / Unsplash'],
            ['id' => 'photo-1598890777032-bde13fba5be3', 'caption' => 'Subah-e-Banaras morning prayer rituals along Ganges.', 'credit' => 'The Chronicle / AP'],
            ['id' => 'photo-1524492412937-b28074a5d7da', 'caption' => 'Qutub Minar medieval victory tower and iron pillar.', 'credit' => 'AFP / Unsplash'],
            ['id' => 'photo-1564507592333-c60657eea523', 'caption' => 'Yamuna river reflection of Mughal marble monuments.', 'credit' => 'The Chronicle / Photo'],
        ],

        'business' => [
            ['id' => 'photo-1590283603385-17ffb3a7f29f', 'caption' => 'Bombay Stock Exchange terminal displaying index rally.', 'credit' => 'Bloomberg / Unsplash'],
            ['id' => 'photo-1486406146926-c627a92ad1ab', 'caption' => 'Reflective glass facade of premier banking towers.', 'credit' => 'The Chronicle / Financial'],
            ['id' => 'photo-1526304640581-d334cdbbf45e', 'caption' => 'Currency notes in central reserve vaults.', 'credit' => 'RBI / Unsplash'],
            ['id' => 'photo-1611974789855-9c2a0a7236a3', 'caption' => 'Real-time equity candlestick chart indicators.', 'credit' => 'Bloomberg / Unsplash'],
            ['id' => 'photo-1565372195458-9de0b320ef04', 'caption' => 'Automated gantry cranes at Mundra container seaport.', 'credit' => 'Adani Ports / Unsplash'],
            ['id' => 'photo-1579532537598-459ecdaf39cc', 'caption' => 'Hallmarked bullion reserve ingots in treasury vault.', 'credit' => 'The Chronicle / Photo'],
            ['id' => 'photo-1559526324-4b87b5e36e44', 'caption' => 'Financial district skyscrapers reflecting morning dawn.', 'credit' => 'Unsplash'],
            ['id' => 'photo-1507679799987-c73779587ccf', 'caption' => 'Boardroom directors reviewing fiscal audit reports.', 'credit' => 'The Chronicle / AP'],
            ['id' => 'photo-1454165804606-c3d57bc86b40', 'caption' => 'Venture investment analysts auditing SaaS metrics.', 'credit' => 'Mint / Unsplash'],
            ['id' => 'photo-1551836022-d5d88e9218df', 'caption' => 'Fintech unicorn headquarters engineering hub.', 'credit' => 'The Chronicle / Photo'],
            ['id' => 'photo-1504384308090-c894fdcc538d', 'caption' => 'Central banking monetary policy committee room.', 'credit' => 'RBI / Unsplash'],
            ['id' => 'photo-1518186285589-2f7649de83e0', 'caption' => 'Cryptocurrency hardware cold storage facility.', 'credit' => 'Unsplash'],
        ],

        'tech' => [
            ['id' => 'photo-1518770660439-4636190af475', 'caption' => 'Silicon wafer microprocessor architecture macro shot.', 'credit' => 'The Chronicle / Tech'],
            ['id' => 'photo-1558494949-ef010cbdcc31', 'caption' => 'Hyperscale AI GPU server cluster and optical buses.', 'credit' => 'NVIDIA / Unsplash'],
            ['id' => 'photo-1531746790731-6c087fecd65a', 'caption' => 'Humanoid robotics testbed in autonomous laboratory.', 'credit' => 'Unsplash'],
            ['id' => 'photo-1508739773434-c26b3d09e071', 'caption' => 'Class-1 cleanroom operator inspecting silicon ingots.', 'credit' => 'India Semi / Unsplash'],
            ['id' => 'photo-1618005182384-a83a8bd57fbe', 'caption' => 'Multimodal transformer neural network weights model.', 'credit' => 'The Chronicle / AI'],
            ['id' => 'photo-1526374965328-7f61d4dc18c5', 'caption' => 'Cybersecurity operational security command terminal.', 'credit' => 'CERT-In / Unsplash'],
            ['id' => 'photo-1535378620166-273708d44e4c', 'caption' => 'Cryogenic dilution refrigerator for quantum qubits.', 'credit' => 'TIFR / Unsplash'],
            ['id' => 'photo-1451187580459-43490279c0fa', 'caption' => 'Low-earth orbit synthetic aperture radar satellite.', 'credit' => 'ISRO / Unsplash'],
            ['id' => 'photo-1620712943543-bcc4688e7485', 'caption' => 'Generative foundation model latency benchmarks.', 'credit' => 'The Chronicle / Tech'],
            ['id' => 'photo-1504639725590-34d0984388bd', 'caption' => 'Rust systems programming terminal compiling kernel.', 'credit' => 'GitHub / Unsplash'],
            ['id' => 'photo-1519389950473-47ba0277781c', 'caption' => 'Autonomous mobility simulation software engineers.', 'credit' => 'The Chronicle / Photo'],
            ['id' => 'photo-1573164713988-8665fc963095', 'caption' => 'Precision industrial robotic arm welding chassis.', 'credit' => 'Tata Motors / Unsplash'],
        ],

        'world' => [
            ['id' => 'photo-1541872703-74c5e44368f9', 'caption' => 'United Nations General Assembly Hall in New York.', 'credit' => 'UN / Unsplash'],
            ['id' => 'photo-1577495508048-b635879837f1', 'caption' => 'European Parliament debating global carbon tariffs.', 'credit' => 'EU / Unsplash'],
            ['id' => 'photo-1526778548025-fa2f459cd5c1', 'caption' => 'Commercial container vessels transiting Malacca Strait.', 'credit' => 'Lloyds / Unsplash'],
            ['id' => 'photo-1494522855154-9297ac14b55f', 'caption' => 'G20 sherpa negotiations over debt restructuring.', 'credit' => 'The Chronicle / AP'],
            ['id' => 'photo-1516245834210-c4c142787335', 'caption' => 'Deepwater container fleet navigating international waters.', 'credit' => 'Maersk / Unsplash'],
            ['id' => 'photo-1513836279014-a89f7a76ae86', 'caption' => 'Svalbard Arctic glacier research station observatory.', 'credit' => 'Unsplash'],
            ['id' => 'photo-1529107386315-e1a2ed48a620', 'caption' => 'Tri-lateral peace treaty signing in Geneva chamber.', 'credit' => 'AFP / Unsplash'],
            ['id' => 'photo-1506973035872-a4ec16b8e8d9', 'caption' => 'Trans-Pacific maritime trade corridors at dawn.', 'credit' => 'The Chronicle / AP'],
            ['id' => 'photo-1578575437130-527eed3abbec', 'caption' => 'Frankfurt international airport logistics cargo bays.', 'credit' => 'Lufthansa / Unsplash'],
            ['id' => 'photo-1544620347-c4fd4a3d5957', 'caption' => 'Cross-border Eurail transit bridge network.', 'credit' => 'The Chronicle / Photo'],
            ['id' => 'photo-1451187580459-43490279c0fa', 'caption' => 'Global undersea fiber optic cables routing map.', 'credit' => 'SubCom / Unsplash'],
            ['id' => 'photo-1507525428034-b723cf961d3e', 'caption' => 'South China Sea maritime economic exclusive zone.', 'credit' => 'Unsplash'],
        ],

        'sports' => [
            ['id' => 'photo-1540747913346-19e32dc3e97e', 'caption' => 'Floodlit cricket stadium packed with 110,000 fans.', 'credit' => 'BCCI / Unsplash'],
            ['id' => 'photo-1626224583764-f87db24ac4ea', 'caption' => 'All England Open badminton court finals match.', 'credit' => 'BWF / Unsplash'],
            ['id' => 'photo-1529699211952-734e80c4d42b', 'caption' => 'World Chess Championship classical match timer.', 'credit' => 'FIDE / The Chronicle'],
            ['id' => 'photo-1461896836934-ffe607ba8211', 'caption' => 'Synthetic Olympic 100m sprint running track.', 'credit' => 'IOC / Unsplash'],
            ['id' => 'photo-1508098682722-e99c43a406b2', 'caption' => 'Crowd roaring during continental football final.', 'credit' => 'FIFA / Unsplash'],
            ['id' => 'photo-1517649763962-0c623266ddc0', 'caption' => 'Javelin thrower in mid-stride during national trials.', 'credit' => 'AFI / Unsplash'],
            ['id' => 'photo-1574629810360-7efbbe195018', 'caption' => 'Match ball hitting back of net during stoppage time.', 'credit' => 'The Chronicle / AP'],
            ['id' => 'photo-1511886929837-354d827aae26', 'caption' => 'Indoor basketball championship stadium wood floor.', 'credit' => 'NBA / Unsplash'],
            ['id' => 'photo-1569517282132-25d22f4573e6', 'caption' => 'Roland Garros red clay court baseline chalk mark.', 'credit' => 'ATP / Unsplash'],
            ['id' => 'photo-1530549387789-4c1017266635', 'caption' => '50m aquatic swimming pool racing lane markers.', 'credit' => 'World Aquatics / Unsplash'],
            ['id' => 'photo-1587280501635-68a0e82cd5ff', 'caption' => 'Table tennis champion serving during quarter-final.', 'credit' => 'ITTF / Unsplash'],
            ['id' => 'photo-1568605117036-5fe5e7bab0b7', 'caption' => 'Trail marathoner summiting Himalayan ridge.', 'credit' => 'The Chronicle / Sports'],
        ],

        'opinion' => [
            ['id' => 'photo-1455390582262-044cdead277a', 'caption' => 'Fountain pen and drafted legal editorial notes.', 'credit' => 'The Chronicle / Archive'],
            ['id' => 'photo-1507842229452-789274934358', 'caption' => 'Grand reading room of National Archives library.', 'credit' => 'Oxford / Unsplash'],
            ['id' => 'photo-1534528741775-53994a69daeb', 'caption' => 'Contributing editor reflecting on constitutional law.', 'credit' => 'The Chronicle / Portrait'],
            ['id' => 'photo-1507003211169-0a1dd7228f2d', 'caption' => 'Senior fellow at Centre for Policy Research.', 'credit' => 'CPR / Unsplash'],
            ['id' => 'photo-1573496359142-b8d87734a5a2', 'caption' => 'Distinguished professor of development economics.', 'credit' => 'The Chronicle / Portrait'],
            ['id' => 'photo-1580489944761-15a19d654956', 'caption' => 'Columnist reviewing South Asian multilateral treaties.', 'credit' => 'The Chronicle / Portrait'],
            ['id' => 'photo-1499750310107-5fef28a66643', 'caption' => 'Morning espresso and annotated draft manuscript.', 'credit' => 'The Chronicle / Editorial'],
            ['id' => 'photo-1516979187457-637abb4f9353', 'caption' => 'Leather-bound supreme court law reports archive.', 'credit' => 'Supreme Court / Unsplash'],
            ['id' => 'photo-1524995997946-a1c2e315a42f', 'caption' => 'Sunlight illuminating jurisprudence reading desks.', 'credit' => 'The Chronicle / Photo'],
            ['id' => 'photo-1532012164546-f432f2e3777f', 'caption' => 'Open history thesis with marginalia annotations.', 'credit' => 'The Chronicle / Archive'],
            ['id' => 'photo-1471107340929-a87cd0f5b5f3', 'caption' => 'Mechanical typewriter used for underground reporting.', 'credit' => 'The Chronicle / Memorial'],
            ['id' => 'photo-1500648767791-00dcc994a43e', 'caption' => 'Distinguished historian analyzing declassified cables.', 'credit' => 'The Chronicle / Portrait'],
        ],

        'entertainment' => [
            ['id' => 'photo-1485846234645-a62644f84728', 'caption' => 'Celluloid 70mm cinematic film projection reels.', 'credit' => 'Cannes / Unsplash'],
            ['id' => 'photo-1514306191717-452ec28c7814', 'caption' => 'National Symphony Orchestra violins section in unison.', 'credit' => 'NCPA / Unsplash'],
            ['id' => 'photo-1489599849927-2ee91cede3ba', 'caption' => 'Heritage Art Deco cinema auditorium in Mumbai.', 'credit' => 'The Chronicle / Culture'],
            ['id' => 'photo-1478720568477-152d9b164e26', 'caption' => 'Panavision anamorphic motion picture camera rig.', 'credit' => 'Film Guild / Unsplash'],
            ['id' => 'photo-1511671782779-c97d3d27a1d4', 'caption' => 'Neve 88RS analog mixing desk in Abbey Road studios.', 'credit' => 'The Chronicle / Sound'],
            ['id' => 'photo-1465847899084-d164df4dedc6', 'caption' => 'Proscenium theatre stage lit with warm tungsten.', 'credit' => 'Prithvi / Unsplash'],
            ['id' => 'photo-1501281668745-f7f57925c3b4', 'caption' => 'Open-air classical music festival at dusk in Gwalior.', 'credit' => 'Sangeet Natak / Unsplash'],
            ['id' => 'photo-1518709268805-4e9042af9f23', 'caption' => 'Master luthier handcrafting concert violin neck.', 'credit' => 'The Chronicle / Craft'],
            ['id' => 'photo-1574267432553-4b4628081c31', 'caption' => 'Golden Peacock trophy at International Film Festival of India.', 'credit' => 'IFFI / Unsplash'],
            ['id' => 'photo-1507676184212-d03ab07a01bf', 'caption' => 'Solo jazz trumpet improvisation in underground club.', 'credit' => 'Blue Note / Unsplash'],
            ['id' => 'photo-1524368535928-5b5e00ddc76b', 'caption' => 'Arena concert stage rigging and pyrotechnics.', 'credit' => 'The Chronicle / Music'],
            ['id' => 'photo-1533174072545-7a4b6ad7a6c3', 'caption' => 'Kathakali classical dancer performing Mahabharata.', 'credit' => 'Kalamandalam / Unsplash'],
        ],

        'lifestyle' => [
            ['id' => 'photo-1544717305-2782549b5136', 'caption' => 'Darjeeling first-flush tea plantation shrouded in fog.', 'credit' => 'Goodricke / Unsplash'],
            ['id' => 'photo-1506126613408-eca07ce68773', 'caption' => 'Dawn meditation hall in Rishikesh on Ganges banks.', 'credit' => 'The Chronicle / Wellness'],
            ['id' => 'photo-1513694203232-719a280e022f', 'caption' => 'Brutalist concrete architecture of Chandigarh sector 1.', 'credit' => 'Le Corbusier Fdn / Unsplash'],
            ['id' => 'photo-1512917774080-9991f1c4c750', 'caption' => 'Net-zero sustainable rammed-earth villa in Coorg.', 'credit' => 'Architectural Digest / Unsplash'],
            ['id' => 'photo-1517248135467-4c7edcad34c4', 'caption' => 'Michelin-starred modern Indian culinary kitchen.', 'credit' => 'The Chronicle / Food'],
            ['id' => 'photo-1540555700478-4be289fbecef', 'caption' => 'Traditional Ayurvedic therapy courtyard in Kumarakom.', 'credit' => 'Kerala Tourism / Unsplash'],
            ['id' => 'photo-1447752875215-b2761acb3c5d', 'caption' => 'Himalayan cedar and deodar forest hiking trail.', 'credit' => 'The Chronicle / Travel'],
            ['id' => 'photo-1519741497674-611481863552', 'caption' => 'Banarasi pure zari silk handloom master artisan.', 'credit' => 'Crafts Council / Unsplash'],
            ['id' => 'photo-1507525428034-b723cf961d3e', 'caption' => 'Unspoiled coral cove in Andaman and Nicobar Islands.', 'credit' => 'The Chronicle / Explorer'],
            ['id' => 'photo-1520250497591-112f2f40a3f4', 'caption' => 'Restored stepwell pavilion turned boutique heritage stay.', 'credit' => 'Heritage Hotels / Unsplash'],
            ['id' => 'photo-1510812431401-41d2bd2722f3', 'caption' => 'Organic single-estate wine barrels in Nashik valley.', 'credit' => 'Sula / Unsplash'],
            ['id' => 'photo-1488646953014-85cb44e25828', 'caption' => 'Traveller standing above clouds on Rohtang pass.', 'credit' => 'The Chronicle / Travel'],
        ],
    ];

    /**
     * 8 Real, high-resolution editorial portrait photos for authors.
     */
    public static array $authors = [
        'rajeshwar-singh' => [
            'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&h=600&q=80&fm=webp',
            'caption' => 'Rajeshwar Singh, National Affairs Editor',
        ],
        'dr-radhika-mehra' => [
            'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=600&h=600&q=80&fm=webp',
            'caption' => 'Dr. Radhika Mehra, Chief Economic Analyst',
        ],
        'siddharth-joshi' => [
            'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&h=600&q=80&fm=webp',
            'caption' => 'Siddharth Joshi, Tech & AI Bureau Chief',
        ],
        'kabir-deshmukh' => [
            'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=600&h=600&q=80&fm=webp',
            'caption' => 'Kabir Deshmukh, Diplomatic & Global Affairs Editor',
        ],
        'sunita-narayanan' => [
            'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=600&h=600&q=80&fm=webp',
            'caption' => 'Sunita Narayanan, Senior Sports Columnist',
        ],
        'pradeep-verma' => [
            'photo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=600&h=600&q=80&fm=webp',
            'caption' => 'Adv. Pradeep Verma, Legal Affairs Correspondent',
        ],
        'tara-roy' => [
            'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&h=600&q=80&fm=webp',
            'caption' => 'Tara Roy, Arts & Culture Critic',
        ],
        'amitav-kashyap' => [
            'photo' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=600&h=600&q=80&fm=webp',
            'caption' => 'Amitav Kashyap, Investigative Ground Reporter',
        ],
    ];

    /**
     * Get a matching curated photo for a category and article index.
     */
    public static function getForCategory(string $categorySlug, int $index = 0): array
    {
        $list = self::$categories[$categorySlug] ?? self::$categories['politics'];
        $item = $list[$index % count($list)];

        return [
            'url' => self::buildUrl($item['id']),
            'caption' => $item['caption'].' Photo: '.$item['credit'],
            'caption_hi' => $item['caption'].' फोटो: '.$item['credit'],
        ];
    }
}
