<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import { Radio, ArrowRight } from 'lucide-vue-next';

const props = defineProps({
  liveBlog: {
    type: Object,
    default: null,
  },
});

const { locale } = useI18n();

const title = computed(() => {
  if (!props.liveBlog) return '';
  if (locale.value === 'hi' && props.liveBlog.title_hi) {
    return props.liveBlog.title_hi;
  }
  return props.liveBlog.title;
});

const subtitle = computed(() => {
  if (!props.liveBlog) return '';
  if (locale.value === 'hi' && props.liveBlog.subtitle_hi) {
    return props.liveBlog.subtitle_hi;
  }
  return props.liveBlog.subtitle || props.liveBlog.excerpt;
});

const articleUrl = computed(() => {
  if (!props.liveBlog) return '#';
  return `/article/${props.liveBlog.slug}`;
});
</script>

<template>
  <div
    v-if="liveBlog"
    class="my-6 bg-gradient-to-r from-red-50 via-white to-red-50/30 dark:from-red-950/20 dark:via-zinc-900 dark:to-zinc-900 border border-red-200 dark:border-red-900/40 rounded-lg p-5 sm:p-6 shadow-sm"
  >
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
      <div class="flex items-center gap-3">
        <!-- Pulsing Live Badge -->
        <div class="inline-flex items-center gap-2 bg-[#C8102E] text-white font-black text-xs px-3 py-1 rounded tracking-widest uppercase">
          <span class="relative flex h-2.5 w-2.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-white"></span>
          </span>
          <Radio class="w-3.5 h-3.5" />
          {{ $t('nav.live') }}
        </div>

        <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-zinc-400">
          Continuous Ground Updates
        </span>
      </div>

      <span class="text-xs text-red-600 dark:text-red-400 font-mono font-medium">
        Live deliberation in progress
      </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
      <div class="lg:col-span-8">
        <h3 class="text-xl sm:text-2xl font-serif font-black text-gray-900 dark:text-white leading-tight mb-2 hover:text-[#C8102E] transition-colors">
          <Link :href="articleUrl">
            {{ title }}
          </Link>
        </h3>
        <p class="text-sm text-gray-600 dark:text-zinc-300 font-body line-clamp-2">
          {{ subtitle }}
        </p>
      </div>

      <div class="lg:col-span-4 flex justify-start lg:justify-end">
        <Link
          :href="articleUrl"
          class="inline-flex items-center gap-2 bg-[#C8102E] hover:bg-[#A00D24] text-white text-xs font-bold uppercase tracking-wider px-5 py-3 rounded transition-all shadow hover:shadow-md"
        >
          Follow Live Coverage
          <ArrowRight class="w-4 h-4" />
        </Link>
      </div>
    </div>
  </div>
</template>

