<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  delay: {
    type: Number,
    default: 0,
  },
  duration: {
    type: Number,
    default: 600,
  },
  threshold: {
    type: Number,
    default: 0.1,
  },
  distance: {
    type: String,
    default: '20px',
  },
  as: {
    type: String,
    default: 'div',
  },
});

const target = ref(null);
const isVisible = ref(false);
let observer = null;

onMounted(() => {
  // Check user preference for reduced motion
  if (typeof window !== 'undefined') {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) {
      isVisible.value = true;
      return;
    }
  }

  if (typeof IntersectionObserver !== 'undefined' && target.value) {
    observer = new IntersectionObserver(
      (entries) => {
        const [entry] = entries;
        if (entry.isIntersecting) {
          isVisible.value = true;
          if (observer) {
            observer.disconnect();
          }
        }
      },
      {
        threshold: props.threshold,
        rootMargin: '40px 0px 0px 0px',
      }
    );
    observer.observe(target.value);
  } else {
    isVisible.value = true;
  }
});

onUnmounted(() => {
  if (observer) {
    observer.disconnect();
  }
});
</script>

<template>
  <component
    :is="as"
    ref="target"
    :style="{
      transitionProperty: 'opacity, transform',
      transitionDuration: `${duration}ms`,
      transitionTimingFunction: 'cubic-bezier(0.16, 1, 0.3, 1)',
      transitionDelay: `${delay}ms`,
      opacity: isVisible ? 1 : 0,
      transform: isVisible ? 'translateY(0)' : `translateY(${distance})`,
    }"
  >
    <slot />
  </component>
</template>

