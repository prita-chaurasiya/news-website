<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import { Bookmark, Sparkles, Clock, ArrowRight } from 'lucide-vue-next';
import { useNewsStore } from '@/stores/newsStore';
import ResponsiveImage from '@/Components/UI/ResponsiveImage.vue';
import FadeUp from '@/Components/UI/FadeUp.vue';

const props = defineProps({
  articles: {
    type: Array,
    default: () => [],
  },
});

const { locale } = useI18n();
const newsStore = useNewsStore();

const picks = computed(() => {
  if (Array.isArray(props.articles)) return props.articles.slice(0, 3);
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

const getAuthor = (art) => {
  if (!art.author) return 'Editorial Staff';
  if (locale.value === 'hi' && art.author.name_hi) return art.author.name_hi;
  return art.author.name;
};
</script>

<template>
  <section v-if="picks.length" class="relative left-1/2 right-1/2 -mx-[50vw] w-screen bg-[#080B11] text-[#E8EAF0] py-12 sm:py-16 my-16 border-y border-zinc-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
      <!-- Section Header on Dark -->
      <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between pb-4 mb-8 border-b border-zinc-800 gap-4">
        <div>
          <div class="flex items-center gap-2 mb-2">
            <Sparkles class="w-4 h-4 text-[#D4AF37]" />
            <span class="text-xs uppercase font-mono font-bold tracking-widest text-[#D4AF37]">
              EDITOR'S CURATED PICKS
            </span>
          </div>
          <h2 class="text-2xl sm:text-4xl font-serif font-black text-white tracking-tight">
            Investigations & Long Reads
          </h2>
        </div>

        <p class="text-xs text-zinc-400 max-w-md font-editorial italic">
          Deep dives, archival reporting, and definitive analysis hand-selected by our senior editorial board.
        </p>
      </div>

      <!-- 3-Column Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <FadeUp
          v-for="(art, idx) in picks"
          :key="art.id"
          :delay="idx * 120"
        >
          <article class="group flex flex-col h-full bg-[#111622] rounded-lg border border-zinc-800/90 overflow-hidden hover:border-zinc-700 hover:shadow-2xl transition-all duration-300">
            <!-- Article Image -->
            <Link :href="`/article/${art.slug}`" class="block w-full">
              <ResponsiveImage
                :src="art.featured_image"
                :alt="getTitle(art)"
                aspect-ratio="16/9"
                :priority="false"
                :overlay="true"
                rounded="rounded-none"
              />
            </Link>

            <div class="p-5 flex-1 flex flex-col justify-between">
              <div>
                <div class="flex items-center justify-between gap-2 mb-2 text-xs">
                  <span class="text-[10px] font-bold uppercase tracking-wider text-[#C8102E] font-mono">
                    {{ art.category?.name || 'SPECIAL' }}
                  </span>
                  <span class="text-zinc-500 font-mono text-[11px] flex items-center gap-1">
                    <Clock class="w-3 h-3" />
                    {{ art.reading_time || 6 }} min read
                  </span>
                </div>

                <h3 class="text-lg font-serif font-bold text-white group-hover:text-[#D4AF37] transition-colors leading-snug mb-3">
                  <Link :href="`/article/${art.slug}`">
                    {{ getTitle(art) }}
                  </Link>
                </h3>

                <p class="text-xs text-zinc-400 font-editorial line-clamp-3 leading-relaxed mb-4">
                  {{ getExcerpt(art) }}
                </p>
              </div>

              <!-- Author Box & Action -->
              <div class="pt-4 border-t border-zinc-800/80 flex items-center justify-between mt-auto">
                <div class="flex items-center gap-2.5">
                  <img
                    v-if="art.author?.avatar"
                    :src="art.author.avatar"
                    :alt="getAuthor(art)"
                    class="w-7 h-7 rounded-full object-cover ring-2 ring-[#C8102E]/80"
                  />
                  <span class="text-xs font-medium text-zinc-300 truncate max-w-[120px]">
                    {{ getAuthor(art) }}
                  </span>
                </div>

                <Link
                  :href="`/article/${art.slug}`"
                  class="text-xs font-semibold uppercase tracking-wider text-white group-hover:text-[#D4AF37] flex items-center gap-1"
                >
                  <span>Read</span>
                  <ArrowRight class="w-3 h-3" />
                </Link>
              </div>
            </div>
          </article>
        </FadeUp>
      </div>
    </div>
  </section>
</template>

