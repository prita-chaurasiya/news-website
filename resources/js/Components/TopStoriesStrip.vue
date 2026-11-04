<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import { Clock, ChevronRight } from 'lucide-vue-next';
import ResponsiveImage from '@/Components/UI/ResponsiveImage.vue';

const props = defineProps({
  articles: {
    type: Array,
    default: () => [],
  },
});

const { locale } = useI18n();

const safeArticles = computed(() => {
  if (Array.isArray(props.articles)) return props.articles.slice(0, 5);
  return [];
});

const getTitle = (art) => {
  if (locale.value === 'hi' && art.title_hi) return art.title_hi;
  return art.title;
};

const getCategory = (art) => {
  if (!art.category) return '';
  if (locale.value === 'hi' && art.category.name_hi) return art.category.name_hi;
  return art.category.name;
};
</script>

<template>
  <section v-if="safeArticles.length" class="my-8 py-5 border-y-2 border-ink bg-surface">
    <div class="flex items-center justify-between pb-3 mb-4 px-2 border-b border-border">
      <div class="flex items-center gap-2">
        <span class="w-2.5 h-2.5 bg-accent rounded-sm animate-pulse"></span>
        <h3 class="text-xs font-bold uppercase tracking-widest text-ink font-mono flex items-center gap-2">
          <span>TOP STORIES NOW</span>
          <span class="text-muted text-[10px]">• CURATED BY THE DESK</span>
        </h3>
      </div>
      <span class="text-[11px] text-muted hidden sm:inline">Updated Continuous Dispatch</span>
    </div>

    <!-- Numbered Horizontal Grid with Real Thumbnails -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 divide-y sm:divide-y-0 sm:divide-x divide-border">
      <div
        v-for="(art, idx) in safeArticles"
        :key="art.id"
        class="pt-3 sm:pt-0 sm:px-3 first:pl-1 last:pr-1 group flex flex-col justify-between"
      >
        <div>
          <!-- Big Ranking Number + Category -->
          <div class="flex items-baseline justify-between mb-2">
            <span class="font-serif font-black text-2xl sm:text-3xl text-muted/30 group-hover:text-accent transition-colors font-mono">
              0{{ idx + 1 }}
            </span>
            <span class="text-[10px] font-bold uppercase tracking-wider text-accent font-mono">
              {{ getCategory(art) }}
            </span>
          </div>

          <!-- Thumbnail & Headline -->
          <div class="flex gap-2.5 items-start mb-2">
            <Link
              v-if="art.featured_image"
              :href="`/article/${art.slug}`"
              class="w-14 h-14 sm:w-16 sm:h-16 flex-shrink-0 rounded-md overflow-hidden block"
            >
              <ResponsiveImage
                :src="art.featured_image"
                :alt="getTitle(art)"
                aspect-ratio="1/1"
                :priority="false"
                rounded="rounded-md"
              />
            </Link>
            <h4 class="text-xs sm:text-sm font-serif font-bold text-ink group-hover:text-accent transition-colors leading-snug line-clamp-3">
              <Link :href="`/article/${art.slug}`">
                {{ getTitle(art) }}
              </Link>
            </h4>
          </div>
        </div>

        <!-- Meta -->
        <div class="mt-2 flex items-center justify-between text-[11px] text-muted">
          <span class="flex items-center gap-1 font-mono">
            <Clock class="w-3 h-3" />
            {{ art.reading_time || 4 }} min
          </span>
          <Link
            :href="`/article/${art.slug}`"
            class="opacity-0 group-hover:opacity-100 transition-opacity text-accent flex items-center"
          >
            <ChevronRight class="w-3.5 h-3.5" />
          </Link>
        </div>
      </div>
    </div>
  </section>
</template>
