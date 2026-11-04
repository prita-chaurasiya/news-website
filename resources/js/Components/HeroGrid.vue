<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import { Clock, Sparkles, ArrowRight, Quote, CheckCircle2 } from 'lucide-vue-next';
import ResponsiveImage from '@/Components/UI/ResponsiveImage.vue';
import FadeUp from '@/Components/UI/FadeUp.vue';

const props = defineProps({
  leadStory: {
    type: Object,
    default: null,
  },
  secondaryStories: {
    type: Array,
    default: () => [],
  },
  opinionStories: {
    type: Array,
    default: () => [],
  },
});

const { locale } = useI18n();

const getTitle = (art) => {
  if (!art) return '';
  if (locale.value === 'hi' && art.title_hi) return art.title_hi;
  return art.title;
};

const getExcerpt = (art) => {
  if (!art) return '';
  if (locale.value === 'hi' && art.excerpt_hi) return art.excerpt_hi;
  return art.excerpt || art.subtitle;
};

const getCategory = (art) => {
  if (!art || !art.category) return '';
  if (locale.value === 'hi' && art.category.name_hi) return art.category.name_hi;
  return art.category.name;
};

const getAuthorName = (art) => {
  if (!art || !art.author) return 'Editorial Desk';
  if (locale.value === 'hi' && art.author.name_hi) return art.author.name_hi;
  return art.author.name;
};

const getAuthorRole = (art) => {
  if (!art || !art.author) return 'Contributing Columnist';
  if (locale.value === 'hi' && art.author.role_title_hi) return art.author.role_title_hi;
  return art.author.role_title || 'Senior Editorial Columnist';
};

// Left Column Stories (3 items)
const topStoriesList = computed(() => {
  return props.secondaryStories.slice(0, 3);
});

// Related Bullet Stories under Lead (items 4 & 5 if available)
const relatedLeadStories = computed(() => {
  return props.secondaryStories.slice(3, 5);
});

// Spotlight Columnist from opinionStories
const featuredColumnistStory = computed(() => {
  return props.opinionStories && props.opinionStories.length > 0
    ? props.opinionStories[0]
    : props.secondaryStories[props.secondaryStories.length - 1];
});

// Key Takeaways for Explained box
const takeaways = computed(() => {
  if (props.leadStory && Array.isArray(props.leadStory.localized_key_takeaways) && props.leadStory.localized_key_takeaways.length) {
    return props.leadStory.localized_key_takeaways.slice(0, 3);
  }
  return [
    'Strategic infrastructure clearance along western economic corridor.',
    'Over $12 billion in projected semiconductor and electronics throughput.',
    'Aligns with national manufacturing and supply-chain resilience targets.',
  ];
});
</script>

<template>
  <section class="py-6 sm:py-8 border-b border-border">
    <!-- ============================================== -->
    <!-- INDIAN EXPRESS SIGNATURE 3-COLUMN HERO GRID    -->
    <!-- (Left 3 cols | Center 6 cols | Right 3 cols)   -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:divide-x lg:divide-border items-start">

      <!-- ============================================ -->
      <!-- COLUMN 1: TOP STORIES (Left 3 cols)         -->
      <!-- ============================================ -->
      <div class="lg:col-span-3 space-y-4">
        <!-- Section Header -->
        <div class="flex items-center justify-between pb-2 border-b-2 border-ink">
          <div class="flex items-center gap-1.5">
            <span class="w-2.5 h-2.5 bg-[#C8102E] rounded-sm"></span>
            <h3 class="text-xs font-bold uppercase tracking-widest text-ink font-mono">
              {{ $t('home.topStories') }}
            </h3>
          </div>
          <span class="text-[10px] text-muted uppercase font-mono tracking-wider">LATEST</span>
        </div>

        <!-- 3 Compact Broadside Cards -->
        <div class="divide-y divide-border/80">
          <div
            v-for="(story, idx) in topStoriesList"
            :key="story.id || idx"
            class="pt-3 pb-3.5 first:pt-0 group"
          >
            <!-- Category Tag & Time -->
            <div class="flex items-center justify-between text-[10px] uppercase font-mono tracking-wider mb-1.5 text-muted">
              <span class="text-[#C8102E] font-bold">{{ getCategory(story) }}</span>
              <span>{{ story.reading_time || 3 }} MIN</span>
            </div>

            <!-- Headline -->
            <Link
              :href="`/article/${story.slug}`"
              class="block font-serif font-bold text-sm sm:text-base text-ink group-hover:text-[#C8102E] transition-colors leading-snug line-clamp-3 mb-2"
            >
              {{ getTitle(story) }}
            </Link>

            <!-- Compact Thumbnail (if available) -->
            <Link
              v-if="story.featured_image"
              :href="`/article/${story.slug}`"
              class="block aspect-[16/9] overflow-hidden rounded-sm bg-surface mt-2"
            >
              <ResponsiveImage
                :src="story.featured_image"
                :alt="getTitle(story)"
                aspect-ratio="16/9"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
              />
            </Link>
          </div>
        </div>
      </div>

      <!-- ============================================ -->
      <!-- COLUMN 2: THE LEAD REPORT (Center 6 cols)   -->
      <!-- ============================================ -->
      <div v-if="leadStory" class="lg:col-span-6 lg:px-4">
        <FadeUp :duration="600">
          <article class="group">
            <!-- 16:9 Main Image -->
            <Link
              :href="`/article/${leadStory.slug}`"
              class="block aspect-[16/9] overflow-hidden rounded-sm bg-surface mb-4 relative"
            >
              <ResponsiveImage
                :src="leadStory.featured_image"
                :alt="getTitle(leadStory)"
                :lqip="leadStory.image_lqip"
                aspect-ratio="16/9"
                priority
                class="w-full h-full object-cover group-hover:scale-102 transition-transform duration-500"
              />
              <span
                v-if="leadStory.category"
                class="absolute top-3 left-3 bg-[#C8102E] text-white text-[11px] font-bold px-2.5 py-0.5 uppercase tracking-wider font-mono shadow-sm"
              >
                {{ getCategory(leadStory) }}
              </span>
            </Link>

            <!-- Lead Headline -->
            <Link :href="`/article/${leadStory.slug}`">
              <h1 class="font-serif font-black text-2xl sm:text-3xl md:text-[34px] leading-[1.18] text-ink group-hover:text-[#C8102E] transition-colors tracking-tight mb-2.5">
                {{ getTitle(leadStory) }}
              </h1>
            </Link>

            <!-- Lead Excerpt -->
            <p class="font-editorial text-sm sm:text-base text-muted leading-relaxed line-clamp-3 mb-3.5">
              {{ getExcerpt(leadStory) }}
            </p>

            <!-- Byline & Timestamp -->
            <div class="flex items-center justify-between py-2 border-y border-border text-xs text-muted font-sans">
              <div class="flex items-center gap-2">
                <div v-if="leadStory.author && leadStory.author.avatar" class="w-6 h-6 rounded-full overflow-hidden bg-surface border border-border">
                  <img :src="leadStory.author.avatar" :alt="getAuthorName(leadStory)" class="w-full h-full object-cover" />
                </div>
                <span class="font-bold text-ink">{{ getAuthorName(leadStory) }}</span>
                <span class="text-muted/60">•</span>
                <span class="text-[11px] font-mono uppercase">{{ leadStory.formatted_date || 'Today' }}</span>
              </div>
              <div class="flex items-center gap-1 text-[11px] font-mono">
                <Clock class="w-3 h-3 text-[#C8102E]" />
                <span>{{ leadStory.reading_time || 5 }} MIN READ</span>
              </div>
            </div>

            <!-- Indian Express Sub-Story Bullets (Related Coverage) -->
            <div v-if="relatedLeadStories.length" class="mt-4 pt-3 border-t border-dashed border-border space-y-2">
              <span class="text-[10px] uppercase font-mono tracking-widest font-bold text-[#C8102E] block">
                RELATED DISPATCHES
              </span>
              <ul class="space-y-1.5">
                <li
                  v-for="(rel, idx) in relatedLeadStories"
                  :key="idx"
                  class="flex items-start gap-2 group/rel"
                >
                  <span class="text-[#C8102E] font-bold text-sm leading-none mt-0.5">•</span>
                  <Link
                    :href="`/article/${rel.slug}`"
                    class="font-serif text-xs sm:text-sm font-semibold text-ink group-hover/rel:text-[#C8102E] transition-colors line-clamp-1 leading-snug"
                  >
                    {{ getTitle(rel) }}
                  </Link>
                </li>
              </ul>
            </div>
          </article>
        </FadeUp>
      </div>

      <!-- ============================================ -->
      <!-- COLUMN 3: EXPLAINED & OPINION (Right 3 cols) -->
      <!-- ============================================ -->
      <div class="lg:col-span-3 lg:pl-4 space-y-5">
        <!-- 1. SIGNATURE "EXPLAINED" SPOTLIGHT BOX -->
        <div class="p-4 bg-surface border-t-4 border-[#C8102E] border-x border-b border-border rounded-sm shadow-sm">
          <div class="flex items-center justify-between pb-2 mb-2.5 border-b border-border">
            <div class="flex items-center gap-1.5">
              <span class="px-2 py-0.5 bg-[#C8102E] text-white text-[10px] font-black tracking-widest uppercase font-mono rounded-sm">
                EXPLAINED
              </span>
            </div>
            <span class="text-[10px] text-muted uppercase font-mono tracking-wider">CONTEXT</span>
          </div>

          <Link
            v-if="leadStory"
            :href="`/article/${leadStory.slug}`"
            class="block font-serif font-bold text-sm sm:text-base text-ink hover:text-[#C8102E] transition-colors leading-snug mb-3"
          >
            Explained: {{ getTitle(leadStory) }}
          </Link>

          <!-- Key Takeaway Bullets -->
          <ul class="space-y-2 text-xs text-muted font-sans border-t border-dashed border-border pt-2.5">
            <li
              v-for="(point, idx) in takeaways"
              :key="idx"
              class="flex items-start gap-2 leading-relaxed"
            >
              <CheckCircle2 class="w-3.5 h-3.5 text-[#C8102E] shrink-0 mt-0.5" />
              <span>{{ point }}</span>
            </li>
          </ul>

          <Link
            v-if="leadStory"
            :href="`/article/${leadStory.slug}`"
            class="mt-3.5 inline-flex items-center gap-1 text-[11px] font-bold uppercase tracking-wider text-[#C8102E] hover:underline"
          >
            <span>Read Complete Context</span>
            <ArrowRight class="w-3 h-3" />
          </Link>
        </div>

        <!-- 2. THE COLUMNIST / OPINION SPOTLIGHT CARD -->
        <div v-if="featuredColumnistStory" class="p-4 bg-paper border border-border rounded-sm">
          <div class="flex items-center justify-between pb-2 mb-3 border-b border-border">
            <h4 class="text-xs font-bold uppercase tracking-widest text-ink font-mono">
              THE COLUMNIST
            </h4>
            <span class="text-[10px] text-[#C8102E] font-mono font-bold uppercase">OPINION</span>
          </div>

          <!-- Author Profile -->
          <div class="flex items-center gap-3 mb-3">
            <div class="w-12 h-12 rounded-full overflow-hidden bg-surface border-2 border-[#C8102E] p-0.5 shrink-0 shadow-sm">
              <img
                v-if="featuredColumnistStory.author && featuredColumnistStory.author.avatar"
                :src="featuredColumnistStory.author.avatar"
                :alt="getAuthorName(featuredColumnistStory)"
                class="w-full h-full object-cover rounded-full"
              />
              <div v-else class="w-full h-full bg-[#C8102E] text-white flex items-center justify-center font-bold text-sm rounded-full">
                {{ getAuthorName(featuredColumnistStory)[0] }}
              </div>
            </div>

            <div>
              <h5 class="font-serif font-bold text-sm text-ink leading-tight">
                {{ getAuthorName(featuredColumnistStory) }}
              </h5>
              <p class="text-[10px] text-muted mt-0.5 line-clamp-1 font-mono uppercase">
                {{ getAuthorRole(featuredColumnistStory) }}
              </p>
            </div>
          </div>

          <!-- Pull Quote Headline -->
          <Link
            :href="`/article/${featuredColumnistStory.slug}`"
            class="block font-serif italic text-xs sm:text-sm text-ink hover:text-[#C8102E] transition-colors leading-relaxed mb-3 group"
          >
            "{{ getTitle(featuredColumnistStory) }}"
          </Link>

          <Link
            :href="`/article/${featuredColumnistStory.slug}`"
            class="inline-flex items-center gap-1 text-[11px] font-bold text-muted hover:text-[#C8102E] uppercase font-mono tracking-wider transition-colors"
          >
            <span>Read Column</span>
            <ArrowRight class="w-3 h-3" />
          </Link>
        </div>
      </div>

    </div>
  </section>
</template>
