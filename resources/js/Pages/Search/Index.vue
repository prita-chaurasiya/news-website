<script setup>
import { ref, watch } from 'vue';
import { Head, router, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import axios from 'axios';
import MainLayout from '@/Layouts/MainLayout.vue';
import ArticleCard from '@/Components/ArticleCard.vue';
import Pagination from '@/Components/Pagination.vue';
import { Search, Filter, Calendar, X, ArrowRight, Globe, Clock } from 'lucide-vue-next';

const props = defineProps({
  query: {
    type: String,
    default: '',
  },
  selectedCategory: {
    type: String,
    default: '',
  },
  selectedDate: {
    type: String,
    default: 'all',
  },
  selectedLanguage: {
    type: String,
    default: 'all',
  },
  articles: {
    type: Object,
    required: true,
  },
  categories: {
    type: Array,
    default: () => [],
  },
  totalResults: {
    type: Number,
    default: 0,
  },
});

const { locale } = useI18n();

const searchQuery = ref(props.query);
const category = ref(props.selectedCategory);
const dateRange = ref(props.selectedDate);
const language = ref(props.selectedLanguage || 'all');

// Instant debounced suggestions
const suggestions = ref([]);
const isSuggesting = ref(false);
let debounceTimer = null;

const onQueryInput = () => {
  if (debounceTimer) clearTimeout(debounceTimer);

  if (searchQuery.value.trim().length < 2) {
    suggestions.value = [];
    return;
  }

  isSuggesting.value = true;
  debounceTimer = setTimeout(async () => {
    try {
      const res = await axios.get(`/api/search/suggestions?q=${encodeURIComponent(searchQuery.value.trim())}`);
      suggestions.value = res.data;
    } catch (e) {
      suggestions.value = [];
    } finally {
      isSuggesting.value = false;
    }
  }, 250);
};

const executeSearch = () => {
  suggestions.value = [];
  router.get('/search', {
    q: searchQuery.value,
    category: category.value,
    date: dateRange.value,
    lang: language.value,
  }, {
    preserveState: true,
    preserveScroll: true,
  });
};

const setCategory = (slug) => {
  category.value = slug;
  executeSearch();
};

const setDateRange = (range) => {
  dateRange.value = range;
  executeSearch();
};

const setLanguage = (lang) => {
  language.value = lang;
  executeSearch();
};

const clearFilter = () => {
  searchQuery.value = '';
  category.value = '';
  dateRange.value = 'all';
  language.value = 'all';
  executeSearch();
};
</script>

<template>
  <MainLayout>
    <Head>
      <title>Search The Chronicle Archives — Real-Time Investigations</title>
      <meta name="description" content="Search across our full archival catalog of investigative reporting, foreign correspondence, and domestic ground dispatches." />
    </Head>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
      <!-- Search Banner -->
      <div class="max-w-4xl mx-auto mb-10 text-center">
        <span class="text-xs font-mono font-bold uppercase tracking-widest text-[#C8102E] block mb-2">
          NEWSROOM ARCHIVAL SEARCH
        </span>
        <h1 class="text-3xl sm:text-5xl font-serif font-black text-ink dark:text-white mb-6 tracking-tight">
          Search The Chronicle Archive
        </h1>

        <!-- Large Search Input Box with Instant Suggestions -->
        <div class="relative max-w-3xl mx-auto">
          <form @submit.prevent="executeSearch" class="flex gap-2">
            <div class="relative flex-1">
              <Search class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-muted" />
              <input
                v-model="searchQuery"
                @input="onQueryInput"
                type="text"
                placeholder="Search headlines, journalists, topics, policies, or places..."
                class="w-full pl-12 pr-10 py-4 rounded-xl bg-surface dark:bg-zinc-900 border-2 border-border dark:border-zinc-700 text-base focus:outline-none focus:border-[#C8102E] shadow-sm font-sans"
              />
              <button
                v-if="searchQuery"
                type="button"
                @click="searchQuery = ''; suggestions = [];"
                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-muted hover:text-ink p-1"
              >
                <X class="w-4 h-4" />
              </button>
            </div>

            <button
              type="submit"
              class="bg-[#C8102E] hover:bg-[#A00D24] text-white font-bold text-xs uppercase tracking-wider px-8 py-4 rounded-xl transition-all shadow-md flex items-center gap-2 flex-shrink-0"
            >
              <span>Search</span>
              <ArrowRight class="w-4 h-4" />
            </button>
          </form>

          <!-- Autocomplete Instant Suggestions Dropdown -->
          <div
            v-if="suggestions.length > 0"
            class="absolute top-full left-0 right-0 mt-2 bg-white dark:bg-zinc-900 rounded-xl shadow-2xl border border-border dark:border-zinc-800 z-50 overflow-hidden divide-y divide-border text-left"
          >
            <div class="p-2.5 text-[10px] font-bold uppercase tracking-widest text-muted font-mono bg-surface dark:bg-zinc-950 px-4">
              Instant Matches
            </div>
            <Link
              v-for="s in suggestions"
              :key="s.id"
              :href="locale === 'hi' ? `/hi/article/${s.slug}` : `/article/${s.slug}`"
              class="p-3.5 flex items-center justify-between hover:bg-red-50/50 dark:hover:bg-zinc-800 transition-colors"
            >
              <span class="text-xs sm:text-sm font-serif font-bold text-ink dark:text-white line-clamp-1">
                {{ locale === 'hi' && s.title_hi ? s.title_hi : s.title }}
              </span>
              <span v-if="s.category" class="text-[10px] font-semibold text-[#C8102E] uppercase ml-2 flex-shrink-0 font-mono">
                {{ s.category.name }}
              </span>
            </Link>
          </div>
        </div>

        <!-- ============================================== -->
        <!-- FILTER CHIPS: CATEGORY, DATE, LANGUAGE         -->
        <!-- ============================================== -->
        <div class="mt-8 space-y-4 max-w-3xl mx-auto text-left">
          <!-- Category Filter Chips -->
          <div>
            <div class="text-[11px] font-bold uppercase tracking-wider text-muted font-mono mb-2 flex items-center gap-1.5">
              <Filter class="w-3.5 h-3.5 text-accent" />
              <span>Category Filter:</span>
            </div>
            <div class="flex flex-wrap gap-2">
              <button
                @click="setCategory('')"
                type="button"
                class="px-3 py-1 rounded-full text-xs font-semibold transition-all"
                :class="category === ''
                  ? 'bg-accent text-white shadow-xs'
                  : 'bg-surface dark:bg-zinc-900 border border-border text-muted hover:text-ink'"
              >
                All Sections
              </button>
              <button
                v-for="cat in categories"
                :key="cat.slug"
                @click="setCategory(cat.slug)"
                type="button"
                class="px-3 py-1 rounded-full text-xs font-semibold transition-all"
                :class="category === cat.slug
                  ? 'bg-accent text-white shadow-xs'
                  : 'bg-surface dark:bg-zinc-900 border border-border text-muted hover:text-ink'"
              >
                {{ cat.name }}
              </button>
            </div>
          </div>

          <!-- Date & Language Row -->
          <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pt-3 border-t border-border/60">
            <!-- Date Chips -->
            <div>
              <div class="text-[11px] font-bold uppercase tracking-wider text-muted font-mono mb-2 flex items-center gap-1.5">
                <Calendar class="w-3.5 h-3.5 text-accent" />
                <span>Publication Timeline:</span>
              </div>
              <div class="flex flex-wrap gap-1.5">
                <button
                  v-for="d in [
                    { key: 'all', label: 'Any Date' },
                    { key: 'today', label: 'Past 24 Hours' },
                    { key: 'week', label: 'Past 7 Days' },
                    { key: 'month', label: 'Past 30 Days' }
                  ]"
                  :key="d.key"
                  @click="setDateRange(d.key)"
                  type="button"
                  class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition-all"
                  :class="dateRange === d.key
                    ? 'bg-ink dark:bg-white text-white dark:text-ink font-bold'
                    : 'bg-surface dark:bg-zinc-900 border border-border text-muted hover:text-ink'"
                >
                  {{ d.label }}
                </button>
              </div>
            </div>

            <!-- Clear Filter Trigger -->
            <button
              v-if="category || dateRange !== 'all' || searchQuery"
              @click="clearFilter"
              class="text-xs text-accent hover:underline font-bold uppercase tracking-wider font-mono self-end sm:self-center"
            >
              Reset Filters
            </button>
          </div>
        </div>
      </div>

      <!-- Results Count Header -->
      <div class="flex items-center justify-between pb-3 mb-8 border-b-2 border-border">
        <h2 class="text-xs font-bold uppercase tracking-widest text-ink dark:text-white font-mono">
          Search Results: <span class="text-accent">{{ totalResults }} Dispatches Found</span>
        </h2>
        <span v-if="query" class="text-xs text-muted font-serif italic">
          Query: "{{ query }}"
        </span>
      </div>

      <!-- ============================================== -->
      <!-- IMAGE RESULTS (HORIZONTAL BROADSHEET FORMAT)   -->
      <!-- ============================================== -->
      <div
        v-if="articles.data && articles.data.length > 0"
        class="divide-y divide-border max-w-4xl mx-auto"
      >
        <ArticleCard
          v-for="art in articles.data"
          :key="art.id"
          :article="art"
          variant="horizontal"
          :show-image="true"
          :show-excerpt="true"
        />
      </div>

      <!-- ============================================== -->
      <!-- EMPTY STATE WITH CUSTOM VECTOR SVG ILLUSTRATION -->
      <!-- ============================================== -->
      <div v-else class="py-20 text-center max-w-md mx-auto">
        <div class="w-24 h-24 mx-auto mb-4 text-[#C8102E]/60 flex items-center justify-center">
          <svg class="w-24 h-24" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="52" cy="52" r="32" stroke="currentColor" stroke-width="3" stroke-dasharray="4 4"/>
            <path d="M76 76L102 102" stroke="#C8102E" stroke-width="4" stroke-linecap="round"/>
            <path d="M40 44H64M40 54H60M40 64H52" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
          </svg>
        </div>

        <h3 class="text-2xl font-serif font-black text-ink dark:text-white mb-2">
          No Dispatches Found
        </h3>
        <p class="text-xs text-muted leading-relaxed mb-6">
          We could not locate any reports matching your search parameters. Try verifying your spelling, searching broader keywords, or clearing active category filters.
        </p>
        <button
          @click="clearFilter"
          type="button"
          class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-accent text-white font-bold text-xs uppercase tracking-wider hover:bg-[#A00D24] transition-colors"
        >
          <span>Reset All Search Filters</span>
        </button>
      </div>

      <!-- Pagination -->
      <Pagination :links="articles.links" />
    </div>
  </MainLayout>
</template>
