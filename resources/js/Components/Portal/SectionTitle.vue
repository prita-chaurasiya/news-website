<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  titleHi: {
    type: String,
    default: '',
  },
  link: {
    type: String,
    default: '',
  },
  linkText: {
    type: String,
    default: 'और भी →',
  },
  variant: {
    type: String,
    default: 'bar', // 'bar' | 'underline'
  },
});
</script>

<template>
  <div
    class="flex items-center justify-between pb-2 mb-3.5 transition-colors"
    :class="[
      variant === 'underline'
        ? 'border-b-2 border-[#D90000]'
        : 'border-b border-gray-200 dark:border-zinc-800'
    ]"
  >
    <div
      class="flex items-center gap-2"
      :class="{ 'border-l-4 border-[#D90000] pl-2.5': variant === 'bar' }"
    >
      <h2 class="font-hindi text-base sm:text-lg md:text-xl font-bold tracking-tight text-gray-900 dark:text-white leading-tight">
        {{ titleHi || title }}
      </h2>
      <slot name="badge" />
    </div>

    <Link
      v-if="link"
      :href="link"
      class="font-hindi text-xs sm:text-sm font-semibold text-[#D90000] hover:text-[#B00000] dark:hover:text-red-400 flex items-center gap-1 transition-colors group shrink-0"
    >
      <span>{{ linkText }}</span>
    </Link>
  </div>
</template>

