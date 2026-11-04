<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import { Bookmark, Clock, Lock } from 'lucide-vue-next';
import { useNewsStore } from '@/stores/newsStore';
import ResponsiveImage from '@/Components/UI/ResponsiveImage.vue';

const props = defineProps({
  article: {
    type: Object,
    required: true,
  },
  variant: {
    type: String,
    default: 'medium', // 'large', 'medium', 'small', 'horizontal'
  },
  showImage: {
    type: Boolean,
    default: true,
  },
  showExcerpt: {
    type: Boolean,
    default: true,
  },
  priority: {
    type: Boolean,
    default: false,
  },
});

const { locale } = useI18n();
const newsStore = useNewsStore();

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
  return props.article.excerpt || props.article.subtitle;
});

const categoryName = computed(() => {
  if (!props.article.category) return '';
  if (locale.value === 'hi' && props.article.category.name_hi) {
    return props.article.category.name_hi;
  }
  return props.article.category.name;
});

const authorName = computed(() => {
  if (!props.article.author) return 'Editorial Staff';
  if (locale.value === 'hi' && props.article.author.name_hi) {
    return props.article.author.name_hi;
  }
  return props.article.author.name;
});

const imageCaption = computed(() => {
  if (locale.value === 'hi' && props.article.image_caption_hi) {
    return props.article.image_caption_hi;
  }
  return props.article.image_caption || '';
});

const isBookmarked = computed(() => newsStore.isBookmarked(props.article.id));
const articleUrl = computed(() => `/article/${props.article.slug}`);

const timeAgo = computed(() => {
  if (!props.article.published_at) return '';
  const date = new Date(props.article.published_at);
  const now = new Date();
  const diffHours = Math.floor((now - date) / (1000 * 60 * 60));
  
  if (diffHours < 1) {
    const diffMins = Math.max(1, Math.floor((now - date) / (1000 * 60)));
    return locale.value === 'hi' ? `${diffMins} मिनट पहले` : `${diffMins}m ago`;
  }
  if (diffHours < 24) {
    return locale.value === 'hi' ? `${diffHours} घंटे पहले` : `${diffHours}h ago`;
  }
  const diffDays = Math.floor(diffHours / 24);
  return locale.value === 'hi' ? `${diffDays} दिन पहले` : `${diffDays}d ago`;
});
</script>

<template>
  <!-- ============================================== -->
  <!-- 1. HORIZONTAL VARIANT (1:1 square thumbnail)   -->
  <!-- ============================================== -->
  <article
    v-if="variant === 'horizontal'"
    class="group flex gap-4 py-3.5 border-b border-border/80 last:border-b-0 items-center"
  >
    <Link
      v-if="showImage && article.featured_image"
      :href="articleUrl"
      class="w-24 h-24 sm:w-28 sm:h-28 flex-shrink-0"
    >
      <ResponsiveImage
        :src="article.featured_image"
        :alt="title"
        aspect-ratio="1/1"
        :priority="false"
        rounded="rounded-md"
      />
    </Link>

    <div class="flex-1 flex flex-col justify-between min-w-0">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <span
            v-if="categoryName"
            class="text-[11px] font-semibold tracking-wider uppercase text-accent"
          >
            {{ categoryName }}
          </span>
          <span v-if="article.is_premium" class="inline-flex items-center gap-0.5 text-[10px] font-bold text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 px-1.5 py-0.5 rounded">
            <Lock class="w-2.5 h-2.5" />
            PLUS
          </span>
        </div>

        <h3 class="text-sm sm:text-base font-serif font-bold text-ink group-hover:text-accent transition-colors leading-snug line-clamp-2">
          <Link :href="articleUrl">
            {{ title }}
          </Link>
        </h3>
      </div>

      <div class="flex items-center justify-between text-xs text-muted mt-2">
        <div class="flex items-center gap-2 truncate text-[11px]">
          <span class="truncate font-medium">{{ authorName }}</span>
          <span>•</span>
          <span class="flex-shrink-0 flex items-center gap-1">
            <Clock class="w-3 h-3 text-muted" />
            {{ timeAgo }}
          </span>
        </div>

        <button
          @click.prevent="newsStore.toggleBookmark(article.id)"
          class="p-1 text-muted hover:text-accent transition-colors"
          :title="isBookmarked ? 'Remove bookmark' : 'Bookmark article'"
          aria-label="Bookmark"
        >
          <Bookmark class="w-3.5 h-3.5" :class="{ 'fill-[#C8102E] text-accent': isBookmarked }" />
        </button>
      </div>
    </div>
  </article>

  <!-- ============================================== -->
  <!-- 2. LARGE VARIANT (Hero lead: 16:9 aspect)     -->
  <!-- ============================================== -->
  <article
    v-else-if="variant === 'large'"
    class="group flex flex-col"
  >
    <div v-if="showImage && article.featured_image" class="mb-4">
      <Link :href="articleUrl" class="block w-full">
        <ResponsiveImage
          :src="article.featured_image"
          :alt="title"
          aspect-ratio="16/9"
          :priority="priority"
          :overlay="true"
          :caption="imageCaption"
          rounded="rounded-lg"
        />
      </Link>
    </div>

    <div class="flex items-center gap-2 mb-2">
      <span
        v-if="categoryName"
        class="text-xs font-bold tracking-widest uppercase text-accent font-mono"
      >
        {{ categoryName }}
      </span>
      <span v-if="article.is_premium" class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 px-2 py-0.5 rounded">
        <Lock class="w-3 h-3" />
        SUBSCRIBER EXCLUSIVE
      </span>
    </div>

    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-black text-ink group-hover:text-accent transition-colors leading-[1.18] mb-3">
      <Link :href="articleUrl">
        {{ title }}
      </Link>
    </h2>

    <p
      v-if="showExcerpt && excerpt"
      class="text-sm sm:text-base text-muted leading-relaxed mb-4 line-clamp-3 font-editorial"
    >
      {{ excerpt }}
    </p>

    <div class="flex items-center justify-between text-xs text-muted pt-3 border-t border-border/80">
      <div class="flex items-center gap-3">
        <!-- Author photo circle with thin red ring -->
        <img
          v-if="article.author?.avatar"
          :src="article.author.avatar"
          :alt="authorName"
          class="w-8 h-8 rounded-full object-cover ring-2 ring-accent/80"
        />
        <div class="flex flex-col">
          <span class="font-semibold text-ink">{{ authorName }}</span>
          <span class="text-[11px] text-muted">{{ timeAgo }} • {{ article.reading_time || 4 }} {{ $t('home.minRead') }}</span>
        </div>
      </div>

      <button
        @click.prevent="newsStore.toggleBookmark(article.id)"
        class="p-1.5 rounded-full hover:bg-surface text-muted hover:text-accent transition-colors"
        :title="isBookmarked ? 'Remove bookmark' : 'Bookmark article'"
        aria-label="Bookmark"
      >
        <Bookmark class="w-4 h-4" :class="{ 'fill-[#C8102E] text-accent': isBookmarked }" />
      </button>
    </div>
  </article>

  <!-- ============================================== -->
  <!-- 3. SMALL VARIANT (Minimal text only / compact)-->
  <!-- ============================================== -->
  <article
    v-else-if="variant === 'small'"
    class="group py-3 border-b border-border/80 last:border-b-0"
  >
    <div class="flex items-center gap-2 mb-1.5">
      <span
        v-if="categoryName"
        class="text-[10px] font-bold tracking-wider uppercase text-accent font-mono"
      >
        {{ categoryName }}
      </span>
      <span class="text-[11px] text-muted">{{ timeAgo }}</span>
    </div>

    <h4 class="text-sm font-serif font-bold text-ink group-hover:text-accent transition-colors leading-snug line-clamp-2">
      <Link :href="articleUrl">
        {{ title }}
      </Link>
    </h4>
  </article>

  <!-- ============================================== -->
  <!-- 4. MEDIUM VARIANT (Default card: 3:2 aspect)   -->
  <!-- ============================================== -->
  <article
    v-else
    class="group flex flex-col h-full bg-paper rounded border border-border overflow-hidden hover:shadow-editorial-hover transition-all duration-300"
  >
    <Link
      v-if="showImage && article.featured_image"
      :href="articleUrl"
      class="w-full block"
    >
      <ResponsiveImage
        :src="article.featured_image"
        :alt="title"
        aspect-ratio="3/2"
        :priority="false"
        rounded="rounded-none"
      />
    </Link>

    <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between">
      <div>
        <div class="flex items-center justify-between gap-2 mb-2">
          <span
            v-if="categoryName"
            class="text-[11px] font-bold tracking-wider uppercase text-accent font-mono"
          >
            {{ categoryName }}
          </span>
          <span v-if="article.is_premium" class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 px-1.5 py-0.5 rounded">
            <Lock class="w-2.5 h-2.5" />
            PLUS
          </span>
        </div>

        <h3 class="text-base sm:text-lg font-serif font-bold text-ink group-hover:text-accent transition-colors leading-snug mb-2 line-clamp-2">
          <Link :href="articleUrl">
            {{ title }}
          </Link>
        </h3>

        <p
          v-if="showExcerpt && excerpt"
          class="text-xs sm:text-sm text-muted line-clamp-2 mb-3 font-editorial leading-relaxed"
        >
          {{ excerpt }}
        </p>
      </div>

      <div class="flex items-center justify-between text-xs text-muted pt-3 border-t border-border mt-auto">
        <span class="truncate max-w-[140px] font-medium">{{ authorName }}</span>
        
        <div class="flex items-center gap-2">
          <span>{{ timeAgo }}</span>
          <button
            @click.prevent="newsStore.toggleBookmark(article.id)"
            class="p-1 hover:text-accent transition-colors"
            :title="isBookmarked ? 'Remove bookmark' : 'Bookmark article'"
            aria-label="Bookmark"
          >
            <Bookmark class="w-3.5 h-3.5" :class="{ 'fill-[#C8102E] text-accent': isBookmarked }" />
          </button>
        </div>
      </div>
    </div>
  </article>
</template>
