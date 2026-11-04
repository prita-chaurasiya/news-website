<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Search, Home, ArrowLeft, Newspaper } from 'lucide-vue-next';

const searchQuery = ref('');

const handleSearch = () => {
  if (searchQuery.value.trim()) {
    router.get(`/search?q=${encodeURIComponent(searchQuery.value.trim())}`);
  }
};
</script>

<template>
  <MainLayout>
    <Head>
      <title>404 — Dispatch Not Found — THE CHRONICLE</title>
      <meta name="description" content="The dispatch or archival report you requested could not be located in our digital archives." />
    </Head>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-16 sm:py-24 text-center">
      <!-- Custom Vector Broadsheet Illustration -->
      <div class="w-32 h-32 mx-auto mb-6 text-[#C8102E] flex items-center justify-center">
        <svg class="w-32 h-32" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
          <!-- Newspaper Base Sheet -->
          <rect x="24" y="24" width="112" height="112" rx="6" fill="#FAF8F5" stroke="#0B0F19" stroke-width="3.5"/>
          <!-- Masthead bar -->
          <rect x="36" y="36" width="88" height="12" fill="#0B0F19"/>
          <!-- Double rule -->
          <line x1="36" y1="54" x2="124" y2="54" stroke="#C8102E" stroke-width="2"/>
          <line x1="36" y1="58" x2="124" y2="58" stroke="#0B0F19" stroke-width="1"/>
          <!-- Columns -->
          <line x1="36" y1="70" x2="74" y2="70" stroke="#8E95A5" stroke-width="3" stroke-linecap="round"/>
          <line x1="36" y1="80" x2="74" y2="80" stroke="#8E95A5" stroke-width="3" stroke-linecap="round"/>
          <line x1="36" y1="90" x2="68" y2="90" stroke="#8E95A5" stroke-width="3" stroke-linecap="round"/>
          <line x1="36" y1="100" x2="72" y2="100" stroke="#8E95A5" stroke-width="3" stroke-linecap="round"/>
          <!-- Red Missing Section Cutout -->
          <circle cx="102" cy="88" r="22" fill="#C8102E" fill-opacity="0.12" stroke="#C8102E" stroke-width="3.5" stroke-dasharray="4 4"/>
          <!-- Question Mark -->
          <path d="M100 80C100 78 101.5 76 104 76C106.5 76 108 78 108 80C108 82.5 106 84 104 86V88.5M104 94H104.01" stroke="#C8102E" stroke-width="3.5" stroke-linecap="round"/>
        </svg>
      </div>

      <span class="text-xs font-mono font-bold uppercase tracking-widest text-[#C8102E] bg-red-50 dark:bg-red-950/40 px-3 py-1 rounded-full inline-block mb-3">
        EDITORIAL 404 • DISPATCH NOT FOUND
      </span>

      <h1 class="text-4xl sm:text-6xl font-serif font-black text-ink dark:text-white mt-2 mb-4 tracking-tight">
        Story Missing From Archive
      </h1>

      <p class="text-base sm:text-lg text-gray-600 dark:text-zinc-300 font-serif mb-8 leading-relaxed max-w-xl mx-auto">
        The report you requested may have been archived, renamed during an editorial update, or temporarily retracted during fact-checking.
      </p>

      <!-- Search in 404 -->
      <div class="max-w-md mx-auto mb-8">
        <form @submit.prevent="handleSearch" class="flex gap-2">
          <div class="relative flex-1">
            <Search class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-muted" />
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search headline keywords..."
              class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-surface dark:bg-zinc-900 border border-border text-xs focus:outline-none focus:border-accent font-sans"
            />
          </div>
          <button
            type="submit"
            class="px-4 py-2.5 bg-accent hover:bg-[#A00D24] text-white text-xs font-bold uppercase tracking-wider rounded-lg transition-colors"
          >
            Search
          </button>
        </form>
      </div>

      <!-- Action Buttons -->
      <div class="flex flex-wrap items-center justify-center gap-4">
        <Link
          href="/"
          class="inline-flex items-center gap-2 bg-[#C8102E] hover:bg-[#A00D24] text-white font-bold text-xs uppercase tracking-wider px-6 py-3.5 rounded transition-colors shadow-sm"
        >
          <Home class="w-4 h-4" />
          <span>Return to Front Page</span>
        </Link>

        <Link
          href="/search"
          class="inline-flex items-center gap-2 bg-surface dark:bg-zinc-800 border border-border text-ink dark:text-zinc-200 hover:text-accent font-bold text-xs uppercase tracking-wider px-6 py-3.5 rounded transition-colors"
        >
          <Search class="w-4 h-4" />
          <span>Browse Complete Archive</span>
        </Link>
      </div>
    </div>
  </MainLayout>
</template>
