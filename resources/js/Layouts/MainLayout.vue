<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { usePage, Link, router } from '@inertiajs/vue3';
import { useNewsStore } from '@/stores/newsStore';
import Rule from '@/Components/UI/Rule.vue';
import {
  Sun,
  Moon,
  Search,
  Menu as MenuIcon,
  X as CloseIcon,
  CloudSun,
  Radio,
  FileText,
  User as UserIcon,
  ExternalLink,
  ChevronDown,
  Shield,
  Bookmark,
  LogOut,
  ArrowUp,
} from 'lucide-vue-next';

const { locale, t } = useI18n();
const page = usePage();
const newsStore = useNewsStore();

const isMobileMenuOpen = ref(false);
const isSearchOpen = ref(false);
const isUserMenuOpen = ref(false);
const isScrolled = ref(false);
const searchQuery = ref('');
const selectedCityKey = ref('delhi');

const handleScroll = () => {
  if (typeof window !== 'undefined') {
    isScrolled.value = window.scrollY > 100;
  }
};

const scrollToTop = () => {
  if (typeof window !== 'undefined') {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
};

// Shared Props from HandleInertiaRequests
const brand = computed(() => page.props.brand || {
  name: 'The Chronicle',
  name_hi: 'द क्रॉनिकल',
  tagline: 'Independent Journalism. Global Perspective.',
  tagline_hi: 'स्वतंत्र पत्रकारिता। वैश्विक दृष्टिकोण।',
  volume: 'VOLUME I • NO. 42',
  founded: 'FOUNDED 2026 • NEW DELHI',
  edition: 'INTERNATIONAL EDITION',
});

const currentLocale = computed(() => page.props.locale || locale.value || 'en');

watch(
  () => page.props.locale,
  (newLoc) => {
    if (newLoc && newLoc !== locale.value) {
      locale.value = newLoc;
      if (typeof window !== 'undefined') {
        localStorage.setItem('locale', newLoc);
      }
    }
  },
  { immediate: true }
);

const categories = computed(() => {
  const raw = page.props.categories;
  if (Array.isArray(raw)) return raw;
  if (raw && typeof raw === 'object') return Object.values(raw);
  return [];
});
const footerCategories = computed(() => categories.value.slice(0, 6));
const siteSettings = computed(() => page.props.siteSettings || {});
const authUser = computed(() => page.props.auth?.user || null);

// Weather Data
const weatherData = computed(() => {
  const weatherMap = {
    delhi: siteSettings.value.weather_delhi || { city: 'New Delhi', city_hi: 'नई दिल्ली', temp: '28°C', condition: 'Clear Sky', condition_hi: 'साफ आसमान' },
    mumbai: siteSettings.value.weather_mumbai || { city: 'Mumbai', city_hi: 'मुंबई', temp: '31°C', condition: 'Humid', condition_hi: 'आर्द्र' },
    bengaluru: siteSettings.value.weather_bengaluru || { city: 'Bengaluru', city_hi: 'बेंगलुरु', temp: '24°C', condition: 'Pleasant', condition_hi: 'सुहावना मौसम' },
  };
  return weatherMap[selectedCityKey.value] || weatherMap.delhi;
});

const formattedDate = computed(() => {
  const d = new Date();
  return d.toLocaleDateString(currentLocale.value === 'hi' ? 'hi-IN' : 'en-US', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });
});

const mastheadTitle = computed(() => {
  return currentLocale.value === 'hi'
    ? (brand.value.name_hi || siteSettings.value.site_name_hi || 'द क्रॉनिकल')
    : (brand.value.name || siteSettings.value.site_name || 'The Chronicle');
});

const mastheadTagline = computed(() => {
  return currentLocale.value === 'hi'
    ? (brand.value.tagline_hi || siteSettings.value.site_tagline_hi || 'स्वतंत्र पत्रकारिता। वैश्विक दृष्टिकोण।')
    : (brand.value.tagline || siteSettings.value.site_tagline || 'Independent Journalism. Global Perspective.');
});

// Category Name Helper - guarantees SPORTS & OPINION without browser translation bugs
const getCatName = (cat) => {
  const slug = (cat.slug || '').toLowerCase();
  if (slug === 'sports') {
    return currentLocale.value === 'hi' ? 'खेल' : 'SPORTS';
  }
  if (slug === 'opinion') {
    return currentLocale.value === 'hi' ? 'विचार' : 'OPINION';
  }
  if (currentLocale.value === 'hi' && cat.name_hi) {
    return cat.name_hi;
  }
  return (cat.name || '').toUpperCase();
};

const isNavActive = (path) => {
  const currentPath = page.url.split('?')[0];
  if (path === '/') {
    return currentPath === '/' || currentPath === '/en' || currentPath === '/hi';
  }
  return currentPath.startsWith(path);
};

const getUserInitials = (name) => {
  if (!name) return 'U';
  const parts = name.trim().split(/\s+/);
  if (parts.length >= 2) {
    return (parts[0][0] + parts[1][0]).toUpperCase();
  }
  return name.substring(0, 2).toUpperCase();
};

const csrfToken = computed(() => {
  if (typeof document !== 'undefined') {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
  }
  return '';
});

// Switch Language
const switchLanguage = (newLang) => {
  if (currentLocale.value === newLang) return;
  locale.value = newLang;
  newsStore.setLocale(newLang);
  router.get(`/lang/${newLang}`, {}, {
    preserveState: false,
    preserveScroll: true,
  });
};

// Search Submit
const handleSearch = () => {
  if (!searchQuery.value.trim()) return;
  isSearchOpen.value = false;
  router.get(`/search?q=${encodeURIComponent(searchQuery.value.trim())}`);
};

const handleGlobalClick = (event) => {
  if (isUserMenuOpen.value && !event.target.closest('.relative')) {
    isUserMenuOpen.value = false;
  }
};

onMounted(() => {
  document.documentElement.lang = currentLocale.value;
  document.addEventListener('click', handleGlobalClick);
  window.addEventListener('scroll', handleScroll, { passive: true });
});

onUnmounted(() => {
  document.removeEventListener('click', handleGlobalClick);
  window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
  <div class="min-h-screen flex flex-col font-sans bg-[#FBFBFB] dark:bg-[#0F1115] text-[#121212] dark:text-[#EAEAEA]">
    <!-- ============================================== -->
    <!-- 1. TOP UTILITY BAR                            -->
    <!-- ============================================== -->
    <header class="border-b border-gray-200 dark:border-zinc-800 text-[11px] bg-white dark:bg-zinc-950">
      <div class="max-w-7xl mx-auto px-4 py-1.5 flex items-center justify-between">
        <!-- Date & Weather Widget -->
        <div class="flex items-center gap-4 text-gray-500 dark:text-zinc-400">
          <span class="font-medium hidden sm:inline">{{ formattedDate }}</span>

          <span class="hidden sm:inline text-gray-300 dark:text-zinc-700">•</span>

          <!-- Weather Quick Widget -->
          <div class="flex items-center gap-1.5 cursor-pointer group relative">
            <CloudSun class="w-3.5 h-3.5 text-amber-500" />
            <span class="font-medium">
              {{ locale === 'hi' ? weatherData.city_hi : weatherData.city }}:
              <strong class="text-gray-800 dark:text-zinc-200">{{ weatherData.temp }}</strong>
            </span>
            <span class="hidden md:inline text-[10px] text-gray-400">({{ locale === 'hi' ? weatherData.condition_hi : weatherData.condition }})</span>
            
            <!-- City Dropdown -->
            <select
              v-model="selectedCityKey"
              class="opacity-0 absolute inset-0 cursor-pointer w-full"
              aria-label="Select weather city"
            >
              <option value="delhi">Delhi</option>
              <option value="mumbai">Mumbai</option>
              <option value="bengaluru">Bengaluru</option>
            </select>
          </div>
        </div>

        <!-- Right Side: Lang, Dark Mode, Auth & Subscribe -->
        <div class="flex items-center gap-3 sm:gap-4">
          <!-- E-paper Link -->
          <a
            href="#epaper"
            class="hidden md:flex items-center gap-1 text-gray-600 dark:text-zinc-400 hover:text-[#C8102E] font-medium transition-colors"
          >
            <FileText class="w-3 h-3" />
            <span>{{ $t('nav.epaper') }}</span>
          </a>

          <!-- Language Switcher Button Group -->
          <div class="flex items-center bg-gray-100 dark:bg-zinc-900 rounded p-0.5 border border-gray-200 dark:border-zinc-800 text-[10px] font-bold">
            <button
              @click="switchLanguage('en')"
              :class="currentLocale === 'en' ? 'bg-white dark:bg-zinc-800 text-[#C8102E] shadow-sm' : 'text-gray-500 dark:text-zinc-400 hover:text-black dark:hover:text-white'"
              class="px-2 py-0.5 rounded transition-colors"
            >
              EN
            </button>
            <button
              @click="switchLanguage('hi')"
              :class="currentLocale === 'hi' ? 'bg-white dark:bg-zinc-800 text-[#C8102E] shadow-sm' : 'text-gray-500 dark:text-zinc-400 hover:text-black dark:hover:text-white'"
              class="px-2 py-0.5 rounded transition-colors font-hindi"
            >
              हिन्दी
            </button>
          </div>

          <!-- Dark / Light Mode Toggle -->
          <button
            @click="newsStore.toggleTheme"
            class="p-1 rounded text-gray-500 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-white transition-colors"
            :title="newsStore.theme === 'dark' ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
            aria-label="Toggle theme"
          >
            <Sun v-if="newsStore.theme === 'dark'" class="w-3.5 h-3.5 text-amber-400" />
            <Moon v-else class="w-3.5 h-3.5 text-zinc-600" />
          </button>

          <!-- Auth Status & Initials Avatar Dropdown -->
          <div v-if="authUser" class="relative">
            <button
              @click="isUserMenuOpen = !isUserMenuOpen"
              class="flex items-center gap-1.5 focus:outline-none group"
              aria-label="User Account Menu"
            >
              <div class="w-6 h-6 rounded-full bg-[#C8102E] text-white flex items-center justify-center text-[10px] font-bold tracking-tight shadow-sm ring-1 ring-white dark:ring-zinc-900 group-hover:bg-[#A00D24] transition-colors">
                {{ getUserInitials(authUser.name) }}
              </div>
              <ChevronDown class="w-3 h-3 text-gray-500 group-hover:text-gray-800 dark:group-hover:text-zinc-200 transition-transform duration-150" :class="{ 'rotate-180': isUserMenuOpen }" />
            </button>

            <!-- Dropdown Menu -->
            <div
              v-if="isUserMenuOpen"
              class="absolute right-0 mt-2 w-48 bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-md shadow-xl py-1 z-50 text-xs"
            >
              <div class="px-3 py-2 border-b border-gray-100 dark:border-zinc-800">
                <p class="font-bold text-gray-900 dark:text-white truncate">{{ authUser.name }}</p>
                <p class="text-[10px] text-gray-500 dark:text-zinc-400 truncate">{{ authUser.email }}</p>
              </div>

              <Link
                v-if="authUser.email === 'admin@news.com' || (authUser.roles && authUser.roles.length)"
                href="/admin"
                @click="isUserMenuOpen = false"
                class="flex items-center gap-2 px-3 py-2 text-gray-700 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-800 hover:text-[#C8102E]"
              >
                <Shield class="w-3.5 h-3.5 text-[#C8102E]" />
                <span>Admin Dashboard</span>
              </Link>

              <Link
                href="/bookmarks"
                @click="isUserMenuOpen = false"
                class="flex items-center gap-2 px-3 py-2 text-gray-700 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-800 hover:text-[#C8102E]"
              >
                <Bookmark class="w-3.5 h-3.5 text-gray-400" />
                <span>Saved Articles</span>
              </Link>

              <div class="border-t border-gray-100 dark:border-zinc-800 my-1"></div>

              <form action="/logout" method="POST" class="w-full">
                <input type="hidden" name="_token" :value="csrfToken" />
                <button
                  type="submit"
                  class="w-full flex items-center gap-2 px-3 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 text-left transition-colors font-medium"
                >
                  <LogOut class="w-3.5 h-3.5" />
                  <span>Sign Out</span>
                </button>
              </form>
            </div>
          </div>

          <a
            v-else
            href="/admin/demo-login"
            class="hidden sm:inline-flex items-center gap-1 font-semibold text-gray-700 dark:text-zinc-300 hover:text-[#C8102E] transition-colors"
            title="1-Click Admin Access"
          >
            <span>Admin</span>
          </a>

          <!-- Subscribe Button -->
          <a
            href="#subscribe"
            class="bg-[#C8102E] hover:bg-[#A00D24] text-white font-bold px-3 py-1 rounded text-[11px] tracking-wider uppercase transition-colors shadow-sm"
          >
            {{ $t('nav.subscribe') }}
          </a>
        </div>
      </div>
    </header>

    <!-- ============================================== -->
    <!-- 2. MASTHEAD / MAIN LOGO                       -->
    <!-- ============================================== -->
    <div class="py-6 sm:py-8 bg-paper border-b border-border transition-all duration-300">
      <div class="max-w-7xl mx-auto px-4 text-center">
        <!-- Edition and Established line -->
        <div class="flex items-center justify-between text-[11px] uppercase tracking-widest text-muted mb-2 font-mono">
          <span class="hidden md:inline">{{ brand.founded || 'FOUNDED 2026 • NEW DELHI' }}</span>
          <span class="mx-auto md:mx-0 font-bold text-accent">{{ brand.volume || 'VOLUME I • NO. 42' }}</span>
          <span class="hidden md:inline">{{ brand.edition || 'INTERNATIONAL EDITION' }}</span>
        </div>

        <!-- Big Serif Brand Logo -->
        <Link href="/" class="inline-block group">
          <h1 class="text-3xl sm:text-5xl lg:text-6xl font-serif font-black tracking-tight text-ink group-hover:text-accent transition-colors">
            {{ mastheadTitle }}
          </h1>
        </Link>

        <!-- Tagline -->
        <p class="text-xs text-muted italic tracking-wider mt-1.5 font-serif">
          {{ mastheadTagline }}
        </p>

        <!-- Double Rule Under Masthead (NYT / The Hindu / Economist style) -->
        <Rule variant="double" margin="mt-4 mb-0" />
      </div>
    </div>

    <!-- ============================================== -->
    <!-- 3. STICKY CATEGORY NAVIGATION BAR (SHRINKS ON SCROLL) -->
    <!-- ============================================== -->
    <nav class="sticky top-0 z-40 bg-paper/95 backdrop-blur-md border-b-2 border-ink shadow-sm transition-all duration-200">
      <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-12">
        <!-- Mobile Drawer Hamburger -->
        <button
          @click="isMobileMenuOpen = !isMobileMenuOpen"
          class="lg:hidden p-1.5 text-ink hover:text-accent"
          aria-label="Open navigation menu"
        >
          <MenuIcon class="w-5 h-5" />
        </button>

        <!-- Desktop Categories Strip: Aligned Baseline, Animated Red Underline -->
        <div class="hidden lg:flex items-center space-x-6 xl:space-x-7 overflow-x-auto no-scrollbar h-full">
          <!-- Shrunk Brand Mark when scrolled -->
          <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 -translate-x-3 scale-95"
            enter-to-class="opacity-100 translate-x-0 scale-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 translate-x-0 scale-100"
            leave-to-class="opacity-0 -translate-x-3 scale-95"
          >
            <Link
              v-if="isScrolled"
              href="/"
              class="flex items-center gap-2 flex-shrink-0 font-serif font-black text-lg text-ink hover:text-accent transition-colors pr-4 mr-1 border-r border-border"
            >
              <span class="w-2.5 h-2.5 rounded-sm bg-accent inline-block"></span>
              <span class="tracking-tight whitespace-nowrap">{{ mastheadTitle }}</span>
            </Link>
          </transition>

          <Link
            href="/"
            class="relative h-full flex items-center text-xs font-semibold uppercase tracking-wider transition-colors after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-[#C8102E] after:transition-transform after:duration-200"
            :class="isNavActive('/') ? 'text-accent after:scale-x-100' : 'text-ink hover:text-accent after:scale-x-0 hover:after:scale-x-100'"
          >
            {{ $t('nav.home') }}
          </Link>

          <!-- LIVE Pulse Link: Aligned to exact same baseline & weight -->
          <a
            href="#live-blog"
            class="relative h-full flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-[#C8102E] hover:text-[#A00D24] transition-colors after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-[#C8102E] after:transition-transform after:duration-200 after:scale-x-0 hover:after:scale-x-100"
          >
            <span class="relative flex h-2 w-2">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#C8102E] opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2 w-2 bg-[#C8102E]"></span>
            </span>
            <span>{{ $t('nav.live') }}</span>
          </a>

          <!-- Dynamic Categories with guaranteed translations & notranslate protection -->
          <Link
            v-for="cat in categories"
            :key="cat.slug"
            :href="`/category/${cat.slug}`"
            notranslate
            translate="no"
            class="relative h-full flex items-center text-xs font-semibold uppercase tracking-wider transition-colors whitespace-nowrap after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-[#C8102E] after:transition-transform after:duration-200"
            :class="isNavActive(`/category/${cat.slug}`) ? 'text-[#C8102E] dark:text-[#C8102E] after:scale-x-100' : 'text-gray-800 dark:text-zinc-200 hover:text-[#C8102E] dark:hover:text-[#C8102E] after:scale-x-0 hover:after:scale-x-100'"
          >
            {{ getCatName(cat) }}
          </Link>
        </div>

        <!-- Right Side: Search Icon Trigger -->
        <div class="flex items-center gap-2">
          <button
            @click="isSearchOpen = !isSearchOpen"
            class="flex items-center gap-1.5 text-xs font-medium text-gray-600 dark:text-zinc-400 hover:text-[#C8102E] transition-colors p-1.5"
            aria-label="Search articles"
          >
            <Search class="w-4 h-4" />
            <span class="hidden sm:inline">{{ $t('nav.searchBtn') }}</span>
          </button>
        </div>
      </div>
    </nav>

    <!-- ============================================== -->
    <!-- 4. SEARCH OVERLAY MODAL                       -->
    <!-- ============================================== -->
    <div
      v-if="isSearchOpen"
      class="bg-white dark:bg-zinc-900 border-b border-gray-200 dark:border-zinc-800 shadow-lg py-4 px-4 transition-all"
    >
      <div class="max-w-3xl mx-auto">
        <form @submit.prevent="handleSearch" class="flex items-center gap-2">
          <div class="relative flex-1">
            <Search class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" />
            <input
              v-model="searchQuery"
              type="text"
              autofocus
              :placeholder="$t('nav.search')"
              class="w-full pl-10 pr-4 py-2.5 rounded bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 text-sm focus:outline-none focus:border-[#C8102E]"
            />
          </div>
          <button
            type="submit"
            class="bg-[#C8102E] hover:bg-[#A00D24] text-white font-bold text-xs uppercase tracking-wider px-5 py-2.5 rounded transition-colors"
          >
            {{ $t('nav.searchBtn') }}
          </button>
          <button
            type="button"
            @click="isSearchOpen = false"
            class="p-2 text-gray-400 hover:text-gray-900 dark:hover:text-white"
          >
            <CloseIcon class="w-5 h-5" />
          </button>
        </form>

        <div class="flex flex-wrap items-center gap-2 mt-3 text-xs text-gray-500 dark:text-zinc-400">
          <span class="font-semibold text-gray-700 dark:text-zinc-300">Trending Topics:</span>
          <Link href="/category/politics" class="hover:text-[#C8102E]">#CabinetCorridor</Link>
          <span>•</span>
          <Link href="/category/tech" class="hover:text-[#C8102E]">#BharatLLM</Link>
          <span>•</span>
          <Link href="/category/business" class="hover:text-[#C8102E]">#Sensex81k</Link>
          <span>•</span>
          <Link href="/category/sports" class="hover:text-[#C8102E]">#CricketAnalytics</Link>
        </div>
      </div>
    </div>

    <!-- ============================================== -->
    <!-- 5. MOBILE DRAWER NAVIGATION                   -->
    <!-- ============================================== -->
    <div
      v-if="isMobileMenuOpen"
      class="fixed inset-0 z-50 lg:hidden bg-black/60 backdrop-blur-sm"
      @click.self="isMobileMenuOpen = false"
    >
      <div class="w-4/5 max-w-sm h-full bg-white dark:bg-zinc-950 p-6 shadow-2xl flex flex-col justify-between overflow-y-auto">
        <div>
          <!-- Header of Drawer -->
          <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-zinc-800 mb-6">
            <h2 class="font-serif font-black text-xl text-gray-900 dark:text-white">
              {{ mastheadTitle }}
            </h2>
            <button
              @click="isMobileMenuOpen = false"
              class="p-1 text-gray-400 hover:text-gray-900 dark:hover:text-white"
            >
              <CloseIcon class="w-5 h-5" />
            </button>
          </div>

          <!-- Links -->
          <div class="space-y-3">
            <Link
              href="/"
              @click="isMobileMenuOpen = false"
              class="block text-sm font-bold uppercase tracking-wider text-gray-900 dark:text-white hover:text-[#C8102E]"
            >
              {{ $t('nav.home') }}
            </Link>

            <a
              href="#live-blog"
              @click="isMobileMenuOpen = false"
              class="flex items-center gap-2 text-sm font-black uppercase tracking-wider text-[#C8102E]"
            >
              <span class="w-2 h-2 rounded-full bg-[#C8102E] animate-ping"></span>
              {{ $t('nav.live') }}
            </a>

            <div class="pt-2 pb-1 border-t border-gray-100 dark:border-zinc-800">
              <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2 block">
                {{ $t('nav.menu') }}
              </span>
              <div class="space-y-2.5">
                <Link
                  v-for="cat in categories"
                  :key="cat.slug"
                  :href="`/category/${cat.slug}`"
                  @click="isMobileMenuOpen = false"
                  class="block text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-zinc-300 hover:text-[#C8102E]"
                >
                  {{ getCatName(cat) }}
                </Link>
              </div>
            </div>
          </div>
        </div>

        <!-- Footer of Drawer -->
        <div class="pt-6 border-t border-gray-200 dark:border-zinc-800 space-y-4">
          <div class="flex items-center justify-between">
            <span class="text-xs font-medium text-gray-500">Edition / भाषा</span>
            <div class="flex gap-2">
              <button
                @click="switchLanguage('en')"
                :class="currentLocale === 'en' ? 'font-bold text-[#C8102E]' : 'text-gray-400'"
                class="text-xs"
              >
                English
              </button>
              <span>|</span>
              <button
                @click="switchLanguage('hi')"
                :class="currentLocale === 'hi' ? 'font-bold text-[#C8102E]' : 'text-gray-400'"
                class="text-xs font-hindi"
              >
                हिन्दी
              </button>
            </div>
          </div>

          <a
            href="#subscribe"
            class="block w-full text-center bg-[#C8102E] text-white font-bold text-xs uppercase tracking-wider py-3 rounded"
          >
            {{ $t('nav.subscribe') }}
          </a>
        </div>
      </div>
    </div>

    <!-- ============================================== -->
    <!-- 6. MAIN PAGE CONTENT INJECTION                -->
    <!-- ============================================== -->
    <main class="flex-1">
      <slot />
    </main>

    <!-- ============================================== -->
    <!-- 7. RICH EDITORIAL FOOTER                      -->
    <!-- ============================================== -->
    <footer class="mt-16 bg-[#111317] text-zinc-300 pt-12 pb-8 border-t-4 border-[#C8102E]">
      <div class="max-w-7xl mx-auto px-4">
        <!-- Footer Top Branding -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between pb-8 mb-8 border-b border-zinc-800 gap-6">
          <div>
            <h2 class="text-2xl sm:text-3xl font-serif font-black text-white tracking-tight">
              {{ mastheadTitle }}
            </h2>
            <p class="text-xs text-zinc-400 mt-1 font-serif italic">
              {{ $t('footer.tagline') }}
            </p>
          </div>

          <!-- Social Handles -->
          <div class="flex items-center gap-3">
            <a href="#" class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-300 hover:bg-[#C8102E] hover:text-white transition-colors text-xs font-bold">X</a>
            <a href="#" class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-300 hover:bg-[#C8102E] hover:text-white transition-colors text-xs font-bold">FB</a>
            <a href="#" class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-300 hover:bg-[#C8102E] hover:text-white transition-colors text-xs font-bold">YT</a>
            <a href="#" class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-300 hover:bg-[#C8102E] hover:text-white transition-colors text-xs font-bold">TG</a>
            <a href="#" class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-300 hover:bg-[#C8102E] hover:text-white transition-colors text-xs font-bold">IG</a>
          </div>
        </div>

        <!-- Footer Columns Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 text-xs pb-12 border-b border-zinc-800">
          <!-- News Sections -->
          <div>
            <h4 class="font-bold uppercase tracking-widest text-white mb-3 border-b border-zinc-800 pb-1.5">
              News Sections
            </h4>
            <ul class="space-y-2">
              <li v-for="cat in footerCategories" :key="cat.slug">
                <Link :href="`/category/${cat.slug}`" class="hover:text-white hover:underline">
                  {{ getCatName(cat) }}
                </Link>
              </li>
            </ul>
          </div>

          <!-- Opinion & Analysis -->
          <div>
            <h4 class="font-bold uppercase tracking-widest text-white mb-3 border-b border-zinc-800 pb-1.5">
              Analysis & Multi-Media
            </h4>
            <ul class="space-y-2">
              <li><Link href="/category/opinion" class="hover:text-white hover:underline">{{ $t('nav.opinion') }}</Link></li>
              <li><a href="#live-blog" class="hover:text-white hover:underline">{{ $t('nav.live') }} Updates</a></li>
              <li><a href="#videos" class="hover:text-white hover:underline">{{ $t('nav.videos') }}</a></li>
              <li><a href="#epaper" class="hover:text-white hover:underline">{{ $t('nav.epaper') }}</a></li>
              <li><a href="#photo-stories" class="hover:text-white hover:underline">{{ $t('home.photoStories') }}</a></li>
            </ul>
          </div>

          <!-- The Organization -->
          <div>
            <h4 class="font-bold uppercase tracking-widest text-white mb-3 border-b border-zinc-800 pb-1.5">
              The Chronicle
            </h4>
            <ul class="space-y-2">
              <li><Link href="/about" class="hover:text-white hover:underline">{{ $t('footer.about') }}</Link></li>
              <li><Link href="/about" class="hover:text-white hover:underline">{{ $t('footer.editorialCode') }}</Link></li>
              <li><Link href="/about" class="hover:text-white hover:underline">{{ $t('footer.ethics') }}</Link></li>
              <li><Link href="/about" class="hover:text-white hover:underline">{{ $t('footer.careers') }}</Link></li>
              <li><Link href="/contact" class="hover:text-white hover:underline">{{ $t('footer.contact') }}</Link></li>
              <li><Link href="/advertise" class="hover:text-white hover:underline">{{ $t('footer.advertise') }}</Link></li>
            </ul>
          </div>

          <!-- Legal & Privacy -->
          <div>
            <h4 class="font-bold uppercase tracking-widest text-white mb-3 border-b border-zinc-800 pb-1.5">
              Legal & Policies
            </h4>
            <ul class="space-y-2">
              <li><Link href="/privacy" class="hover:text-white hover:underline">{{ $t('footer.privacy') }}</Link></li>
              <li><Link href="/terms" class="hover:text-white hover:underline">{{ $t('footer.terms') }}</Link></li>
              <li><Link href="/terms" class="hover:text-white hover:underline">{{ $t('footer.subscriptionTerms') }}</Link></li>
              <li><Link href="/privacy" class="hover:text-white hover:underline">{{ $t('footer.cookiePolicy') }}</Link></li>
              <li><a href="/sitemap.xml" target="_blank" class="hover:text-white hover:underline">Sitemap & RSS</a></li>
            </ul>
          </div>

          <!-- Apps & Subscriptions -->
          <div class="col-span-2 md:col-span-4 lg:col-span-1">
            <h4 class="font-bold uppercase tracking-widest text-white mb-3 border-b border-zinc-800 pb-1.5">
              Digital Editions
            </h4>
            <p class="text-zinc-400 text-xs mb-3">
              Read everywhere on iOS, Android, and web with offline sync.
            </p>
            <div class="space-y-2">
              <a href="#" class="block bg-zinc-800 hover:bg-zinc-700 text-white text-[11px] font-semibold px-3 py-2 rounded text-center">
                Download on App Store
              </a>
              <a href="#" class="block bg-zinc-800 hover:bg-zinc-700 text-white text-[11px] font-semibold px-3 py-2 rounded text-center">
                Get it on Google Play
              </a>
            </div>
          </div>
        </div>

        <!-- Bottom Copyright & Back to Top -->
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-[11px] text-zinc-500 gap-4 text-center sm:text-left">
          <p>© 2026 THE CHRONICLE MEDIA GROUP. {{ $t('footer.allRightsReserved') }}</p>
          
          <div class="flex items-center gap-6">
            <div class="flex items-center gap-4">
              <span>Powered by Laravel 11 & Vue 3</span>
              <span>•</span>
              <span class="text-zinc-400">WCAG AA Compliant</span>
            </div>

            <!-- Back to top button -->
            <button
              @click="scrollToTop"
              class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded bg-zinc-800 hover:bg-[#C8102E] text-zinc-300 hover:text-white transition-colors text-[10px] font-bold uppercase tracking-wider"
              title="Return to top of page"
            >
              <span>Back to Top</span>
              <ArrowUp class="w-3.5 h-3.5" />
            </button>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

