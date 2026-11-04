<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import MainLayout from '@/Layouts/MainLayout.vue';
import ArticleCard from '@/Components/ArticleCard.vue';
import Pagination from '@/Components/Pagination.vue';
import { CheckCircle2, Mail, FileText, Eye, Home, ChevronRight, Globe, ArrowRight } from 'lucide-vue-next';

const props = defineProps({
  author: {
    type: Object,
    required: true,
  },
  articles: {
    type: Object,
    required: true,
  },
  stats: {
    type: Object,
    default: () => ({ total_articles: 0, total_views: 0 }),
  },
});

const { locale } = useI18n();

const name = computed(() => {
  if (locale.value === 'hi' && props.author.name_hi) {
    return props.author.name_hi;
  }
  return props.author.name;
});

const role = computed(() => {
  if (locale.value === 'hi' && props.author.role_title_hi) {
    return props.author.role_title_hi;
  }
  return props.author.role_title || 'Contributing Editor';
});

const bio = computed(() => {
  if (locale.value === 'hi' && props.author.bio_hi) {
    return props.author.bio_hi;
  }
  return props.author.bio;
});
</script>

<template>
  <MainLayout>
    <Head>
      <title>{{ name }} — The Chronicle Editorial Staff</title>
      <meta name="description" :content="bio || `${name} is an investigative correspondent at The Chronicle.`" />
    </Head>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
      <!-- Breadcrumbs -->
      <nav class="flex items-center gap-2 text-xs text-muted mb-8">
        <Link href="/" class="hover:text-accent flex items-center gap-1 transition-colors">
          <Home class="w-3.5 h-3.5" />
          <span>{{ $t('nav.home') }}</span>
        </Link>
        <ChevronRight class="w-3.5 h-3.5 text-muted/60" />
        <span class="text-muted">Editorial Staff</span>
        <ChevronRight class="w-3.5 h-3.5 text-muted/60" />
        <span class="font-bold uppercase tracking-wider text-accent font-mono">{{ name }}</span>
      </nav>

      <!-- Author Profile Header Card -->
      <div class="p-6 sm:p-10 bg-surface dark:bg-zinc-900 rounded-2xl border border-border dark:border-zinc-800 shadow-sm mb-12">
        <div class="flex flex-col md:flex-row items-start md:items-center gap-8">
          <!-- Large Circular Photo with Crimson Ring -->
          <div class="relative flex-shrink-0">
            <img
              v-if="author.avatar"
              :src="author.avatar"
              :alt="name"
              class="w-28 h-28 sm:w-36 sm:h-36 rounded-full object-cover ring-4 ring-[#C8102E] shadow-lg"
            />
            <div class="absolute bottom-1 right-1 w-6 h-6 rounded-full bg-accent text-white flex items-center justify-center shadow">
              <CheckCircle2 class="w-4 h-4 fill-current" />
            </div>
          </div>

          <div class="flex-1 min-w-0">
            <div class="flex flex-wrap items-center gap-2 mb-1.5">
              <h1 class="text-3xl sm:text-5xl font-serif font-black text-ink dark:text-white tracking-tight">
                {{ name }}
              </h1>
            </div>

            <p class="text-xs sm:text-sm font-semibold uppercase tracking-widest text-[#C8102E] font-mono mb-4">
              {{ role }} • NEW DELHI BUREAU
            </p>

            <p v-if="bio" class="text-sm sm:text-base text-gray-700 dark:text-zinc-300 font-serif leading-relaxed max-w-3xl">
              {{ bio }}
            </p>

            <!-- Metrics & Handles -->
            <div class="flex flex-wrap items-center gap-6 mt-6 pt-6 border-t border-border/80 text-xs text-muted">
              <div class="flex items-center gap-1.5 font-sans">
                <FileText class="w-4 h-4 text-accent" />
                <span><strong class="text-ink dark:text-white font-mono">{{ stats.total_articles }}</strong> Published Dispatches</span>
              </div>

              <div class="flex items-center gap-1.5 font-sans">
                <Eye class="w-4 h-4 text-accent" />
                <span><strong class="text-ink dark:text-white font-mono">{{ Number(stats.total_views).toLocaleString() }}</strong> Reader Views</span>
              </div>

              <a
                v-if="author.twitter_handle"
                :href="`https://twitter.com/${author.twitter_handle.replace('@', '')}`"
                target="_blank"
                rel="noopener noreferrer"
                class="font-mono text-accent hover:underline flex items-center gap-1"
              >
                <span>{{ author.twitter_handle }}</span>
              </a>

              <a
                v-if="author.email"
                :href="`mailto:${author.email}`"
                class="text-muted hover:text-ink flex items-center gap-1.5 transition-colors font-mono"
              >
                <Mail class="w-3.5 h-3.5" />
                <span>{{ author.email }}</span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Author's Articles Archive -->
      <div class="flex items-center justify-between pb-3 mb-8 border-b-2 border-border">
        <h2 class="text-xs font-bold uppercase tracking-widest text-ink dark:text-white font-mono">
          Investigation Catalog: Articles by {{ name }}
        </h2>
        <span class="text-xs font-mono text-muted">
          Page {{ articles.current_page }} of {{ articles.last_page }}
        </span>
      </div>

      <!-- Articles Grid (3 Columns) -->
      <div
        v-if="articles.data && articles.data.length > 0"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
      >
        <ArticleCard
          v-for="art in articles.data"
          :key="art.id"
          :article="art"
          variant="medium"
          :show-image="true"
          :show-excerpt="true"
        />
      </div>

      <!-- Empty State with Custom Illustration -->
      <div v-else class="py-20 text-center max-w-md mx-auto">
        <div class="w-24 h-24 mx-auto mb-4 text-[#C8102E]/60 flex items-center justify-center">
          <svg class="w-20 h-20" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="28" y="24" width="64" height="72" rx="4" stroke="currentColor" stroke-width="3"/>
            <path d="M40 40H80M40 52H80M40 64H68" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
            <circle cx="84" cy="80" r="12" fill="#C8102E" fill-opacity="0.15" stroke="#C8102E" stroke-width="3"/>
            <path d="M84 74V82M84 86H84.01" stroke="#C8102E" stroke-width="3" stroke-linecap="round"/>
          </svg>
        </div>
        <h3 class="text-xl font-serif font-black text-ink dark:text-white mb-2">
          No Dispatches on File
        </h3>
        <p class="text-xs text-muted mb-6 leading-relaxed">
          {{ name }} does not have any public investigations registered at this moment.
        </p>
        <Link
          href="/"
          class="inline-flex items-center gap-2 px-5 py-2.5 rounded bg-accent text-white text-xs font-bold uppercase tracking-wider hover:bg-[#A00D24] transition-colors"
        >
          <span>Explore Other Writers</span>
        </Link>
      </div>

      <Pagination :links="articles.links" />
    </div>
  </MainLayout>
</template>
