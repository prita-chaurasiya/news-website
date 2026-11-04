<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import { Feather, ArrowRight, Quote } from 'lucide-vue-next';
import FadeUp from '@/Components/UI/FadeUp.vue';

const props = defineProps({
  articles: {
    type: Array,
    default: () => [],
  },
});

const { locale } = useI18n();

const getTitle = (art) => {
  if (locale.value === 'hi' && art.title_hi) return art.title_hi;
  return art.title;
};

const getSubtitle = (art) => {
  if (locale.value === 'hi' && art.subtitle_hi) return art.subtitle_hi;
  return art.subtitle || art.excerpt;
};

const getAuthorName = (art) => {
  if (!art.author) return 'Editorial Board';
  if (locale.value === 'hi' && art.author.name_hi) return art.author.name_hi;
  return art.author.name;
};

const getAuthorRole = (art) => {
  if (!art.author) return 'Columnist';
  if (locale.value === 'hi' && art.author.role_title_hi) return art.author.role_title_hi;
  return art.author.role_title || 'Contributing Editor';
};
</script>

<template>
  <section class="my-12 sm:my-16 py-8 px-4 sm:px-8 bg-surface rounded-lg border border-border">
    <!-- Header -->
    <div class="flex items-center justify-between pb-4 mb-8 border-b-2 border-ink">
      <div class="flex items-center gap-2">
        <Feather class="w-4 h-4 text-accent" />
        <h2 class="text-xs font-bold uppercase tracking-widest text-ink font-mono">
          {{ $t('home.opinionAndAnalysis') }}
        </h2>
      </div>

      <Link
        href="/category/opinion"
        class="text-xs font-semibold uppercase tracking-wider text-muted hover:text-accent transition-colors flex items-center gap-1 group"
      >
        <span>{{ $t('home.viewAll') }}</span>
        <ArrowRight class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" />
      </Link>
    </div>

    <!-- Opinion Grid (The Print style with author circles & pull-quote styling) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <FadeUp
        v-for="(art, idx) in articles"
        :key="art.id"
        :delay="idx * 100"
      >
        <div class="group relative flex flex-col justify-between p-5 bg-paper rounded border border-border/80 hover:shadow-editorial-hover transition-all duration-300 h-full">
          <!-- Decorative Quote Watermark -->
          <span class="absolute top-3 right-4 font-serif text-5xl font-black text-accent/15 leading-none select-none pointer-events-none group-hover:text-accent/30 transition-colors">
            “
          </span>

          <div>
            <!-- Author Header with Circular Photo + Thin Red Ring -->
            <div class="flex items-center gap-3.5 mb-4 pb-3 border-b border-border/60">
              <img
                v-if="art.author?.avatar"
                :src="art.author.avatar"
                :alt="getAuthorName(art)"
                class="w-12 h-12 rounded-full object-cover ring-2 ring-accent/80 shadow-sm flex-shrink-0"
              />
              <div class="min-w-0">
                <h4 class="text-xs font-bold text-ink dark:text-zinc-100 truncate">
                  {{ getAuthorName(art) }}
                </h4>
                <p class="text-[11px] text-accent font-medium truncate font-mono">
                  {{ getAuthorRole(art) }}
                </p>
              </div>
            </div>

            <!-- Headline (Playfair Display) -->
            <h3 class="text-base sm:text-lg font-serif font-bold text-ink dark:text-zinc-100 group-hover:text-accent transition-colors leading-snug mb-3 line-clamp-3">
              <Link :href="`/article/${art.slug}`">
                {{ getTitle(art) }}
              </Link>
            </h3>

            <!-- Pull-Quote Style Italic Excerpt -->
            <blockquote class="text-xs sm:text-sm text-muted dark:text-zinc-300 font-editorial italic line-clamp-3 leading-relaxed border-l-2 border-accent/40 pl-3">
              “{{ getSubtitle(art) }}”
            </blockquote>
          </div>

          <div class="mt-4 pt-3 border-t border-border/60 flex items-center justify-between text-[11px] text-muted dark:text-zinc-400">
            <span class="uppercase tracking-widest font-semibold text-[10px] text-accent font-mono">
              {{ art.type === 'editorial' ? 'Editorial' : 'Column' }}
            </span>
            <span class="font-mono">{{ art.reading_time || 5 }} {{ $t('home.minRead') }}</span>
          </div>
        </div>
      </FadeUp>
    </div>
  </section>
</template>
