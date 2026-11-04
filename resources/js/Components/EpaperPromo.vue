<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { FileText, ArrowRight, ExternalLink } from 'lucide-vue-next';

const props = defineProps({
  epaper: {
    type: Object,
    default: null,
  },
});

const { locale } = useI18n();

const title = computed(() => {
  if (!props.epaper) return '';
  if (locale.value === 'hi' && props.epaper.title_hi) {
    return props.epaper.title_hi;
  }
  return props.epaper.title;
});

const formattedDate = computed(() => {
  const d = new Date();
  return d.toLocaleDateString(locale.value === 'hi' ? 'hi-IN' : 'en-US', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });
});
</script>

<template>
  <div class="my-8 p-6 bg-stone-100 dark:bg-zinc-900 rounded-lg border border-stone-200 dark:border-zinc-800 flex flex-col md:flex-row items-center gap-6">
    <!-- Replica Thumbnail -->
    <div class="w-32 sm:w-40 aspect-[3/4] bg-white shadow-md rounded overflow-hidden flex-shrink-0 border border-gray-200 relative group">
      <img
        :src="epaper?.thumbnail_url || 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=400&q=80'"
        alt="E-paper cover"
        class="w-full h-full object-cover"
      />
      <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
        <span class="text-[10px] font-bold text-white uppercase tracking-wider bg-[#C8102E] px-2 py-1 rounded">Preview</span>
      </div>
    </div>

    <!-- Details -->
    <div class="flex-1 text-center md:text-left">
      <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-[#C8102E] mb-1">
        <FileText class="w-3.5 h-3.5" />
        {{ $t('home.epaperTitle') }}
      </div>
      <h3 class="text-xl sm:text-2xl font-serif font-black text-gray-900 dark:text-white leading-tight mb-2">
        {{ title || $t('home.epaperTitle') }}
      </h3>
      <p class="text-xs sm:text-sm text-gray-600 dark:text-zinc-300 font-body mb-4 max-w-xl">
        {{ $t('home.epaperSubtitle') }}
      </p>

      <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-xs text-gray-500 dark:text-zinc-400">
        <span class="font-mono bg-stone-200 dark:bg-zinc-800 px-2.5 py-1 rounded">{{ formattedDate }}</span>
        <span>•</span>
        <span class="font-semibold">{{ epaper?.edition || 'National' }} Edition</span>
        <span>•</span>
        <span>{{ epaper?.pages_count || 16 }} Pages</span>
      </div>
    </div>

    <!-- Action Button -->
    <div class="flex-shrink-0">
      <a
        :href="epaper?.pdf_url || '#'"
        target="_blank"
        rel="noopener noreferrer"
        class="inline-flex items-center gap-2 bg-[#111111] dark:bg-white text-white dark:text-black hover:bg-[#C8102E] dark:hover:bg-[#C8102E] dark:hover:text-white font-bold text-xs uppercase tracking-wider px-6 py-3.5 rounded transition-colors shadow"
      >
        <span>{{ $t('home.readEpaper') }}</span>
        <ExternalLink class="w-4 h-4" />
      </a>
    </div>
  </div>
</template>

