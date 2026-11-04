<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Shield, Award, Users, BookOpen, Globe2, Heart } from 'lucide-vue-next';
</script>

<template>
  <MainLayout>
    <Head>
      <title>About Us — The Chronicle</title>
      <meta name="description" content="The Chronicle is an independent global news publication dedicated to fearless investigative reporting and public interest journalism." />
    </Head>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">
      <!-- Header -->
      <div class="text-center pb-8 border-b border-gray-200 dark:border-zinc-800 mb-8">
        <span class="text-xs font-bold uppercase tracking-widest text-[#C8102E] font-mono">
          FOUNDED 2026 • NEW DELHI
        </span>
        <h1 class="text-3xl sm:text-5xl font-serif font-black text-gray-900 dark:text-white mt-2 mb-4">
          Independent Journalism.<br />Uncompromising Truth.
        </h1>
        <p class="text-base sm:text-lg text-gray-600 dark:text-zinc-300 font-serif italic max-w-2xl mx-auto">
          "The newspaper is not merely a recorder of events; it is the constitutional conscience of a democratic republic."
        </p>
      </div>

      <!-- Core Philosophy -->
      <div class="prose prose-stone dark:prose-invert max-w-none font-body text-base sm:text-lg leading-relaxed space-y-6 mb-12">
        <p class="lead">
          <strong>The Chronicle</strong> was established in 2026 with a singularly focused mission: to rebuild trust in Indian and global journalism through fearless, evidence-based, on-the-ground investigations.
        </p>
        <p>
          In a media ecosystem increasingly driven by sensationalist television shouting matches and opaque algorithmic feed incentives, we believe that democratic citizens deserve sober analysis, verifiable primary documentation, and prose written with intellectual care.
        </p>
      </div>

      <!-- Pillar Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="p-6 bg-white dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800 shadow-sm">
          <div class="w-10 h-10 rounded-full bg-red-50 dark:bg-red-950/60 text-[#C8102E] flex items-center justify-center mb-3">
            <Shield class="w-5 h-5" />
          </div>
          <h3 class="text-base font-serif font-bold text-gray-900 dark:text-white mb-2">
            No Corporate Ownership
          </h3>
          <p class="text-xs text-gray-600 dark:text-zinc-400 leading-relaxed font-body">
            We are funded exclusively by readers, subscribers, and transparent philanthropic trusts. No industrial conglomerate dictates our editorial line.
          </p>
        </div>

        <div class="p-6 bg-white dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800 shadow-sm">
          <div class="w-10 h-10 rounded-full bg-red-50 dark:bg-red-950/60 text-[#C8102E] flex items-center justify-center mb-3">
            <Globe2 class="w-5 h-5" />
          </div>
          <h3 class="text-base font-serif font-bold text-gray-900 dark:text-white mb-2">
            Ground-Truth Reporting
          </h3>
          <p class="text-xs text-gray-600 dark:text-zinc-400 leading-relaxed font-body">
            Over 60% of our editorial budget is allocated directly to field travel, rural reporting, and regional bureau coverage across all states.
          </p>
        </div>

        <div class="p-6 bg-white dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800 shadow-sm">
          <div class="w-10 h-10 rounded-full bg-red-50 dark:bg-red-950/60 text-[#C8102E] flex items-center justify-center mb-3">
            <Award class="w-5 h-5" />
          </div>
          <h3 class="text-base font-serif font-bold text-gray-900 dark:text-white mb-2">
            Rigorous Fact Verification
          </h3>
          <p class="text-xs text-gray-600 dark:text-zinc-400 leading-relaxed font-body">
            Every investigation undergoes dual-source verification and independent legal vetting before publication to uphold the highest standard of accuracy.
          </p>
        </div>
      </div>

      <!-- Bureau Addresses -->
      <div class="p-6 sm:p-8 bg-stone-100 dark:bg-zinc-900 rounded-lg border border-stone-200 dark:border-zinc-800">
        <h3 class="text-sm font-bold uppercase tracking-widest text-[#C8102E] mb-4">
          Principal Editorial Bureaus
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs text-gray-700 dark:text-zinc-300">
          <div>
            <h4 class="font-bold text-gray-900 dark:text-white mb-1">New Delhi National Bureau</h4>
            <p>Chronicle House, 14 Bahadur Shah Zafar Marg</p>
            <p>New Delhi 110002, India</p>
            <p class="mt-1 font-mono text-gray-500">editorial@chronicle.news</p>
          </div>
          <div>
            <h4 class="font-bold text-gray-900 dark:text-white mb-1">Mumbai Financial Bureau</h4>
            <p>Nariman Point Commercial Tower, 8th Floor</p>
            <p>Mumbai 400021, Maharashtra</p>
            <p class="mt-1 font-mono text-gray-500">markets@chronicle.news</p>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>
