<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import ResponsiveImage from '@/Components/UI/ResponsiveImage.vue';
import { ArrowRight, Clock, X, Sparkles } from 'lucide-vue-next';

const props = defineProps({
  article: {
    type: Object,
    required: true,
  },
  category: {
    type: Object,
    default: null,
  },
});

const { locale } = useI18n();
const isFloatingVisible = ref(false);
const isDismissed = ref(false);

const title = computed(() => {
  if (locale.value === 'hi' && props.article.title_hi) {
    return props.article.title_hi;
  }
  return props.article.title;
});

const excerpt = computed(() => {
  if (locale.value === 'hi' && props.article.excerpt_hi) {
    return props.article.excerpt_hi;
  }
  return props.article.excerpt || props.article.subtitle || '';
});

const categoryName = computed(() => {
  const cat = props.category || props.article.category;
  if (!cat) return 'Top Coverage';
  if (locale.value === 'hi' && cat.name_hi) {
    return cat.name_hi;
  }
  return cat.name;
});

const articleUrl = computed(() => {
  return locale.value === 'hi'
    ? `/hi/article/${props.article.slug}`
    : `/article/${props.article.slug}`;
});

const checkScroll = () => {
  if (isDismissed.value) return;
  const scrollTop = window.scrollY || document.documentElement.scrollTop;
  const docHeight = document.documentElement.scrollHeight - window.innerHeight;
  if (docHeight > 0) {
    const ratio = scrollTop / docHeight;
    isFloatingVisible.value = ratio > 0.65;
  }
};

onMounted(() => {
  window.addEventListener('scroll', checkScroll, { passive: true });
  checkScroll();
});

onUnmounted(() => {
  window.removeEventListener('scroll', checkScroll);
});
</script>

<template>
  <div v-if="article">
    <!-- 1. Inline Prominent Broadsheet "Read Next" Recommendation Card -->
    <div class="my-10 p-6 sm:p-8 bg-surface dark:bg-zinc-900/90 rounded-xl border-2 border-border dark:border-zinc-800 shadow-sm relative overflow-hidden group">
      <!-- Top Eyebrow -->
      <div class="flex items-center justify-between gap-4 mb-4 pb-3 border-b border-border/80">
        <div class="flex items-center gap-2">
          <span class="w-2.5 h-2.5 rounded-sm bg-[#C8102E]"></span>
          <span class="text-xs font-bold uppercase tracking-widest text-[#C8102E] font-mono">
            Read Next in {{ categoryName }}
          </span>
        </div>
        <span class="text-[11px] text-muted font-mono uppercase tracking-wider flex items-center gap-1">
          <Clock class="w-3.5 h-3.5" />
          {{ article.reading_time || 4 }} min read
        </span>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-12 gap-6 items-center">
        <!-- 16:9 Image -->
        <div class="sm:col-span-5">
          <Link :href="articleUrl" class="block overflow-hidden rounded-lg aspect-[16/9] shadow-sm">
            <ResponsiveImage
              :src="article.featured_image || 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=800&q=80'"
              :alt="title"
              aspect-ratio="16/9"
              rounded="rounded-lg"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            />
          </Link>
        </div>

        <!-- Details -->
        <div class="sm:col-span-7 flex flex-col justify-between">
          <div>
            <h3 class="text-xl sm:text-2xl font-serif font-black text-ink dark:text-white group-hover:text-accent transition-colors leading-snug mb-2">
              <Link :href="articleUrl">
                {{ title }}
              </Link>
            </h3>

            <p v-if="excerpt" class="text-xs sm:text-sm text-gray-600 dark:text-zinc-300 font-serif line-clamp-2 leading-relaxed mb-4">
              {{ excerpt }}
            </p>
          </div>

          <div class="flex items-center justify-between pt-2">
            <span class="text-xs text-muted font-sans font-medium">
              By <strong class="text-ink dark:text-zinc-200">{{ article.author?.name || 'Staff Correspondent' }}</strong>
            </span>

            <Link
              :href="articleUrl"
              class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-accent hover:text-[#A00D24] transition-colors"
            >
              <span>Continue Reading</span>
              <ArrowRight class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" />
            </Link>
          </div>
        </div>
      </div>
    </div>

    <!-- 2. Desktop Floating "Read Next" Pill in Bottom Right -->
    <transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0 translate-y-6 scale-95"
      enter-to-class="opacity-100 translate-y-0 scale-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100 translate-y-0 scale-100"
      leave-to-class="opacity-0 translate-y-6 scale-95"
    >
      <div
        v-if="isFloatingVisible && !isDismissed"
        class="hidden xl:flex fixed bottom-6 right-6 z-40 max-w-sm bg-white dark:bg-zinc-900 border border-border dark:border-zinc-800 rounded-xl shadow-2xl p-3.5 items-center gap-3 animate-in"
      >
        <button
          @click="isDismissed = true"
          class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-zinc-200 dark:bg-zinc-800 hover:bg-red-500 hover:text-white flex items-center justify-center text-xs text-gray-600 dark:text-zinc-300 transition-colors shadow"
          title="Dismiss recommendation"
        >
          <X class="w-3 h-3" />
        </button>

        <img
          :src="article.featured_image || 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=150&q=80'"
          :alt="title"
          class="w-14 h-14 rounded-lg object-cover flex-shrink-0"
        />

        <div class="min-w-0 flex-1">
          <div class="text-[10px] font-bold uppercase tracking-wider text-accent mb-0.5">
            Read Next in {{ categoryName }}
          </div>
          <Link
            :href="articleUrl"
            class="block text-xs font-serif font-black text-ink dark:text-white hover:text-accent truncate leading-tight mb-1"
          >
            {{ title }}
          </Link>
          <Link
            :href="articleUrl"
            class="inline-flex items-center gap-1 text-[11px] font-bold text-accent hover:underline"
          >
            <span>Jump to Story</span>
            <ArrowRight class="w-3 h-3" />
          </Link>
        </div>
      </div>
    </transition>
  </div>
</template>
