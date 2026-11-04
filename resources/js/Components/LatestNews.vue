<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import axios from 'axios';
import ArticleCard from './ArticleCard.vue';
import SectionHeader from '@/Components/UI/SectionHeader.vue';
import SkeletonLoader from './SkeletonLoader.vue';
import { Loader2 } from 'lucide-vue-next';

const props = defineProps({
  initialNews: {
    type: Array,
    default: () => [],
  },
  hasMore: {
    type: Boolean,
    default: true,
  },
  currentPage: {
    type: Number,
    default: 1,
  },
});

const { t } = useI18n();
const articles = ref([...props.initialNews]);
const page = ref(props.currentPage);
const canLoadMore = ref(props.hasMore);
const isLoading = ref(false);

const loadMore = async () => {
  if (isLoading.value || !canLoadMore.value) return;

  isLoading.value = true;
  const nextPage = page.value + 1;

  try {
    const response = await axios.get(`/?page=${nextPage}`, {
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
    });

    if (response.data && response.data.latestNews) {
      articles.value.push(...response.data.latestNews);
      canLoadMore.value = response.data.hasMoreLatest;
      page.value = response.data.currentPage;
    }
  } catch (error) {
    console.error('Error loading more latest articles:', error);
  } finally {
    isLoading.value = false;
  }
};
</script>

<template>
  <div class="py-6 sm:py-8 border-b border-border">
    <SectionHeader
      :title="$t('home.latestNews')"
      label="CHRONOLOGICAL FEED"
    />

    <div class="divide-y divide-border/80">
      <ArticleCard
        v-for="story in articles"
        :key="story.id"
        :article="story"
        variant="horizontal"
        :show-image="true"
        :show-excerpt="true"
      />
    </div>

    <!-- Skeleton when loading -->
    <div v-if="isLoading" class="space-y-4 pt-4">
      <SkeletonLoader type="horizontal" />
      <SkeletonLoader type="horizontal" />
    </div>

    <!-- Load More Button -->
    <div class="mt-8 text-center">
      <button
        v-if="canLoadMore"
        @click="loadMore"
        :disabled="isLoading"
        class="inline-flex items-center gap-2 border border-gray-900 dark:border-gray-100 hover:bg-gray-900 hover:text-white dark:hover:bg-white dark:hover:text-black font-semibold text-xs tracking-wider uppercase px-8 py-3.5 rounded transition-all duration-200 disabled:opacity-50"
      >
        <Loader2 v-if="isLoading" class="w-4 h-4 animate-spin" />
        <span>{{ isLoading ? $t('home.loadingMore') : $t('home.loadMore') }}</span>
      </button>

      <p v-else class="text-xs text-gray-400 italic py-3">
        {{ $t('home.noMoreStories') }}
      </p>
    </div>
  </div>
</template>

