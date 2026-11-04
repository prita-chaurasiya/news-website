<script setup>
import { ref, computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link2, Check, Share2 } from 'lucide-vue-next';

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  url: {
    type: String,
    default: '',
  },
});

const { t } = useI18n();
const copied = ref(false);

const shareUrl = computed(() => {
  return props.url || (typeof window !== 'undefined' ? window.location.href : '');
});

const whatsappShare = computed(() => {
  return `https://api.whatsapp.com/send?text=${encodeURIComponent(props.title + ' ' + shareUrl.value)}`;
});

const twitterShare = computed(() => {
  return `https://twitter.com/intent/tweet?text=${encodeURIComponent(props.title)}&url=${encodeURIComponent(shareUrl.value)}`;
});

const facebookShare = computed(() => {
  return `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl.value)}`;
});

const telegramShare = computed(() => {
  return `https://t.me/share/url?url=${encodeURIComponent(shareUrl.value)}&text=${encodeURIComponent(props.title)}`;
});

const copyLink = async () => {
  if (typeof navigator !== 'undefined' && navigator.clipboard) {
    try {
      await navigator.clipboard.writeText(shareUrl.value);
      copied.value = true;
      setTimeout(() => {
        copied.value = false;
      }, 2500);
    } catch (err) {
      console.error('Failed to copy link:', err);
    }
  }
};
</script>

<template>
  <div class="flex items-center gap-1.5 sm:gap-2">
    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 mr-1 hidden sm:inline">
      {{ $t('article.share') }}:
    </span>

    <!-- WhatsApp -->
    <a
      :href="whatsappShare"
      target="_blank"
      rel="noopener noreferrer"
      class="w-8 h-8 rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-600 dark:hover:text-white flex items-center justify-center transition-colors text-xs font-bold"
      title="Share on WhatsApp"
    >
      WA
    </a>

    <!-- X / Twitter -->
    <a
      :href="twitterShare"
      target="_blank"
      rel="noopener noreferrer"
      class="w-8 h-8 rounded-full bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-zinc-300 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black flex items-center justify-center transition-colors text-xs font-bold"
      title="Share on X (Twitter)"
    >
      𝕏
    </a>

    <!-- Facebook -->
    <a
      :href="facebookShare"
      target="_blank"
      rel="noopener noreferrer"
      class="w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white flex items-center justify-center transition-colors text-xs font-bold"
      title="Share on Facebook"
    >
      FB
    </a>

    <!-- Telegram -->
    <a
      :href="telegramShare"
      target="_blank"
      rel="noopener noreferrer"
      class="w-8 h-8 rounded-full bg-sky-50 dark:bg-sky-950/40 text-sky-600 dark:text-sky-400 hover:bg-sky-500 hover:text-white dark:hover:bg-sky-500 dark:hover:text-white flex items-center justify-center transition-colors text-xs font-bold"
      title="Share on Telegram"
    >
      TG
    </a>

    <!-- Copy Link with Toast -->
    <button
      @click="copyLink"
      class="relative w-8 h-8 rounded-full bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-zinc-300 hover:bg-[#C8102E] hover:text-white transition-colors flex items-center justify-center"
      :title="$t('article.copyLink')"
    >
      <Check v-if="copied" class="w-4 h-4 text-emerald-500" />
      <Link2 v-else class="w-4 h-4" />

      <!-- Tooltip Notification -->
      <span
        v-if="copied"
        class="absolute -top-8 left-1/2 -translate-x-1/2 bg-black text-white text-[10px] font-bold px-2 py-0.5 rounded shadow whitespace-nowrap"
      >
        {{ $t('article.linkCopied') }}
      </span>
    </button>
  </div>
</template>

