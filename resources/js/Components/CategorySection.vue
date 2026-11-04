<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import SectionHeader from '@/Components/UI/SectionHeader.vue';
import ArticleCard from './ArticleCard.vue';
import FadeUp from '@/Components/UI/FadeUp.vue';

const props = defineProps({
  category: {
    type: Object,
    required: true,
  },
  articles: {
    type: Array,
    default: () => [],
  },
});

const { locale } = useI18n();

const categoryName = computed(() => {
  if (locale.value === 'hi' && props.category.name_hi) {
    return props.category.name_hi;
  }
  return props.category.name;
});

const safeArticles = computed(() => {
  if (Array.isArray(props.articles)) return props.articles;
  if (props.articles && typeof props.articles === 'object') return Object.values(props.articles);
  return [];
});
const primaryArticle = computed(() => safeArticles.value[0] || null);
const secondaryArticles = computed(() => safeArticles.value.slice(1, 4));
</script>

<template>
  <section v-if="articles && articles.length > 0" class="py-6 sm:py-8 border-b border-border">
    <!-- Reusable SectionHeader -->
    <SectionHeader
      :title="categoryName"
      label="REPORTING & DISPATCHES"
      :href="`/category/${category.slug}`"
      :color="category.color || '#C8102E'"
    />

    <!-- Layout: 1 Primary Card (left) + 2/3 Stacked Horizontal Cards (right) -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
      <div v-if="primaryArticle" class="md:col-span-6 lg:col-span-7">
        <FadeUp :duration="500">
          <ArticleCard
            :article="primaryArticle"
            variant="medium"
            :show-image="true"
            :show-excerpt="true"
          />
        </FadeUp>
      </div>

      <div class="md:col-span-6 lg:col-span-5 divide-y divide-border">
        <FadeUp
          v-for="(story, index) in secondaryArticles"
          :key="story.id"
          :delay="index * 80"
        >
          <ArticleCard
            :article="story"
            variant="horizontal"
            :show-image="true"
            :show-excerpt="false"
          />
        </FadeUp>
      </div>
    </div>
  </section>
</template>
