<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import { ChevronLeft, ChevronRight, Zap } from 'lucide-vue-next';

const props = defineProps({
  news: {
    type: Array,
    default: () => [],
  },
  defaultText: {
    type: String,
    default: '',
  },
});

const { locale } = useI18n();
const currentIndex = ref(0);
const isPaused = ref(false);
let timer = null;

const currentItem = computed(() => {
  if (props.news && props.news.length > 0) {
    return props.news[currentIndex.value];
  }
  return null;
});

const displayTitle = computed(() => {
  if (!currentItem.value) {
    return props.defaultText || 'Latest dispatches and breaking coverage from The Chronicle.';
  }
  if (locale.value === 'hi' && currentItem.value.title_hi) {
    return currentItem.value.title_hi;
  }
  return currentItem.value.title;
});

const articleUrl = computed(() => {
  if (currentItem.value?.slug) {
    return `/article/${currentItem.value.slug}`;
  }
  return '#';
});

const nextStory = () => {
  if (props.news.length > 0) {
    currentIndex.value = (currentIndex.value + 1) % props.news.length;
  }
};

const prevStory = () => {
  if (props.news.length > 0) {
    currentIndex.value = (currentIndex.value - 1 + props.news.length) % props.news.length;
  }
};

onMounted(() => {
  timer = setInterval(() => {
    if (!isPaused.value && props.news.length > 1) {
      nextStory();
    }
  }, 5000);
});

onUnmounted(() => {
  if (timer) clearInterval(timer);
});
</script>

<template>
  <div
    class="bg-white dark:bg-zinc-900 border-y border-gray-200 dark:border-zinc-800 text-xs py-2 px-4 flex items-center justify-between overflow-hidden"
    @mouseenter="isPaused = true"
    @mouseleave="isPaused = false"
  >
    <div class="flex items-center gap-3 overflow-hidden flex-1 mr-4">
      <!-- Badge -->
      <div class="flex items-center gap-1.5 bg-[#C8102E] text-white font-bold text-[11px] tracking-wider uppercase px-2.5 py-0.5 rounded-sm flex-shrink-0">
        <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
        <Zap class="w-3 h-3 fill-current" />
        {{ $t('home.breaking') }}
      </div>

      <!-- Ticker Content with Transition -->
      <div class="overflow-hidden truncate flex-1">
        <Transition name="fade" mode="out-in">
          <Link
            :key="currentIndex"
            :href="articleUrl"
            class="font-medium text-gray-900 dark:text-gray-200 hover:text-[#C8102E] transition-colors truncate block"
          >
            {{ displayTitle }}
          </Link>
        </Transition>
      </div>
    </div>

    <!-- Controls -->
    <div v-if="news && news.length > 1" class="flex items-center gap-1 flex-shrink-0 text-gray-400">
      <span class="text-[11px] font-mono mr-1.5 text-gray-500">
        {{ currentIndex + 1 }}/{{ news.length }}
      </span>
      <button
        @click="prevStory"
        class="p-0.5 hover:text-[#C8102E] transition-colors"
        aria-label="Previous story"
      >
        <ChevronLeft class="w-4 h-4" />
      </button>
      <button
        @click="nextStory"
        class="p-0.5 hover:text-[#C8102E] transition-colors"
        aria-label="Next story"
      >
        <ChevronRight class="w-4 h-4" />
      </button>
    </div>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.fade-enter-from {
  opacity: 0;
  transform: translateY(6px);
}

.fade-leave-to {
  opacity: 0;
  transform: translateY(-6px);
}
</style>

