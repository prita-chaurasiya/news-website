<script setup>
defineProps({
  variant: {
    type: String,
    default: 'hairline', // 'hairline', 'double', 'bold', 'accent', 'dots'
  },
  margin: {
    type: String,
    default: 'my-6 sm:my-8',
  },
});
</script>

<template>
  <!-- 1. Double Rule under Masthead / Sections -->
  <div
    v-if="variant === 'double'"
    :class="[margin, 'masthead-double-rule w-full']"
    role="separator"
    aria-hidden="true"
  ></div>

  <!-- 2. Bold 2px Ink Divider -->
  <div
    v-else-if="variant === 'bold'"
    :class="[margin, 'w-full border-b-2 border-ink']"
    role="separator"
    aria-hidden="true"
  ></div>

  <!-- 3. Red Accent Divider -->
  <div
    v-else-if="variant === 'accent'"
    :class="[margin, 'w-full border-b-2 border-accent']"
    role="separator"
    aria-hidden="true"
  ></div>

  <!-- 4. Subtle Dots / Ornament -->
  <div
    v-else-if="variant === 'dots'"
    :class="[margin, 'flex items-center justify-center gap-3 text-muted text-xs tracking-widest']"
    role="separator"
    aria-hidden="true"
  >
    <span>•</span>
    <span>•</span>
    <span>•</span>
  </div>

  <!-- 5. Default 1px Hairline Rule -->
  <div
    v-else
    :class="[margin, 'w-full hairline-rule']"
    role="separator"
    aria-hidden="true"
  ></div>
</template>

