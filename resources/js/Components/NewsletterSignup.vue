<script setup>
import { ref } from 'vue';
import { Mail, CheckCircle, ArrowRight } from 'lucide-vue-next';

const email = ref('');
const isSubmitted = ref(false);
const isLoading = ref(false);

const handleSubscribe = () => {
  if (!email.value || !email.value.includes('@')) return;
  isLoading.value = true;
  setTimeout(() => {
    isLoading.value = false;
    isSubmitted.value = true;
    email.value = '';
  }, 600);
};
</script>

<template>
  <div class="my-8 p-6 sm:p-8 bg-zinc-900 text-white rounded-lg border border-zinc-800">
    <div class="max-w-2xl mx-auto text-center">
      <div class="w-10 h-10 rounded-full bg-[#C8102E] text-white mx-auto flex items-center justify-center mb-3">
        <Mail class="w-5 h-5" />
      </div>

      <h3 class="text-xl sm:text-2xl font-serif font-black mb-2">
        {{ $t('home.newsletterTitle') }}
      </h3>
      <p class="text-xs sm:text-sm text-zinc-300 font-body mb-6 leading-relaxed">
        {{ $t('home.newsletterSubtitle') }}
      </p>

      <div v-if="isSubmitted" class="p-3 bg-emerald-950/60 border border-emerald-500/50 rounded text-emerald-300 text-xs font-semibold flex items-center justify-center gap-2">
        <CheckCircle class="w-4 h-4 text-emerald-400" />
        <span>{{ $t('home.subscribeSuccess') }}</span>
      </div>

      <form v-else @submit.prevent="handleSubscribe" class="flex flex-col sm:flex-row gap-2 max-w-md mx-auto">
        <input
          v-model="email"
          type="email"
          required
          :placeholder="$t('home.newsletterPlaceholder')"
          class="flex-1 px-4 py-3 rounded bg-zinc-800 border border-zinc-700 text-white placeholder-zinc-400 text-xs focus:outline-none focus:border-[#C8102E]"
        />
        <button
          type="submit"
          :disabled="isLoading"
          class="bg-[#C8102E] hover:bg-[#A00D24] text-white font-bold text-xs uppercase tracking-wider px-6 py-3 rounded transition-colors flex items-center justify-center gap-2 flex-shrink-0 disabled:opacity-50"
        >
          <span>{{ $t('home.subscribeNewsletter') }}</span>
          <ArrowRight class="w-3.5 h-3.5" />
        </button>
      </form>
    </div>
  </div>
</template>

