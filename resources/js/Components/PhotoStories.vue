<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { Camera, Image as ImageIcon, X, ChevronLeft, ChevronRight, Maximize2 } from 'lucide-vue-next';
import ResponsiveImage from '@/Components/UI/ResponsiveImage.vue';
import FadeUp from '@/Components/UI/FadeUp.vue';

const props = defineProps({
  galleries: {
    type: Array,
    default: () => [],
  },
});

const { locale } = useI18n();

const safeGalleries = computed(() => {
  if (Array.isArray(props.galleries)) return props.galleries;
  return [];
});

const activeGallery = ref(null);
const currentPhotoIndex = ref(0);

const getTitle = (gal) => {
  if (!gal) return '';
  if (locale.value === 'hi' && gal.title_hi) return gal.title_hi;
  return gal.title;
};

const getPhotos = (gal) => {
  if (!gal) return [];
  if (Array.isArray(gal.photos) && gal.photos.length) return gal.photos;
  return [
    { url: gal.cover_image, caption: gal.description || 'Editorial field photo.' },
    { url: gal.cover_image, caption: 'Special documentary photography series.' },
  ];
};

const openLightbox = (gal, idx = 0) => {
  activeGallery.value = gal;
  currentPhotoIndex.value = idx;
};

const closeLightbox = () => {
  activeGallery.value = null;
  currentPhotoIndex.value = 0;
};

const nextPhoto = () => {
  if (!activeGallery.value) return;
  const list = getPhotos(activeGallery.value);
  currentPhotoIndex.value = (currentPhotoIndex.value + 1) % list.length;
};

const prevPhoto = () => {
  if (!activeGallery.value) return;
  const list = getPhotos(activeGallery.value);
  currentPhotoIndex.value = (currentPhotoIndex.value - 1 + list.length) % list.length;
};

const handleKeyDown = (e) => {
  if (!activeGallery.value) return;
  if (e.key === 'Escape') closeLightbox();
  if (e.key === 'ArrowRight') nextPhoto();
  if (e.key === 'ArrowLeft') prevPhoto();
};

onMounted(() => {
  if (typeof window !== 'undefined') {
    window.addEventListener('keydown', handleKeyDown);
  }
});

onUnmounted(() => {
  if (typeof window !== 'undefined') {
    window.removeEventListener('keydown', handleKeyDown);
  }
});
</script>

<template>
  <section v-if="safeGalleries.length" class="my-12 sm:my-16 py-8 border-y-2 border-ink">
    <!-- Section Header -->
    <div class="flex items-center justify-between pb-4 mb-8 border-b border-border">
      <div class="flex items-center gap-2">
        <Camera class="w-4 h-4 text-accent" />
        <h2 class="text-xs font-bold uppercase tracking-widest text-ink font-mono">
          {{ $t('home.photoStories') }}
        </h2>
      </div>
      <span class="text-xs text-muted font-mono tracking-wider">VISUAL DISPATCHES</span>
    </div>

    <!-- Masonry-Style Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <FadeUp
        v-for="(gal, idx) in safeGalleries"
        :key="gal.id"
        :delay="idx * 120"
      >
        <div
          class="group relative rounded-lg overflow-hidden bg-surface border border-border shadow-sm cursor-pointer hover:shadow-editorial-hover transition-all duration-300"
          @click="openLightbox(gal, 0)"
        >
          <!-- Cover Image via ResponsiveImage -->
          <ResponsiveImage
            :src="gal.cover_image"
            :alt="getTitle(gal)"
            aspect-ratio="16/9"
            :priority="false"
            :overlay="true"
            rounded="rounded-none"
          >
            <!-- Badge on Image -->
            <div class="absolute top-3 left-3 z-10 flex items-center gap-1.5 bg-black/70 backdrop-blur-md text-[10px] font-mono font-bold uppercase tracking-widest text-amber-400 px-2.5 py-1 rounded border border-amber-400/30">
              <ImageIcon class="w-3 h-3" />
              <span>{{ getPhotos(gal).length }} PHOTOS</span>
            </div>

            <!-- Expand Hover Indicator -->
            <div class="absolute top-3 right-3 z-10 opacity-0 group-hover:opacity-100 transition-opacity bg-black/60 text-white p-1.5 rounded-full">
              <Maximize2 class="w-3.5 h-3.5" />
            </div>

            <!-- Gradient Caption Overlay -->
            <div class="absolute inset-x-0 bottom-0 p-5 text-white bg-gradient-to-t from-black/90 via-black/40 to-transparent">
              <h3 class="text-base sm:text-lg font-serif font-bold text-white group-hover:text-amber-300 transition-colors leading-snug">
                {{ getTitle(gal) }}
              </h3>
              <p class="text-xs text-zinc-300 mt-1 font-editorial line-clamp-2">
                {{ gal.description }}
              </p>
            </div>
          </ResponsiveImage>
        </div>
      </FadeUp>
    </div>

    <!-- FULLSCREEN LIGHTBOX MODAL -->
    <Teleport to="body">
      <transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div
          v-if="activeGallery"
          class="fixed inset-0 z-50 bg-black/95 backdrop-blur-md flex flex-col justify-between p-4 sm:p-6 text-white"
          @click.self="closeLightbox"
        >
          <!-- Lightbox Top Bar -->
          <div class="flex items-center justify-between pb-4 border-b border-zinc-800">
            <div>
              <span class="text-[11px] font-mono uppercase tracking-widest text-accent font-bold">
                PHOTO ESSAY • LIGHTBOX
              </span>
              <h3 class="font-serif font-black text-lg sm:text-xl text-white">
                {{ getTitle(activeGallery) }}
              </h3>
            </div>

            <div class="flex items-center gap-4">
              <span class="font-mono text-xs text-zinc-400">
                {{ currentPhotoIndex + 1 }} / {{ getPhotos(activeGallery).length }}
              </span>
              <button
                @click="closeLightbox"
                class="p-2 rounded-full bg-zinc-800 hover:bg-zinc-700 text-white transition-colors"
                aria-label="Close Lightbox"
              >
                <X class="w-5 h-5" />
              </button>
            </div>
          </div>

          <!-- Main Stage with Image & Controls -->
          <div class="relative flex-1 flex items-center justify-center my-4 overflow-hidden">
            <button
              v-if="getPhotos(activeGallery).length > 1"
              @click="prevPhoto"
              class="absolute left-2 sm:left-6 z-20 w-11 h-11 rounded-full bg-black/60 hover:bg-black/90 text-white flex items-center justify-center border border-zinc-700 transition-colors"
              aria-label="Previous Photo"
            >
              <ChevronLeft class="w-6 h-6" />
            </button>

            <!-- Current Slide Image -->
            <div class="max-w-5xl max-h-[75vh] flex flex-col items-center">
              <img
                :src="getPhotos(activeGallery)[currentPhotoIndex]?.url || activeGallery.cover_image"
                :alt="getTitle(activeGallery)"
                class="max-h-[65vh] w-auto max-w-full object-contain rounded shadow-2xl transition-all duration-300"
              />
              <p class="mt-3 text-xs sm:text-sm text-zinc-300 font-editorial italic text-center max-w-2xl px-4">
                {{ getPhotos(activeGallery)[currentPhotoIndex]?.caption || activeGallery.description }}
              </p>
            </div>

            <button
              v-if="getPhotos(activeGallery).length > 1"
              @click="nextPhoto"
              class="absolute right-2 sm:right-6 z-20 w-11 h-11 rounded-full bg-black/60 hover:bg-black/90 text-white flex items-center justify-center border border-zinc-700 transition-colors"
              aria-label="Next Photo"
            >
              <ChevronRight class="w-6 h-6" />
            </button>
          </div>

          <!-- Lightbox Bottom Filmstrip -->
          <div class="pt-3 border-t border-zinc-800 flex items-center justify-center gap-3 overflow-x-auto no-scrollbar py-2">
            <button
              v-for="(photo, pIdx) in getPhotos(activeGallery)"
              :key="pIdx"
              @click="currentPhotoIndex = pIdx"
              class="w-16 h-11 rounded overflow-hidden border-2 transition-all flex-shrink-0"
              :class="currentPhotoIndex === pIdx ? 'border-accent scale-105 opacity-100' : 'border-transparent opacity-50 hover:opacity-80'"
            >
              <img :src="photo.url" class="w-full h-full object-cover" />
            </button>
          </div>
        </div>
      </transition>
    </Teleport>
  </section>
</template>
