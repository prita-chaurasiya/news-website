<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;

class AuthorsSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::where('email', 'admin@news.com')->first();
        $editorUser = User::where('email', 'editor@news.com')->first();
        $journalistUser = User::where('email', 'journalist@news.com')->first();

        $authors = [
            [
                'name' => 'Rajeshwar Singh',
                'name_hi' => 'राजेश्वर सिंह',
                'slug' => 'rajeshwar-singh',
                'role_title' => 'National Affairs Editor',
                'role_title_hi' => 'राष्ट्रीय मामले संपादक',
                'bio' => 'Senior journalist with three decades covering Indian parliament, federal politics, and electoral shifts across North and South blocks.',
                'bio_hi' => 'तीन दशकों से भारतीय संसद, केंद्रीय राजनीति और चुनावी बदलावों को कवर करने वाले वरिष्ठ पत्रकार।',
                'avatar' => CuratedPhotoLibrary::$authors['rajeshwar-singh']['photo'],
                'email' => 'rajeshwar@news.com',
                'twitter_handle' => '@rajeshwar_journo',
                'is_featured' => true,
                'user_id' => $adminUser?->id,
            ],
            [
                'name' => 'Dr. Radhika Mehra',
                'name_hi' => 'डॉ. राधिका मेहरा',
                'slug' => 'dr-radhika-mehra',
                'role_title' => 'Chief Economic Analyst',
                'role_title_hi' => 'मुख्य आर्थिक विश्लेषक',
                'bio' => 'Former central bank consultant and economist specializing in macro monetary policy, capital markets, and international trade dynamics.',
                'bio_hi' => 'पूर्व केंद्रीय बैंक सलाहकार और अर्थशास्त्री, मौद्रिक नीति, पूंजी बाज़ार और वैश्विक व्यापार विशेषज्ञ।',
                'avatar' => CuratedPhotoLibrary::$authors['dr-radhika-mehra']['photo'],
                'email' => 'radhika.m@news.com',
                'twitter_handle' => '@radhika_econ',
                'is_featured' => true,
                'user_id' => $editorUser?->id,
            ],
            [
                'name' => 'Siddharth Joshi',
                'name_hi' => 'सिद्धार्थ जोशी',
                'slug' => 'siddharth-joshi',
                'role_title' => 'Tech & AI Bureau Chief',
                'role_title_hi' => 'तकनीक व एआई ब्यूरो प्रमुख',
                'bio' => 'Investigating frontier artificial intelligence models, semiconductor supply chains, cybersecurity threats, and tech antitrust debates.',
                'bio_hi' => 'आर्टिफिशियल इंटेलिजेंस, सेमीकंडक्टर आपूर्ति, साइबर सुरक्षा और तकनीकी नीतियों के अन्वेषक।',
                'avatar' => CuratedPhotoLibrary::$authors['siddharth-joshi']['photo'],
                'email' => 'siddharth.j@news.com',
                'twitter_handle' => '@siddharth_ai',
                'is_featured' => true,
                'user_id' => $journalistUser?->id,
            ],
            [
                'name' => 'Kabir Deshmukh',
                'name_hi' => 'कबीर देशमुख',
                'slug' => 'kabir-deshmukh',
                'role_title' => 'Diplomatic & Global Affairs Editor',
                'role_title_hi' => 'राजनयिक व वैश्विक संपादक',
                'bio' => 'Reporting from international summits, conflict zones, and UN corridors with a keen focus on Indo-Pacific maritime security.',
                'bio_hi' => 'वैश्विक सम्मेलनों, संघर्ष क्षेत्रों और संयुक्त राष्ट्र से इंडो-पैसिफिक कूटनीति के विश्लेषक।',
                'avatar' => CuratedPhotoLibrary::$authors['kabir-deshmukh']['photo'],
                'email' => 'kabir.d@news.com',
                'twitter_handle' => '@kabir_diplomat',
                'is_featured' => true,
                'user_id' => null,
            ],
            [
                'name' => 'Sunita Narayanan',
                'name_hi' => 'सुनीता नारायणन',
                'slug' => 'sunita-narayanan',
                'role_title' => 'Senior Sports Columnist',
                'role_title_hi' => 'वरिष्ठ खेल स्तंभकार',
                'bio' => 'Veteran sports writer tracking Indian cricket analytics, Olympic disciplines, and sports governance across Asia.',
                'bio_hi' => 'भारतीय क्रिकेट, ओलंपिक खेलों और खेल प्रशासन पर पैनी नज़र रखने वाली अनुभवी खेल लेखिका।',
                'avatar' => CuratedPhotoLibrary::$authors['sunita-narayanan']['photo'],
                'email' => 'sunita.n@news.com',
                'twitter_handle' => '@sunita_sports',
                'is_featured' => true,
                'user_id' => null,
            ],
            [
                'name' => 'Adv. Pradeep Verma',
                'name_hi' => 'एडवोकेट प्रदीप वर्मा',
                'slug' => 'pradeep-verma',
                'role_title' => 'Legal Affairs Correspondent',
                'role_title_hi' => 'कानूनी मामलों के संवाददाता',
                'bio' => 'Supreme Court and constitutional law specialist bringing clarity to judicial precedents, fundamental rights, and legislative reform.',
                'bio_hi' => 'सुप्रीम कोर्ट और संवैधानिक कानून विशेषज्ञ, न्यायिक फैसलों और मौलिक अधिकारों के विश्लेषक।',
                'avatar' => CuratedPhotoLibrary::$authors['pradeep-verma']['photo'],
                'email' => 'pradeep.v@news.com',
                'twitter_handle' => '@verma_legal',
                'is_featured' => false,
                'user_id' => null,
            ],
            [
                'name' => 'Tara Roy',
                'name_hi' => 'तारा रॉय',
                'slug' => 'tara-roy',
                'role_title' => 'Arts & Culture Critic',
                'role_title_hi' => 'कला व संस्कृति समीक्षक',
                'bio' => 'Reviewer of contemporary literature, South Asian indie cinema, public museums, and architectural restoration projects.',
                'bio_hi' => 'समकालीन साहित्य, भारतीय सिनेमा, कला प्रदर्शनियों और विरासत संरक्षण की समीक्षक।',
                'avatar' => CuratedPhotoLibrary::$authors['tara-roy']['photo'],
                'email' => 'tara.r@news.com',
                'twitter_handle' => '@tara_culture',
                'is_featured' => false,
                'user_id' => null,
            ],
            [
                'name' => 'Amitav Kashyap',
                'name_hi' => 'अमिताव कश्यप',
                'slug' => 'amitav-kashyap',
                'role_title' => 'Investigative Ground Reporter',
                'role_title_hi' => 'खोजी ज़मीनी रिपोर्टर',
                'bio' => 'Recipient of national reporting accolades, dedicated to climate change impacts on agrarian economies and rural public healthcare.',
                'bio_hi' => 'जलवायु परिवर्तन, ग्रामीण अर्थव्यवस्था और स्वास्थ्य व्यवस्था पर ज़मीनी पड़ताल के लिए सम्मानित पत्रकार।',
                'avatar' => CuratedPhotoLibrary::$authors['amitav-kashyap']['photo'],
                'email' => 'amitav.k@news.com',
                'twitter_handle' => '@amitav_ground',
                'is_featured' => true,
                'user_id' => null,
            ],
        ];

        foreach ($authors as $author) {
            Author::updateOrCreate(['slug' => $author['slug']], $author);
        }
    }
}
