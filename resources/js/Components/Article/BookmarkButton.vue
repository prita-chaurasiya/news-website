<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { Bookmark } from 'lucide-vue-next';
import { useNewsStore } from '@/stores/newsStore';

const props = defineProps({
  articleId: {
    type: Number,
    required: true,
  },
});

const { t } = useI18n();
const page = usePage();
const newsStore = useNewsStore();

const isSaved = computed(() => newsStore.isBookmarked(props.articleId));

const handleToggle = async () => {
  newsStore.toggleBookmark(props.articleId);

  // If user is authenticated, also sync with database
  if (page.props.auth?.user) {
    try {
      await axios.post(`/article/${props.articleId}/bookmark`);
    } catch (err) {
      console.error('Failed to sync bookmark with server:', err);
    }
  }
};
</script>

<template>
  <button
    @click="handleToggle"
    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-xs font-semibold transition-all"
    :class="isSaved
      ? 'bg-red-50 dark:bg-red-950/40 border-[#C8102E] text-[#C8102E]'
      : 'bg-gray-100 dark:bg-zinc-800 border-gray-200 dark:border-zinc-700 text-gray-700 dark:text-zinc-300 hover:border-[#C8102E] hover:text-[#C8102E]'"
    :title="isSaved ? $t('article.saved') : $t('article.save')"
  >
    <Bookmark class="w-3.5 h-3.5" :class="{ 'fill-[#C8102E]': isSaved }" />
    <span>{{ isSaved ? $t('article.saved') : $t('article.save') }}</span>
  </button>
</template>

