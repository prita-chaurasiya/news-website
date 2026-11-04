<script setup>
defineProps({
  type: {
    type: String,
    default: 'box', // 'box', 'card', 'hero', 'text', 'avatar'
  },
  height: {
    type: String,
    default: 'h-4',
  },
  width: {
    type: String,
    default: 'w-full',
  },
  count: {
    type: Number,
    default: 1,
  },
  rounded: {
    type: String,
    default: 'rounded',
  },
});
</script>

<template>
  <!-- Card Skeleton -->
  <div v-if="type === 'card'" class="space-y-3">
    <div class="w-full aspect-[3/2] rounded bg-surface border border-border animate-shimmer"></div>
    <div class="h-3 w-1/4 rounded bg-surface animate-shimmer"></div>
    <div class="h-5 w-4/5 rounded bg-surface animate-shimmer"></div>
    <div class="h-3 w-3/5 rounded bg-surface animate-shimmer"></div>
  </div>

  <!-- Hero Skeleton -->
  <div v-else-if="type === 'hero'" class="space-y-4">
    <div class="w-full aspect-[16/9] rounded-lg bg-surface border border-border animate-shimmer"></div>
    <div class="h-4 w-1/5 rounded bg-surface animate-shimmer"></div>
    <div class="h-8 w-11/12 rounded bg-surface animate-shimmer"></div>
    <div class="h-4 w-3/4 rounded bg-surface animate-shimmer"></div>
  </div>

  <!-- Avatar Skeleton -->
  <div v-else-if="type === 'avatar'" class="w-10 h-10 rounded-full bg-surface border border-border animate-shimmer"></div>

  <!-- Simple Text Line(s) -->
  <div v-else-if="type === 'text'" class="space-y-2">
    <div
      v-for="n in count"
      :key="n"
      :class="[height, n === count && count > 1 ? 'w-2/3' : width, rounded, 'bg-surface animate-shimmer']"
    ></div>
  </div>

  <!-- Default Box -->
  <div
    v-else
    :class="[height, width, rounded, 'bg-surface border border-border animate-shimmer']"
  ></div>
</template>

