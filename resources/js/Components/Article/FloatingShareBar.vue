<script setup>
import { ref, computed, onUnmounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { useNewsStore } from '@/stores/newsStore';
import {
  Headphones,
  Bookmark,
  Share2,
  Link2,
  Check,
  MessageCircle,
} from 'lucide-vue-next';

const props = defineProps({
  articleId: {
    type: Number,
    required: true,
  },
  title: {
    type: String,
    required: true,
  },
  content: {
    type: String,
    required: true,
  },
  url: {
    type: String,
    default: '',
  },
  layout: {
    type: String,
    default: 'all', // 'all', 'desktop', 'mobile'
  },
});

const { locale } = useI18n();
const page = usePage();
const newsStore = useNewsStore();

// Copy link state
const copied = ref(false);

// Mobile share drawer / sheet
const isShareDrawerOpen = ref(false);

// Web Speech Audio State
const isAudioPlaying = ref(false);
let utterance = null;

const isSaved = computed(() => newsStore.isBookmarked(props.articleId));

const shareUrl = computed(() => {
  return props.url || (typeof window !== 'undefined' ? window.location.href : '');
});

// Clean text for speech synthesis
const cleanTextForSpeech = (html) => {
  if (typeof document === 'undefined') return props.title;
  const tmp = document.createElement('div');
  tmp.innerHTML = html;
  const rawText = tmp.textContent || tmp.innerText || '';
  return `${props.title}. ${rawText}`.replace(/\s+/g, ' ').trim();
};

const toggleAudio = () => {
  if (typeof window === 'undefined' || !('speechSynthesis' in window)) {
    alert('Web Speech Audio is not supported in this browser.');
    return;
  }

  if (isAudioPlaying.value) {
    window.speechSynthesis.cancel();
    isAudioPlaying.value = false;
    return;
  }

  window.speechSynthesis.cancel();
  const readable = cleanTextForSpeech(props.content);
  utterance = new SpeechSynthesisUtterance(readable);

  const voices = window.speechSynthesis.getVoices();
  if (locale.value === 'hi') {
    utterance.lang = 'hi-IN';
    const hiVoice = voices.find((v) => v.lang.includes('hi') || v.name.includes('Hindi'));
    if (hiVoice) utterance.voice = hiVoice;
  } else {
    utterance.lang = 'en-US';
    const enVoice = voices.find((v) => v.lang.includes('en-IN') || v.lang.includes('en-US'));
    if (enVoice) utterance.voice = enVoice;
  }

  utterance.rate = 0.95;
  utterance.pitch = 1.0;

  utterance.onstart = () => {
    isAudioPlaying.value = true;
  };

  utterance.onend = () => {
    isAudioPlaying.value = false;
  };

  utterance.onerror = () => {
    isAudioPlaying.value = false;
  };

  window.speechSynthesis.speak(utterance);
};

onUnmounted(() => {
  if (typeof window !== 'undefined' && 'speechSynthesis' in window) {
    window.speechSynthesis.cancel();
  }
});

const toggleBookmark = async () => {
  newsStore.toggleBookmark(props.articleId);
  if (page.props.auth?.user) {
    try {
      await axios.post(`/article/${props.articleId}/bookmark`);
    } catch (err) {
      console.error('Bookmark sync error:', err);
    }
  }
};

const copyShareLink = async () => {
  if (typeof navigator !== 'undefined' && navigator.clipboard) {
    try {
      await navigator.clipboard.writeText(shareUrl.value);
      copied.value = true;
      setTimeout(() => {
        copied.value = false;
      }, 2500);
    } catch (e) {
      console.error('Clipboard copy failed:', e);
    }
  }
};

const shareNative = async () => {
  if (typeof navigator !== 'undefined' && navigator.share) {
    try {
      await navigator.share({
        title: props.title,
        url: shareUrl.value,
      });
    } catch (e) {
      // User cancelled
    }
  } else {
    isShareDrawerOpen.value = true;
  }
};
</script>

<template>
  <div>
    <!-- ============================================== -->
    <!-- 1. DESKTOP FLOATING VERTICAL SHARE BAR         -->
    <!-- 64px width, hairline border, no heavy shadow,  -->
    <!-- hidden below 1024px                            -->
    <!-- ============================================== -->
    <aside
      v-if="layout === 'all' || layout === 'desktop'"
      aria-label="Article utilities and share actions"
      class="hidden lg:flex flex-col items-center gap-2 p-2 w-16 bg-surface/90 dark:bg-zinc-900/90 backdrop-blur-md rounded-2xl border border-border dark:border-zinc-800 shadow-none transition-all duration-300"
    >
      <!-- Audio Reader -->
      <button
        @click="toggleAudio"
        type="button"
        class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-200 group relative"
        :class="isAudioPlaying
          ? 'bg-[#C8102E] text-white shadow-none'
          : 'bg-white dark:bg-zinc-800 text-gray-700 dark:text-zinc-300 hover:text-[#C8102E] hover:border-[#C8102E] border border-border/80'"
        :title="isAudioPlaying ? 'Stop reading' : 'Listen to article'"
      >
        <span v-if="isAudioPlaying" class="flex items-end gap-0.5 h-3.5">
          <span class="w-0.5 bg-white animate-pulse h-3"></span>
          <span class="w-0.5 bg-white animate-pulse h-1.5"></span>
          <span class="w-0.5 bg-white animate-pulse h-3.5"></span>
        </span>
        <Headphones v-else class="w-4 h-4 transition-transform group-hover:scale-110" />

        <!-- Tooltip -->
        <span class="absolute left-14 px-2 py-1 bg-ink text-white text-[10px] font-sans font-medium rounded opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity whitespace-nowrap z-30 shadow-sm">
          {{ isAudioPlaying ? 'Stop Audio' : 'Listen (Web Speech)' }}
        </span>
      </button>

      <!-- Bookmark / Save -->
      <button
        @click="toggleBookmark"
        type="button"
        class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-200 group relative"
        :class="isSaved
          ? 'bg-red-50 dark:bg-red-950/40 text-[#C8102E] border-2 border-[#C8102E]'
          : 'bg-white dark:bg-zinc-800 border border-border/80 text-gray-700 dark:text-zinc-300 hover:text-[#C8102E] hover:border-[#C8102E]'"
        :title="isSaved ? 'Story Saved' : 'Save Story'"
      >
        <Bookmark class="w-4 h-4 transition-transform group-hover:scale-110" :class="{ 'fill-[#C8102E]': isSaved }" />

        <span class="absolute left-14 px-2 py-1 bg-ink text-white text-[10px] font-sans font-medium rounded opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity whitespace-nowrap z-30 shadow-sm">
          {{ isSaved ? 'Story Saved' : 'Save for Later' }}
        </span>
      </button>

      <!-- Divider -->
      <div class="w-8 h-[1px] bg-border dark:bg-zinc-800 my-1"></div>

      <!-- Font Size Stepper (A- / A+) Capped between 90% and 130% -->
      <div class="w-full flex flex-col items-center gap-1 py-1.5 px-1 bg-white dark:bg-zinc-800 rounded-xl border border-border/80">
        <button
          @click="newsStore.increaseFontSize"
          :disabled="newsStore.fontSizeScale >= 1.30"
          type="button"
          class="w-8 h-7 rounded flex items-center justify-center font-serif font-black text-xs text-gray-700 dark:text-zinc-200 hover:text-[#C8102E] disabled:opacity-30 disabled:pointer-events-none transition-colors"
          title="Increase font size (A+)"
        >
          A+
        </button>
        <span class="text-[9px] font-sans font-bold text-muted tabular-nums leading-none select-none">
          {{ Math.round(newsStore.fontSizeScale * 100) }}%
        </span>
        <button
          @click="newsStore.decreaseFontSize"
          :disabled="newsStore.fontSizeScale <= 0.90"
          type="button"
          class="w-8 h-7 rounded flex items-center justify-center font-serif font-black text-xs text-gray-700 dark:text-zinc-200 hover:text-[#C8102E] disabled:opacity-30 disabled:pointer-events-none transition-colors"
          title="Decrease font size (A-)"
        >
          A−
        </button>
      </div>

      <!-- Divider -->
      <div class="w-8 h-[1px] bg-border dark:bg-zinc-800 my-1"></div>

      <!-- WhatsApp -->
      <a
        :href="`https://api.whatsapp.com/send?text=${encodeURIComponent(title + ' ' + shareUrl)}`"
        target="_blank"
        rel="noopener noreferrer"
        class="w-10 h-10 rounded-full bg-white dark:bg-zinc-800 border border-border/80 text-gray-700 dark:text-zinc-300 hover:text-[#25D366] hover:border-[#25D366] flex items-center justify-center transition-all duration-200 group relative"
        title="Share on WhatsApp"
      >
        <MessageCircle class="w-4 h-4" />
        <span class="absolute left-14 px-2 py-1 bg-ink text-white text-[10px] font-sans font-medium rounded opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity whitespace-nowrap z-30 shadow-sm">
          WhatsApp
        </span>
      </a>

      <!-- X / Twitter -->
      <a
        :href="`https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(shareUrl)}`"
        target="_blank"
        rel="noopener noreferrer"
        class="w-10 h-10 rounded-full bg-white dark:bg-zinc-800 border border-border/80 text-gray-700 dark:text-zinc-300 hover:text-black dark:hover:text-white hover:border-black flex items-center justify-center transition-all duration-200 group relative"
        title="Share on X"
      >
        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        <span class="absolute left-14 px-2 py-1 bg-ink text-white text-[10px] font-sans font-medium rounded opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity whitespace-nowrap z-30 shadow-sm">
          Share on X
        </span>
      </a>

      <!-- Facebook -->
      <a
        :href="`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}`"
        target="_blank"
        rel="noopener noreferrer"
        class="w-10 h-10 rounded-full bg-white dark:bg-zinc-800 border border-border/80 text-gray-700 dark:text-zinc-300 hover:text-[#1877F2] hover:border-[#1877F2] flex items-center justify-center transition-all duration-200 group relative"
        title="Share on Facebook"
      >
        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
        <span class="absolute left-14 px-2 py-1 bg-ink text-white text-[10px] font-sans font-medium rounded opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity whitespace-nowrap z-30 shadow-sm">
          Facebook
        </span>
      </a>

      <!-- Copy Link -->
      <button
        @click="copyShareLink"
        type="button"
        class="w-10 h-10 rounded-full bg-white dark:bg-zinc-800 border border-border/80 text-gray-700 dark:text-zinc-300 hover:text-[#C8102E] hover:border-[#C8102E] flex items-center justify-center transition-all duration-200 group relative"
        title="Copy Link"
      >
        <component :is="copied ? Check : Link2" class="w-4 h-4" :class="{ 'text-emerald-600': copied }" />

        <span
          class="absolute left-14 px-2 py-1 text-[10px] font-sans font-medium rounded transition-opacity whitespace-nowrap z-30 shadow-sm"
          :class="copied ? 'bg-emerald-600 text-white opacity-100' : 'bg-ink text-white opacity-0 pointer-events-none group-hover:opacity-100'"
        >
          {{ copied ? 'Link Copied!' : 'Copy Link' }}
        </span>
      </button>
    </aside>

    <!-- ============================================== -->
    <!-- 2. MOBILE FIXED BOTTOM ACTION BAR              -->
    <!-- Active on < 1024px mobile & tablet             -->
    <!-- ============================================== -->
    <nav
      v-if="layout === 'all' || layout === 'mobile'"
      aria-label="Mobile reading controls"
      class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-white/95 dark:bg-[#0B0F19]/95 backdrop-blur-md border-t border-border px-4 py-2 flex items-center justify-around shadow-md"
    >
      <!-- Listen Audio -->
      <button
        @click="toggleAudio"
        type="button"
        class="flex flex-col items-center gap-0.5 text-[10px] font-sans font-bold uppercase tracking-wider"
        :class="isAudioPlaying ? 'text-[#C8102E]' : 'text-gray-600 dark:text-zinc-400 hover:text-[#C8102E]'"
      >
        <span v-if="isAudioPlaying" class="flex items-end gap-0.5 h-4 mb-0.5">
          <span class="w-0.5 bg-[#C8102E] animate-pulse h-3"></span>
          <span class="w-0.5 bg-[#C8102E] animate-pulse h-1.5"></span>
          <span class="w-0.5 bg-[#C8102E] animate-pulse h-3.5"></span>
        </span>
        <Headphones v-else class="w-4 h-4 mb-0.5" />
        <span>{{ isAudioPlaying ? 'Playing' : 'Listen' }}</span>
      </button>

      <!-- Font Size Stepper (A- / A+) -->
      <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-zinc-100 dark:bg-zinc-800 border border-border/60">
        <button
          @click="newsStore.decreaseFontSize"
          :disabled="newsStore.fontSizeScale <= 0.90"
          type="button"
          class="text-xs font-serif font-black px-1 text-gray-700 dark:text-zinc-300 disabled:opacity-30"
          title="Decrease font size"
        >
          A−
        </button>
        <span class="text-[10px] font-sans font-bold text-muted tabular-nums select-none">
          {{ Math.round(newsStore.fontSizeScale * 100) }}%
        </span>
        <button
          @click="newsStore.increaseFontSize"
          :disabled="newsStore.fontSizeScale >= 1.30"
          type="button"
          class="text-xs font-serif font-black px-1 text-gray-700 dark:text-zinc-300 disabled:opacity-30"
          title="Increase font size"
        >
          A+
        </button>
      </div>

      <!-- Bookmark Toggle -->
      <button
        @click="toggleBookmark"
        type="button"
        class="flex flex-col items-center gap-0.5 text-[10px] font-sans font-bold uppercase tracking-wider"
        :class="isSaved ? 'text-[#C8102E]' : 'text-gray-600 dark:text-zinc-400 hover:text-[#C8102E]'"
      >
        <Bookmark class="w-4 h-4 mb-0.5" :class="{ 'fill-[#C8102E]': isSaved }" />
        <span>{{ isSaved ? 'Saved' : 'Save' }}</span>
      </button>

      <!-- Share Native or Sheet -->
      <button
        @click="shareNative"
        type="button"
        class="flex flex-col items-center gap-0.5 text-[10px] font-sans font-bold uppercase tracking-wider text-gray-600 dark:text-zinc-400 hover:text-[#C8102E]"
      >
        <Share2 class="w-4 h-4 mb-0.5" />
        <span>Share</span>
      </button>
    </nav>

    <!-- Mobile Share Sheet Modal (Fallback if navigator.share is unavailable) -->
    <Teleport to="body">
      <div
        v-if="isShareDrawerOpen"
        class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-end justify-center sm:items-center p-0 sm:p-4"
        @click.self="isShareDrawerOpen = false"
      >
        <div class="w-full max-w-sm bg-white dark:bg-zinc-900 rounded-t-2xl sm:rounded-2xl p-6 shadow-2xl border border-border text-center animate-in slide-in-from-bottom">
          <h3 class="font-serif font-black text-lg text-ink dark:text-white mb-2">Share this Dispatch</h3>
          <p class="text-xs text-muted mb-6 truncate font-sans">{{ title }}</p>

          <div class="grid grid-cols-4 gap-3 mb-6">
            <a
              :href="`https://api.whatsapp.com/send?text=${encodeURIComponent(title + ' ' + shareUrl)}`"
              target="_blank"
              class="flex flex-col items-center gap-1.5 p-2 rounded-lg hover:bg-black/5"
            >
              <div class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center">
                <MessageCircle class="w-5 h-5" />
              </div>
              <span class="text-[10px] font-sans font-bold">WhatsApp</span>
            </a>

            <a
              :href="`https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(shareUrl)}`"
              target="_blank"
              class="flex flex-col items-center gap-1.5 p-2 rounded-lg hover:bg-black/5"
            >
              <div class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
              </div>
              <span class="text-[10px] font-sans font-bold">X</span>
            </a>

            <a
              :href="`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}`"
              target="_blank"
              class="flex flex-col items-center gap-1.5 p-2 rounded-lg hover:bg-black/5"
            >
              <div class="w-10 h-10 rounded-full bg-[#1877F2] text-white flex items-center justify-center">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              </div>
              <span class="text-[10px] font-sans font-bold">Facebook</span>
            </a>

            <button
              @click="copyShareLink"
              type="button"
              class="flex flex-col items-center gap-1.5 p-2 rounded-lg hover:bg-black/5"
            >
              <div class="w-10 h-10 rounded-full bg-zinc-200 dark:bg-zinc-800 text-ink dark:text-white flex items-center justify-center">
                <component :is="copied ? Check : Link2" class="w-5 h-5" :class="{ 'text-emerald-600': copied }" />
              </div>
              <span class="text-[10px] font-sans font-bold">{{ copied ? 'Copied!' : 'Copy Link' }}</span>
            </button>
          </div>

          <button
            @click="isShareDrawerOpen = false"
            type="button"
            class="w-full py-2.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-ink dark:text-white text-xs font-sans font-bold uppercase tracking-wider"
          >
            Cancel
          </button>
        </div>
      </div>
    </Teleport>
  </div>
</template>
