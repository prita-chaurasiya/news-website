<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PortalLayout from '@/Layouts/PortalLayout.vue';
import SectionTitle from '@/Components/Portal/SectionTitle.vue';
import ResponsiveImage from '@/Components/UI/ResponsiveImage.vue';
import { Clock, Flame, Play, ArrowRight } from 'lucide-vue-next';

const props = defineProps({
  leadStory: {
    type: Object,
    default: null,
  },
  secondaryStories: {
    type: Array,
    default: () => [],
  },
  breakingNews: {
    type: Array,
    default: () => [],
  },
  trendingNews: {
    type: Array,
    default: () => [],
  },
  categorySections: {
    type: Array,
    default: () => [],
  },
  opinionStories: {
    type: Array,
    default: () => [],
  },
  videoStories: {
    type: Array,
    default: () => [],
  },
  photoStories: {
    type: Array,
    default: () => [],
  },
});

const featuredStory = computed(() => props.leadStory || props.secondaryStories[0]);
</script>

<template>
  <Head title="द क्रॉनिकल - हिंदी न्यूज़ पोर्टल" />

  <PortalLayout :breaking-news="breakingNews">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-6">

      <!-- ============================================== -->
      <!-- TOP STORY LEAD SHOWCASE                        -->
      <!-- ============================================== -->
      <section v-if="featuredStory" class="mb-6 pb-6 border-b border-[#E5E5E5] dark:border-zinc-800">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6 items-start">
          <!-- Big 16:9 Lead Card -->
          <div class="lg:col-span-8 group">
            <Link :href="`/article/${featuredStory.slug}`" class="block">
              <div class="relative overflow-hidden rounded bg-gray-100 dark:bg-zinc-800 aspect-[16/9] mb-3">
                <ResponsiveImage
                  :src="featuredStory.featured_image"
                  :alt="featuredStory.title_hi || featuredStory.title"
                  :lqip="featuredStory.image_lqip"
                  aspect-ratio="16/9"
                  priority
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                />
                <span
                  v-if="featuredStory.category"
                  class="absolute top-3 left-3 bg-[#D90000] text-white text-[11px] font-bold px-2.5 py-1 rounded shadow-sm"
                >
                  {{ featuredStory.category.name_hi || featuredStory.category.name }}
                </span>
              </div>

              <h1 class="font-hindi text-xl sm:text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white group-hover:text-[#D90000] transition-colors leading-tight">
                {{ featuredStory.title_hi || featuredStory.title }}
              </h1>

              <p class="font-hindi text-sm sm:text-base text-gray-600 dark:text-zinc-300 mt-2 line-clamp-2 leading-relaxed">
                {{ featuredStory.meta_description_hi || featuredStory.meta_description }}
              </p>

              <div class="flex items-center gap-3 text-xs text-gray-400 mt-2.5">
                <span v-if="featuredStory.author" class="font-medium text-gray-700 dark:text-zinc-300">
                  {{ featuredStory.author.name_hi || featuredStory.author.name }}
                </span>
                <span>•</span>
                <span class="flex items-center gap-1">
                  <Clock class="w-3.5 h-3.5" />
                  {{ featuredStory.reading_time || 4 }} मिनट पढ़ें
                </span>
              </div>
            </Link>
          </div>

          <!-- Secondary Side Stories (Dense List) -->
          <div class="lg:col-span-4 space-y-3">
            <SectionTitle title="प्रमुख खबरें" title-hi="बड़ी खबरें" />

            <div
              v-for="(story, idx) in secondaryStories.slice(0, 4)"
              :key="story.id || idx"
              class="flex gap-3 pb-3 border-b border-gray-100 dark:border-zinc-800/80 group"
            >
              <Link :href="`/article/${story.slug}`" class="shrink-0 w-24 h-16 sm:w-28 sm:h-20 rounded overflow-hidden bg-gray-100 dark:bg-zinc-800">
                <ResponsiveImage
                  :src="story.featured_image"
                  :alt="story.title_hi || story.title"
                  aspect-ratio="16/9"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200"
                />
              </Link>

              <div class="flex-1 min-w-0">
                <Link
                  :href="`/article/${story.slug}`"
                  class="font-hindi text-xs sm:text-sm font-bold text-gray-900 dark:text-white group-hover:text-[#D90000] line-clamp-2 leading-snug transition-colors"
                >
                  {{ story.title_hi || story.title }}
                </Link>
                <div class="flex items-center gap-2 text-[11px] text-gray-400 mt-1">
                  <span v-if="story.category" class="text-[#D90000] font-semibold">
                    {{ story.category.name_hi || story.category.name }}
                  </span>
                  <span>•</span>
                  <span>{{ story.reading_time || 3 }} मि.</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Preview Notice for Theme Switch -->
      <div class="p-3 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/40 rounded flex items-center justify-between text-xs text-[#D90000] font-medium">
        <span>✨ <strong>Portal Theme Active:</strong> Dense Hindi TV-News portal layout inspired by AajTak layout patterns, powered by The Chronicle database.</span>
        <a href="?theme=editorial" class="underline font-bold hover:text-[#A00000]">Switch back to Editorial Theme →</a>
      </div>

    </div>
  </PortalLayout>
</template>

