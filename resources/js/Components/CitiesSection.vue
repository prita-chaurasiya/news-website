<script setup>
import { ref, computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import { MapPin, ArrowRight, Clock } from 'lucide-vue-next';
import ResponsiveImage from '@/Components/UI/ResponsiveImage.vue';

const props = defineProps({
  articles: {
    type: Array,
    default: () => [],
  },
});

const { locale } = useI18n();

const cities = [
  { key: 'delhi', name: 'Delhi', name_hi: 'दिल्ली' },
  { key: 'mumbai', name: 'Mumbai', name_hi: 'मुंबई' },
  { key: 'bengaluru', name: 'Bengaluru', name_hi: 'बेंगलुरु' },
  { key: 'kolkata', name: 'Kolkata', name_hi: 'कोलकाता' },
  { key: 'chennai', name: 'Chennai', name_hi: 'चेन्नई' },
  { key: 'lucknow', name: 'Lucknow', name_hi: 'लखनऊ' },
  { key: 'hyderabad', name: 'Hyderabad', name_hi: 'हैदराबाद' },
];

const activeCityKey = ref('delhi');

const activeCity = computed(() => {
  return cities.find(c => c.key === activeCityKey.value) || cities[0];
});

// Display 4 stories from the pool, simulated per city
const displayArticles = computed(() => {
  if (!Array.isArray(props.articles) || props.articles.length === 0) return [];
  const offset = cities.findIndex(c => c.key === activeCityKey.value);
  const rotated = [...props.articles.slice(offset), ...props.articles.slice(0, offset)];
  return rotated.slice(0, 4);
});

const getTitle = (art) => {
  if (locale.value === 'hi' && art.title_hi) return art.title_hi;
  return art.title;
};

const getExcerpt = (art) => {
  if (locale.value === 'hi' && art.excerpt_hi) return art.excerpt_hi;
  return art.excerpt || art.subtitle;
};
</script>

<template>
  <section id="cities" v-if="displayArticles.length" class="my-10 sm:my-14 py-6 border-b border-border scroll-mt-20">
    <!-- Header with City Selector Tabs -->
    <div class="flex flex-col md:flex-row md:items-center justify-between pb-3 mb-6 border-b-2 border-ink gap-4">
      <div class="flex items-center gap-2">
        <MapPin class="w-4 h-4 text-[#C8102E]" />
        <h2 class="font-serif font-black text-xl sm:text-2xl text-ink tracking-tight">
          {{ $t('home.citiesTitle') }}
        </h2>
        <span class="text-[10px] text-muted font-mono uppercase hidden sm:inline">• EYE ON THE NATION</span>
      </div>

      <!-- Indian Express Horizontal City Tabs -->
      <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar text-xs font-semibold whitespace-nowrap">
        <button
          v-for="city in cities"
          :key="city.key"
          @click="activeCityKey = city.key"
          class="px-2.5 py-1 rounded transition-colors"
          :class="activeCityKey === city.key
            ? 'bg-[#C8102E] text-white font-bold shadow-sm'
            : 'text-muted dark:text-zinc-300 hover:text-ink hover:bg-surface dark:hover:bg-zinc-800'"
        >
          {{ locale === 'hi' ? city.name_hi : city.name }}
        </button>
      </div>
    </div>

    <!-- 4 City Stories Grid (1 Dominant + 3 Compact) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div
        v-for="(art, idx) in displayArticles"
        :key="art.id || idx"
        class="group flex flex-col justify-between"
      >
        <div>
          <!-- Thumbnail -->
          <Link
            v-if="art.featured_image"
            :href="`/article/${art.slug}`"
            class="block aspect-[16/9] overflow-hidden rounded-sm bg-surface mb-3"
          >
            <ResponsiveImage
              :src="art.featured_image"
              :alt="getTitle(art)"
              aspect-ratio="16/9"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            />
          </Link>

          <!-- City Tag -->
          <div class="flex items-center gap-1 text-[10px] font-mono uppercase tracking-wider text-[#C8102E] font-bold mb-1">
            <span>{{ locale === 'hi' ? activeCity.name_hi : activeCity.name }}</span>
            <span>DISPATCH</span>
          </div>

          <!-- Headline -->
          <Link
            :href="`/article/${art.slug}`"
            class="font-serif font-bold text-sm sm:text-base text-ink dark:text-zinc-100 group-hover:text-[#C8102E] transition-colors leading-snug line-clamp-3 mb-1.5 block"
          >
            {{ getTitle(art) }}
          </Link>

          <p class="font-editorial text-xs text-muted dark:text-zinc-300 line-clamp-2 leading-relaxed">
            {{ getExcerpt(art) }}
          </p>
        </div>

        <div class="mt-3 pt-2 border-t border-dashed border-border flex items-center justify-between text-[11px] font-mono text-muted dark:text-zinc-400">
          <span>{{ art.reading_time || 3 }} MIN READ</span>
          <Link :href="`/article/${art.slug}`" class="text-[#C8102E] hover:underline font-bold">
            Full Story →
          </Link>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.no-scrollbar::-webkit-scrollbar {
  display: none;
}
.no-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
