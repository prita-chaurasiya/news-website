<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Megaphone, Users, Award, TrendingUp, Mail, Download } from 'lucide-vue-next';
</script>

<template>
  <MainLayout>
    <Head>
      <title>Advertise With Us — The Chronicle</title>
      <meta name="description" content="Reach an influential audience of policymakers, business leaders, academics, and engaged citizens on The Chronicle." />
    </Head>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-10">
      <!-- Hero -->
      <div class="text-center pb-8 border-b border-gray-200 dark:border-zinc-800 mb-10">
        <span class="text-xs font-mono font-bold uppercase tracking-widest text-[#C8102E]">
          COMMERCIAL MEDIA SOLUTIONS
        </span>
        <h1 class="text-3xl sm:text-5xl font-serif font-black text-gray-900 dark:text-white mt-2 mb-4">
          Engage High-Intent Decision Makers
        </h1>
        <p class="text-sm sm:text-base text-gray-600 dark:text-zinc-300 font-body max-w-2xl mx-auto leading-relaxed">
          The Chronicle reaches an influential readership spanning senior corporate executives, government policymakers, researchers, and discerning urban citizens.
        </p>
      </div>

      <!-- Key Demographic Stats -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
        <div class="p-5 bg-white dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800 text-center shadow-sm">
          <div class="text-3xl sm:text-4xl font-serif font-black text-[#C8102E] mb-1">4.2M</div>
          <div class="text-xs uppercase tracking-wider font-bold text-gray-500">Monthly Pageviews</div>
        </div>

        <div class="p-5 bg-white dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800 text-center shadow-sm">
          <div class="text-3xl sm:text-4xl font-serif font-black text-[#C8102E] mb-1">74%</div>
          <div class="text-xs uppercase tracking-wider font-bold text-gray-500">College Educated</div>
        </div>

        <div class="p-5 bg-white dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800 text-center shadow-sm">
          <div class="text-3xl sm:text-4xl font-serif font-black text-[#C8102E] mb-1">4.8m</div>
          <div class="text-xs uppercase tracking-wider font-bold text-gray-500">Avg. Session Time</div>
        </div>

        <div class="p-5 bg-white dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800 text-center shadow-sm">
          <div class="text-3xl sm:text-4xl font-serif font-black text-[#C8102E] mb-1">180K+</div>
          <div class="text-xs uppercase tracking-wider font-bold text-gray-500">Newsletter Subscribers</div>
        </div>
      </div>

      <!-- High-Impact Ad Placements -->
      <h2 class="text-xl font-serif font-bold text-gray-900 dark:text-white mb-6">
        Curated Brand Formats
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="p-6 bg-white dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800">
          <span class="text-[10px] font-bold uppercase tracking-wider text-[#C8102E] block mb-2 font-mono">Format 01</span>
          <h3 class="text-base font-serif font-bold mb-2 text-gray-900 dark:text-white">Header Leaderboard</h3>
          <p class="text-xs text-gray-600 dark:text-zinc-400 font-body mb-4 leading-relaxed">
            Premium position spanning the full viewport top on both desktop and mobile, ensuring 100% viewability on first impression.
          </p>
          <span class="text-xs font-mono font-bold text-gray-500">CPM: ₹350 - ₹450</span>
        </div>

        <div class="p-6 bg-white dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800">
          <span class="text-[10px] font-bold uppercase tracking-wider text-[#C8102E] block mb-2 font-mono">Format 02</span>
          <h3 class="text-base font-serif font-bold mb-2 text-gray-900 dark:text-white">In-Article Native Cards</h3>
          <p class="text-xs text-gray-600 dark:text-zinc-400 font-body mb-4 leading-relaxed">
            Cleanly styled native brand insertions placed organically within editorial reporting without intrusive overlay barriers.
          </p>
          <span class="text-xs font-mono font-bold text-gray-500">CPM: ₹280 - ₹380</span>
        </div>

        <div class="p-6 bg-white dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800">
          <span class="text-[10px] font-bold uppercase tracking-wider text-[#C8102E] block mb-2 font-mono">Format 03</span>
          <h3 class="text-base font-serif font-bold mb-2 text-gray-900 dark:text-white">Evening Briefing Sponsor</h3>
          <p class="text-xs text-gray-600 dark:text-zinc-400 font-body mb-4 leading-relaxed">
            Exclusive single-sponsor branding on our daily flagship newsletter delivered to 180,000 verified executive inboxes.
          </p>
          <span class="text-xs font-mono font-bold text-gray-500">Rate: ₹75,000 / send</span>
        </div>
      </div>

      <!-- Sales Contact Card -->
      <div class="p-8 bg-zinc-950 text-white rounded-xl flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
          <h3 class="text-xl font-serif font-bold mb-1">Request the 2026 Media Kit</h3>
          <p class="text-xs text-zinc-400 max-w-lg">
            Download our comprehensive rate card and programmatic specification guidelines or consult with our partnership team.
          </p>
        </div>

        <div class="flex items-center gap-3">
          <Link
            href="/contact"
            class="bg-[#C8102E] hover:bg-[#A00D24] text-white text-xs font-bold uppercase tracking-wider px-6 py-3.5 rounded transition-colors"
          >
            Contact Sales Team
          </Link>
        </div>
      </div>
    </div>
  </MainLayout>
</template>
