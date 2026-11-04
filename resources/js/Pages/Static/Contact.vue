<script setup>
import { ref } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Mail, Phone, MapPin, Send, CheckCircle2, ShieldAlert } from 'lucide-vue-next';

const page = usePage();

const form = useForm({
  name: '',
  email: '',
  department: 'editorial',
  subject: '',
  message: '',
});

const submitForm = () => {
  form.post('/contact', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>

<template>
  <MainLayout>
    <Head>
      <title>Contact the Editorial Bureau — The Chronicle</title>
      <meta name="description" content="Get in touch with editors, reporters, corrections, and advertising desks at The Chronicle." />
    </Head>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-10">
      <div class="text-center pb-8 border-b border-gray-200 dark:border-zinc-800 mb-8">
        <h1 class="text-3xl sm:text-5xl font-serif font-black text-gray-900 dark:text-white mb-3">
          Contact The Chronicle
        </h1>
        <p class="text-sm sm:text-base text-gray-600 dark:text-zinc-400 font-body max-w-xl mx-auto">
          We welcome news tips, ground dispatches, corrections, syndication inquiries, and reader feedback.
        </p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Contact Form (7 cols) -->
        <div class="lg:col-span-7 bg-white dark:bg-zinc-900 p-6 sm:p-8 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm">
          <h2 class="text-lg font-serif font-bold text-gray-900 dark:text-white mb-4">
            Send an Editorial Dispatch
          </h2>

          <div
            v-if="page.props.flash?.success"
            class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-500 rounded text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm flex items-start gap-3"
          >
            <CheckCircle2 class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" />
            <div>{{ page.props.flash.success }}</div>
          </div>

          <form @submit.prevent="submitForm" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-zinc-300 mb-1.5">
                  Your Full Name *
                </label>
                <input
                  v-model="form.name"
                  type="text"
                  required
                  placeholder="e.g. Anand K. Varma"
                  class="w-full px-3.5 py-2.5 rounded bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 text-xs sm:text-sm focus:outline-none focus:border-[#C8102E]"
                />
              </div>

              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-zinc-300 mb-1.5">
                  Email Address *
                </label>
                <input
                  v-model="form.email"
                  type="email"
                  required
                  placeholder="e.g. anand@domain.com"
                  class="w-full px-3.5 py-2.5 rounded bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 text-xs sm:text-sm focus:outline-none focus:border-[#C8102E]"
                />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-zinc-300 mb-1.5">
                  Department *
                </label>
                <select
                  v-model="form.department"
                  required
                  class="w-full px-3.5 py-2.5 rounded bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 text-xs sm:text-sm focus:outline-none focus:border-[#C8102E]"
                >
                  <option value="editorial">Editorial & Reporting</option>
                  <option value="advertising">Advertising & Partnerships</option>
                  <option value="corrections">Corrections & Fact-Checking</option>
                  <option value="general">Subscriptions & Reader Support</option>
                </select>
              </div>

              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-zinc-300 mb-1.5">
                  Subject *
                </label>
                <input
                  v-model="form.subject"
                  type="text"
                  required
                  placeholder="Brief summary of inquiry"
                  class="w-full px-3.5 py-2.5 rounded bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 text-xs sm:text-sm focus:outline-none focus:border-[#C8102E]"
                />
              </div>
            </div>

            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-zinc-300 mb-1.5">
                Detailed Message / Tip *
              </label>
              <textarea
                v-model="form.message"
                rows="5"
                required
                placeholder="Include relevant dates, locations, public links, or background context..."
                class="w-full px-3.5 py-2.5 rounded bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 text-xs sm:text-sm focus:outline-none focus:border-[#C8102E]"
              ></textarea>
            </div>

            <button
              type="submit"
              :disabled="form.processing"
              class="w-full bg-[#C8102E] hover:bg-[#A00D24] text-white font-bold text-xs uppercase tracking-wider py-3.5 rounded transition-colors shadow flex items-center justify-center gap-2 disabled:opacity-50"
            >
              <Send class="w-4 h-4" />
              <span>{{ form.processing ? 'Transmitting Dispatch...' : 'Submit Message' }}</span>
            </button>
          </form>
        </div>

        <!-- Bureau Direct Lines & Whistleblower Box (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
          <div class="p-6 bg-white dark:bg-zinc-900 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm text-xs space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-widest text-gray-900 dark:text-white pb-2 border-b border-gray-100 dark:border-zinc-800">
              Direct Contact Lines
            </h3>

            <div class="flex items-start gap-3">
              <Mail class="w-4 h-4 text-[#C8102E] flex-shrink-0 mt-0.5" />
              <div>
                <strong class="text-gray-900 dark:text-zinc-100">Editorial Queries:</strong>
                <p class="font-mono text-gray-500">editorial@chronicle.news</p>
              </div>
            </div>

            <div class="flex items-start gap-3">
              <Phone class="w-4 h-4 text-[#C8102E] flex-shrink-0 mt-0.5" />
              <div>
                <strong class="text-gray-900 dark:text-zinc-100">Telephone Switchboard:</strong>
                <p class="font-mono text-gray-500">+91 (11) 4567 8900 / 8901</p>
              </div>
            </div>

            <div class="flex items-start gap-3">
              <MapPin class="w-4 h-4 text-[#C8102E] flex-shrink-0 mt-0.5" />
              <div>
                <strong class="text-gray-900 dark:text-zinc-100">National Headquarters:</strong>
                <p class="text-gray-500 leading-relaxed">
                  Chronicle House, 14 Bahadur Shah Zafar Marg,<br />
                  New Delhi 110002, India
                </p>
              </div>
            </div>
          </div>

          <!-- Whistleblower Protection Box -->
          <div class="p-6 bg-stone-900 text-white rounded-xl border border-zinc-800 shadow-sm">
            <div class="flex items-center gap-2 text-amber-400 font-bold text-xs uppercase tracking-wider mb-2">
              <ShieldAlert class="w-4 h-4" />
              <span>Secure Whistleblower Channel</span>
            </div>
            <p class="text-xs text-zinc-300 leading-relaxed mb-3">
              If you hold confidential primary documents concerning public corruption or human rights violations, submit securely via Signal or encrypted PGP mail.
            </p>
            <span class="font-mono text-[11px] text-amber-300 block bg-black/60 p-2 rounded">
              PGP Fingerprint: 4F92 B7A1 88E0 231C D998
            </span>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>
