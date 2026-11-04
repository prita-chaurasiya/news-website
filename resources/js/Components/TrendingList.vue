<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import { Flame, Clock } from 'lucide-vue-next';

const props = defineProps({
  articles: {
    type: Array,
    default: () => [],
  },
});

const { locale } = useI18n();

const getTitle = (art) => {
  if (locale.value === 'hi' && art.title_hi) {
    return art.title_hi;
  }
  return art.title;
};

const getCategory = (art) => {
  if (!art.category) return '';
  if (locale.value === 'hi' && art.category.name_hi) {
    return art.category.name_hi;
  }
  return art.category.name;
};
</script>

<template>
  <div class="bg-white dark:bg-zinc-900/70 p-5 rounded border border-gray-200 dark:border-zinc-800">
    <div class="flex items-center gap-2 pb-3 mb-4 border-b-2 border-gray-900 dark:border-gray-100">
      <Flame class="w-4 h-4 text-[#C8102E]" />
      <h3 class="text-xs font-bold uppercase tracking-widest text-gray-900 dark:text-gray-100">
        {{ $t('home.trending') }}
      </h3>
    </div>

    <div class="divide-y divide-gray-100 dark:divide-zinc-800/80">
      <div
        v-for="(art, idx) in articles"
        :key="art.id"
        class="py-3 flex items-start gap-4 group"
      >
        <!-- Editorial Serif Rank Number -->
        <span class="text-2xl sm:text-3xl font-serif font-black text-gray-300 dark:text-zinc-700 group-hover:text-[#C8102E] transition-colors leading-none w-7 flex-shrink-0">
          {{ String(idx + 1).padStart(2, '0') }}
        </span>

        <div class="flex-1 min-w-0">
          <span
            v-if="getCategory(art)"
            class="text-[10px] font-bold uppercase tracking-wider text-[#C8102E] block mb-0.5"
          >
            {{ getCategory(art) }}
          </span>

          <h4 class="text-xs sm:text-sm font-serif font-bold text-gray-900 dark:text-gray-100 group-hover:text-[#C8102E] transition-colors leading-snug line-clamp-2">
            <Link :href="`/article/${art.slug}`">
              {{ getTitle(art) }}
            </Link>
          </h4>

          <div class="flex items-center gap-2 text-[11px] text-gray-400 mt-1">
            <span class="flex items-center gap-0.5">
              <Clock class="w-3 h-3" />
              {{ art.reading_time || 4 }} {{ $t('home.minRead') }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

