<script setup lang="ts">
defineProps<{
    variant?: 'grid' | 'glow' | 'both';
}>();
</script>

<template>
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div
            v-if="variant === 'grid' || variant === 'both'"
            class="marketing-grid-bg absolute inset-0 opacity-40"
        />
        <div
            v-if="variant === 'glow' || variant === 'both'"
            class="absolute -top-24 right-0 size-[28rem] rounded-full bg-brand-accent/15 blur-3xl"
        />
        <div
            v-if="variant === 'glow' || variant === 'both'"
            class="absolute bottom-0 left-0 size-64 rounded-full bg-brand-accent/10 blur-3xl"
        />
    </div>
</template>
