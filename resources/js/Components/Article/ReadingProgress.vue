<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const progress = ref(0);

const updateProgress = () => {
  const scrollTop = window.scrollY || document.documentElement.scrollTop;
  const docHeight = document.documentElement.scrollHeight - window.innerHeight;
  if (docHeight > 0) {
    progress.value = Math.min(100, Math.max(0, (scrollTop / docHeight) * 100));
  }
};

onMounted(() => {
  window.addEventListener('scroll', updateProgress, { passive: true });
  updateProgress();
});

onUnmounted(() => {
  window.removeEventListener('scroll', updateProgress);
});
</script>

<template>
  <div class="fixed top-0 left-0 right-0 z-50 h-1 bg-transparent">
    <div
      class="h-full bg-[#C8102E] transition-all duration-150 ease-out shadow-sm"
      :style="{ width: `${progress}%` }"
    ></div>
  </div>
</template>

