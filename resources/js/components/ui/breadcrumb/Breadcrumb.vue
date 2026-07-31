<script lang="ts" setup>
import type { HTMLAttributes } from "vue"

const props = defineProps<{
  class?: HTMLAttributes["class"]
}>()
</script>

<template>
  <nav
    aria-label="breadcrumb"
    data-slot="breadcrumb"
    data-test="admin-breadcrumbs"
    :class="props.class"
  >
    <slot />
  </nav>
</template>
