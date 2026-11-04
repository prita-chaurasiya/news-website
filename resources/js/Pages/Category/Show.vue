<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import MainLayout from '@/Layouts/MainLayout.vue';
import ArticleCard from '@/Components/ArticleCard.vue';
import Pagination from '@/Components/Pagination.vue';
import NewsletterSignup from '@/Components/NewsletterSignup.vue';
import ResponsiveImage from '@/Components/UI/ResponsiveImage.vue';
import { ChevronRight, Home, Clock, Sparkles, Newspaper } from 'lucide-vue-next';

const props = defineProps({
  category: {
    type: Object,
    required: true,
  },
  featuredStory: {
    type: Object,
    default: null,
  },
  articles: {
    type: Object,
    required: true,
  },
});

const { locale } = useI18n();

const isFirstPage = computed(() => {
  return !props.articles.prev_page_url;
});

const categoryName = computed(() => {
  if (locale.value === 'hi' && props.category.name_hi) {
    return props.category.name_hi;
  }
  return props.category.name;
});

const categoryDescription = computed(() => {
  if (locale.value === 'hi' && props.category.description_hi) {
    return props.category.description_hi;
  }
  return props.category.description || `In-depth reporting, continuous updates, and analytical ground dispatches from ${categoryName.value}.`;
});

// The 3 sub-stories featured alongside or below the big lead story (only on page 1)
const subStories = computed(() => {
  if (!isFirstPage.value || !props.articles?.data) return [];
  // Exclude the featured story if it appears in articles list
  const list = props.articles.data.filter(a => a.id !== props.featuredStory?.id);
  return list.slice(0, 3);
});

// Remaining articles for the clean broadsheet grid
const gridArticles = computed(() => {
  if (!props.articles?.data) return [];
  if (isFirstPage.value && subStories.value.length > 0) {
    const subIds = new Set(subStories.value.map(a => a.id));
    if (props.featuredStory) subIds.add(props.featuredStory.id);
    return props.articles.data.filter(a => !subIds.has(a.id));
  }
  return props.articles.data;
});

const getArticleTitle = (art) => {
  if (!art) return '';
  if (locale.value === 'hi' && art.title_hi) return art.title_hi;
  return art.title;
};

const getArticleExcerpt = (art) => {
  if (!art) return '';
  if (locale.value === 'hi' && art.excerpt_hi) return art.excerpt_hi;
  return art.excerpt || art.subtitle || '';
};

const getArticleUrl = (art) => {
  if (!art?.slug) return '#';
  return locale.value === 'hi' ? `/hi/article/${art.slug}` : `/article/${art.slug}`;
};
</script>

<template>
  <MainLayout>
    <Head>
      <title>{{ categoryName }} News & Analysis — THE CHRONICLE</title>
      <meta name="description" :content="categoryDescription" />
    </Head>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
      <!-- Breadcrumbs -->
      <nav class="flex items-center gap-2 text-xs text-muted mb-6">
        <Link href="/" class="hover:text-accent flex items-center gap-1 transition-colors">
          <Home class="w-3.5 h-3.5" />
          <span>{{ $t('nav.home') }}</span>
        </Link>
        <ChevronRight class="w-3.5 h-3.5 text-muted/60" />
        <span class="font-bold uppercase tracking-wider text-accent font-mono">
          {{ categoryName }}
        </span>
      </nav>

      <!-- Category Hero Header with Broadsheet Double Rule -->
      <header class="pb-6 mb-8 border-b-4 border-ink dark:border-white" :style="{ borderColor: category.color || '#C8102E' }">
        <div class="flex items-center gap-2.5 mb-2">
          <span class="w-3.5 h-3.5 rounded-sm" :style="{ backgroundColor: category.color || '#C8102E' }"></span>
          <span class="text-xs font-bold tracking-widest uppercase text-muted font-mono">
            SECTION DESK • ARCHIVAL COVERAGE
          </span>
        </div>
        <h1 class="text-4xl sm:text-6xl font-serif font-black text-ink dark:text-white uppercase tracking-tight">
          {{ categoryName }}
        </h1>
        <p v-if="categoryDescription" class="text-base sm:text-lg text-gray-600 dark:text-zinc-300 font-serif max-w-3xl mt-2 leading-relaxed">
          {{ categoryDescription }}
        </p>
      </header>

      <!-- ============================================== -->
      <!-- 1. BIG FEATURED STORY + 3 SUB-STORIES (PAGE 1) -->
      <!-- ============================================== -->
      <section v-if="isFirstPage && featuredStory" class="mb-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
          <!-- Big Featured Story (7 Cols) -->
          <div class="lg:col-span-7 bg-surface dark:bg-zinc-900/90 rounded-xl border border-border p-5 sm:p-6 shadow-sm group">
            <span class="inline-block text-[10px] font-bold uppercase tracking-widest text-[#C8102E] font-mono mb-2">
              ★ Lead Coverage
            </span>

            <Link :href="getArticleUrl(featuredStory)" class="block overflow-hidden rounded-lg aspect-[16/10] mb-4 shadow-sm">
              <ResponsiveImage
                :src="featuredStory.featured_image || 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=1200&q=80'"
                :alt="getArticleTitle(featuredStory)"
                aspect-ratio="16/9"
                :priority="true"
                rounded="rounded-lg"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
              />
            </Link>

            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-black text-ink dark:text-white group-hover:text-accent transition-colors leading-tight mb-3">
              <Link :href="getArticleUrl(featuredStory)">
                {{ getArticleTitle(featuredStory) }}
              </Link>
            </h2>

            <p class="text-sm sm:text-base text-gray-600 dark:text-zinc-300 font-serif line-clamp-3 mb-4 leading-relaxed">
              {{ getArticleExcerpt(featuredStory) }}
            </p>

            <div class="text-xs text-muted flex items-center justify-between pt-3 border-t border-border/70 font-sans">
              <span>By <strong class="text-ink dark:text-white">{{ featuredStory.author?.name || 'Staff' }}</strong></span>
              <span class="flex items-center gap-1 font-mono">
                <Clock class="w-3 h-3" />
                {{ featuredStory.reading_time || 5 }} min read
              </span>
            </div>
          </div>

          <!-- 3 Sub-Stories (5 Cols) -->
          <div class="lg:col-span-5 flex flex-col gap-5">
            <div
              v-for="(sub, idx) in subStories"
              :key="sub.id"
              class="p-4 sm:p-5 bg-white dark:bg-zinc-900 rounded-xl border border-border shadow-xs hover:border-accent transition-all duration-200 group flex items-start gap-4"
            >
              <Link :href="getArticleUrl(sub)" class="w-24 sm:w-28 aspect-[4/3] rounded-lg overflow-hidden flex-shrink-0 bg-surface">
                <img
                  :src="sub.featured_image || 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=400&q=80'"
                  :alt="getArticleTitle(sub)"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                  loading="lazy"
                />
              </Link>

              <div class="flex-1 min-w-0">
                <span class="text-[10px] font-bold uppercase tracking-wider text-accent font-mono mb-1 block">
                  Dispatch 0{{ idx + 1 }}
                </span>
                <h3 class="text-sm sm:text-base font-serif font-black text-ink dark:text-white group-hover:text-accent transition-colors line-clamp-2 leading-snug mb-1.5">
                  <Link :href="getArticleUrl(sub)">
                    {{ getArticleTitle(sub) }}
                  </Link>
                </h3>
                <div class="text-[11px] text-muted flex items-center gap-2 font-mono">
                  <span>{{ sub.reading_time || 4 }} min read</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ============================================== -->
      <!-- 2. CATEGORY ACCENT LINE SEPARATOR              -->
      <!-- ============================================== -->
      <div class="my-10 flex items-center gap-4">
        <div class="h-1 flex-1 rounded-full" :style="{ backgroundColor: category.color || '#C8102E' }"></div>
        <span class="text-xs font-bold uppercase tracking-widest text-muted font-mono whitespace-nowrap">
          ALL {{ categoryName }} DISPATCHES
        </span>
        <div class="h-1 flex-1 rounded-full" :style="{ backgroundColor: category.color || '#C8102E' }"></div>
      </div>

      <!-- ============================================== -->
      <!-- 3. CLEAN 3-COLUMN ARTICLES GRID                -->
      <!-- ============================================== -->
      <div
        v-if="gridArticles && gridArticles.length > 0"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
      >
        <ArticleCard
          v-for="art in gridArticles"
          :key="art.id"
          :article="art"
          variant="medium"
          :show-image="true"
          :show-excerpt="true"
        />
      </div>

      <!-- ============================================== -->
      <!-- 4. EMPTY STATE WITH VECTOR SVG ILLUSTRATION   -->
      <!-- ============================================== -->
      <div
        v-else-if="!featuredStory && (!articles.data || articles.data.length === 0)"
        class="py-20 text-center max-w-md mx-auto"
      >
        <div class="w-24 h-24 mx-auto mb-4 text-[#C8102E]/60 flex items-center justify-center">
          <svg class="w-20 h-20" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="20" y="24" width="80" height="72" rx="6" stroke="currentColor" stroke-width="3" stroke-dasharray="6 6"/>
            <path d="M36 44H84M36 56H84M36 68H64M36 80H52" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
            <circle cx="80" cy="74" r="8" stroke="#C8102E" stroke-width="3"/>
            <path d="M86 80L94 88" stroke="#C8102E" stroke-width="3" stroke-linecap="round"/>
          </svg>
        </div>
        <h3 class="text-xl font-serif font-black text-ink dark:text-white mb-2">
          No Dispatches in {{ categoryName }}
        </h3>
        <p class="text-xs text-muted mb-6 leading-relaxed">
          Our editorial bureau is actively preparing ground coverage for this section. Check back shortly or browse other desks.
        </p>
        <Link
          href="/"
          class="inline-flex items-center gap-2 px-5 py-2.5 rounded bg-accent text-white text-xs font-bold uppercase tracking-wider hover:bg-[#A00D24] transition-colors"
        >
          <span>Return to Front Page</span>
        </Link>
      </div>

      <!-- Pagination Links -->
      <Pagination :links="articles.links" />

      <!-- In-Flow Newsletter -->
      <div class="mt-14">
        <NewsletterSignup />
      </div>
    </div>
  </MainLayout>
</template>
