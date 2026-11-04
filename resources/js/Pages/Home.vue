<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import BreakingTicker from '@/Components/BreakingTicker.vue';
import MarketTicker from '@/Components/MarketTicker.vue';
import HeroGrid from '@/Components/HeroGrid.vue';
import TopStoriesStrip from '@/Components/TopStoriesStrip.vue';
import EditorsPicksBand from '@/Components/EditorsPicksBand.vue';
import LiveBlogCard from '@/Components/LiveBlogCard.vue';
import TrendingList from '@/Components/TrendingList.vue';
import LatestNews from '@/Components/LatestNews.vue';
import CategorySection from '@/Components/CategorySection.vue';
import OpinionSection from '@/Components/OpinionSection.vue';
import VideoSection from '@/Components/VideoSection.vue';
import PhotoStories from '@/Components/PhotoStories.vue';
import EpaperPromo from '@/Components/EpaperPromo.vue';
import NewsletterSignup from '@/Components/NewsletterSignup.vue';
import MembershipBanner from '@/Components/MembershipBanner.vue';
import Rule from '@/Components/UI/Rule.vue';
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
  liveBlog: {
    type: Object,
    default: null,
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
  videos: {
    type: Array,
    default: () => [],
  },
  galleries: {
    type: Array,
    default: () => [],
  },
  epaper: {
    type: Object,
    default: null,
  },
  marketTickers: {
    type: [Array, Object],
    default: () => [],
  },
  latestNews: {
    type: Array,
    default: () => [],
  },
  hasMoreLatest: {
    type: Boolean,
    default: true,
  },
  currentPage: {
    type: Number,
    default: 1,
  },
});

const safeCategorySections = computed(() => {
  if (Array.isArray(props.categorySections)) return props.categorySections;
  if (props.categorySections && typeof props.categorySections === 'object') return Object.values(props.categorySections);
  return [];
});
const firstCategorySections = computed(() => safeCategorySections.value.slice(0, 3));
const nextCategorySections = computed(() => safeCategorySections.value.slice(3, 6));

const topStoriesList = computed(() => {
  if (props.trendingNews && props.trendingNews.length) {
    return props.trendingNews.slice(0, 5);
  }
  return props.secondaryStories.slice(0, 5);
});

const editorsPicks = computed(() => {
  if (props.secondaryStories && props.secondaryStories.length >= 3) {
    return props.secondaryStories.slice(0, 3);
  }
  return props.latestNews.slice(0, 3);
});
</script>

<template>
  <MainLayout>
    <Head>
      <title>Independent Journalism. Global Perspective.</title>
      <meta name="description" content="The Chronicle provides fearless investigative journalism, ground reports, market analysis, and global affairs." />
      <meta property="og:title" content="The Chronicle — Independent Journalism" />
      <meta property="og:description" content="In-depth reporting from India and around the world." />
    </Head>

    <!-- 1. BREAKING NEWS TICKER -->
    <BreakingTicker :news="breakingNews" />

    <!-- 2. BLOOMBERG-STYLE MARKET DATA STRIP -->
    <MarketTicker :tickers="marketTickers" />

    <!-- 3. MAIN HOMEPAGE CONTENT WRAPPER -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
      <!-- HERO SECTION: 1 Lead Story + 4 Secondary Stories -->
      <HeroGrid
        :lead-story="leadStory"
        :secondary-stories="secondaryStories"
      />

      <!-- HORIZONTAL "TOP STORIES" NUMBERED STRIP (Axios / NYT style) -->
      <TopStoriesStrip :articles="topStoriesList" />

      <!-- LIVE BLOG CARD -->
      <div id="live-blog" class="my-8">
        <LiveBlogCard :live-blog="liveBlog" />
      </div>

      <!-- PRIMARY 2-COLUMN SPLIT (Section gap: 64px - 96px) -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 my-8 sm:my-12">
        <!-- PRIMARY CONTENT COLUMN (8 COLS) -->
        <div class="lg:col-span-8 space-y-8">
          <!-- First 3 Categories: Politics, Business, Tech -->
          <template v-for="sec in firstCategorySections" :key="sec.category.slug">
            <CategorySection
              :category="sec.category"
              :articles="sec.articles"
            />
          </template>
        </div>

        <!-- SIDEBAR COLUMN (4 COLS) -->
        <div class="lg:col-span-4 space-y-8">
          <!-- TRENDING NOW TOP 10 -->
          <TrendingList :articles="trendingNews" />

          <!-- SIDEBAR DISPLAY ADVERTISEMENT -->
          <div class="p-4 bg-surface border border-dashed border-border rounded text-center">
            <span class="text-[10px] tracking-widest uppercase font-mono text-muted block mb-2">Advertisement</span>
            <div class="aspect-[4/3] bg-gradient-to-br from-zinc-800 to-zinc-950 rounded flex flex-col items-center justify-center p-6 text-white text-center shadow-lg">
              <span class="text-xs uppercase tracking-widest text-accent font-bold mb-1 font-mono">Chronicle Pro</span>
              <h4 class="font-serif font-bold text-base mb-2">The Complete Digital Archive</h4>
              <p class="text-xs text-zinc-300 mb-4 font-editorial">Unlimited access to 20 years of investigative journalism & financial intelligence.</p>
              <a href="#subscribe" class="bg-accent hover:bg-accent-hover text-white text-xs font-bold px-4 py-2 rounded uppercase tracking-wider transition-colors shadow">
                Start Trial
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- FULL-WIDTH "EDITOR'S PICKS" BAND ON DARK BACKGROUND -->
      <EditorsPicksBand :articles="editorsPicks" />

      <!-- OPINION AND EDITORIAL SECTION (The Print style) -->
      <OpinionSection :articles="opinionStories" />

      <!-- VIDEOS SECTION (Bloomberg / WaPo style) -->
      <div id="videos">
        <VideoSection :videos="videos" />
      </div>

      <!-- PHOTO STORIES / GALLERIES (Masonry Grid with Lightbox) -->
      <div id="photo-stories">
        <PhotoStories :galleries="galleries" />
      </div>

      <!-- SECONDARY 2-COLUMN SPLIT -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 my-10 sm:my-14">
        <!-- LOWER PRIMARY COLUMN (8 COLS) -->
        <div class="lg:col-span-8 space-y-8">
          <!-- Next Categories: Sports, India, World -->
          <template v-for="sec in nextCategorySections" :key="sec.category.slug">
            <CategorySection
              :category="sec.category"
              :articles="sec.articles"
            />
          </template>

          <!-- LATEST NEWS WITH LOAD MORE -->
          <LatestNews
            :initial-news="latestNews"
            :has-more="hasMoreLatest"
            :current-page="currentPage"
          />
        </div>

        <!-- LOWER SIDEBAR (4 COLS) -->
        <div class="lg:col-span-4 space-y-6">
          <!-- E-PAPER PROMO (The Hindu style) -->
          <div id="epaper">
            <EpaperPromo :epaper="epaper" />
          </div>

          <!-- NEWSLETTER SIGNUP BLOCK -->
          <NewsletterSignup />

          <!-- GUARDIAN STYLE MEMBERSHIP BANNER -->
          <div id="subscribe">
            <MembershipBanner />
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>
