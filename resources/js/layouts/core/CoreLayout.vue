<script setup lang="ts">
import CoreSidebarLayout from '@/layouts/core/CoreSidebarLayout.vue';
import type { BreadcrumbItem } from '@/types';

const { breadcrumbs = [] } = defineProps<{
    breadcrumbs?: BreadcrumbItem[];
}>();
</script>

<template>
    <CoreSidebarLayout :breadcrumbs="breadcrumbs">
        <slot />
    </CoreSidebarLayout>
</template>
