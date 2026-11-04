<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  links: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <div v-if="links && links.length > 3" class="flex flex-wrap items-center justify-center gap-1.5 py-8">
    <template v-for="(link, key) in links" :key="key">
      <div
        v-if="link.url === null"
        class="px-3 py-1.5 text-xs text-gray-400 dark:text-zinc-600 border border-gray-200 dark:border-zinc-800 rounded opacity-50 cursor-not-allowed"
        v-html="link.label"
      ></div>

      <Link
        v-else
        :href="link.url"
        class="px-3.5 py-1.5 text-xs font-semibold rounded border transition-colors"
        :class="link.active
          ? 'bg-[#C8102E] border-[#C8102E] text-white'
          : 'bg-white dark:bg-zinc-900 border-gray-200 dark:border-zinc-800 text-gray-700 dark:text-zinc-300 hover:border-[#C8102E] hover:text-[#C8102E]'"
        v-html="link.label"
      />
    </template>
  </div>
</template>
