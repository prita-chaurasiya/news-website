<script setup>
import { ref, computed } from 'vue';
import { useNewsStore } from '@/stores/newsStore';
import { Lock, Check, ShieldCheck, X, Sparkles } from 'lucide-vue-next';

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false,
  },
  readCount: {
    type: Number,
    default: 3,
  },
});

const emit = defineEmits(['close', 'subscribed']);

const newsStore = useNewsStore();
const selectedPlan = ref('annual');
const subscribedSuccess = ref(false);

const simulateSubscribe = () => {
  subscribedSuccess.value = true;
  setTimeout(() => {
    newsStore.resetReadingMeter();
    emit('subscribed');
    emit('close');
  }, 1200);
};
</script>

<template>
  <Teleport to="body">
    <div
      v-if="isOpen"
      class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto"
      @click.self="$emit('close')"
    >
      <div class="relative w-full max-w-xl bg-white dark:bg-zinc-900 rounded-xl shadow-2xl border border-gray-200 dark:border-zinc-800 p-6 sm:p-8 text-center my-8">
        <!-- Close Button -->
        <button
          @click="$emit('close')"
          class="absolute top-4 right-4 p-1.5 rounded-full text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-zinc-800 transition-colors"
        >
          <X class="w-5 h-5" />
        </button>

        <!-- Lock Icon Header -->
        <div class="w-12 h-12 rounded-full bg-red-50 dark:bg-red-950/50 text-[#C8102E] mx-auto flex items-center justify-center mb-4">
          <Lock class="w-6 h-6" />
        </div>

        <span class="inline-block text-[11px] font-bold tracking-widest uppercase text-[#C8102E] bg-red-50 dark:bg-red-950/50 px-2.5 py-0.5 rounded mb-2">
          Metered Access • {{ readCount }} of 3 Free Articles Read
        </span>

        <h3 class="text-2xl sm:text-3xl font-serif font-black text-gray-900 dark:text-white mb-2">
          Read Fearless, Independent Journalism Without Limits
        </h3>

        <p class="text-xs sm:text-sm text-gray-600 dark:text-zinc-300 font-body mb-6 max-w-md mx-auto">
          We do not take corporate grants or political favors. Your subscription directly funds investigative field reporting across the nation.
        </p>

        <!-- Subscription Tier Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-left">
          <!-- Monthly -->
          <div
            @click="selectedPlan = 'monthly'"
            class="p-4 rounded-lg border-2 cursor-pointer transition-all"
            :class="selectedPlan === 'monthly'
              ? 'border-[#C8102E] bg-red-50/20 dark:bg-red-950/20'
              : 'border-gray-200 dark:border-zinc-800 hover:border-gray-300'"
          >
            <div class="flex justify-between items-center mb-1">
              <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Monthly</span>
              <span class="w-3.5 h-3.5 rounded-full border-2 border-[#C8102E] flex items-center justify-center" v-if="selectedPlan === 'monthly'">
                <span class="w-1.5 h-1.5 bg-[#C8102E] rounded-full"></span>
              </span>
            </div>
            <div class="text-2xl font-serif font-bold text-gray-900 dark:text-white">₹299<span class="text-xs font-sans text-gray-400 font-normal">/mo</span></div>
            <p class="text-[11px] text-gray-500 mt-1">Billed monthly. Cancel anytime.</p>
          </div>

          <!-- Annual (Recommended) -->
          <div
            @click="selectedPlan = 'annual'"
            class="p-4 rounded-lg border-2 cursor-pointer transition-all relative"
            :class="selectedPlan === 'annual'
              ? 'border-[#C8102E] bg-red-50/20 dark:bg-red-950/20'
              : 'border-gray-200 dark:border-zinc-800 hover:border-gray-300'"
          >
            <span class="absolute -top-2.5 right-3 bg-amber-500 text-black text-[9px] font-black uppercase px-2 py-0.5 rounded shadow">
              SAVE 30% • BEST VALUE
            </span>
            <div class="flex justify-between items-center mb-1">
              <span class="text-xs font-bold uppercase tracking-wider text-[#C8102E]">All-Access Annual</span>
              <span class="w-3.5 h-3.5 rounded-full border-2 border-[#C8102E] flex items-center justify-center" v-if="selectedPlan === 'annual'">
                <span class="w-1.5 h-1.5 bg-[#C8102E] rounded-full"></span>
              </span>
            </div>
            <div class="text-2xl font-serif font-bold text-gray-900 dark:text-white">₹2,499<span class="text-xs font-sans text-gray-400 font-normal">/yr</span></div>
            <p class="text-[11px] text-gray-500 mt-1">Just ₹208/month billed annually.</p>
          </div>
        </div>

        <!-- Features Checklist -->
        <ul class="text-xs text-gray-600 dark:text-zinc-300 space-y-2 mb-6 text-left max-w-md mx-auto">
          <li class="flex items-center gap-2">
            <Check class="w-4 h-4 text-[#C8102E] flex-shrink-0" />
            <span>Unlimited access to all investigations, ground reports & opinions</span>
          </li>
          <li class="flex items-center gap-2">
            <Check class="w-4 h-4 text-[#C8102E] flex-shrink-0" />
            <span>Daily E-Paper broadsheet replica downloaded by 6:00 AM</span>
          </li>
          <li class="flex items-center gap-2">
            <Check class="w-4 h-4 text-[#C8102E] flex-shrink-0" />
            <span>High-fidelity text-to-speech audio edition on every article</span>
          </li>
          <li class="flex items-center gap-2">
            <Check class="w-4 h-4 text-[#C8102E] flex-shrink-0" />
            <span>Clean, ad-light reading experience on all devices</span>
          </li>
        </ul>

        <!-- Action Button -->
        <button
          @click="simulateSubscribe"
          :disabled="subscribedSuccess"
          class="w-full bg-[#C8102E] hover:bg-[#A00D24] text-white font-bold text-xs uppercase tracking-wider py-3.5 rounded transition-colors shadow-lg flex items-center justify-center gap-2"
        >
          <Sparkles class="w-4 h-4" />
          <span>{{ subscribedSuccess ? 'Activating Unlimited Pass...' : 'Subscribe Now (Demo 1-Click Access)' }}</span>
        </button>

        <p class="text-[11px] text-gray-400 mt-3">
          Tax included. 14-day money-back guarantee.
        </p>
      </div>
    </div>
  </Teleport>
</template>

