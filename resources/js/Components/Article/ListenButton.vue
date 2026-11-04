<script setup>
import { ref, onUnmounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { Headphones, Square, Play, Pause } from 'lucide-vue-next';

const props = defineProps({
  text: {
    type: String,
    required: true,
  },
  title: {
    type: String,
    default: '',
  },
});

const { locale, t } = useI18n();

const isPlaying = ref(false);
const isPaused = ref(false);
let utterance = null;

const cleanTextForSpeech = (html) => {
  const tmp = document.createElement('div');
  tmp.innerHTML = html;
  const rawText = tmp.textContent || tmp.innerText || '';
  return `${props.title}. ${rawText}`.replace(/\s+/g, ' ').trim();
};

const startAudio = () => {
  if (typeof window === 'undefined' || !('speechSynthesis' in window)) {
    alert('Web Speech Audio is not supported in this browser.');
    return;
  }

  if (isPaused.value) {
    window.speechSynthesis.resume();
    isPlaying.value = true;
    isPaused.value = false;
    return;
  }

  window.speechSynthesis.cancel();

  const readableText = cleanTextForSpeech(props.text);
  utterance = new SpeechSynthesisUtterance(readableText);

  // Configure voice based on current locale
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
    isPlaying.value = true;
    isPaused.value = false;
  };

  utterance.onend = () => {
    isPlaying.value = false;
    isPaused.value = false;
  };

  utterance.onerror = (e) => {
    console.error('Speech synthesis error:', e);
    isPlaying.value = false;
    isPaused.value = false;
  };

  window.speechSynthesis.speak(utterance);
};

const pauseAudio = () => {
  if (typeof window !== 'undefined' && 'speechSynthesis' in window) {
    window.speechSynthesis.pause();
    isPlaying.value = false;
    isPaused.value = true;
  }
};

const stopAudio = () => {
  if (typeof window !== 'undefined' && 'speechSynthesis' in window) {
    window.speechSynthesis.cancel();
    isPlaying.value = false;
    isPaused.value = false;
  }
};

onUnmounted(() => {
  if (typeof window !== 'undefined' && 'speechSynthesis' in window) {
    window.speechSynthesis.cancel();
  }
});
</script>

<template>
  <div class="inline-flex items-center gap-1.5 bg-gray-100 dark:bg-zinc-800 rounded-full py-1 px-3 border border-gray-200 dark:border-zinc-700 text-xs">
    <!-- Play / Pause Button -->
    <button
      v-if="!isPlaying"
      @click="startAudio"
      class="flex items-center gap-1.5 font-semibold text-gray-800 dark:text-zinc-200 hover:text-[#C8102E] transition-colors"
      :title="$t('article.listen')"
    >
      <Headphones class="w-3.5 h-3.5 text-[#C8102E]" />
      <span>{{ isPaused ? 'Resume' : $t('article.listen') }}</span>
    </button>

    <button
      v-else
      @click="pauseAudio"
      class="flex items-center gap-1.5 font-semibold text-[#C8102E] transition-colors"
    >
      <!-- Animated Equalizer Waveform -->
      <span class="flex items-end gap-0.5 h-3.5 mr-0.5">
        <span class="w-0.5 bg-[#C8102E] animate-pulse h-3"></span>
        <span class="w-0.5 bg-[#C8102E] animate-pulse h-1.5"></span>
        <span class="w-0.5 bg-[#C8102E] animate-pulse h-3.5"></span>
      </span>
      <span>{{ $t('article.listening') }}</span>
    </button>

    <!-- Stop Button (shown while active or paused) -->
    <button
      v-if="isPlaying || isPaused"
      @click="stopAudio"
      class="ml-1 p-1 hover:text-[#C8102E] transition-colors text-gray-500"
      :title="$t('article.stopAudio')"
    >
      <Square class="w-3 h-3 fill-current" />
    </button>
  </div>
</template>

