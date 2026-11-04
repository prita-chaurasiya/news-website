<script setup>
defineProps({
  type: {
    type: String,
    default: 'card', // 'card', 'horizontal', 'text', 'hero'
  },
});
</script>

<template>
  <div v-if="type === 'hero'" class="animate-pulse space-y-4">
    <div class="w-full h-80 sm:h-96 bg-gray-200 dark:bg-zinc-800 rounded"></div>
    <div class="h-4 bg-gray-200 dark:bg-zinc-800 rounded w-1/4"></div>
    <div class="h-8 bg-gray-200 dark:bg-zinc-800 rounded w-3/4"></div>
    <div class="h-4 bg-gray-200 dark:bg-zinc-800 rounded w-full"></div>
    <div class="h-4 bg-gray-200 dark:bg-zinc-800 rounded w-2/3"></div>
  </div>

  <div v-else-if="type === 'horizontal'" class="animate-pulse flex gap-4 py-3">
    <div class="w-28 h-20 sm:w-36 sm:h-24 bg-gray-200 dark:bg-zinc-800 rounded flex-shrink-0"></div>
    <div class="flex-1 space-y-2">
      <div class="h-3 bg-gray-200 dark:bg-zinc-800 rounded w-1/4"></div>
      <div class="h-4 bg-gray-200 dark:bg-zinc-800 rounded w-5/6"></div>
      <div class="h-3 bg-gray-200 dark:bg-zinc-800 rounded w-1/2"></div>
    </div>
  </div>

  <div v-else class="animate-pulse space-y-3">
    <div class="w-full h-44 bg-gray-200 dark:bg-zinc-800 rounded"></div>
    <div class="h-3 bg-gray-200 dark:bg-zinc-800 rounded w-1/3"></div>
    <div class="h-5 bg-gray-200 dark:bg-zinc-800 rounded w-4/5"></div>
    <div class="h-3 bg-gray-200 dark:bg-zinc-800 rounded w-full"></div>
  </div>
</template>

