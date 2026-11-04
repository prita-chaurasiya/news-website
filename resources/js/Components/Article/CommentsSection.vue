<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { usePage, router } from '@inertiajs/vue3';
import axios from 'axios';
import { MessageSquare, ThumbsUp, CornerDownRight, Send, Check } from 'lucide-vue-next';

const props = defineProps({
  articleId: {
    type: Number,
    required: true,
  },
  comments: {
    type: Array,
    default: () => [],
  },
});

const { t } = useI18n();
const page = usePage();

const newComment = ref({
  author_name: page.props.auth?.user?.name || '',
  author_email: page.props.auth?.user?.email || '',
  content: '',
});

const replyingTo = ref(null);
const replyContent = ref('');
const isSubmitting = ref(false);
const submittedSuccess = ref(false);
const likesMap = ref({});

const submitComment = () => {
  if (!newComment.value.content.trim()) return;

  isSubmitting.value = true;
  router.post(`/article/${props.articleId}/comments`, {
    author_name: newComment.value.author_name || 'Reader',
    author_email: newComment.value.author_email || null,
    content: newComment.value.content,
  }, {
    preserveScroll: true,
    onSuccess: () => {
      newComment.value.content = '';
      submittedSuccess.value = true;
      isSubmitting.value = false;
      setTimeout(() => {
        submittedSuccess.value = false;
      }, 4000);
    },
    onError: () => {
      isSubmitting.value = false;
    },
  });
};

const submitReply = (parentId) => {
  if (!replyContent.value.trim()) return;

  isSubmitting.value = true;
  router.post(`/article/${props.articleId}/comments`, {
    parent_id: parentId,
    author_name: page.props.auth?.user?.name || 'Reader',
    content: replyContent.value,
  }, {
    preserveScroll: true,
    onSuccess: () => {
      replyContent.value = '';
      replyingTo.value = null;
      isSubmitting.value = false;
    },
    onError: () => {
      isSubmitting.value = false;
    },
  });
};

const likeComment = async (comment) => {
  try {
    const response = await axios.post(`/comments/${comment.id}/like`);
    if (response.data && response.data.likes_count !== undefined) {
      comment.likes_count = response.data.likes_count;
      likesMap.value[comment.id] = true;
    }
  } catch (err) {
    console.error('Failed to like comment:', err);
  }
};
</script>

<template>
  <section class="my-10 pt-8 border-t-2 border-gray-900 dark:border-gray-100">
    <div class="flex items-center justify-between pb-3 mb-6 border-b border-gray-100 dark:border-zinc-800">
      <div class="flex items-center gap-2">
        <MessageSquare class="w-4 h-4 text-[#C8102E]" />
        <h3 class="text-xs font-bold uppercase tracking-widest text-gray-900 dark:text-gray-100">
          {{ $t('article.comments') }} ({{ comments.length }})
        </h3>
      </div>
    </div>

    <!-- Post Comment Form -->
    <div class="p-5 sm:p-6 bg-white dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-800 mb-8 shadow-sm">
      <h4 class="text-sm font-serif font-bold text-gray-900 dark:text-white mb-3">
        {{ $t('article.leaveComment') }}
      </h4>

      <div v-if="submittedSuccess" class="mb-4 p-3 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-500 text-emerald-700 dark:text-emerald-300 rounded text-xs flex items-center gap-2">
        <Check class="w-4 h-4 text-emerald-500" />
        <span>Your perspective has been shared with our readers.</span>
      </div>

      <form @submit.prevent="submitComment" class="space-y-3">
        <div v-if="!$page.props.auth?.user" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <input
            v-model="newComment.author_name"
            type="text"
            required
            :placeholder="$t('article.namePlaceholder')"
            class="px-3 py-2 rounded bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 text-xs focus:outline-none focus:border-[#C8102E]"
          />
          <input
            v-model="newComment.author_email"
            type="email"
            :placeholder="$t('article.emailPlaceholder')"
            class="px-3 py-2 rounded bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 text-xs focus:outline-none focus:border-[#C8102E]"
          />
        </div>

        <textarea
          v-model="newComment.content"
          rows="3"
          required
          :placeholder="$t('article.commentPlaceholder')"
          class="w-full px-3 py-2 rounded bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 text-xs sm:text-sm focus:outline-none focus:border-[#C8102E]"
        ></textarea>

        <div class="flex justify-end">
          <button
            type="submit"
            :disabled="isSubmitting"
            class="inline-flex items-center gap-1.5 bg-[#C8102E] hover:bg-[#A00D24] text-white font-bold text-xs uppercase tracking-wider px-5 py-2.5 rounded transition-colors shadow disabled:opacity-50"
          >
            <Send class="w-3.5 h-3.5" />
            <span>{{ isSubmitting ? 'Posting...' : $t('article.postComment') }}</span>
          </button>
        </div>
      </form>
    </div>

    <!-- Comments List -->
    <div class="space-y-6">
      <div
        v-for="comment in comments"
        :key="comment.id"
        class="p-4 sm:p-5 bg-white dark:bg-zinc-900 rounded-lg border border-gray-100 dark:border-zinc-800/80 shadow-sm"
      >
        <!-- Author & Date -->
        <div class="flex items-center justify-between mb-2">
          <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full bg-stone-200 dark:bg-zinc-700 flex items-center justify-center text-xs font-bold font-mono">
              {{ comment.author_name ? comment.author_name.charAt(0).toUpperCase() : 'R' }}
            </div>
            <div>
              <span class="text-xs font-bold text-gray-900 dark:text-gray-100 block leading-tight">
                {{ comment.author_name }}
              </span>
              <span class="text-[10px] text-gray-400">
                Verified Reader
              </span>
            </div>
          </div>

          <span class="text-[11px] text-gray-400 font-mono">
            {{ new Date(comment.created_at).toLocaleDateString() }}
          </span>
        </div>

        <!-- Content -->
        <p class="text-xs sm:text-sm text-gray-700 dark:text-zinc-300 font-body leading-relaxed mb-3">
          {{ comment.content }}
        </p>

        <!-- Actions: Like & Reply -->
        <div class="flex items-center gap-4 text-xs text-gray-500 pt-2 border-t border-gray-50 dark:border-zinc-800">
          <button
            @click="likeComment(comment)"
            class="flex items-center gap-1 hover:text-[#C8102E] transition-colors"
            :class="{ 'text-[#C8102E] font-bold': likesMap[comment.id] }"
          >
            <ThumbsUp class="w-3.5 h-3.5" :class="{ 'fill-current': likesMap[comment.id] }" />
            <span>{{ comment.likes_count || 0 }} {{ $t('article.likes') }}</span>
          </button>

          <button
            @click="replyingTo = (replyingTo === comment.id ? null : comment.id)"
            class="flex items-center gap-1 hover:text-[#C8102E] transition-colors"
          >
            <CornerDownRight class="w-3.5 h-3.5" />
            <span>{{ $t('article.reply') }}</span>
          </button>
        </div>

        <!-- Inline Reply Form -->
        <div v-if="replyingTo === comment.id" class="mt-3 pl-4 border-l-2 border-[#C8102E] pt-2">
          <textarea
            v-model="replyContent"
            rows="2"
            placeholder="Write your reply..."
            class="w-full px-3 py-1.5 rounded bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 text-xs focus:outline-none focus:border-[#C8102E]"
          ></textarea>
          <div class="flex justify-end gap-2 mt-2">
            <button
              @click="replyingTo = null"
              class="px-3 py-1 text-xs text-gray-400 hover:text-gray-600"
            >
              Cancel
            </button>
            <button
              @click="submitReply(comment.id)"
              :disabled="isSubmitting"
              class="bg-[#C8102E] text-white text-xs font-bold px-4 py-1 rounded"
            >
              Submit Reply
            </button>
          </div>
        </div>

        <!-- Nested Replies -->
        <div v-if="comment.replies && comment.replies.length > 0" class="mt-4 pl-4 sm:pl-6 border-l-2 border-gray-200 dark:border-zinc-800 space-y-3">
          <div
            v-for="reply in comment.replies"
            :key="reply.id"
            class="p-3 bg-gray-50 dark:bg-zinc-800/50 rounded text-xs"
          >
            <div class="flex items-center justify-between mb-1">
              <span class="font-bold text-gray-900 dark:text-zinc-200">{{ reply.author_name }}</span>
              <span class="text-[10px] text-gray-400 font-mono">{{ new Date(reply.created_at).toLocaleDateString() }}</span>
            </div>
            <p class="text-gray-700 dark:text-zinc-300 font-body">{{ reply.content }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

