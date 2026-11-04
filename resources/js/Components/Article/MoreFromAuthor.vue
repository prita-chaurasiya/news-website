<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import ArticleCard from '@/Components/ArticleCard.vue';

const props = defineProps({
  author: {
    type: Object,
    required: true,
  },
  articles: {
    type: Array,
    default: () => [],
  },
});

const { locale } = useI18n();

const authorName = computed(() => {
  if (locale.value === 'hi' && props.author.name_hi) {
    return props.author.name_hi;
  }
  return props.author.name;
});
</script>

<template>
  <section v-if="articles && articles.length > 0" class="my-10 p-6 bg-gray-50 dark:bg-zinc-900/60 rounded-lg border border-gray-200 dark:border-zinc-800">
    <div class="flex items-center justify-between pb-3 mb-6 border-b border-gray-200 dark:border-zinc-800">
      <h3 class="text-xs font-bold uppercase tracking-widest text-gray-900 dark:text-gray-100">
        {{ $t('article.moreFromAuthor') }}: <span class="text-[#C8102E]">{{ authorName }}</span>
      </h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <ArticleCard
        v-for="art in articles"
        :key="art.id"
        :article="art"
        variant="medium"
        :show-image="true"
        :show-excerpt="false"
      />
    </div>
  </section>
</template>

