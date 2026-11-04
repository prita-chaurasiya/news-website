<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
</script>

<template>
  <MainLayout>
    <Head>
      <title>Terms of Service — The Chronicle</title>
    </Head>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">
      <div class="pb-6 border-b border-gray-200 dark:border-zinc-800 mb-8">
        <span class="text-xs font-mono font-bold uppercase tracking-widest text-[#C8102E]">
          LEGAL AGREEMENT
        </span>
        <h1 class="text-3xl sm:text-4xl font-serif font-black text-gray-900 dark:text-white mt-1 mb-2">
          Terms of Service
        </h1>
        <p class="text-xs text-gray-400">Effective: November 2026</p>
      </div>

      <div class="prose prose-stone dark:prose-invert max-w-none font-body text-sm sm:text-base leading-relaxed space-y-6">
        <h3>1. Intellectual Property & Copyright</h3>
        <p>
          All reporting, photographic essays, original typography, graphic layouts, and video documentaries published on <em>The Chronicle</em> are protected under domestic and international copyright treaties. Unauthorized web scraping, automated AI training mirroring, or commercial republishing without explicit licensing agreements is strictly prohibited.
        </p>

        <h3>2. Reader Commenting & Discussion Standards</h3>
        <p>
          We welcome vibrant intellectual debate in our reader discussion forums. However, hate speech, defamation, commercial solicitation, personal doxxing, or harassment will result in immediate comment removal and permanent account suspension.
        </p>

        <h3>3. Subscriptions & Billing</h3>
        <p>
          Digital subscriptions renew automatically at the conclusion of each billing cycle unless canceled prior to the renewal date. You may cancel your subscription at any time via your account settings.
        </p>
      </div>
    </div>
  </MainLayout>
</template>
