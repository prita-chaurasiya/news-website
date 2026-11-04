<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Zap, CheckCircle2 } from 'lucide-vue-next';

const props = defineProps({
  takeaways: {
    type: [Array, Object],
    default: () => [],
  },
});

const { locale } = useI18n();

const points = computed(() => {
  if (Array.isArray(props.takeaways)) {
    return props.takeaways;
  }
  if (typeof props.takeaways === 'object' && props.takeaways !== null) {
    if (locale.value === 'hi' && Array.isArray(props.takeaways.hi)) {
      return props.takeaways.hi;
    }
    if (Array.isArray(props.takeaways.en)) {
      return props.takeaways.en;
    }
  }
  return [];
});
</script>

<template>
  <div
    v-if="points && points.length > 0"
    class="my-8 p-5 sm:p-6 bg-[#FAF8F5] dark:bg-[#121826] border border-[#E7E2DA] dark:border-[#232B3B] border-l-4 border-l-[#C8102E] rounded-r-lg shadow-none"
  >
    <div class="flex items-center gap-2 mb-3.5">
      <div class="w-5 h-5 rounded-full bg-[#C8102E] text-white flex items-center justify-center flex-shrink-0">
        <Zap class="w-3 h-3 fill-current" />
      </div>
      <h3 class="font-sans text-xs font-bold uppercase tracking-widest text-[#C8102E]">
        {{ $t('article.keyTakeaways') }}
      </h3>
    </div>

    <ul class="space-y-3 font-sans text-[17px] leading-[1.6] text-ink dark:text-zinc-200">
      <li
        v-for="(point, idx) in points"
        :key="idx"
        class="flex items-start gap-3"
      >
        <CheckCircle2 class="w-4 h-4 text-[#C8102E] flex-shrink-0 mt-1" />
        <span>{{ point }}</span>
      </li>
    </ul>
  </div>
</template>
