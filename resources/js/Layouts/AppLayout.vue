<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import PortalLayout from '@/Layouts/PortalLayout.vue';

const props = defineProps({
  breakingNews: {
    type: Array,
    default: () => [],
  },
});

const page = usePage();
const activeTheme = computed(() => page.props.theme || 'editorial');
</script>

<template>
  <PortalLayout v-if="activeTheme === 'portal'" :breaking-news="breakingNews">
    <slot />
  </PortalLayout>
  <MainLayout v-else>
    <slot />
  </MainLayout>
</template>

