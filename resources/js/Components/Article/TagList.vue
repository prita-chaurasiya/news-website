<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import { Tag as TagIcon } from 'lucide-vue-next';

const props = defineProps({
  tags: {
    type: Array,
    default: () => [],
  },
});

const { locale } = useI18n();

const getTagName = (t) => {
  if (locale.value === 'hi' && t.name_hi) {
    return t.name_hi;
  }
  return t.name;
};
</script>

<template>
  <div v-if="tags && tags.length > 0" class="my-6 pt-4 border-t border-gray-100 dark:border-zinc-800">
    <div class="flex items-center gap-2 mb-3 text-xs font-bold uppercase tracking-wider text-gray-400">
      <TagIcon class="w-3.5 h-3.5 text-[#C8102E]" />
      <span>{{ $t('article.tags') }}</span>
    </div>

    <div class="flex flex-wrap gap-2">
      <Link
        v-for="t in tags"
        :key="t.slug"
        :href="`/tag/${t.slug}`"
        class="text-xs bg-gray-100 dark:bg-zinc-800 hover:bg-[#C8102E] hover:text-white dark:hover:bg-[#C8102E] dark:hover:text-white text-gray-700 dark:text-zinc-300 px-3 py-1.5 rounded-full transition-colors font-medium"
      >
        #{{ getTagName(t) }}
      </Link>
    </div>
  </div>
</template>

