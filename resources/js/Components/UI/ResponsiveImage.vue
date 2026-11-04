<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  src: {
    type: String,
    required: true,
  },
  alt: {
    type: String,
    default: '',
  },
  aspectRatio: {
    type: String,
    default: '16/9', // 'hero', '16/9', '3/2', '1/1', 'square', 'circle', 'auto'
  },
  priority: {
    type: Boolean,
    default: false,
  },
  caption: {
    type: String,
    default: '',
  },
  credit: {
    type: String,
    default: '',
  },
  overlay: {
    type: Boolean,
    default: false,
  },
  rounded: {
    type: String,
    default: 'rounded-lg',
  },
  imgClass: {
    type: String,
    default: '',
  },
});

const isLoaded = ref(false);
const hasError = ref(false);
const currentSrc = ref(props.src);

// Neutral real photo fallback if image fails to load
const fallbackPhoto = 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=800&q=80';

const handleError = (e) => {
  if (!hasError.value) {
    hasError.value = true;
    currentSrc.value = fallbackPhoto;
    isLoaded.value = true;
  }
};

const aspectClass = computed(() => {
  switch (props.aspectRatio) {
    case 'hero':
      return 'aspect-[16/9] lg:aspect-[21/9]';
    case '16/9':
      return 'aspect-[16/9]';
    case '3/2':
      return 'aspect-[3/2]';
    case '1/1':
    case 'square':
    case 'circle':
    case 'circular':
      return 'aspect-square';
    case '4/3':
      return 'aspect-[4/3]';
    case 'auto':
      return '';
    default:
      return `aspect-[${props.aspectRatio}]`;
  }
});

// Auto-derive 400w, 800w, 1600w srcset if it's local WebP or Unsplash
const imageSrcset = computed(() => {
  if (hasError.value) return '';
  const url = currentSrc.value;
  if (!url) return '';

  if (url.includes('-1600.webp')) {
    const base = url.replace('-1600.webp', '');
    return `${base}-400.webp 400w, ${base}-800.webp 800w, ${base}-1600.webp 1600w`;
  }

  if (url.includes('images.unsplash.com')) {
    const clean = url.split('?')[0];
    return `${clean}?auto=format&fit=crop&w=400&q=80 400w, ${clean}?auto=format&fit=crop&w=800&q=80 800w, ${clean}?auto=format&fit=crop&w=1600&q=80 1600w`;
  }

  return '';
});

const imageSizes = computed(() => {
  if (props.aspectRatio === '1/1' || props.aspectRatio === 'square' || props.aspectRatio === 'circle') {
    return '(max-width: 640px) 96px, 128px';
  }
  if (props.aspectRatio === 'hero' || props.aspectRatio === '16/9') {
    return '(max-width: 768px) 100vw, (max-width: 1200px) 70vw, 1200px';
  }
  return '(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 600px';
});

const computedAlt = computed(() => {
  return props.alt || 'The Chronicle Editorial Dispatch';
});
</script>

<template>
  <figure class="group/resp block w-full">
    <!-- Image Box with Aspect Ratio and Blur-up Transition -->
    <div
      :class="[
        aspectClass,
        rounded,
        'relative overflow-hidden bg-surface border border-border/60 w-full'
      ]"
    >
      <img
        :src="currentSrc"
        :srcset="imageSrcset"
        :sizes="imageSizes"
        :alt="computedAlt"
        :loading="priority ? 'eager' : 'lazy'"
        :fetchpriority="priority ? 'high' : 'auto'"
        @load="isLoaded = true"
        @error="handleError"
        :class="[
          'w-full h-full object-cover transition-all duration-700 ease-out group-hover/resp:scale-105',
          isLoaded ? 'opacity-100 blur-0 scale-100' : 'opacity-70 blur-xs scale-102',
          imgClass
        ]"
      />

      <!-- Subtle Gradient Overlay (Lead stories / Guardian / Bloomberg style) -->
      <div
        v-if="overlay"
        class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/25 to-transparent pointer-events-none transition-opacity duration-300"
      ></div>

      <!-- Foreground slot for badges or overlays -->
      <slot />
    </div>

    <!-- Caption & Credit Line -->
    <figcaption
      v-if="caption || credit || $slots.caption"
      class="mt-2 text-[11px] text-muted italic font-sans flex items-center justify-between gap-4 leading-normal"
    >
      <slot name="caption">
        <span class="truncate">{{ caption }}</span>
        <span v-if="credit" class="flex-shrink-0 font-sans font-medium not-italic text-[10px] uppercase tracking-wider text-muted">
          {{ credit }}
        </span>
      </slot>
    </figcaption>
  </figure>
</template>
