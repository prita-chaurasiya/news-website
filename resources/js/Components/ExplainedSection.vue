<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import { HelpCircle, ArrowRight, Clock, Sparkles } from 'lucide-vue-next';
import ResponsiveImage from '@/Components/UI/ResponsiveImage.vue';

const props = defineProps({
  articles: {
    type: Array,
    default: () => [],
  },
});

const { locale } = useI18n();

const safeArticles = computed(() => {
  if (Array.isArray(props.articles) && props.articles.length > 0) {
    return props.articles.slice(0, 4);
  }
  return [];
});

const getTitle = (art) => {
  if (locale.value === 'hi' && art.title_hi) return art.title_hi;
  return art.title;
};

const getExcerpt = (art) => {
  if (locale.value === 'hi' && art.excerpt_hi) return art.excerpt_hi;
  return art.excerpt || art.subtitle;
};

const getCategory = (art) => {
  if (!art.category) return 'EXPLAINED';
  if (locale.value === 'hi' && art.category.name_hi) return art.category.name_hi;
  return art.category.name;
};

const mainStory = computed(() => safeArticles.value[0]);
const subStories = computed(() => safeArticles.value.slice(1, 4));
</script>

<template>
  <section id="explained" v-if="safeArticles.length" class="my-10 sm:my-14 py-8 px-4 sm:px-8 bg-surface border-y-2 border-ink rounded-sm scroll-mt-20">
    <!-- Indian Express EXPLAINED Section Masthead -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 mb-6 border-b border-border gap-2">
      <div>
        <div class="flex items-center gap-2">
          <span class="px-2.5 py-0.5 bg-[#C8102E] text-white text-xs font-black tracking-widest uppercase font-mono rounded-sm">
            EXPLAINED
          </span>
          <h2 class="font-serif font-black text-xl sm:text-2xl text-ink tracking-tight">
            {{ $t('home.explainedTitle') }}
          </h2>
        </div>
        <p class="text-xs text-muted mt-1 font-editorial italic">
          {{ $t('home.explainedSubtitle') }}
        </p>
      </div>

      <Link
        href="/search?q=explained"
        class="text-xs font-bold uppercase tracking-wider text-[#C8102E] hover:underline flex items-center gap-1 group font-mono shrink-0"
      >
        <span>Explore All Explained</span>
        <ArrowRight class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" />
      </Link>
    </div>

    <!-- 4-Card Explained Layout (1 Feature + 3 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
      <!-- Left Featured Explained Story (6 cols) -->
      <div v-if="mainStory" class="lg:col-span-6 group">
        <Link :href="`/article/${mainStory.slug}`" class="block">
          <div class="aspect-[16/9] overflow-hidden rounded-sm bg-paper mb-3.5 relative">
            <ResponsiveImage
              :src="mainStory.featured_image"
              :alt="getTitle(mainStory)"
              aspect-ratio="16/9"
              class="w-full h-full object-cover group-hover:scale-102 transition-transform duration-300"
            />
            <span class="absolute top-2.5 left-2.5 bg-[#C8102E] text-white text-[10px] font-black uppercase tracking-wider px-2 py-0.5 font-mono shadow">
              {{ getCategory(mainStory) }}
            </span>
          </div>

          <h3 class="font-serif font-bold text-xl sm:text-2xl text-ink group-hover:text-[#C8102E] transition-colors leading-tight mb-2">
            Explained: {{ getTitle(mainStory) }}
          </h3>

          <p class="font-editorial text-sm text-muted leading-relaxed line-clamp-2 mb-3">
            {{ getExcerpt(mainStory) }}
          </p>

          <div class="flex items-center gap-2 text-xs font-mono text-muted">
            <Clock class="w-3.5 h-3.5 text-[#C8102E]" />
            <span>{{ mainStory.reading_time || 5 }} MIN READ</span>
          </div>
        </Link>
      </div>

      <!-- Right 3 Column Cards (6 cols) -->
      <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-3 gap-4 lg:divide-x divide-border">
        <div
          v-for="(story, idx) in subStories"
          :key="story.id || idx"
          class="sm:px-3 first:pl-0 last:pr-0 group flex flex-col justify-between"
        >
          <div>
            <span class="text-[10px] uppercase font-mono tracking-wider font-bold text-[#C8102E] block mb-1.5">
              {{ getCategory(story) }}
            </span>

            <Link
              :href="`/article/${story.slug}`"
              class="font-serif font-bold text-sm sm:text-base text-ink group-hover:text-[#C8102E] transition-colors leading-snug line-clamp-3 mb-2 block"
            >
              Explained: {{ getTitle(story) }}
            </Link>

            <p class="text-xs text-muted font-editorial line-clamp-2 leading-relaxed">
              {{ getExcerpt(story) }}
            </p>
          </div>

          <div class="mt-3 pt-2 border-t border-dashed border-border/80 flex items-center justify-between text-[11px] font-mono text-muted">
            <span>{{ story.reading_time || 4 }} MIN</span>
            <Link :href="`/article/${story.slug}`" class="text-[#C8102E] hover:underline font-bold">
              Read →
            </Link>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
