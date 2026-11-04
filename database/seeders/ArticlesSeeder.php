<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticlesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all()->keyBy('slug');
        $authors = Author::all()->keyBy('slug');
        $tags = Tag::all()->keyBy('slug');

        $articlesData = [
            // ==========================================
            // 1. LEAD STORY (HERO 1) - Politics / Parliament
            // ==========================================
            [
                'category_slug' => 'politics',
                'author_slug' => 'rajeshwar-singh',
                'title' => 'Cabinet Clears Landmark High-Speed Freight & Semiconductor Corridor in ₹2.4 Lakh Crore Infrastructure Push',
                'title_hi' => 'कैबिनेट ने 2.4 लाख करोड़ रुपये के इंफ्रास्ट्रक्चर प्रोजेक्ट को दी मंजूरी, हाई-स्पीड फ्रेट और सेमीकंडक्टर कॉरिडोर का होगा निर्माण',
                'subtitle' => 'The multi-modal logistics corridor links six manufacturing states with deep-sea ports, offering duty incentives and indigenous silicon testbeds.',
                'subtitle_hi' => 'छह औद्योगिक राज्यों को गहरे समुद्र के बंदरगाहों से जोड़ने वाला यह मल्टी-मॉडल कॉरिडोर स्वदेशी सिलिकॉन विनिर्माण को देगा नई गति।',
                'excerpt' => 'In a decisive Cabinet Committee on Economic Affairs meeting chaired by the Prime Minister, the government approved an ambitious multi-modal logistics network designed to halve freight transit times across northern industrial hubs.',
                'excerpt_hi' => 'आर्थिक मामलों की कैबिनेट समिति ने उत्तर भारत के औद्योगिक केंद्रों से माल ढुलाई समय को आधा करने वाले महत्वाकांक्षी मल्टी-मॉडल लॉजिस्टिक्स नेटवर्क को ऐतिहासिक मंजूरी दी है।',
                'key_takeaways' => [
                    'en' => [
                        '₹2.4 lakh crore allocation across five fiscal years with 40% viability gap funding.',
                        'Targeted reduction in logistics costs from 14% to 8.5% of national GDP by 2030.',
                        'Dedicated green electricity feed-in tariffs guaranteed for participating industrial clusters.',
                        'Two state-of-the-art silicon fabrication packaging parks linked along the corridor route.',
                    ],
                    'hi' => [
                        'पांच वित्तीय वर्षों में 2.4 लाख करोड़ रुपये का आवंटन और 40% व्यवहार्यता अंतर अनुदान।',
                        '2030 तक राष्ट्रीय जीडीपी के 14% से घटाकर 8.5% पर लॉजिस्टिक्स लागत लाने का लक्ष्य।',
                        'सहभागी औद्योगिक समूहों के लिए समर्पित हरित बिजली आपूर्ति की गारंटी।',
                        'कॉरिडोर मार्ग पर दो अत्याधुनिक सिलिकॉन फैब्रिकेशन पैकेजिंग पार्क की स्थापना।',
                    ],
                ],
                'content' => '<p class="lead">In what senior policymakers describe as the most ambitious physical infrastructure initiative since the golden quadrilateral, the Union Cabinet on Wednesday sanctioned the comprehensive Pan-India High-Speed Logistics & Semiconductor Transit Corridor.</p>
                <p>The ₹2.4 lakh crore investment aims to transform India’s manufacturing competitiveness by cutting inter-state freight transit times by up to 52 per cent between Western port terminals and inland consumer clusters.</p>
                <blockquote>"This corridor is not merely asphalt and rail track; it is the strategic circulatory system for an economy racing toward five trillion dollars," declared the Minister of Commerce during the post-cabinet briefing.</blockquote>
                <h3>Phased Execution and Private Capital Mobilization</h3>
                <p>According to documents reviewed by this newspaper, the first phase covering 1,840 kilometers will be completed within 36 months under a hybrid annuity model. Institutional sovereign funds from Singapore and the UAE have already expressed intent to co-invest alongside domestic infrastructure trusts.</p>
                <p>Beyond bulk freight, the corridor reserves dedicated fiber-optic ducts and water recycling channels to supply cleanrooms in Gujarat, Maharashtra, and Karnataka, providing plug-and-play foundations for international chipmakers.</p>',
                'content_hi' => '<p class="lead">केंद्रीय मंत्रिमंडल ने बुधवार को देश के अब तक के सबसे बड़े मल्टी-मॉडल फ्रेट व सेमीकंडक्टर ट्रांजिट कॉरिडोर को आधिकारिक मंज़ूरी प्रदान कर दी है।</p>
                <p>2.4 लाख करोड़ रुपये की इस व्यापक परियोजना का मुख्य उद्देश्य माल ढुलाई में लगने वाले समय को 50 प्रतिशत से अधिक कम करना और भारत को वैश्विक आपूर्ति श्रृंखला का प्रमुख केंद्र बनाना है।</p>
                <blockquote>"यह कॉरिडोर केवल रेल और सड़क का ढांचा नहीं, बल्कि पांच ट्रिलियन डॉलर की अर्थव्यवस्था की जीवनरेखा है।" — वाणिज्य मंत्री</blockquote>
                <h3>तीन चरणों में पूरा होगा निर्माण</h3>
                <p>आधिकारिक दस्तावेजों के अनुसार पहले चरण का 1,840 किलोमीटर लंबा हिस्सा अगले 36 महीनों में पूरा किया जाएगा। कॉरिडोर के समानांतर ऑप्टिकल फाइबर और विशेष ऊर्जा ग्रिड बिछाए जाएंगे।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1541888946425-d0fbb186c5f7?auto=format&fit=crop&w=1200&q=80',
                'image_caption' => 'High-speed automated freight terminal under construction along the western freight route.',
                'image_caption_hi' => 'पश्चिमी माल ढुलाई मार्ग पर निर्माणाधीन अत्याधुनिक ऑटोमेटेड टर्मिनल।',
                'type' => 'standard',
                'is_featured' => true,
                'is_breaking' => true,
                'is_trending' => true,
                'is_premium' => false,
                'reading_time' => 6,
                'views_count' => 184500,
                'shares_count' => 4320,
                'published_at' => Carbon::now()->subHours(2),
                'tag_slugs' => ['budget-2026', 'startups', 'green-energy'],
            ],

            // ==========================================
            // 2. HERO SECONDARY 1 - Tech / AI
            // ==========================================
            [
                'category_slug' => 'tech',
                'author_slug' => 'siddharth-joshi',
                'title' => 'Open-Weight Multimodal AI Models Outperform Proprietary Giants in Indic Language Benchmarks',
                'title_hi' => 'ओपन-वेट एआई मॉडल्स ने इंडिक भाषा बेंचमार्क में वैश्विक कंपनियों को पछाड़ा',
                'subtitle' => 'Researchers from Bengaluru and Hyderabad unveil BharatLLM-3, delivering 94% conversational accuracy across 14 scheduled Indian languages.',
                'subtitle_hi' => 'बेंगलुरु और हैदराबाद के शोधकर्ताओं द्वारा विकसित भारतएलएलएम-3 ने 14 भारतीय भाषाओं में 94% सटीकता हासिल की।',
                'excerpt' => 'A homegrown consortium of independent AI researchers has released a breakthrough open-weights model capable of real-time translation, regional dialect synthesis, and complex legal reasoning in 14 Indian languages.',
                'excerpt_hi' => 'भारतीय एआई शोधकर्ताओं के एक समूह ने स्वदेशी ओपन-वेट मॉडल जारी किया है जो कानूनी व्याख्या और 14 भारतीय भाषाओं में सटीक अनुवाद करने में सक्षम है।',
                'key_takeaways' => [
                    'en' => [
                        'Trained on 8 trillion curated native tokens with zero syntactic hallucination on legal tests.',
                        'Runs locally on consumer-grade GPUs, enabling rural banking and telemedicine deployment.',
                        'Fully open under Apache 2.0 license for Indian developers and enterprise innovators.',
                    ],
                    'hi' => [
                        '8 ट्रिलियन प्रामाणिक भारतीय टोकन्स पर प्रशिक्षित, कानूनी परीक्षणों में शून्य भ्रामक निष्कर्ष।',
                        'सामान्य हार्डवेयर पर संचालित करने योग्य, जिससे ग्रामीण बैंकिंग और टेलीमेडिसिन को मिलेगा बल।',
                        'भारतीय डेवलपर्स के लिए अपाचे 2.0 लाइसेंस के तहत पूर्णतः मुफ्त उपलब्ध।',
                    ],
                ],
                'content' => '<p class="lead">In a significant stride for sovereign computing, a joint initiative between leading academic laboratories in Bengaluru has open-sourced BharatLLM-3, an advanced 70-billion-parameter foundation model.</p>
                <p>Unlike Western foundational models whose training corpora historically comprised less than two per cent Indian vernacular text, BharatLLM was architected from the ground up on state archives, literary digests, and court transcripts.</p>
                <blockquote>"Language is cultural epistemology. When you force Indian civil questions through translation layers, nuances of constitutional jurisprudence vanish," said the lead research fellow.</blockquote>',
                'content_hi' => '<p class="lead">भारतीय शोधकर्ताओं ने ओपन-सोर्स भारतएलएलएम-3 जारी कर तकनीकी संप्रभुता की दिशा में ऐतिहासिक उपलब्धि हासिल की है।</p>
                <p>यह 70 बिलियन पैरामीटर वाला मॉडल विशेष रूप से भारतीय सामाजिक, सांस्कृतिक और कानूनी संदर्भों के लिए प्रशिक्षित किया गया है।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=800&q=80',
                'image_caption' => 'Neural network visualization showing multilingual cross-attention layers.',
                'image_caption_hi' => 'बहुभाषी तंत्रिका नेटवर्क का क्रॉस-अटेंशन विज़ुअलाइज़ेशन।',
                'type' => 'explainer',
                'is_featured' => true,
                'is_breaking' => false,
                'is_trending' => true,
                'is_premium' => false,
                'reading_time' => 5,
                'views_count' => 142300,
                'shares_count' => 2980,
                'published_at' => Carbon::now()->subHours(4),
                'tag_slugs' => ['ai-revolution', 'startups'],
            ],

            // ==========================================
            // 3. HERO SECONDARY 2 - Business / Markets
            // ==========================================
            [
                'category_slug' => 'business',
                'author_slug' => 'dr-radhika-mehra',
                'title' => 'Sensex Surges Past 81,500 as Global Funds Pivot Back to Domestic Manufacturing and Defense Equities',
                'title_hi' => 'सेंसेक्स 81,500 के पार, विदेशी संस्थागत निवेशकों ने घरेलू मैन्युफैक्चरिंग और रक्षा शेयरों में की रिकॉर्ड लिवाली',
                'subtitle' => 'Foreign Portfolio Investors turned net buyers for the fifth straight session, pouring ₹12,800 crore into capital goods and renewables.',
                'subtitle_hi' => 'विदेशी पोर्टफोलियो निवेशकों ने लगातार पांचवें सत्र में शुद्ध खरीदारी करते हुए 12,800 करोड़ रुपये का निवेश किया।',
                'excerpt' => 'Bulls held firm control of Dalal Street on Wednesday morning, propelling benchmark indices to record intra-day territory behind massive institutional flows into capital goods and energy transition stocks.',
                'excerpt_hi' => 'दलाल स्ट्रीट पर आज सुबह तेजी का रुख रहा और पूंजीगत सामान व ऊर्जा क्षेत्र में भारी निवेश के चलते बेंचमार्क सूचकांकों ने नया कीर्तिमान बनाया।',
                'key_takeaways' => [
                    'en' => [
                        'Sensex gained 680 points to touch 81,540, led by heavyweights in engineering and electronics.',
                        'Domestic retail SIP inflows crossed ₹22,000 crore monthly milestone for the third time.',
                        'Yield on the 10-year benchmark government bond eased two basis points to 6.94%.',
                    ],
                    'hi' => [
                        'इंजीनियरिंग और इलेक्ट्रॉनिक्स शेयरों की अगुवाई में सेंसेक्स 680 अंक चढ़कर 81,540 पर पहुंचा।',
                        'घरेलू एसआईपी प्रवाह लगातार तीसरे महीने 22,000 करोड़ रुपये के पार रहा।',
                        '10-वर्षीय सरकारी बॉन्ड यील्ड घटकर 6.94% पर आई।',
                    ],
                ],
                'content' => '<p class="lead">Indian equity benchmarks extended their historic winning rally on Wednesday, with broad-based participation lifting both the BSE Sensex and NSE Nifty 50 to unprecedented highs.</p>
                <p>The rally was driven by robust order books among heavy engineering conglomerates and export expansion in aerospace components.</p>',
                'content_hi' => '<p class="lead">भारतीय शेयर बाज़ारों में बुधवार को लगातार बढ़त का सिलसिला जारी रहा, जिससे सेंसेक्स और निफ्टी नए रिकॉर्ड स्तर पर पहुंच गए।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=800&q=80',
                'image_caption' => 'Financial trading monitors displaying surging indices at Bombay Stock Exchange.',
                'image_caption_hi' => 'बॉम्बे स्टॉक एक्सचेंज पर तेजी दर्शाते वित्तीय ट्रेडिंग मॉनिटर्स।',
                'type' => 'standard',
                'is_featured' => true,
                'is_breaking' => false,
                'is_trending' => true,
                'is_premium' => false,
                'reading_time' => 4,
                'views_count' => 98400,
                'shares_count' => 1890,
                'published_at' => Carbon::now()->subHours(5),
                'tag_slugs' => ['stock-markets', 'budget-2026'],
            ],

            // ==========================================
            // 4. HERO SECONDARY 3 - World / Diplomacy
            // ==========================================
            [
                'category_slug' => 'world',
                'author_slug' => 'kabir-deshmukh',
                'title' => 'Indo-Pacific Naval Trilateral Concludes Live Sea Drills with Focus on Underwater Cable Security',
                'title_hi' => 'इंडो-पैसिफिक नौसैनिक अभ्यास संपन्न, समुद्र के नीचे संचार केबलों की सुरक्षा पर रहा विशेष जोर',
                'subtitle' => 'Naval forces from New Delhi, Canberra, and Tokyo deployed unmanned underwater vehicles across key choke points in the Malacca Strait.',
                'subtitle_hi' => 'भारत, ऑस्ट्रेलिया और जापान की नौसेनाओं ने मलक्का जलडमरूमध्य में मानवरहित पनडुब्बियों के जरिए किया संयुक्त अभ्यास।',
                'excerpt' => 'In a high-stakes demonstration of interoperability, naval task forces concluded joint maneuvers aimed at safeguarding submarine communications cables that carry 98 per cent of trans-continental digital data.',
                'excerpt_hi' => 'समुद्र के नीचे बिछी वैश्विक संचार केबलों की सुरक्षा सुनिश्चित करने के उद्देश्य से भारत, ऑस्ट्रेलिया और जापान ने संयुक्त नौसैनिक अभ्यास संपन्न किया।',
                'key_takeaways' => [
                    'en' => [
                        'First joint deployment of deep-sea unmanned reconnaissance submarines across maritime corridors.',
                        'Protocol established for immediate multinational response to acoustic anomalies near fiber repeaters.',
                        'Defense ministers scheduled to meet in New Delhi next month for institutionalized patrol framework.',
                    ],
                    'hi' => [
                        'समुद्री गलियारों में गहरे समुद्र के टोही ड्रोन का पहला संयुक्त परीक्षण।',
                        'फाइबर केबलों के पास संदिग्ध गतिविधियों पर त्वरित बहुराष्ट्रीय प्रतिक्रिया का प्रोटोकॉल तैयार।',
                        'अगले महीने नई दिल्ली में नियमित गश्ती समझौते पर हस्ताक्षर करेंगे रक्षा मंत्री।',
                    ],
                ],
                'content' => '<p class="lead">Naval forces from India, Australia, and Japan on Tuesday concluded five days of intensive tactical drills in the eastern Indian Ocean.</p>
                <p>The exercises focused on asymmetric underwater threats to the critical submarine data pipelines that underpin the modern global financial system.</p>',
                'content_hi' => '<p class="lead">भारत, ऑस्ट्रेलिया और जापान की नौसेनाओं ने हिंद महासागर में पांच दिवसीय गहन सामरिक अभ्यास पूरा किया।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?auto=format&fit=crop&w=800&q=80',
                'image_caption' => 'Guided-missile destroyer maneuvering during maritime security exercises.',
                'image_caption_hi' => 'संयुक्त अभ्यास के दौरान हिंद महासागर में गश्त करता युद्धपोत।',
                'type' => 'standard',
                'is_featured' => true,
                'is_breaking' => false,
                'is_trending' => false,
                'is_premium' => false,
                'reading_time' => 5,
                'views_count' => 67200,
                'shares_count' => 1120,
                'published_at' => Carbon::now()->subHours(6),
                'tag_slugs' => ['geopolitics', 'defense'],
            ],

            // ==========================================
            // 5. HERO SECONDARY 4 - Science / ISRO
            // ==========================================
            [
                'category_slug' => 'india',
                'author_slug' => 'siddharth-joshi',
                'title' => 'ISRO Unveils Gaganyaan Habitat Module Integration Ahead of Final Orbital Drop Test',
                'title_hi' => 'इसरो ने गगनयान के क्रू मॉड्यूल का किया सफल एकीकरण, अंतिम कक्षीय परीक्षण जल्द',
                'subtitle' => 'The Bengaluru-based space agency confirmed all environmental life-support systems have passed rigorous 96-hour vacuum chamber certifications.',
                'subtitle_hi' => 'इसरो ने पुष्टि की है कि गगनयान के क्रू मॉड्यूल ने वैक्यूम चैंबर में 96 घंटे के सभी सुरक्षा मानकों को सफलतापूर्वक पूरा कर लिया है।',
                'excerpt' => 'India’s human spaceflight program reached a major technical milestone on Tuesday as the flight-ready orbital module underwent end-to-end integration at the Satish Dhawan Space Centre in Sriharikota.',
                'excerpt_hi' => 'भारत के मानव अंतरिक्ष मिशन गगनयान ने उस समय एक और महत्वपूर्ण पड़ाव पार किया जब श्रीहरिकोटा में क्रू मॉड्यूल का सफल परीक्षण पूरा किया गया।',
                'key_takeaways' => [
                    'en' => [
                        'Environmental Control & Life Support System (ECLSS) certified for three crew members for 72 hours.',
                        'Indigenous parachute deceleration system verified via simulated supersonic jettison.',
                        'Final uncrewed orbital flight slated before the end of the second quarter.',
                    ],
                    'hi' => [
                        'पर्यावरण नियंत्रण और जीवन रक्षक प्रणाली तीन अंतरिक्ष यात्रियों के 72 घंटे के प्रवास हेतु प्रमाणित।',
                        'स्वदेशी पैराशूट प्रणाली का सुपरसोनिक गति पर सफल सत्यापन।',
                        'दूसरी तिमाही के अंत से पहले मानव रहित परीक्षण उड़ान प्रस्तावित।',
                    ],
                ],
                'content' => '<p class="lead">Engineers at the Indian Space Research Organisation (ISRO) have achieved structural and electrical integration of the Gaganyaan orbital module ahead of its crucial unmanned qualification flight.</p>
                <p>The 4.4-tonne crew module features proprietary thermal shielding engineered to endure re-entry temperatures exceeding 2,200 degrees Celsius.</p>',
                'content_hi' => '<p class="lead">भारतीय अंतरिक्ष अनुसंधान संगठन (इसरो) ने गगनयान मिशन के क्रू मॉड्यूल का सफल तकनीकी एकीकरण पूरा कर लिया है।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1517976487507-5989b651c4a4?auto=format&fit=crop&w=800&q=80',
                'image_caption' => 'The orbital vehicle crew capsule undergoing sensor calibration inside the cleanroom.',
                'image_caption_hi' => 'इसरो के क्लीनरूम में सेंसर कैलिब्रेशन से गुजरता हुआ गगनयान क्रू मॉड्यूल।',
                'type' => 'standard',
                'is_featured' => true,
                'is_breaking' => false,
                'is_trending' => true,
                'is_premium' => false,
                'reading_time' => 4,
                'views_count' => 112000,
                'shares_count' => 3100,
                'published_at' => Carbon::now()->subHours(7),
                'tag_slugs' => ['isro-space', 'tech'],
            ],

            // ==========================================
            // 6. LIVE BLOG STORY - Supreme Court Constitutional Bench
            // ==========================================
            [
                'category_slug' => 'india',
                'author_slug' => 'pradeep-verma',
                'title' => 'LIVE: Supreme Court 7-Judge Constitution Bench Hears Landmark Federal Taxation & Inter-State Goods Power Case',
                'title_hi' => 'लाइव: सुप्रीम कोर्ट की 7-सदस्यीय संविधान पीठ में अंतर-राज्यीय कर व संघवाद पर ऐतिहासिक सुनवाई जारी',
                'subtitle' => 'Live updates from Courtroom 1 as the Chief Justice and six senior judges deliberate on state fiscal autonomy versus central harmonization.',
                'subtitle_hi' => 'कोर्ट रूम 1 से लाइव अपडेट: राज्यों की वित्तीय स्वायत्तता और केंद्रीय शक्तियों के संतुलन पर शीर्ष अदालत में अहम बहस।',
                'excerpt' => 'A rare seven-judge bench of the Supreme Court is hearing oral arguments in a batch of constitutional petitions examining the sovereign power of states to levy local excise and environmental cesses.',
                'excerpt_hi' => 'सुप्रीम कोर्ट की सात जजों की संविधान पीठ राज्यों द्वारा स्थानीय कर और पर्यावरण उपकर लगाने के संवैधानिक अधिकारों पर सुनवाई कर रही है।',
                'key_takeaways' => [
                    'en' => [
                        'Chief Justice notes that fiscal federalism cannot be subordinated to administrative convenience.',
                        'Attorney General argues for uniform commercial taxonomy across all sovereign economic zones.',
                        'Verdict will establish definitive precedent for mining royalties and state mineral tariffs.',
                    ],
                    'hi' => [
                        'प्रधान न्यायाधीश ने कहा कि वित्तीय संघवाद को प्रशासनिक सुविधा के लिए गौण नहीं किया जा सकता।',
                        'महान्यायवादी ने सभी राज्यों में एकसमान व्यापारिक कर ढांचे की वकालत की।',
                        'फैसला खनन रॉयल्टी और राज्य खनिज शुल्कों के लिए निर्णायक मिसाल बनेगा।',
                    ],
                ],
                'content' => '<p class="lead"><strong>3:15 PM Update:</strong> The Chief Justice intervenes during arguments by Senior Counsel appearing for resource-rich states, inquiring whether cooperative federalism allows for asymmetric revenue rights when national security corridors are involved.</p>
                <p><strong>2:30 PM Update:</strong> Attorney General concludes his submissions on Article 246A, maintaining that parliamentary supremacy in international treaties extends to inter-state supply chains.</p>
                <p><strong>11:45 AM Update:</strong> The bench convenes to full capacity with senior counsels representing nine state governments present in Courtroom 1.</p>',
                'content_hi' => '<p class="lead"><strong>दोपहर 3:15 बजे:</strong> प्रधान न्यायाधीश ने सुनवाई के दौरान कहा कि सहकारी संघवाद के सिद्धांतों का पालन दोनों पक्षों को करना होगा।</p>
                <p><strong>दोपहर 2:30 बजे:</strong> अटॉर्नी जनरल ने अनुच्छेद 246ए पर अपनी दलीलें पूरी कीं।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80',
                'image_caption' => 'The pillars of the Supreme Court of India in New Delhi.',
                'image_caption_hi' => 'नई दिल्ली स्थित भारत के सर्वोच्च न्यायालय के स्तंभ।',
                'type' => 'live',
                'is_featured' => false,
                'is_breaking' => true,
                'is_trending' => true,
                'is_premium' => false,
                'reading_time' => 3,
                'views_count' => 156000,
                'shares_count' => 3800,
                'published_at' => Carbon::now()->subMinutes(25),
                'tag_slugs' => ['supreme-court', 'elections'],
            ],

            // ==========================================
            // 7. OPINION / EDITORIAL 1 (The Print style)
            // ==========================================
            [
                'category_slug' => 'opinion',
                'author_slug' => 'rajeshwar-singh',
                'title' => 'Why India’s Digital Public Infrastructure Has Rewritten the Washington Consensus',
                'title_hi' => 'भारत के डिजिटल पब्लिक इंफ्रास्ट्रक्चर ने कैसे बदल दी वैश्विक आर्थिक समझ',
                'subtitle' => 'By treating digital identity, payments, and data exchange as sovereign public goods, New Delhi proved that inclusive state capacity beats monopolistic Silicon Valley platforms.',
                'subtitle_hi' => 'डिजिटल पहचान, भुगतान और डेटा को सार्वजनिक संपत्ति मानकर भारत ने दिखाया कि जनकल्याणकारी तकनीक का मॉडल क्या होना चाहिए।',
                'excerpt' => 'When future economic historians look back at the third decade of the twenty-first century, they will not point to tariff barriers or subsidies as India’s definitive economic pivot. They will point to code.',
                'excerpt_hi' => 'भविष्य के अर्थशास्त्री जब इस सदी के तीसरे दशक का अध्ययन करेंगे, तो वे भारत के आर्थिक कायाकल्प के लिए डिजिटल इंफ्रास्ट्रक्चर को सबसे अहम मोड़ मानेंगे।',
                'key_takeaways' => [
                    'en' => [
                        'DPI lowered transaction friction for informal micro-merchants from 3.5% to virtually zero.',
                        'The tripartite model of open APIs, private innovation, and state regulation is being exported to 18 nations.',
                        'The next frontier is AI computing power as a subsidized public utility for tier-2 research labs.',
                    ],
                    'hi' => [
                        'डिजिटल पब्लिक इंफ्रास्ट्रक्चर ने छोटे व्यापारियों के लिए लेनदेन की लागत को शून्य के करीब पहुंचा दिया।',
                        'ओपन एपीआई और सार्वजनिक नियमन का यह मॉडल अब 18 देश अपना रहे हैं।',
                        'अगला चरण शोध प्रयोगशालाओं के लिए रियायती दरों पर एआई कंप्यूटिंग शक्ति उपलब्ध कराना है।',
                    ],
                ],
                'content' => '<p class="lead">When future economic historians look back at the third decade of the twenty-first century, they will not point to tariff barriers or subsidies as India’s definitive economic pivot. They will point to protocol layers and public rail.</p>
                <p>For forty years, international financial institutions preached a narrow orthodoxy: state bureaucracy should build roads, regulate currencies, and otherwise step aside while proprietary venture platforms extract platform rents.</p>
                <p>India rejected this false dichotomy. By treating identity (Aadhaar), instant settlements (UPI), and document verification (DigiLocker) as non-excludable public utilities, it fostered the most vibrant fintech ecosystem on the planet without creating platform oligarchies.</p>',
                'content_hi' => '<p class="lead">भारत ने दुनिया को दिखाया है कि तकनीक को एकाधिकार बनाने के बजाय जब जनता की संपत्ति बनाया जाता है, तो समाज का हर वर्ग सशक्त होता है।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=800&q=80',
                'image_caption' => 'Global fiber optic data streams connecting sovereign computing nodes.',
                'image_caption_hi' => 'वैश्विक डेटा नेटवर्क और डिजिटल इंफ्रास्ट्रक्चर का प्रतीकात्मक दृश्य।',
                'type' => 'opinion',
                'is_featured' => false,
                'is_breaking' => false,
                'is_trending' => true,
                'is_premium' => true,
                'reading_time' => 7,
                'views_count' => 89400,
                'shares_count' => 2450,
                'published_at' => Carbon::now()->subHours(8),
                'tag_slugs' => ['startups', 'ai-revolution'],
            ],

            // ==========================================
            // 8. OPINION / EDITORIAL 2
            // ==========================================
            [
                'category_slug' => 'opinion',
                'author_slug' => 'dr-radhika-mehra',
                'title' => 'The Rupee in the Age of Geopolitical Realignment: De-Dollarisation or Multilateral Hedging?',
                'title_hi' => 'भू-राजनीतिक पुनर्गठन के दौर में रुपया: डी-डॉलरीकरण या बहुपक्षीय संतुलन?',
                'subtitle' => 'Bilateral rupee settlements with ASEAN and the Gulf are prudent risk management, not ideological bravado. Here is why the dollar will retain its reserve anchor while trade invoicing diversifies.',
                'subtitle_hi' => 'आसियान और खाड़ी देशों के साथ द्विपक्षीय रुपये में व्यापार व्यावहारिक जोखिम प्रबंधन है। डॉलर की स्थिति और व्यापार के विविधीकरण का यथार्थवादी विश्लेषण।',
                'excerpt' => 'Talk of the dollar’s immediate demise is wildly exaggerated. However, the weaponisation of SWIFT has forced central banks from Riyadh to Jakarta to insulate at least a quarter of their trade books.',
                'excerpt_hi' => 'डॉलर के एकाधिकार पर बहस के बीच केंद्रीय बैंकों द्वारा अपनी व्यापारिक मुद्रा में विविधता लाने की रणनीति का गहन विश्लेषण।',
                'key_takeaways' => [
                    'en' => [
                        'Local currency settlement mechanisms have grown 340% year-on-year across crude oil imports.',
                        'RBI’s Vostro account architecture now spans 22 sovereign jurisdictions.',
                        'Capital account convertibility must remain gradual to guard against speculative liquidity shocks.',
                    ],
                    'hi' => [
                        'कच्चे तेल के आयात में स्थानीय मुद्रा निपटान तंत्र में साल-दर-साल 340% की वृद्धि हुई है।',
                        'आरबीआई का वोस्ट्रो खाता ढांचा अब 22 देशों में सक्रिय है।',
                        'सट्टेबाजी से बचाव के लिए पूंजी खाता परिवर्तनीयता को चरणबद्ध रखना आवश्यक है।',
                    ],
                ],
                'content' => '<p class="lead">Talk of the immediate demise of the US dollar as the world’s supreme reserve asset has become fashionable across seminar circuits. Yet empirical balance sheets tell a far more nuanced story.</p>
                <p>What we are witnessing is not abrupt replacement, but rather the structural birth of a multi-currency trade invoicing matrix.</p>',
                'content_hi' => '<p class="lead">अमेरिकी डॉलर के वर्चस्व और बहुपक्षीय व्यापार निपटान में रुपये की बढ़ती स्वीकार्यता का संतुलित विश्लेषण।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?auto=format&fit=crop&w=800&q=80',
                'image_caption' => 'Currency banknotes and financial trade indicators.',
                'image_caption_hi' => 'विदेशी मुद्रा और अंतरराष्ट्रीय व्यापार के संकेतक।',
                'type' => 'editorial',
                'is_featured' => false,
                'is_breaking' => false,
                'is_trending' => false,
                'is_premium' => true,
                'reading_time' => 8,
                'views_count' => 64100,
                'shares_count' => 1430,
                'published_at' => Carbon::now()->subHours(10),
                'tag_slugs' => ['budget-2026', 'geopolitics'],
            ],

            // ==========================================
            // 9. SPORTS - Cricket Analysis
            // ==========================================
            [
                'category_slug' => 'sports',
                'author_slug' => 'sunita-narayanan',
                'title' => 'Beyond the Boundaries: How Biomechanical Data and AI Bowler Tracking Revolutionized India’s Fast-Bowling Arsenal',
                'title_hi' => 'पिच से आगे: बायोमैकेनिक्स और एआई ने कैसे बदल दी भारतीय तेज गेंदबाजी की तस्वीर',
                'subtitle' => 'Inside the National Cricket Academy’s high-performance biomechanics lab, where workload algorithms and high-speed motion capture prevent stress fractures before they happen.',
                'subtitle_hi' => 'नेशनल क्रिकेट एकेडमी की अत्याधुनिक प्रयोगशाला से रिपोर्ट, जहां आधुनिक तकनीक से तेज गेंदबाजों की फिटनेस और गति को निखारा जा रहा है।',
                'excerpt' => 'Two decades ago, Indian fast bowlers were often characterized as honest workhorses who slowed down past their thirty-first over. Today, India boasts the most fearsome, relentless pace quartet in world cricket.',
                'excerpt_hi' => 'भारतीय तेज गेंदबाजी के परिवर्तन की वैज्ञानिक यात्रा: कैसे आधुनिक मोशन कैप्चर और वर्कलोड मैनेजमेंट ने भारतीय पेस अटैक को दुनिया का सबसे खतरनाक आक्रमण बनाया।',
                'key_takeaways' => [
                    'en' => [
                        'NCA monitors 120 kinematic markers at 1,000 frames per second during practice deliveries.',
                        'Injury recurrence among frontline fast bowlers dropped 62% over three domestic seasons.',
                        'Personalized recovery cycles adjust bowling workloads based on sleep telemetry and heart rate variability.',
                    ],
                    'hi' => [
                        'प्रैक्टिस के दौरान प्रति सेकंड 1,000 फ्रेम पर 120 काइनेमैटिक मार्करों की निगरानी की जाती है।',
                        'पिछले तीन सत्रों में प्रमुख गेंदबाजों के चोटिल होने की दर में 62% की कमी आई है।',
                        'नींद और हृदय गति के डेटा के आधार पर गेंदबाजों का वर्कलोड तय किया जाता है।',
                    ],
                ],
                'content' => '<p class="lead">Two decades ago, visiting teams arrived on the subcontinent expecting spin traps on day one and harmless seamers who faded after twelve overs. That era has been decisively consigned to history.</p>
                <p>The transformation of Indian pace bowling is the product of meticulous athletic science, institutional sports medicine, and mathematical workload pacing.</p>',
                'content_hi' => '<p class="lead">भारतीय तेज गेंदबाजी का उदय केवल प्रतिभा का परिणाम नहीं, बल्कि गहन वैज्ञानिक अनुसंधान और एथलेटिक प्रबंधन का कमाल है।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?auto=format&fit=crop&w=800&q=80',
                'image_caption' => 'A cricket leather ball illuminated under stadium floodlights during an evening test session.',
                'image_caption_hi' => 'स्टेडियम की फ्लडलाइट्स के नीचे क्रिकेट की लाल गेंद।',
                'type' => 'standard',
                'is_featured' => false,
                'is_breaking' => false,
                'is_trending' => true,
                'is_premium' => false,
                'reading_time' => 6,
                'views_count' => 124000,
                'shares_count' => 4100,
                'published_at' => Carbon::now()->subHours(11),
                'tag_slugs' => ['cricket'],
            ],

            // ==========================================
            // 10. GROUND REPORT / AGRARIAN (Amitav Kashyap)
            // ==========================================
            [
                'category_slug' => 'india',
                'author_slug' => 'amitav-kashyap',
                'title' => 'Ground Report: In Bundelkhand’s Solar Wells, Farmers Discover That Abundant Power Needs Wise Groundwater Stewardship',
                'title_hi' => 'ग्राउंड रिपोर्ट: बुंदेलखंड में सोलर पंपों से खेतों में हरियाली, लेकिन भूजल संरक्षण की नई चुनौती',
                'subtitle' => 'The PM-KUSUM solar revolution has eliminated diesel bills for 85,000 agrarian households, but falling aquifers demand immediate micro-drip mandates.',
                'subtitle_hi' => 'सोलर पंपों ने किसानों को महंगे डीजल से मुक्ति तो दिलाई है, लेकिन गिरते जलस्तर ने ड्रिप सिंचाई और जल प्रबंधन की मांग तेज कर दी है।',
                'excerpt' => 'Standing in his lush field of black gram in Mahoba, fifty-two-year-old Ramphal Kushwaha points with pride to the solar array glistening on his pump shed. Four years ago, diesel took half his harvest profit.',
                'excerpt_hi' => 'महोबा के खेतों से पड़ताल: सोलर सिंचाई ने बुंदेलखंड के किसानों की जिंदगी कैसे बदली और अब भूजल बचाने के लिए किन नए कदमों की जरूरत है।',
                'key_takeaways' => [
                    'en' => [
                        'Solar pumps cut annual household energy expenditures by ₹48,000 on average across drought belts.',
                        'Satellite data shows localized water tables dropping 1.8 meters annually where flood irrigation persists.',
                        'Community water cooperatives in 14 villages have instituted self-imposed daily pumping ceilings.',
                    ],
                    'hi' => [
                        'सोलर पंपों से किसानों के सालाना ईंधन खर्च में औसतन 48,000 रुपये की बचत हुई है।',
                        'बाढ़ सिंचाई जारी रहने वाले इलाकों में भूजल स्तर में सालाना 1.8 मीटर की गिरावट दर्ज की गई।',
                        '14 गांवों में किसानों ने पानी के अति-दोहन को रोकने के लिए सामुदायिक नियम बनाए हैं।',
                    ],
                ],
                'content' => '<p class="lead">Under the blistering midday sun of Bundelkhand, the drone of diesel generator pumps used to be the soundscape of agriculture. Today, there is only the quiet hum of an electric inverter and the rush of cool water into brick channels.</p>
                <p>The solar pumping revolution has fundamentally altered the economics of marginal farming across central India. Yet, as with all technological boons, it brings an urgent ecological reckoning.</p>',
                'content_hi' => '<p class="lead">बुंदेलखंड के गांवों में सोलर ऊर्जा ने किसानों की लागत को कम कर नई उम्मीदें जगाई हैं, लेकिन साथ ही भूजल संरक्षण की जिम्मेदारी भी बढ़ाई है।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1509391365360-2e959784a276?auto=format&fit=crop&w=800&q=80',
                'image_caption' => 'Photovoltaic panels installed on agrarian land providing zero-emission irrigation.',
                'image_caption_hi' => 'खेतों में स्थापित सोलर पैनल जिनसे स्वच्छ ऊर्जा से सिंचाई हो रही है।',
                'type' => 'standard',
                'is_featured' => false,
                'is_breaking' => false,
                'is_trending' => false,
                'is_premium' => true,
                'reading_time' => 7,
                'views_count' => 45600,
                'shares_count' => 980,
                'published_at' => Carbon::now()->subHours(12),
                'tag_slugs' => ['green-energy', 'climate-crisis'],
            ],

            // ==========================================
            // 11. CULTURE & ENTERTAINMENT
            // ==========================================
            [
                'category_slug' => 'entertainment',
                'author_slug' => 'tara-roy',
                'title' => 'The Quiet Renaissance of Regional Indian Cinema: Why Narrative Honesty is Trouncing Big-Budget Spectacle',
                'title_hi' => 'क्षेत्रीय भारतीय सिनेमा का नया स्वर्णिम दौर: क्यों बड़े बजट के तमाशे पर भारी पड़ रही है सच्ची कहानियां',
                'subtitle' => 'From Malayalam rural dramas to Marathi social satire, mid-budget films rooted in local ethos are dominating box offices and streaming queues nationwide.',
                'subtitle_hi' => 'मलयालम ग्रामीण कथाओं से लेकर मराठी व्यंग्य तक, अपनी जड़ों से जुड़ी फिल्में दर्शकों के दिलों पर राज कर रही हैं।',
                'excerpt' => 'Audiences weary of cookie-cutter CGI blockbusters and repetitive superhero tropes are flocking to films with grounded characters, conversational dialect, and moral complexity.',
                'excerpt_hi' => 'नकली वीएफएक्स और पुरानी कहानियों से ऊब चुके दर्शक अब स्थानीय संस्कृति और गहरे इंसानी रिश्तों पर आधारित सिनेमा को प्राथमिकता दे रहे हैं।',
                'key_takeaways' => [
                    'en' => [
                        'Regional language productions captured 58% of nationwide theatrical receipts this quarter.',
                        'Average production budgets under ₹25 crore are yielding return multiples of 4x to 8x.',
                        'Subtitle literacy among Hindi heartland streaming audiences has surged past 74%.',
                    ],
                    'hi' => [
                        'इस तिमाही में कुल बॉक्स ऑफिस कमाई में क्षेत्रीय भाषा की फिल्मों की हिस्सेदारी 58% रही।',
                        '25 करोड़ से कम बजट वाली फिल्में 4 से 8 गुना तक मुनाफा कमा रही हैं।',
                        'हिंदी पट्टी के दर्शकों में सबटाइटल के साथ अन्य भारतीय भाषाओं की फिल्में देखने का रुझान 74% बढ़ा।',
                    ],
                ],
                'content' => '<p class="lead">Something profound has shifted in the collective cinematic appetite of the Indian subcontinent. The era where a star name and a generic foreign action choreographer could guarantee a hundred-crore opening weekend is drawing to an unceremonious close.</p>
                <p>In its place has emerged a discerning, subtitle-fluent viewership that rewards storytelling authenticity above all else.</p>',
                'content_hi' => '<p class="lead">भारतीय सिनेमा में एक सुखद बदलाव देखने को मिल रहा है जहां बड़े बजट के बजाय बेहतरीन पटकथा और अभिनय को दर्शक सराह रहे हैं।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&w=800&q=80',
                'image_caption' => 'The illuminated marquee of an independent classic movie theater.',
                'image_caption_hi' => 'सिनेमा थियेटर का दृश्य जहां दर्शकों की भीड़ उमड़ रही है।',
                'type' => 'standard',
                'is_featured' => false,
                'is_breaking' => false,
                'is_trending' => true,
                'is_premium' => false,
                'reading_time' => 5,
                'views_count' => 78900,
                'shares_count' => 2100,
                'published_at' => Carbon::now()->subHours(14),
                'tag_slugs' => ['cinema'],
            ],

            // ==========================================
            // 12. LIFESTYLE & HEALTH
            // ==========================================
            [
                'category_slug' => 'lifestyle',
                'author_slug' => 'tara-roy',
                'title' => 'Circadian Fasting and Traditional Millets: How Ancient Indian Nutritional Wisdom is Validated by Modern Epigenetics',
                'title_hi' => 'पारंपरिक मिलेट्स और भोजन का समय: आधुनिक विज्ञान ने भी मानी प्राचीन भारतीय खान-पान की श्रेष्ठता',
                'subtitle' => 'Clinical trials at All India Institute of Medical Sciences demonstrate that ragi and bajra reduce HbA1c spikes by 38% compared to polished grains.',
                'subtitle_hi' => 'एम्स के क्लीनिकल परीक्षणों में साबित हुआ कि रागी और बाजरा जैसे मोटे अनाज ब्लड शुगर और मेटाबॉलिक स्वास्थ्य के लिए बेहद लाभकारी हैं।',
                'excerpt' => 'For decades, urban Indian dining tables abandoned humble coarse grains in pursuit of white refined wheat and polished rice. Now, molecular biology is confirming what grandmotherly kitchen lore insisted on all along.',
                'excerpt_hi' => 'आधुनिक शोध में यह स्पष्ट हुआ है कि मौसमी और स्थानीय मोटे अनाज शरीर की रोग प्रतिरोधक क्षमता और दीर्घायु के लिए सर्वोत्तम हैं।',
                'key_takeaways' => [
                    'en' => [
                        'High resistant starch in pearl millet promotes beneficial gut microbiota and lowers insulin resistance.',
                        'Consuming heavy meals before sunset aligns with circadian expression of digestive metabolic genes.',
                        'Global culinary chefs are reinventing traditional Indian grains into contemporary fine-dining staples.',
                    ],
                    'hi' => [
                        'बाजरे में मौजूद प्रतिरोधी स्टार्च आंतों के स्वास्थ्य को सुधारता है और इंसुलिन प्रतिरोध को कम करता है।',
                        'सूर्यास्त से पहले भोजन करने से पाचन क्रिया और मेटाबॉलिज्म संतुलित रहता है।',
                        'वैश्विक स्तर पर शेफ अब भारतीय मोटे अनाजों को आधुनिक व्यंजनों में शामिल कर रहे हैं।',
                    ],
                ],
                'content' => '<p class="lead">In an era plagued by sedentary metabolic disorders and ultra-processed food dependencies, an ancient culinary philosophy is orchestrating an evidence-based comeback.</p>
                <p>Millets, once dismissed as coarse subsistence food, are now recognized as nutritional powerhouses capable of reversing pre-diabetic trajectories.</p>',
                'content_hi' => '<p class="lead">स्वास्थ्य और पोषण के क्षेत्र में अब मोटे अनाजों (मिलेट्स) को सुपरफूड के रूप में नई वैश्विक पहचान मिल रही है।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?auto=format&fit=crop&w=800&q=80',
                'image_caption' => 'Nutrient-rich bowls of organic grains, seeds, and fresh garden vegetables.',
                'image_caption_hi' => 'पारंपरिक मोटे अनाज और ताजे फल-सब्जियों से युक्त संतुलित आहार।',
                'type' => 'standard',
                'is_featured' => false,
                'is_breaking' => false,
                'is_trending' => false,
                'is_premium' => false,
                'reading_time' => 5,
                'views_count' => 52300,
                'shares_count' => 1760,
                'published_at' => Carbon::now()->subHours(16),
                'tag_slugs' => ['health-medicine', 'green-energy'],
            ],
        ];

        // Seed the 12 highly detailed articles first
        foreach ($articlesData as $item) {
            $cat = $categories->get($item['category_slug']);
            $auth = $authors->get($item['author_slug']);

            if (! $cat || ! $auth) {
                continue;
            }

            $article = Article::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'category_id' => $cat->id,
                    'author_id' => $auth->id,
                    'title' => $item['title'],
                    'title_hi' => $item['title_hi'],
                    'slug' => Str::slug($item['title']),
                    'slug_hi' => Str::slug($item['title_hi']),
                    'subtitle' => $item['subtitle'],
                    'subtitle_hi' => $item['subtitle_hi'],
                    'excerpt' => $item['excerpt'],
                    'excerpt_hi' => $item['excerpt_hi'],
                    'key_takeaways' => $item['key_takeaways'],
                    'content' => $item['content'],
                    'content_hi' => $item['content_hi'],
                    'featured_image' => $item['featured_image'],
                    'image_caption' => $item['image_caption'],
                    'image_caption_hi' => $item['image_caption_hi'],
                    'image_credit' => $item['image_credit'] ?? 'Photo: Unsplash',
                    'type' => $item['type'],
                    'status' => 'published',
                    'is_featured' => $item['is_featured'],
                    'is_breaking' => $item['is_breaking'],
                    'is_trending' => $item['is_trending'],
                    'is_premium' => $item['is_premium'],
                    'reading_time' => $item['reading_time'],
                    'audio_url' => null,
                    'meta_title' => $item['title'],
                    'meta_title_hi' => $item['title_hi'],
                    'meta_description' => $item['excerpt'],
                    'meta_description_hi' => $item['excerpt_hi'],
                    'views_count' => $item['views_count'],
                    'shares_count' => $item['shares_count'],
                    'published_at' => $item['published_at'],
                ]
            );

            // Attach tags
            if (! empty($item['tag_slugs'])) {
                $tagIds = [];
                foreach ($item['tag_slugs'] as $tslug) {
                    if ($t = $tags->get($tslug)) {
                        $tagIds[] = $t->id;
                    }
                }
                $article->tags()->sync($tagIds);
            }
        }

        // ==========================================
        // SEED ADDITIONAL 54 ARTICLES TO REACH 66 ARTICLES
        // Across Politics, India, World, Business, Tech, Sports, Opinion, Entertainment, Lifestyle
        // ==========================================
        $editorialTemplates = [
            'politics' => [
                [
                    'en' => 'Parliament Committee Proposes Comprehensive Data Privacy Framework for Electoral Roll Digitization',
                    'hi' => 'संसदीय समिति ने मतदाता सूची के डिजिटलीकरण हेतु सख्त डेटा गोपनीयता नियमों की सिफारिश की',
                    'sub_en' => 'Biometric anonymization safeguards and mandatory tri-annual security audits recommended to all state election commissions.',
                    'sub_hi' => 'सभी राज्य चुनाव आयोगों के लिए बायोमेट्रिक सुरक्षा और त्रैवार्षिक ऑडिट अनिवार्य करने का प्रस्ताव।',
                    'img' => 'https://images.unsplash.com/photo-1540910419892-4a36d2c3266c?auto=format&fit=crop&w=800&q=80',
                    'views' => 64000,
                    'breaking' => true,
                ],
                [
                    'en' => 'States Demand Expansion of Central Tax Divisible Pool in Upcoming Finance Commission Deliberations',
                    'hi' => 'आगामी वित्त आयोग की बैठकों में राज्यों ने केंद्रीय करों के विभाज्य पूल को बढ़ाने की मांग रखी',
                    'sub_en' => 'Fiscal autonomy and demographic weighting criteria emerge as primary topics of debate between states and center.',
                    'sub_hi' => 'राज्यों और केंद्र के बीच वित्तीय स्वायत्तता और जनसांख्यिकीय भार मुख्य चर्चा का विषय बने।',
                    'img' => 'https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?auto=format&fit=crop&w=800&q=80',
                    'views' => 48000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Clean Energy Mandate: Municipal Corporations Directed to Transition 80% Fleet to Electric Vehicles',
                    'hi' => 'स्वच्छ ऊर्जा निर्देश: नगर निगमों को 80% वाहन बेड़े को इलेक्ट्रिक वाहनों में बदलने का आदेश',
                    'sub_en' => 'Urban local bodies in tier-1 cities receive direct green bond financing to deploy zero-emission public transport.',
                    'sub_hi' => 'टियर-1 शहरों के नगर निकायों को शून्य-उत्सर्जन परिवहन के लिए ग्रीन बॉन्ड से मिलेगी वित्तीय सहायता।',
                    'img' => 'https://images.unsplash.com/photo-1558441719-74e892c55e10?auto=format&fit=crop&w=800&q=80',
                    'views' => 39500,
                    'breaking' => false,
                ],
                [
                    'en' => 'Civil Aviation Ministry Finalizes Fast-Track Clearances for 24 New Regional Greenfield Airports',
                    'hi' => 'नागरिक उड्डयन मंत्रालय ने 24 नए क्षेत्रीय ग्रीनफील्ड हवाई अड्डों के लिए तेज़ मंज़ूरी प्रक्रिया तय की',
                    'sub_en' => 'Tier-2 and tier-3 industrial centers to connect with metropolitan cargo terminals by late next year.',
                    'sub_hi' => 'टियर-2 और टियर-3 शहर अगले वर्ष के अंत तक सीधे मेट्रो कार्गो टर्मिनलों से जुड़ेंगे।',
                    'img' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&w=800&q=80',
                    'views' => 52000,
                    'breaking' => false,
                ],
                [
                    'en' => 'National Highway Authority Achieves Record 38 Kilometers Per Day Paving Speed on Delhi-Mumbai Expressways',
                    'hi' => 'एनएचएआई ने दिल्ली-मुंबई एक्सप्रेसवे पर प्रतिदिन 38 किलोमीटर सड़क निर्माण का नया रिकॉर्ड बनाया',
                    'sub_en' => 'Automated GPS-guided bitumen pavers and drone surveillance accelerate construction ahead of monsoon season.',
                    'sub_hi' => 'ऑटोमेटेड जीपीएस पेवर्स और ड्रोन निगरानी से मानसून से पहले निर्माण कार्य में आई अभूतपूर्व तेजी।',
                    'img' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=800&q=80',
                    'views' => 41200,
                    'breaking' => false,
                ],
                [
                    'en' => 'Lok Sabha Passes Comprehensive Merchant Shipping Bill to Elevate Indian Flagged Vessel Share',
                    'hi' => 'लोकसभा ने भारतीय जहाजों की वैश्विक हिस्सेदारी बढ़ाने के लिए मर्चेंट शिपिंग विधेयक पारित किया',
                    'sub_en' => 'Fiscal incentives and streamlined tonnage taxation positioned to attract international fleet registration.',
                    'sub_hi' => 'भारतीय तटों पर जहाजों के पंजीकरण को बढ़ावा देने के लिए कर छूट और सरल नियमों का प्रावधान।',
                    'img' => 'https://images.unsplash.com/photo-1518241353330-0f7941c2d9b5?auto=format&fit=crop&w=800&q=80',
                    'views' => 31000,
                    'breaking' => false,
                ],
            ],

            'india' => [
                [
                    'en' => 'Varanasi International Stadium Nears Completion with Sustainable Bamboo Architecture and Solar Roofs',
                    'hi' => 'वाराणसी अंतरराष्ट्रीय स्टेडियम का निर्माण अंतिम चरण में, बांस वास्तुकला और सौर ऊर्जा से होगा संचालित',
                    'sub_en' => 'The 30,000-seater green stadium incorporates crescent moon canopies and zero-liquid discharge treatment plants.',
                    'sub_hi' => '30,000 दर्शक क्षमता वाला यह हरित स्टेडियम सौर ऊर्जा और जल पुनर्चक्रण तकनीक से लैस है।',
                    'img' => 'https://images.unsplash.com/photo-1577223625816-7546f13df25d?auto=format&fit=crop&w=800&q=80',
                    'views' => 58000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Western Ghats Ecology Board Approves Wildlife Overpasses Across Konkan Railway Expansion',
                    'hi' => 'पश्चिमी घाट पर्यावरण बोर्ड ने कोंकण रेलवे विस्तार पर वन्यजीव ओवरपास को दी मंजूरी',
                    'sub_en' => 'Elevated viaducts and acoustic baffling walls will ensure elephant corridors remain undisturbed by freight trains.',
                    'sub_hi' => 'हाथियों के प्राकृतिक आवागमन गलियारों की सुरक्षा के लिए बनाए जाएंगे विशेष साउंडप्रूफ ओवरपास।',
                    'img' => 'https://images.unsplash.com/photo-1534567153574-2b12153a87f0?auto=format&fit=crop&w=800&q=80',
                    'views' => 44100,
                    'breaking' => false,
                ],
                [
                    'en' => 'Bengaluru Tech Corridor Upgrades Stormwater Drain Network with IoT Flood Sensors',
                    'hi' => 'बेंगलुरु टेक कॉरिडोर में बाढ़ रोकथाम के लिए आईओटी सेंसर और आधुनिक ड्रेनेज नेटवर्क तैयार',
                    'sub_en' => 'Machine learning telemetry predicts localized waterlogging 45 minutes ahead of torrential cloudbursts.',
                    'sub_hi' => 'मशीन लर्निंग आधारित सेंसर भारी बारिश के 45 मिनट पहले जलभराव की चेतावनी देंगे।',
                    'img' => 'https://images.unsplash.com/photo-1519501025264-65ba15a82390?auto=format&fit=crop&w=800&q=80',
                    'views' => 61000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Archaeological Survey Unearths 2,400-Year-Old Iron Age Smelting Workshop in Odisha',
                    'hi' => 'ओडिशा में भारतीय पुरातत्व सर्वेक्षण ने 2,400 साल पुरानी लौह युगीन भट्ठी और कार्यशाला की खोज की',
                    'sub_en' => 'High-carbon steel ingots demonstrate sophisticated metallurgy contemporaneous with the Mauryan empire.',
                    'sub_hi' => 'मौर्य काल के समकालीन उच्च-कार्बन स्टील सिल्लियां प्राचीन भारतीय धातुकर्म की श्रेष्ठता दर्शाती हैं।',
                    'img' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=800&q=80',
                    'views' => 38000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Ladakh Glacier Monitoring Unit Reports Stable Ice Mass Following Winter Conservation Efforts',
                    'hi' => 'लद्दाख ग्लेशियर निगरानी इकाई ने शीतकालीन संरक्षण प्रयासों के बाद बर्फ की स्थिति को स्थिर बताया',
                    'sub_en' => 'Artificial ice stupas and community snow harvesting prove effective in recharging high-altitude aquifers.',
                    'sub_hi' => 'कृत्रिम आइस स्तूप और सामुदायिक प्रयासों से ऊंचाई वाले इलाकों में जलस्रोतों को पुनर्जीवित करने में सफलता।',
                    'img' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=800&q=80',
                    'views' => 49500,
                    'breaking' => false,
                ],
                [
                    'en' => 'Kashmir Saffron Harvest Crosses Decade High as GI Tagging Eliminates Adulteration',
                    'hi' => 'जीआई टैगिंग के असर से कश्मीरी केसर की पैदावार और निर्यात में एक दशक का सबसे बड़ा उछाल',
                    'sub_en' => 'Direct farmer-to-buyer traceability portals guarantee record farmgate prices for Pampore growers.',
                    'sub_hi' => 'डिजिटल ट्रेसिबिलिटी पोर्टल के जरिए पंपोर के किसानों को मिला अपनी फसल का रिकॉर्ड मूल्य।',
                    'img' => 'https://images.unsplash.com/photo-1599940824399-b87987ceb72a?auto=format&fit=crop&w=800&q=80',
                    'views' => 42000,
                    'breaking' => false,
                ],
            ],

            'world' => [
                [
                    'en' => 'Geneva Climate Summit Reaches Accord on Global Carbon Credit Verifiability Protocol',
                    'hi' => 'जिनेवा जलवायु सम्मेलन में वैश्विक कार्बन क्रेडिट सत्यापन प्रोटोकॉल पर बनी सहमति',
                    'sub_en' => 'Standardized satellite audits will prevent greenwashing and credit double-counting across continents.',
                    'sub_hi' => 'उपग्रह निगरानी से कार्बन क्रेडिट की दोहरी गणना और भ्रामक दावों पर लगेगी प्रभावी रोक।',
                    'img' => 'https://images.unsplash.com/photo-1569163139599-0f4517e36f51?auto=format&fit=crop&w=800&q=80',
                    'views' => 53000,
                    'breaking' => false,
                ],
                [
                    'en' => 'European Union Mandates Interoperable Battery Swapping for Light Urban Delivery Fleets',
                    'hi' => 'यूरोपीय संघ ने डिलीवरी वाहनों के लिए मानकीकृत बैटरी स्वैपिंग प्रणाली को किया अनिवार्य',
                    'sub_en' => 'New rules require universal modular pack dimensions by 2028 across all commercial electric two-wheelers.',
                    'sub_hi' => '2028 तक सभी व्यावसायिक इलेक्ट्रिक दोपहिया वाहनों के लिए एकसमान बैटरी पैक का नियम लागू।',
                    'img' => 'https://images.unsplash.com/photo-1517524008697-84bbe3c3fd98?auto=format&fit=crop&w=800&q=80',
                    'views' => 36500,
                    'breaking' => false,
                ],
                [
                    'en' => 'Global Energy Watchdog Raises 2030 Renewable Projection by 28% Driven by Asian Deployments',
                    'hi' => 'अंतरराष्ट्रीय ऊर्जा एजेंसी ने एशियाई देशों में सौर व पवन ऊर्जा की रिकॉर्ड स्थापना के बाद 2030 का अनुमान बढ़ाया',
                    'sub_en' => 'Plummeting solar cell manufacturing costs drive rapid decarbonization across developing industrial nations.',
                    'sub_hi' => 'सौर उपकरणों की गिरती कीमतों से विकासशील देशों में स्वच्छ ऊर्जा अपनाने की गति हुई दोगुनी।',
                    'img' => 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=800&q=80',
                    'views' => 47000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Tokyo and London Sign Landmark Sovereign Quantum Cryptography Security Pact',
                    'hi' => 'टोक्यो और लंदन ने सॉवरेन क्वांटम क्रिप्टोग्राफी सुरक्षा समझौते पर किए ऐतिहासिक हस्ताक्षर',
                    'sub_en' => 'Joint defense protocols prepare trans-oceanic bank clearance channels against quantum decryption.',
                    'sub_hi' => 'भविष्य के साइबर हमलों से बैंकिंग और रक्षा संचार को सुरक्षित रखने के लिए संयुक्त तंत्र विकसित।',
                    'img' => 'https://images.unsplash.com/photo-1504639725590-34d0984388bd?auto=format&fit=crop&w=800&q=80',
                    'views' => 41000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Pacific Island Nations Ratify Unified Marine Biodiversity Conservation Treaty',
                    'hi' => 'प्रशांत महासागरीय देशों ने समुद्री जैव विविधता संरक्षण की ऐतिहासिक संधि को दी मंजूरी',
                    'sub_en' => 'Commercial deep-seabed mining moratorium enacted across 2.4 million square nautical miles.',
                    'sub_hi' => '24 लाख समुद्री मील क्षेत्र में गहरे समुद्र में व्यावसायिक खनन पर लगाया गया पूर्ण प्रतिबंध।',
                    'img' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=800&q=80',
                    'views' => 33400,
                    'breaking' => false,
                ],
                [
                    'en' => 'Singapore Sovereign Fund Commits $4.5 Billion to Indian Renewable Green Hydrogen Hubs',
                    'hi' => 'सिंगापुर के सॉवरेन वेल्थ फंड ने भारतीय ग्रीन हाइड्रोजन परियोजनाओं में 4.5 अरब डॉलर निवेश की घोषणा की',
                    'sub_en' => 'Coastal Gujarat and Andhra Pradesh export hubs prepare to ship ammonia to East Asian industrial ports.',
                    'sub_hi' => 'गुजरात और आंध्र प्रदेश के तटीय केंद्रों से पूर्वी एशिया को स्वच्छ ऊर्जा निर्यात करने का लक्ष्य।',
                    'img' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80',
                    'views' => 61500,
                    'breaking' => false,
                ],
            ],

            'business' => [
                [
                    'en' => 'Reserve Bank of India Keeps Repo Rate Unchanged at 6.5%, Forecasts 7.4% GDP Growth for FY27',
                    'hi' => 'आरबीआई ने रेपो दर 6.5% पर स्थिर रखी, वित्त वर्ष 2027 के लिए 7.4% जीडीपी विकास दर का अनुमान',
                    'sub_en' => 'Monetary Policy Committee remains vigilantly focused on food inflation while celebrating capital investment.',
                    'sub_hi' => 'मुद्रास्फीति पर नियंत्रण बनाए रखते हुए केंद्रीय बैंक ने आर्थिक विकास के लिए अनुकूल माहौल की बात कही।',
                    'img' => 'https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?auto=format&fit=crop&w=800&q=80',
                    'views' => 89000,
                    'breaking' => true,
                ],
                [
                    'en' => 'India Electronics Exports Cross $30 Billion Milestone Led by Mobile Phone Assembly and Components',
                    'hi' => 'भारत का इलेक्ट्रॉनिक्स निर्यात 30 अरब डॉलर के पार, मोबाइल असेंबली और कलपुर्जों की मांग में भारी उछाल',
                    'sub_en' => 'Domestic value addition rises to 28% as local printed circuit board fabrication plants commence volume output.',
                    'sub_hi' => 'घरेलू स्तर पर सर्किट बोर्ड और पुर्जों के निर्माण से स्थानीय मूल्य संवर्धन बढ़कर 28% पर पहुंचा।',
                    'img' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
                    'views' => 71000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Commercial Electric Vehicles Gain 19% Market Share in Intra-City Logistics This Quarter',
                    'hi' => 'शहरी लॉजिस्टिक्स में कमर्शियल इलेक्ट्रिक वाहनों की हिस्सेदारी बढ़कर 19% हुई',
                    'sub_en' => 'Last-mile e-commerce operators cite 60% operating cost reductions versus legacy diesel vans.',
                    'sub_hi' => 'डीजल वाहनों की तुलना में 60% कम परिचालन लागत के चलते डिलीवरी कंपनियों ने अपनाए ईवी।',
                    'img' => 'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?auto=format&fit=crop&w=800&q=80',
                    'views' => 54000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Corporate Bond Issuance Surpasses Equity IPO Volume as Top Firms Lock In Long-Term Low Yields',
                    'hi' => 'कॉर्पोरेट बॉन्ड निर्गम ने आईपीओ वॉल्यूम को पीछे छोड़ा, कंपनियों ने कम ब्याज दरों पर जुटाया कर्ज',
                    'sub_en' => 'Domestic mutual funds and insurance companies absorb AA and AAA rated paper with record subscription.',
                    'sub_hi' => 'म्यूचुअल फंड और बीमा कंपनियों ने शीर्ष कंपनियों के बॉन्ड्स में रिकॉर्ड निवेश किया।',
                    'img' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80',
                    'views' => 46000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Fintech Lending Protocols Implement Stricter AI Underwriting Rules Mandated by Central Bank',
                    'hi' => 'आरबीआई के निर्देशों के तहत फिनटेक कंपनियों ने डिजिटल ऋण के लिए सख्त एआई नियम लागू किए',
                    'sub_en' => 'Algorithmic credit assessments must now provide verifiable explainability to prevent biased lending denials.',
                    'sub_hi' => 'अनावश्यक ऋण अस्वीकृति रोकने के लिए एल्गोरिदम के फैसलों की पारदर्शिता को किया गया अनिवार्य।',
                    'img' => 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?auto=format&fit=crop&w=800&q=80',
                    'views' => 62500,
                    'breaking' => false,
                ],
                [
                    'en' => 'Commercial Aviation Passenger Traffic Sets Single-Day Record with 5.2 Lakh Flown Nationally',
                    'hi' => 'घरेलू विमानन क्षेत्र में नया कीर्तिमान, एक दिन में 5.2 लाख यात्रियों ने की हवाई यात्रा',
                    'sub_en' => 'Regional connectivity schemes and festival season demand sustain 92% airline passenger load factors.',
                    'sub_hi' => 'उड़ान योजना और त्योहारी मांग के चलते एयरलाइंस की सीटें 92% क्षमता से भरी रहीं।',
                    'img' => 'https://images.unsplash.com/photo-1520437358207-323b43b50729?auto=format&fit=crop&w=800&q=80',
                    'views' => 49000,
                    'breaking' => false,
                ],
            ],

            'tech' => [
                [
                    'en' => 'Indian Semiconductor Mission Signs Packaging JV with Global Foundry for Gujarat Facility',
                    'hi' => 'भारतीय सेमीकंडक्टर मिशन ने गुजरात में चिप पैकेजिंग प्लांट के लिए वैश्विक कंपनी से किया समझौता',
                    'sub_en' => 'Facility to produce 40 million advanced microchips monthly for automotive and industrial IoT applications.',
                    'sub_hi' => 'ऑटोमोबाइल और औद्योगिक उपकरणों के लिए प्रतिमाह 4 करोड़ आधुनिक चिप्स का होगा उत्पादन।',
                    'img' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=800&q=80',
                    'views' => 84000,
                    'breaking' => true,
                ],
                [
                    'en' => 'Cybersecurity Agency Issues Advisory on Quantum-Safe TLS Encryption Standards for Banking Networks',
                    'hi' => 'कंप्यूटर इमरजेंसी रिस्पॉन्स टीम ने बैंकिंग नेटवर्क के लिए क्वांटम-सेफ एन्क्रिप्शन दिशानिर्देश जारी किए',
                    'sub_en' => 'Financial institutions given 18-month roadmap to migrate core payment gateways to post-quantum cryptography.',
                    'sub_hi' => 'बैंकों को भुगतान प्रणालियों को क्वांटम-सुरक्षित तकनीक पर स्थानांतरित करने के लिए 18 महीने की समयसीमा।',
                    'img' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=800&q=80',
                    'views' => 58000,
                    'breaking' => false,
                ],
                [
                    'en' => 'DeepTech Startups in Hyderabad and Pune Secure $840 Million for Robotics and Edge Computing',
                    'hi' => 'हैदराबाद और पुणे के डीप-टेक स्टार्टअप्स ने रोबोटिक्स और एज कंप्यूटिंग में 84 करोड़ डॉलर जुटाए',
                    'sub_en' => 'Enterprise automation and smart warehouse logistics drive institutional venture funding revival.',
                    'sub_hi' => 'औद्योगिक ऑटोमेशन और वेयरहाउस रोबोटिक्स में निवेशकों की दिलचस्पी से मिला भारी निवेश।',
                    'img' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=800&q=80',
                    'views' => 67000,
                    'breaking' => false,
                ],
                [
                    'en' => 'IIT Madras Researchers Develop Low-Power 32-bit Microprocessor for Space Electronics',
                    'hi' => 'आईआईटी मद्रास के शोधकर्ताओं ने अंतरिक्ष मिशनों के लिए बनाया कम बिजली की खपत वाला माइक्रोप्रोसेसर',
                    'sub_en' => 'Radiation-hardened Shakti derivative proves fault-tolerant during extreme thermal cycling tests.',
                    'sub_hi' => 'रेडिएशन-प्रतिरोधी शक्ति प्रोसेसर ने अत्यधिक तापमान परीक्षणों में शत-प्रतिशत विश्वसनीयता दर्ज की।',
                    'img' => 'https://images.unsplash.com/photo-1517430816045-df4b7de11d1d?auto=format&fit=crop&w=800&q=80',
                    'views' => 61000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Satellite Broadband Terminals Roll Out to 10,000 Remote Himalayan Villages for High-Speed Internet',
                    'hi' => 'हिमालय के 10,000 दुर्गम गांवों में उपग्रह ब्रॉडबैंड सेवा शुरू, मिली हाई-स्पीड इंटरनेट कनेक्टिविटी',
                    'sub_en' => 'Low Earth orbit constellation delivers 100 Mbps telehealth and digital schooling connections.',
                    'sub_hi' => 'सैटेलाइट नेटवर्क के माध्यम से दूरदराज के क्षेत्रों में टेली-मेडिसिन और ई-शिक्षा की सुविधा उपलब्ध।',
                    'img' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=800&q=80',
                    'views' => 49500,
                    'breaking' => false,
                ],
                [
                    'en' => 'Open-Source Drone Autopilot Stack Achieves Civilian Airspace Certification in Historic First',
                    'hi' => 'ओपन-सोर्स ड्रोन ऑटोपायलट सॉफ्टवेयर को नागरिक हवाई क्षेत्र में संचालन के लिए पहली बार मिला प्रमाणन',
                    'sub_en' => 'Indigenously developed avionics stack approved for autonomous agricultural spraying and medicine delivery.',
                    'sub_hi' => 'कृषि छिड़काव और जीवन रक्षक दवाओं की डिलीवरी के लिए स्वदेशी तकनीक को डीजीसीए की हरी झंडी।',
                    'img' => 'https://images.unsplash.com/photo-1527977966376-1c8408f9f108?auto=format&fit=crop&w=800&q=80',
                    'views' => 52000,
                    'breaking' => false,
                ],
            ],

            'sports' => [
                [
                    'en' => 'India Clinches Historic Clean Sweep in Border-Gavaskar Test Series with Record 4th Innings Chase',
                    'hi' => 'भारत ने रचा इतिहास: बॉर्डर-गावस्कर टेस्ट सीरीज में 4-0 से क्लीन स्वीप, चौथी पारी में रिकॉर्ड लक्ष्य हासिल',
                    'sub_en' => 'Unflappable middle-order partnership seals thrilling three-wicket triumph on final day in Melbourne.',
                    'sub_hi' => 'मेलबर्न में अंतिम दिन मध्यक्रम की शानदार साझेदारी ने भारत को दिलाई यादगार ऐतिहासिक जीत।',
                    'img' => 'https://images.unsplash.com/photo-1531415074968-036ba1b575da?auto=format&fit=crop&w=800&q=80',
                    'views' => 178000,
                    'breaking' => true,
                ],
                [
                    'en' => 'National Javelin Champion Breaks Asian Record with 91.4 Meter Throw at Continental Diamond League',
                    'hi' => 'भारतीय भाला फेंक चैंपियन ने रचा नया एशियाई रिकॉर्ड, डायमंड लीग में 91.4 मीटर का थ्रो कर जीता गोल्ड',
                    'sub_en' => 'Sensational final-round attempt surpasses world-leading mark, setting expectations high for upcoming world finals.',
                    'sub_hi' => 'अंतिम प्रयास में दुनिया का सर्वश्रेष्ठ थ्रो फेंककर विश्व चैंपियनशिप के लिए मजबूत की दावेदारी।',
                    'img' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=800&q=80',
                    'views' => 112000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Indian Women Football Team Qualifies for Asian Cup Knockout Stages with Gritty Defensive Display',
                    'hi' => 'भारतीय महिला फुटबॉल टीम ने शानदार खेल से एशियन कप के नॉकआउट चरण में किया प्रवेश',
                    'sub_en' => 'Goalkeeper produces six world-class saves in scoreless stalemate against higher-ranked opponents.',
                    'sub_hi' => 'गोलकीपर के छह बेहतरीन बचावों के दम पर भारत ने शीर्ष वरीय टीम को बराबरी पर रोका।',
                    'img' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?auto=format&fit=crop&w=800&q=80',
                    'views' => 64000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Badminton Prodigy Clinches All England Open Super 1000 Title in Thrilling Three-Game Classic',
                    'hi' => 'भारतीय बैडमिंटन खिलाड़ी ने जीता ऑल इंग्लैंड ओपन का खिताब, 3 गेम के रोमांचक फाइनल में दर्ज की जीत',
                    'sub_en' => 'Tactical net play and explosive smashes overcome reigning world number one in Birmingham.',
                    'sub_hi' => 'बर्मिंघम में दुनिया के नंबर एक खिलाड़ी को मात देकर रचा बैडमिंटन में नया इतिहास।',
                    'img' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?auto=format&fit=crop&w=800&q=80',
                    'views' => 76000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Hockey India League Revival Draws Record Global Broadcast Viewership Across 42 Nations',
                    'hi' => 'हॉकी इंडिया लीग की वापसी को मिला वैश्विक समर्थन, 42 देशों में रिकॉर्ड दर्शकों ने देखा लाइव प्रसारण',
                    'sub_en' => 'Fast-paced shootouts and high scoring averages rejuvenate domestic club fan engagement.',
                    'sub_hi' => 'रोमांचक मुकाबलों और युवा खिलाड़ियों के प्रदर्शन से घरेलू हॉकी को मिला नया जीवन।',
                    'img' => 'https://images.unsplash.com/photo-1580748141549-71748dbe0bdc?auto=format&fit=crop&w=800&q=80',
                    'views' => 45000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Chess Grandmaster Enters Candidates Tournament Final Four with Flawless Endgame Technique',
                    'hi' => 'भारतीय ग्रैंडमास्टर ने कैंडिडैट्स शतरंज टूर्नामेंट के सेमीफाइनल में बनाई जगह, एंडगेम में दिखाया कमाल',
                    'sub_en' => 'Precise knight maneuvers in game seven secure critical win against classical world champion.',
                    'sub_hi' => 'सातवीं बाज़ी में शानदार चालों से पूर्व विश्व चैंपियन को हराकर विश्व खिताब की ओर बढ़ाया कदम।',
                    'img' => 'https://images.unsplash.com/photo-1529699211952-734e80c4d42b?auto=format&fit=crop&w=800&q=80',
                    'views' => 88000,
                    'breaking' => false,
                ],
            ],

            'opinion' => [
                [
                    'en' => 'Why Reforming Higher Education Demands Abolishing Departmental Silos and Funding Cross-Discipline Labs',
                    'hi' => 'उच्च शिक्षा में सुधार के लिए विभागों की दीवारें तोड़कर अंतःविषय शोध को बढ़ावा देना जरूरी',
                    'sub_en' => 'The next era of technological breakthrough will occur at the intersection of computer science, biology, and materials.',
                    'sub_hi' => 'आर्टिफिशियल इंटेलिजेंस और जीव विज्ञान के मेल से ही संभव होंगे भविष्य के बड़े वैज्ञानिक आविष्कार।',
                    'img' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80',
                    'views' => 51000,
                    'breaking' => false,
                ],
                [
                    'en' => 'The Urban Water Conundrum: Why Metros Must Price Groundwater and Recycle Every Drop of Sewage',
                    'hi' => 'शहरी जल संकट का समाधान: भूजल दोहन पर नियंत्रण और सीवेज जल के 100% पुनर्चक्रण की आवश्यकता',
                    'sub_en' => 'Without mandatory dual-piping in commercial real estate, Indian cities will exhaust reservoirs by mid-decade.',
                    'sub_hi' => 'रीसाइक्लिंग और जल संरक्षण के सख्त नियमों के बिना शहरों का विकास टिक नहीं सकता।',
                    'img' => 'https://images.unsplash.com/photo-1541888946425-d0fbb186c5f7?auto=format&fit=crop&w=800&q=80',
                    'views' => 47000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Sovereignty in the Cloud: How National Data Protection Laws Must Balance Innovation with Civil Privacy',
                    'hi' => 'क्लाउड में संप्रभुता: राष्ट्रीय डेटा सुरक्षा कानूनों में नवाचार और नागरिक स्वतंत्रता का संतुलन',
                    'sub_en' => 'A well-crafted regulatory regime empowers startups while stopping unchecked surveillance capitalism.',
                    'sub_hi' => 'मजबूत कानून न केवल नागरिकों की निजता की रक्षा करते हैं बल्कि निष्पक्ष प्रतिस्पर्धा को भी बढ़ावा देते हैं।',
                    'img' => 'https://images.unsplash.com/photo-1510511459019-5dda7724fd87?auto=format&fit=crop&w=800&q=80',
                    'views' => 59000,
                    'breaking' => false,
                ],
                [
                    'en' => 'The Rebirth of Public Libraries: Why Every District Needs Vibrant Physical Community Knowledge Centers',
                    'hi' => 'सार्वजनिक पुस्तकालयों का पुनर्जन्म: हर जिले में आधुनिक ज्ञान केंद्रों की क्यों है आवश्यकता',
                    'sub_en' => 'In an age of digital screen exhaustion, quiet communal reading spaces cultivate democratic discourse and research.',
                    'sub_hi' => 'स्क्रीन के अत्यधिक उपयोग के दौर में शांत अध्ययन केंद्र सामाजिक संवाद और ज्ञान का आधार बनते हैं।',
                    'img' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=800&q=80',
                    'views' => 38000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Fiscal Federalism in Practice: How States Can Generate Independent Non-Tax Revenue Streams',
                    'hi' => 'राज्यों की वित्तीय मजबूती: गैर-कर राजस्व के नए स्रोतों से स्वायत्तता हासिल करने का रोडमैप',
                    'sub_en' => 'Municipal asset monetisation and green land-value capture offer viable alternatives to central grants.',
                    'sub_hi' => 'शहरी संपत्तियों के बेहतर प्रबंधन और ग्रीन बॉन्ड्स से राज्य बढ़ा सकते हैं अपनी आय।',
                    'img' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=800&q=80',
                    'views' => 42000,
                    'breaking' => false,
                ],
                [
                    'en' => 'The Agrarian Energy Transition: Turning Crop Stubble into High-Value Biomethane and Fertilizer',
                    'hi' => 'पराली से समृद्धि: कृषि अवशेषों को बायो-मीथेन और जैविक खाद में बदलकर प्रदूषण से मुक्ति का मार्ग',
                    'sub_en' => 'Decentralised bio-refineries can eradicate northern smog while injecting ₹18,000 crore into rural farmer pockets.',
                    'sub_hi' => 'बायोगैस संयंत्रों के जरिए पराली जलाने की समस्या का स्थाई और लाभकारी समाधान संभव।',
                    'img' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=800&q=80',
                    'views' => 61000,
                    'breaking' => false,
                ],
            ],

            'entertainment' => [
                [
                    'en' => 'Acclaimed Independent Docu-Series on Indian Classical Music Masters Streams Globally to Rave Reviews',
                    'hi' => 'भारतीय शास्त्रीय संगीत के उस्तादों पर बनी वृत्तचित्र श्रृंखला को मिला वैश्विक दर्शकों का भरपूर प्यार',
                    'sub_en' => 'Six-part restoration captures rare audio recordings, archival concerts, and intimate guru-shishya lineages.',
                    'sub_hi' => 'छह भागों की इस विशेष श्रृंखला में दुर्लभ संगीत रिकॉर्डिंग्स और गुरु-शिष्य परंपरा का मार्मिक चित्रण।',
                    'img' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=800&q=80',
                    'views' => 46000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Jaipur Literature Festival Announces 2026 Lineup Celebrating Translation and Decolonial Histories',
                    'hi' => 'जयपुर लिटरेचर फेस्टिवल 2026 का शेड्यूल जारी, अनुवाद और भारतीय भाषाओं के साहित्य पर रहेगा फोकस',
                    'sub_en' => 'Over 350 international novelists, poets, and historians set to converge for five days of vibrant literary debate.',
                    'sub_hi' => '350 से अधिक अंतरराष्ट्रीय लेखक और विचारक पांच दिनों तक समकालीन विमर्श में लेंगे हिस्सा।',
                    'img' => 'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?auto=format&fit=crop&w=800&q=80',
                    'views' => 52000,
                    'breaking' => false,
                ],
                [
                    'en' => 'National Film Heritage Mission Restores 100 Lost Silent Era Classics in Ultra-High-Definition 4K',
                    'hi' => 'राष्ट्रीय फिल्म विरासत मिशन ने 100 मूक युग की दुर्लभ फिल्मों को 4के अल्ट्रा-एचडी में किया रीस्टोर',
                    'sub_en' => 'Damaged celluloid negatives saved from decay and digitized for permanent public educational access.',
                    'sub_hi' => 'सैकड़ों वर्ष पुराने नष्ट होते सेल्यूलॉयड प्रिंट्स को आधुनिक तकनीक से सहेजकर किया गया डिजिटाइज।',
                    'img' => 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?auto=format&fit=crop&w=800&q=80',
                    'views' => 39000,
                    'breaking' => false,
                ],
                [
                    'en' => 'South Asian Contemporary Art Biennale Opens in Kochi with Immersive Climate and Memory Installations',
                    'hi' => 'कोच्चि में समकालीन कला बिनाले का आगाज, जलवायु परिवर्तन और सांस्कृतिक स्मृतियों पर केंद्रित प्रदर्शनियां',
                    'sub_en' => 'Over 90 artists from 40 nations transform historic warehouses into breathtaking interactive pavilions.',
                    'sub_hi' => '40 देशों के 90 से अधिक कलाकारों ने ऐतिहासिक वेयरहाउसों को जीवंत कला केंद्रों में बदला।',
                    'img' => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=800&q=80',
                    'views' => 41000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Live Symphony Orchestra Reimagines Classic Film Soundtracks with Traditional Indian Sitar and Sarod',
                    'hi' => 'सिम्फनी ऑर्केस्ट्रा ने सितार और सरोद के साथ क्लासिक फिल्मी धुनों को दिया नया मंत्रमुग्ध कर देने वाला रूप',
                    'sub_en' => 'Sold-out concert hall in Mumbai witnesses thunderous standing ovations for fusion arrangements.',
                    'sub_hi' => 'मुंबई में आयोजित इस विशेष फ्यूजन कॉन्सर्ट में दर्शकों ने खड़े होकर किया कलाकारों का अभिनंदन।',
                    'img' => 'https://images.unsplash.com/photo-1465847899084-d164df4dedc6?auto=format&fit=crop&w=800&q=80',
                    'views' => 37000,
                    'breaking' => false,
                ],
            ],

            'lifestyle' => [
                [
                    'en' => 'The Rise of Sustainable Slow Travel in Himachal: Homestays and Heritage Trails Replace Mass Tourism',
                    'hi' => 'हिमाचल में स्लो-ट्रैवल का नया चलन: अंधाधुंध पर्यटन के बजाय होमस्टे और हेरिटेज वॉक को पसंद कर रहे सैलानी',
                    'sub_en' => 'Local village cooperatives earn double income by curating organic farm stays and indigenous craft workshops.',
                    'sub_hi' => 'स्थानीय ग्रामीण समितियां पर्यटकों को पारंपरिक जीवनशैली और हस्तशिल्प से रूबरू कराकर बढ़ा रही हैं आय।',
                    'img' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80',
                    'views' => 58000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Restoring Native Forests: The Urban Miyawaki Woods Bringing Birdsong Back to Concrete Metros',
                    'hi' => 'कंक्रीट के शहरों में हरियाली की वापसी: मियावाकी पद्धति से विकसित हो रहे घने शहरी जंगल',
                    'sub_en' => 'Tiny micro-forests planted across Delhi and Pune drop local ambient temperatures by up to three degrees.',
                    'sub_hi' => 'दिल्ली और पुणे में मियावाकी जंगलों से प्रदूषण कम होने के साथ स्थानीय तापमान में भी आई 3 डिग्री तक गिरावट।',
                    'img' => 'https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=800&q=80',
                    'views' => 45000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Handloom Weavers of Chanderi and Kanjeevaram Find Direct Global Buyers via Blockchain Authentication',
                    'hi' => 'चंदेरी और कांजीवरम के बुनकरों को ब्लॉकचेन तकनीक से मिला सीधा वैश्विक बाज़ार, बिचौलियों से मिली मुक्ति',
                    'sub_en' => 'Cryptographic thread tags verify authentic handloom provenance, securing fourfold price premiums.',
                    'sub_hi' => 'डिजिटल टैग्स से असली हथकरघा वस्त्रों की प्रामाणिकता सिद्ध होने से कारीगरों को मिला वाजिब दाम।',
                    'img' => 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&w=800&q=80',
                    'views' => 49000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Mental Wellbeing in High-Pressure Tech Workspaces: Why Companies Are Mandating Digital Sabbath Hours',
                    'hi' => 'वर्कप्लेस पर मानसिक शांति के लिए टेक कंपनियों ने लागू किया डिजिटल डिटॉक्स नियम',
                    'sub_en' => 'Weekly no-email weekends and mandatory ergonomic sabbaticals boost employee retention by 34%.',
                    'sub_hi' => 'सप्ताहांत पर आधिकारिक संदेशों पर रोक और ध्यान सत्रों से कर्मचारियों के तनाव में आई भारी कमी।',
                    'img' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
                    'views' => 51000,
                    'breaking' => false,
                ],
                [
                    'en' => 'Heritage House Restoration: How Architects Are Reviving Mud, Lime, and Stone for Zero-Energy Homes',
                    'hi' => 'पारंपरिक वास्तुकला की वापसी: मिट्टी, चूना और पत्थर से बन रहे शून्य-ऊर्जा वाले आधुनिक पर्यावरण-अनुकूल घर',
                    'sub_en' => 'Ancient thermal mass principles provide natural cooling without high-wattage air conditioning.',
                    'sub_hi' => 'पारंपरिक तकनीकों से बने मकान बिना एयर कंडीशनर के भी गर्मियों में रहते हैं प्राकृतिक रूप से ठंडे।',
                    'img' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80',
                    'views' => 43000,
                    'breaking' => false,
                ],
            ],
        ];

        $authorKeys = $authors->keys()->toArray();
        $authorIndex = 0;
        $counter = 0;

        foreach ($editorialTemplates as $catSlug => $items) {
            $cat = $categories->get($catSlug);
            if (! $cat) {
                continue;
            }

            foreach ($items as $tmpl) {
                $authorKey = $authorKeys[$authorIndex % count($authorKeys)];
                $auth = $authors->get($authorKey);
                $authorIndex++;
                $counter++;

                $publishedAt = Carbon::now()->subHours(10 + ($counter * 3));

                $curated = CuratedPhotoLibrary::getForCategory($catSlug, $counter);
                $featuredImage = $curated['url'];
                $caption = $curated['caption'];
                $captionHi = $curated['caption_hi'];

                $article = Article::updateOrCreate(
                    ['slug' => Str::slug($tmpl['en'])],
                    [
                        'category_id' => $cat->id,
                        'author_id' => $auth->id,
                        'title' => $tmpl['en'],
                        'title_hi' => $tmpl['hi'],
                        'slug' => Str::slug($tmpl['en']),
                        'slug_hi' => Str::slug($tmpl['hi']),
                        'subtitle' => $tmpl['sub_en'],
                        'subtitle_hi' => $tmpl['sub_hi'],
                        'excerpt' => $tmpl['sub_en'],
                        'excerpt_hi' => $tmpl['sub_hi'],
                        'key_takeaways' => [
                            'en' => [
                                'Comprehensive policy guidelines finalized following extensive consultative stakeholder review.',
                                'Tangible economic and environmental dividends projected over the coming fiscal timeframe.',
                                'Independent regulatory mechanisms instituted to monitor verifiable progress milestones.',
                            ],
                            'hi' => [
                                'हितधारकों के व्यापक परामर्श के बाद नीतिगत दिशानिर्देशों को अंतिम रूप दिया गया।',
                                'आगामी वित्तीय समयसीमा में ठोस आर्थिक और सामाजिक लाभ मिलने की उम्मीद।',
                                'प्रगति की निगरानी के लिए स्वतंत्र नियामक तंत्र की स्थापना।',
                            ],
                        ],
                        'content' => '<p class="lead">'.$tmpl['sub_en'].'</p>
                        <p>Detailed analysis reveals that systemic investments across institutional infrastructure continue to accelerate domestic capacity and improve standard operating metrics.</p>
                        <blockquote>"Transformative progress requires sustained regulatory clarity and multi-stakeholder collaboration." — Senior Policy Advisor</blockquote>
                        <p>Officials confirmed that pilot phases have demonstrated overwhelming efficacy, paving the way for nationwide expansion by the end of the calendar year.</p>',
                        'content_hi' => '<p class="lead">'.$tmpl['sub_hi'].'</p>
                        <p>विस्तृत विश्लेषण से पता चलता है कि संस्थागत ढांचे में किए गए निरंतर निवेश से देश की क्षमता में अभूतपूर्व वृद्धि हो रही है।</p>
                        <blockquote>"सच्चा बदलाव निरंतर नीतिगत स्पष्टता और सभी पक्षों के सहयोग से ही संभव है।"</blockquote>',
                        'featured_image' => $featuredImage,
                        'image_caption' => $caption,
                        'image_caption_hi' => $captionHi,
                        'image_credit' => 'Photo: Unsplash',
                        'type' => ($catSlug === 'opinion') ? 'opinion' : 'standard',
                        'status' => 'published',
                        'is_featured' => false,
                        'is_breaking' => $tmpl['breaking'],
                        'is_trending' => ($tmpl['views'] > 55000),
                        'is_premium' => ($counter % 3 === 0),
                        'reading_time' => 4 + ($counter % 4),
                        'views_count' => $tmpl['views'],
                        'shares_count' => intval($tmpl['views'] * 0.025),
                        'published_at' => $publishedAt,
                    ]
                );

                // Assign tags based on category
                if ($catSlug === 'politics') {
                    $article->tags()->sync([$tags['budget-2026']?->id, $tags['elections']?->id]);
                }
                if ($catSlug === 'tech') {
                    $article->tags()->sync([$tags['ai-revolution']?->id, $tags['startups']?->id]);
                }
                if ($catSlug === 'business') {
                    $article->tags()->sync([$tags['stock-markets']?->id, $tags['budget-2026']?->id]);
                }
                if ($catSlug === 'sports') {
                    $article->tags()->sync([$tags['cricket']?->id]);
                }
                if ($catSlug === 'world') {
                    $article->tags()->sync([$tags['geopolitics']?->id, $tags['defense']?->id]);
                }
            }
        }
    }
}
