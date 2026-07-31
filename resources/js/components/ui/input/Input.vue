<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { onMounted, ref, useAttrs } from "vue"
import { cn } from "@/lib/utils"

defineOptions({
  inheritAttrs: false,
})

const props = defineProps<{
  defaultValue?: string | number
  class?: HTMLAttributes["class"]
}>()

const attrs = useAttrs()
const inputRef = ref<HTMLInputElement | null>(null)

onMounted(() => {
  if (inputRef.value === null) {
    return
  }

  if (props.defaultValue === undefined || props.defaultValue === null) {
    return
  }

  if (inputRef.value.value !== "") {
    return
  }

  inputRef.value.value = String(props.defaultValue)
})
</script>

<template>
  <!--
    Uncontrolled on purpose: Inertia <Form> reads native name/value.
    A v-model / :value binding would reset typed values when `processing`
    re-renders the form (and flaky Pest Browser fills).
  -->
  <input
    ref="inputRef"
    v-bind="attrs"
    data-slot="input"
    :class="cn(
      'file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 border-input h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm',
      'focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]',
      'aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive',
      props.class,
    )"
    :defaultValue="props.defaultValue"
  >
</template>
