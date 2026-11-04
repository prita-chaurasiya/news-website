<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import ArticleCard from '@/Components/ArticleCard.vue';

defineProps({
  articles: {
    type: Array,
    default: () => [],
  },
});
</script>

<template>
  <section v-if="articles && articles.length > 0" class="my-10 pt-8 border-t-2 border-gray-900 dark:border-gray-100">
    <div class="flex items-center justify-between pb-3 mb-6 border-b border-gray-100 dark:border-zinc-800">
      <h3 class="text-xs font-bold uppercase tracking-widest text-gray-900 dark:text-gray-100">
        {{ $t('article.related') }}
      </h3>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
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

