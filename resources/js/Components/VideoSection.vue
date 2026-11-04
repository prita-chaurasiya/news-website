<script setup>
import { ref, computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Play, X, Film, Clock, Eye } from 'lucide-vue-next';
import ResponsiveImage from '@/Components/UI/ResponsiveImage.vue';
import FadeUp from '@/Components/UI/FadeUp.vue';

const props = defineProps({
  videos: {
    type: Array,
    default: () => [],
  },
});

const { locale } = useI18n();
const activeVideo = ref(null);

const safeVideos = computed(() => {
  if (Array.isArray(props.videos)) return props.videos;
  if (props.videos && typeof props.videos === 'object') return Object.values(props.videos);
  return [];
});

const featuredVideo = computed(() => safeVideos.value[0] || null);
const secondaryVideos = computed(() => safeVideos.value.slice(1, 4));

const getTitle = (vid) => {
  if (!vid) return '';
  if (locale.value === 'hi' && vid.title_hi) return vid.title_hi;
  return vid.title;
};

const playVideo = (vid) => {
  activeVideo.value = vid;
};

const closeVideo = () => {
  activeVideo.value = null;
};
</script>

<template>
  <section v-if="safeVideos.length" class="my-12 sm:my-16 py-10 sm:py-12 px-4 sm:px-8 bg-[#0B0F19] text-[#E8EAF0] rounded-xl border border-zinc-800 shadow-2xl">
    <!-- Header -->
    <div class="flex items-center justify-between pb-4 mb-8 border-b border-zinc-800">
      <div class="flex items-center gap-2">
        <Film class="w-4 h-4 text-accent" />
        <h2 class="text-xs font-bold uppercase tracking-widest text-white font-mono">
          {{ $t('home.videosAndMedia') }}
        </h2>
      </div>

      <span class="text-xs text-zinc-400 font-mono tracking-wider">
        CHRONICLE INVESTIGATIVE SHORTS
      </span>
    </div>

    <!-- Video Grid: Large Player Left (7 cols), Playlist Right (5 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
      <!-- Main Featured Player -->
      <div v-if="featuredVideo" class="lg:col-span-7 group cursor-pointer" @click="playVideo(featuredVideo)">
        <div class="relative aspect-video rounded-lg overflow-hidden bg-zinc-900 border border-zinc-800 mb-4 shadow-xl">
          <ResponsiveImage
            :src="featuredVideo.thumbnail"
            :alt="getTitle(featuredVideo)"
            aspect-ratio="16/9"
            :priority="false"
            rounded="rounded-lg"
          >
            <!-- Center Play Button Overlay -->
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center transition-all duration-300 group-hover:bg-black/25">
              <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-accent text-white flex items-center justify-center shadow-2xl transition-all duration-300 group-hover:scale-110 group-hover:bg-accent/90">
                <Play class="w-7 h-7 sm:w-9 sm:h-9 fill-current translate-x-1" />
              </div>
            </div>

            <!-- Duration Badge -->
            <span class="absolute bottom-3 right-3 bg-black/85 text-white text-[11px] font-mono font-bold px-2.5 py-1 rounded shadow-md border border-zinc-700">
              {{ featuredVideo.duration || '08:42' }}
            </span>
          </ResponsiveImage>
        </div>

        <div class="flex items-center gap-3 text-xs text-zinc-400 mb-1 font-mono">
          <span class="text-accent uppercase font-bold tracking-wider">Featured Report</span>
          <span>•</span>
          <span class="flex items-center gap-1">
            <Eye class="w-3 h-3" />
            {{ (featuredVideo.views_count || 12400).toLocaleString() }} views
          </span>
        </div>

        <h3 class="text-xl sm:text-2xl font-serif font-bold text-white group-hover:text-accent transition-colors leading-snug mb-2">
          {{ getTitle(featuredVideo) }}
        </h3>
        <p class="text-xs sm:text-sm text-zinc-300 font-editorial line-clamp-2 leading-relaxed">
          {{ featuredVideo.description }}
        </p>
      </div>

      <!-- Secondary Playlist Column -->
      <div class="lg:col-span-5 space-y-3">
        <div class="pb-2 mb-2 border-b border-zinc-800 flex items-center justify-between text-xs font-mono uppercase tracking-wider text-zinc-400">
          <span>Continuous Queue</span>
          <span>{{ secondaryVideos.length }} Dispatches</span>
        </div>

        <div
          v-for="vid in secondaryVideos"
          :key="vid.id"
          class="group flex gap-3.5 cursor-pointer p-3 rounded-lg hover:bg-zinc-800/60 border border-transparent hover:border-zinc-700/60 transition-all duration-200"
          @click="playVideo(vid)"
        >
          <!-- 16:9 Thumbnail with Mini Play Button -->
          <div class="relative w-36 sm:w-40 aspect-video rounded overflow-hidden bg-zinc-900 flex-shrink-0 border border-zinc-800">
            <ResponsiveImage
              :src="vid.thumbnail"
              :alt="getTitle(vid)"
              aspect-ratio="16/9"
              :priority="false"
              rounded="rounded"
            >
              <div class="absolute inset-0 bg-black/35 flex items-center justify-center group-hover:bg-black/15 transition-colors">
                <div class="w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center shadow-lg transition-transform group-hover:scale-110">
                  <Play class="w-4 h-4 fill-current translate-x-0.5" />
                </div>
              </div>
              <span class="absolute bottom-1.5 right-1.5 bg-black/85 text-[10px] font-mono px-1.5 py-0.5 rounded text-white">
                {{ vid.duration || '04:15' }}
              </span>
            </ResponsiveImage>
          </div>

          <div class="flex-1 min-w-0 flex flex-col justify-center">
            <h4 class="text-xs sm:text-sm font-serif font-bold text-white group-hover:text-accent transition-colors line-clamp-2 leading-snug mb-1">
              {{ getTitle(vid) }}
            </h4>
            <div class="flex items-center gap-2 text-[10px] text-zinc-400 font-mono">
              <span>{{ (vid.views_count || 5200).toLocaleString() }} views</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Interactive Video Player Modal -->
    <Teleport to="body">
      <transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
      >
        <div
          v-if="activeVideo"
          class="fixed inset-0 z-50 bg-black/90 backdrop-blur-md flex items-center justify-center p-4 sm:p-6"
          @click.self="closeVideo"
        >
          <div class="relative w-full max-w-4xl bg-[#111317] rounded-xl overflow-hidden border border-zinc-700 shadow-2xl">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-zinc-950 border-b border-zinc-800">
              <h3 class="font-serif font-bold text-base sm:text-lg text-white truncate pr-4">
                {{ getTitle(activeVideo) }}
              </h3>
              <button
                @click="closeVideo"
                class="w-8 h-8 rounded-full bg-zinc-800 hover:bg-zinc-700 text-white flex items-center justify-center transition-colors flex-shrink-0"
              >
                <X class="w-4 h-4" />
              </button>
            </div>

            <!-- Video Player Stage -->
            <div class="relative aspect-video bg-black">
              <iframe
                v-if="activeVideo.youtube_id"
                :src="`https://www.youtube-nocookie.com/embed/${activeVideo.youtube_id}?autoplay=1&rel=0`"
                class="w-full h-full border-0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
              ></iframe>

              <video
                v-else
                controls
                autoplay
                :poster="activeVideo.thumbnail"
                class="w-full h-full object-cover"
              >
                <source :src="activeVideo.video_url || 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4'" type="video/mp4" />
                Your browser does not support HTML5 video.
              </video>
            </div>

            <!-- Description Under Player -->
            <div class="p-4 sm:p-6 bg-[#0E1015] border-t border-zinc-800 flex items-start justify-between gap-4">
              <div>
                <p class="text-xs sm:text-sm text-zinc-300 font-editorial leading-relaxed">
                  {{ activeVideo.description }}
                </p>
                <span class="text-[11px] font-mono text-zinc-500 mt-2 block">
                  Original Production • The Chronicle Visual Investigations
                </span>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </Teleport>
  </section>
</template>
