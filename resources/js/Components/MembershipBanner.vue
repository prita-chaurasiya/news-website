<script setup>
import { ShieldCheck, Heart } from 'lucide-vue-next';
</script>

<template>
  <div class="my-8 p-6 sm:p-7 bg-[#FFFDF7] dark:bg-zinc-900/90 rounded-lg border-2 border-amber-300 dark:border-amber-500/40 shadow-sm">
    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
      <div class="flex items-start gap-4">
        <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 flex items-center justify-center flex-shrink-0 mt-0.5">
          <Heart class="w-5 h-5 fill-current" />
        </div>
        <div>
          <h3 class="text-base sm:text-lg font-serif font-black text-gray-900 dark:text-white mb-1">
            {{ $t('home.supportTitle') }}
          </h3>
          <p class="text-xs sm:text-sm text-gray-700 dark:text-zinc-300 font-body leading-relaxed max-w-2xl">
            {{ $t('home.supportDesc') }}
          </p>
        </div>
      </div>

      <div class="flex-shrink-0">
        <a
          href="#subscribe"
          class="inline-flex items-center gap-2 bg-[#111111] dark:bg-amber-500 text-white dark:text-black hover:bg-[#C8102E] dark:hover:bg-amber-400 font-bold text-xs uppercase tracking-wider px-6 py-3.5 rounded transition-all shadow"
        >
          <ShieldCheck class="w-4 h-4" />
          <span>{{ $t('home.supportBtn') }}</span>
        </a>
      </div>
    </div>
  </div>
</template>

