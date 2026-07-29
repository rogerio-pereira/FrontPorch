<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

export type SitePaginationState = {
    currentPage: number;
    lastPage: number;
    previousPageUrl: string | null;
    nextPageUrl: string | null;
};

defineProps<{
    pagination: SitePaginationState;
    testId: string;
}>();
</script>

<template>
    <nav
        v-if="pagination.lastPage > 1"
        class="mt-10 flex items-center justify-center gap-4 text-sm"
        :data-test="testId"
    >
        <Link
            v-if="pagination.previousPageUrl"
            :href="pagination.previousPageUrl"
            class="font-semibold text-brand-accent hover:underline"
            :data-test="`${testId}-previous`"
        >
            Previous
        </Link>
        <span class="text-[var(--text-muted-on-dark)]">
            Page {{ pagination.currentPage }} of {{ pagination.lastPage }}
        </span>
        <Link
            v-if="pagination.nextPageUrl"
            :href="pagination.nextPageUrl"
            class="font-semibold text-brand-accent hover:underline"
            :data-test="`${testId}-next`"
        >
            Next
        </Link>
    </nav>
</template>
