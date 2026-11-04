<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Epaper;
use App\Models\Gallery;
use App\Models\SiteSetting;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MediaAndAdsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. VIDEOS
        $videos = [
            [
                'title' => 'Inside ISRO Cleanrooms: How Engineers Built Gaganyaan’s Thermal Heat Shield',
                'title_hi' => 'इसरो के क्लीनरूम से विशेष रिपोर्ट: कैसे बना गगनयान का हीट शील्ड',
                'slug' => 'inside-isro-cleanrooms-gaganyaan-heat-shield',
                'youtube_id' => '21X5lGlDOfg',
                'duration' => '08:42',
                'thumbnail' => 'https://images.unsplash.com/photo-1517976487507-5989b651c4a4?auto=format&fit=crop&w=800&q=80',
                'description' => 'Exclusive walkthrough of the satellite assembly complex in Sriharikota, detailing the materials science behind atmospheric re-entry protection.',
                'description_hi' => 'श्रीहरिकोटा अंतरिक्ष केंद्र से विशेष वृत्तचित्र, जानिए कैसे अंतरिक्ष से धरती पर सुरक्षित लौटेगा क्रू मॉड्यूल।',
                'views_count' => 142000,
                'published_at' => Carbon::now()->subDays(1),
            ],
            [
                'title' => 'Groundwater & Solar Wells: What the Agrarian Energy Revolution Looks Like in Bundelkhand',
                'title_hi' => 'बुंदेलखंड से ग्राउंड रिपोर्ट: सोलर ऊर्जा से खेतों की सिंचाई और भूजल की हकीकत',
                'slug' => 'groundwater-solar-wells-bundelkhand-investigation',
                'youtube_id' => 'L_LUpnjgPso',
                'duration' => '12:15',
                'thumbnail' => 'https://images.unsplash.com/photo-1509391365360-2e959784a276?auto=format&fit=crop&w=800&q=80',
                'description' => 'Our investigative correspondent spends a week interviewing farming families in Mahoba as solar irrigation alters rural economics.',
                'description_hi' => 'महोबा के किसानों की ज़बानी: सोलर पंपों से बचत की कहानी और गिरते भूजल की नई चिंता।',
                'views_count' => 89000,
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'The Architecture of Dalal Street: Behind the High-Frequency Trading Desks',
                'title_hi' => 'दलाल स्ट्रीट की आधुनिक ट्रेडिंग: हाई-स्पीड एल्गोरिदम कैसे संचालित करते हैं शेयर बाज़ार',
                'slug' => 'architecture-of-dalal-street-high-frequency-trading',
                'youtube_id' => '1la40W93t44',
                'duration' => '09:30',
                'thumbnail' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=800&q=80',
                'description' => 'A behind-the-scenes look at institutional quantitative trading servers handling millions of microsecond stock transactions.',
                'description_hi' => 'बॉम्बे स्टॉक एक्सचेंज के एल्गोरिथमिक ट्रेडिंग फ्लोर से विशेष आर्थिक विश्लेषण।',
                'views_count' => 97000,
                'published_at' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'The Biomechanics of 150 km/h: Motion-Capturing Indian Fast Bowling at NCA',
                'title_hi' => '150 किमी/घंटा की रफ्तार का विज्ञान: नेशनल क्रिकेट एकेडमी में गेंदबाजों का बायोमैकेनिकल विश्लेषण',
                'slug' => 'biomechanics-of-fast-bowling-nca-bengaluru',
                'youtube_id' => 'kJQP7kiw5Fk',
                'duration' => '07:54',
                'thumbnail' => 'https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?auto=format&fit=crop&w=800&q=80',
                'description' => 'High-speed camera telemetry reveals how wrist-cock angles and front-foot bracing yield lethal reverse swing.',
                'description_hi' => 'हाई-स्पीड कैमरों और सेंसरों के जरिए जानिए कैसे तैयार होते हैं भारत के घातक तेज गेंदबाज।',
                'views_count' => 182000,
                'published_at' => Carbon::now()->subDays(4),
            ],
        ];

        foreach ($videos as $vid) {
            Video::updateOrCreate(['slug' => $vid['slug']], $vid);
        }

        // 2. GALLERIES
        $galleries = [
            [
                'title' => 'Photostory: The Living Root Bridges and Cloud Forests of Meghalaya',
                'title_hi' => 'तस्वीरों में: मेघालय के जीवित जड़ पुल और बादलों से घिरे घने जंगल',
                'slug' => 'photostory-living-root-bridges-meghalaya',
                'cover_image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1000&q=80',
                'description' => 'Centuries of Khasi bio-engineering showcased through morning mist, roaring waterfalls, and woven Ficus elastica roots.',
                'description_hi' => 'खासी समुदाय की सदियों पुरानी बायो-इंजीनियरिंग और पूर्वोत्तर भारत की अनुपम प्राकृतिक छटा।',
                'photos' => [
                    [
                        'url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1000&q=80',
                        'caption' => 'The double-decker living root bridge spanning the Umshiang river in Nongriat.',
                        'caption_hi' => 'नोंगरियात में उमशियांग नदी पर बना प्रसिद्ध डबल डेकर रूट ब्रिज।',
                    ],
                    [
                        'url' => 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=1000&q=80',
                        'caption' => 'Morning fog blankets the rolling hills of the East Khasi plateau.',
                        'caption_hi' => 'पूर्वी खासी पहाड़ियों पर सुबह के कोहरे का विहंगम दृश्य।',
                    ],
                    [
                        'url' => 'https://images.unsplash.com/photo-1426604966848-d7adac402bff?auto=format&fit=crop&w=1000&q=80',
                        'caption' => 'Pristine rainwater cascading down limestone ravines near Cherrapunji.',
                        'caption_hi' => 'चेरापूंजी के निकट चूना पत्थर की चट्टानों से गिरता प्राकृतिक जलप्रपात।',
                    ],
                ],
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Restoring the Past: Inside the Conservation of Ancient Chola Bronze Sculptures',
                'title_hi' => 'धरोहर का संरक्षण: प्राचीन चोल कांस्य मूर्तियों के रासायनिक पुनरुद्धार की दुर्लभ तस्वीरें',
                'slug' => 'restoring-the-past-chola-bronze-conservation',
                'cover_image' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=1000&q=80',
                'description' => 'Master metallurgical conservators painstakingly reverse centuries of micro-corrosion using ultrasound and non-destructive lasers.',
                'description_hi' => 'विशेषज्ञ पुरातत्वविदों द्वारा सदियों पुरानी कलाकृतियों को सहेजने के वैज्ञानिक प्रयास।',
                'photos' => [
                    [
                        'url' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=1000&q=80',
                        'caption' => 'Laser ablation of mineralized patina on a 10th-century Nataraja bronze arm.',
                        'caption_hi' => 'दसवीं शताब्दी की नटराज प्रतिमा पर लेजर तकनीक से किया जा रहा संरक्षण कार्य।',
                    ],
                    [
                        'url' => 'https://images.unsplash.com/photo-1582555172866-f73bb12a2ab3?auto=format&fit=crop&w=1000&q=80',
                        'caption' => 'Microscopic examination reveals the lost-wax casting technique used by imperial guild artisans.',
                        'caption_hi' => 'माइक्रोस्कोप द्वारा प्राचीन लॉस्ट-वैक्स धातु ढलाई तकनीक का विश्लेषण।',
                    ],
                ],
                'published_at' => Carbon::now()->subDays(3),
            ],
        ];

        foreach ($galleries as $gal) {
            Gallery::updateOrCreate(['slug' => $gal['slug']], $gal);
        }

        // 3. EPAPERS
        $epapers = [
            [
                'title' => 'National Edition - Daily Broadsheet',
                'title_hi' => 'राष्ट्रीय संस्करण - दैनिक ई-पेपर',
                'edition' => 'National',
                'date' => Carbon::today(),
                'pdf_url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=500&q=80',
                'pages_count' => 20,
            ],
            [
                'title' => 'Delhi Metro & Capital Edition',
                'title_hi' => 'दिल्ली मेट्रो व राजधानी संस्करण',
                'edition' => 'Delhi',
                'date' => Carbon::today(),
                'pdf_url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=500&q=80',
                'pages_count' => 16,
            ],
            [
                'title' => 'Mumbai Financial & Western Edition',
                'title_hi' => 'मुंबई वित्तीय व पश्चिमी संस्करण',
                'edition' => 'Mumbai',
                'date' => Carbon::today(),
                'pdf_url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1586339949916-3e9457bef6d3?auto=format&fit=crop&w=500&q=80',
                'pages_count' => 18,
            ],
            [
                'title' => 'Bengaluru Tech & Southern Edition',
                'title_hi' => 'बेंगलुरु टेक व दक्षिणी संस्करण',
                'edition' => 'Bengaluru',
                'date' => Carbon::today(),
                'pdf_url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1495020689067-958852a7765e?auto=format&fit=crop&w=500&q=80',
                'pages_count' => 16,
            ],
        ];

        foreach ($epapers as $epaper) {
            Epaper::updateOrCreate(
                ['edition' => $epaper['edition'], 'date' => $epaper['date']],
                $epaper
            );
        }

        // 4. ADS SLOTS
        $ads = [
            [
                'name' => 'Top Leaderboard Banner',
                'slot' => 'header_leaderboard',
                'type' => 'image',
                'image_url' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&h=120&q=80',
                'destination_url' => '#',
                'html_code' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Sidebar Premium Display',
                'slot' => 'sidebar_top',
                'type' => 'image',
                'image_url' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=400&h=300&q=80',
                'destination_url' => '#',
                'html_code' => null,
                'is_active' => true,
            ],
            [
                'name' => 'In-Article Sponsored Native',
                'slot' => 'in_article',
                'type' => 'image',
                'image_url' => 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?auto=format&fit=crop&w=800&h=200&q=80',
                'destination_url' => '#',
                'html_code' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Footer Sticky Promo',
                'slot' => 'sticky_footer',
                'type' => 'image',
                'image_url' => 'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?auto=format&fit=crop&w=1200&h=100&q=80',
                'destination_url' => '#',
                'html_code' => null,
                'is_active' => true,
            ],
        ];

        foreach ($ads as $ad) {
            Ad::updateOrCreate(['slot' => $ad['slot']], $ad);
        }

        // 5. COMMENTS
        $topArticles = Article::take(6)->get();
        $user = User::where('email', 'reader@news.com')->first();

        $commentsPool = [
            [
                'name' => 'Kavita Menon',
                'email' => 'kavita.m@example.com',
                'content' => 'A remarkably thorough piece. The emphasis on domestic value addition over simple assembly cannot be stressed enough if we want sustainable job growth.',
                'likes' => 38,
            ],
            [
                'name' => 'Arunav Sengupta',
                'email' => 'arunav.s@example.com',
                'content' => 'Very lucid breakdown of the legal nuances. The Chief Justice’s remarks on fiscal federalism will likely dictate how mining royalties are treated for the next decade.',
                'likes' => 24,
            ],
            [
                'name' => 'Nikhil Kulkarni',
                'email' => 'nikhil.k@example.com',
                'content' => 'Fascinating to see how sports biomechanics is finally taking center stage in India. The workload pacing telemetry reminds me of how Premier League clubs manage player health.',
                'likes' => 19,
            ],
            [
                'name' => 'Meera Bhattacharya',
                'email' => 'meera.b@example.com',
                'content' => 'The ground reality in Bundelkhand really puts things into perspective. Technology gives us solutions, but community stewardship is what actually sustains them.',
                'likes' => 45,
            ],
        ];

        foreach ($topArticles as $art) {
            foreach ($commentsPool as $cData) {
                $comment = Comment::create([
                    'article_id' => $art->id,
                    'user_id' => $user?->id,
                    'parent_id' => null,
                    'author_name' => $cData['name'],
                    'author_email' => $cData['email'],
                    'content' => $cData['content'],
                    'status' => 'approved',
                    'likes_count' => $cData['likes'],
                    'created_at' => Carbon::now()->subHours(rand(1, 8)),
                ]);

                // Create a threaded reply
                Comment::create([
                    'article_id' => $art->id,
                    'user_id' => null,
                    'parent_id' => $comment->id,
                    'author_name' => 'Prof. S. R. Ramanathan',
                    'author_email' => 'ramanathan@example.com',
                    'content' => 'Completely agree with '.$cData['name'].'. Furthermore, historical policy comparisons indicate that institutional continuity is the key ingredient.',
                    'status' => 'approved',
                    'likes_count' => 12,
                    'created_at' => Carbon::now()->subMinutes(rand(10, 50)),
                ]);
            }
        }

        // 6. SITE SETTINGS
        $settings = [
            ['key' => 'site_name', 'value' => 'THE CHRONICLE', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Independent Journalism. Global Perspective.', 'group' => 'general'],
            ['key' => 'site_name_hi', 'value' => 'द क्रॉनिकल', 'group' => 'general'],
            ['key' => 'site_tagline_hi', 'value' => 'स्वतंत्र पत्रकारिता। वैश्विक दृष्टिकोण।', 'group' => 'general'],
            ['key' => 'breaking_ticker_text', 'value' => 'Cabinet Clears Landmark High-Speed Freight & Semiconductor Corridor in ₹2.4 Lakh Crore Push | Sensex Crosses 81,500 | ISRO Gaganyaan Final Drop Tests Slated', 'group' => 'general'],
            ['key' => 'breaking_ticker_text_hi', 'value' => 'कैबिनेट ने 2.4 लाख करोड़ रुपये के इंफ्रास्ट्रक्चर प्रोजेक्ट को दी मंजूरी | सेंसेक्स 81,500 के पार | गगनयान का अंतिम कक्षीय परीक्षण जल्द', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'editorial@chronicle.news', 'group' => 'contact'],
            ['key' => 'phone_number', 'value' => '+91 (11) 4567 8900', 'group' => 'contact'],
            ['key' => 'office_address', 'value' => 'Chronicle House, 14 Bahadur Shah Zafar Marg, New Delhi 110002', 'group' => 'contact'],
            ['key' => 'weather_delhi', 'value' => json_encode(['city' => 'New Delhi', 'city_hi' => 'नई दिल्ली', 'temp' => '28°C', 'condition' => 'Clear Sky', 'condition_hi' => 'साफ आसमान', 'aqi' => '124 (Moderate)']), 'group' => 'weather'],
            ['key' => 'weather_mumbai', 'value' => json_encode(['city' => 'Mumbai', 'city_hi' => 'मुंबई', 'temp' => '31°C', 'condition' => 'Humid', 'condition_hi' => 'आर्द्र', 'aqi' => '88 (Good)']), 'group' => 'weather'],
            ['key' => 'weather_bengaluru', 'value' => json_encode(['city' => 'Bengaluru', 'city_hi' => 'बेंगलुरु', 'temp' => '24°C', 'condition' => 'Pleasant Breezy', 'condition_hi' => 'सुहावना मौसम', 'aqi' => '52 (Clean)']), 'group' => 'weather'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
