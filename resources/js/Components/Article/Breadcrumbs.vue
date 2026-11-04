<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import { ChevronRight, Home } from 'lucide-vue-next';

const props = defineProps({
  category: {
    type: Object,
    default: null,
  },
  currentTitle: {
    type: String,
    default: '',
  },
});

const { locale } = useI18n();

const categoryName = computed(() => {
  if (!props.category) return '';
  if (locale.value === 'hi' && props.category.name_hi) {
    return props.category.name_hi;
  }
  return props.category.name;
});
</script>

<template>
  <nav class="flex items-center gap-2 text-xs text-gray-500 dark:text-zinc-400 py-3 font-medium overflow-hidden truncate">
    <Link href="/" class="hover:text-[#C8102E] flex items-center gap-1 transition-colors">
      <Home class="w-3.5 h-3.5" />
      <span>{{ $t('nav.home') }}</span>
    </Link>

    <ChevronRight class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" />

    <Link
      v-if="category"
      :href="`/category/${category.slug}`"
      class="hover:text-[#C8102E] font-semibold uppercase tracking-wider text-[11px] transition-colors"
      :style="{ color: category.color || '#C8102E' }"
    >
      {{ categoryName }}
    </Link>

    <ChevronRight v-if="category" class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" />

    <span class="truncate text-gray-800 dark:text-zinc-200 font-serif">
      {{ currentTitle }}
    </span>
  </nav>
</template>

