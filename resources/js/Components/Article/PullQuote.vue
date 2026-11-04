<script setup>
import { Quote } from 'lucide-vue-next';

defineProps({
  quote: {
    type: String,
    required: true,
  },
  author: {
    type: String,
    default: '',
  },
});
</script>

<template>
  <figure class="my-8 py-4 px-6 border-l-4 border-[#C8102E] bg-gray-50/80 dark:bg-zinc-900/50 rounded-r">
    <Quote class="w-6 h-6 text-[#C8102E] mb-2 opacity-60" />
    <blockquote class="text-lg sm:text-xl font-serif italic text-gray-900 dark:text-gray-100 leading-snug">
      “{{ quote }}”
    </blockquote>
    <figcaption v-if="author" class="mt-2 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-zinc-400 font-sans">
      — {{ author }}
    </figcaption>
  </figure>
</template>

