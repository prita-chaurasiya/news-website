<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
</script>

<template>
  <MainLayout>
    <Head>
      <title>Privacy Policy — The Chronicle</title>
    </Head>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">
      <div class="pb-6 border-b border-gray-200 dark:border-zinc-800 mb-8">
        <span class="text-xs font-mono font-bold uppercase tracking-widest text-[#C8102E]">
          LEGAL & DATA PROTECTION
        </span>
        <h1 class="text-3xl sm:text-4xl font-serif font-black text-gray-900 dark:text-white mt-1 mb-2">
          Reader Privacy Policy
        </h1>
        <p class="text-xs text-gray-400">Last updated: November 2026</p>
      </div>

      <div class="prose prose-stone dark:prose-invert max-w-none font-body text-sm sm:text-base leading-relaxed space-y-6">
        <h3>1. Our Core Commitment to Reader Confidentiality</h3>
        <p>
          At <em>The Chronicle</em>, reader privacy is treated as an extension of journalistic freedom. We do not sell your personal data, reading habits, or search histories to commercial data brokers.
        </p>

        <h3>2. Information We Collect</h3>
        <p>
          When you register for an account, subscribe to our newsletters, or sign up for a digital subscription, we collect basic identifiers such as your name, email address, and billing parameters. We process payments through certified external gateways (Stripe and Razorpay) and do not retain complete payment card credentials on our servers.
        </p>

        <h3>3. Cookies and Local Data Storage</h3>
        <p>
          We employ local browser storage and minimal first-party cookies exclusively to remember your reading preferences (such as Dark/Light mode theme and font scaling) and to tally the metered article reading counter.
        </p>

        <h3>4. Your Rights Under Data Protection Regulations</h3>
        <p>
          You retain the sovereign right to inspect, correct, export, or permanently delete your subscriber profile at any juncture by notifying our Data Protection Officer at <span class="font-mono text-[#C8102E]">privacy@chronicle.news</span>.
        </p>
      </div>
    </div>
  </MainLayout>
</template>
