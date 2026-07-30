<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';

defineProps<{
    title: string;
    description: string;
    backHref: string;
}>();
</script>

<template>
    <div class="flex h-full flex-1 flex-col gap-6 p-4">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <Heading :title="title" :description="description" />
            <Link
                :href="backHref"
                class="text-sm font-medium text-muted-foreground hover:underline"
                data-test="core-form-back"
            >
                Back to list
            </Link>
        </div>

        <div class="w-full rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border">
            <slot />
        </div>
    </div>
</template>
