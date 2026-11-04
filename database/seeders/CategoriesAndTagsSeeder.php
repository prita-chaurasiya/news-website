<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class CategoriesAndTagsSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Politics',
                'name_hi' => 'राजनीति',
                'slug' => 'politics',
                'description' => 'Uncompromising coverage of national governance, parliament, policies, and political debates.',
                'description_hi' => 'राष्ट्रीय शासन, संसद, नीतियों और राजनीतिक बहसों का निष्पक्ष विश्लेषण।',
                'color' => '#C8102E',
                'sort_order' => 1,
                'is_menu' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'India',
                'name_hi' => 'भारत',
                'slug' => 'india',
                'description' => 'In-depth ground reports, state developments, judiciary, and social transformations across the nation.',
                'description_hi' => 'देश भर से ज़मीनी रिपोर्ट, राज्यों के घटनाक्रम, न्यायपालिका और सामाजिक बदलाव।',
                'color' => '#D84315',
                'sort_order' => 2,
                'is_menu' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'World',
                'name_hi' => 'विश्व',
                'slug' => 'world',
                'description' => 'Global diplomacy, international conflicts, multilateral summits, and foreign policy perspectives.',
                'description_hi' => 'वैश्विक कूटनीति, अंतरराष्ट्रीय संघर्ष, वैश्विक शिखर सम्मेलन और विदेश नीति।',
                'color' => '#1565C0',
                'sort_order' => 3,
                'is_menu' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Business',
                'name_hi' => 'व्यापार',
                'slug' => 'business',
                'description' => 'Financial markets, macroeconomic policies, corporate leadership, banking, and startups.',
                'description_hi' => 'वित्तीय बाज़ार, आर्थिक नीतियां, कॉर्पोरेट नेतृत्व, बैंकिंग और स्टार्टअप्स।',
                'color' => '#2E7D32',
                'sort_order' => 4,
                'is_menu' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Tech',
                'name_hi' => 'तकनीक',
                'slug' => 'tech',
                'description' => 'Artificial intelligence, consumer electronics, cybersecurity, space exploration, and deep tech.',
                'description_hi' => 'आर्टिफिशियल इंटेलिजेंस, उपभोक्ता तकनीक, साइबर सुरक्षा, अंतरिक्ष अन्वेषण और डीप टेक।',
                'color' => '#6A1B9A',
                'sort_order' => 5,
                'is_menu' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Sports',
                'name_hi' => 'खेल',
                'slug' => 'sports',
                'description' => 'Comprehensive scores, player analysis, cricket, football, Olympics, and grassroots athletics.',
                'description_hi' => 'क्रिकेट, फुटबॉल, ओलंपिक, स्कोर और खेल जगत की विस्तृत कवरेज।',
                'color' => '#EF6C00',
                'sort_order' => 6,
                'is_menu' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Opinion',
                'name_hi' => 'विचार',
                'slug' => 'opinion',
                'description' => 'Thought-provoking columns, sharp intellectual debate, editorial stances, and diverse viewpoints.',
                'description_hi' => 'विचारोत्तेजक लेख, संपादकीय दृष्टिकोण और समाज के विभिन्न क्षेत्रों से प्रखर राय।',
                'color' => '#37474F',
                'sort_order' => 7,
                'is_menu' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Entertainment',
                'name_hi' => 'मनोरंजन',
                'slug' => 'entertainment',
                'description' => 'Cinema reviews, OTT releases, music, cultural phenomena, and profiles of leading artists.',
                'description_hi' => 'सिनेमा समीक्षा, ओटीटी रिलीज़, संगीत और कला जगत की प्रमुख हस्तियों की कहानियां।',
                'color' => '#C2185B',
                'sort_order' => 8,
                'is_menu' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'Lifestyle',
                'name_hi' => 'जीवनशैली',
                'slug' => 'lifestyle',
                'description' => 'Wellbeing, literature, travel, food culture, heritage, and sustainable living.',
                'description_hi' => 'स्वास्थ्य, साहित्य, यात्रा, खान-पान, विरासत और सतत जीवनशैली।',
                'color' => '#00838F',
                'sort_order' => 9,
                'is_menu' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $tags = [
            ['name' => 'AI Revolution', 'name_hi' => 'एआई क्रांति', 'slug' => 'ai-revolution'],
            ['name' => 'Budget 2026', 'name_hi' => 'बजट 2026', 'slug' => 'budget-2026'],
            ['name' => 'Supreme Court', 'name_hi' => 'सुप्रीम कोर्ट', 'slug' => 'supreme-court'],
            ['name' => 'Geopolitics', 'name_hi' => 'भू-राजनीति', 'slug' => 'geopolitics'],
            ['name' => 'ISRO & Space', 'name_hi' => 'इसरो और अंतरिक्ष', 'slug' => 'isro-space'],
            ['name' => 'Cricket', 'name_hi' => 'क्रिकेट', 'slug' => 'cricket'],
            ['name' => 'Green Energy', 'name_hi' => 'हरित ऊर्जा', 'slug' => 'green-energy'],
            ['name' => 'Stock Markets', 'name_hi' => 'शेयर बाज़ार', 'slug' => 'stock-markets'],
            ['name' => 'Elections', 'name_hi' => 'चुनाव', 'slug' => 'elections'],
            ['name' => 'Defense', 'name_hi' => 'रक्षा', 'slug' => 'defense'],
            ['name' => 'Climate Crisis', 'name_hi' => 'जलवायु संकट', 'slug' => 'climate-crisis'],
            ['name' => 'Health & Medicine', 'name_hi' => 'स्वास्थ्य और चिकित्सा', 'slug' => 'health-medicine'],
            ['name' => 'Cinema', 'name_hi' => 'सिनेमा', 'slug' => 'cinema'],
            ['name' => 'Startups', 'name_hi' => 'स्टार्टअप्स', 'slug' => 'startups'],
            ['name' => 'Aviation', 'name_hi' => 'उड्डयन', 'slug' => 'aviation'],
        ];

        foreach ($tags as $t) {
            Tag::updateOrCreate(['slug' => $t['slug']], $t);
        }
    }
}
