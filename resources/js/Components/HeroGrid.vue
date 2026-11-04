<script setup>
import ArticleCard from './ArticleCard.vue';
import FadeUp from '@/Components/UI/FadeUp.vue';

defineProps({
  leadStory: {
    type: Object,
    default: null,
  },
  secondaryStories: {
    type: Array,
    default: () => [],
  },
});
</script>

<template>
  <section class="py-6 sm:py-8 border-b border-border">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:divide-x lg:divide-border">
      <!-- LEAD STORY (Large Column - 7 to 8 cols) with drop-in animation -->
      <div v-if="leadStory" class="lg:col-span-7 xl:col-span-8 lg:pr-6">
        <FadeUp :duration="700">
          <ArticleCard
            :article="leadStory"
            variant="large"
            :show-image="true"
            :show-excerpt="true"
            :priority="true"
          />

          <!-- Axios-Style Key Takeaways Preview for the Lead Story -->
          <div
            v-if="Array.isArray(leadStory.localized_key_takeaways) && leadStory.localized_key_takeaways.length"
            class="mt-6 p-4 sm:p-5 bg-surface border-l-4 border-accent rounded-r text-sm border-y border-r border-border/60"
          >
            <div class="flex items-center gap-2 font-bold uppercase tracking-wider text-xs text-accent mb-2.5 font-mono">
              <span class="w-2 h-2 rounded-full bg-accent"></span>
              {{ $t('home.keyTakeaways') }} • {{ $t('article.smartBrevity') }}
            </div>
            <ul class="space-y-2 text-ink font-editorial text-xs sm:text-sm">
              <li
                v-for="(point, idx) in leadStory.localized_key_takeaways.slice(0, 3)"
                :key="idx"
                class="flex items-start gap-2.5"
              >
                <span class="text-accent font-bold leading-tight">•</span>
                <span class="leading-relaxed">{{ point }}</span>
              </li>
            </ul>
          </div>
        </FadeUp>
      </div>

      <!-- SECONDARY STORIES (Sidebar Grid - 4 to 5 cols) -->
      <div class="lg:col-span-5 xl:col-span-4 lg:pl-6 space-y-2">
        <div class="flex items-center justify-between pb-2 mb-3 border-b-2 border-ink">
          <h3 class="text-xs font-bold uppercase tracking-widest text-ink font-mono">
            {{ $t('home.topStories') }}
          </h3>
          <span class="text-[10px] text-muted uppercase font-mono tracking-wider">Fast Read</span>
        </div>

        <div class="divide-y divide-border/80">
          <FadeUp
            v-for="(story, index) in secondaryStories"
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
    </div>
  </section>
</template>
