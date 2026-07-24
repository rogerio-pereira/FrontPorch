<script setup lang="ts">
import { computed } from 'vue';
import type { Component } from 'vue';

const props = defineProps<{
    icon: Component;
    label?: string;
    size?: 'sm' | 'md' | 'lg';
}>();

const sizeClass = computed(() => {
    if (props.size === 'sm') {
        return 'size-10 [&_svg]:size-4';
    }

    if (props.size === 'lg') {
        return 'size-14 [&_svg]:size-7';
    }

    return 'size-12 [&_svg]:size-5';
});
</script>

<template>
    <div class="flex flex-col items-center gap-2 text-center">
        <div
            :class="[
                sizeClass,
                'flex items-center justify-center rounded-xl border border-brand-accent/30 bg-brand-accent/10 text-brand-accent shadow-[0_0_30px_rgba(114,136,123,0.12)]',
            ]"
        >
            <component :is="icon" />
        </div>
        <span
            v-if="label"
            class="text-xs font-medium text-[var(--text-muted-on-dark)]"
        >
            {{ label }}
        </span>
    </div>
</template>
