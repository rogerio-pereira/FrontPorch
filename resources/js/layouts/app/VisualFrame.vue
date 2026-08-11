<script setup lang="ts">
import { cn } from '@/lib/utils';

defineProps<{
    src: string;
    alt: string;
    aspect?: 'video' | 'square' | 'portrait';
    class?: string;
}>();
</script>

<template>
    <div
        :class="cn(
            'group relative overflow-hidden rounded-xl border border-brand-accent/25 bg-surface-raised shadow-[0_0_60px_rgba(114,136,123,0.12)]',
            aspect === 'square' && 'aspect-square',
            aspect === 'portrait' && 'aspect-[4/5]',
            aspect === 'video' && 'aspect-video',
            $props.class,
        )"
    >
        <div class="absolute inset-0 bg-gradient-to-t from-brand-bg/80 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100" />
        <img
            :src="src"
            :alt="alt"
            loading="lazy"
            class="size-full object-cover transition-transform duration-500 group-hover:scale-[1.03]"
        />
    </div>
</template>
