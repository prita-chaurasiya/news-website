<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import MainLayout from '@/Layouts/MainLayout.vue';
import ReadingProgress from '@/Components/Article/ReadingProgress.vue';
import Breadcrumbs from '@/Components/Article/Breadcrumbs.vue';
import KeyTakeaways from '@/Components/Article/KeyTakeaways.vue';
import FloatingShareBar from '@/Components/Article/FloatingShareBar.vue';
import ReadNextSuggestion from '@/Components/Article/ReadNextSuggestion.vue';
import AuthorBox from '@/Components/Article/AuthorBox.vue';
import TagList from '@/Components/Article/TagList.vue';
import RelatedArticles from '@/Components/Article/RelatedArticles.vue';
import MoreFromAuthor from '@/Components/Article/MoreFromAuthor.vue';
import CommentsSection from '@/Components/Article/CommentsSection.vue';
import PaywallModal from '@/Components/Article/PaywallModal.vue';
import ResponsiveImage from '@/Components/UI/ResponsiveImage.vue';
import { useNewsStore } from '@/stores/newsStore';
import { Clock, Lock, Sparkles } from 'lucide-vue-next';

const props = defineProps({
  article: {
    type: Object,
    required: true,
  },
  relatedArticles: {
    type: Array,
    default: () => [],
  },
  moreFromAuthor: {
    type: Array,
    default: () => [],
  },
  isBookmarked: {
    type: Boolean,
    default: false,
  },
  canonicalUrl: {
    type: String,
    default: '',
  },
});

const { locale } = useI18n();
const newsStore = useNewsStore();

const isPaywallOpen = ref(false);

const title = computed(() => {
  if (locale.value === 'hi' && props.article.title_hi) {
    return props.article.title_hi;
  }
  return props.article.title;
});

const subtitle = computed(() => {
  if (locale.value === 'hi' && props.article.subtitle_hi) {
    return props.article.subtitle_hi;
  }
  return props.article.subtitle || props.article.excerpt;
});

const excerpt = computed(() => {
  if (locale.value === 'hi' && props.article.excerpt_hi) {
    return props.article.excerpt_hi;
  }
  return props.article.excerpt || props.article.subtitle;
});

const content = computed(() => {
  if (locale.value === 'hi' && props.article.content_hi) {
    return props.article.content_hi;
  }
  return props.article.content;
});

const caption = computed(() => {
  if (locale.value === 'hi' && props.article.image_caption_hi) {
    return props.article.image_caption_hi;
  }
  return props.article.image_caption || 'Special investigative dispatch.';
});

const photoCredit = computed(() => {
  return props.article.image_credit || 'Photo: Unsplash';
});

const authorName = computed(() => {
  if (!props.article.author) return 'Editorial Staff';
  if (locale.value === 'hi' && props.article.author.name_hi) {
    return props.article.author.name_hi;
  }
  return props.article.author.name;
});

const formattedDate = computed(() => {
  if (!props.article.published_at) return '';
  const d = new Date(props.article.published_at);
  return d.toLocaleDateString(locale.value === 'hi' ? 'hi-IN' : 'en-US', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });
});

// Paywall metered state
const isPaywallActive = computed(() => {
  return props.article.is_premium || newsStore.readArticlesCount > 3;
});

// JSON-LD Structured Data Schema for NewsArticle
const jsonLdData = computed(() => {
  return JSON.stringify({
    '@context': 'https://schema.org',
    '@type': 'NewsArticle',
    'headline': title.value,
    'image': [props.article.featured_image || 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167'],
    'datePublished': props.article.published_at,
    'dateModified': props.article.updated_at,
    'author': [
      {
        '@type': 'Person',
        'name': authorName.value,
        'jobTitle': props.article.author?.role_title || 'Journalist',
      },
    ],
    'publisher': {
      '@type': 'Organization',
      'name': 'The Chronicle',
      'logo': {
        '@type': 'ImageObject',
        'url': 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167',
      },
    },
    'description': excerpt.value,
    'mainEntityOfPage': {
      '@type': 'WebPage',
      '@id': props.canonicalUrl,
    },
  });
});

onMounted(() => {
  // Metered reading logic: record article read in localStorage
  newsStore.recordArticleRead(props.article.id);

  // If article is premium or reader has exceeded 3 free articles, prompt modal
  if (isPaywallActive.value) {
    setTimeout(() => {
      isPaywallOpen.value = true;
    }, 1800);
  }
});
</script>

<template>
  <MainLayout>
    <!-- Dynamic SEO and Social Meta Tags -->
    <Head>
      <title>{{ title }} — THE CHRONICLE</title>
      <meta name="description" :content="excerpt" />
      <link rel="canonical" :href="canonicalUrl" />

      <!-- Open Graph / Facebook -->
      <meta property="og:type" content="article" />
      <meta property="og:title" :content="title" />
      <meta property="og:description" :content="excerpt" />
      <meta property="og:image" :content="article.featured_image" />
      <meta property="og:url" :content="canonicalUrl" />

      <!-- Twitter Cards -->
      <meta name="twitter:card" content="summary_large_image" />
      <meta name="twitter:title" :content="title" />
      <meta name="twitter:description" :content="excerpt" />
      <meta name="twitter:image" :content="article.featured_image" />

      <!-- NewsArticle Structured Data (JSON-LD) -->
      <component is="script" type="application/ld+json">
        {{ jsonLdData }}
      </component>
    </Head>

    <!-- 1. Fixed Red Reading Progress Bar at the Very Top -->
    <ReadingProgress />

    <article class="w-full pb-16">
      <!-- ============================================== -->
      <!-- 2. ARTICLE MASTHEAD & HEADER (ABOVE THE FOLD)  -->
      <!-- ============================================== -->
      <header class="max-w-4xl mx-auto px-4 sm:px-6 pt-4 sm:pt-6">
        <!-- Breadcrumbs -->
        <Breadcrumbs
          :category="article.category"
          :current-title="title"
        />

        <div class="my-4 sm:my-6">
          <!-- Category & Premium Pill -->
          <div class="flex items-center gap-2.5 mb-3">
            <Link
              v-if="article.category"
              :href="locale === 'hi' ? `/hi/category/${article.category.slug}` : `/category/${article.category.slug}`"
              class="text-xs font-bold uppercase tracking-widest text-[#C8102E] hover:underline font-mono"
            >
              {{ locale === 'hi' && article.category.name_hi ? article.category.name_hi : article.category.name }}
            </Link>
            <span v-if="article.is_premium" class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 px-2 py-0.5 rounded font-mono">
              <Lock class="w-3 h-3" />
              SUBSCRIBER EXCLUSIVE
            </span>
          </div>

          <!-- Headline (Playfair Display) -->
          <h1 class="text-3xl sm:text-5xl lg:text-6xl font-serif font-black text-ink dark:text-white leading-[1.12] tracking-tight mb-4">
            {{ title }}
          </h1>

          <!-- Subheadline / Excerpt -->
          <p v-if="subtitle" class="text-lg sm:text-2xl text-gray-600 dark:text-zinc-300 font-serif leading-relaxed mb-6 font-normal">
            {{ subtitle }}
          </p>

          <!-- Byline, Date & Reading Time Utility Bar -->
          <div class="py-4 border-y border-border flex flex-wrap items-center justify-between gap-4">
            <!-- Author Info -->
            <div class="flex items-center gap-3">
              <Link
                v-if="article.author?.slug"
                :href="`/author/${article.author.slug}`"
                class="group flex-shrink-0"
              >
                <img
                  v-if="article.author?.avatar"
                  :src="article.author.avatar"
                  :alt="authorName"
                  class="w-11 h-11 rounded-full object-cover ring-2 ring-[#C8102E] shadow-none transition-transform group-hover:scale-105"
                />
              </Link>
              <div>
                <div class="text-sm font-bold text-ink dark:text-white">
                  <Link
                    v-if="article.author?.slug"
                    :href="`/author/${article.author.slug}`"
                    class="hover:text-accent transition-colors"
                  >
                    {{ authorName }}
                  </Link>
                  <span v-else>{{ authorName }}</span>
                </div>
                <div class="text-xs text-muted flex items-center gap-2 font-sans">
                  <span>{{ formattedDate }}</span>
                  <span>•</span>
                  <span class="flex items-center gap-1 font-mono">
                    <Clock class="w-3 h-3" />
                    {{ article.reading_time || 5 }} {{ $t('article.minRead') }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Edition Pip -->
            <div class="hidden sm:flex items-center gap-2 text-xs font-mono text-muted uppercase tracking-wider">
              <span>National Bureau Dispatch</span>
            </div>
          </div>
        </div>
      </header>

      <!-- ============================================== -->
      <!-- 3. FULL-WIDTH HERO IMAGE (21:9 desktop, 16:9 mobile) -->
      <!-- With Dynamic Photo Credit & Shadow-free Caption Bar -->
      <!-- ============================================== -->
      <figure v-if="article.featured_image" class="max-w-5xl xl:max-w-6xl mx-auto px-4 sm:px-6 my-6 sm:my-8">
        <ResponsiveImage
          :src="article.featured_image"
          :alt="title"
          aspect-ratio="21/9"
          :priority="true"
          rounded="rounded-xl"
          class="w-full shadow-none"
        >
          <template #caption>
            <div class="w-full flex flex-col sm:flex-row sm:items-center justify-between gap-2 pt-2.5 border-l-2 border-[#C8102E] pl-3 italic font-sans text-xs text-muted shadow-none">
              <span>{{ caption }}</span>
              <span class="not-italic font-sans text-[12px] font-medium uppercase tracking-wider text-muted flex-shrink-0">
                {{ photoCredit }}
              </span>
            </div>
          </template>
        </ResponsiveImage>
      </figure>

      <!-- ============================================== -->
      <!-- 4. 3-COLUMN EDITORIAL GRID (64px | 720px | 1fr)-->
      <!-- Desktop: 64px floating share bar sticky top-96,-->
      <!-- Centered 720px column, 1fr balance column.     -->
      <!-- Mobile: Bottom fixed action bar.               -->
      <!-- ============================================== -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 my-8">
        <div class="grid grid-cols-1 lg:grid-cols-[64px_720px_1fr] gap-8 xl:gap-12 items-start justify-center">
          <!-- Column 1: Desktop Floating Share Bar (64px, Sticky top 96px, hidden below 1024px) -->
          <div class="hidden lg:flex justify-center sticky top-[96px] z-20">
            <FloatingShareBar
              :article-id="article.id"
              :title="title"
              :content="content"
              :url="canonicalUrl"
              layout="desktop"
            />
          </div>

          <!-- Column 2: Centered 720px Reading Column -->
          <main class="w-full max-w-[720px] min-w-0 mx-auto">
            <!-- Key Takeaways Card with Left Red Border -->
            <KeyTakeaways :takeaways="article.key_takeaways" />

            <!-- Main Article Editorial Body (Source Serif 4, 20px, 1.75 / Hindi 1.9, Drop Cap) -->
            <div class="relative my-8">
              <div
                class="prose-editorial space-y-6 text-[#262626] dark:text-[#D4D4D8]"
                :class="[
                  locale === 'hi' ? 'is-hindi' : 'is-en',
                  { 'max-h-[520px] overflow-hidden select-none': isPaywallActive }
                ]"
                :style="{
                  fontSize: `${(20 * newsStore.fontSizeScale).toFixed(1)}px`,
                  lineHeight: locale === 'hi' ? '1.9' : '1.75'
                }"
                v-html="content"
              ></div>

              <!-- Blurred Fade at Bottom if Paywall is Triggered -->
              <div
                v-if="isPaywallActive"
                class="absolute bottom-0 inset-x-0 h-80 bg-gradient-to-t from-[#FAF8F5] via-[#FAF8F5]/95 to-transparent dark:from-[#0B0F19] dark:via-[#0B0F19]/95 flex flex-col items-center justify-end pb-8 z-20"
              >
                <div class="text-center p-6 bg-white/95 dark:bg-zinc-900/95 backdrop-blur-md rounded-2xl border border-border dark:border-zinc-800 shadow-2xl max-w-md mx-auto">
                  <div class="w-10 h-10 rounded-full bg-red-50 dark:bg-red-950/60 text-[#C8102E] flex items-center justify-center mx-auto mb-3">
                    <Lock class="w-5 h-5" />
                  </div>
                  <h3 class="font-serif font-black text-xl text-ink dark:text-white mb-1.5">
                    Read the Full Investigation
                  </h3>
                  <p class="text-xs text-muted font-sans mb-5 leading-relaxed">
                    You have read your monthly allocation of 3 free articles. Subscribe to fund fearless, grounded reporting across the globe.
                  </p>
                  <button
                    @click="isPaywallOpen = true"
                    type="button"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#C8102E] hover:bg-[#A00D24] text-white font-bold text-xs uppercase tracking-wider shadow-none transition-transform hover:scale-105"
                  >
                    <span>Explore All-Access Plans</span>
                    <Sparkles class="w-4 h-4" />
                  </button>
                </div>
              </div>
            </div>

            <!-- Tag List -->
            <TagList :tags="article.tags" />

            <!-- Author Box Card with Photo, Bio & Follow Button -->
            <AuthorBox
              v-if="article.author"
              :author="article.author"
            />

            <!-- Prominent "Read Next" Recommendation Box -->
            <ReadNextSuggestion
              v-if="relatedArticles && relatedArticles.length > 0"
              :article="relatedArticles[0]"
              :category="article.category"
            />

            <!-- More From Author -->
            <MoreFromAuthor
              v-if="article.author && moreFromAuthor.length > 0"
              :author="article.author"
              :articles="moreFromAuthor"
            />

            <!-- Related Stories as Image Cards -->
            <RelatedArticles
              v-if="relatedArticles.length > 0"
              :articles="relatedArticles"
            />

            <!-- Comments Section (Post, Reply, Like) -->
            <CommentsSection
              :article-id="article.id"
              :comments="article.approved_comments || []"
            />
          </main>

          <!-- Column 3: 1fr Spacer / Balance Column (Desktop only) -->
          <aside aria-hidden="true" class="hidden lg:block min-w-0">
            <!-- Balances the 3-column layout so the 720px reading column is placed correctly -->
          </aside>
        </div>
      </div>

      <!-- Mobile Fixed Bottom Action Bar (hidden on desktop lg:hidden) -->
      <FloatingShareBar
        :article-id="article.id"
        :title="title"
        :content="content"
        :url="canonicalUrl"
        layout="mobile"
      />
    </article>

    <!-- Metered Paywall Subscription Modal -->
    <PaywallModal
      :is-open="isPaywallOpen"
      :read-count="newsStore.readArticlesCount"
      @close="isPaywallOpen = false"
      @subscribed="isPaywallOpen = false"
    />
  </MainLayout>
</template>

<style>
/* ========================================================= */
/* PREMIUM BROADSHEET ARTICLE TYPOGRAPHY STYLES              */
/* ========================================================= */

.prose-editorial {
  font-family: 'Source Serif 4', 'Source Serif Pro', Georgia, serif;
  font-size: 20px;
  line-height: 1.75;
}

.prose-editorial.is-hindi {
  font-family: 'Noto Serif Devanagari', 'Noto Sans Devanagari', Georgia, serif;
  font-size: 20px;
  line-height: 1.9;
}

/* Paragraph Spacing & Base Font Size Inheritance */
.prose-editorial p {
  font-size: inherit;
  line-height: inherit;
  margin-bottom: 1.5rem;
}

.prose-editorial p.lead {
  font-size: inherit;
  line-height: inherit;
}

/* Pure CSS Drop Cap on First Paragraph */
/* Float left, Playfair Display 900, 4.2em, line-height 0.8, red */
/* Small right margin (0.12em) ensures "In" reads cleanly as one word */
.prose-editorial > p:first-of-type::first-letter {
  float: left;
  font-family: 'Playfair Display', Georgia, serif;
  font-weight: 900;
  font-size: 4.2em;
  line-height: 0.8;
  margin-right: 0.12em;
  padding: 0;
  color: #C8102E;
}

/* Red Serif Pull Quotes */
.prose-editorial blockquote {
  font-family: 'Playfair Display', Georgia, serif;
  font-style: italic;
  font-size: 1.35rem;
  line-height: 1.5;
  border-left: 4px solid #C8102E;
  padding-left: 1.5rem;
  margin: 2.25rem 0;
  color: #0B0F19;
}
.dark .prose-editorial blockquote {
  color: #FAFAFA;
}

/* Headings inside Article Body */
.prose-editorial h2,
.prose-editorial h3 {
  font-family: 'Playfair Display', Georgia, serif;
  font-weight: 900;
  color: #0B0F19;
  letter-spacing: -0.02em;
  margin-top: 2.5rem;
  margin-bottom: 1rem;
}
.dark .prose-editorial h2,
.dark .prose-editorial h3 {
  color: #FFFFFF;
}

.prose-editorial h2 {
  font-size: 1.75rem;
  line-height: 1.25;
}

.prose-editorial h3 {
  font-size: 1.35rem;
  line-height: 1.3;
}

/* Lists */
.prose-editorial ul,
.prose-editorial ol {
  margin: 1.5rem 0;
  padding-left: 1.5rem;
}

.prose-editorial ul {
  list-style-type: disc;
}

.prose-editorial ol {
  list-style-type: decimal;
}

.prose-editorial li {
  margin-bottom: 0.5rem;
  font-size: inherit;
  line-height: inherit;
}

/* Inline Images and Figures */
.prose-editorial figure {
  margin: 2.25rem 0;
}

.prose-editorial figure img {
  border-radius: 0.5rem;
  width: 100%;
}

.prose-editorial figcaption {
  font-family: 'Inter', sans-serif;
  font-size: 0.75rem;
  color: #5B6475;
  font-style: italic;
  margin-top: 0.5rem;
  border-left: 2px solid #C8102E;
  padding-left: 0.75rem;
}
.dark .prose-editorial figcaption {
  color: #94A3B8;
}

/* Links inside Article Body */
.prose-editorial a {
  color: #C8102E;
  text-decoration: underline;
  text-underline-offset: 3px;
  font-weight: 500;
  transition: opacity 0.2s;
}
.prose-editorial a:hover {
  opacity: 0.8;
}
</style>
