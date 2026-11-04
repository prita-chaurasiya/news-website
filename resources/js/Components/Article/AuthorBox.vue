<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { CheckCircle2, Mail, UserPlus, Check } from 'lucide-vue-next';

const props = defineProps({
  author: {
    type: Object,
    required: true,
  },
});

const { locale } = useI18n();
const isFollowing = ref(false);

const name = computed(() => {
  if (locale.value === 'hi' && props.author.name_hi) {
    return props.author.name_hi;
  }
  return props.author.name;
});

const role = computed(() => {
  if (locale.value === 'hi' && props.author.role_title_hi) {
    return props.author.role_title_hi;
  }
  return props.author.role_title || 'Contributing Editor';
});

const bio = computed(() => {
  if (locale.value === 'hi' && props.author.bio_hi) {
    return props.author.bio_hi;
  }
  return props.author.bio;
});

onMounted(() => {
  if (typeof window !== 'undefined' && props.author?.id) {
    isFollowing.value = localStorage.getItem(`thechronicle_follow_${props.author.id}`) === 'true';
  }
});

const toggleFollow = () => {
  isFollowing.value = !isFollowing.value;
  if (typeof window !== 'undefined' && props.author?.id) {
    localStorage.setItem(`thechronicle_follow_${props.author.id}`, isFollowing.value ? 'true' : 'false');
  }
};
</script>

<template>
  <div class="my-8 p-5 sm:p-6 bg-surface dark:bg-zinc-900/90 rounded-xl border border-border dark:border-zinc-800 shadow-sm flex flex-col sm:flex-row items-start gap-4">
    <Link
      v-if="author.slug"
      :href="`/author/${author.slug}`"
      class="group/avatar flex-shrink-0"
    >
      <img
        v-if="author.avatar"
        :src="author.avatar"
        :alt="name"
        class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover ring-2 ring-[#C8102E] shadow-sm transition-transform duration-300 group-hover/avatar:scale-105"
      />
    </Link>

    <div class="flex-1 min-w-0">
      <div class="flex flex-wrap items-center justify-between gap-3 mb-1">
        <div>
          <div class="flex items-center gap-1.5">
            <Link
              v-if="author.slug"
              :href="`/author/${author.slug}`"
              class="text-base sm:text-lg font-serif font-black text-ink dark:text-white hover:text-accent transition-colors"
            >
              {{ name }}
            </Link>
            <span v-else class="text-base sm:text-lg font-serif font-black text-ink dark:text-white">
              {{ name }}
            </span>
            <CheckCircle2 class="w-4 h-4 text-[#C8102E] fill-current" />
          </div>
          <p class="text-xs font-semibold text-[#C8102E] uppercase tracking-wider font-mono">
            {{ role }}
          </p>
        </div>

        <!-- Follow Button & Handles -->
        <div class="flex items-center gap-2.5">
          <button
            @click="toggleFollow"
            type="button"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold transition-all shadow-xs"
            :class="isFollowing
              ? 'bg-zinc-200 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 hover:bg-zinc-300'
              : 'bg-[#C8102E] hover:bg-[#A00D24] text-white'"
          >
            <component :is="isFollowing ? Check : UserPlus" class="w-3.5 h-3.5" />
            <span>{{ isFollowing ? 'Following' : 'Follow' }}</span>
          </button>

          <a
            v-if="author.twitter_handle"
            :href="`https://twitter.com/${author.twitter_handle.replace('@', '')}`"
            target="_blank"
            rel="noopener noreferrer"
            class="text-muted hover:text-ink text-xs font-mono hidden sm:inline"
          >
            {{ author.twitter_handle }}
          </a>
          <a
            v-if="author.email"
            :href="`mailto:${author.email}`"
            class="p-1.5 rounded-full text-muted hover:text-accent hover:bg-black/5 transition-colors"
            title="Email author"
          >
            <Mail class="w-3.5 h-3.5" />
          </a>
        </div>
      </div>

      <p v-if="bio" class="text-xs sm:text-sm text-gray-700 dark:text-zinc-300 font-serif leading-relaxed mt-2.5">
        {{ bio }}
      </p>

      <div v-if="author.slug" class="mt-3 pt-2.5 border-t border-border/60 flex items-center justify-between text-xs">
        <Link
          :href="`/author/${author.slug}`"
          class="font-semibold text-accent hover:underline flex items-center gap-1 text-[11px] uppercase tracking-wider font-mono"
        >
          View Full Portfolio & Articles →
        </Link>
      </div>
    </div>
  </div>
</template>
