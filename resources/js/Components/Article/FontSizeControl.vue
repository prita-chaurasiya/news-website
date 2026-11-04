<script setup>
import { computed } from 'vue';
import { useNewsStore } from '@/stores/newsStore';

const newsStore = useNewsStore();

const increase = () => {
  if (newsStore.fontSizeLevel < 3) {
    newsStore.setFontSize(newsStore.fontSizeLevel + 1);
  }
};

const decrease = () => {
  if (newsStore.fontSizeLevel > 0) {
    newsStore.setFontSize(newsStore.fontSizeLevel - 1);
  }
};

const reset = () => {
  newsStore.setFontSize(1);
};
</script>

<template>
  <div class="inline-flex items-center bg-gray-100 dark:bg-zinc-800 rounded p-0.5 border border-gray-200 dark:border-zinc-700 text-xs">
    <button
      @click="decrease"
      :disabled="newsStore.fontSizeLevel === 0"
      class="px-2 py-0.5 font-bold hover:bg-white dark:hover:bg-zinc-700 rounded transition-colors disabled:opacity-30"
      title="Decrease font size"
    >
      A-
    </button>

    <button
      @click="reset"
      class="px-2 py-0.5 font-bold hover:bg-white dark:hover:bg-zinc-700 rounded transition-colors text-[11px]"
      :class="{ 'text-[#C8102E]': newsStore.fontSizeLevel === 1 }"
      title="Reset font size"
    >
      A
    </button>

    <button
      @click="increase"
      :disabled="newsStore.fontSizeLevel === 3"
      class="px-2 py-0.5 font-bold hover:bg-white dark:hover:bg-zinc-700 rounded transition-colors disabled:opacity-30"
      title="Increase font size"
    >
      A+
    </button>
  </div>
</template>

