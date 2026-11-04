<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { usePage, Link, router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import {
  Search,
  Menu as MenuIcon,
  X as CloseIcon,
  CloudSun,
  Tv,
  Film,
  Home as HomeIcon,
  Video as VideoIcon,
  Flame,
  LayoutDashboard,
  Bookmark,
  LogOut,
  ChevronDown,
  ChevronRight,
  User as UserIcon,
  Share2,
} from 'lucide-vue-next';

const props = defineProps({
  breakingNews: {
    type: Array,
    default: () => [],
  },
});

const page = usePage();
const { locale, t } = useI18n();

// Shared props
const brand = computed(() => page.props.brand || { name: 'The Chronicle', name_hi: 'द क्रॉनिकल' });
const categories = computed(() => page.props.categories || []);
const siteSettings = computed(() => page.props.siteSettings || {});
const trendingTopics = computed(() => page.props.trendingTopics || []);
const authUser = computed(() => page.props.auth?.user || null);
const currentLocale = computed(() => page.props.locale || 'hi');

const canAccessAdmin = computed(() => {
  if (!authUser.value) return false;
  if (authUser.value.can_access_panel !== undefined) {
    return Boolean(authUser.value.can_access_panel);
  }
  return ['admin', 'editor', 'journalist'].includes(authUser.value.role);
});

// UI states
const isScrolled = ref(false);
const isDrawerOpen = ref(false);
const isUserMenuOpen = ref(false);
const isSearchOpen = ref(false);
const searchQuery = ref('');
const activeMegaMenu = ref(null);
const currentTickerIndex = ref(0);
const isTickerPaused = ref(false);
let tickerTimer = null;

// Breaking headlines fallback if prop is empty
const tickerItems = computed(() => {
  if (props.breakingNews && props.breakingNews.length > 0) {
    return props.breakingNews;
  }
  return [
    { id: 1, title: 'Cabinet Clears Landmark High-Speed Freight & Semiconductor Corridor', title_hi: 'केंद्रीय मंत्रिमंडल ने सेमीकंडक्टर और हाई-स्पीड फ्रेट कॉरिडोर को दी ऐतिहासिक मंजूरी', slug: 'cabinet-clears-landmark-high-speed-freight-semiconductor-corridor' },
    { id: 2, title: 'Sensex Surges Past 81,500 as Global Funds Pivot Back to India Tech', title_hi: 'सेंसेक्स 81,500 के पार, विदेशी निवेशकों ने भारतीय टेक व बैंकिंग में किया भारी निवेश', slug: 'sensex-surges-past-81500-as-global-funds-pivot-back-to-india-tech' },
    { id: 3, title: 'T20 World Cup Final: Team India Prepares for High-Stakes Clash', title_hi: 'टी20 विश्व कप फाइनल: खिताबी मुकाबले के लिए भारतीय टीम की जोरदार तैयारी', slug: 't20-world-cup-final' },
  ];
});

const currentBreakingItem = computed(() => tickerItems.value[currentTickerIndex.value] || tickerItems.value[0]);

const startTicker = () => {
  if (tickerTimer) clearInterval(tickerTimer);
  tickerTimer = setInterval(() => {
    if (!isTickerPaused.value && tickerItems.value.length > 1) {
      currentTickerIndex.value = (currentTickerIndex.value + 1) % tickerItems.value.length;
    }
  }, 4500);
};

const handleScroll = () => {
  if (typeof window !== 'undefined') {
    isScrolled.value = window.scrollY > 80;
  }
};

onMounted(() => {
  startTicker();
  window.addEventListener('scroll', handleScroll, { passive: true });
});

onUnmounted(() => {
  if (tickerTimer) clearInterval(tickerTimer);
  window.removeEventListener('scroll', handleScroll);
});

// Hindi Formatted Date
const formattedDate = computed(() => {
  const d = new Date();
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  const loc = currentLocale.value === 'hi' ? 'hi-IN' : 'en-IN';
  return d.toLocaleDateString(loc, options);
});

// Weather
const weather = computed(() => {
  const w = siteSettings.value?.weather_delhi || { temp: '28°C', condition_hi: 'साफ आसमान', condition: 'Clear Sky' };
  return currentLocale.value === 'hi'
    ? `${w.temp} ${w.condition_hi || 'साफ मौसम'}`
    : `${w.temp} ${w.condition || 'Clear'}`;
});

// Switch language
const switchLanguage = (target) => {
  router.get(`/lang/${target}`, {}, { preserveState: false });
};

// Search submit
const submitSearch = () => {
  if (searchQuery.value.trim()) {
    router.get('/search', { q: searchQuery.value.trim() });
    isSearchOpen.value = false;
  }
};

// 4-column Indian States list for "भारत" mega menu
const indianStates = [
  { name: 'उत्तर प्रदेश', slug: 'uttar-pradesh' },
  { name: 'बिहार', slug: 'bihar' },
  { name: 'दिल्ली एनसीआर', slug: 'delhi' },
  { name: 'मध्य प्रदेश', slug: 'madhya-pradesh' },
  { name: 'राजस्थान', slug: 'rajasthan' },
  { name: 'महाराष्ट्र', slug: 'maharashtra' },
  { name: 'पंजाब', slug: 'punjab' },
  { name: 'हरियाणा', slug: 'haryana' },
  { name: 'गुजरात', slug: 'gujarat' },
  { name: 'पश्चिम बंगाल', slug: 'west-bengal' },
  { name: 'झारखंड', slug: 'jharkhand' },
  { name: 'छत्तीसगढ़', slug: 'chhattisgarh' },
  { name: 'उत्तराखंड', slug: 'uttarakhand' },
  { name: 'हिमाचल प्रदेश', slug: 'himachal-pradesh' },
  { name: 'जम्मू कश्मीर', slug: 'jammu-kashmir' },
  { name: 'दक्षिण भारत', slug: 'south-india' },
];

// Helper to get Hindi or English name
const getCatName = (cat) => {
  return currentLocale.value === 'hi' ? (cat.name_hi || cat.name) : cat.name;
};

// CSRF token
const csrfToken = computed(() => {
  if (typeof document !== 'undefined') {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
  }
  return '';
});

const getUserInitials = (name) => {
  if (!name) return 'U';
  return name.split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase();
};
</script>

<template>
  <div class="min-h-screen flex flex-col bg-white dark:bg-[#111317] text-[#111111] dark:text-[#E8EAF0] font-hindi selection:bg-[#D90000] selection:text-white">

    <!-- ============================================== -->
    <!-- 1. THIN TOP STRIP                              -->
    <!-- ============================================== -->
    <div class="bg-[#F4F4F6] dark:bg-[#181B20] border-b border-[#E5E5E5] dark:border-zinc-800 text-[11px] sm:text-xs text-gray-600 dark:text-zinc-400 py-1 px-3 sm:px-4">
      <div class="max-w-7xl mx-auto flex items-center justify-between gap-2">
        <!-- Date & Weather -->
        <div class="flex items-center gap-3 overflow-hidden whitespace-nowrap">
          <span class="font-medium text-gray-700 dark:text-zinc-300">{{ formattedDate }}</span>
          <span class="text-gray-300 dark:text-zinc-700">|</span>
          <div class="hidden sm:flex items-center gap-1.5 font-medium">
            <CloudSun class="w-3.5 h-3.5 text-amber-500" />
            <span>नई दिल्ली: {{ weather }}</span>
          </div>
        </div>

        <!-- Links, E-Paper, Language & User -->
        <div class="flex items-center gap-3 shrink-0">
          <a
            href="#epaper"
            class="hidden md:inline-flex items-center gap-1 font-semibold text-gray-700 dark:text-zinc-300 hover:text-[#D90000] transition-colors"
          >
            <span>ई-पेपर</span>
          </a>

          <span class="hidden md:inline text-gray-300 dark:text-zinc-700">|</span>

          <!-- Language Switcher -->
          <div class="flex items-center gap-1 font-semibold text-xs">
            <button
              @click="switchLanguage('hi')"
              class="px-1.5 py-0.5 rounded transition-colors"
              :class="currentLocale === 'hi' ? 'bg-[#D90000] text-white font-bold' : 'hover:text-[#D90000]'"
            >
              हिंदी
            </button>
            <span class="text-gray-300 dark:text-zinc-700">/</span>
            <button
              @click="switchLanguage('en')"
              class="px-1.5 py-0.5 rounded transition-colors"
              :class="currentLocale === 'en' ? 'bg-[#D90000] text-white font-bold' : 'hover:text-[#D90000]'"
            >
              EN
            </button>
          </div>

          <span class="text-gray-300 dark:text-zinc-700">|</span>

          <!-- User Menu / Sign In -->
          <div v-if="authUser" class="relative">
            <button
              @click="isUserMenuOpen = !isUserMenuOpen"
              class="flex items-center gap-1.5 font-medium hover:text-[#D90000] focus:outline-none"
            >
              <div class="w-5 h-5 rounded-full bg-[#D90000] text-white text-[10px] font-bold flex items-center justify-center">
                {{ getUserInitials(authUser.name) }}
              </div>
              <span class="hidden sm:inline text-xs font-semibold max-w-[100px] truncate">{{ authUser.name }}</span>
              <ChevronDown class="w-3 h-3 text-gray-500" />
            </button>

            <!-- Dropdown -->
            <div
              v-if="isUserMenuOpen"
              class="absolute right-0 mt-2 w-48 bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded shadow-xl py-1 z-50 text-xs"
            >
              <div class="px-3 py-2 border-b border-gray-100 dark:border-zinc-800">
                <p class="font-bold text-gray-900 dark:text-white truncate">{{ authUser.name }}</p>
                <p class="text-[10px] text-gray-500 dark:text-zinc-400 truncate">{{ authUser.email }}</p>
              </div>

              <a
                v-if="canAccessAdmin"
                href="/admin"
                class="flex items-center gap-2 px-3 py-2 text-gray-700 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-800 hover:text-[#D90000]"
              >
                <LayoutDashboard class="w-3.5 h-3.5 text-[#D90000]" />
                <span>एडमिन डैशबोर्ड</span>
              </a>

              <Link
                href="/bookmarks"
                @click="isUserMenuOpen = false"
                class="flex items-center gap-2 px-3 py-2 text-gray-700 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-800 hover:text-[#D90000]"
              >
                <Bookmark class="w-3.5 h-3.5 text-gray-400" />
                <span>सहेजे गए लेख</span>
              </Link>

              <form action="/logout" method="POST" class="border-t border-gray-100 dark:border-zinc-800 mt-1">
                <input type="hidden" name="_token" :value="csrfToken" />
                <button
                  type="submit"
                  class="w-full flex items-center gap-2 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 text-left font-medium"
                >
                  <LogOut class="w-3.5 h-3.5" />
                  <span>लॉग आउट</span>
                </button>
              </form>
            </div>
          </div>

          <a
            v-else
            href="/admin/login"
            class="flex items-center gap-1 font-semibold text-gray-700 dark:text-zinc-300 hover:text-[#D90000]"
          >
            <UserIcon class="w-3.5 h-3.5 text-[#D90000]" />
            <span>लॉग इन</span>
          </a>
        </div>
      </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. MAIN BRAND HEADER                           -->
    <!-- ============================================== -->
    <header class="bg-white dark:bg-[#111317] border-b border-[#E5E5E5] dark:border-zinc-800 py-3 sm:py-4 px-3 sm:px-4">
      <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
        <!-- Logo / Masthead -->
        <div class="flex items-center gap-3">
          <button
            @click="isDrawerOpen = true"
            class="p-1.5 -ml-1 text-gray-700 dark:text-zinc-200 hover:text-[#D90000] focus:outline-none"
            aria-label="Open Full Sections Drawer"
          >
            <MenuIcon class="w-6 h-6" />
          </button>

          <Link href="/" class="flex flex-col">
            <span class="font-hindi font-black text-2xl sm:text-3xl md:text-4xl text-[#D90000] tracking-tight leading-none">
              {{ brand.name_hi || 'द क्रॉनिकल' }}
            </span>
            <span class="font-sans font-bold text-[9px] sm:text-[10px] tracking-widest uppercase text-gray-500 dark:text-zinc-400 mt-0.5">
              {{ brand.name || 'THE CHRONICLE' }} • 24x7 HINDI NEWS
            </span>
          </Link>
        </div>

        <!-- Center / Right Actions -->
        <div class="flex items-center gap-2.5 sm:gap-4">
          <!-- Live TV Button (Pulsing Red) -->
          <a
            href="#live-tv"
            class="flex items-center gap-1.5 sm:gap-2 bg-[#D90000] hover:bg-[#B00000] text-white px-2.5 sm:px-4 py-1.5 rounded font-bold text-xs sm:text-sm tracking-wide shadow-sm transition-transform active:scale-95"
          >
            <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
            <Tv class="w-4 h-4 hidden sm:inline" />
            <span>लाइव टीवी</span>
          </a>

          <!-- Quick Search Trigger -->
          <div class="relative">
            <button
              v-if="!isSearchOpen"
              @click="isSearchOpen = true"
              class="p-2 text-gray-600 dark:text-zinc-300 hover:text-[#D90000] rounded-full hover:bg-gray-100 dark:hover:bg-zinc-800 transition-colors"
              aria-label="Search"
            >
              <Search class="w-5 h-5" />
            </button>

            <!-- Search Input Expand -->
            <div v-else class="flex items-center gap-1 bg-gray-100 dark:bg-zinc-800 rounded px-2 py-1">
              <input
                v-model="searchQuery"
                type="text"
                placeholder="खबरें खोजें..."
                class="bg-transparent text-xs sm:text-sm text-gray-900 dark:text-white focus:outline-none w-36 sm:w-56"
                @keyup.enter="submitSearch"
                autofocus
              />
              <button @click="submitSearch" class="text-[#D90000] hover:text-[#B00000] p-1">
                <Search class="w-4 h-4" />
              </button>
              <button @click="isSearchOpen = false" class="text-gray-400 hover:text-gray-600 p-1">
                <CloseIcon class="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- ============================================== -->
    <!-- 3. STICKY MAIN NAVIGATION BAR                  -->
    <!-- ============================================== -->
    <nav
      class="sticky top-0 z-40 bg-white dark:bg-[#16181D] border-b-2 border-[#D90000] shadow-sm transition-shadow duration-200"
      :class="{ 'shadow-md': isScrolled }"
    >
      <div class="max-w-7xl mx-auto px-3 sm:px-4 relative">
        <div class="flex items-center justify-between">
          <!-- Horizontal Scrollable Nav Links -->
          <div class="flex items-center space-x-1 sm:space-x-2 overflow-x-auto no-scrollbar py-2 text-sm font-bold whitespace-nowrap">
            <!-- Home -->
            <Link
              href="/"
              class="px-2.5 py-1 rounded text-[#D90000] bg-red-50 dark:bg-red-950/30 font-black hover:bg-red-100 dark:hover:bg-red-950/50 transition-colors shrink-0"
            >
              होम
            </Link>

            <!-- Bharat / State with Mega Menu -->
            <div
              class="relative shrink-0 group"
              @mouseenter="activeMegaMenu = 'bharat'"
              @mouseleave="activeMegaMenu = null"
            >
              <button
                class="flex items-center gap-0.5 px-2.5 py-1 text-gray-800 dark:text-zinc-200 hover:text-[#D90000] hover:bg-gray-50 dark:hover:bg-zinc-800 rounded transition-colors"
              >
                <span>भारत</span>
                <ChevronDown class="w-3 h-3 text-gray-400 group-hover:rotate-180 transition-transform" />
              </button>

              <!-- Mega Menu Dropdown -->
              <div
                v-if="activeMegaMenu === 'bharat'"
                class="absolute left-0 top-full w-[320px] sm:w-[480px] md:w-[600px] bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 shadow-2xl p-4 rounded-b-md z-50"
              >
                <div class="flex items-center justify-between pb-2 mb-3 border-b border-gray-100 dark:border-zinc-800">
                  <span class="text-xs font-bold uppercase tracking-wider text-[#D90000]">राज्यवार मुख्य खबरें</span>
                  <Link href="/category/india" class="text-[11px] text-gray-500 hover:text-[#D90000]">सभी राज्य देखें →</Link>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                  <Link
                    v-for="st in indianStates"
                    :key="st.slug"
                    :href="`/search?q=${encodeURIComponent(st.name)}`"
                    class="p-1.5 hover:bg-red-50 dark:hover:bg-red-950/30 hover:text-[#D90000] rounded font-medium text-gray-700 dark:text-zinc-300 transition-colors truncate"
                  >
                    {{ st.name }}
                  </Link>
                </div>
              </div>
            </div>

            <!-- Dynamic Categories -->
            <Link
              v-for="cat in categories"
              :key="cat.slug"
              :href="`/category/${cat.slug}`"
              class="px-2.5 py-1 text-gray-800 dark:text-zinc-200 hover:text-[#D90000] hover:bg-gray-50 dark:hover:bg-zinc-800 rounded transition-colors shrink-0"
            >
              {{ getCatName(cat) }}
            </Link>

            <!-- Static Anchor Categories -->
            <a
              href="#videos"
              class="px-2.5 py-1 text-gray-800 dark:text-zinc-200 hover:text-[#D90000] hover:bg-gray-50 dark:hover:bg-zinc-800 rounded transition-colors shrink-0 flex items-center gap-1"
            >
              <VideoIcon class="w-3.5 h-3.5 text-[#D90000]" />
              <span>वीडियो</span>
            </a>

            <a
              href="#photos"
              class="px-2.5 py-1 text-gray-800 dark:text-zinc-200 hover:text-[#D90000] hover:bg-gray-50 dark:hover:bg-zinc-800 rounded transition-colors shrink-0 flex items-center gap-1"
            >
              <Film class="w-3.5 h-3.5 text-blue-600" />
              <span>फोटो</span>
            </a>
          </div>
        </div>
      </div>
    </nav>

    <!-- ============================================== -->
    <!-- 4. BREAKING NEWS TICKER BAR                    -->
    <!-- ============================================== -->
    <div
      class="bg-[#111317] text-white border-b border-zinc-800 text-xs sm:text-sm py-1.5 px-3 sm:px-4"
      @mouseenter="isTickerPaused = true"
      @mouseleave="isTickerPaused = false"
    >
      <div class="max-w-7xl mx-auto flex items-center gap-3">
        <!-- Red Pill Label -->
        <div class="bg-[#D90000] text-white px-2.5 py-0.5 rounded text-[11px] font-black uppercase tracking-wider flex items-center gap-1 shrink-0 animate-pulse">
          <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
          <span>ब्रेकिंग न्यूज़</span>
        </div>

        <!-- Rotating Headline -->
        <div class="flex-1 overflow-hidden relative h-5">
          <Transition name="fade-slide" mode="out-in">
            <Link
              v-if="currentBreakingItem"
              :key="currentBreakingItem.id || currentTickerIndex"
              :href="currentBreakingItem.slug ? `/article/${currentBreakingItem.slug}` : '#'"
              class="absolute inset-0 flex items-center text-gray-200 hover:text-white hover:underline truncate font-semibold"
            >
              {{ currentLocale === 'hi' ? (currentBreakingItem.title_hi || currentBreakingItem.title) : currentBreakingItem.title }}
            </Link>
          </Transition>
        </div>

        <!-- Ticker controls -->
        <span class="text-[10px] text-zinc-400 hidden sm:inline shrink-0">
          {{ currentTickerIndex + 1 }} / {{ tickerItems.length }}
        </span>
      </div>
    </div>

    <!-- ============================================== -->
    <!-- 5. TRENDING TOPICS ROW (CHIPS)                 -->
    <!-- ============================================== -->
    <div class="bg-[#FAFAFA] dark:bg-[#15171C] border-b border-[#E5E5E5] dark:border-zinc-800 py-1.5 px-3 sm:px-4 text-xs">
      <div class="max-w-7xl mx-auto flex items-center gap-2 overflow-x-auto no-scrollbar whitespace-nowrap">
        <div class="flex items-center gap-1 font-bold text-[#D90000] shrink-0 text-xs">
          <Flame class="w-3.5 h-3.5" />
          <span>ट्रेंडिंग:</span>
        </div>

        <Link
          v-for="(t, i) in trendingTopics"
          :key="i"
          :href="t.url || `/search?q=${encodeURIComponent(t.title)}`"
          class="px-2 py-0.5 rounded bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 text-gray-700 dark:text-zinc-300 hover:text-[#D90000] hover:border-[#D90000] text-[11px] sm:text-xs font-medium transition-colors"
        >
          {{ t.title }}
        </Link>
      </div>
    </div>

    <!-- ============================================== -->
    <!-- 6. MAIN CONTENT SLOT                           -->
    <!-- ============================================== -->
    <main class="flex-1 pb-16 md:pb-8">
      <slot />
    </main>

    <!-- ============================================== -->
    <!-- 7. MOBILE FIXED BOTTOM NAVIGATION              -->
    <!-- ============================================== -->
    <div class="fixed bottom-0 inset-x-0 z-50 md:hidden bg-white dark:bg-[#16181D] border-t border-gray-200 dark:border-zinc-800 shadow-2xl py-1.5 px-3 flex items-center justify-around text-[10px] font-bold">
      <Link href="/" class="flex flex-col items-center text-[#D90000]">
        <HomeIcon class="w-5 h-5" />
        <span class="mt-0.5">होम</span>
      </Link>

      <a href="#videos" class="flex flex-col items-center text-gray-600 dark:text-zinc-400 hover:text-[#D90000]">
        <VideoIcon class="w-5 h-5" />
        <span class="mt-0.5">वीडियो</span>
      </a>

      <a href="#live-tv" class="flex flex-col items-center text-[#D90000]">
        <div class="relative">
          <Tv class="w-5 h-5" />
          <span class="absolute -top-0.5 -right-0.5 w-2 h-2 rounded-full bg-[#D90000] animate-ping"></span>
        </div>
        <span class="mt-0.5">लाइव टीवी</span>
      </a>

      <a href="#reels" class="flex flex-col items-center text-gray-600 dark:text-zinc-400 hover:text-[#D90000]">
        <Film class="w-5 h-5" />
        <span class="mt-0.5">न्यूज़ रील</span>
      </a>

      <button @click="isDrawerOpen = true" class="flex flex-col items-center text-gray-600 dark:text-zinc-400 hover:text-[#D90000]">
        <MenuIcon class="w-5 h-5" />
        <span class="mt-0.5">मेन्यू</span>
      </button>
    </div>

    <!-- ============================================== -->
    <!-- 8. FULL-SCREEN SECTIONS DRAWER                 -->
    <!-- ============================================== -->
    <div
      v-if="isDrawerOpen"
      class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex justify-start"
      @click.self="isDrawerOpen = false"
    >
      <div class="w-full max-w-md h-full bg-white dark:bg-[#14161B] p-6 overflow-y-auto shadow-2xl flex flex-col justify-between">
        <div>
          <!-- Drawer Header -->
          <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-zinc-800 mb-6">
            <div class="flex flex-col">
              <span class="font-hindi font-black text-2xl text-[#D90000]">
                {{ brand.name_hi || 'द क्रॉनिकल' }}
              </span>
              <span class="text-[10px] text-gray-400 uppercase tracking-widest font-sans">
                सभी सेक्शंस और राज्य
              </span>
            </div>
            <button
              @click="isDrawerOpen = false"
              class="p-2 text-gray-500 hover:text-gray-900 dark:hover:text-white"
            >
              <CloseIcon class="w-6 h-6" />
            </button>
          </div>

          <!-- Section Links -->
          <div class="space-y-4">
            <div>
              <span class="text-[11px] font-bold uppercase tracking-wider text-[#D90000] block mb-2">
                प्रमुख सेक्शंस
              </span>
              <div class="grid grid-cols-2 gap-2 text-sm font-semibold">
                <Link
                  href="/"
                  @click="isDrawerOpen = false"
                  class="p-2 rounded bg-gray-50 dark:bg-zinc-800/60 hover:text-[#D90000]"
                >
                  होम
                </Link>
                <Link
                  v-for="cat in categories"
                  :key="cat.slug"
                  :href="`/category/${cat.slug}`"
                  @click="isDrawerOpen = false"
                  class="p-2 rounded bg-gray-50 dark:bg-zinc-800/60 hover:text-[#D90000] truncate"
                >
                  {{ getCatName(cat) }}
                </Link>
              </div>
            </div>

            <!-- State List -->
            <div class="pt-4 border-t border-gray-100 dark:border-zinc-800">
              <span class="text-[11px] font-bold uppercase tracking-wider text-[#D90000] block mb-2">
                राज्यवार खबरें
              </span>
              <div class="grid grid-cols-2 gap-1.5 text-xs">
                <Link
                  v-for="st in indianStates"
                  :key="st.slug"
                  :href="`/search?q=${encodeURIComponent(st.name)}`"
                  @click="isDrawerOpen = false"
                  class="p-1.5 hover:text-[#D90000] text-gray-700 dark:text-zinc-300 truncate"
                >
                  {{ st.name }}
                </Link>
              </div>
            </div>
          </div>
        </div>

        <!-- Drawer Footer -->
        <div class="pt-6 border-t border-gray-200 dark:border-zinc-800 mt-6 text-xs text-gray-500 space-y-2">
          <div class="flex items-center justify-between">
            <span>भाषा बदलें:</span>
            <div class="flex gap-2">
              <button @click="switchLanguage('hi')" :class="currentLocale === 'hi' ? 'text-[#D90000] font-bold' : ''">हिंदी</button>
              <span>|</span>
              <button @click="switchLanguage('en')" :class="currentLocale === 'en' ? 'text-[#D90000] font-bold' : ''">English</button>
            </div>
          </div>
          <p class="text-[10px] text-gray-400">© 2026 {{ brand.name }}. All rights reserved.</p>
        </div>
      </div>
    </div>

    <!-- ============================================== -->
    <!-- 9. DARK PORTAL FOOTER                          -->
    <!-- ============================================== -->
    <footer class="bg-[#1A1A1A] text-zinc-300 pt-10 pb-16 md:pb-10 border-t-4 border-[#D90000]">
      <div class="max-w-7xl mx-auto px-4">
        <!-- Top Footer Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-8 border-b border-zinc-800">
          <!-- Col 1: Brand Info -->
          <div class="md:col-span-1">
            <span class="font-hindi font-black text-2xl text-white tracking-tight">
              {{ brand.name_hi || 'द क्रॉनिकल' }}
            </span>
            <p class="text-xs text-zinc-400 mt-2 leading-relaxed">
              देश और दुनिया की हर बड़ी खबर, ज़मीनी पड़ताल और विश्वसनीय विश्लेषण 24x7 आप तक।
            </p>
            <div class="mt-4 flex items-center gap-3">
              <a href="#" class="w-8 h-8 rounded-full bg-zinc-800 hover:bg-[#D90000] text-white flex items-center justify-center transition-colors">
                <Share2 class="w-4 h-4" />
              </a>
            </div>
          </div>

          <!-- Col 2: Categories -->
          <div>
            <h4 class="font-bold text-white text-xs uppercase tracking-wider mb-3 border-l-2 border-[#D90000] pl-2">
              प्रमुख श्रेणियां
            </h4>
            <div class="grid grid-cols-2 gap-2 text-xs text-zinc-400">
              <Link
                v-for="cat in categories.slice(0, 8)"
                :key="cat.slug"
                :href="`/category/${cat.slug}`"
                class="hover:text-white transition-colors"
              >
                {{ getCatName(cat) }}
              </Link>
            </div>
          </div>

          <!-- Col 3: Policy & Legal Links -->
          <div>
            <h4 class="font-bold text-white text-xs uppercase tracking-wider mb-3 border-l-2 border-[#D90000] pl-2">
              कंपनी और नीतियां
            </h4>
            <div class="flex flex-col space-y-2 text-xs text-zinc-400">
              <Link href="/about" class="hover:text-white transition-colors">हमारे बारे में (About Us)</Link>
              <Link href="/contact" class="hover:text-white transition-colors">संपर्क करें (Contact Us)</Link>
              <Link href="/advertise" class="hover:text-white transition-colors">विज्ञापन (Advertise)</Link>
              <Link href="/privacy" class="hover:text-white transition-colors">गोपनीयता नीति (Privacy Policy)</Link>
              <Link href="/terms" class="hover:text-white transition-colors">नियम और शर्तें (Terms of Use)</Link>
              <a href="#" class="hover:text-white transition-colors">शिकायत निवारण (Complaint Redressal)</a>
              <a href="#" class="hover:text-white transition-colors">संशोधन नीति (Correction Policy)</a>
            </div>
          </div>

          <!-- Col 4: Trending Tags & App Downloads -->
          <div>
            <h4 class="font-bold text-white text-xs uppercase tracking-wider mb-3 border-l-2 border-[#D90000] pl-2">
              ट्रेंडिंग टैग्स
            </h4>
            <div class="flex flex-wrap gap-1.5">
              <Link
                v-for="(t, i) in trendingTopics"
                :key="i"
                :href="t.url"
                class="px-2 py-0.5 rounded bg-zinc-800 text-[11px] text-zinc-300 hover:bg-[#D90000] hover:text-white transition-colors"
              >
                {{ t.title }}
              </Link>
            </div>
          </div>
        </div>

        <!-- Bottom Copyright -->
        <div class="pt-6 text-center text-xs text-zinc-500">
          <p>© 2026 {{ brand.name }} ({{ brand.name_hi }}). सर्वाधिकार सुरक्षित। All rights reserved.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<style scoped>
.no-scrollbar::-webkit-scrollbar {
  display: none;
}
.no-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.3s ease;
}
.fade-slide-enter-from {
  opacity: 0;
  transform: translateY(10px);
}
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>

