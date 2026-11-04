<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from 'lucide-vue-next';

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    default: '',
  },
  href: {
    type: String,
    default: '',
  },
  viewAllText: {
    type: String,
    default: '',
  },
  color: {
    type: String,
    default: '#C8102E',
  },
  count: {
    type: [Number, String],
    default: null,
  },
});

const { locale } = useI18n();

const resolvedViewAll = computed(() => {
  if (props.viewAllText) return props.viewAllText;
  return locale.value === 'hi' ? 'सभी देखें' : 'View Section';
});
</script>

<template>
  <div class="flex items-end justify-between pb-3.5 mb-6 border-b-2 border-ink dark:border-ink relative">
    <div>
      <!-- Small-caps kicker / category badge -->
      <div v-if="label" class="flex items-center gap-2 mb-1.5">
        <span class="w-2.5 h-2.5 rounded-full" :style="{ backgroundColor: color }"></span>
        <span class="section-label text-[11px] text-muted tracking-widest font-mono">
          {{ label }}
        </span>
      </div>

      <!-- Main Headline in Serif -->
      <h2 class="text-xl sm:text-2xl lg:text-3xl font-serif font-black tracking-tight text-ink flex items-center gap-3">
        <span>{{ title }}</span>
        <span
          v-if="count !== null"
          class="text-xs font-mono font-bold px-2 py-0.5 rounded-full bg-surface border border-border text-muted"
        >
          {{ count }}
        </span>
      </h2>
    </div>

    <!-- Optional Right Link -->
    <Link
      v-if="href"
      :href="href"
      class="group inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-muted hover:text-accent transition-colors pb-0.5"
    >
      <span>{{ resolvedViewAll }}</span>
      <ArrowRight class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-1" />
    </Link>
  </div>
</template>

