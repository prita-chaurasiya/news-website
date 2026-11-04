<script setup>
import { onMounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import ArticleCard from '@/Components/ArticleCard.vue';
import Pagination from '@/Components/Pagination.vue';
import { useNewsStore } from '@/stores/newsStore';
import { Bookmark, Home, ChevronRight, BookOpen } from 'lucide-vue-next';

const props = defineProps({
  savedArticles: {
    type: Object,
    required: true,
  },
  isGuest: {
    type: Boolean,
    default: true,
  },
});

const newsStore = useNewsStore();

onMounted(() => {
  // If guest reader and query is missing IDs, hydrate from localStorage
  if (props.isGuest && newsStore.bookmarkedIds.length > 0) {
    const urlParams = new URLSearchParams(window.location.search);
    const existingIds = urlParams.get('ids');
    const localIds = newsStore.bookmarkedIds.join(',');

    if (existingIds !== localIds) {
      router.get('/bookmarks', { ids: localIds }, {
        preserveState: true,
        replace: true,
      });
    }
  }
});
</script>

<template>
  <MainLayout>
    <Head>
      <title>Saved Articles — THE CHRONICLE</title>
    </Head>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
      <!-- Breadcrumbs -->
      <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
        <Link href="/" class="hover:text-[#C8102E] flex items-center gap-1">
          <Home class="w-3.5 h-3.5" />
          <span>{{ $t('nav.home') }}</span>
        </Link>
        <ChevronRight class="w-3.5 h-3.5 text-gray-400" />
        <span class="font-bold uppercase tracking-wider text-[#C8102E]">Saved Stories</span>
      </nav>

      <!-- Header -->
      <div class="flex items-center justify-between pb-4 mb-8 border-b-2 border-gray-900 dark:border-gray-100">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 rounded-full bg-red-50 dark:bg-red-950/60 text-[#C8102E] flex items-center justify-center">
            <Bookmark class="w-4 h-4 fill-current" />
          </div>
          <div>
            <h1 class="text-2xl sm:text-3xl font-serif font-black text-gray-900 dark:text-white">
              Your Reading List
            </h1>
            <p class="text-xs text-gray-500 dark:text-zinc-400">
              Stories saved for offline review or later reading.
            </p>
          </div>
        </div>

        <span class="text-xs font-mono font-bold text-gray-400">
          {{ savedArticles.total || savedArticles.data.length }} Stories
        </span>
      </div>

      <!-- Articles Grid -->
      <div
        v-if="savedArticles.data && savedArticles.data.length > 0"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
      >
        <ArticleCard
          v-for="art in savedArticles.data"
          :key="art.id"
          :article="art"
          variant="medium"
          :show-image="true"
          :show-excerpt="true"
        />
      </div>

      <!-- Empty State with Vector SVG Illustration -->
      <div v-else class="py-20 text-center max-w-md mx-auto">
        <div class="w-24 h-24 mx-auto mb-4 text-[#C8102E]/60 flex items-center justify-center">
          <svg class="w-20 h-20" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M36 28C36 24 39 20 44 20H76C81 20 84 24 84 28V100L60 84L36 100V28Z" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M48 40H72M48 52H64" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
            <circle cx="60" cy="84" r="8" fill="#C8102E" fill-opacity="0.2"/>
          </svg>
        </div>
        <h3 class="text-xl font-serif font-black text-ink dark:text-white mb-2">
          Your Reading List is Empty
        </h3>
        <p class="text-xs text-muted mb-6 leading-relaxed">
          While reading any investigation, click the bookmark icon in the story byline or floating action bar to preserve it for offline reading.
        </p>
        <Link
          href="/"
          class="inline-block bg-[#C8102E] hover:bg-[#A00D24] text-white font-bold text-xs uppercase tracking-wider px-6 py-3 rounded-full transition-colors shadow-sm"
        >
          Explore Front Page Stories
        </Link>
      </div>

      <Pagination :links="savedArticles.links" />
    </div>
  </MainLayout>
</template>
